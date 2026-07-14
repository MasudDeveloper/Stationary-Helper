<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentTemplate;
use App\Models\DocumentCategory;

class DocumentTemplateController extends Controller
{
    public function index()
    {
        $templates = DocumentTemplate::with('category')->get();
        return view('admin.templates.index', compact('templates'));
    }

    public function create()
    {
        $categories = DocumentCategory::where('is_active', true)->get();
        return view('admin.templates.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:document_categories,id',
            'language' => 'required|string',
            'content' => 'required|string',
        ]);

        // Auto-extract placeholders (words inside square brackets)
        preg_match_all('/\[(.*?)\]/', $request->content, $matches);
        $fields = array_values(array_unique($matches[1]));
        
        $template = new DocumentTemplate();
        $template->name = $request->name;
        $template->category_id = $request->category_id;
        $template->language = $request->language;
        $template->description = $request->description;
        $template->content = $request->content;
        $template->total_fields = count($fields);
        $template->fields_data = json_encode($fields);
        $template->save();

        return redirect()->route('admin.templates.index')->with('success', 'Template created successfully');
    }

    public function edit(DocumentTemplate $template)
    {
        $categories = DocumentCategory::where('is_active', true)->get();
        return view('admin.templates.edit', compact('template', 'categories'));
    }

    public function update(Request $request, DocumentTemplate $template)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:document_categories,id',
            'language' => 'required|string',
            'content' => 'required|string',
        ]);

        preg_match_all('/\[(.*?)\]/', $request->content, $matches);
        $fields = array_values(array_unique($matches[1]));

        $template->name = $request->name;
        $template->category_id = $request->category_id;
        $template->language = $request->language;
        $template->description = $request->description;
        $template->content = $request->content;
        $template->total_fields = count($fields);
        $template->fields_data = json_encode($fields);
        $template->is_active = $request->has('is_active');
        $template->save();

        return redirect()->route('admin.templates.index')->with('success', 'Template updated successfully');
    }

    public function destroy(DocumentTemplate $template)
    {
        $template->delete();
        return redirect()->route('admin.templates.index')->with('success', 'Template deleted successfully');
    }
}
