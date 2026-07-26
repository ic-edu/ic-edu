@extends('layouts.user')

@section('title', 'Home')

@section('content')
    {{-- 1. Hero Section --}}
    <x-landing.hero />

    {{-- 2. About Section --}}
    <x-landing.about />

    {{-- 3. Marquee Ticker Strip --}}
    <x-landing.marquee />

    {{-- 4. Why Choose Us (Puzzle Board) --}}
    <x-landing.why-choose-us />

    {{-- 5. Testimonials and Stats --}}
    <x-landing.testimonials />

    {{-- 6. CTA Earth Section --}}
    <x-landing.cta-earth />
@endsection