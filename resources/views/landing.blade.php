@extends('layouts.user')

@section('title', 'Home')

@push('styles')
<style>
    /* ─────────────────────────────────────────
       MARQUEE
    ───────────────────────────────────────── */
    .marquee-track {
        animation: marquee 28s linear infinite;
    }
    @keyframes marquee {
        from { transform: translateX(0); }
        to   { transform: translateX(-50%); }
    }

    /* ─────────────────────────────────────────
       TESTIMONIAL COLUMNS
    ───────────────────────────────────────── */
    .testi-col-wrap {
        overflow: hidden;
        mask-image: linear-gradient(to bottom, transparent 0%, black 10%, black 90%, transparent 100%);
        -webkit-mask-image: linear-gradient(to bottom, transparent 0%, black 10%, black 90%, transparent 100%);
    }
    .testi-track {
        display: flex;
        flex-direction: column;
        gap: 16px;
        animation-timing-function: linear;
        animation-iteration-count: infinite;
    }
    .testi-track-up   { animation: testiScrollUp   30s linear infinite; }
    .testi-track-down { animation: testiScrollDown 35s linear infinite; }
    .testi-col-wrap:hover .testi-track { animation-play-state: paused; }
    @keyframes testiScrollUp   { 0% { transform: translateY(0);    } 100% { transform: translateY(-50%); } }
    @keyframes testiScrollDown { 0% { transform: translateY(-50%); } 100% { transform: translateY(0);    } }

    .testi-item {
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 20px;
        padding: 22px;
        flex-shrink: 0;
        transition: box-shadow .25s ease, transform .25s ease;
        cursor: default;
    }
    .testi-item:hover {
        box-shadow: 0 16px 48px rgba(37, 99, 235, 0.10);
        transform: translateY(-3px);
    }
    .testi-title {
        font-family: 'Poppins', sans-serif;
        color: #1a3a5a;
        font-weight: 800;
        line-height: 1.1;
    }

    /* ─────────────────────────────────────────
       FLOATING (general)
    ───────────────────────────────────────── */
    .floating {
        animation: floating 4s ease-in-out infinite;
    }
    @keyframes floating {
        0%, 100% { transform: translateX(-50%) translateY(0px); }
        50%       { transform: translateX(-50%) translateY(-12px); }
    }

    /* ─────────────────────────────────────────
       PUZZLE — DESKTOP (≥ 1025px)
       Absolute positioning only on large screens
    ───────────────────────────────────────── */
    @media (min-width: 1025px) {
        .puzzle-board {
            position: relative;
            width: 1200px;
            height: 420px;
            margin: 0 auto;
            overflow: visible;
        }
        .piece {
            position: absolute;
            transition: transform .35s cubic-bezier(.175,.885,.32,1.275), filter .35s ease;
            cursor: pointer;
            overflow: visible;
        }
        .piece:hover {
            transform: translateY(-14px) scale(1.03);
            z-index: 99;
            filter: drop-shadow(0 25px 35px rgba(0,0,0,.28));
        }
        .piece img { width: 100%; height: auto; display: block; user-select: none; -webkit-user-drag: none; pointer-events: none; }

        /* positions */
        .p-kiri-atas    { width: 523px; top: 0;    left: -15px; z-index: 5; }
        .p-tengah-atas  { width: 331px; top: 0;    left: 455px; z-index: 2; }
        .p-kanan-atas   { width: 492px; top: 0;    left: 723px; z-index: 4; }
        .p-kiri-bawah   { width: 480px; top: 244px; left: -15px; z-index: 3; }
        .p-tengah-bawah { width: 505px; top: 244px; left: 400px; z-index: 1; }
        .p-kanan-bawah  { width: 383px; top: 172px; left: 833px; z-index: 6; }

        /* text overlays */
        .puzzle-text-content {
            position: absolute;
            z-index: 20;
            pointer-events: none;
        }
        .puzzle-text-content h3 {
            font-family: 'Poppins', sans-serif;
            font-size: 3rem;
            font-weight: 900;
            line-height: 1;
            margin-bottom: 14px;
        }
        .puzzle-text-content p {
            font-size: .95rem;
            line-height: 1.7;
            font-weight: 500;
            max-width: 300px;
        }
        .t-toeic { top: 40px;   left: 45px;  color: white; }
        .t-ielts { top: 15px;   right: 45px; text-align: right; color: white; }
        .t-lms   { bottom: 30px; left: 45px; color: #1A3A5A; }
        .t-toefl { bottom: 55px; left: 100px; color: white; }

        .owl-main, .owl-second {
            position: absolute;
            z-index: 25;
            top: 25%;
            left: 50%;
            transform: translateX(-50%);
            pointer-events: none;
        }
        .owl-main   { width: 180px; }
        .owl-second { width: 150px; }

        /* scale down at 1280 */
        @media (max-width: 1280px) {
            .puzzle-board {
                transform: scale(.9);
                transform-origin: top center;
                height: 460px;
                margin-bottom: 20px;
            }
        }
    }

    /* ─────────────────────────────────────────
       PUZZLE — MOBILE / TABLET (≤ 1024px)
       Flat card layout, no absolute positioning
    ───────────────────────────────────────── */
    @media (max-width: 1024px) {
        .puzzle-board {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
            padding: 0 16px;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        /* hide the pure-connector middle pieces */
        .p-tengah-atas,
        .p-kanan-bawah { display: none; }

        .piece {
            position: relative !important;
            width: 100% !important;
            top: auto !important; left: auto !important;
            border-radius: 24px;
            overflow: hidden;
            cursor: pointer;
            transition: transform .3s ease, box-shadow .3s ease;
        }
        .piece:active { transform: scale(0.98); }

        .piece > img:first-child {
            width: 100%;
            height: 180px;
            object-fit: cover;
            display: block;
            user-select: none;
            -webkit-user-drag: none;
        }

        /* text overlays on mobile: full-width bar at bottom */
        .puzzle-text-content {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            padding: 16px 20px;
            background: linear-gradient(to top, rgba(0,0,0,0.65) 0%, transparent 100%);
            pointer-events: none;
        }
        .puzzle-text-content h3 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.6rem;
            font-weight: 900;
            line-height: 1;
            margin-bottom: 6px;
            color: white !important;
        }
        .puzzle-text-content p {
            font-size: 0.8rem;
            line-height: 1.5;
            max-width: 100%;
            color: rgba(255,255,255,0.9) !important;
            margin: 0;
        }
        /* override any desktop colour classes */
        .t-toeic, .t-ielts, .t-lms, .t-toefl {
            top: auto !important; bottom: 0 !important;
            left: 0 !important; right: 0 !important;
            text-align: left !important;
        }

        /* hide owls on mobile */
        .owl-main, .owl-second { display: none; }
    }

    /* ─────────────────────────────────────────
       HERO — tighten on very small screens
    ───────────────────────────────────────── */
    @media (max-width: 400px) {
        .hero-avatar-row { flex-wrap: wrap; justify-content: center; }
    }

    /* ─────────────────────────────────────────
       TESTIMONIAL MOBILE CAROUSEL
    ───────────────────────────────────────── */
    .testi-mobile-scroll {
        display: flex;
        gap: 16px;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 12px;
        scrollbar-width: none;
    }
    .testi-mobile-scroll::-webkit-scrollbar { display: none; }
    .testi-mobile-card {
        min-width: 280px;
        max-width: 300px;
        flex-shrink: 0;
        scroll-snap-align: start;
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 20px;
        padding: 20px;
    }

   
    /* ─────────────────────────────────────────
       ABOUT SECTION IMAGE — mobile
    ───────────────────────────────────────── */
    @media (max-width: 640px) {
        .about-img-wrap {
            border-radius: 20px 20px 60px 20px !important;
        }
    }

    /* ─────────────────────────────────────────
       STATS BAR — wrap nicely on mobile
    ───────────────────────────────────────── */
    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 20px !important;
        }
    }
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════
     SECTION 1 — HERO
