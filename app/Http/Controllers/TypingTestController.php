<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypingTestParagraph;

class TypingTestController extends Controller
{
    public function index()
    {
        $paragraphs = TypingTestParagraph::where('is_active', true)->latest()->get();
        return view('typing_test.index', compact('paragraphs'));
    }

    public function test($id)
    {
        $paragraph = TypingTestParagraph::where('is_active', true)->findOrFail($id);
        return view('typing_test.test', compact('paragraph'));
    }

    public function custom()
    {
        return view('typing_test.custom');
    }
}
