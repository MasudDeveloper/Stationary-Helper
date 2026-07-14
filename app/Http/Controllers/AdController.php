<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LocalAd;

class AdController extends Controller
{
    public function index()
    {
        $ads = LocalAd::orderBy('created_at', 'desc')->get();
        return view('admin.ads', compact('ads'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'target_url' => 'nullable|url',
            'slot' => 'required|in:top,bottom,sidebar',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/ads'), $imageName);
            $imagePath = 'uploads/ads/' . $imageName;

            LocalAd::create([
                'title' => $request->title,
                'image_path' => $imagePath,
                'target_url' => $request->target_url,
                'slot' => $request->slot,
                'is_active' => true,
            ]);

            return back()->with('success', 'লোকাল বিজ্ঞাপন সফলভাবে যোগ করা হয়েছে।');
        }

        return back()->with('error', 'ছবি আপলোড করতে কোনো সমস্যা হয়েছে।');
    }

    public function toggle($id)
    {
        $ad = LocalAd::findOrFail($id);
        $ad->is_active = !$ad->is_active;
        $ad->save();

        return back()->with('success', 'বিজ্ঞাপনের স্ট্যাটাস পরিবর্তন করা হয়েছে।');
    }

    public function destroy($id)
    {
        $ad = LocalAd::findOrFail($id);
        
        // Delete image file if exists
        if (file_exists(public_path($ad->image_path))) {
            unlink(public_path($ad->image_path));
        }

        $ad->delete();

        return back()->with('success', 'লোকাল বিজ্ঞাপন মুছে ফেলা হয়েছে।');
    }
}
