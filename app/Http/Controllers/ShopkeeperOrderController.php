<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminOrder;
use Illuminate\Support\Facades\Auth;

class ShopkeeperOrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->account_type !== 'business') {
            return redirect()->route('dashboard')->with('error', 'আপনার বিজনেস একাউন্ট নেই।');
        }

        $orders = AdminOrder::where('shopkeeper_id', $user->id)
                            ->orderBy('created_at', 'desc')
                            ->paginate(15);
        return view('shopkeeper.orders.index', compact('orders'));
    }

    public function accept($id)
    {
        $order = AdminOrder::where('shopkeeper_id', Auth::id())->findOrFail($id);
        
        if ($order->status !== 'pending') {
            return back()->with('error', 'অর্ডারটি ইতিমধ্যে অ্যাক্সেপ্ট করা হয়েছে।');
        }

        $order->status = 'accepted';
        $order->save();

        return back()->with('success', 'অর্ডারটি অ্যাক্সেপ্ট করা হয়েছে। কাজ শেষ হলে "Mark as Completed" এ ক্লিক করুন।');
    }

    public function complete($id)
    {
        $order = AdminOrder::where('shopkeeper_id', Auth::id())->findOrFail($id);
        
        if ($order->status !== 'accepted') {
            return back()->with('error', 'অর্ডারটি আগে অ্যাক্সেপ্ট করতে হবে।');
        }

        $order->status = 'completed';
        $order->save();

        return back()->with('success', 'কাজটি সম্পন্ন হয়েছে! এডমিন যাচাই করে পেমেন্ট করবে।');
    }
}
