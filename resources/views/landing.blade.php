@extends('layouts.user')

@section('title', 'Home')

@push('styles')
<style>
    /* ── Hero doodle decorations ── */
    .hero-doodle {
        position: absolute;
        opacity: 0.18;
        pointer-events: none;
    }

    /* ── Topic pills (Did you know? card) ── */
    .topic-pill {
        transition: all .2s ease;
    }

    .topic-pill {
        transition: all .2s ease;
    }

    .topic-pill:hover {
        background: #2563eb;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.25);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.25);
    }

    /* ── Marquee scroll ── */
    .marquee-track {
        animation: marquee 28s linear infinite;
    }
    .marquee-track {
        animation: marquee 28s linear infinite;
    }

    @keyframes marquee {
        from { transform: translateX(0); }
        to { transform: translateX(-50%); }
        to { transform: translateX(-50%); }
    }

    /* ── Testimonial scrolling columns ── */
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

    .testi-track-up {
        animation: testiScrollUp 30s linear infinite;
    }

    .testi-track-down {
        animation: testiScrollDown 35s linear infinite;
    }

    .testi-col-wrap:hover .testi-track {
        animation-play-state: paused;
    }


    .testi-track-up {
        animation: testiScrollUp 30s linear infinite;
    }

    .testi-track-down {
        animation: testiScrollDown 35s linear infinite;
    }

    .testi-col-wrap:hover .testi-track {
        animation-play-state: paused;
    }

    @keyframes testiScrollUp {
        0% { transform: translateY(0); }
        100% { transform: translateY(-50%); }
    }


    @keyframes testiScrollDown {
        0% { transform: translateY(-50%); }
        0% { transform: translateY(-50%); }
        100% { transform: translateY(0); }
    }

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
        box-shadow: 0 16px 48px rgba(37, 99, 235, 0.10);
        transform: translateY(-3px);
    }

    /* Animasi Bumi Berputar */
    .rotating-earth {
        animation: rotateEarth 60s linear infinite;
        transform-origin: center;
    }

    @keyframes rotateEarth {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* Animasi Awan Melayang */
    .floating-cloud {
        animation: cloudFloat 6s ease-in-out infinite;
    }

    @keyframes cloudFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    /* Gaya tulisan header testimonial */
    .testi-title {
        font-family: 'Poppins', sans-serif;
        color: #1a3a5a;
        font-weight: 800;
        line-height: 1.1;
    }

    /* =========================================================
       PUZZLE BOARD FINAL
       ========================================================= */
    .puzzle-board {
        position: relative;
        width: 1200px;
        height: 420px;
        margin: 0 auto;
        overflow: visible;
    }

    .piece {
        position: absolute;
        transition: transform .35s cubic-bezier(.175, .885, .32, 1.275), filter .35s ease, z-index .2s ease;
        cursor: pointer;
        overflow: visible;
    }

    .piece img {
        width: 100%;
        height: auto;
        display: block;
        user-select: none;
        -webkit-user-drag: none;
        pointer-events: none;
    }

    .piece:hover {
        transform: translateY(-14px) scale(1.03);
        z-index: 99;
        filter: drop-shadow(0 25px 35px rgba(0, 0, 0, .28));
    }

    /* ===== PUZZLE POSITIONS ===== */
    .p-kiri-atas { width: 523px; top: 0; left: -15px; z-index: 5; }
    .p-tengah-atas { width: 331px; top: 0; left: 455px; z-index: 2; }
    .p-kanan-atas { width: 492px; top: 0; left: 723px; z-index: 4; }
    .p-kiri-bawah { width: 480px; top: 244px; left: -15px; z-index: 3; }
    .p-tengah-bawah { width: 505px; top: 244px; left: 400px; z-index: 1; }
    .p-kanan-bawah { width: 383px; top: 172px; left: 833px; z-index: 6; }

    /* ===== TEXT CONTENT ===== */
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

    /* ===== TEXT POSITIONS ===== */
    .t-toeic { top: 40px; left: 45px; color: white; }
    .t-ielts { top: 15px; right: 45px; text-align: right; color: white; }
    .t-lms { bottom: 30px; left: 45px; color: #1A3A5A; }
    .t-toefl { bottom: 55px; left: 100px; color: white; }

    .owl-main, .owl-second {
        position: absolute;
        z-index: 25;
        top: 25%;
        left: 50%;
        transform: translateX(-50%);
        pointer-events: none;
    }
    .owl-main { width: 180px; }
    .owl-second { width: 150px; }

    .floating {
        animation: floating 4s ease-in-out infinite;
    }

    @keyframes floating {
        0%, 100% { transform: translateX(-50%) translateY(0px); }
        50% { transform: translateX(-50%) translateY(-12px); }
    }

    /* ===== RESPONSIVE PUZZLE ===== */
    @media (max-width: 1280px) {
        .puzzle-board {
            transform: scale(.9);
            transform-origin: top center;
            height: 460px;
            margin-bottom: 20px;
        }
    }

    @media (max-width: 1024px) {
        .puzzle-board {
            width: 100%;
            height: auto !important;
            display: flex;
            flex-direction: column;
            gap: 24px;
            transform: none !important;
            padding: 0 20px;
        }

        .piece {
            position: relative !important;
            width: 100% !important;
            max-width: 700px;
            top: auto !important;
            left: auto !important;
            margin: 0 auto;
        }

        .puzzle-text-content {
            position: absolute;
            z-index: 30;
        }

        .t-toeic, .t-ielts, .t-lms, .t-toefl {
            left: 40px !important;
            right: auto !important;
            top: 50% !important;
            bottom: auto !important;
            transform: translateY(-50%);
            text-align: left;
        }

        .t-toeic, .t-ielts, .t-toefl { color: white; }
        .t-lms { color: #1A3A5A; }
        .puzzle-text-content h3 { font-size: 2.4rem; }
        .puzzle-text-content p { max-width: 260px; }
    }

    @media (max-width: 640px) {
        .puzzle-text-content h3 { font-size: 2rem; }
        .puzzle-text-content p { font-size: .82rem; line-height: 1.5; max-width: 220px; }
        .owl-main { width: 120px; }
        .owl-second { width: 100px; }
    }

    @media (max-width: 992px) {
        .puzzle-board {
            height: auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 0 20px;
        }

        .puzzle-piece-img {
            position: relative;
            width: 100% !important;
            left: auto !important; right: auto !important; top: auto !important; bottom: auto !important;
            border-radius: 20px;
        }

        .puzzle-text-content {
            position: absolute;
            left: 0 !important; top: 0 !important; right: 0 !important; bottom: 0 !important;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: left !important;
            align-items: flex-start !important;
        }

        .t-lms, .t-toefl, .t-toeic, .t-ielts { color: white !important; }
        .t-lms h3, .t-lms p { color: #1A456C !important; }
    }

    /* Animasi Bumi Berputar */
    .rotating-earth {
        animation: rotateEarth 60s linear infinite;
        transform-origin: center;
    }

    @keyframes rotateEarth {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* Animasi Awan Melayang */
    .floating-cloud {
        animation: cloudFloat 6s ease-in-out infinite;
    }

    @keyframes cloudFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    /* Gaya tulisan header testimonial */
    .testi-title {
        font-family: 'Poppins', sans-serif;
        color: #1a3a5a;
        font-weight: 800;
        line-height: 1.1;
    }

    /* =========================================================
       PUZZLE BOARD FINAL
       ========================================================= */
    .puzzle-board {
        position: relative;
        width: 1200px;
        height: 420px;
        margin: 0 auto;
        overflow: visible;
    }

    .piece {
        position: absolute;
        transition: transform .35s cubic-bezier(.175, .885, .32, 1.275), filter .35s ease, z-index .2s ease;
        cursor: pointer;
        overflow: visible;
    }

    .piece img {
        width: 100%;
        height: auto;
        display: block;
        user-select: none;
        -webkit-user-drag: none;
        pointer-events: none;
    }

    .piece:hover {
        transform: translateY(-14px) scale(1.03);
        z-index: 99;
        filter: drop-shadow(0 25px 35px rgba(0, 0, 0, .28));
    }

    /* ===== PUZZLE POSITIONS ===== */
    .p-kiri-atas { width: 523px; top: 0; left: -15px; z-index: 5; }
    .p-tengah-atas { width: 331px; top: 0; left: 455px; z-index: 2; }
    .p-kanan-atas { width: 492px; top: 0; left: 723px; z-index: 4; }
    .p-kiri-bawah { width: 480px; top: 244px; left: -15px; z-index: 3; }
    .p-tengah-bawah { width: 505px; top: 244px; left: 400px; z-index: 1; }
    .p-kanan-bawah { width: 383px; top: 172px; left: 833px; z-index: 6; }

    /* ===== TEXT CONTENT ===== */
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

    /* ===== TEXT POSITIONS ===== */
    .t-toeic { top: 40px; left: 45px; color: white; }
    .t-ielts { top: 15px; right: 45px; text-align: right; color: white; }
    .t-lms { bottom: 30px; left: 45px; color: #1A3A5A; }
    .t-toefl { bottom: 55px; left: 100px; color: white; }

    .owl-main, .owl-second {
        position: absolute;
        z-index: 25;
        top: 25%;
        left: 50%;
        transform: translateX(-50%);
        pointer-events: none;
    }
    .owl-main { width: 180px; }
    .owl-second { width: 150px; }

    .floating {
        animation: floating 4s ease-in-out infinite;
    }

    @keyframes floating {
        0%, 100% { transform: translateX(-50%) translateY(0px); }
        50% { transform: translateX(-50%) translateY(-12px); }
    }

    /* ===== RESPONSIVE PUZZLE ===== */
    @media (max-width: 1280px) {
        .puzzle-board {
            transform: scale(.9);
            transform-origin: top center;
            height: 460px;
            margin-bottom: 20px;
        }
    }

    @media (max-width: 1024px) {
        .puzzle-board {
            width: 100%;
            height: auto !important;
            display: flex;
            flex-direction: column;
            gap: 24px;
            transform: none !important;
            padding: 0 20px;
        }

        .piece {
            position: relative !important;
            width: 100% !important;
            max-width: 700px;
            top: auto !important;
            left: auto !important;
            margin: 0 auto;
        }

        .puzzle-text-content {
            position: absolute;
            z-index: 30;
        }

        .t-toeic, .t-ielts, .t-lms, .t-toefl {
            left: 40px !important;
            right: auto !important;
            top: 50% !important;
            bottom: auto !important;
            transform: translateY(-50%);
            text-align: left;
        }

        .t-toeic, .t-ielts, .t-toefl { color: white; }
        .t-lms { color: #1A3A5A; }
        .puzzle-text-content h3 { font-size: 2.4rem; }
        .puzzle-text-content p { max-width: 260px; }
    }

    @media (max-width: 640px) {
        .puzzle-text-content h3 { font-size: 2rem; }
        .puzzle-text-content p { font-size: .82rem; line-height: 1.5; max-width: 220px; }
        .owl-main { width: 120px; }
        .owl-second { width: 100px; }
    }

    @media (max-width: 992px) {
        .puzzle-board {
            height: auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 0 20px;
        }

        .puzzle-piece-img {
            position: relative;
            width: 100% !important;
            left: auto !important; right: auto !important; top: auto !important; bottom: auto !important;
            border-radius: 20px;
        }

        .puzzle-text-content {
            position: absolute;
            left: 0 !important; top: 0 !important; right: 0 !important; bottom: 0 !important;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: left !important;
            align-items: flex-start !important;
        }

        .t-lms, .t-toefl, .t-toeic, .t-ielts { color: white !important; }
        .t-lms h3, .t-lms p { color: #1A456C !important; }
    }
</style>
@endpush

@section('content')

{{--  SECTION 1 -  Hero --}}
<section class="w-full bg-white pt-24 pb-16 lg:pt-36 lg:pb-24 px-[5%] overflow-hidden">
    <div class="max-w-[1140px] mx-auto flex flex-col-reverse lg:flex-row items-center justify-between gap-12">
        <div class="w-full lg:max-w-[550px] flex flex-col items-center lg:items-start text-center lg:text-left">
            <span class="inline-block bg-slate-100 text-[#2b4c7e] text-xs lg:text-sm font-semibold px-4 py-1.5 rounded-full mb-6">
                #1 English Learning Platform
            </span>
            
            <h1 class="text-3xl sm:text-4xl lg:text-[42px] font-extrabold text-[#1a365d] leading-tight mb-5 tracking-tight">
                Unlock English Skills That <br>
                <span class="text-[#55b6bb]">Move You Forward</span>
{{--  SECTION 1 -  Hero --}}
<section class="w-full bg-white pt-24 pb-16 lg:pt-36 lg:pb-24 px-[5%] overflow-hidden">
    <div class="max-w-[1140px] mx-auto flex flex-col-reverse lg:flex-row items-center justify-between gap-12">
        <div class="w-full lg:max-w-[550px] flex flex-col items-center lg:items-start text-center lg:text-left">
            <span class="inline-block bg-slate-100 text-[#2b4c7e] text-xs lg:text-sm font-semibold px-4 py-1.5 rounded-full mb-6">
                #1 English Learning Platform
            </span>
            
            <h1 class="text-3xl sm:text-4xl lg:text-[42px] font-extrabold text-[#1a365d] leading-tight mb-5 tracking-tight">
                Unlock English Skills That <br>
                <span class="text-[#55b6bb]">Move You Forward</span>
            </h1>
            
            <p class="text-sm lg:text-base text-slate-600 leading-relaxed mb-8 max-w-[500px]">
                Master in-demand English skills — from IELTS, TOEIC, TOEFL to daily conversation. Learn at your own pace, track your growth, and stay ahead.
            
            <p class="text-sm lg:text-base text-slate-600 leading-relaxed mb-8 max-w-[500px]">
                Master in-demand English skills — from IELTS, TOEIC, TOEFL to daily conversation. Learn at your own pace, track your growth, and stay ahead.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto mb-10">
                <a href="#" class="inline-block px-7 py-3 rounded-full text-sm font-bold text-white bg-[#1d3557] hover:bg-[#14243b] transition-all text-center shadow-md">
            
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto mb-10">
                <a href="#" class="inline-block px-7 py-3 rounded-full text-sm font-bold text-white bg-[#1d3557] hover:bg-[#14243b] transition-all text-center shadow-md">
                    Start Learning Free
                </a>
                <a href="#" class="inline-block px-7 py-3 rounded-full text-sm font-bold text-white bg-[#1d3557] hover:bg-[#14243b] transition-all text-center shadow-md">
                <a href="#" class="inline-block px-7 py-3 rounded-full text-sm font-bold text-white bg-[#1d3557] hover:bg-[#14243b] transition-all text-center shadow-md">
                    Browse Courses
                </a>
            </div>
            
            <div class="flex flex-col sm:flex-row items-center gap-3">
                <div class="flex -space-x-2">
                    <div class="w-8 h-8 rounded-full bg-blue-500 text-white border-2 border-white flex items-center justify-center text-[10px] font-bold">RK</div>
                    <div class="w-8 h-8 rounded-full bg-indigo-500 text-white border-2 border-white flex items-center justify-center text-[10px] font-bold">BS</div>
                    <div class="w-8 h-8 rounded-full bg-emerald-500 text-white border-2 border-white flex items-center justify-center text-[10px] font-bold">SM</div>
                    <div class="w-8 h-8 rounded-full bg-amber-500 text-white border-2 border-white flex items-center justify-center text-[10px] font-bold">DA</div>
            
            <div class="flex flex-col sm:flex-row items-center gap-3">
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
        <div class="w-full lg:flex-1 flex justify-center lg:justify-end lg:pr-8 relative z-10" data-aos="fade-left" data-aos-duration="1000">
            <div class="relative w-[290px] h-[290px] sm:w-[350px] sm:h-[350px] lg:w-[380px] lg:h-[380px] flex items-center justify-center">
                <div class="w-full h-full bg-[#1A456C] rounded-full shadow-xl"></div>
                <img src="{{ asset('assets/maskot/hero maskot.png') }}" 
                    alt="IC EDU Mascot" 
                    class="absolute w-[125%] sm:w-[130%] h-auto object-contain drop-shadow-[0_25px_35px_rgba(0,0,0,0.3)] z-20 -bottom-8 -right-6 lg:-right-8">
            </div>
        </div>
    </div>
</section>

<section class="relative bg-[#1a395b] w-[100vw] left-1/2 right-1/2 -ml-[50vw] -mr-[50vw] pt-24 pb-24 px-[5%] rounded-t-[50px] lg:rounded-t-[80px] overflow-hidden">
    <div class="max-w-[1140px] mx-auto flex flex-col lg:flex-row items-center gap-12 lg:gap-16 relative z-10">
        <div class="w-full lg:w-[45%] flex justify-center lg:justify-start" data-aos="fade-right" data-aos-duration="1000">
            <div class="relative w-full max-w-[380px] aspect-[4/5] rounded-[30px] rounded-tl-[100px] overflow-hidden shadow-2xl bg-slate-800">
                <img src="{{ asset('assets/images/building.png') }}" 
                     alt="PT Edukasi Persada Indonesia Building" 
                     class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                <p class="text-xs lg:text-sm text-slate-500">
                    <strong class="text-slate-700">12,000+</strong> students already learning
                </p>
            </div>
        </div>
        <div class="w-full lg:flex-1 flex justify-center lg:justify-end lg:pr-8 relative z-10" data-aos="fade-left" data-aos-duration="1000">
            <div class="relative w-[290px] h-[290px] sm:w-[350px] sm:h-[350px] lg:w-[380px] lg:h-[380px] flex items-center justify-center">
                <div class="w-full h-full bg-[#1A456C] rounded-full shadow-xl"></div>
                <img src="{{ asset('assets/maskot/hero maskot.png') }}" 
                    alt="IC EDU Mascot" 
                    class="absolute w-[125%] sm:w-[130%] h-auto object-contain drop-shadow-[0_25px_35px_rgba(0,0,0,0.3)] z-20 -bottom-8 -right-6 lg:-right-8">
            </div>
        </div>
    </div>
</section>

<section class="relative bg-[#1a395b] w-[100vw] left-1/2 right-1/2 -ml-[50vw] -mr-[50vw] pt-24 pb-24 px-[5%] rounded-t-[50px] lg:rounded-t-[80px] overflow-hidden">
    <div class="max-w-[1140px] mx-auto flex flex-col lg:flex-row items-center gap-12 lg:gap-16 relative z-10">
        <div class="w-full lg:w-[45%] flex justify-center lg:justify-start" data-aos="fade-right" data-aos-duration="1000">
            <div class="relative w-full max-w-[380px] aspect-[4/5] rounded-[30px] rounded-tl-[100px] overflow-hidden shadow-2xl bg-slate-800">
                <img src="{{ asset('assets/images/building.png') }}" 
                     alt="PT Edukasi Persada Indonesia Building" 
                     class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
            </div>
        </div>

        <div class="w-full lg:w-[55%] text-white" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
            <div class="mb-6 flex justify-center lg:justify-start">
                <span class="inline-block bg-white/10 backdrop-blur-md text-white text-xs font-semibold px-4 py-1.5 rounded-full uppercase tracking-wider">
                    Who we are - Who we are
                </span>
            </div>
            
            <h2 class="text-3xl sm:text-4xl lg:text-[40px] font-extrabold leading-tight mb-6 tracking-tight text-center lg:text-left">
                Your Trusted Platform for <br class="hidden sm:block">
                English Learning and Test Preparation
            </h2>
            
            <p class="text-sm lg:text-base text-slate-300 leading-relaxed mb-8 max-w-[580px] text-center lg:text-left">
                IC Edu is an English education platform operated by <strong class="text-white">PT Edukasi Persada Indonesia</strong>, providing tailored language training programs for students, professionals, universities, and companies.
            </p>
            <div class="space-y-6 max-w-[500px] mx-auto lg:mx-0">
                {{-- Point 1 --}}
                <div class="flex items-start gap-4">
                    <span class="text-[#55b6bb] text-2xl leading-none mt-0.5">•</span>
                    <div>
                        <h4 class="text-base font-bold text-white leading-tight mb-1">Interactive Practice</h4>
                        <p class="text-sm text-slate-300">Engaging modules and real test simulations</p>
        <div class="w-full lg:w-[55%] text-white" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
            <div class="mb-6 flex justify-center lg:justify-start">
                <span class="inline-block bg-white/10 backdrop-blur-md text-white text-xs font-semibold px-4 py-1.5 rounded-full uppercase tracking-wider">
                    Who we are - Who we are
                </span>
            </div>
            
            <h2 class="text-3xl sm:text-4xl lg:text-[40px] font-extrabold leading-tight mb-6 tracking-tight text-center lg:text-left">
                Your Trusted Platform for <br class="hidden sm:block">
                English Learning and Test Preparation
            </h2>
            
            <p class="text-sm lg:text-base text-slate-300 leading-relaxed mb-8 max-w-[580px] text-center lg:text-left">
                IC Edu is an English education platform operated by <strong class="text-white">PT Edukasi Persada Indonesia</strong>, providing tailored language training programs for students, professionals, universities, and companies.
            </p>
            <div class="space-y-6 max-w-[500px] mx-auto lg:mx-0">
                {{-- Point 1 --}}
                <div class="flex items-start gap-4">
                    <span class="text-[#55b6bb] text-2xl leading-none mt-0.5">•</span>
                    <div>
                        <h4 class="text-base font-bold text-white leading-tight mb-1">Interactive Practice</h4>
                        <p class="text-sm text-slate-300">Engaging modules and real test simulations</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <span class="text-[#55b6bb] text-2xl leading-none mt-0.5">•</span>
                    <div>
                        <h4 class="text-base font-bold text-white leading-tight mb-1">International Preparation</h4>
                        <p class="text-sm text-slate-300">Programs for IELTS, TOEFL, and TOEIC success.</p>
                <div class="flex items-start gap-4">
                    <span class="text-[#55b6bb] text-2xl leading-none mt-0.5">•</span>
                    <div>
                        <h4 class="text-base font-bold text-white leading-tight mb-1">International Preparation</h4>
                        <p class="text-sm text-slate-300">Programs for IELTS, TOEFL, and TOEIC success.</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <span class="text-[#55b6bb] text-2xl leading-none mt-0.5">•</span>
                    <div>
                        <h4 class="text-base font-bold text-white leading-tight mb-1">Flexible Learning</h4>
                        <p class="text-sm text-slate-300">Study anytime through our digital platform.</p>
                </div>

                <div class="flex items-start gap-4">
                    <span class="text-[#55b6bb] text-2xl leading-none mt-0.5">•</span>
                    <div>
                        <h4 class="text-base font-bold text-white leading-tight mb-1">Flexible Learning</h4>
                        <p class="text-sm text-slate-300">Study anytime through our digital platform.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


{{-- MARQUEE STRIP --}}
{{-- MARQUEE STRIP --}}
<div class="marquee-strip overflow-hidden py-5 bg-blue-50 border-y border-blue-100">
    <div class="marquee-track flex gap-10 w-max">
        @php
        $marqueeItems = [
        'IELTS Preparation', 'TOEFL Training', 'Academic Writing', 'Public Speaking',
        'Grammar Mastery', 'Vocabulary Builder', 'Listening Skills', 'Pronunciation',
        'Business English', 'TOEIC Prep', 'Reading Skills', 'Daily Conversation',
        ];
        $marqueeItems = [
        'IELTS Preparation', 'TOEFL Training', 'Academic Writing', 'Public Speaking',
        'Grammar Mastery', 'Vocabulary Builder', 'Listening Skills', 'Pronunciation',
        'Business English', 'TOEIC Prep', 'Reading Skills', 'Daily Conversation',
        ];
        @endphp
        @foreach(array_merge($marqueeItems, $marqueeItems) as $item)
        <div class="marquee-item flex items-center gap-2.5 text-xs font-bold text-blue-600 uppercase tracking-widest whitespace-nowrap">
            <span class="w-[5px] h-[5px] rounded-full bg-blue-400 flex-shrink-0"></span>
            {{ $item }}
        </div>
        <div class="marquee-item flex items-center gap-2.5 text-xs font-bold text-blue-600 uppercase tracking-widest whitespace-nowrap">
            <span class="w-[5px] h-[5px] rounded-full bg-blue-400 flex-shrink-0"></span>
            {{ $item }}
        </div>
        @endforeach
    </div>
</div>

{{-- SECTION 6 — WHY CHOOSE US --}}
<section class="py-24 bg-white overflow-hidden" id="why-choose-us">
    <div class="max-w-[1200px] mx-auto px-[5%]">
        <div class="text-center mb-16">
            <span class="bg-blue-50 text-blue-600 px-4 py-1.5 rounded-full text-xs font-bold mb-6 inline-block uppercase tracking-widest">
                Why Choose Us
{{-- SECTION 6 — WHY CHOOSE US --}}
<section class="py-24 bg-white overflow-hidden" id="why-choose-us">
    <div class="max-w-[1200px] mx-auto px-[5%]">
        <div class="text-center mb-16">
            <span class="bg-blue-50 text-blue-600 px-4 py-1.5 rounded-full text-xs font-bold mb-6 inline-block uppercase tracking-widest">
                Why Choose Us
            </span>
            <h2 class="text-4xl lg:text-5xl font-extrabold text-[#1a3a5a] mb-6 leading-[1.1]">
                All-in-one platform for English <br class="hidden md:block"> learning and test preparation 
            <h2 class="text-4xl lg:text-5xl font-extrabold text-[#1a3a5a] mb-6 leading-[1.1]">
                All-in-one platform for English <br class="hidden md:block"> learning and test preparation 
            </h2>
        </div>
    </div>

    {{-- PUZZLE BOARD --}}
    <div class="puzzle-board">
        {{-- TOEIC --}}
        <div class="piece p-kiri-atas">
            <img src="{{ asset('assets/puzzle/kiri-atas.png') }}" alt="TOEIC Piece">
            <div class="puzzle-text-content t-toeic">
                <h3>TOEIC</h3>
                <p>Focus on workplace communication skills, including business conversations, emails, and daily office situations.</p>
            </div>

    {{-- PUZZLE BOARD --}}
    <div class="puzzle-board">
        {{-- TOEIC --}}
        <div class="piece p-kiri-atas">
            <img src="{{ asset('assets/puzzle/kiri-atas.png') }}" alt="TOEIC Piece">
            <div class="puzzle-text-content t-toeic">
                <h3>TOEIC</h3>
                <p>Focus on workplace communication skills, including business conversations, emails, and daily office situations.</p>
            </div>
        </div>

        {{-- TENGAH ATAS --}}
        <div class="piece p-tengah-atas flex items-center justify-center">
            <img src="{{ asset('assets/puzzle/tengah-atas.png') }}" alt="Middle Top Piece">
            <img src="{{ asset('images/owl.png') }}" class="absolute z-20 w-[180px] owl-one" alt="Owl">
        {{-- TENGAH ATAS --}}
        <div class="piece p-tengah-atas flex items-center justify-center">
            <img src="{{ asset('assets/puzzle/tengah-atas.png') }}" alt="Middle Top Piece">
            <img src="{{ asset('images/owl.png') }}" class="absolute z-20 w-[180px] owl-one" alt="Owl">
        </div>

        {{-- IELTS --}}
        <div class="piece p-kanan-atas">
            <img src="{{ asset('assets/puzzle/kanan-atas.png') }}" alt="IELTS Piece">
            <div class="puzzle-text-content t-ielts">
                <h3>IELTS</h3>
                <p>Designed for academic and international purposes, covering listening, reading, writing, and speaking.</p>
            </div>
        {{-- IELTS --}}
        <div class="piece p-kanan-atas">
            <img src="{{ asset('assets/puzzle/kanan-atas.png') }}" alt="IELTS Piece">
            <div class="puzzle-text-content t-ielts">
                <h3>IELTS</h3>
                <p>Designed for academic and international purposes, covering listening, reading, writing, and speaking.</p>
            </div>
        </div>

        {{-- LMS --}}
        <div class="piece p-kiri-bawah">
            <img src="{{ asset('assets/puzzle/kiri-bawah.png') }}" alt="LMS Piece">
            <div class="puzzle-text-content t-lms">
                <h3>LMS</h3>
                <p>A flexible learning system to track progress, access materials, and improve English skills at your own pace.</p>
            </div>
        {{-- LMS --}}
        <div class="piece p-kiri-bawah">
            <img src="{{ asset('assets/puzzle/kiri-bawah.png') }}" alt="LMS Piece">
            <div class="puzzle-text-content t-lms">
                <h3>LMS</h3>
                <p>A flexible learning system to track progress, access materials, and improve English skills at your own pace.</p>
            </div>
        </div>

        {{-- TOEFL --}}
        <div class="piece p-tengah-bawah">
            <img src="{{ asset('assets/puzzle/tengah-bawah.png') }}" alt="TOEFL Piece">
            <div class="puzzle-text-content t-toefl">
                <h3>TOEFL</h3>
                <p>Focuses on academic English used in universities, including lectures, essays, and campus discussions.</p>
            </div>
        {{-- TOEFL --}}
        <div class="piece p-tengah-bawah">
            <img src="{{ asset('assets/puzzle/tengah-bawah.png') }}" alt="TOEFL Piece">
            <div class="puzzle-text-content t-toefl">
                <h3>TOEFL</h3>
                <p>Focuses on academic English used in universities, including lectures, essays, and campus discussions.</p>
            </div>
        </div>

        {{-- KANAN BAWAH --}}
        <div class="piece p-kanan-bawah flex items-center justify-center">
            <img src="{{ asset('assets/puzzle/kanan-bawah.png') }}" alt="Bottom Right Piece">
            <img src="{{ asset('images/owl.png') }}" class="absolute z-20 w-[150px] owl-two" alt="Owl">
        {{-- KANAN BAWAH --}}
        <div class="piece p-kanan-bawah flex items-center justify-center">
            <img src="{{ asset('assets/puzzle/kanan-bawah.png') }}" alt="Bottom Right Piece">
            <img src="{{ asset('images/owl.png') }}" class="absolute z-20 w-[150px] owl-two" alt="Owl">
        </div>
    </div>
</section>

{{-- SECTION 7 — TESTIMONIALS + STATISTIC BAR --}}
<section class="testi-section py-24 overflow-hidden bg-white" id="testimonials">
{{-- SECTION 7 — TESTIMONIALS + STATISTIC BAR --}}
<section class="testi-section py-24 overflow-hidden bg-white" id="testimonials">
    <div class="max-w-[1200px] mx-auto px-[5%]">
        @php
        $displayColA = [
        ['name' => 'Arran Douglas', 'achievement' => 'IELTS Score: 7.5 → 8.0', 'quote' => 'The modules at IC.EDU were very easy to understand. The LMS monitored my progress every day.'],
        ['name' => 'Jeffrey Avery', 'achievement' => 'TOEFL iBT: 89 → 107', 'quote' => 'I really enjoyed the online test platform. The interface has a simple, fast, and the UI/UX is comfortable.']
        ];

        $displayColB = [
        ['name' => 'Amanda Banks', 'achievement' => 'Business English Certified', 'quote' => 'This platform made my English preparation more effective. The results were beyond my expectations.']
        ];
        @endphp
        @php
        $displayColA = [
        ['name' => 'Arran Douglas', 'achievement' => 'IELTS Score: 7.5 → 8.0', 'quote' => 'The modules at IC.EDU were very easy to understand. The LMS monitored my progress every day.'],
        ['name' => 'Jeffrey Avery', 'achievement' => 'TOEFL iBT: 89 → 107', 'quote' => 'I really enjoyed the online test platform. The interface has a simple, fast, and the UI/UX is comfortable.']
        ];

        $displayColB = [
        ['name' => 'Amanda Banks', 'achievement' => 'Business English Certified', 'quote' => 'This platform made my English preparation more effective. The results were beyond my expectations.']
        ];
        @endphp
        <div class="grid lg:grid-cols-[400px_1fr] gap-16 items-center">
            <div>
                <div class="mb-6">
                    <svg width="60" height="45" viewBox="0 0 80 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.8571 0V30H0V60H34.2857V0H22.8571ZM68.5714 0V30H45.7143V60H80V0H68.5714Z" fill="#1a3a5a" />
                    </svg>
            <div>
                <div class="mb-6">
                    <svg width="60" height="45" viewBox="0 0 80 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.8571 0V30H0V60H34.2857V0H22.8571ZM68.5714 0V30H45.7143V60H80V0H68.5714Z" fill="#1a3a5a" />
                    </svg>
                </div>
                <h2 class="testi-title text-4xl lg:text-5xl mb-6">
                    Stories from<br>IC.EDU<br>Learners
                <h2 class="testi-title text-4xl lg:text-5xl mb-6">
                    Stories from<br>IC.EDU<br>Learners
                </h2>
                <p class="text-slate-500 text-lg max-w-[320px]">Read what our students have to say about their journey.</p>
                <p class="text-slate-500 text-lg max-w-[320px]">Read what our students have to say about their journey.</p>
            </div>
            <div class="hidden lg:grid grid-cols-2 gap-6" style="height: 600px;">
            <div class="hidden lg:grid grid-cols-2 gap-6" style="height: 600px;">
                <div class="testi-col-wrap">
                    <div class="testi-track testi-track-up">
                        @foreach(array_merge($displayColA, $displayColA, $displayColA) as $t)
                        <div class="bg-white border border-slate-100 p-8 rounded-[32px] shadow-sm">
                            <div class="text-amber-400 mb-4 text-sm">★★★★★</div>
                            <p class="text-slate-600 mb-6 italic">"{{ $t['quote'] }}"</p>
                            <div class="flex items-center gap-4">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($t['name']) }}&background=1a3a5a&color=fff" class="w-11 h-11 rounded-full">
                                <div>
                                    <div class="font-bold text-[#1a3a5a] text-sm">{{ $t['name'] }}</div>
                                    <div class="text-xs text-slate-400">{{ $t['achievement'] }}</div>
                                </div>
                            </div>
                        </div>
                        @foreach(array_merge($displayColA, $displayColA, $displayColA) as $t)
                        <div class="bg-white border border-slate-100 p-8 rounded-[32px] shadow-sm">
                            <div class="text-amber-400 mb-4 text-sm">★★★★★</div>
                            <p class="text-slate-600 mb-6 italic">"{{ $t['quote'] }}"</p>
                            <div class="flex items-center gap-4">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($t['name']) }}&background=1a3a5a&color=fff" class="w-11 h-11 rounded-full">
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
                <div class="testi-col-wrap mt-12">
                    <div class="testi-track testi-track-down">
                        @foreach(array_merge($displayColB, $displayColB, $displayColB) as $t)
                        <div class="bg-white border border-slate-100 p-8 rounded-[32px] shadow-sm">
                            <div class="text-amber-400 mb-4 text-sm">★★★★★</div>
                            <p class="text-slate-600 mb-6 italic">"{{ $t['quote'] }}"</p>
                            <div class="flex items-center gap-4">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($t['name']) }}&background=1a3a5a&color=fff" class="w-11 h-11 rounded-full">
                                <div>
                                    <div class="font-bold text-[#1a3a5a] text-sm">{{ $t['name'] }}</div>
                                    <div class="text-xs text-slate-400">{{ $t['achievement'] }}</div>
                                </div>
                            </div>
                        </div>
                        @foreach(array_merge($displayColB, $displayColB, $displayColB) as $t)
                        <div class="bg-white border border-slate-100 p-8 rounded-[32px] shadow-sm">
                            <div class="text-amber-400 mb-4 text-sm">★★★★★</div>
                            <p class="text-slate-600 mb-6 italic">"{{ $t['quote'] }}"</p>
                            <div class="flex items-center gap-4">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($t['name']) }}&background=1a3a5a&color=fff" class="w-11 h-11 rounded-full">
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
        </div>
    </div>
    
    <div class="py-10 bg-white border-t border-b border-slate-100 mt-12">
        <div class="max-w-[1100px] mx-auto px-[5%]">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                <div class="flex flex-col items-center">
                    <div class="text-2xl lg:text-3xl font-extrabold text-[#1a3a5a] mb-1">
                        <span class="counter" data-target="250">0</span>K +
                    </div>
                    <div class="text-[10px] lg:text-[11px] font-bold text-[#1a3a5a] uppercase tracking-widest opacity-70">Premium Courses</div>
                </div>
                <div class="flex flex-col items-center">
                    <div class="text-2xl lg:text-3xl font-extrabold text-[#1a3a5a] mb-1">
                        <span class="counter" data-target="500">0</span>K+
                    </div>
                    <div class="text-[10px] lg:text-[11px] font-bold text-[#1a3a5a] uppercase tracking-widest opacity-70">Active Learner</div>
                </div>
                <div class="flex flex-col items-center">
                    <div class="text-2xl lg:text-3xl font-extrabold text-[#1a3a5a] mb-1">
                        <span class="counter" data-target="98">0</span>%
                    </div>
                    <div class="text-[10px] lg:text-[11px] font-bold text-[#1a3a5a] uppercase tracking-widest opacity-70">Face Rate</div>
                </div>
                <div class="flex flex-col items-center">
                    <div class="text-2xl lg:text-3xl font-extrabold text-[#1a3a5a] mb-1">
                        <span class="counter" data-target="100">0</span>K+
                    </div>
                    <div class="text-[10px] lg:text-[11px] font-bold text-[#1a3a5a] uppercase tracking-widest opacity-70">Certificates Issued</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- SECTION: UNLOCK ENGLISH SKILLS --}}