════════════════════════════════════════════ --}}
<section class="w-full bg-white pt-24 pb-16 lg:pt-36 lg:pb-24 px-[5%] overflow-hidden">
    <div class="max-w-[1140px] mx-auto flex flex-col-reverse lg:flex-row items-center justify-between gap-10 lg:gap-12">

        {{-- LEFT: Copy --}}
        <div class="w-full lg:max-w-[550px] flex flex-col items-center lg:items-start text-center lg:text-left">
            <span class="inline-block bg-slate-100 text-[#2b4c7e] text-xs lg:text-sm font-semibold px-4 py-1.5 rounded-full mb-5">
                #1 English Learning Platform
            </span>

            <h1 class="text-3xl sm:text-4xl lg:text-[42px] font-extrabold text-[#1a365d] leading-tight mb-4 tracking-tight">
                Unlock English Skills That <br>
                <span class="text-[#55b6bb]">Move You Forward</span>
            </h1>

            <p class="text-sm lg:text-base text-slate-600 leading-relaxed mb-7 max-w-[500px]">
                Master in-demand English skills — from IELTS, TOEIC, TOEFL to daily conversation. Learn at your own pace, track your growth, and stay ahead.
            </p>

            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto mb-8">
                <a href="#" class="inline-block px-7 py-3 rounded-full text-sm font-bold text-white bg-[#1d3557] hover:bg-[#14243b] transition-all text-center shadow-md">
                    Start Learning Free
                </a>
                <a href="#" class="inline-block px-7 py-3 rounded-full text-sm font-bold text-[#1d3557] bg-white border-2 border-[#1d3557] hover:bg-slate-50 transition-all text-center">
                    Browse Courses
                </a>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3 hero-avatar-row">
                <div class="flex -space-x-2">
                    <div class="w-8 h-8 rounded-full bg-blue-500 text-white border-2 border-white flex items-center justify-center text-[10px] font-bold">RK</div>
                    <div class="w-8 h-8 rounded-full bg-indigo-500 text-white border-2 border-white flex items-center justify-center text-[10px] font-bold">BS</div>
                    <div class="w-8 h-8 rounded-full bg-emerald-500 text-white border-2 border-white flex items-center justify-center text-[10px] font-bold">SM</div>
                    <div class="w-8 h-8 rounded-full bg-amber-500 text-white border-2 border-white flex items-center justify-center text-[10px] font-bold">DA</div>
                </div>
                <p class="text-xs lg:text-sm text-slate-500">
                    <strong class="text-slate-700">12,000+</strong> students already learning
                </p>
            </div>
        </div>

        {{-- RIGHT: Mascot --}}
        <div class="w-full lg:flex-1 flex justify-center lg:justify-end lg:pr-8 relative z-10">
            <div class="relative w-[240px] h-[240px] sm:w-[300px] sm:h-[300px] lg:w-[380px] lg:h-[380px] flex items-center justify-center">
                <div class="w-full h-full bg-[#1A456C] rounded-full shadow-xl"></div>
                <img src="{{ asset('assets/maskot/hero maskot.png') }}"
                     alt="IC EDU Mascot"
                     class="absolute w-[125%] sm:w-[130%] h-auto object-contain drop-shadow-[0_25px_35px_rgba(0,0,0,0.3)] z-20 -bottom-8 -right-6 lg:-right-8">
            </div>
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════
     SECTION 2 — ABOUT
