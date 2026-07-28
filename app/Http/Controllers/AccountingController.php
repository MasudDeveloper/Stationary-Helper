<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AccountingTransaction;
use App\Models\DailyCashRecord;
use App\Models\Due;
use Illuminate\Support\Facades\Auth;

class AccountingController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $transactions = AccountingTransaction::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $income = $transactions->where('type', 'income')->sum('amount');
        $expense = $transactions->where('type', 'expense')->sum('amount');
        $balance = $income - $expense;

        return view('accounting.index', compact('transactions', 'income', 'expense', 'balance'));
    }

    public function storeTransaction(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        AccountingTransaction::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return back()->with('success', 'হিসাব সফলভাবে যোগ করা হয়েছে।');
    }

    public function destroyTransaction($id)
    {
        $transaction = AccountingTransaction::where('user_id', Auth::id())->findOrFail($id);
        $transaction->delete();
        return back()->with('success', 'হিসাব মুছে ফেলা হয়েছে।');
    }

    public function cashCalculator()
    {
        $records = DailyCashRecord::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('accounting.calculator', compact('records'));
    }

    public function storeCashRecord(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'note_1000' => 'integer|min:0',
            'note_500' => 'integer|min:0',
            'note_200' => 'integer|min:0',
            'note_100' => 'integer|min:0',
            'note_50' => 'integer|min:0',
            'note_20' => 'integer|min:0',
            'note_10' => 'integer|min:0',
            'note_5' => 'integer|min:0',
            'note_2' => 'integer|min:0',
            'note_1' => 'integer|min:0',
        ]);

        $total = ($request->note_1000 * 1000) +
                 ($request->note_500 * 500) +
                 ($request->note_200 * 200) +
                 ($request->note_100 * 100) +
                 ($request->note_50 * 50) +
                 ($request->note_20 * 20) +
                 ($request->note_10 * 10) +
                 ($request->note_5 * 5) +
                 ($request->note_2 * 2) +
                 ($request->note_1 * 1);

        DailyCashRecord::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'note_1000' => $request->note_1000 ?? 0,
            'note_500' => $request->note_500 ?? 0,
            'note_200' => $request->note_200 ?? 0,
            'note_100' => $request->note_100 ?? 0,
            'note_50' => $request->note_50 ?? 0,
            'note_20' => $request->note_20 ?? 0,
            'note_10' => $request->note_10 ?? 0,
            'note_5' => $request->note_5 ?? 0,
            'note_2' => $request->note_2 ?? 0,
            'note_1' => $request->note_1 ?? 0,
            'total_amount' => $total,
        ]);

        return back()->with('success', 'ক্যাশ হিসাব সফলভাবে সংরক্ষণ করা হয়েছে।');
    }

    public function receiptGenerator()
    {
        return redirect()->route('accounting.memo');
    }

    public function memoGenerator()
    {
        return view('accounting.memo');
    }

    public function sendWhatsApp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'pdf_base64' => 'required|string',
            'filename' => 'required|string',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'আপনাকে প্রথমে লগইন করতে হবে।'
            ], 401);
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
                'message' => $request->message ?? 'আপনার ইনভয়েস / ক্যাশ মেমো পাঠানো হয়েছে।',
                'mediaBase64' => $base64,
                'mediaMime' => 'application/pdf',
                'mediaName' => $request->filename . '.pdf'
            ]);

            if ($response->successful() && $response->json('success')) {
                return response()->json([
                    'success' => true,
                    'message' => 'WhatsApp-এ ইনভয়েস PDF ফাইল পাঠানো সফল হয়েছে!'
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

    // --- Dues (Bakir Hishab) Methods ---
    
    public function dues()
    {
        $userId = Auth::id();
        $dues = Due::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        
        $receivable = $dues->where('type', 'receivable')->where('is_paid', false)->sum('amount');
        $payable = $dues->where('type', 'payable')->where('is_paid', false)->sum('amount');
        
        return view('accounting.dues', compact('dues', 'receivable', 'payable'));
    }

    public function storeDue(Request $request)
    {
        $request->validate([
            'person_name' => 'required|string|max:255',
            'type' => 'required|in:receivable,payable',
            'amount' => 'required|numeric|min:1',
            'purpose' => 'nullable|string|max:255',
            'due_date' => 'nullable|date',
        ]);

        Due::create([
            'user_id' => Auth::id(),
            'person_name' => $request->person_name,
            'type' => $request->type,
            'amount' => $request->amount,
            'purpose' => $request->purpose,
            'due_date' => $request->due_date,
            'is_paid' => false,
        ]);

        return back()->with('success', 'বাকি হিসাব সফলভাবে যোগ করা হয়েছে।');
    }

    public function markDuePaid($id)
    {
        $due = Due::where('user_id', Auth::id())->findOrFail($id);
        $due->is_paid = true;
        $due->save();
        
        return back()->with('success', 'হিসাব পরিশোধিত হিসেবে মার্ক করা হয়েছে।');
    }

    public function destroyDue($id)
    {
        $due = Due::where('user_id', Auth::id())->findOrFail($id);
        $due->delete();
        
        return back()->with('success', 'হিসাব মুছে ফেলা হয়েছে।');
    }
}
