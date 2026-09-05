<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GrammarLesson;
use App\Models\GrammarExercise;
use App\Models\GrammarSubmission;
use Illuminate\Support\Facades\Auth;

class GrammarController extends Controller
{
    public function index()
    {
        $lessons = GrammarLesson::with('exercises')
            ->where('is_active', true)
            ->orderBy('level_no')
            ->get();

        $submissions = GrammarSubmission::where('user_id', Auth::id())
            ->get()
            ->keyBy('lesson_id');

        return view('grammar.index', compact('lessons', 'submissions'));
    }

    public function show($id)
    {
        $lesson = GrammarLesson::with('exercises')->findOrFail($id);
        $submission = GrammarSubmission::where('user_id', Auth::id())
            ->where('lesson_id', $lesson->id)
            ->first();

        return view('grammar.show', compact('lesson', 'submission'));
    }

    public function submitQuiz(Request $request, $id)
    {
        $lesson = GrammarLesson::with('exercises')->findOrFail($id);
        $exercises = $lesson->exercises;

        $request->validate([
            'answers' => 'required|array',
        ]);

        $studentAnswers = $request->answers; // Format: [exercise_id => selected_option_text]
        $correctCount = 0;
        $total = $exercises->count();
        $explanations = [];

        foreach ($exercises as $exercise) {
            $submitted = $studentAnswers[$exercise->id] ?? null;
            $isCorrect = ($submitted === $exercise->correct_answer);

            if ($isCorrect) {
                $correctCount++;
            }

            $explanations[$exercise->id] = [
                'is_correct' => $isCorrect,
                'submitted' => $submitted,
                'correct' => $exercise->correct_answer,
                'explanation' => $exercise->explanation,
            ];
        }

        $score = $total > 0 ? round(($correctCount / $total) * 100, 2) : 0;

        // Save submission record
        GrammarSubmission::updateOrCreate(
            ['user_id' => Auth::id(), 'lesson_id' => $lesson->id],
            [
                'score' => $score,
                'is_completed' => true,
                'answers' => $studentAnswers,
            ]
        );

        return response()->json([
            'success' => true,
            'score' => $score,
            'correct_count' => $correctCount,
            'total' => $total,
            'results' => $explanations,
        ]);
    }

    public function checker()
    {
        return view('grammar.checker');
    }

    public function tenseHub()
    {
        return view('grammar.tense');
    }

    public function narrationHub()
    {
        return view('grammar.narration');
    }

    public function rightOfVerbHub()
    {
        return view('grammar.right_of_verb');
    }

    public function rightFormOfVerbsSolver()
    {
        return view('grammar.right_form_of_verbs');
    }

    public function narrationSolver()
    {
        return view('grammar.narration_solver');
    }

    public function partsOfSpeechHub()
    {
        return view('grammar.parts_of_speech');
    }

    public function articlesHub()
    {
        return view('grammar.articles');
    }
}
