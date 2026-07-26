<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'course_id',
        'certificate_code',
        'issued_at',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::created(function ($certificate) {
            $user = $certificate->user;
            if ($user) {
                $course = $certificate->course;
                $user->notify(new \App\Notifications\GeneralNotification([
                    'title' => 'Certificate issued for <strong>' . $course->title . '</strong> 🎉',
                    'desc' => 'Congratulations! You completed the course and earned your certificate. Click below to view and download it.',
                    'type' => 'course',
                    'category' => 'Certificate Earned',
                    'action_url' => route('test_taker.course.certificate.download', $course->id),
                    'action_text' => 'Download Certificate →'
                ]));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
