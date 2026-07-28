<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SavedDocument;
use Illuminate\Support\Facades\Auth;

class SavedDocumentController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type');
        $query = SavedDocument::where('user_id', Auth::id())->orderBy('created_at', 'desc');
        
        if ($type) {
            $query->where('type', $type);
        }
        
        $savedDocuments = $query->paginate(15);
        
        return view('saved_documents.index', compact('savedDocuments', 'type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'template_id' => 'required|integer',
            'type' => 'required|string|in:document,cv',
            'title' => 'required|string|max:255',
            'form_data' => 'nullable|array',
        ]);

        $savedDoc = SavedDocument::create([
            'user_id' => Auth::id(),
            'template_id' => $request->template_id,
            'type' => $request->type,
            'title' => $request->title,
            'form_data' => $request->form_data ?? [],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'সফলভাবে সংরক্ষণ করা হয়েছে!',
            'id' => $savedDoc->id
        ]);
    }

    public function show($id)
    {
        $savedDoc = SavedDocument::where('user_id', Auth::id())->findOrFail($id);

        if ($savedDoc->type === 'cv') {
            return redirect()->route('cv.fill', ['id' => $savedDoc->template_id, 'saved_id' => $savedDoc->id]);
        } else {
            return redirect()->route('document.fill', ['id' => $savedDoc->template_id, 'saved_id' => $savedDoc->id]);
        }
    }

    public function destroy($id)
    {
        $savedDoc = SavedDocument::where('user_id', Auth::id())->findOrFail($id);
        $savedDoc->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'ডিলিট করা হয়েছে!']);
        }

        return back()->with('success', 'ডকুমেন্টটি মুছে ফেলা হয়েছে।');
    }
}
