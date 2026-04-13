<?php

namespace App\Http\Controllers\TestTaker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        return view('test_taker.course.index');
    }
}
