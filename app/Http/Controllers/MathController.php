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
        $chapNo = (int) $lesson->chapter_no;
        $customExercises = $lesson->exercises;
        
        if ($chapNo === 1) {
            return view('lms.math.arithmetic_creative', compact('lesson', 'customExercises'));
        }

        if ($chapNo === 2) {
            return view('lms.math.set_function', compact('lesson', 'customExercises'));
        }

        if (in_array($chapNo, [3, 4, 5, 11, 12, 13])) {
            return view('lms.math.algebra_creative', compact('lesson', 'customExercises'));
        }

        if (in_array($chapNo, [6, 7, 8, 9, 10, 14, 15, 16])) {
            return view('lms.math.geometry_calc', compact('lesson', 'customExercises'));
        }

        if ($chapNo === 17) {
            return view('lms.math.porisonkhan', compact('lesson'));
        }

        return view('lms.math.show', compact('lesson'));
    }
}
