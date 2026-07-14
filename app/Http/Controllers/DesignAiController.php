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
        
        // Determine credit cost based on account type
        $cost = ($user->role === 'business') ? 1.00 : 5.00;

        if ($user->credits < $cost) {
            return response()->json(['error' => 'আপনার পর্যাপ্ত ক্রেডিট নেই। অনুগ্রহ করে ক্রেডিট রিচার্জ করুন।'], 403);
        }

        // Deduct credits
        $user->credits -= $cost;
        $user->save();

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
        $cost = ($user->role === 'business') ? 1.00 : 5.00;

        if ($user->credits < $cost) {
            return response()->json(['error' => 'আপনার পর্যাপ্ত ক্রেডিট নেই। অনুগ্রহ করে ক্রেডিট রিচার্জ করুন।'], 403);
        }

        // Deduct credits
        $user->credits -= $cost;
        $user->save();

        // Return success and trigger mock/client-side transparent processing
        return response()->json([
            'success' => true,
            'remaining_credits' => $user->credits,
            'cost' => $cost
        ]);
    }
}
