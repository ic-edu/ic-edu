<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionGroup extends Model
{
    protected $fillable = [
        'subsection_id',
        'title',
        'instruction',
        'group_type',
        'passage_text',
        'image_path',
        'audio_path',
        'order_position',
    ];

    protected $casts = [
        'order_position' => 'integer',
    ];

    public function subsection()
    {
        return $this->belongsTo(Subsection::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
