<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReferralEarning;
use Illuminate\Support\Facades\Auth;

class ReferralController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $earnings = ReferralEarning::where('referrer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'earnings_page');
            
        $referredUsers = $user->referrals()
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'users_page');
            
        $totalEarned = ReferralEarning::where('referrer_id', $user->id)->sum('amount');
        $totalReferrals = $user->referrals()->count();

        return view('referrals.index', compact('earnings', 'referredUsers', 'totalEarned', 'totalReferrals'));
    }
}
