<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseModule extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'description',
        'order_position',
    ];

    protected $casts = [
        'order_position' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (! $model->order_position) {
                $max = static::where('course_id', $model->course_id)->max('order_position');
                $model->order_position = $max ? $max + 1 : 1;
            }
        });
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(CourseLesson::class, 'module_id')->orderBy('order_position');
    }
}
