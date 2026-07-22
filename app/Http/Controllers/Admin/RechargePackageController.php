<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RechargePackage;

class RechargePackageController extends Controller
{
    public function index()
    {
        $packages = RechargePackage::orderBy('sort_order')->get();
        return view('admin.recharge_packages.index', compact('packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'credits' => 'required|integer|min:1',
            'price' => 'required|numeric|min:1',
            'sort_order' => 'nullable|integer',
        ]);

        RechargePackage::create([
            'title' => $request->title,
            'credits' => $request->credits,
            'price' => $request->price,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return back()->with('success', 'প্যাকেজ সফলভাবে তৈরি হয়েছে।');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'credits' => 'required|integer|min:1',
            'price' => 'required|numeric|min:1',
            'sort_order' => 'nullable|integer',
        ]);

        $package = RechargePackage::findOrFail($id);
        $package->update([
            'title' => $request->title,
            'credits' => $request->credits,
            'price' => $request->price,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return back()->with('success', 'প্যাকেজ আপডেট করা হয়েছে।');
    }

    public function destroy($id)
    {
        $package = RechargePackage::findOrFail($id);
        $package->delete();

        return back()->with('success', 'প্যাকেজ ডিলিট করা হয়েছে।');
    }
}
