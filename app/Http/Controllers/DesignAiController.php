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
        $costSetting = \App\Models\Setting::where('key', 'ai_image_cost')->value('value');
        $cost = ($costSetting !== null && $costSetting !== '') ? (float) $costSetting : 0.00;
        
        $bgCostSetting = \App\Models\Setting::where('key', 'cost_bg_removal')->value('value');
        $bg_cost = ($bgCostSetting !== null && $bgCostSetting !== '') ? (float) $bgCostSetting : 5.00;
        
        return view('design.ai_hub', compact('cost', 'bg_cost'));
    }

    public function generateImage(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:500',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Check dynamic setting from Admin panel (default is 0 for free)
        $costSetting = \App\Models\Setting::where('key', 'ai_image_cost')->value('value');
        $cost = ($costSetting !== null && $costSetting !== '') ? (float) $costSetting : 0.00;

        if ($cost > 0 && $user->credits < $cost) {
            return response()->json(['error' => 'আপনার পর্যাপ্ত ক্রেডিট নেই। প্রতিটি ছবি জেনারেট করতে ' . $cost . ' ক্রেডিট প্রয়োজন। অনুগ্রহ করে রিচার্জ করুন।'], 403);
        }

        // Deduct credits only if cost > 0
        if ($cost > 0) {
            $user->deductCreditAndPayCommission($cost, 'AI Image Generation');
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

        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $costSetting = \App\Models\Setting::where('key', 'cost_bg_removal')->value('value');
        $cost = ($costSetting !== null && $costSetting !== '') ? (float) $costSetting : 5.00;

        if ($cost > 0 && $user->credits < $cost) {
            return response()->json(['error' => 'আপনার পর্যাপ্ত ক্রেডিট নেই। ব্যাকগ্রাউন্ড রিমুভ করতে ' . $cost . ' ক্রেডিট প্রয়োজন।'], 403);
        }

        if ($cost > 0) {
            $user->deductCreditAndPayCommission($cost, 'Background Removal');
        }

        // Return success
        return response()->json([
            'success' => true,
            'remaining_credits' => $user ? $user->credits : 0,
            'cost' => $cost
        ]);
    }
}
