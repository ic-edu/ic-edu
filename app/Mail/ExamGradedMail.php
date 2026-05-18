<?php

namespace App\Mail;

use App\Models\ExamAttempt;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Sent to the TEST TAKER when their exam has been fully graded by the examiner.
 */
class ExamGradedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly ExamAttempt $attempt
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Exam Results Are Ready — ' . $this->attempt->exam->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.exam-graded',
        );
    }
}
