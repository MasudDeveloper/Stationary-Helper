<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PdfTool;

class AdminPdfToolController extends Controller
{
    public function index()
    {
        $tools = PdfTool::orderBy('order')->get();
        return view('admin.pdf_tools', compact('tools'));
    }

    public function toggle($id)
    {
        $tool = PdfTool::findOrFail($id);
        $tool->is_active = !$tool->is_active;
        $tool->save();

        return redirect()->back()->with('success', 'টুলের স্ট্যাটাস আপডেট করা হয়েছে।');
    }
}
