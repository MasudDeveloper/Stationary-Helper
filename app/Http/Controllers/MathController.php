<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MathLesson;
use App\Models\MathStudentSubmission;
use Illuminate\Support\Facades\Auth;

class MathController extends Controller
{
    public function index()
    {
        $lessons = MathLesson::with('exercises')->where('is_active', true)->orderBy('chapter_no')->get();
        $submissions = MathStudentSubmission::where('user_id', Auth::id())
            ->pluck('score', 'lesson_id')
            ->toArray();

        return view('lms.math.index', compact('lessons', 'submissions'));
    }

    public function show($id)
    {
        $lesson = MathLesson::with('exercises')->findOrFail($id);
        
        if ($lesson->chapter_no === 1) {
            $customExercises = $lesson->exercises;
            return view('lms.math.arithmetic_creative', compact('lesson', 'customExercises'));
        }

        if ($lesson->chapter_no === 17) {
            return view('lms.math.porisonkhan', compact('lesson'));
        }

        if ($lesson->chapter_no === 2) {
            $customExercises = $lesson->exercises;
            return view('lms.math.set_function', compact('lesson', 'customExercises'));
        }

        if ($lesson->chapter_no === 3) {
            $customExercises = $lesson->exercises;
            return view('lms.math.algebra_creative', compact('lesson', 'customExercises'));
        }

        if (in_array($lesson->chapter_no, [6, 7, 8, 16])) {
            $customExercises = $lesson->exercises;
            return view('lms.math.geometry_calc', compact('lesson', 'customExercises'));
        }

        return view('lms.math.show', compact('lesson'));
    }
}
