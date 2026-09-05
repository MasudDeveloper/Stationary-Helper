<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountingLesson;
use App\Models\AccountingStudentSubmission;
use App\Models\GrammarLesson;
use App\Models\GrammarSubmission;
use App\Models\MathLesson;
use App\Models\MathStudentSubmission;
use Illuminate\Support\Facades\Auth;

class LmsDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. Accounting Stats
        $accountingLessonsCount = AccountingLesson::where('is_active', true)->count();
        $accountingCompleted = AccountingStudentSubmission::where('user_id', $userId)
            ->where('is_correct', true)
            ->distinct('exercise_id')
            ->count();

        // 2. English Stats
        $englishLessonsCount = GrammarLesson::where('is_active', true)->count();
        $englishCompleted = GrammarSubmission::where('user_id', $userId)
            ->where('is_completed', true)
            ->count();

        // 3. Mathematics Stats
        $mathLessonsCount = MathLesson::where('is_active', true)->count();
        $mathCompleted = MathStudentSubmission::where('user_id', $userId)
            ->where('is_completed', true)
            ->count();

        // Overall stats
        $totalLessons = $accountingLessonsCount + $englishLessonsCount + $mathLessonsCount;
        $totalCompleted = $accountingCompleted + $englishCompleted + $mathCompleted;
        $progressPercent = $totalLessons > 0 ? round(($totalCompleted / $totalLessons) * 100) : 0;

        return view('lms.dashboard', compact(
            'accountingLessonsCount',
            'accountingCompleted',
            'englishLessonsCount',
            'englishCompleted',
            'mathLessonsCount',
            'mathCompleted',
            'totalLessons',
            'totalCompleted',
            'progressPercent'
        ));
    }
}
