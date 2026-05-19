<?php

namespace App\Http\Controllers\User;

use App\Models\Exam;
use App\Models\ExamEnrollment;
use App\Enums\ExamAttemptStatus;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::where('is_active', true)
            ->where('is_public', true)
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

        // If already finished or graded, block
        $finishedAttempt = \App\Models\ExamAttempt::where('user_id', $userId)
            ->where('exam_id', $exam->id)
            ->whereIn('status', [ExamAttemptStatus::FINISHED->value, ExamAttemptStatus::GRADED->value])
            ->first();

        if ($finishedAttempt) {
            return redirect()->route('test_taker.exam.my_exams')->with('error', 'Ujian ini sudah selesai.');
        }

        // Resume ongoing
        $existingAttempt = \App\Models\ExamAttempt::where('user_id', $userId)
            ->where('exam_id', $exam->id)
            ->where('status', ExamAttemptStatus::ONGOING->value)
            ->first();

        if ($existingAttempt) {
            return redirect()->route('test_taker.exam.attempt', ['attempt' => $existingAttempt->id]);
        }

        // Create new attempt
        $newAttempt = \App\Models\ExamAttempt::create([
            'user_id'  => $userId,
            'exam_id'  => $exam->id,
            'started_at' => now(),
            'status'   => ExamAttemptStatus::ONGOING->value,
        ]);

        return redirect()->route('test_taker.exam.attempt', ['attempt' => $newAttempt->id]);
    }

    public function showResult(\App\Models\ExamAttempt $attempt)
    {
        // Pastikan hanya pemilik attempt yang bisa melihat hasil
        if ($attempt->user_id !== Auth::id()) {
            abort(403);
        }

        // Tampilkan hanya jika sudah dinilai
        if ($attempt->status !== ExamAttemptStatus::GRADED->value) {
            return redirect()->route('test_taker.exam.my_exams')->with('error', 'Ujian belum selesai dinilai.');
        }

        return view('test_taker.exams.result', compact('attempt'));
    }

    public function scoreReport(\App\Models\ExamAttempt $attempt, \App\Services\ScoreReportService $service)
    {
        if ($attempt->user_id !== Auth::id()) {
            abort(403);
        }

        if ($attempt->status !== ExamAttemptStatus::GRADED->value) {
            return redirect()->route('test_taker.exam.my_exams')->with('error', 'Score Report hanya tersedia setelah ujian selesai dinilai.');
        }

        $reportData = $service->generateData($attempt);
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('test_taker.exams.score_report', $reportData);
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download('Score_Report_' . str_replace(' ', '_', $attempt->exam->title) . '.pdf');
    }
}
