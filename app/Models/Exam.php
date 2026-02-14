<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Exam extends Model
{
    use HasUuids;
    use SoftDeletes;
    protected $guarded = [];

    public $incrementing = false;
    protected $keyType = 'string';

    public function exam_type()
    {
        return $this->belongsTo(ExamType::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}
