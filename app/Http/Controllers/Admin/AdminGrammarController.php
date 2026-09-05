<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GrammarLesson;
use App\Models\GrammarExercise;

class AdminGrammarController extends Controller
{
    public function index()
    {
        $lessons = GrammarLesson::withCount('exercises')->orderBy('level_no')->get();
        return view('admin.grammar.index', compact('lessons'));
    }

    public function create()
    {
        return view('admin.grammar.edit');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'level_no' => 'required|integer',
            'level_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'rule' => 'nullable|string',
            'formula' => 'nullable|string',
            'recognition' => 'nullable|string',
            'step_1' => 'nullable|string',
            'step_2' => 'nullable|string',
            'step_3' => 'nullable|string',
            'example' => 'nullable|string',
            'common_mistake' => 'nullable|string',
            'exam_answer_pattern' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data['is_active'] = $request->has('is_active');

        GrammarLesson::create($data);

        return redirect()->route('admin.grammar-lessons.index')
            ->with('success', 'Grammar level created successfully!');
    }

    public function edit($id)
    {
        $lesson = GrammarLesson::findOrFail($id);
        return view('admin.grammar.edit', compact('lesson'));
    }

    public function update(Request $request, $id)
    {
        $lesson = GrammarLesson::findOrFail($id);

        $data = $request->validate([
            'level_no' => 'required|integer',
            'level_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'rule' => 'nullable|string',
            'formula' => 'nullable|string',
            'recognition' => 'nullable|string',
            'step_1' => 'nullable|string',
            'step_2' => 'nullable|string',
            'step_3' => 'nullable|string',
            'example' => 'nullable|string',
            'common_mistake' => 'nullable|string',
            'exam_answer_pattern' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data['is_active'] = $request->has('is_active');

        $lesson->update($data);

        return redirect()->route('admin.grammar-lessons.index')
            ->with('success', 'Grammar level updated successfully!');
    }

    public function destroy($id)
    {
        $lesson = GrammarLesson::findOrFail($id);
        $lesson->delete();

        return redirect()->route('admin.grammar-lessons.index')
            ->with('success', 'Grammar level deleted successfully!');
    }

    public function exercises($id)
    {
        $lesson = GrammarLesson::with('exercises')->findOrFail($id);
        return view('admin.grammar.exercises', compact('lesson'));
    }

    public function storeExercise(Request $request, $id)
    {
        $lesson = GrammarLesson::findOrFail($id);

        $request->validate([
            'question' => 'required|string',
            'options' => 'required|array|min:2',
            'correct_answer' => 'required|string',
            'explanation' => 'nullable|string',
        ]);

        GrammarExercise::create([
            'lesson_id' => $lesson->id,
            'question' => $request->question,
            'options' => $request->options,
            'correct_answer' => $request->correct_answer,
            'explanation' => $request->explanation,
        ]);

        return redirect()->route('admin.grammar-lessons.exercises', $lesson->id)
            ->with('success', 'Practice question added successfully!');
    }

    public function destroyExercise($id)
    {
        $exercise = GrammarExercise::findOrFail($id);
        $lessonId = $exercise->lesson_id;
        $exercise->delete();

        return redirect()->route('admin.grammar-lessons.exercises', $lessonId)
            ->with('success', 'Practice question deleted successfully!');
    }
}
