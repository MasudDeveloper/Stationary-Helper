<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MathLesson;
use App\Models\MathExercise;

class AdminMathController extends Controller
{
    public function index()
    {
        $lessons = MathLesson::withCount('exercises')->where('is_active', true)->orderBy('chapter_no')->get();
        return view('admin.math.index', compact('lessons'));
    }

    public function create()
    {
        return view('admin.math.edit');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'chapter_no' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data['is_active'] = $request->has('is_active');

        MathLesson::create($data);

        return redirect()->route('admin.math-lessons.index')
            ->with('success', 'গণিত অধ্যায় সফলভাবে তৈরি হয়েছে!');
    }

    public function edit($id)
    {
        $lesson = MathLesson::findOrFail($id);
        return view('admin.math.edit', compact('lesson'));
    }

    public function update(Request $request, $id)
    {
        $lesson = MathLesson::findOrFail($id);

        $data = $request->validate([
            'chapter_no' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data['is_active'] = $request->has('is_active');

        $lesson->update($data);

        return redirect()->route('admin.math-lessons.index')
            ->with('success', 'গণিত অধ্যায় আপডেট করা হয়েছে!');
    }

    public function destroy($id)
    {
        $lesson = MathLesson::findOrFail($id);
        $lesson->delete();

        return redirect()->route('admin.math-lessons.index')
            ->with('success', 'গণিত অধ্যায় মুছে ফেলা হয়েছে!');
    }

    public function exercises(Request $request, $id)
    {
        $lesson = MathLesson::findOrFail($id);
        $search = $request->get('search');

        $query = MathExercise::where('lesson_id', $lesson->id);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('question', 'like', "%{$search}%");
            });
        }

        $exercises = $query->orderBy('id')->paginate(20);

        return view('admin.math.exercises', compact('lesson', 'exercises', 'search'));
    }

    public function storeExercise(Request $request, $id)
    {
        $lesson = MathLesson::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'question' => 'nullable|string',
            'options' => 'nullable',
            'correct_answer' => 'nullable|string',
            'explanation' => 'nullable|string',
        ]);

        $options = $request->input('options');
        if (is_string($options)) {
            $decoded = json_decode($options, true);
            if ($decoded !== null) {
                $options = $decoded;
            }
        }

        MathExercise::create([
            'lesson_id' => $lesson->id,
            'title' => $request->title,
            'question' => $request->question ?? 'পরামিতিক প্রশ্ন',
            'options' => $options,
            'correct_answer' => $request->correct_answer ?? 'অটো সমাধান সক্রিয়',
            'explanation' => $request->explanation ?? 'ডাইনামিক সূত্র দ্বারা স্বয়ংক্রিয় সমাধান নির্ণয় করা হবে।',
        ]);

        return redirect()->route('admin.math-lessons.exercises', $lesson->id)
            ->with('success', 'প্রশ্ন সফলভাবে যোগ করা হয়েছে!');
    }

    public function updateExercise(Request $request, $id)
    {
        $exercise = MathExercise::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'question' => 'nullable|string',
            'options' => 'nullable',
            'correct_answer' => 'nullable|string',
            'explanation' => 'nullable|string',
        ]);

        $options = $request->input('options');
        if (is_string($options)) {
            $decoded = json_decode($options, true);
            if ($decoded !== null) {
                $options = $decoded;
            }
        }

        $exercise->update([
            'title' => $request->title,
            'question' => $request->question ?? $exercise->question,
            'options' => $options,
            'correct_answer' => $request->correct_answer ?? ($exercise->correct_answer ?? 'অটো সমাধান সক্রিয়'),
            'explanation' => $request->explanation ?? ($exercise->explanation ?? 'ডাইনামিক সূত্র দ্বারা স্বয়ংক্রিয় সমাধান নির্ণয় করা হবে।'),
        ]);

        return redirect()->route('admin.math-lessons.exercises', $exercise->lesson_id)
            ->with('success', "প্রশ্ন #{$exercise->id} সফলভাবে আপডেট করা হয়েছে!");
    }

    public function destroyExercise($id)
    {
        $exercise = MathExercise::findOrFail($id);
        $lessonId = $exercise->lesson_id;
        $exercise->delete();

        return redirect()->route('admin.math-lessons.exercises', $lessonId)
            ->with('success', 'প্রশ্ন মুছে ফেলা হয়েছে!');
    }
}
