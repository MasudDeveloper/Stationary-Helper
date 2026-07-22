<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CvTemplate;

class CvTemplateController extends Controller
{
    public function index()
    {
        $templates = CvTemplate::all();
        return view('admin.cv_templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.cv_templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'language' => 'required|string',
            'format' => 'nullable|string',
            'design_name' => 'nullable|string',
            'content' => 'required|string',
            'credit_cost' => 'required|integer|min:0',
        ]);

        // Auto-extract placeholders (words inside square brackets)
        preg_match_all('/\[(.*?)\]/', $request->content, $matches);
        $fields = array_values(array_unique($matches[1]));
        
        $template = new CvTemplate();
        $template->name = $request->name;
        $template->language = $request->language;
        $template->format = $request->format;
        $template->design_name = $request->design_name;
        $template->content = $request->content;
        $template->total_fields = count($fields);
        $template->fields_data = json_encode($fields);
        $template->credit_cost = $request->credit_cost;
        $template->save();

        return redirect()->route('admin.cv_templates.index')->with('success', 'CV Template created successfully');
    }

    public function edit(CvTemplate $cvTemplate)
    {
        return view('admin.cv_templates.edit', compact('cvTemplate'));
    }

    public function update(Request $request, CvTemplate $cvTemplate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'language' => 'required|string',
            'format' => 'nullable|string',
            'design_name' => 'nullable|string',
            'content' => 'required|string',
            'credit_cost' => 'required|integer|min:0',
        ]);

        preg_match_all('/\[(.*?)\]/', $request->content, $matches);
        $fields = array_values(array_unique($matches[1]));

        $cvTemplate->name = $request->name;
        $cvTemplate->language = $request->language;
        $cvTemplate->format = $request->format;
        $cvTemplate->design_name = $request->design_name;
        $cvTemplate->content = $request->content;
        $cvTemplate->total_fields = count($fields);
        $cvTemplate->fields_data = json_encode($fields);
        $cvTemplate->credit_cost = $request->credit_cost;
        $cvTemplate->is_active = $request->has('is_active');
        $cvTemplate->save();

        return redirect()->route('admin.cv_templates.index')->with('success', 'CV Template updated successfully');
    }

    public function destroy(CvTemplate $cvTemplate)
    {
        $cvTemplate->delete();
        return redirect()->route('admin.cv_templates.index')->with('success', 'CV Template deleted successfully');
    }
}