<section class="relative bg-white pt-32 pb-0 overflow-hidden text-center">
    <div class="absolute top-[10%] left-[8%] floating-cloud" style="animation-delay: 0s;">
        <img src="{{ asset('assets/maskot/awan 1.png') }}" alt="Cloud" class="w-24 lg:w-32">
    </div>
    <div class="absolute bottom-[15%] left-[5%] floating-cloud" style="animation-delay: 3s;">
        <img src="{{ asset('assets/maskot/awan 3.png') }}" alt="Cloud" class="w-20 lg:w-28">
    </div>
    <div class="absolute bottom-[35%] left-[25%] floating-cloud" style="animation-delay: 1.3s;">
        <img src="{{ asset('assets/maskot/awan 2.png') }}" alt="Cloud" class="w-24 lg:w-28">
    </div>
    <div class="absolute top-[15%] right-[12%] floating-cloud" style="animation-delay: 2s;">
        <img src="{{ asset('assets/maskot/awan 5.png') }}" alt="Cloud" class="w-24 lg:w-32">
    </div>
    <div class="absolute bottom-[25%] right-[5%] floating-cloud" style="animation-delay: 4.5s;">
        <img src="{{ asset('assets/maskot/awan 4.png') }}" alt="Cloud" class="w-24 lg:w-32">
    </div>
    
    <div class="relative z-10 px-[5%] mb-16">
        <h2 class="text-4xl lg:text-6xl font-extrabold mb-10 leading-tight text-[#1a3a5a]">
            Unlock English Skills <br> Anytime, Anywhere
        </h2>
        <a href="{{ route('register') }}" class="inline-block bg-[#1a3a5a] hover:bg-[#2c4e7a] text-white px-12 py-4 rounded-full font-bold text-xl transition-all shadow-xl shadow-blue-100">
            Get Started – Its Free Trial
        </a>
    </div>
    
    <div class="flex justify-center relative">
        <div class="w-[300px] lg:w-[500px] -mb-64 lg:-mb-80">
            <img src="{{ asset('assets/maskot/bumi.png') }}" class="rotating-earth w-full h-auto opacity-90" alt="World Map">
        </div>
    </div>
