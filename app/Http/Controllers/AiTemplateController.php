<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AiTemplate;
use Illuminate\Support\Facades\Auth;

class AiTemplateController extends Controller
{
    // Seed default templates if database is empty
    private function seedDefaults()
    {
        if (AiTemplate::count() == 0) {
            $defaults = [
                [
                    'title' => 'Argentina Poster with background',
                    'category' => 'world_cup',
                    'thumbnail_path' => 'https://image.pollinations.ai/prompt/Argentina%20football%20team%20poster%20empty%20jersey%20background%20stadium%20glow?width=800&height=1000&nologo=true',
                    'prompt' => 'Argentina football poster with customizable jersey',
                    'inputs_schema' => ['name' => true, 'number' => true, 'photo' => true],
                    'overlay_settings' => [
                        'photo' => ['x' => 150, 'y' => 200, 'w' => 180, 'h' => 220],
                        'name' => ['x' => 200, 'y' => 500, 'size' => 36, 'color' => '#ffffff'],
                        'number' => ['x' => 200, 'y' => 420, 'size' => 72, 'color' => '#f59e0b']
                    ],
                    'is_premium' => true,
                    'credits_cost' => 5.00
                ],
                [
                    'title' => 'ব্রাজিল ফুটবল সুপারস্টার পোস্টার',
                    'category' => 'world_cup',
                    'thumbnail_path' => 'https://image.pollinations.ai/prompt/Brazil%20football%20team%20poster%20empty%20yellow%20jersey%20background%20stadium%20glow?width=800&height=1000&nologo=true',
                    'prompt' => 'Brazil football poster with customizable jersey',
                    'inputs_schema' => ['name' => true, 'number' => true, 'photo' => true],
                    'overlay_settings' => [
                        'photo' => ['x' => 150, 'y' => 200, 'w' => 180, 'h' => 220],
                        'name' => ['x' => 200, 'y' => 500, 'size' => 36, 'color' => '#ffffff'],
                        'number' => ['x' => 200, 'y' => 420, 'size' => 72, 'color' => '#10b981']
                    ],
                    'is_premium' => true,
                    'credits_cost' => 5.00
                ],
                [
                    'title' => 'Team Germany Flag & Fire',
                    'category' => 'world_cup',
                    'thumbnail_path' => 'https://image.pollinations.ai/prompt/Germany%20football%20team%20poster%20empty%20white%20jersey%20background%20fire%20glow?width=800&height=1000&nologo=true',
                    'prompt' => 'Germany football poster flag and fire',
                    'inputs_schema' => ['name' => true, 'number' => true, 'photo' => true],
                    'overlay_settings' => [
                        'photo' => ['x' => 150, 'y' => 200, 'w' => 180, 'h' => 220],
                        'name' => ['x' => 200, 'y' => 500, 'size' => 36, 'color' => '#ffffff'],
                        'number' => ['x' => 200, 'y' => 420, 'size' => 72, 'color' => '#ef4444']
                    ],
                    'is_premium' => true,
                    'credits_cost' => 5.00
                ],
                [
                    'title' => 'পুরানো ছবি পুনরুদ্ধার (Photo Restore)',
                    'category' => 'restore',
                    'thumbnail_path' => 'https://image.pollinations.ai/prompt/Old%20vintage%20photo%20side%20by%20side%20restored%20crisp%20photo%20frame?width=800&height=600&nologo=true',
                    'prompt' => 'Old photo restore template',
                    'inputs_schema' => ['photo' => true],
                    'overlay_settings' => [
                        'photo' => ['x' => 50, 'y' => 50, 'w' => 700, 'h' => 500]
                    ],
                    'is_premium' => false,
                    'credits_cost' => 0.00
                ],
                [
                    'title' => 'রাজকীয় বর-কনের ছবি (Royal Bride)',
                    'category' => 'creative',
                    'thumbnail_path' => 'https://image.pollinations.ai/prompt/Royal%20indian%20wedding%20portrait%20empty%20face%20glow?width=800&height=1000&nologo=true',
                    'prompt' => 'Royal bride groom customizable face template',
                    'inputs_schema' => ['photo' => true],
                    'overlay_settings' => [
                        'photo' => ['x' => 200, 'y' => 150, 'w' => 200, 'h' => 250]
                    ],
                    'is_premium' => true,
                    'credits_cost' => 5.00
                ]
            ];

            foreach ($defaults as $tmpl) {
                AiTemplate::create($tmpl);
            }
        }
    }

