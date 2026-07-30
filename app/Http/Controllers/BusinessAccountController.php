<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessUpgradeRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class BusinessAccountController extends Controller
{
    public function upgrade()
    {
        $user = Auth::user();
        if ($user->account_type == 'business') {
            return redirect()->route('dashboard')->with('error', 'আপনার আগে থেকেই বিজনেস একাউন্ট আছে।');
        }

        $existingRequest = BusinessUpgradeRequest::where('user_id', $user->id)
                            ->where('status', 'pending')
                            ->first();

        $upgradeFee = Setting::where('key', 'business_upgrade_fee')->value('value') ?? 50;
        
        $settings = Setting::whereIn('key', [
            'payment_bkash', 'payment_nagad', 'payment_rocket', 'upgrade_banner_url'
        ])->pluck('value', 'key')->toArray();

        return view('business.upgrade', compact('existingRequest', 'upgradeFee', 'settings'));
    }

    public function submitUpgrade(Request $request)
    {
        $user = Auth::user();
        if ($user->account_type == 'business') {
            return back()->with('error', 'আপনার আগে থেকেই বিজনেস একাউন্ট আছে।');
        }

        $request->validate([
            'trx_id' => 'required|string|max:100',
            'payment_method' => 'required|string|max:50',
        ]);

        $upgradeFee = Setting::where('key', 'business_upgrade_fee')->value('value') ?? 50;

        BusinessUpgradeRequest::create([
            'user_id' => $user->id,
            'amount' => $upgradeFee,
            'trx_id' => $request->trx_id,
            'payment_method' => $request->payment_method,
            'status' => 'pending'
        ]);

        return back()->with('success', 'আপনার রিকোয়েস্ট পাঠানো হয়েছে! এডমিন খুব শীঘ্রই যাচাই করে একাউন্ট আপগ্রেড করে দিবে।');
    }
}
