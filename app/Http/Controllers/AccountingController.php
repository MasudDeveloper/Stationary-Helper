<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AccountingTransaction;
use App\Models\DailyCashRecord;
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
        return view('accounting.receipt');
    }

    public function memoGenerator()
    {
        return view('accounting.memo');
    }
}
