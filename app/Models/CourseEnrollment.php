<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseEnrollment extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'status',
        'enrolled_at',
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::created(function ($enrollment) {
            $user = $enrollment->user;
            if ($user) {
                $course = $enrollment->course;
                $user->notify(new \App\Notifications\GeneralNotification([
                    'title' => 'Successfully enrolled in <strong>' . $course->title . '</strong>',
                    'desc' => "You've been successfully enrolled. Start your first lesson anytime — your progress is saved automatically.",
                    'type' => 'course',
                    'category' => 'Course Enrolled',
                    'action_url' => route('test_taker.course.show', $course->id),
                    'action_text' => 'Go to Course →'
                ]));
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
