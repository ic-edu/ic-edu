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

    .topic-pill:hover {
        background: #2563eb;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.25);
    }

    /* ── Marquee scroll ── */
    .marquee-track {
        animation: marquee 28s linear infinite;
    }

    @verbatim @keyframes marquee {
        from {
            transform: translateX(0);
        }

        to {
            transform: translateX(-50%);
        }
    }

    @endverbatim

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
        animation-name: testiScrollUp;
        animation-duration: 30s;
    }

    .testi-track-down {
        animation-name: testiScrollDown;
        animation-duration: 36s;
    }

    .testi-col-wrap:hover .testi-track {
        animation-play-state: paused;
    }

    @verbatim @keyframes testiScrollUp {
        0% {
            transform: translateY(0);
        }

        100% {
            transform: translateY(-50%);
        }
    }

    @keyframes testiScrollDown {
        0% {
            transform: translateY(-50%);
        }

        100% {
            transform: translateY(0);
        }
    }

    @endverbatim .testi-item {
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

    /* Animasi Bumi Berputar */
    .rotating-earth {
        animation: rotateEarth 60s linear infinite;
        transform-origin: center;
    }

    @keyframes rotateEarth {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    /* Animasi Awan Melayang */
    .floating-cloud {
        animation: cloudFloat 6s ease-in-out infinite;
    }

    @keyframes cloudFloat {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-20px);
        }
    }

    /* ... kode lainnya ... */

    /* Animasi Scroll Ke Atas */
    @keyframes testiScrollUp {
        0% {
            transform: translateY(0);
        }

        100% {
            transform: translateY(-50%);
        }
    }

    /* Animasi Scroll Ke Bawah */
    @keyframes testiScrollDown {
        0% {
            transform: translateY(-50%);
        }

        100% {
            transform: translateY(0);
        }
    }

    .testi-track-up {
        animation: testiScrollUp 30s linear infinite;
    }

    .testi-track-down {
        animation: testiScrollDown 35s linear infinite;
    }

    /* Agar animasi berhenti saat di-hover */
    .testi-col-wrap:hover .testi-track {
        animation-play-state: paused;
    }

    /* Gaya tulisan header testimonial */
    .testi-title {
        font-family: 'Poppins', sans-serif;
        color: #1a3a5a;
        /* Navy sesuai desain kamu */
        font-weight: 800;
        line-height: 1.1;
    }

    /* Board Tempat Menyusun Puzzle */
    .puzzle-board {
        position: relative;
        width: 100%;
        max-width: 1200px;
        height: 600px;
        Tinggi disesuaikan dengan proporsi puzzle margin: 40px auto 0 auto;
    }

    /* Setiap Potongan Puzzle */
    /* .puzzle-piece {
        position: absolute;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        cursor: pointer;
    } */

    /* .puzzle-piece img:first-child {
        width: 100%;
        height: auto;
        display: block;
    } */

    /* .puzzle-piece:hover {
        transform: scale(1.05) translateY(-10px);
        z-index: 99 !important;
        filter: drop-shadow(0 25px 35px rgba(0, 0, 0, 0.3));
    } */

    /* =========================================================
   PUZZLE BOARD FINAL
   ========================================================= */

    .puzzle-board {
        position: relative;
        width: 1200px;
        height: 720px;
        margin: 0 auto;
        overflow: visible;
    }

    /* =========================================================
   PIECE BASE
   ========================================================= */

    .piece {
        position: absolute;
        transition:
            transform .35s cubic-bezier(.175, .885, .32, 1.275),
            filter .35s ease,
            z-index .2s ease;

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

    /* =========================================================
   HOVER EFFECT
   ========================================================= */

    .piece:hover {
        transform: translateY(-14px) scale(1.03);
        z-index: 99;

        filter:
            drop-shadow(0 25px 35px rgba(0, 0, 0, .28));
    }

    /* =========================================================
   PUZZLE POSITIONS
   Sesuaikan lagi dikit kalau PNG berubah ukuran
   ========================================================= */

    /* ===== TOP ===== */

    .p-kiri-atas {
        width: 523px;
        top: 0;
        left: -15px;
        z-index: 5;
    }

    .p-tengah-atas {
        width: 331px;
        top: 0;
        left: 455px;
        z-index: 2;
    }

    .p-kanan-atas {
        width: 492px;
        top: 0;
        left: 723px;
        z-index: 4;
    }

    /* ===== BOTTOM ===== */

    .p-kiri-bawah {
        width: 480px;
        top: 244px;
        left: -15px;
        z-index: 3;
    }

    .p-tengah-bawah {
        width: 505px;
        top: 244px;
        left: 400px;
        z-index: 1;
    }

    .p-kanan-bawah {
        width: 383px;
        top: 172px;
        left: 833px;
        z-index: 6;
    }

    /* =========================================================
   TEXT CONTENT
   ========================================================= */

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

    /* =========================================================
   TEXT POSITIONS
   ========================================================= */

    .t-toeic {
        top: 40px;
        left: 45px;
        color: white;
    }

    .t-ielts {
        top: 15px;
        right: 45px;
        text-align: right;
        color: white;
    }

    .t-lms {
        bottom: 30px;
        left: 45px;
        color: #1A3A5A;
    }

    .t-toefl {
        bottom: 55px;
        left: 100px;
        color: white;
    }

    /* =========================================================
   OWL
   ========================================================= */

    .owl-main {
        position: absolute;
        z-index: 25;

        width: 180px;
        top: 25%;
        left: 50%;

        transform: translateX(-50%);
        pointer-events: none;
    }

    .owl-second {
        position: absolute;
        z-index: 25;

        width: 150px;
        top: 25%;
        left: 50%;

        transform: translateX(-50%);
        pointer-events: none;
    }

    /* =========================================================
   FLOATING ANIMATION
   ========================================================= */

    .floating {
        animation: floating 4s ease-in-out infinite;
    }

    @keyframes floating {
        0% {
            transform: translateX(-50%) translateY(0px);
        }

        50% {
            transform: translateX(-50%) translateY(-12px);
        }

        100% {
            transform: translateX(-50%) translateY(0px);
        }
    }

    /* =========================================================
   RESPONSIVE
   ========================================================= */

    @media (max-width: 1280px) {

        .puzzle-board {
            transform: scale(.9);
            transform-origin: top center;
            height: 650px;
        }
    }

    @media (max-width: 1024px) {

        .puzzle-board {
            width: 100%;
            height: auto;

            display: flex;
            flex-direction: column;
            gap: 24px;

            transform: none;
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

        .t-toeic,
        .t-ielts,
        .t-lms,
        .t-toefl {
            left: 40px !important;
            right: auto !important;
            top: 50% !important;
            bottom: auto !important;

            transform: translateY(-50%);
            text-align: left;
        }

        .t-toeic,
        .t-ielts,
        .t-toefl {
            color: white;
        }

        .t-lms {
            color: #1A3A5A;
        }

        .puzzle-text-content h3 {
            font-size: 2.4rem;
        }

        .puzzle-text-content p {
            max-width: 260px;
        }
    }

    @media (max-width: 640px) {

        .puzzle-text-content h3 {
            font-size: 2rem;
        }

        .puzzle-text-content p {
            font-size: .82rem;
            line-height: 1.5;
            max-width: 220px;
        }

        .owl-main {
            width: 120px;
        }

        .owl-second {
            width: 100px;
        }
    }

    /* Responsif: Jika layar kekecilan (Tablet/HP), kita ubah jadi susunan list normal */
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
            left: auto !important;
            right: auto !important;
            top: auto !important;
            bottom: auto !important;
            border-radius: 20px;
        }

        .puzzle-text-content {
            position: absolute;
            left: 0 !important;
            top: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: left !important;
            align-items: flex-start !important;
        }

        .t-lms,
        .t-toefl,
        .t-toeic,
        .t-ielts {
            color: white !important;
        }

        .t-lms h3,
        .t-lms p {
            color: #1A456C !important;
        }
    }
