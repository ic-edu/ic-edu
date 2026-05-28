<?php

namespace App\Models;

use App\Models\ExamAttempt;
use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Exam extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'exam_type_id',
        'title',
        'description',
        'total_duration',
        'mode',
        'is_active',
        'is_public',
        'tokens_required',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_public' => 'boolean',
        'total_duration' => 'integer',
        'tokens_required' => 'integer',
    ];

    public function examType(): BelongsTo
    {
        return $this->belongsTo(ExamType::class, 'exam_type_id');
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class, 'exam_id');
    }

    public function attempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }

    public function enrollments()
    {
        return $this->hasMany(ExamEnrollment::class);
    }

    public function getTotalQuestionsAttribute(): int
    {
        return Question::whereHas('questionGroup.subsection.section', function ($query) {
            $query->where('exam_id', $this->id);
        })->count();
    }

    public function courseLessons()
    {
        return $this->hasMany(CourseLesson::class, 'exam_id');
    }
}
