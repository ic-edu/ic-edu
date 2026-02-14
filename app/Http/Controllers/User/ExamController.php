<?php

namespace App\Http\Controllers\User;

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::where('is_active', true)
            ->with(['exam_type'])
            ->latest()
            ->get();
        return view('exams.index', compact('exams'));
    }

    public function result(ExamAttempt $attempt)
    {
        if ($attempt->user_id !== Auth::id()) {
            abort(403, 'Access denied');
        }

        return view('exams.result', compact('attempt'));
    }

    public function start(Exam $exam)
    {
        $existingAttempt = ExamAttempt::where('user_id', Auth::id())
            ->where('exam_id', $exam->id)
            ->where('status', 'in_progress')
            ->first();

        if ($existingAttempt) {
            return redirect()->route('exams.simulation', $existingAttempt->id);
        }

        $newAttempt = ExamAttempt::create([
            'user_id' => Auth::id(),
            'exam_id' => $exam->id,
            'start_time' => now(),
            'status' => 'in_progress',
            'current_question_index' => 0,
            'answers' => []
        ]);

        return redirect()->route('exams.simulation', $newAttempt->id);
    }
}