</style>

@endpush

@section('content')

{{-- ════════════════════════════════════════════════════════════════════════
     SECTION 1 — HERO
     ════════════════════════════════════════════════════════════════════════
     🔧 BACKEND (route):
        - route('register') → pastikan sudah terdaftar di web.php
        - route('login')    → idem

     🔧 BACKEND (data dinamis):
        - Angka "12,000+" dan rating "4.9" saat ini HARDCODE.
          Ganti dengan variabel dari controller, contoh:
            LandingController(at)index → return view('landing', compact('stats'))
            lalu: {{ $stats->total_students }} dan {{ $stats->avg_rating }}
- Avatar social proof pakai ui-avatars.com (placeholder).
Jika ingin foto real user, kirim $recentStudents dari controller
dan loop $recentStudents->profile_photo_url
════════════════════════════════════════════════════════════════════════ --}}
<section class="hero-section min-h-screen pt-24 pb-12 px-[5%] relative overflow-hidden flex items-center"
    style="background: linear-gradient(145deg, #eef4ff 0%, #e0eaff 40%, #f0f5ff 100%);">

    {{-- Decorative SVG doodles — pure visual, tidak butuh backend --}}
    <svg class="hero-doodle" style="top:14%;left:6%;width:90px;" viewBox="0 0 90 40" fill="none">
        <path d="M4 20 Q22 4 44 20 Q66 36 86 20" stroke="#2563eb" stroke-width="2.5" stroke-linecap="round" />
        <path d="M4 30 Q22 14 44 30 Q66 46 86 30" stroke="#2563eb" stroke-width="2.5" stroke-linecap="round" />
    </svg>
    <svg class="hero-doodle" style="top:20%;right:8%;width:60px;" viewBox="0 0 60 60" fill="none">
        <circle cx="30" cy="30" r="26" stroke="#2563eb" stroke-width="2" stroke-dasharray="6 5" />
    </svg>
    <svg class="hero-doodle" style="bottom:22%;left:3%;width:48px;" viewBox="0 0 48 48" fill="none">
        <path d="M8 24 L24 8 L40 24 L24 40 Z" stroke="#2563eb" stroke-width="2" />
    </svg>
    <div class="hero-doodle" style="bottom:30%;right:5%;font-size:2.2rem;opacity:0.1;">✦</div>

    <div class="max-w-[1160px] mx-auto w-full grid lg:grid-cols-[1fr_480px] gap-10 items-center relative z-10">

        {{-- LEFT: Headline + CTA + Social proof --}}
        <div data-reveal>
            <h1 class="text-[2.9rem] lg:text-[3.6rem] font-extrabold leading-[1.08] tracking-tight text-slate-900 mb-6">
                From Struggling<br>
                Learner to <span class="text-blue-600 relative">
                    Confident
                    <svg class="absolute -bottom-2 left-0 w-full" viewBox="0 0 200 12" fill="none" preserveAspectRatio="none">
                        <path d="M2 8 Q50 2 100 8 Q150 14 198 6" stroke="#2563eb" stroke-width="3" stroke-linecap="round" opacity="0.4" />
                    </svg>
                </span><br>
                English Speaker
            </h1>

            <p class="text-base text-slate-500 leading-[1.8] mb-8 max-w-[480px]">
                IC.EDU is your all-in-one English learning platform — built for Indonesians who want to ace IELTS, TOEFL, TOEIC,
                or simply speak English with confidence in the real world.
            </p>

            <div class="flex flex-wrap gap-3 mb-10">
                <a href="{{ route('register') }}"
                    class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full text-sm font-bold text-white
                          bg-blue-600 shadow-lg shadow-blue-300/50 hover:bg-blue-700 hover:-translate-y-0.5 transition-all">
                    Start Learning Free
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
                <a href="#courses"
                    class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full text-sm font-bold text-slate-700
                          bg-white border border-slate-200 hover:border-blue-400 hover:text-blue-600 shadow-sm transition-all">
                    Browse Courses
                </a>
            </div>

            {{-- Social proof --}}
            <div class="flex items-center gap-3 text-xs text-slate-500">
                <div class="flex">
                    {{-- 🔧 BACKEND: Ganti dengan foto real jika ada ($recentStudents) --}}
                    @foreach(['Rina+K/3b82f6', 'Budi+S/6366f1', 'Sari+W/0d9488', 'Dian+A/f59e0b'] as $av)
                    @php [$n, $c] = explode('/', $av) @endphp
                    <img src="https://ui-avatars.com/api/?name={{ $n }}&background={{ $c }}&color=fff&size=64"
                        class="w-8 h-8 rounded-full border-2 border-white -mr-2 object-cover" alt="">
                    @endforeach
                </div>
                {{-- 🔧 BACKEND: Ganti "12,000+" dengan {{ $stats->total_students }} --}}
                <span><strong class="text-slate-900 font-bold">12,000+</strong> students already learning</span>
                {{-- 🔧 BACKEND: Ganti "4.9" dengan {{ $stats->avg_rating }} --}}
                <span class="text-amber-500 font-bold">★★★★★ <span class="text-slate-500 font-normal">4.9</span></span>
            </div>
        </div>

        {{-- RIGHT: Hero card --}}
        <div class="hidden lg:block" data-reveal>
            <div class="relative pt-6 pb-16 pr-6 pl-10">

                {{-- Main gradient card --}}
                <div class="relative rounded-[28px] overflow-hidden"
                    style="background: linear-gradient(150deg,#1e40af 0%,#2563eb 60%,#3b82f6 100%); height: 460px;">
                    <div class="absolute -top-16 -right-16 w-64 h-64 rounded-full bg-white/[0.06]"></div>
                    <div class="absolute -bottom-10 -left-10 w-48 h-48 rounded-full bg-white/[0.05]"></div>

                    <div class="absolute top-8 left-8 z-10 max-w-[56%]">
                        <span class="inline-block bg-white/15 text-white/90 text-[0.62rem] font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-4">
                            🎓 IC.EDU Platform
                        </span>
                        {{-- 🔧 BACKEND: Ganti "12,000+" dengan {{ $stats->total_students }} --}}
                        <p class="text-white/60 text-[0.68rem] font-semibold uppercase tracking-widest mb-2">
                            Trusted by 12,000+ learners
                        </p>
                        <h2 class="text-white text-[1.4rem] font-extrabold leading-snug">
                            Your Path to<br>English Fluency<br>Starts Here
                        </h2>
                    </div>

                    {{-- 🔧 BACKEND: Ganti dengan asset lokal, misal: asset('assets/hero-student.jpg') --}}
                    <img src="https://images.unsplash.com/photo-1529390079861-591de354faf5?auto=format&fit=crop&w=600&q=80"
                        alt="Happy student"
                        class="absolute bottom-0 right-0 h-full w-[62%] object-cover object-top"
                        style="mask-image: linear-gradient(to left, black 55%, transparent 100%);
                                -webkit-mask-image: linear-gradient(to left, black 55%, transparent 100%);">
                </div>

                {{-- "Did you know?" floating card --}}
                <div class="did-you-know-card absolute bottom-4 -left-2 w-[265px] bg-white rounded-2xl shadow-2xl shadow-slate-200/80 p-4 border border-slate-100 z-20">
                    <div class="flex items-center gap-2.5 mb-2.5">
                        <div class="w-8 h-8 rounded-xl bg-blue-600 flex items-center justify-center flex-shrink-0">
                            <svg width="14" height="14" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 110 20A10 10 0 0112 2z" />
                            </svg>
                        </div>
                        <span class="text-sm font-extrabold text-slate-800">Did you know?</span>
                    </div>
                    <p class="text-[0.76rem] text-slate-500 leading-[1.7]">
                        IC.EDU is not just a course platform — it's your personal English coach. AI-powered feedback,
                        live sessions, and certified instructors to turn your goals into results.
                    </p>
                    {{-- Topic pills — sepenuhnya statis, tidak butuh backend --}}
                    <div class="flex flex-wrap gap-1.5 mt-3">
                        @foreach(['IELTS', 'TOEFL', 'TOEIC', 'Speaking', 'Writing', 'Listening', 'Grammar'] as $pill)
                        <span class="topic-pill text-[0.65rem] font-bold text-slate-600 bg-slate-100 px-2.5 py-1 rounded-full cursor-default">
                            {{ $pill }}
                        </span>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>


