@extends('layouts.user')

@section('title', 'Home')

{{-- ╔══════════════════════════════════════════════════════════════════════╗
     ║  PAGE-SPECIFIC STYLES                                               ║
     ║  (at)keyframes di-wrap (at)verbatim agar Blade tidak salah parse "(at)"      ║
     ╚══════════════════════════════════════════════════════════════════════╝ --}}
@push('styles')
<style>
    /* ── Hero doodle decorations ── */
    .hero-doodle {
        position: absolute;
        opacity: 0.18;
        pointer-events: none;
    }

    /* ── Topic pills (Did you know? card) ── */
    .topic-pill { transition: all .2s ease; }
    .topic-pill:hover {
        background: #2563eb;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(37,99,235,0.25);
    }

    /* ── Marquee scroll ── */
    .marquee-track { animation: marquee 28s linear infinite; }

    @verbatim
    @keyframes marquee {
        from { transform: translateX(0); }
        to   { transform: translateX(-50%); }
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
    .testi-track-up   { animation-name: testiScrollUp;   animation-duration: 30s; }
    .testi-track-down { animation-name: testiScrollDown; animation-duration: 36s; }
    .testi-col-wrap:hover .testi-track { animation-play-state: paused; }

    @verbatim
    @keyframes testiScrollUp {
        0%   { transform: translateY(0); }
        100% { transform: translateY(-50%); }
    }
    @keyframes testiScrollDown {
        0%   { transform: translateY(-50%); }
        100% { transform: translateY(0); }
    }
    @endverbatim

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
        box-shadow: 0 16px 48px rgba(37,99,235,0.10);
        transform: translateY(-3px);
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
        <path d="M4 20 Q22 4 44 20 Q66 36 86 20" stroke="#2563eb" stroke-width="2.5" stroke-linecap="round"/>
        <path d="M4 30 Q22 14 44 30 Q66 46 86 30" stroke="#2563eb" stroke-width="2.5" stroke-linecap="round"/>
    </svg>
    <svg class="hero-doodle" style="top:20%;right:8%;width:60px;" viewBox="0 0 60 60" fill="none">
        <circle cx="30" cy="30" r="26" stroke="#2563eb" stroke-width="2" stroke-dasharray="6 5"/>
    </svg>
    <svg class="hero-doodle" style="bottom:22%;left:3%;width:48px;" viewBox="0 0 48 48" fill="none">
        <path d="M8 24 L24 8 L40 24 L24 40 Z" stroke="#2563eb" stroke-width="2"/>
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
                        <path d="M2 8 Q50 2 100 8 Q150 14 198 6" stroke="#2563eb" stroke-width="3" stroke-linecap="round" opacity="0.4"/>
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
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
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
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 110 20A10 10 0 0112 2z"/>
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
                ['🧠', '#eff6ff', 'Learn Smarter',          'Personalized AI-powered lessons adapt to your level and goals. No wasted time on things you already know.'],
                ['📅', '#f5f3ff', 'Built for Your Schedule', 'Learn anytime, anywhere. Pick up where you left off on any device, even on your coffee break.'],
                ['🏆', '#fef9c3', 'Learn from the Best',    "Expert instructors. Top-tier professionals and practitioners who know what they're teaching."],
                ['🤝', '#dcfce7', 'Community-Powered',      'Join groups, ask questions, and build your confidence with others on the same journey.'],
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
                    'svg'     => 'undraw_followers_m4z4.svg',
                    'thumbBg' => '#dbeafe',
                    'accent'  => '#1d4ed8',
                    'badgeBg' => '#eff6ff',
                    'badge'   => 'Foundation',
                    'meta'    => '24 Lessons · All Levels',
                    'title'   => 'Advanced Listening Comprehension',
                    'desc'    => 'Train your ear with native speakers, podcasts, and IELTS audio.',
                ],
                [
                    'svg'     => 'undraw_learning-to-sketch_uaxi.svg',
                    'thumbBg' => '#ede9fe',
                    'accent'  => '#6d28d9',
                    'badgeBg' => '#f5f3ff',
                    'badge'   => 'Most Popular',
                    'meta'    => '18 Lessons · Beginner+',
                    'title'   => 'Fluent & Confident Speaking',
                    'desc'    => 'Break the fear barrier with structured drills and live speaking clubs.',
                ],
                [
                    'svg'     => 'undraw_schedule_ry1w.svg',
                    'thumbBg' => '#dcfce7',
                    'accent'  => '#15803d',
                    'badgeBg' => '#f0fdf4',
                    'badge'   => 'Academic',
                    'meta'    => '20 Lessons · Intermediate',
                    'title'   => 'Academic Reading Mastery',
                    'desc'    => 'Speed-read complex texts and master skimming & scanning techniques.',
                ],
                [
                    'svg'     => 'undraw_tasting_cd81.svg',
                    'thumbBg' => '#fef9c3',
                    'accent'  => '#a16207',
                    'badgeBg' => '#fefce8',
                    'badge'   => 'Core Skill',
                    'meta'    => '32 Lessons · All Levels',
                    'title'   => 'English Grammar Deep Dive',
                    'desc'    => 'From basic tenses to complex clauses — build the grammar foundation.',
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
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
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
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
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
                ['01', '📋', 'Take a Placement Test',     'We assess your level across all 4 skills — Listening, Speaking, Reading, and Writing — in under 15 minutes.'],
                ['02', '🗺️', 'Get Your Personal Path',    'Our system builds a custom curriculum based on your goals, schedule, and target score or fluency level.'],
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


{{-- ════════════════════════════════════════════════════════════════════════
     SECTION 7 — TESTIMONIALS
     ════════════════════════════════════════════════════════════════════════
     🔧 BACKEND (data):
        - $colA dan $colB saat ini HARDCODE di (at)php block.
          Untuk dynamic: buat tabel `testimonials` dengan kolom:
            (name, achievement, quote, avatar_color)
          Kirim dari controller:
            $testimonials = Testimonial::latest()->take(8)->get();
          Lalu di view:
            (at)php
              $colA = $testimonials->take(4);
              $colB = $testimonials->skip(4)->take(4);
            (at)endphp
          Dan akses field dengan $t->name, $t->achievement, $t->quote, dst.

     🔧 BACKEND (avatar):
        - Saat ini pakai ui-avatars.com dengan initial nama.
          Jika ada foto real: ganti src dengan $t->avatar_url
          atau {{ Storage::url($t->avatar) }}

     🔧 BACKEND (statistik):
        - Angka 12K+, 4.9★, 98% HARDCODE.
          Ganti dengan $stats->total_students, $stats->avg_rating,
          $stats->satisfaction_rate dari controller.
     ════════════════════════════════════════════════════════════════════════ --}}
<section class="testi-section py-24 overflow-hidden" id="testimonials"
         style="background: linear-gradient(160deg, #f8faff 0%, #eff4ff 100%);">
    <div class="max-w-[1200px] mx-auto px-[5%]">
        <div class="grid lg:grid-cols-[400px_1fr] gap-16 items-center">

            {{-- LEFT: Heading + statistik --}}
            <div data-reveal>
                <div class="inline-flex items-center gap-2 mb-5">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                    <span class="text-sm font-bold text-slate-500 uppercase tracking-widest">Testimonials</span>
                </div>
                <h2 class="text-[2.8rem] lg:text-[3.2rem] font-extrabold leading-[1.1] tracking-tight text-slate-900 mb-5">
                    Don't just<br>take our<br><span class="text-blue-600">word for it</span>
                </h2>
                <p class="text-[0.97rem] text-slate-500 leading-[1.8] mb-8 max-w-[340px]">
                    Read what our students have to say about their IC.EDU journey — real results, real people.
                </p>
                {{-- 🔧 BACKEND: Ganti angka hardcode dengan variabel dari controller --}}
                <div class="flex gap-8">
                    <div>
                        <div class="text-2xl font-extrabold text-slate-900">12K+</div>
                        <div class="text-xs text-slate-400 font-medium mt-0.5">Active Learners</div>
                    </div>
                    <div class="w-px bg-slate-200"></div>
                    <div>
                        <div class="text-2xl font-extrabold text-slate-900">4.9 <span class="text-amber-400 text-lg">★</span></div>
                        <div class="text-xs text-slate-400 font-medium mt-0.5">Average Rating</div>
                    </div>
                    <div class="w-px bg-slate-200"></div>
                    <div>
                        <div class="text-2xl font-extrabold text-slate-900">98%</div>
                        <div class="text-xs text-slate-400 font-medium mt-0.5">Satisfaction Rate</div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Dua kolom auto-scroll --}}
            <div class="hidden lg:grid grid-cols-2 gap-4" style="height: 560px;">

                {{-- 🔧 BACKEND: Ganti (at)php hardcode ini dengan query dari DB (lihat komentar di atas) --}}
                @php
                $colA = [
                    // Format: [name, achievement, quote, avatar_initials, avatar_hex_color]
                    ['Rina Kusuma',   'IELTS Score: 7.5 → 8.0',    'I never thought I could hit 8.0. The speaking modules and weekly live practice sessions were the complete game-changer for me. I finally feel confident!',    'Rina+K',   '2563eb'],
                    ['Budi Santoso',  'TOEFL iBT: 89 → 107',       "IC.EDU helped me fix grammar issues I didn't even know I had. My writing score jumped from 22 to 28 in just 6 weeks. Unbelievable results.",                'Budi+S',   '6366f1'],
                    ['Sari Wijaya',   'Business English Graduate',  'IC.EDU helped me land my dream job at a multinational company. The course prepared me perfectly for every interview I had.',                                 'Sari+W',   '0d9488'],
                    ['Ahmad Fauzi',   'TOEIC: 650 → 860',          'The TOEIC preparation course is incredibly structured. In just 8 weeks, my score jumped by 210 points. The practice tests felt exactly like the real exam!', 'Ahmad+F',  'f59e0b'],
                ];
                $colB = [
                    ['Dewi Rahayu',   'IELTS General: Band 7.0',   "IC.EDU's AI feedback on my essays was a revelation — it caught patterns I never noticed. My writing improved dramatically in just 3 weeks.",               'Dewi+R',   'ec4899'],
                    ['Reza Pratama',  'DET Score: 120',             'Studying for the DET felt overwhelming until I found IC.EDU. The bite-sized lessons and adaptive quizzes made everything click in just 4 weeks.',           'Reza+P',   '8b5cf6'],
                    ['Citra Lestari', 'TOEFL Essentials: 12/14',   'Live speaking club was the best thing that happened to my confidence. I went from freezing in presentations to leading team meetings in English.',           'Citra+L',  '14b8a6'],
                    ['Hendra Wijaya', 'Business English Certified', 'I got promoted to Regional Manager largely because I could finally communicate clearly with our international clients. Thank you IC.EDU!',                  'Hendra+W', 'f97316'],
                ];
                @endphp

                {{-- Kolom A — scroll ke ATAS --}}
                <div class="testi-col-wrap">
                    <div class="testi-track testi-track-up">
                        {{-- Duplikat untuk looping seamless --}}
                        @foreach(array_merge($colA, $colA) as $t)
                            <div class="testi-item">
                                <div class="text-amber-400 text-sm tracking-wider mb-3">★★★★★</div>
                                <p class="text-[0.82rem] text-slate-600 leading-[1.75] mb-4">"{{ $t[2] }}"</p>
                                <div class="flex items-center gap-2.5">
                                    {{-- 🔧 BACKEND: Ganti dengan $t->avatar_url jika dari DB --}}
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($t[3]) }}&background={{ $t[4] }}&color=fff&size=80"
                                         class="w-9 h-9 rounded-full object-cover flex-shrink-0" alt="{{ $t[0] }}">
                                    <div>
                                        <div class="text-xs font-bold text-slate-800">{{ $t[0] }}</div>
                                        <div class="text-[0.68rem] text-slate-400 mt-0.5">{{ $t[1] }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Kolom B — scroll ke BAWAH, offset mt-10 agar tidak simetris --}}
                <div class="testi-col-wrap mt-10">
                    <div class="testi-track testi-track-down">
                        @foreach(array_merge($colB, $colB) as $t)
                            <div class="testi-item">
                                <div class="text-amber-400 text-sm tracking-wider mb-3">★★★★★</div>
                                <p class="text-[0.82rem] text-slate-600 leading-[1.75] mb-4">"{{ $t[2] }}"</p>
                                <div class="flex items-center gap-2.5">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($t[3]) }}&background={{ $t[4] }}&color=fff&size=80"
                                         class="w-9 h-9 rounded-full object-cover flex-shrink-0" alt="{{ $t[0] }}">
                                    <div>
                                        <div class="text-xs font-bold text-slate-800">{{ $t[0] }}</div>
                                        <div class="text-[0.68rem] text-slate-400 mt-0.5">{{ $t[1] }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>


{{-- ════════════════════════════════════════════════════════════════════════
     SECTION 8 — CTA BANNER
     ════════════════════════════════════════════════════════════════════════
     🔧 BACKEND (route):
        - route('register') → harus terdaftar di web.php
        - route('login')    → harus terdaftar di web.php
     🔧 BACKEND (data):
        - Angka "12,000" HARDCODE → ganti dengan $stats->total_students
     ════════════════════════════════════════════════════════════════════════ --}}
<section class="py-20 px-[5%]">
    <div class="max-w-[1160px] mx-auto bg-gradient-to-br from-blue-800 via-blue-600 to-indigo-600
                rounded-[32px] p-16 grid grid-cols-1 lg:grid-cols-[1fr_auto] gap-8 items-center
                relative overflow-hidden" data-reveal>

        {{-- Background orbs — dekoratif, tidak butuh backend --}}
        <div class="absolute -top-20 right-48 w-72 h-72 rounded-full bg-white/[0.06] pointer-events-none"></div>
        <div class="absolute -bottom-16 -right-16 w-60 h-60 rounded-full bg-white/[0.04] pointer-events-none"></div>

        <div class="relative z-10">
            <h2 class="text-3xl lg:text-4xl font-extrabold text-white tracking-tight leading-tight mb-3">
                Ready to Grow<br>with IC.EDU?
            </h2>
            {{-- 🔧 BACKEND: Ganti "12,000" dengan {{ $stats->total_students }} --}}
            <p class="text-sm text-white/75 leading-7 max-w-lg">
                Join over 12,000 students who are already on their path to English fluency.
                Your first 7 days are completely free — no credit card required.
            </p>
        </div>

        <div class="flex flex-col gap-3 flex-shrink-0 relative z-10">
            <a href="{{ route('register') }}"
               class="inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-full text-sm font-bold
                      text-blue-600 bg-white shadow-md hover:-translate-y-0.5 hover:shadow-lg transition-all">
                Get Started — It's Free
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            <a href="{{ route('login') }}"
               class="text-center text-sm text-white/60 font-medium py-2 hover:text-white/85 transition-colors">
                Already have an account? Sign In
            </a>
            <p class="text-center text-xs text-white/40">No credit card · Cancel anytime</p>
        </div>

    </div>
</section>

@endsection