</section>

<script>
    const counters = document.querySelectorAll('.counter');
    const speed = 200;

    const startCounter = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = +entry.target.getAttribute('data-target');
                const updateCount = () => {
                    const currentCount = +entry.target.innerText;
                    const increment = target / speed;
                    if (currentCount < target) {
                        if (target % 1 !== 0) {
                            entry.target.innerText = (currentCount + increment).toFixed(1);
                        } else {
                            entry.target.innerText = Math.ceil(currentCount + increment);
                        }
                        setTimeout(updateCount, 1);
                    } else {
                        entry.target.innerText = target;
                    }
                };
                updateCount();
                observer.unobserve(entry.target);
            }
        });
    };

    const observer = new IntersectionObserver(startCounter, { threshold: 0.5 });
    counters.forEach(counter => observer.observe(counter));
</script>
<script>
    const counters = document.querySelectorAll('.counter');
    const speed = 200;

    const startCounter = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = +entry.target.getAttribute('data-target');
                const updateCount = () => {
                    const currentCount = +entry.target.innerText;
                    const increment = target / speed;
                    if (currentCount < target) {
                        if (target % 1 !== 0) {
                            entry.target.innerText = (currentCount + increment).toFixed(1);
                        } else {
                            entry.target.innerText = Math.ceil(currentCount + increment);
                        }
                        setTimeout(updateCount, 1);
                    } else {
                        entry.target.innerText = target;
                    }
                };
                updateCount();
                observer.unobserve(entry.target);
            }
        });
    };

    const observer = new IntersectionObserver(startCounter, { threshold: 0.5 });
    counters.forEach(counter => observer.observe(counter));
</script>
@endsection