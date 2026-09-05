<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountingLesson;
use App\Models\AccountingExercise;

class AdminAccountingSolverController extends Controller
{
    public function index()
    {
        $lessons = AccountingLesson::with('exercises')->orderBy('chapter_no')->get();
        return view('admin.accounting_solver.index', compact('lessons'));
    }

    public function create()
    {
        $lessons = AccountingLesson::orderBy('chapter_no')->get();
        return view('admin.accounting_solver.create', compact('lessons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:accounting_lessons,id',
            'title' => 'required|string|max:255',
            'stimulus' => 'required|string',
            'answer_schema' => 'required|json',
        ]);

        AccountingExercise::create([
            'lesson_id' => $request->lesson_id,
            'title' => $request->title,
            'stimulus' => $request->stimulus,
            'answer_schema' => json_decode($request->answer_schema, true),
        ]);

        return redirect()->route('admin.accounting-solver.index')->with('success', 'অনুশীলনী সফলভাবে তৈরি করা হয়েছে।');
    }

    public function edit($id)
    {
        $exercise = AccountingExercise::findOrFail($id);
        $lessons = AccountingLesson::orderBy('chapter_no')->get();
        return view('admin.accounting_solver.edit', compact('exercise', 'lessons'));
    }

    public function update(Request $request, $id)
    {
        $exercise = AccountingExercise::findOrFail($id);
        $request->validate([
            'lesson_id' => 'required|exists:accounting_lessons,id',
            'title' => 'required|string|max:255',
            'stimulus' => 'required|string',
            'answer_schema' => 'required|json',
        ]);

        $exercise->update([
            'lesson_id' => $request->lesson_id,
            'title' => $request->title,
            'stimulus' => $request->stimulus,
            'answer_schema' => json_decode($request->answer_schema, true),
        ]);

        return redirect()->route('admin.accounting-solver.index')->with('success', 'অনুশীলনী সফলভাবে আপডেট করা হয়েছে।');
    }

    public function destroy($id)
    {
        $exercise = AccountingExercise::findOrFail($id);
        $exercise->delete();
        return redirect()->route('admin.accounting-solver.index')->with('success', 'অনুশীলনী মুছে ফেলা হয়েছে।');
    }
}
