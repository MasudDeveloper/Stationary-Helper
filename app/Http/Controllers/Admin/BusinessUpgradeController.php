<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessUpgradeRequest;
use Illuminate\Support\Facades\Auth;

class BusinessUpgradeController extends Controller
{
    public function index()
    {
        $requests = BusinessUpgradeRequest::with('user')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.business_upgrades.index', compact('requests'));
    }

    public function approve($id)
    {
        $req = BusinessUpgradeRequest::findOrFail($id);
        if ($req->status !== 'pending') {
            return back()->with('error', 'এই রিকোয়েস্টটি ইতিমধ্যে প্রসেস করা হয়েছে।');
        }

        $req->status = 'approved';
        $req->approved_by = Auth::id();
        $req->save();

        $user = $req->user;
        $user->account_type = 'business';
        $user->save();

        return back()->with('success', 'একাউন্টটি সফলভাবে বিজনেস একাউন্টে আপগ্রেড করা হয়েছে।');
    }

    public function reject($id)
    {
        $req = BusinessUpgradeRequest::findOrFail($id);
        if ($req->status !== 'pending') {
            return back()->with('error', 'এই রিকোয়েস্টটি ইতিমধ্যে প্রসেস করা হয়েছে।');
        }

        $req->status = 'rejected';
        $req->approved_by = Auth::id();
        $req->save();

        return back()->with('success', 'আপগ্রেড রিকোয়েস্ট বাতিল করা হয়েছে।');
    }
}
