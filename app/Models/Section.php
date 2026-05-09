<?php

namespace App\Models;

use App\Models\Subsection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'exam_id',
        'title',
        'order_position',
        'duration',
        'description',
    ];

    protected $casts = [
        'order_position' => 'integer',
        'duration' => 'integer',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $maxOrder = static::where('exam_id', $model->exam_id)->max('order_position');
            $model->order_position = $maxOrder ? $maxOrder + 1 : 1;
        });
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function subsections(): HasMany
    {
        return $this->hasMany(Subsection::class, 'section_id');
    }
}
