@php
$courses = [
    [
        'title' => 'TOEIC Listening & Reading',
        'image' => 'images/course1.jpg',
        'price' => 100000,
        'link' => '#'
    ],
    [
        'title' => 'TOEIC Speaking & Writing',
        'image' => 'images/course2.jpg',
        'price' => 100000,
        'link' => '#'
    ],
    [
        'title' => 'TOEFL iBT',
        'image' => 'images/course3.jpg',
        'price' => 100000,
        'link' => '#'
    ],
];
@endphp

@extends('layouts.test_taker')
@section('title', 'Browse Exams')

@section('content')

<div class="grid grid-cols-3 gap-6">
    @foreach ($courses as $course)
        <x-course-card 
            :title="$course['title']"
            :image="asset($course['image'])"
            :price="'Rp ' . number_format($course['price']) . '/Month'"
            :link="$course['link']"
        />
    @endforeach
</div>

@endsection