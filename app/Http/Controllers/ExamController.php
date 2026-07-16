<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\ExamParticipant;
use App\Models\ExamSubmission;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    // Ensure only authenticated users manage exams, public for participating
    public function __construct()
    {
        $this->middleware('auth')->except(['participate', 'submitExam']);
    }

    public function index()
    {
        $exams = Exam::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('exams.index', compact('exams'));
    }

    public function create(Request $request)
    {
        $type = $request->query('type', 'mcq');
        return view('exams.create', compact('type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subject' => 'nullable|string',
            'class' => 'nullable|string',
            'type' => 'required|in:mcq,cq',
            'duration_minutes' => 'required|integer|min:1',
            'questions' => 'required|json',
        ]);

        $exam = Exam::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'subject' => $request->subject,
            'class' => $request->class,
            'type' => $request->type,
            'duration_minutes' => $request->duration_minutes,
            'status' => true,
        ]);

        $questionsData = json_decode($request->questions, true);

        foreach ($questionsData as $qData) {
            if ($request->type == 'mcq') {
                ExamQuestion::create([
                    'exam_id' => $exam->id,
                    'question_text' => $qData['text'],
                    'options' => $qData['options'], // json
                    'correct_answer' => $qData['correct_answer'] ?? null,
                    'marks' => $qData['marks'] ?? 1,
                ]);
            } else {
                ExamQuestion::create([
                    'exam_id' => $exam->id,
                    'question_text' => $qData['stem'],
                    'options' => [
                        'a' => $qData['a'],
                        'b' => $qData['b'],
                        'c' => $qData['c'],
                        'd' => $qData['d'],
                    ], // Storing CQ parts in options column for simplicity
                    'marks' => 10,
                ]);
            }
        }

        return response()->json(['success' => true, 'redirect' => route('exams.index')]);
    }

    public function show($id)
    {
        $exam = Exam::where('user_id', Auth::id())->with(['questions', 'participants', 'submissions'])->findOrFail($id);
        return view('exams.show', compact('exam'));
    }

    public function participate($id)
    {
        $exam = Exam::with('questions')->findOrFail($id);
        if (!$exam->status) {
            abort(403, 'This exam is currently closed.');
        }
        return view('exams.participate', compact('exam'));
    }

    public function submitExam(Request $request, $id)
    {
        $exam = Exam::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'roll_no' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'answers' => 'required|array', // key: question_id, value: answer
        ]);

        // Create participant
        $participant = ExamParticipant::create([
            'exam_id' => $exam->id,
            'name' => $request->name,
            'roll_no' => $request->roll_no,
            'phone' => $request->phone,
        ]);

        // Evaluate score (For MCQ)
        $totalScore = 0;
        $status = 'pending';

        if ($exam->type == 'mcq') {
            $status = 'graded';
            foreach ($exam->questions as $question) {
                $qId = $question->id;
                if (isset($request->answers[$qId]) && $request->answers[$qId] == $question->correct_answer) {
                    $totalScore += $question->marks;
                }
            }
        }

        // Save submission
        $submission = ExamSubmission::create([
            'exam_participant_id' => $participant->id,
            'exam_id' => $exam->id,
            'answers' => $request->answers,
            'total_score' => $totalScore,
            'status' => $status,
        ]);

        return redirect()->route('exams.results', $submission->id)->with('success', 'Exam submitted successfully!');
    }

    public function results($submission_id)
    {
        $submission = ExamSubmission::with(['participant', 'exam.questions'])->findOrFail($submission_id);
        return view('exams.results', compact('submission'));
    }
    
    public function destroy($id)
    {
        $exam = Exam::where('user_id', Auth::id())->findOrFail($id);
        $exam->delete();
        return back()->with('success', 'Exam deleted successfully.');
    }
}
