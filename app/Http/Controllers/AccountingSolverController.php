<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountingLesson;
use App\Models\AccountingExercise;
use App\Models\AccountingStudentSubmission;
use Illuminate\Support\Facades\Auth;

class AccountingSolverController extends Controller
{
    public function index()

    {
        $lessons = AccountingLesson::with('exercises')->where('is_active', true)->orderBy('chapter_no')->get();
        
        $submissions = AccountingStudentSubmission::where('user_id', Auth::id())
            ->pluck('is_correct', 'exercise_id')
            ->toArray();

        return view('accounting.solver.index', compact('lessons', 'submissions'));
    }

    public function show($id)
    {
        $exercise = AccountingExercise::with('lesson')->findOrFail($id);
        $submission = AccountingStudentSubmission::where('user_id', Auth::id())
            ->where('exercise_id', $exercise->id)
            ->first();

        return view('accounting.solver.show', compact('exercise', 'submission'));
    }

    public function verify(Request $request, $id)
    {
        $exercise = AccountingExercise::findOrFail($id);
        $correctSchema = $exercise->answer_schema; // Schema of correct answers

        $request->validate([
            'entries' => 'required|array',
        ]);

        $studentEntries = $request->entries;
        $feedback = [];
        $isCorrect = true;
        $score = 100.00;
        
        // Loop correct schema and match student input
        foreach ($correctSchema as $index => $correct) {
            $student = $studentEntries[$index] ?? null;
            if (!$student) {
                $isCorrect = false;
                $feedback[] = [
                    'row' => $index + 1,
                    'error' => "লেনদেন এন্ট্রি করা হয়নি।"
                ];
                continue;
            }

            // Check Account name
            $cleanCorrectAccount = trim($correct['account']);
            $cleanStudentAccount = trim($student['account']);
            if (mb_strtolower($cleanCorrectAccount) !== mb_strtolower($cleanStudentAccount)) {
                $isCorrect = false;
                $feedback[] = [
                    'row' => $index + 1,
                    'field' => 'account',
                    'error' => "হিসাবের নাম ভুল হয়েছে। সঠিক: {$correct['account']}"
                ];
            }

            // Check Classification/Nature
            if ($correct['nature'] !== $student['nature']) {
                $isCorrect = false;
                $feedback[] = [
                    'row' => $index + 1,
                    'field' => 'nature',
                    'error' => "হিসাবের প্রকৃতি ভুল হয়েছে। সঠিক: " . $this->natureName($correct['nature'])
                ];
            }

            // Check Type (Dr/Cr)
            if ($correct['type'] !== $student['type']) {
                $isCorrect = false;
                $feedback[] = [
                    'row' => $index + 1,
                    'field' => 'type',
                    'error' => "ডেবিট/ক্রেডিট প্রকৃতি ভুল হয়েছে। সঠিক: " . ($correct['type'] === 'Dr' ? 'ডেবিট (Dr)' : 'ক্রেডিট (Cr)')
                ];
            }

            // Check Amount
            if (floatval($correct['amount']) !== floatval($student['amount'])) {
                $isCorrect = false;
                $feedback[] = [
                    'row' => $index + 1,
                    'field' => 'amount',
                    'error' => "টাকার পরিমাণ ভুল হয়েছে। সঠিক: {$correct['amount']} ৳"
                ];
            }
        }

        if (!$isCorrect) {
            $score = max(0, 100 - (count($feedback) * 15));
        }

        // Save submission
        AccountingStudentSubmission::updateOrCreate(
            ['user_id' => Auth::id(), 'exercise_id' => $exercise->id],
            [
                'submitted_answers' => $studentEntries,
                'is_correct' => $isCorrect,
                'score' => $score,
                'feedback' => $feedback
            ]
        );

        return response()->json([
            'success' => true,
            'is_correct' => $isCorrect,
            'score' => $score,
            'feedback' => $feedback
        ]);
    }

    private function natureName($nature)
    {
        $map = [
            'Asset' => 'সম্পদ',
            'Liability' => 'দায়',
            'Equity' => 'مালিকানাস্বত্ব (মালিকানাস্বত্ব)',
            'Revenue' => 'আয়',
            'Expense' => 'ব্যয়'
        ];
        return $map[$nature] ?? $nature;
    }
}
