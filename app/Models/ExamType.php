<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ExamType extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'description',
    ];
    
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
}