{{-- ════════════════════════════════════════════════════════════════════════
     SECTION 2 — WHY IC.EDU
     ════════════════════════════════════════════════════════════════════════
     🔧 BACKEND: Konten 4 card saat ini HARDCODE di (at)foreach.
        Untuk dynamic: buat tabel `features`, kirim $features dari controller,
        lalu ganti (at)foreach array hardcode dengan (at)foreach($features as $f).
        Field yang dibutuhkan: icon (emoji), bg_color, title, description.
     ════════════════════════════════════════════════════════════════════════ --}}
<section class="py-24 px-[5%]" id="why">
    <div class="max-w-[1160px] mx-auto">

        <div class="text-center max-w-xl mx-auto mb-14" data-reveal>
            <span class="inline-block bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full mb-4">
                Why Choose Us
            </span>
            <h2 class="text-3xl lg:text-4xl font-extrabold tracking-tight leading-[1.15] mb-3">
                Smart Learning, Real Results
            </h2>
            <p class="text-slate-500 leading-7">
                We make learning effective, enjoyable, and personalized — so you stay motivated and actually finish what you start.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- 🔧 BACKEND: Data hardcode — ganti dengan $features dari controller jika dynamic --}}
            @foreach([
            ['🧠', '#eff6ff', 'Learn Smarter', 'Personalized AI-powered lessons adapt to your level and goals. No wasted time on things you already know.'],
            ['📅', '#f5f3ff', 'Built for Your Schedule', 'Learn anytime, anywhere. Pick up where you left off on any device, even on your coffee break.'],
            ['🏆', '#fef9c3', 'Learn from the Best', "Expert instructors. Top-tier professionals and practitioners who know what they're teaching."],
            ['🤝', '#dcfce7', 'Community-Powered', 'Join groups, ask questions, and build your confidence with others on the same journey.'],
            ] as [$icon, $bg, $title, $desc])
            <div class="bg-[#f8faff] border border-slate-200 rounded-[20px] p-7
                            hover:bg-white hover:shadow-xl hover:shadow-blue-100 hover:-translate-y-1 hover:border-blue-100
                            transition-all cursor-default" data-reveal>
                <div class="w-[52px] h-[52px] rounded-[14px] flex items-center justify-center text-2xl mb-4"
                    style="background: {{ $bg }};">{{ $icon }}</div>
                <h4 class="text-sm font-bold mb-2">{{ $title }}</h4>
                <p class="text-xs text-slate-500 leading-[1.6]">{{ $desc }}</p>
            </div>
            @endforeach
        </div>

    </div>
