<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminOrder;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = AdminOrder::with(['admin', 'shopkeeper'])->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        return view('admin.orders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'shopkeeper_account_id' => 'required|string',
            'order_details' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ]);

        $shopkeeper = User::where('account_id', $request->shopkeeper_account_id)
                          ->where('account_type', 'business')
                          ->first();

        if (!$shopkeeper) {
            return back()->with('error', 'এই Account ID এর কোনো বিজনেস একাউন্ট পাওয়া যায়নি।')->withInput();
        }

        AdminOrder::create([
            'admin_id' => Auth::id(),
            'shopkeeper_id' => $shopkeeper->id,
            'order_details' => $request->order_details,
            'amount' => $request->amount,
            'status' => 'pending'
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'অর্ডার সফলভাবে পাঠানো হয়েছে।');
    }

    public function markPaid($id)
    {
        $order = AdminOrder::findOrFail($id);
        if ($order->status !== 'completed') {
            return back()->with('error', 'অর্ডারটি এখনো কমপ্লিট হয়নি।');
        }

        $order->status = 'paid';
        $order->save();

        return back()->with('success', 'অর্ডারটি পেইড (Paid) হিসেবে মার্ক করা হয়েছে।');
    }
}
