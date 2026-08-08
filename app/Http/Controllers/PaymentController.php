<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\PaymentRequest;
use App\Models\User;

class PaymentController extends Controller
{
    public function recharge()
    {
        $packages = \App\Models\RechargePackage::where('is_active', true)->orderBy('sort_order')->get();
        return view('payment.recharge', compact('packages'));
    }

    public function submitRecharge(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:recharge_packages,id',
            'sender_number' => 'required|string',
            'transaction_id' => 'required|string|unique:payment_requests',
        ]);

        $package = \App\Models\RechargePackage::findOrFail($request->package_id);

        PaymentRequest::create([
            'user_id' => Auth::id(),
            'amount' => $package->price,
            'credits' => $package->credits,
            'payment_method' => 'bkash',
            'sender_number' => $request->sender_number,
            'transaction_id' => $request->transaction_id,
        ]);

        return back()->with('success', 'আপনার পেমেন্ট রিকোয়েস্ট সফলভাবে জমা হয়েছে। অ্যাডমিন ভেরিফাই করার পর আপনার একাউন্টে ক্রেডিট যোগ হবে।');
    }

    // Admin functions
    public function adminPayments()
    {
        $requests = PaymentRequest::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.payments', compact('requests'));
    }

    public function approvePayment($id)
    {
        $paymentRequest = PaymentRequest::findOrFail($id);
        
        if ($paymentRequest->status === 'pending') {
            $paymentRequest->status = 'approved';
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

                // Pay 20% commission to referrer if applicable
                if ($user->referred_by) {
                    $referrer = User::find($user->referred_by);
                    if ($referrer) {
                        $commission = $paymentRequest->amount * 0.20; // 20% commission
                        $referrer->credits += $commission;
                        $referrer->save();

                        \App\Models\ReferralEarning::create([
                            'referrer_id' => $referrer->id,
                            'referred_user_id' => $user->id,
                            'amount' => $commission,
                            'source_type' => 'Subscription Purchase (' . $paymentRequest->subscription_plan . ')',
                        ]);
                    }
                }
            } else {
                // Add credits to user
                $user->credits += $paymentRequest->credits;
                $user->save();
                
                // Give commission to referrer (10% of recharged credits)
                if ($user->referred_by) {
                    $referrer = User::find($user->referred_by);
                    if ($referrer) {
                        $commission = $paymentRequest->credits * 0.10; // 10% commission
                        $referrer->credits += $commission;
                        $referrer->save();

                        \App\Models\ReferralEarning::create([
                            'referrer_id' => $referrer->id,
                            'referred_user_id' => $user->id,
                            'amount' => $commission,
                            'source_type' => 'Credit Recharge',
                        ]);
                    }
                }
            }
            
            return back()->with('success', 'পেমেন্ট অ্যাপ্রুভ করা হয়েছে।');
        }
        
        return back()->with('error', 'এই রিকোয়েস্টটি আগে থেকেই প্রসেস করা হয়েছে।');
    }

    public function rejectPayment($id)
    {
        $paymentRequest = PaymentRequest::findOrFail($id);
        
        if ($paymentRequest->status === 'pending') {
            $paymentRequest->status = 'rejected';
            $paymentRequest->save();
            
            return back()->with('success', 'পেমেন্ট রিজেক্ট করা হয়েছে।');
        }
        
        return back()->with('error', 'এই রিকোয়েস্টটি আগে থেকেই প্রসেস করা হয়েছে।');
    }
}
