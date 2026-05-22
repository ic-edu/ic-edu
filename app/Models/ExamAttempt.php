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

    public function currentQuestion()
    {
        return $this->belongsTo(Question::class, 'current_question_id');
    }

    public function examiner()
    {
        return $this->belongsTo(User::class, 'examiner_id');
    }
}
