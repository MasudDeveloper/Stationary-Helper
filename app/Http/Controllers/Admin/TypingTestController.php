<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TypingTestParagraph;

class TypingTestController extends Controller
{
    public function index()
    {
        $paragraphs = TypingTestParagraph::latest()->get();
        return view('admin.typing_test.index', compact('paragraphs'));
    }

    public function create()
    {
        return view('admin.typing_test.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'language' => 'required|string|in:English,Bangla',
            'content' => 'required|string',
        ]);

        TypingTestParagraph::create([
            'title' => $request->title,
            'language' => $request->language,
            'content' => $request->content,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.typing-test.index')->with('success', 'Paragraph added successfully');
    }

    public function edit(TypingTestParagraph $typing_test)
    {
        return view('admin.typing_test.edit', compact('typing_test'));
    }

    public function update(Request $request, TypingTestParagraph $typing_test)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'language' => 'required|string|in:English,Bangla',
            'content' => 'required|string',
        ]);

        $typing_test->update([
            'title' => $request->title,
            'language' => $request->language,
            'content' => $request->content,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.typing-test.index')->with('success', 'Paragraph updated successfully');
    }

    public function destroy(TypingTestParagraph $typing_test)
    {
        $typing_test->delete();
        return redirect()->route('admin.typing-test.index')->with('success', 'Paragraph deleted successfully');
    }
}