</section>


{{-- ════════════════════════════════════════════════════════════════════════
     MARQUEE STRIP — sepenuhnya statis, tidak butuh backend
     ════════════════════════════════════════════════════════════════════════ --}}
<div class="marquee-strip overflow-hidden py-5 bg-blue-50 border-y border-blue-100">
    <div class="marquee-track flex gap-10 w-max">
        @php
        $marqueeItems = [
        'IELTS Preparation', 'TOEFL Training', 'Academic Writing', 'Public Speaking',
        'Grammar Mastery', 'Vocabulary Builder', 'Listening Skills', 'Pronunciation',
        'Business English', 'TOEIC Prep', 'Reading Skills', 'Daily Conversation',
        ];
        @endphp
        {{-- Duplikat array untuk looping seamless --}}
        @foreach(array_merge($marqueeItems, $marqueeItems) as $item)
        <div class="marquee-item flex items-center gap-2.5 text-xs font-bold text-blue-600 uppercase tracking-widest whitespace-nowrap">
            <span class="w-[5px] h-[5px] rounded-full bg-blue-400 flex-shrink-0"></span>
            {{ $item }}
        </div>
        @endforeach
    </div>
</div>


{{-- ════════════════════════════════════════════════════════════════════════
     SECTION 3 — COURSE CATEGORIES
     ════════════════════════════════════════════════════════════════════════
     🔧 BACKEND (data):
        - $courseCards saat ini HARDCODE di (at)php block di bawah.
          Untuk dynamic: buat tabel `course_categories` dengan kolom:
            (svg_file, thumb_bg, accent_color, badge_bg, badge_label,
             meta_text, title, description)
          Kirim dari controller: LandingController(at)index → compact('courseCategories')
          Lalu ganti (at)php hardcode dengan: (at)foreach($courseCategories as $card)

     🔧 BACKEND (asset SVG):
        - File ilustrasi HARUS ada di folder: public/assets/
            ✓ undraw_followers_m4z4.svg        → Listening
            ✓ undraw_learning-to-sketch_uaxi.svg → Speaking
            ✓ undraw_schedule_ry1w.svg          → Reading
            ✓ undraw_tasting_cd81.svg           → Grammar

     🔧 BACKEND (route):
        - route('#') → harus terdaftar di web.php
          dan CourseController(at)index harus sudah dibuat
     ════════════════════════════════════════════════════════════════════════ --}}
