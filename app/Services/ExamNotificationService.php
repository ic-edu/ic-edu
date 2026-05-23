<?php

namespace App\Services;

use App\Mail\ExamGradedMail;
use App\Mail\ExamNeedsGradingMail;
use App\Models\ExamAttempt;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ExamNotificationService
{
    /**
     * Notify a test taker that their exam has been fully graded.
     *
     * Call this from the examiner grading flow after all scores are saved.
     *
     * Usage:
     *   app(ExamNotificationService::class)->notifyTestTakerGraded($attempt);
     */
    public function notifyTestTakerGraded(ExamAttempt $attempt): void
    {
        $attempt->loadMissing(['user', 'exam.examType']);

        $recipient = $attempt->user;

        if (!$recipient || !$recipient->email) {
            Log::warning("[ExamNotification] Cannot send graded email: user or email missing.", [
                'attempt_id' => $attempt->id,
            ]);
            return;
        }

        try {
            Mail::to($recipient->email, $recipient->name)
                ->send(new ExamGradedMail($attempt));

            Log::info("[ExamNotification] Graded email sent.", [
                'attempt_id' => $attempt->id,
                'to'         => $recipient->email,
            ]);
        } catch (\Throwable $e) {
            Log::error("[ExamNotification] Failed to send graded email.", [
                'attempt_id' => $attempt->id,
                'error'      => $e->getMessage(),
            ]);
        }
    }

    /**
     * Notify an examiner that a test taker has finished an exam and needs grading.
     *
     * Call this from the exam finish flow (finishExam()) after the attempt is saved.
     *
     * Usage:
     *   app(ExamNotificationService::class)->notifyExaminerNeedsGrading($attempt, $examiner);
     *
     * If $examiner is null, the method will look for any admin user as fallback.
     */
    public function notifyExaminerNeedsGrading(ExamAttempt $attempt, ?User $examiner = null): void
    {
        $attempt->loadMissing(['user', 'exam']);

        // Fallback: find any admin/examiner role user if none provided
        if (!$examiner) {
            $examiner = User::where('role', 'examiner')->first()
                ?? User::where('role', 'admin')->first();
        }

        if (!$examiner || !$examiner->email) {
            Log::warning("[ExamNotification] Cannot send needs-grading email: no examiner found.", [
                'attempt_id' => $attempt->id,
            ]);
            return;
        }

        try {
            Mail::to($examiner->email, $examiner->name)
                ->send(new ExamNeedsGradingMail($attempt, $examiner));

            Log::info("[ExamNotification] Needs-grading email sent.", [
                'attempt_id'   => $attempt->id,
                'to'           => $examiner->email,
                'test_taker'   => $attempt->user->email ?? 'unknown',
            ]);
        } catch (\Throwable $e) {
            Log::error("[ExamNotification] Failed to send needs-grading email.", [
                'attempt_id' => $attempt->id,
                'error'      => $e->getMessage(),
            ]);
        }
    }

    /**
     * Notify ALL examiners about a pending submission.
     *
     * Use this if the system assigns grading to multiple examiners.
     *
     * @param  User[]  $examiners
     */
    public function notifyAllExaminers(ExamAttempt $attempt, array $examiners): void
    {
        foreach ($examiners as $examiner) {
            $this->notifyExaminerNeedsGrading($attempt, $examiner);
        }
    }
}
