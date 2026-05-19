<?php

namespace App\Models;

use App\Models\ExamAttempt;
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
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_public' => 'boolean',
        'total_duration' => 'integer',
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
        return DB::table('questions')
            ->join('question_groups', 'questions.question_group_id', '=', 'question_groups.id')
            ->join('subsections', 'question_groups.subsection_id', '=', 'subsections.id')
            ->join('sections', 'subsections.section_id', '=', 'sections.id')
            ->where('sections.exam_id', $this->id)
            ->count();
    }
}
