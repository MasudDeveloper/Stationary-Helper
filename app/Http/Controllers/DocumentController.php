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

    public function toggleFavorite($id)
    {
        $template = DocumentTemplate::findOrFail($id);
        $user = Auth::user();
        
        if ($user->favoriteDocuments()->where('document_template_id', $id)->exists()) {
            $user->favoriteDocuments()->detach($id);
            return back()->with('success', 'ডকুমেন্টটি ফেভারিট থেকে সরানো হয়েছে।');
        } else {
            $user->favoriteDocuments()->attach($id);
            return back()->with('success', 'ডকুমেন্টটি ফেভারিটে যুক্ত করা হয়েছে।');
        }
    }

    public function favorites()
    {
        $templates = Auth::user()->favoriteDocuments()->where('is_active', true)->with('category')->get();
        return view('document.favorites', compact('templates'));
    }

    public function deductCredit($id)
    {
        $template = DocumentTemplate::findOrFail($id);
        $user = Auth::user();
        
        $cost = $template->credit_cost ?? 5; // Default to 5 if null
        
        if ($user->credits < $cost) {
            return response()->json([
                'success' => false,
                'message' => 'পর্যাপ্ত ক্রেডিট নেই! আপনার অ্যাকাউন্টে আরো ক্রেডিট যোগ করুন।'
            ], 403);
        }
        
        $user->credits -= $cost;
        $user->save();
        
        // Also log this transaction (optional, but recommended if there is a transaction system)
        
        return response()->json([
            'success' => true,
            'message' => 'ক্রেডিট কাটা হয়েছে। প্রিন্টিং শুরু হচ্ছে...',
            'remaining_credits' => $user->credits
        ]);
    }
}
