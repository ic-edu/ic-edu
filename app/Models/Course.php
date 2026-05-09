<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'thumbnail_path',
        'description',
        'target_level',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function modules(): HasMany
    {
        return $this->hasMany(CourseModule::class)->orderBy('order_position');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(CourseEnrollment::class);
    }
}
