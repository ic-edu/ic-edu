<?php

namespace App\Models;

use App\Models\AttemptAnswer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_group_id',
        'type',
        'question_text',
        'image_path',
        'audio_path',
        'points',
        'order_position',
    ];

    protected $casts = [
        'points' => 'integer',
        'order_position' => 'integer',
    ];

    public function group()
    {
        return $this->belongsTo(QuestionGroup::class, 'question_group_id');
    }

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }

    public function answers()
    {
        return $this->hasMany(AttemptAnswer::class);
    }
}
