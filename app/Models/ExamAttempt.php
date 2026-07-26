<?php

namespace App\Models;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamAttempt extends Model
{
    use SoftDeletes;
    use HasUuids;

    protected $fillable = [
        'user_id',
        'exam_id',
        'status',
        'started_at',
        'submitted_at',
        'finished_at',
        'raw_score',
        'converted_score',
        'section_scores',
        'is_passed',
        'current_question_id',
        'examiner_id',
    ];

    protected $casts = [
        'started_at'      => 'datetime',
        'submitted_at'    => 'datetime',
        'finished_at'     => 'datetime',
        'raw_score'       => 'integer',
        'converted_score' => 'decimal:1',
        'section_scores'  => 'array',
        'is_passed'       => 'boolean',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function answers()
    {
        return $this->hasMany(AttemptAnswer::class);
    }

    protected static function booted()
    {
        static::updated(function ($attempt) {
            if ($attempt->isDirty('status')) {
                $newStatus = $attempt->status;
                $oldStatus = $attempt->getOriginal('status');
                
                $user = $attempt->user;
                if ($user) {
                    $exam = $attempt->exam;
                    if ($newStatus === 'finished' && $oldStatus !== 'finished') {
                        $user->notify(new \App\Notifications\GeneralNotification([
                            'title' => 'Exam submitted: <strong>' . $exam->title . '</strong>',
                            'desc' => 'Your answers have been successfully submitted and are pending review by our instruction team.',
                            'type' => 'exam',
                            'category' => 'Exam Submitted',
                            'action_url' => route('test_taker.exam.my_exams'),
                            'action_text' => 'View My Exams →'
                        ]));
                    } elseif ($newStatus === 'graded' && $oldStatus !== 'graded') {
                        $passingScore = $exam->examType->passing_score ?? null;
                        $isPassed = $passingScore ? $attempt->converted_score >= $passingScore : null;
                        $passedText = $isPassed === true ? ' — excellent performance!' : '';
                        
                        $user->notify(new \App\Notifications\GeneralNotification([
                            'title' => 'Score report is ready for <strong>' . $exam->title . '</strong>',
                            'desc' => 'Your full score breakdown is now available. You scored <span class="np__score-chip np__score-chip--high">' . number_format($attempt->converted_score, 1) . '</span>' . $passedText,
                            'type' => 'exam',
                            'category' => 'Score Report',
                            'action_url' => route('test_taker.exam.score_report', $attempt->id),
                            'action_text' => 'View Report →'
                        ]));
                    }
                }
            }
        });
    }

    public function currentQuestion()
    {
        return $this->belongsTo(Question::class, 'current_question_id');
    }

    public function examiner()
    {
        return $this->belongsTo(User::class, 'examiner_id');
    }
}
