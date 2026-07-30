<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\QuestionPaper;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index()
    {
        $papers = QuestionPaper::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('questions.index', compact('papers'));
    }

    public function create(Request $request)
    {
        $type = $request->query('type', 'mcq');
        return view('questions.create', compact('type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'school_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'subject' => 'nullable|string',
            'class' => 'nullable|string',
            'duration' => 'nullable|string',
            'marks' => 'nullable|string',
            'type' => 'required|in:mcq,cq,mixed',
            'content' => 'required|json',
        ]);

        QuestionPaper::create([
            'user_id' => Auth::id(),
            'school_name' => $request->school_name ?? 'স্কুলের / প্রতিষ্ঠানের নাম',
            'address' => $request->address ?? 'ঠিকানা / স্থান',
            'title' => $request->title,
            'subject' => $request->subject,
            'class' => $request->class,
            'duration' => $request->duration ?? '৩ ঘণ্টা',
            'marks' => $request->marks ?? '৫০',
            'type' => $request->type,
            'content' => json_decode($request->content, true),
        ]);

        return response()->json(['success' => true, 'redirect' => route('questions.index')]);
    }

    public function show($id)
    {
        $paper = QuestionPaper::where('user_id', Auth::id())->findOrFail($id);
        return view('questions.show', compact('paper'));
    }

    public function destroy($id)
    {
        $paper = QuestionPaper::where('user_id', Auth::id())->findOrFail($id);
        $paper->delete();

        return back()->with('success', 'প্রশ্নপত্র মুছে ফেলা হয়েছে।');
    }
}