════════════════════════════════════════════ --}}
<section class="relative bg-[#1a395b] w-[100vw] left-1/2 right-1/2 -ml-[50vw] -mr-[50vw] pt-20 pb-20 px-[5%] rounded-t-[40px] lg:rounded-t-[80px] overflow-hidden">
    <div class="max-w-[1140px] mx-auto flex flex-col lg:flex-row items-center gap-10 lg:gap-16 relative z-10">

        {{-- Image --}}
        <div class="w-full lg:w-[45%] flex justify-center">
            <div class="about-img-wrap relative w-full max-w-[360px] aspect-[4/5] rounded-[30px] rounded-tl-[80px] overflow-hidden shadow-2xl bg-slate-800">
                <img src="{{ asset('assets/images/building.png') }}"
                     alt="PT Edukasi Persada Indonesia Building"
                     class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
            </div>
        </div>

        {{-- Copy --}}
        <div class="w-full lg:w-[55%] text-white">
            <div class="mb-5 flex justify-center lg:justify-start">
                <span class="inline-block bg-white/10 backdrop-blur-md text-white text-xs font-semibold px-4 py-1.5 rounded-full uppercase tracking-wider">
                    Who we are
                </span>
            </div>

            <h2 class="text-2xl sm:text-3xl lg:text-[40px] font-extrabold leading-tight mb-5 tracking-tight text-center lg:text-left">
                Your Trusted Platform for English Learning and Test Preparation
            </h2>

            <p class="text-sm lg:text-base text-slate-300 leading-relaxed mb-7 max-w-[580px] text-center lg:text-left">
                IC Edu is an English education platform operated by <strong class="text-white">PT Edukasi Persada Indonesia</strong>, providing tailored language training programs for students, professionals, universities, and companies.
            </p>

            <div class="space-y-5 max-w-[500px] mx-auto lg:mx-0">
                @foreach([
                    ['Interactive Practice', 'Engaging modules and real test simulations'],
                    ['International Preparation', 'Programs for IELTS, TOEFL, and TOEIC success.'],
                    ['Flexible Learning', 'Study anytime through our digital platform.'],
                ] as $point)
                <div class="flex items-start gap-4">
                    <span class="text-[#55b6bb] text-2xl leading-none mt-0.5 flex-shrink-0">•</span>
                    <div>
                        <h4 class="text-base font-bold text-white leading-tight mb-1">{{ $point[0] }}</h4>
                        <p class="text-sm text-slate-300">{{ $point[1] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════
     MARQUEE STRIP
════════════════════════════════════════════ --}}
<div class="overflow-hidden py-4 bg-blue-50 border-y border-blue-100">
    <div class="marquee-track flex gap-10 w-max">
        @php
        $marqueeItems = [
            'IELTS Preparation', 'TOEFL Training', 'Academic Writing', 'Public Speaking',
            'Grammar Mastery', 'Vocabulary Builder', 'Listening Skills', 'Pronunciation',
            'Business English', 'TOEIC Prep', 'Reading Skills', 'Daily Conversation',
        ];
        @endphp
        @foreach(array_merge($marqueeItems, $marqueeItems) as $item)
        <div class="flex items-center gap-2.5 text-xs font-bold text-blue-600 uppercase tracking-widest whitespace-nowrap">
            <span class="w-[5px] h-[5px] rounded-full bg-blue-400 flex-shrink-0"></span>
            {{ $item }}
        </div>
        @endforeach
    </div>