<section class="course-section py-24 px-[5%] bg-[#f8faff]" id="courses">
    <div class="max-w-[1160px] mx-auto">

        <div class="text-center max-w-xl mx-auto mb-14" data-reveal>
            <span class="inline-block bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full mb-4">
                Course Categories
            </span>
            <h2 class="text-3xl lg:text-4xl font-extrabold tracking-tight leading-[1.15] mb-3">
                Every Skill You Need to Speak with Confidence
            </h2>
            <p class="text-slate-500 leading-7">
                Structured, expert-led courses designed for real-world English — not just exams.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

            {{-- 🔧 BACKEND: Ganti (at)php block ini dengan data dari controller ($courseCategories) --}}
            @php
            $courseCards = [
            [
            'svg' => 'undraw_followers_m4z4.svg',
            'thumbBg' => '#dbeafe',
            'accent' => '#1d4ed8',
            'badgeBg' => '#eff6ff',
            'badge' => 'Foundation',
            'meta' => '24 Lessons · All Levels',
            'title' => 'Advanced Listening Comprehension',
            'desc' => 'Train your ear with native speakers, podcasts, and IELTS audio.',
            ],
            [
            'svg' => 'undraw_learning-to-sketch_uaxi.svg',
            'thumbBg' => '#ede9fe',
            'accent' => '#6d28d9',
            'badgeBg' => '#f5f3ff',
            'badge' => 'Most Popular',
            'meta' => '18 Lessons · Beginner+',
            'title' => 'Fluent & Confident Speaking',
            'desc' => 'Break the fear barrier with structured drills and live speaking clubs.',
            ],
            [
            'svg' => 'undraw_schedule_ry1w.svg',
            'thumbBg' => '#dcfce7',
            'accent' => '#15803d',
            'badgeBg' => '#f0fdf4',
            'badge' => 'Academic',
            'meta' => '20 Lessons · Intermediate',
            'title' => 'Academic Reading Mastery',
            'desc' => 'Speed-read complex texts and master skimming & scanning techniques.',
            ],
            [
            'svg' => 'undraw_tasting_cd81.svg',
            'thumbBg' => '#fef9c3',
            'accent' => '#a16207',
            'badgeBg' => '#fefce8',
            'badge' => 'Core Skill',
            'meta' => '32 Lessons · All Levels',
            'title' => 'English Grammar Deep Dive',
            'desc' => 'From basic tenses to complex clauses — build the grammar foundation.',
            ],
            ];
            @endphp

            @foreach($courseCards as $card)
            <div class="course-card bg-white border border-slate-200 rounded-[20px] overflow-hidden
                            hover:-translate-y-1.5 hover:shadow-xl hover:shadow-blue-100 hover:border-blue-100
                            transition-all cursor-pointer group" data-reveal>

                {{-- Thumbnail dengan SVG ilustrasi --}}
                <div class="relative overflow-hidden flex items-end justify-center px-6 pt-6 pb-0"
                    style="background: {{ $card['thumbBg'] }}; height: 160px;">

                    {{-- Deco blob kanan atas — membesar saat hover --}}
                    <div class="absolute w-28 h-28 rounded-full opacity-20 -right-4 -top-4
                                    transition-transform duration-500 group-hover:scale-125"
                        style="background: {{ $card['accent'] }};"></div>

                    {{-- SVG ilustrasi dari public/assets/ --}}
                    <img src="{{ asset('assets/' . $card['svg']) }}"
                        alt="{{ $card['title'] }}"
                        class="relative z-10 w-full max-w-[148px] h-[130px] object-contain object-bottom
                                    transition-transform duration-500 group-hover:-translate-y-2 group-hover:scale-105
                                    drop-shadow-md">
                </div>

                {{-- Card body --}}
                <div class="p-5">
                    <span class="inline-block text-[0.68rem] font-bold uppercase tracking-wide px-2.5 py-1 rounded-full mb-2"
                        style="background: {{ $card['badgeBg'] }}; color: {{ $card['accent'] }};">
                        {{ $card['badge'] }}
                    </span>
                    <h3 class="text-sm font-bold text-slate-800 mb-1.5">{{ $card['title'] }}</h3>
                    <p class="text-xs text-slate-500 leading-[1.6] mb-4">{{ $card['desc'] }}</p>
                    <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                        <span class="text-xs text-slate-400 font-medium">{{ $card['meta'] }}</span>
                        {{-- Arrow button — berubah jadi solid saat hover --}}
                        <div class="w-[30px] h-[30px] rounded-full bg-blue-50 flex items-center justify-center
                                        group-hover:bg-blue-600 transition-colors duration-300">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"
                                viewBox="0 0 24 24"
                                class="text-blue-600 group-hover:text-white transition-colors duration-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

        {{-- 🔧 BACKEND: route('#') harus terdaftar di web.php --}}
        <div class="text-center mt-10" data-reveal>
            <a href="#"
                class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full text-sm font-bold text-white
                      bg-blue-600 shadow-lg shadow-blue-200 hover:bg-blue-700 hover:-translate-y-0.5 transition-all">
                View All Courses
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>

    </div>
</section>


{{-- ════════════════════════════════════════════════════════════════════════
     SECTION 4 — FEATURE SPLIT (Consistency tools)
     ════════════════════════════════════════════════════════════════════════
     🔧 BACKEND:
        - Foto dari Unsplash → ganti dengan asset lokal:
          asset('assets/feature-consistency.jpg') jika sudah punya
        - Checklist HARDCODE → bisa dynamic dari DB jika perlu
        - route('register') → harus terdaftar di web.php
     ════════════════════════════════════════════════════════════════════════ --}}
