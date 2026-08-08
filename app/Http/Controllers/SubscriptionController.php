<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentRequest;

class SubscriptionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('subscription.index', compact('user'));
    }

    public function buy(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:1_month,6_months,1_year',
            'sender_number' => 'required|string',
            'transaction_id' => 'required|string|unique:payment_requests',
        ]);

        $prices = [
            '1_month' => 50,
            '6_months' => 250,
            '1_year' => 500
        ];

        PaymentRequest::create([
            'user_id' => Auth::id(),
            'amount' => $prices[$request->plan],
            'credits' => 0,
            'request_type' => 'subscription',
            'subscription_plan' => $request->plan,
            'payment_method' => 'bkash',
            'sender_number' => $request->sender_number,
            'transaction_id' => $request->transaction_id,
        ]);

        return back()->with('success', 'আপনার সাবস্ক্রিপশন পেমেন্ট রিকোয়েস্ট সফলভাবে জমা হয়েছে। অ্যাডমিন ভেরিফাই করার পর আপনার সাবস্ক্রিপশন একটিভ হবে।');
    }
}
