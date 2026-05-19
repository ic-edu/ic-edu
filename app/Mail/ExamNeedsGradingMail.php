<?php

namespace App\Mail;

use App\Models\ExamAttempt;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Sent to an EXAMINER when a test taker has finished an exam and needs grading.
 */
class ExamNeedsGradingMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly ExamAttempt $attempt,
        public readonly User        $examiner,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Submission Needs Grading — ' . $this->attempt->exam->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.exam-needs-grading',
        );
    }
}
