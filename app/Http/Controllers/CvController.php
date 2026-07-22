<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CvTemplate;
use Illuminate\Support\Facades\Auth;

class CvController extends Controller
{
    public function index()
    {
        $templates = CvTemplate::where('is_active', true)->get();
        return view('cv.index', compact('templates'));
    }

    public function fill($id)
    {
        $template = CvTemplate::where('is_active', true)->findOrFail($id);
        
        // Decode the fields json
        $fields = json_decode($template->fields_data, true) ?? [];
        
        return view('cv.fill', compact('template', 'fields'));
    }

    public function deductCredit($id)
    {
        $template = CvTemplate::findOrFail($id);
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $cost = $template->credit_cost ?? 5;
        
        if ($user->credits < $cost) {
            return response()->json([
                'success' => false,
                'message' => 'পর্যাপ্ত ক্রেডিট নেই! আপনার অ্যাকাউন্টে আরো ক্রেডিট যোগ করুন।'
            ], 403);
        }
        
        $user->credits -= $cost;
        $user->save();
        
        return response()->json([
            'success' => true,
            'message' => 'ক্রেডিট কাটা হয়েছে। প্রিন্টিং শুরু হচ্ছে...',
            'remaining_credits' => $user->credits
        ]);
    }

    public function sendWhatsApp(Request $request, $id)
    {
        $request->validate([
            'phone' => 'required|string',
            'pdf_base64' => 'required|string',
            'filename' => 'required|string'
        ]);

        $template = CvTemplate::findOrFail($id);
        $user = Auth::user();

        $cost = $template->credit_cost ?? 5;
        if ($user->credits < $cost) {
            return response()->json([
                'success' => false,
                'message' => 'পর্যাপ্ত ক্রেডিট নেই! আপনার অ্যাকাউন্টে আরো ক্রেডিট যোগ করুন।'
            ], 403);
        }

        try {
            $statusResp = \Illuminate\Support\Facades\Http::timeout(5)->get("http://localhost:3001/status/{$user->id}");
            if (!$statusResp->successful() || $statusResp->json('status') !== 'CONNECTED') {
                return response()->json([
                    'success' => false,
                    'message' => 'আপনার WhatsApp কানেক্ট করা নেই। দয়া করে ড্যাশবোর্ড থেকে WhatsApp কানেক্ট করুন।'
                ], 400);
            }

            $parts = explode(',', $request->pdf_base64);
            $base64 = end($parts);

            $response = \Illuminate\Support\Facades\Http::post("http://localhost:3001/send", [
                'userId' => $user->id,
                'phone' => $request->phone,
                'message' => 'আপনার রিকুয়েস্ট করা সিভিটি পাঠানো হয়েছে।',
                'mediaBase64' => $base64,
                'mediaMime' => 'application/pdf',
                'mediaName' => $request->filename . '.pdf'
            ]);

            if ($response->successful() && $response->json('success')) {
                $user->credits -= $cost;
                $user->save();

                return response()->json([
                    'success' => true,
                    'message' => 'WhatsApp-এ ফাইল পাঠানো সফল হয়েছে!',
                    'remaining_credits' => $user->credits
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'ফাইল পাঠানো সম্ভব হয়নি। WhatsApp কানেকশন চেক করুন।'
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'সার্ভারের সাথে কানেক্ট করা যাচ্ছে না।'
            ], 500);
        }
    }
}
