<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        return view('#');
    }
    public function detail($id)
{
    return view('course.detail');
}
}