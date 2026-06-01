<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseLesson extends Model
{
    protected $fillable = [
        'module_id',
        'exam_id',
        'passing_score',
        'title',
        'type',
        'content_url',
        'file_path',
        'text_content',
        'duration_minutes',
        'order_position',
        'is_previewable',
    ];

    protected $casts = [
        'duration_minutes' => 'integer',
        'order_position'   => 'integer',
        'is_previewable'   => 'boolean',
        'passing_score'    => 'decimal:1',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (! $model->order_position) {
                $max = static::where('module_id', $model->module_id)->max('order_position');
                $model->order_position = $max ? $max + 1 : 1;
            }
        });
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(CourseModule::class, 'module_id');
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    /**
     * Human-readable label for each lesson type.
     */
    public static function types(): array
    {
        return [
            'video'     => 'Video',
            'pdf'       => 'PDF',
            'text'      => 'Text / Article',
            'audio'     => 'Audio',
            'link'      => 'External Link',
            'quiz'      => 'Quiz / Practice',
        ];
    }

    public function progresses()
    {
        return $this->hasMany(LessonProgress::class, 'course_lesson_id');
    }
}
