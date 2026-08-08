<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentRequest;
use App\Models\User;
use App\Models\Setting;
use App\Models\ReferralEarning;

class GatewayController extends Controller
{
    /**
     * Create payment order on AmarGateway.
     */
    public function createOrder(Request $request)
    {
        $request->validate([
            'type' => 'required|in:credit,subscription',
            'package_id' => 'required_if:type,credit|exists:recharge_packages,id',
            'plan' => 'required_if:type,subscription|in:1_month,6_months,1_year',
            'payment_method' => 'required|in:bkash,nagad,rocket,upay',
        ]);

        $merchantKey = Setting::where('key', 'gateway_merchant_key')->value('value');
        if (!$merchantKey) {
            return response()->json(['success' => false, 'message' => 'Gateway is not properly configured.'], 500);
        }

        $amount = 0;
        $credits = 0;
        $plan = null;

        if ($request->type === 'credit') {
            $package = \App\Models\RechargePackage::findOrFail($request->package_id);
            $amount = $package->price;
            $credits = $package->credits;
        } else {
            $plan = $request->plan;
            $prices = [
                '1_month' => 50,
                '6_months' => 250,
                '1_year' => 500
            ];
            $amount = $prices[$plan];
        }

        $orderRef = 'ORDER_' . time() . '_' . rand(1000, 9999);

        // Call AmarGateway API
        try {
            $response = Http::withHeaders([
                'X-Merchant-Key' => $merchantKey,
                'Accept' => 'application/json'
            ])->post('https://amargateway.mrdeveloper.xyz/api/merchant/payment/create', [
                'order_ref' => $orderRef,
                'expected_amount' => $amount,
                'payment_method' => $request->payment_method,
                'customer_name' => Auth::user()->name,
                'customer_phone' => Auth::user()->email,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Record the pending payment request
                PaymentRequest::create([
                    'user_id' => Auth::id(),
                    'amount' => $amount,
                    'credits' => $credits,
                    'request_type' => $request->type,
                    'subscription_plan' => $plan,
                    'payment_method' => $request->payment_method,
                    'sender_number' => 'Auto Gateway',
                    'transaction_id' => 'PENDING',
                    'gateway_order_ref' => $orderRef,
                    'status' => 'pending',
                ]);

                return response()->json([
                    'success' => true,
                    'order_ref' => $orderRef,
                    'pay_info' => $data['pay_info'] ?? [
                        'expected_amount' => $amount,
                        'payment_method' => $request->payment_method
                    ]
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to create gateway order. ' . ($response->json()['message'] ?? '')], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Connection to Gateway failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Check payment status on AmarGateway (manual query verification).
     */
    public function checkStatus(Request $request)
    {
        $request->validate([
            'order_ref' => 'required|string',
        ]);

        $merchantKey = Setting::where('key', 'gateway_merchant_key')->value('value');
        if (!$merchantKey) {
            return response()->json(['success' => false, 'message' => 'Gateway configuration missing.'], 500);
        }

        try {
            $response = Http::withHeaders([
                'X-Merchant-Key' => $merchantKey,
                'Accept' => 'application/json'
            ])->get('https://amargateway.mrdeveloper.xyz/api/merchant/payment/status', [
                'order_ref' => $request->order_ref
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if ($data['status'] === 'verified') {
                    $paymentRequest = PaymentRequest::where('gateway_order_ref', $request->order_ref)->first();
                    if ($paymentRequest && $paymentRequest->status === 'pending') {
                        $this->verifyAndProcessPayment($paymentRequest, $data['transaction_id'] ?? 'GATEWAY_' . time());
                        return response()->json(['success' => true, 'message' => 'Payment verified successfully!']);
                    }
                    return response()->json(['success' => true, 'message' => 'Payment already processed.']);
                }
                return response()->json(['success' => false, 'status' => $data['status'], 'message' => 'Payment is still pending on gateway. Please wait or send money first.']);
            }
            return response()->json(['success' => false, 'message' => 'Gateway status query failed.'], 400);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Connection failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Webhook Callback (IPN) handler.
     */
    public function handleWebhook(Request $request)
    {
        $signature = $request->header('X-Gateway-Signature');
        $payload = $request->all();
        $secret = Setting::where('key', 'gateway_webhook_secret')->value('value') ?? 'webhook_secret_key';

        $calculatedSignature = hash_hmac('sha256', json_encode($payload), $secret);

        if (hash_equals($calculatedSignature, $signature)) {
            if ($payload['status'] === 'verified') {
                $paymentRequest = PaymentRequest::where('gateway_order_ref', $payload['order_ref'])->first();
                if ($paymentRequest && $paymentRequest->status === 'pending') {
                    $this->verifyAndProcessPayment($paymentRequest, $payload['transaction_id'] ?? 'WEBHOOK_' . time());
                }
            }
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid Signature'], 400);
    }

    /**
     * Process verification and apply credits/subscriptions and commission.
     */
    private function verifyAndProcessPayment(PaymentRequest $paymentRequest, $transactionId)
    {
        $paymentRequest->status = 'approved';
        $paymentRequest->transaction_id = $transactionId;
        $paymentRequest->save();

        $user = $paymentRequest->user;

        if ($paymentRequest->request_type === 'subscription') {
            $months = 1;
            if ($paymentRequest->subscription_plan === '6_months') {
                $months = 6;
            } elseif ($paymentRequest->subscription_plan === '1_year') {
                $months = 12;
            }

            $currentExpiry = $user->subscription_expires_at && $user->subscription_expires_at->isFuture()
                ? $user->subscription_expires_at
                : now();

            $user->subscription_expires_at = $currentExpiry->addMonths($months);
            $user->subscription_plan = $paymentRequest->subscription_plan;
            $user->save();

            // Referrer Commission (20%)
            if ($user->referred_by) {
                $referrer = User::find($user->referred_by);
                if ($referrer) {
                    $commission = $paymentRequest->amount * 0.20;
                    $referrer->credits += $commission;
                    $referrer->save();

                    ReferralEarning::create([
                        'referrer_id' => $referrer->id,
                        'referred_user_id' => $user->id,
                        'amount' => $commission,
                        'source_type' => 'Subscription Purchase (' . $paymentRequest->subscription_plan . ')',
                    ]);
                }
            }
        } else {
            // Add credits
            $user->credits += $paymentRequest->credits;
            $user->save();

            // Referrer Commission (10%)
            if ($user->referred_by) {
                $referrer = User::find($user->referred_by);
                if ($referrer) {
                    $commission = $paymentRequest->credits * 0.10;
                    $referrer->credits += $commission;
                    $referrer->save();

                    ReferralEarning::create([
                        'referrer_id' => $referrer->id,
                        'referred_user_id' => $user->id,
                        'amount' => $commission,
                        'source_type' => 'Credit Recharge',
                    ]);
                }
            }
        }
    }
}
