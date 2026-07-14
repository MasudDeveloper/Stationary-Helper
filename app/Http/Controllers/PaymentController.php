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
        return view('payment.recharge');
    }

    public function submitRecharge(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10',
            'sender_number' => 'required|string',
            'transaction_id' => 'required|string|unique:payment_requests',
        ]);

        // Assuming 1 Taka = 1 Credit for simplicity, can be adjusted based on account type
        $credits = $request->amount;

        PaymentRequest::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'credits' => $credits,
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

            // Add credits to user
            $user = $paymentRequest->user;
            $user->credits += $paymentRequest->credits;
            $user->save();
            
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