</div>

{{-- ═══════════════════════════════════════════
     SECTION 3 — WHY CHOOSE US / PUZZLE
════════════════════════════════════════════ --}}
<section class="py-20 bg-white overflow-hidden" id="why-choose-us">
    <div class="max-w-[1200px] mx-auto px-[5%]">
        <div class="text-center mb-12">
            <span class="bg-blue-50 text-blue-600 px-4 py-1.5 rounded-full text-xs font-bold mb-5 inline-block uppercase tracking-widest">
                Why Choose Us
            </span>
            <h2 class="text-3xl lg:text-5xl font-extrabold text-[#1a3a5a] mb-4 leading-[1.1]">
                All-in-one platform for English <br class="hidden md:block"> learning and test preparation
            </h2>
        </div>
    </div>

    {{-- PUZZLE BOARD --}}
    <div class="puzzle-board">

        {{-- TOEIC --}}
        <div class="piece p-kiri-atas">
            <img src="{{ asset('assets/puzzle/kiri-atas.png') }}" alt="TOEIC">
            <div class="puzzle-text-content t-toeic">
                <h3>TOEIC</h3>
                <p>Focus on workplace communication skills, including business conversations, emails, and daily office situations.</p>
            </div>
        </div>

        {{-- TENGAH ATAS (owl piece — hidden on mobile) --}}
        <div class="piece p-tengah-atas flex items-center justify-center">
            <img src="{{ asset('assets/puzzle/tengah-atas.png') }}" alt="">
            <img src="{{ asset('images/owl.png') }}" class="absolute z-20 w-[180px] owl-one" alt="Owl">
        </div>

        {{-- IELTS --}}
        <div class="piece p-kanan-atas">
            <img src="{{ asset('assets/puzzle/kanan-atas.png') }}" alt="IELTS">
            <div class="puzzle-text-content t-ielts">
                <h3>IELTS</h3>
                <p>Designed for academic and international purposes, covering listening, reading, writing, and speaking.</p>
            </div>
        </div>

        {{-- LMS --}}
        <div class="piece p-kiri-bawah">
            <img src="{{ asset('assets/puzzle/kiri-bawah.png') }}" alt="LMS">
            <div class="puzzle-text-content t-lms">
            </div>
        </div>

        {{-- TOEFL --}}
        <div class="piece p-tengah-bawah">
            <img src="{{ asset('assets/puzzle/tengah-bawah.png') }}" alt="TOEFL">
            <div class="puzzle-text-content t-toefl">
                <h3>TOEFL</h3>
                <p>Focuses on academic English used in universities, including lectures, essays, and campus discussions.</p>
            </div>
        </div>

        {{-- KANAN BAWAH (owl piece — hidden on mobile) --}}
        <div class="piece p-kanan-bawah flex items-center justify-center">
            <img src="{{ asset('assets/puzzle/kanan-bawah.png') }}" alt="">
            <img src="{{ asset('images/owl.png') }}" class="absolute z-20 w-[150px] owl-two" alt="Owl">
        </div>

    </div>