    public function index(Request $request)
    {
        $this->seedDefaults();

        $query = AiTemplate::query();

        // Filter by category
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Search title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $templates = $query->orderBy('created_at', 'desc')->get();

        return view('design.ai_templates', compact('templates'));
    }

    public function customize($id)
    {
        $template = AiTemplate::findOrFail($id);
        return view('design.ai_template_customize', compact('template'));
    }

    public function process(Request $request, $id)
    {
        $template = AiTemplate::findOrFail($id);
        $user = Auth::user();

        // Calculate credit cost
        $cost = $template->is_premium ? ($user->role === 'business' ? 1.00 : $template->credits_cost) : 0.00;

        if ($user->credits < $cost) {
            return response()->json(['error' => 'আপনার পর্যাপ্ত ক্রেডিট নেই। অনুগ্রহ করে ক্রেডিট রিচার্জ করুন।'], 403);
        }

        // Deduct credits
        if ($cost > 0) {
            $user->credits -= $cost;
            $user->save();
        }

        return response()->json([
            'success' => true,
            'remaining_credits' => $user->credits,
            'cost' => $cost
        ]);
    }

    // Admin management
    public function adminIndex()
    {
        $templates = AiTemplate::orderBy('created_at', 'desc')->get();
        return view('admin.ai_templates', compact('templates'));
    }

    public function adminStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_premium' => 'nullable|boolean',
            'credits_cost' => 'nullable|numeric|min:0',
        ]);

        $imagePath = '';
        if ($request->hasFile('thumbnail')) {
            $imageName = time() . '.' . $request->thumbnail->extension();
            $request->thumbnail->move(public_path('uploads/templates'), $imageName);
            $imagePath = asset('uploads/templates/' . $imageName);
        }

        // Build inputs schema
        $inputs = [
            'name' => $request->has('field_name'),
            'number' => $request->has('field_number'),
            'photo' => $request->has('field_photo'),
        ];

        // Build overlay settings
        $overlay = [
            'photo' => [
                'x' => (int) $request->input('photo_x', 150),
                'y' => (int) $request->input('photo_y', 200),
                'w' => (int) $request->input('photo_w', 180),
                'h' => (int) $request->input('photo_h', 220),
            ],
            'name' => [
                'x' => (int) $request->input('name_x', 200),
                'y' => (int) $request->input('name_y', 500),
                'size' => (int) $request->input('name_size', 36),
                'color' => $request->input('name_color', '#ffffff'),
            ],
            'number' => [
                'x' => (int) $request->input('number_x', 200),
                'y' => (int) $request->input('number_y', 420),
                'size' => (int) $request->input('number_size', 72),
                'color' => $request->input('number_color', '#f59e0b'),
            ]
        ];

        AiTemplate::create([
            'title' => $request->title,
            'category' => $request->category,
            'thumbnail_path' => $imagePath,
            'prompt' => $request->prompt ?? '',
            'inputs_schema' => $inputs,
            'overlay_settings' => $overlay,
            'is_premium' => $request->has('is_premium'),
            'credits_cost' => $request->input('credits_cost', 0.00),
        ]);

        return back()->with('success', 'নতুন এআই টেমপ্লেট সফলভাবে যোগ করা হয়েছে।');
    }

    public function adminDestroy($id)
    {
        $template = AiTemplate::findOrFail($id);
        // Delete image file if local
        if (str_contains($template->thumbnail_path, 'uploads/templates')) {
            $localPath = public_path(str_replace(asset(''), '', $template->thumbnail_path));
            if (file_exists($localPath)) {
                unlink($localPath);
            }
        }
        $template->delete();
        return back()->with('success', 'টেমপ্লেট মুছে ফেলা হয়েছে।');
    }
}
