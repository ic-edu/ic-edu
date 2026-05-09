<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subsection extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'section_id',
        'title',
        'instructions',
        'order_position',
        'instruction_audio_path',
        'instruction_image_path',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $maxOrder = static::where('section_id', $model->section_id)->max('order_position');
            $model->order_position = $maxOrder ? $maxOrder + 1 : 1;
        });
    }

    protected $casts = [
        'order_position' => 'integer',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function questionGroups(): HasMany
    {
        return $this->hasMany(QuestionGroup::class, 'subsection_id');
    }
}
