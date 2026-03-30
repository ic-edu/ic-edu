<?php

namespace App\Http\Controllers\User;

use App\Models\Exam;
use App\Http\Controllers\Controller;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::where('is_active', true)
            ->with('examType')
            ->latest()
            ->get();
        return view('test_taker.exams.index', compact('exams'));
    }
}
