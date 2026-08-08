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
            'credit_cost' => 'nullable|numeric|min:0',
            'page_size' => 'nullable|string',
            'page_orientation' => 'nullable|string',
            'margin_top_first' => 'nullable|numeric',
            'margin_top' => 'nullable|numeric',
            'margin_bottom' => 'nullable|numeric',
            'margin_left' => 'nullable|numeric',
            'margin_right' => 'nullable|numeric',
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
        $template->credit_cost = $request->credit_cost ?? 5;
        $template->page_size = $request->page_size ?? 'a4';
        $template->page_orientation = $request->page_orientation ?? 'portrait';
        $template->margin_top_first = $request->margin_top_first ?? 4.5;
        $template->margin_top = $request->margin_top ?? 1.0;
        $template->margin_bottom = $request->margin_bottom ?? 20;
        $template->margin_left = $request->margin_left ?? 20;
        $template->margin_right = $request->margin_right ?? 20;
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
            'credit_cost' => 'nullable|numeric|min:0',
            'page_size' => 'nullable|string',
            'page_orientation' => 'nullable|string',
            'margin_top_first' => 'nullable|numeric',
            'margin_top' => 'nullable|numeric',
            'margin_bottom' => 'nullable|numeric',
            'margin_left' => 'nullable|numeric',
            'margin_right' => 'nullable|numeric',
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
        if ($request->has('credit_cost')) $template->credit_cost = $request->credit_cost;
        if ($request->has('page_size')) $template->page_size = $request->page_size;
        if ($request->has('page_orientation')) $template->page_orientation = $request->page_orientation;
        if ($request->has('margin_top_first')) $template->margin_top_first = $request->margin_top_first;
        if ($request->has('margin_top')) $template->margin_top = $request->margin_top;
        if ($request->has('margin_bottom')) $template->margin_bottom = $request->margin_bottom;
        if ($request->has('margin_left')) $template->margin_left = $request->margin_left;
        if ($request->has('margin_right')) $template->margin_right = $request->margin_right;
        $template->save();

        return redirect()->route('admin.templates.index')->with('success', 'Template updated successfully');
    }

    public function destroy(DocumentTemplate $template)
    {
        $template->delete();
        return redirect()->route('admin.templates.index')->with('success', 'Template deleted successfully');
    }
}
