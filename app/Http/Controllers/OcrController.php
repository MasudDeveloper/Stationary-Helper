<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Http;
use App\Models\Setting;

class OcrController extends Controller
{
    /**
     * Show the OCR tool UI
     */
    public function index()
    {
        $engine = Setting::where('key', 'ocr_engine')->value('value') ?? 'tesseract';
        
        $costSetting = Setting::where('key', 'cost_ocr_scanner')->value('value');
        $cost = ($costSetting !== null && $costSetting !== '') ? (float) $costSetting : 5.00;
        
        return view('ocr.index', compact('engine', 'cost'));
    }

    /**
     * Deduct credits before starting OCR processing
     */
    public function deductCredit(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $costSetting = Setting::where('key', 'cost_ocr_scanner')->value('value');
        $cost = ($costSetting !== null && $costSetting !== '') ? (float) $costSetting : 5.00;

        if ($cost > 0 && $user->credits < $cost) {
            return response()->json([
                'error' => 'আপনার পর্যাপ্ত ক্রেডিট নেই। অনুগ্রহ করে ক্রেডিট রিচার্জ করুন।'
            ], 403);
        }

        if ($cost > 0) {
            $user->deductCreditAndPayCommission($cost, 'OCR Scanner');
        }

        return response()->json([
            'success' => true,
            'remaining_credits' => $user->credits,
            'cost' => $cost
        ]);
    }

    /**
     * Process OCR via OCR.Space API Backend
     */
    public function processOcrSpace(Request $request)
    {
        $request->validate([
            'image' => 'required|string', // Base64 image
            'language' => 'required|string' // ben or eng
        ]);

        $apiKey = Setting::where('key', 'ocr_space_api_key')->value('value');
        
        if (empty($apiKey)) {
            return response()->json(['error' => 'OCR API Key is not configured by Admin.'], 500);
        }

        $language = $request->language === 'ben' ? 'ben' : 'eng'; // OCR.Space uses 'ben' and 'eng'

        try {
            $response = Http::asForm()->post('https://api.ocr.space/parse/image', [
                'apikey' => $apiKey,
                'base64Image' => $request->image,
                'language' => $language,
                'OCREngine' => 2 // Engine 2 is much better for special characters/asian languages
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['IsErroredOnProcessing']) && $data['IsErroredOnProcessing']) {
                    return response()->json(['error' => $data['ErrorMessage'][0] ?? 'OCR processing failed.'], 500);
                }

                $text = '';
                if (isset($data['ParsedResults']) && count($data['ParsedResults']) > 0) {
                    foreach ($data['ParsedResults'] as $result) {
                        $text .= $result['ParsedText'] . "\n";
                    }
                }

                return response()->json(['success' => true, 'text' => trim($text)]);
            }

            return response()->json(['error' => 'Failed to connect to OCR service.'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred during OCR.'], 500);
        }
    }
}