</section>

<x-landing.courses-card/>

{{-- ═══════════════════════════════════════════
     SECTION 4 — TESTIMONIALS
════════════════════════════════════════════ --}}
<section class="py-20 overflow-hidden bg-white" id="testimonials">
    <div class="max-w-[1200px] mx-auto px-[5%]">

        @php
        $testimonials = [
            ['name' => 'Arran Douglas',  'achievement' => 'IELTS Score: 7.5 → 8.0',      'quote' => 'The modules at IC.EDU were very easy to understand. The LMS monitored my progress every day.'],
            ['name' => 'Jeffrey Avery',  'achievement' => 'TOEFL iBT: 89 → 107',          'quote' => 'I really enjoyed the online test platform. The interface is simple, fast, and comfortable.'],
            ['name' => 'Amanda Banks',   'achievement' => 'Business English Certified',    'quote' => 'This platform made my English preparation more effective. The results were beyond my expectations.'],
        ];
        $displayColA = array_slice($testimonials, 0, 2);
        $displayColB = array_slice($testimonials, 2, 1);
        @endphp

        <div class="grid lg:grid-cols-[400px_1fr] gap-12 lg:gap-16 items-center">

            {{-- Left: heading --}}
            <div>
                <div class="mb-5">
                    <svg width="60" height="45" viewBox="0 0 80 60" fill="none">
                        <path d="M22.8571 0V30H0V60H34.2857V0H22.8571ZM68.5714 0V30H45.7143V60H80V0H68.5714Z" fill="#1a3a5a"/>
                    </svg>
                </div>
                <h2 class="testi-title text-3xl lg:text-5xl mb-4">
                    Stories from<br>IC.EDU<br>Learners
                </h2>
                <p class="text-slate-500 text-base lg:text-lg max-w-[320px]">Read what our students have to say about their journey.</p>
            </div>

            {{-- Desktop: animated columns --}}
            <div class="hidden lg:grid grid-cols-2 gap-6" style="height: 600px;">
                <div class="testi-col-wrap">
                    <div class="testi-track testi-track-up">
                        @foreach(array_merge($displayColA, $displayColA, $displayColA) as $t)
                        <div class="testi-item">
                            <div class="text-amber-400 mb-3 text-sm">★★★★★</div>
                            <p class="text-slate-600 mb-5 italic text-sm">"{{ $t['quote'] }}"</p>
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($t['name']) }}&background=1a3a5a&color=fff" class="w-10 h-10 rounded-full" alt="{{ $t['name'] }}">
                                <div>
                                    <div class="font-bold text-[#1a3a5a] text-sm">{{ $t['name'] }}</div>
                                    <div class="text-xs text-slate-400">{{ $t['achievement'] }}</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="testi-col-wrap mt-12">
                    <div class="testi-track testi-track-down">
                        @foreach(array_merge($displayColB, $displayColB, $displayColB) as $t)
                        <div class="testi-item">
                            <div class="text-amber-400 mb-3 text-sm">★★★★★</div>
                            <p class="text-slate-600 mb-5 italic text-sm">"{{ $t['quote'] }}"</p>
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($t['name']) }}&background=1a3a5a&color=fff" class="w-10 h-10 rounded-full" alt="{{ $t['name'] }}">
                                <div>
                                    <div class="font-bold text-[#1a3a5a] text-sm">{{ $t['name'] }}</div>
                                    <div class="text-xs text-slate-400">{{ $t['achievement'] }}</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Mobile: horizontal scroll carousel --}}
            <div class="lg:hidden -mx-[5%]">
                <div class="testi-mobile-scroll px-[5%]">
                    @foreach($testimonials as $t)
                    <div class="testi-mobile-card">
                        <div class="text-amber-400 mb-3 text-sm">★★★★★</div>
                        <p class="text-slate-600 mb-4 italic text-sm">"{{ $t['quote'] }}"</p>
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($t['name']) }}&background=1a3a5a&color=fff" class="w-9 h-9 rounded-full" alt="{{ $t['name'] }}">
                            <div>
                                <div class="font-bold text-[#1a3a5a] text-sm">{{ $t['name'] }}</div>
                                <div class="text-xs text-slate-400">{{ $t['achievement'] }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <p class="text-center text-xs text-slate-400 mt-3">← Swipe to read more →</p>
            </div>

        </div>
    </div>

    {{-- Stats Bar --}}
    <div class="py-10 bg-white border-t border-b border-slate-100 mt-12">
        <div class="max-w-[1100px] mx-auto px-[5%]">
            <div class="stats-grid grid grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                @foreach([
                    ['250', 'K +', 'Premium Courses'],
                    ['500', 'K+',  'Active Learner'],
                    ['98',  '%',   'Pass Rate'],
                    ['100', 'K+',  'Certificates Issued'],
                ] as $stat)
                <div class="flex flex-col items-center">
                    <div class="text-2xl lg:text-3xl font-extrabold text-[#1a3a5a] mb-1">
                        <span class="counter" data-target="{{ $stat[0] }}">0</span>{{ $stat[1] }}
                    </div>
                    <div class="text-[10px] lg:text-[11px] font-bold text-[#1a3a5a] uppercase tracking-widest opacity-70">{{ $stat[2] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<x-landing.unlock/>

<script>
(function () {
    const counters = document.querySelectorAll('.counter');
    const speed = 200;
    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const el = entry.target;
            const target = +el.getAttribute('data-target');
            const update = () => {
                const current = +el.innerText;
                const increment = target / speed;
                if (current < target) {
                    el.innerText = Math.ceil(current + increment);
                    setTimeout(update, 1);
                } else {
                    el.innerText = target;
                }
            };
            update();
            obs.unobserve(el);
        });
    }, { threshold: 0.5 });
    counters.forEach(c => observer.observe(c));
})();
</script>
@endsection