<section class="py-24 px-[5%]">
    <div class="max-w-[1160px] mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

        {{-- 🔧 BACKEND: Ganti src Unsplash dengan asset lokal jika sudah ada --}}
        <div class="rounded-3xl overflow-hidden shadow-2xl shadow-blue-100" data-reveal>
            <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?auto=format&fit=crop&w=800&q=80"
                alt="Built to keep you going" class="w-full block">
        </div>

        <div data-reveal>
            <span class="inline-block bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full mb-4">
                Built to Keep You Going
            </span>
            <h2 class="text-3xl lg:text-[2.2rem] font-extrabold tracking-tight leading-[1.2] mb-4">
                Stay consistent with tools that actually work
            </h2>
            <p class="text-sm text-slate-500 leading-7 mb-6">
                Stay consistent with gamified streaks, progress tracking, peer groups, and notifications that motivate — not annoy.
            </p>
            <ul class="flex flex-col gap-2.5 mb-7">
                @foreach(['Smart Learning Streaks', 'Gamified Progress', 'Peer Groups & Discussions', 'Mobile Friendly', 'Certificates That Matter'] as $item)
                <li class="flex items-center gap-2.5 text-sm font-semibold text-slate-900">
                    <span class="w-[22px] h-[22px] rounded-full bg-blue-50 text-blue-600 text-xs font-extrabold
                                     flex items-center justify-center flex-shrink-0">✓</span>
                    {{ $item }}
                </li>
                @endforeach
            </ul>
            <a href="{{ route('register') }}"
                class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full text-sm font-bold text-white
                      bg-blue-600 shadow-lg shadow-blue-200 hover:bg-blue-700 hover:-translate-y-0.5 transition-all">
                Start Learning Free
            </a>
        </div>

    </div>
</section>


{{-- ════════════════════════════════════════════════════════════════════════
     SECTION 5 — HOW IT WORKS
     ════════════════════════════════════════════════════════════════════════
     🔧 BACKEND: Konten 3 step card sepenuhnya HARDCODE — tidak butuh DB.
        Tidak ada route/auth dependency di section ini.
     ════════════════════════════════════════════════════════════════════════ --}}
<section class="how-section py-24 px-[5%] bg-gradient-to-br from-[#f0f7ff] to-[#e8f0fe]" id="how">
    <div class="max-w-[1160px] mx-auto">

        <div class="text-center max-w-xl mx-auto mb-14" data-reveal>
            <span class="inline-block bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full mb-4">
                The Process
            </span>
            <h2 class="text-3xl lg:text-4xl font-extrabold tracking-tight leading-[1.15] mb-3">
                Simple Steps to English Fluency
            </h2>
            <p class="text-slate-500 leading-7">
                From zero to confident speaker — our proven 3-step path gets you there faster than you think.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">

            {{-- Dashed connector line, tampil hanya di desktop --}}
            <div class="hidden md:block absolute top-11 left-[calc(16.66%+1.5rem)] right-[calc(16.66%+1.5rem)] h-px"
                style="background: repeating-linear-gradient(to right, #bfdbfe 0, #bfdbfe 8px, transparent 8px, transparent 16px);"></div>

            @foreach([
            ['01', '📋', 'Take a Placement Test', 'We assess your level across all 4 skills — Listening, Speaking, Reading, and Writing — in under 15 minutes.'],
            ['02', '🗺️', 'Get Your Personal Path', 'Our system builds a custom curriculum based on your goals, schedule, and target score or fluency level.'],
            ['03', '🏆', 'Learn, Practice & Achieve', 'Complete lessons, join live sessions, take mock tests, and earn certificates as you hit each milestone.'],
            ] as [$num, $icon, $title, $desc])
            <div class="how-card bg-white rounded-3xl p-8 text-center border border-blue-100 shadow-sm
                            hover:-translate-y-1.5 hover:shadow-xl hover:shadow-blue-100
                            transition-all relative z-[1]" data-reveal>
                <div class="w-14 h-14 rounded-full bg-blue-600 text-white text-xl font-extrabold
                                flex items-center justify-center mx-auto mb-5 shadow-md shadow-blue-300">
                    {{ $num }}
                </div>
                <div class="text-3xl mb-3">{{ $icon }}</div>
                <h4 class="text-sm font-bold mb-2">{{ $title }}</h4>
                <p class="text-xs text-slate-500 leading-[1.65]">{{ $desc }}</p>
            </div>
            @endforeach

        </div>

    </div>
</section>


{{-- ════════════════════════════════════════════════════════════════════════
     SECTION 6 — COMMUNITY SPLIT
     ════════════════════════════════════════════════════════════════════════
     🔧 BACKEND:
        - Foto dari Unsplash → ganti dengan asset lokal jika sudah ada
        - route('register') → harus terdaftar di web.php
     ════════════════════════════════════════════════════════════════════════ --}}
<section class="py-24 px-[5%]">
    <div class="max-w-[1160px] mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

        <div data-reveal>
            <span class="inline-block bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full mb-4">
                You're Not Learning Alone
            </span>
            <h2 class="text-3xl lg:text-[2.2rem] font-extrabold tracking-tight leading-[1.2] mb-4">
                Join a community of learners from across the world
            </h2>
            <p class="text-sm text-slate-500 leading-7 mb-6">
                At IC.EDU, learning means more than just watching lessons — it's about growing together.
                Our vibrant community connects learners from around the world so you can discuss topics,
                share progress, and find the accountability partner you need.
            </p>
            <ul class="flex flex-col gap-2.5 mb-7">
                @foreach(['Weekly Live Speaking Clubs', 'Peer Study Groups', 'Native Speaker Exchange', '24/7 Discussion Forums'] as $item)
                <li class="flex items-center gap-2.5 text-sm font-semibold text-slate-900">
                    <span class="w-[22px] h-[22px] rounded-full bg-blue-50 text-blue-600 text-xs font-extrabold
                                     flex items-center justify-center flex-shrink-0">✓</span>
                    {{ $item }}
                </li>
                @endforeach
            </ul>
            <a href="{{ route('register') }}"
                class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full text-sm font-bold text-white
                      bg-blue-600 shadow-lg shadow-blue-200 hover:bg-blue-700 hover:-translate-y-0.5 transition-all">
                Join Our Community
            </a>
        </div>

        {{-- 🔧 BACKEND: Ganti src Unsplash dengan asset lokal jika sudah ada --}}
        <div class="rounded-3xl overflow-hidden shadow-2xl shadow-blue-100" data-reveal>
            <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=800&q=80"
                alt="Community" class="w-full block">
        </div>

    </div>
