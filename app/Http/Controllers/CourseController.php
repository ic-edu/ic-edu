<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        return view('test_taker.course.index');
    }

    public function detail($id)
    {
        return view('test_taker.course.detail');
    }
}
