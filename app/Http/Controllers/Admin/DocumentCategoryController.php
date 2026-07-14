<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentCategory;

class DocumentCategoryController extends Controller
{
    public function index()
    {
        $categories = DocumentCategory::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = new DocumentCategory();
        $category->name = $request->name;
        $category->is_active = $request->has('is_active');
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully');
    }

    public function edit(DocumentCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, DocumentCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category->name = $request->name;
        $category->is_active = $request->has('is_active');
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy(DocumentCategory $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully');
    }
}
