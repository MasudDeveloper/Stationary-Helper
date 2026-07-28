<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DesignAiController extends Controller
{
    public function graphicsEditor()
    {
        return view('design.graphics');
    }

    public function aiHub()
    {
        return view('design.ai_hub');
    }

    public function generateImage(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:500',
        ]);

        $user = Auth::user();
        
        // Check dynamic setting from Admin panel (default is 0 for free)
        $costSetting = \App\Models\Setting::where('key', 'ai_image_cost')->value('value');
        $cost = ($costSetting !== null && $costSetting !== '') ? (float) $costSetting : 0.00;

        if ($cost > 0 && $user->credits < $cost) {
            return response()->json(['error' => 'আপনার পর্যাপ্ত ক্রেডিট নেই। প্রতিটি ছবি জেনারেট করতে ' . $cost . ' ক্রেডিট প্রয়োজন। অনুগ্রহ করে রিচার্জ করুন।'], 403);
        }

        // Deduct credits only if cost > 0
        if ($cost > 0) {
            $user->credits -= $cost;
            $user->save();
        }

        // Integrate with pollinations.ai for image generation (free, no API key required)
        $encodedPrompt = urlencode($request->prompt);
        $imageUrl = "https://image.pollinations.ai/prompt/{$encodedPrompt}?width=1024&height=1024&nologo=true";

        return response()->json([
            'success' => true,
            'image_url' => $imageUrl,
            'remaining_credits' => $user->credits,
            'cost' => $cost
        ]);
    }

    public function removeBackground(Request $request)
    {
        $request->validate([
            'image' => 'required|string', // Base64 image
        ]);

        $user = Auth::user();
        $cost = 0; // Free in AI Hub

        // Return success without deducting any credits
        return response()->json([
            'success' => true,
            'remaining_credits' => $user ? $user->credits : 0,
            'cost' => $cost
        ]);
    }
}
