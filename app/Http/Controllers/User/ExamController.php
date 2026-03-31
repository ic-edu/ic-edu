<?php

namespace App\Http\Controllers\User;

use App\Models\Exam;
use App\Models\ExamEnrollment;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::where('is_active', true)
            ->with('examType')
            ->latest()
            ->get();
        return view('test_taker.exams.index', compact('exams'));
    }

    public function myExams()
    {
        $userId = Auth::id();
        $enrollments = ExamEnrollment::where('user_id', $userId)
            ->with(['exam.examType', 'exam.attempts' => function($q) use($userId) {
                $q->where('user_id', $userId)->latest();
            }])
            ->latest('enrolled_at')
            ->get();

        return view('test_taker.exams.my_exams', compact('enrollments'));
    }

    public function startExam(Exam $exam)
    {
        $userId = Auth::id();

        // Check if enrolled
        $enrollment = ExamEnrollment::where('user_id', $userId)->where('exam_id', $exam->id)->first();
        if (!$enrollment) {
            return redirect()->route('test_taker.exam.index')->with('error', 'Anda belum terdaftar.');
        }

        // If already finished, block
        $finishedAttempt = \App\Models\ExamAttempt::where('user_id', $userId)
            ->where('exam_id', $exam->id)
            ->where('status', 'finished')
            ->first();

        if ($finishedAttempt) {
            return redirect()->route('test_taker.exam.my_exams')->with('error', 'Ujian ini sudah selesai.');
        }

        // Resume ongoing
        $existingAttempt = \App\Models\ExamAttempt::where('user_id', $userId)
            ->where('exam_id', $exam->id)
            ->where('status', 'ongoing')
            ->first();

        if ($existingAttempt) {
            return redirect()->route('test_taker.exam.attempt', ['attempt' => $existingAttempt->id]);
        }

        // Create new attempt
        $newAttempt = \App\Models\ExamAttempt::create([
            'user_id' => $userId,
            'exam_id' => $exam->id,
            'started_at' => now(),
            'status' => 'ongoing',
        ]);

        return redirect()->route('test_taker.exam.attempt', ['attempt' => $newAttempt->id]);
    }
}
