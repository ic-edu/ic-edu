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
        'finished_at',
        'total_score',
        'current_question_id',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'total_score' => 'integer',
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
}