</section>

<div class="marquee-strip overflow-hidden py-5 bg-blue-50 border-y border-blue-100">
    <div class="marquee-track flex gap-10 w-max">
        @php
        $marqueeItems = [
        'IELTS Preparation', 'TOEFL Training', 'Academic Writing', 'Public Speaking',
        'Grammar Mastery', 'Vocabulary Builder', 'Listening Skills', 'Pronunciation',
        'Business English', 'TOEIC Prep', 'Reading Skills', 'Daily Conversation',
        ];
        @endphp
        {{-- Duplikat array untuk looping seamless --}}
        @foreach(array_merge($marqueeItems, $marqueeItems) as $item)
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

        {{-- Header --}}
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="bg-blue-50 text-blue-600 px-4 py-1.5 rounded-full text-xs font-bold mb-6 inline-block uppercase tracking-widest">
                Why Choose Us
            </span>

            <h2 class="text-4xl lg:text-5xl font-extrabold text-[#1a3a5a] mb-6 leading-[1.1]">
                All-in-one platform for English
                <br class="hidden md:block">
                learning and test preparation 
            </h2>
        </div>

    </div>

    {{-- PUZZLE BOARD --}}
    <div class="puzzle-board">

        {{-- TOEIC --}}
        <div class="piece p-kiri-atas"
            data-aos="fade-right">

            <img src="{{ asset('assets/puzzle/kiri-atas.png') }}"
                alt="TOEIC Piece">

            <div class="puzzle-text-content t-toeic">
                <h3>TOEIC</h3>
                <p>
                    Focus on workplace communication skills,
                    including business conversations,
                    emails, and daily office situations.
                </p>
            </div>

        </div>

        {{-- TENGAH ATAS --}}
        <div class="piece p-tengah-atas flex items-center justify-center"
            data-aos="fade-down">

            <img src="{{ asset('assets/puzzle/tengah-atas.png') }}"
                alt="Middle Top Piece">

            {{-- OWL --}}
            <img src="{{ asset('images/owl.png') }}"
                class="absolute z-20 w-[180px] owl-one"
                alt="Owl">

        </div>


        {{-- IELTS --}}
        <div class="piece p-kanan-atas"
            data-aos="fade-left">

            <img src="{{ asset('assets/puzzle/kanan-atas.png') }}"
                alt="IELTS Piece">

            <div class="puzzle-text-content t-ielts">
                <h3>IELTS</h3>
                <p>
                    Designed for academic and international purposes,
                    covering listening, reading, writing,
                    and speaking.
                </p>
            </div>

        </div>


        {{-- LMS --}}
        <div class="piece p-kiri-bawah"
            data-aos="fade-right"
            data-aos-delay="200">

            <img src="{{ asset('assets/puzzle/kiri-bawah.png') }}"
                alt="LMS Piece">

            <div class="puzzle-text-content t-lms">
                <h3>LMS</h3>
                <p>
                    A flexible learning system to track progress,
                    access materials, and improve English skills
                    at your own pace.
                </p>
            </div>

        </div>


        {{-- TOEFL --}}
        <div class="piece p-tengah-bawah"
            data-aos="fade-up"
            data-aos-delay="400">

            <img src="{{ asset('assets/puzzle/tengah-bawah.png') }}"
                alt="TOEFL Piece">

            <div class="puzzle-text-content t-toefl">
                <h3>TOEFL</h3>
                <p>
                    Focuses on academic English used in universities,
                    including lectures, essays,
                    and campus discussions.
                </p>
            </div>

        </div>


        {{-- KANAN BAWAH --}}
        <div class="piece p-kanan-bawah flex items-center justify-center"
            data-aos="fade-left"
            data-aos-delay="200">

            <img src="{{ asset('assets/puzzle/kanan-bawah.png') }}"
                alt="Bottom Right Piece">

            {{-- OWL --}}
            <img src="{{ asset('images/owl.png') }}"
                class="absolute z-20 w-[150px] owl-two"
                alt="Owl">

        </div>

    </div>

</section>

