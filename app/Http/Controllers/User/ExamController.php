<?php

namespace App\Http\Controllers\User;

use App\Models\Exam;
use App\Models\Section;
use App\Models\ExamEnrollment;
use App\Models\AttemptAnswer;
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

        // Create new attempt within transaction to safely deduct tokens
        try {
            $newAttempt = \Illuminate\Support\Facades\DB::transaction(function () use ($userId, $exam) {
                if ($exam->tokens_required > 0) {
                    $user = \App\Models\User::lockForUpdate()->find($userId);
                    
                    if ($user->tokens < $exam->tokens_required) {
                        throw new \Exception('INSUFFICIENT_TOKENS');
                    }
                    
                    $user->decrement('tokens', $exam->tokens_required);
                    
                    \App\Models\TokenTransaction::create([
                        'user_id' => $user->id,
                        'type' => 'deduction',
                        'amount' => -$exam->tokens_required,
                        'description' => "Mulai ujian: {$exam->title}",
                        'reference_id' => 'EXM-' . strtoupper(\Illuminate\Support\Str::random(8)),
                        'status' => 'completed',
                    ]);
                }

                return \App\Models\ExamAttempt::create([
                    'user_id'  => $userId,
                    'exam_id'  => $exam->id,
                    'started_at' => now(),
                    'status'   => ExamAttemptStatus::ONGOING->value,
                ]);
            });
            
            return redirect()->route('test_taker.exam.attempt', ['attempt' => $newAttempt->id]);
            
        } catch (\Exception $e) {
            if ($e->getMessage() === 'INSUFFICIENT_TOKENS') {
                return redirect()->route('test_taker.exam.my_exams')->with('error', 'Token tidak cukup untuk mengikuti ujian ini. Silakan top up token Anda.');
            }
            \Illuminate\Support\Facades\Log::error('Exam start failed', ['error' => $e->getMessage()]);
            return redirect()->route('test_taker.exam.my_exams')->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi nanti.');
        }
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

    public function sectionReview(\App\Models\ExamAttempt $attempt, Section $section)
    {
        if ($attempt->user_id !== Auth::id()) abort(403);

        if ($attempt->status !== ExamAttemptStatus::GRADED->value) {
            return redirect()->route('test_taker.exam.result', $attempt->id)
                ->with('error', 'Ujian belum selesai dinilai.');
        }

        if ($section->exam_id !== $attempt->exam_id) abort(404);

        $section->load([
            'subsections'                                         => fn($q) => $q->orderBy('order_position'),
            'subsections.questionGroups'                          => fn($q) => $q->orderBy('order_position'),
            'subsections.questionGroups.questions'                => fn($q) => $q->orderBy('order_position'),
            'subsections.questionGroups.questions.options'        => fn($q) => $q->orderBy('id'),
        ]);

        $allQuestionIds = $section->subsections
            ->flatMap(fn($s) => $s->questionGroups)
            ->flatMap(fn($g) => $g->questions)
            ->pluck('id');

        $answers = AttemptAnswer::where('exam_attempt_id', $attempt->id)
            ->whereIn('question_id', $allQuestionIds)
            ->with('selectedOption')
            ->get()
            ->keyBy('question_id');

        // Build flat question list for sidebar
        $flatQuestions = collect();
        $num = 0;
        foreach ($section->subsections as $sub) {
            foreach ($sub->questionGroups as $group) {
                foreach ($group->questions as $q) {
                    $num++;
                    $ans = $answers->get($q->id);
                    $flatQuestions->push([
                        'id'     => $q->id,
                        'number' => $num,
                        'type'   => $q->type,
                        'points' => $q->points,
                        'answer' => $ans,
                    ]);
                }
            }
        }

        return view('test_taker.exams.section_review', compact(
            'attempt', 'section', 'answers', 'flatQuestions'
        ));
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
