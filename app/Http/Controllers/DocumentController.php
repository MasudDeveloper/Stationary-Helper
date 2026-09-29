<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentTemplate;
use App\Models\SavedDocument;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index()
    {
        $templates = DocumentTemplate::where('is_active', true)->with('category')->get();
        return view('document.index', compact('templates'));
    }

    public function fill(Request $request, $id)
    {
        $template = DocumentTemplate::where('is_active', true)->findOrFail($id);
        
        // Decode the fields json
        $fields = json_decode($template->fields_data, true) ?? [];
        
        $savedData = [];
        if ($request->query('saved_id')) {
            $savedDoc = SavedDocument::where('user_id', Auth::id())->find($request->query('saved_id'));
            if ($savedDoc && $savedDoc->form_data) {
                $savedData = $savedDoc->form_data;
            }
        }

        $whatsappCostSetting = \App\Models\Setting::where('key', 'cost_document_whatsapp_send')->value('value');
        $whatsappCost = ($whatsappCostSetting !== null && $whatsappCostSetting !== '') ? (float) $whatsappCostSetting : 5.0;

        return view('document.fill', compact('template', 'fields', 'savedData', 'whatsappCost'));
    }

    public function toggleFavorite($id)
    {
        $template = DocumentTemplate::findOrFail($id);
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if ($user->favoriteDocuments()->where('document_template_id', $id)->exists()) {
            $user->favoriteDocuments()->detach($id);
            return back()->with('success', 'ডকুমেন্টটি ফেভারিট থেকে সরানো হয়েছে।');
        } else {
            $user->favoriteDocuments()->attach($id);
            return back()->with('success', 'ডকুমেন্টটি ফেভারিটে যুক্ত করা হয়েছে।');
        }
    }

    public function favorites()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $templates = $user->favoriteDocuments()->where('is_active', true)->with('category')->get();
        return view('document.favorites', compact('templates'));
    }

    public function deductCredit($id)
    {
        $template = DocumentTemplate::findOrFail($id);
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $cost = $template->credit_cost ?? 5; // Default to 5 if null
        
        if (!$user->hasActiveSubscription() && $user->credits < $cost) {
            return response()->json([
                'success' => false,
                'message' => 'পর্যাপ্ত ক্রেডিট নেই! আপনার অ্যাকাউন্টে আরো ক্রেডিট যোগ করুন।'
            ], 403);
        }
        
        $user->deductCreditAndPayCommission($cost, 'Document Print');
        
        // Also log this transaction (optional, but recommended if there is a transaction system)
        
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

        $template = DocumentTemplate::findOrFail($id);
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Optional: Deduct credit for sending via WhatsApp
        $costSetting = \App\Models\Setting::where('key', 'cost_document_whatsapp_send')->value('value');
        $cost = ($costSetting !== null && $costSetting !== '') ? (float) $costSetting : 5.0;
        if (!$user->hasActiveSubscription() && $user->credits < $cost) {
            return response()->json([
                'success' => false,
                'message' => 'পর্যাপ্ত ক্রেডিট নেই! আপনার অ্যাকাউন্টে আরো ক্রেডিট যোগ করুন।'
            ], 403);
        }

        try {
            // Check status first
            $whatsappUrl = env('WHATSAPP_SERVER_URL', (request()->getHost() === 'localhost' || request()->getHost() === '127.0.0.1') ? 'http://localhost:3001' : 'https://whatsapp.' . preg_replace('/^www\./', '', request()->getHost()));
            $statusResp = \Illuminate\Support\Facades\Http::timeout(5)->get("{$whatsappUrl}/status/{$user->id}");
            if (!$statusResp->successful() || $statusResp->json('status') !== 'CONNECTED') {
                return response()->json([
                    'success' => false,
                    'message' => 'আপনার WhatsApp কানেক্ট করা নেই। দয়া করে ড্যাশবোর্ড থেকে WhatsApp কানেক্ট করুন।'
                ], 400);
            }

            // Clean base64 string safely
            $parts = explode(',', $request->pdf_base64);
            $base64 = end($parts);

            $response = \Illuminate\Support\Facades\Http::post("{$whatsappUrl}/send", [
                'userId' => $user->id,
                'phone' => $request->phone,
                'message' => 'আপনার রিকুয়েস্ট করা ডকুমেন্টটি পাঠানো হয়েছে।',
                'mediaBase64' => $base64,
                'mediaMime' => 'application/pdf',
                'mediaName' => $request->filename . '.pdf'
            ]);

            if ($response->successful() && $response->json('success')) {
                // Deduct credit since it was successfully sent
                $user->deductCreditAndPayCommission($cost, 'Document WhatsApp Send');

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
