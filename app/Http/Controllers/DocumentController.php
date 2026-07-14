<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentTemplate;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index()
    {
        $templates = DocumentTemplate::where('is_active', true)->with('category')->get();
        return view('document.index', compact('templates'));
    }

    public function fill($id)
    {
        $template = DocumentTemplate::where('is_active', true)->findOrFail($id);
        
        // Decode the fields json
        $fields = json_decode($template->fields_data, true) ?? [];
        
        return view('document.fill', compact('template', 'fields'));
    }
}