{{-- SECTION 7 — TESTIMONIALS + STATISTIC BAR --}}
<section class="testi-section py-24 overflow-hidden bg-white" id="testimonials">
    <div class="max-w-[1200px] mx-auto px-[5%]">
        @php
        /* DEFINISI DATA LANGSUNG DI SINI BIAR GA ERROR UNDEFINED VARIABLE */
        $displayColA = [
        ['name' => 'Arran Douglas', 'achievement' => 'IELTS Score: 7.5 → 8.0', 'quote' => 'The modules at IC.EDU were very easy to understand. The LMS monitored my progress every day.'],
        ['name' => 'Jeffrey Avery', 'achievement' => 'TOEFL iBT: 89 → 107', 'quote' => 'I really enjoyed the online test platform. The interface has a simple, fast, and the UI/UX is comfortable.']
        ];

        $displayColB = [
        ['name' => 'Amanda Banks', 'achievement' => 'Business English Certified', 'quote' => 'This platform made my English preparation more effective. The results were beyond my expectations.']
        ];
        @endphp
        <div class="grid lg:grid-cols-[400px_1fr] gap-16 items-center">
            <div data-reveal>
                <div class="mb-6">
                    <svg width="60" height="45" viewBox="0 0 80 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.8571 0V30H0V60H34.2857V0H22.8571ZM68.5714 0V30H45.7143V60H80V0H68.5714Z" fill="#1a3a5a" />
                    </svg>
                </div>
                <h2 style="font-family: 'Poppins', sans-serif; color: #1a3a5a; font-weight: 800; line-height: 1.1; font-size: 3.2rem;" class="mb-6">
                    Stories from<br>IC.EDU<br>Learners
                </h2>
                <p class="text-slate-500 text-lg max-w-[320px]">Read what our students have to say about their journey.</p>
            </div>
            <div class="hidden lg:grid grid-cols-2 gap-6" style="height: 600px;">
                {{-- Kolom Kiri (UP) --}}
                <div class="testi-col-wrap">
                    <div class="testi-track testi-track-up flex flex-col gap-6">
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
                    <div class="testi-track testi-track-down flex flex-col gap-6">
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
                    <div style="font-weight: 800;" class="text-2xl lg:text-3xl text-[#1a3a5a] tracking-tight mb-1">
                        <span class="counter" data-target="250">0</span>K +
                    </div>
                    <div class="text-[10px] lg:text-[11px] font-bold text-[#1a3a5a] uppercase tracking-widest opacity-70">
                        Premium Courses
                    </div>
                </div>

                <div class="flex flex-col items-center">
                    <div style="font-weight: 800;" class="text-2xl lg:text-3xl text-[#1a3a5a] tracking-tight mb-1">
                        <span class="counter" data-target="500">0</span>K+
                    </div>
                    <div class="text-[10px] lg:text-[11px] font-bold text-[#1a3a5a] uppercase tracking-widest opacity-70">
                        Active Learner
                    </div>
                </div>

                <div class="flex flex-col items-center">
                    <div style="font-weight: 800;" class="text-2xl lg:text-3xl text-[#1a3a5a] tracking-tight mb-1">
                        <span class="counter" data-target="98">0</span>%
                    </div>
                    <div class="text-[10px] lg:text-[11px] font-bold text-[#1a3a5a] uppercase tracking-widest opacity-70">
                        Face Rate
                    </div>
                </div>

                <div class="flex flex-col items-center">
                    <div style="font-weight: 800;" class="text-2xl lg:text-3xl text-[#1a3a5a] tracking-tight mb-1">
                        <span class="counter" data-target="100">0</span>K+
                    </div>
                    <div class="text-[10px] lg:text-[11px] font-bold text-[#1a3a5a] uppercase tracking-widest opacity-70">
                        Certificates Issued
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- SECTION: UNLOCK ENGLISH SKILLS  --}}
<section class="relative bg-white pt-32 pb-0 overflow-hidden text-center">
    <div class="absolute top-[10%] left-[8%] floating-cloud" style="animation-delay: 0s;">
        <img src="{{ asset('assets/maskot/awan 1.png') }}" alt="Mascot" class="w-24 lg:w-32">
    </div>
    <div class="absolute bottom-[15%] left-[5%] floating-cloud" style="animation-delay: 3s;">
        <img src="{{ asset('assets/maskot/awan 3.png') }}" alt="Mascot" class="w-20 lg:w-28">
    </div>
    <div class="absolute bottom-[35%] left-[25%] floating-cloud" style="animation-delay: 1.3s;">
        <img src="{{ asset('assets/maskot/awan 2.png') }}" alt="Mascot" class="w-24 lg:w-28">
    </div>
    <div class="absolute top-[15%] right-[12%] floating-cloud" style="animation-delay: 2s;">
        <img src="{{ asset('assets/maskot/awan 5.png') }}" alt="Mascot" class="w-24 lg:w-32">
    </div>
    <div class="absolute bottom-[25%] right-[5%] floating-cloud" style="animation-delay: 4.5s;">
        <img src="{{ asset('assets/maskot/awan 4.png') }}" alt="Mascot" class="w-24 lg:w-32">
    </div>
    <div class="relative z-10 px-[5%] mb-16">
        <h2 class="text-4xl lg:text-6xl font-extrabold mb-10 leading-tight text-[#1a3a5a]">
            Unlock English Skills <br> Anytime, Anywhere
        </h2>

        <a href="{{ route('register') }}"
            class="inline-block bg-[#1a3a5a] hover:bg-[#2c4e7a] text-white px-12 py-4 rounded-full font-bold text-xl transition-all shadow-xl shadow-blue-100">
            Get Started – Its Free Trial
        </a>
    </div>
    <div class="flex justify-center relative">
        <div class="w-[300px] lg:w-[500px] -mb-64 lg:-mb-80">
            {{-- Gunakan gambar bumi dengan warna biru/kontras agar terlihat di bg putih --}}
            <img src="{{ asset('assets/maskot/bumi.png') }}"
                class="rotating-earth w-full h-auto opacity-90"
                alt="World Map">
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
                const count = +entry.target.innerText;
                const increment = target / speed;

                const updateCount = () => {
                    const currentCount = +entry.target.innerText;
                    if (currentCount < target) {
                        // Cek apakah angka punya desimal (seperti 2.5)
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
                observer.unobserve(entry.target); // Biar animasinya cuma jalan sekali
            }
        });
    };

    const observer = new IntersectionObserver(startCounter, {
        threshold: 0.5 // Animasi jalan pas 50% elemen kelihatan di layar
    });

    counters.forEach(counter => observer.observe(counter));
</script>
@endsection