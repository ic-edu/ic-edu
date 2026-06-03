@php
$tests = [
    ['id'=>'ielts', 'label'=>"IELTS\nAcademic", 'name'=>'IELTS', 'sub'=>'Academic', 'orb'=>'#dbeafe', 'accent'=>'#2563eb', 'desc'=>'International standard, accepted worldwide', 'link' => route('ielts')],
    ['id'=>'toefl', 'label'=>"TOEFL\niBT", 'name'=>'TOEFL', 'sub'=>'iBT', 'orb'=>'#ede9fe', 'accent'=>'#7c3aed', 'desc'=>'Required for US university admissions', 'link' => route('toefl')],
    ['id'=>'toeic', 'label'=>"TOEIC\nListening",'name'=>'TOEIC', 'sub'=>'L&R', 'orb'=>'#fef9c3', 'accent'=>'#d97706', 'desc'=>'Gold standard for workplace English', 'link' => route('toeic')],
];
@endphp

<style>
    .test-card {
        position: relative;
        cursor: pointer;
    }

    .test-orb {
        position: absolute;
        inset: 0;
        border-radius: 50%;
        transform: scale(0.72);
        transition: transform .4s cubic-bezier(.34, 1.56, .64, 1), opacity .3s ease;
        opacity: 0;
        z-index: 0;
    }

    .test-card:hover .test-orb,
    .test-card.active .test-orb {
        transform: scale(1);
        opacity: 1;
    }

    .test-doc {
        position: relative;
        z-index: 1;
        background: #fff;
        border: 1.5px solid #e8edf4;
        border-radius: 14px;
        padding: 14px 16px 20px;
        width: 120px;
        transition: transform .35s cubic-bezier(.34, 1.4, .64, 1), box-shadow .3s ease;
        box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
    }

    .test-doc-back {
        position: absolute;
        top: -6px;
        right: -6px;
        width: 120px;
        height: 100%;
        background: #fff;
        border: 1.5px solid #e8edf4;
        border-radius: 14px;
        z-index: 0;
        transition: transform .35s cubic-bezier(.34, 1.4, .64, 1);
    }

    .test-doc-label {
        font-size: 0.82rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
        margin-bottom: 14px;
    }

    .test-doc-line {
        height: 7px;
        border-radius: 99px;
        background: #e8edf4;
        margin-bottom: 7px;
    }

    .test-doc-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #e8edf4;
        display: inline-block;
        margin-right: 6px;
        flex-shrink: 0;
    }

    .test-card:hover .test-doc,
    .test-card.active .test-doc {
        transform: rotate(-4deg) translateY(-6px);
        box-shadow: 0 16px 40px rgba(0, 0, 0, .14);
    }

    .test-card:hover .test-doc-back,
    .test-card.active .test-doc-back {
        transform: rotate(5deg) translateY(-2px);
    }

    .test-card.active .test-doc-label {
        color: inherit;
    }

    .test-card.active .test-doc {
        border-color: transparent;
    }

    #tests-dropdown {
        transform-origin: top center;
    }

    #tests-dropdown.open {
        opacity: 1 !important;
        visibility: visible !important;
        transform: translateY(0) !important;
        pointer-events: auto !important;
    }

    .nav-pill {
        position: relative;
        padding-bottom: 2px;
    }

    .nav-pill::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        border-radius: 99px;
        background: #2563eb;
        transform: scaleX(0);
        transition: transform .25s ease;
        transform-origin: left;
    }

    .nav-pill:hover::after,
    .nav-pill.active::after {
        transform: scaleX(1);
    }

    @keyframes shimmer {
        0% {
            background-position: -200% center;
        }

        100% {
            background-position: 200% center;
        }
    }

    .btn-shimmer {
        background-size: 200% auto;
        background-image: linear-gradient(90deg, #2563eb 0%, #818cf8 40%, #2563eb 100%);
        animation: shimmer 3s linear infinite;
    }

    .btn-shimmer:hover {
        animation-duration: 1.2s;
    }

    .theme-toggle {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--toggle-bg, #f1f5f9);
        color: var(--toggle-icon, #64748b);
        border: 1.5px solid var(--border-default, #e2e8f0);
        cursor: pointer;
        flex-shrink: 0;
        transition: background 0.2s ease, border-color 0.2s ease, transform 0.2s ease;
    }

    .theme-toggle:hover {
        background: var(--toggle-hover-bg, #e2e8f0);
        border-color: var(--brand-blue, #2563eb);
        transform: rotate(15deg);
    }

    .icon-sun {
        display: none;
    }

    .icon-moon {
        display: block;
    }

    [data-theme="dark"] .icon-sun {
        display: block;
    }

    [data-theme="dark"] .icon-moon {
        display: none;
    }

    .scrolled-nav {
        top: 15px !important;
        width: 90% !important;
        max-width: 1200px;
        left: 50% !important;
        transform: translateX(-50%) !important;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.8) !important;
        backdrop-filter: blur(12px);
        border: 1px solid rgba(226, 232, 240, 0.7);
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.1);
        padding: 0px 10px !important;
    }

    #navbar {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    #mobile-menu.open {
        opacity: 1 !important;
        visibility: visible !important;
        transform: translateY(0) !important;
        pointer-events: auto !important;
    }

    [data-theme="dark"] #mobile-btn-signin {
        color: var(--text-primary) !important;
        border-color: var(--border-default) !important;
    }
    
    [data-theme="dark"] #mobile-btn-signin:hover {
        border-color: var(--brand-blue) !important;
        color: var(--brand-blue) !important;
    }

    #mobile-drawer {
        transition: opacity 0.25s ease, transform 0.25s ease, visibility 0.25s;
    }
</style>

<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-transparent border-b border-transparent">
    <div class="max-w-[1300px] mx-auto flex items-center justify-between px-[5%] py-4">
        <a href="{{ url('/') }}" class="flex-shrink-0">
            <img src="{{ asset('assets/icidu_logo.png') }}" alt="IC EDU" class="h-10 sm:h-12 lg:h-14 w-auto object-contain">
        </a>
        <div class="hidden md:flex items-center gap-7">

    {{-- Home --}}
    <a href="{{ url('/') }}"
        class="nav-link nav-pill text-sm font-semibold transition-colors
        {{ request()->is('/') ? 'active text-blue-600' : 'text-slate-700 hover:text-blue-600' }}">
        Home
    </a>

    {{-- Courses --}}
    <a href="{{ route('courses') }}"
        class="nav-link nav-pill text-sm font-semibold transition-colors
        {{ request()->routeIs('courses') ? 'active text-blue-600' : 'text-slate-700 hover:text-blue-600' }}">
        Courses
    </a>

    {{-- Our Tests --}}
    <div class="relative" id="tests-menu">
        <button id="tests-btn" type="button"
            class="nav-link nav-pill inline-flex items-center gap-1.5 text-sm font-semibold transition-colors select-none
            {{ request()->routeIs('ielts') || request()->routeIs('toefl') || request()->routeIs('toeic') ? 'active text-blue-600' : 'text-slate-700 hover:text-blue-600' }}">
            Our Tests

            <svg id="tests-chevron"
                width="13"
                height="13"
                fill="none"
                stroke="currentColor"
                stroke-width="2.5"
                viewBox="0 0 24 24"
                style="transition:transform .25s ease;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div id="tests-dropdown"
            class="absolute top-[calc(100%+18px)] left-0 w-[520px] bg-white/95 backdrop-blur-2xl rounded-3xl border border-slate-100 shadow-[0_32px_80px_rgba(0,0,0,0.14)] p-6 opacity-0 invisible pointer-events-none"
            style="transform: translateY(10px); transition: opacity .25s ease, transform .3s cubic-bezier(.34,1.2,.64,1), visibility .25s;">

            <div class="absolute -top-[7px] left-8 w-3.5 h-3.5 bg-white border-l border-t border-slate-100 rotate-45 rounded-tl-sm"></div>

            <div class="mb-5 px-1">
                <p class="text-[0.68rem] font-bold text-slate-400 uppercase tracking-[0.12em]">
                    Pick Your Test
                </p>
                <p class="text-xs text-slate-500 mt-0.5">
                    Choose the exam you need and start achieving your goals
                </p>
            </div>

            <div class="flex items-end justify-between gap-2 px-1" id="test-cards-row">
                @foreach($tests as $t)
                    <a href="{{ $t['link'] }}"
                        class="test-card flex-1 flex flex-col items-center gap-3 pt-4 pb-3 rounded-2xl transition-all duration-200 hover:bg-slate-50 group"
                        data-id="{{ $t['id'] }}"
                        data-accent="{{ $t['accent'] }}"
                        data-orb="{{ $t['orb'] }}">

                        <div class="relative w-[130px] h-[150px] flex items-center justify-center">

                            <div class="test-orb w-[110px] h-[110px] top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"
                                style="background: {{ $t['orb'] }};">
                            </div>

                            <div class="test-doc-back"></div>

                            <div class="test-doc">
                                <div class="test-doc-label">
                                    {!! nl2br(e($t['label'])) !!}
                                </div>

                                @for($r=0;$r<3;$r++)
                                    <div class="flex items-center mb-1.5">
                                        <span class="test-doc-dot"></span>
                                        <div class="test-doc-line flex-1"
                                            style="width:{{ [70,55,80][$r] }}%;">
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <div class="text-center">
                            <div class="text-sm font-bold text-slate-800 group-hover:text-blue-600 transition-colors leading-tight">
                                {{ $t['name'] }}
                                <span class="font-normal text-slate-400">
                                    {{ $t['sub'] }}
                                </span>
                            </div>

                            <div class="text-[0.68rem] text-slate-400 mt-0.5 leading-tight px-1">
                                {{ $t['desc'] }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Pricing --}}
    <a href="{{ route('pricing') }}"
        class="nav-link nav-pill text-sm font-semibold transition-colors
        {{ request()->routeIs('pricing') ? 'active text-blue-600' : 'text-slate-700 hover:text-blue-600' }}">
        Pricing
    </a>

</div>
    <div class="flex items-center gap-3">
        <button id="theme-toggle" class="theme-toggle" aria-label="Toggle dark mode" title="Switch theme">
            <svg class="icon-moon w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
            <svg class="icon-sun w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </button>
        @auth
            <a href="{{ url('/dashboard') }}"
                class="hidden md:inline-flex items-center gap-2.5 pl-1.5 pr-5 py-1.5 rounded-full text-sm font-bold text-slate-700
                          border-2 border-slate-200 hover:border-blue-500 hover:text-blue-600 hover:shadow-lg hover:-translate-y-0.5 transition-all bg-white/80 backdrop-blur-sm">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-xs shadow-inner">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <span>{{ explode(' ', Auth::user()->name)[0] }}</span>
            </a>
        @else
            <a href="{{ route('login') }}" id="btn-signin"
                class="hidden md:inline-flex items-center px-5 py-2 rounded-full text-sm font-bold text-slate-700
                          border-2 border-slate-200 hover:border-blue-500 hover:text-blue-600 transition-all">
                Sign In
            </a>
            <a href="{{ route('register') }}"
                class="hidden md:inline-flex items-center px-5 py-2.5 rounded-full text-sm font-bold text-white
                          btn-shimmer shadow-lg shadow-blue-300/40 hover:shadow-blue-400/50 hover:-translate-y-0.5 transition-all">
                Get Started
            </a>
        @endauth

        <!-- Hamburger Menu Button (Mobile Only) -->
        <button id="mobile-menu-toggle" class="flex md:hidden w-10 h-10 items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:text-blue-600 active:scale-95 transition-all" aria-label="Toggle mobile menu">
            <svg id="hamburger-icon" class="w-6 h-6 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg id="close-icon" class="w-6 h-6 hidden transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    </div>

    <!-- Mobile Full-Screen Menu Overlay -->
    <div id="mobile-drawer" class="fixed inset-0 w-full h-full min-h-screen z-50 bg-[#091124] backdrop-blur-2xl flex flex-col justify-between p-6 opacity-0 invisible translate-x-full md:hidden overflow-y-auto" style="transition: opacity 0.3s ease, transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.3s; padding-bottom: calc(3.5rem + env(safe-area-inset-bottom, 0px));">
        <!-- Header (Logo & Close Button) -->
        <div class="flex items-center justify-between pb-6 border-b border-white/10">
            <a href="{{ url('/') }}" class="flex-shrink-0">
                <img src="{{ asset('assets/icidu_logo.png') }}" alt="IC EDU" class="h-10 w-auto object-contain">
            </a>
            <button id="mobile-menu-close" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white/10 text-white hover:bg-white/20 active:scale-95 transition-all" aria-label="Close menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Body Links -->
        <div class="flex-1 flex flex-col gap-6 py-8">
            <a href="{{ url('/') }}" class="text-xl font-extrabold text-white hover:text-blue-400 transition-colors flex items-center justify-between">
                <span>Home</span>
                <svg class="w-5 h-5 text-white/40" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
            <a href="{{ route('courses') }}" class="text-xl font-extrabold text-white hover:text-blue-400 transition-colors flex items-center justify-between">
                <span>Courses</span>
                <svg class="w-5 h-5 text-white/40" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
            
            <!-- Accordion Tests Menu -->
            <div class="border-t border-b border-white/10 py-4">
                <button id="mobile-tests-accordion" class="w-full flex items-center justify-between text-xl font-extrabold text-white hover:text-blue-400 transition-colors">
                    <span>Our Tests</span>
                    <svg id="mobile-accordion-chevron" class="w-5 h-5 text-white/60 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="mobile-tests-content" class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out">
                    <div class="grid grid-cols-1 gap-3 pt-4">
                        <a href="{{ route('ielts') }}" class="flex items-center gap-4 bg-white/5 p-4 rounded-2xl border border-white/10 hover:bg-white/10 transition-colors">
                            <div class="w-10 h-10 rounded-xl bg-blue-500/20 flex items-center justify-center text-blue-400 font-black text-sm flex-shrink-0">IE</div>
                            <div>
                                <span class="block text-base font-extrabold text-white">IELTS Academic</span>
                                <span class="block text-xs text-slate-300 mt-0.5">International study & visa</span>
                            </div>
                        </a>
                        <a href="{{ route('toefl') }}" class="flex items-center gap-4 bg-white/5 p-4 rounded-2xl border border-white/10 hover:bg-white/10 transition-colors">
                            <div class="w-10 h-10 rounded-xl bg-purple-500/20 flex items-center justify-center text-purple-400 font-black text-sm flex-shrink-0">TF</div>
                            <div>
                                <span class="block text-base font-extrabold text-white">TOEFL iBT</span>
                                <span class="block text-xs text-slate-300 mt-0.5">US university admissions</span>
                            </div>
                        </a>
                        <a href="{{ route('toeic') }}" class="flex items-center gap-4 bg-white/5 p-4 rounded-2xl border border-white/10 hover:bg-white/10 transition-colors">
                            <div class="w-10 h-10 rounded-xl bg-amber-500/20 flex items-center justify-center text-amber-400 font-black text-sm flex-shrink-0">TC</div>
                            <div>
                                <span class="block text-base font-extrabold text-white">TOEIC L&R</span>
                                <span class="block text-xs text-slate-300 mt-0.5">Workplace English standard</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <a href="{{ route('pricing') }}" class="text-xl font-extrabold text-white hover:text-blue-400 transition-colors flex items-center justify-between">
                <span>Pricing</span>
                <svg class="w-5 h-5 text-white/40" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <!-- Footer (Auth Buttons) -->
        <div class="flex flex-col gap-3 pt-6 border-t border-white/10">
            @auth
                <a href="{{ url('/dashboard') }}" class="w-full text-center py-3.5 rounded-full text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 transition-all shadow-lg">
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="w-full text-center py-3.5 rounded-full text-sm font-bold text-white border-2 border-white/20 hover:bg-white/10 transition-all">
                    Sign In
                </a>
                <a href="{{ route('register') }}" class="w-full text-center py-3.5 rounded-full text-sm font-bold text-white btn-shimmer shadow-lg transition-all">
                    Get Started
                </a>
            @endauth
        </div>
    </div>
</nav>

<script>
(function () {
    'use strict';

    const STORAGE_KEY = 'icedu_theme';
    const html = document.documentElement;
    const toggleBtn = document.getElementById('theme-toggle');
    const navbar = document.getElementById('navbar');

    // =========================
    // THEME
    // =========================
    function applyTheme(theme) {
        if (theme === 'dark') {
            html.setAttribute('data-theme', 'dark');
        } else {
            html.removeAttribute('data-theme');
        }
        localStorage.setItem(STORAGE_KEY, theme);
    }

    function toggleTheme() {
        const isDark = html.getAttribute('data-theme') === 'dark';
        applyTheme(isDark ? 'light' : 'dark');
    }

    function initTheme() {
        const saved = localStorage.getItem(STORAGE_KEY);

        if (saved === 'dark' || saved === 'light') {
            applyTheme(saved);
        } else {
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            applyTheme(prefersDark ? 'dark' : 'light');
        }
    }

    initTheme();

    if (toggleBtn) {
        toggleBtn.addEventListener('click', toggleTheme);
    }

    // =========================
    // NAVBAR SCROLL
    // =========================
    let ticking = false;

    function applyScroll() {
        if (!ticking) {
            requestAnimationFrame(() => {
                const scrolled = window.scrollY > 50;

                if (scrolled) {
                    navbar.classList.add('scrolled-nav');
                    navbar.classList.remove(
                        'bg-transparent',
                        'border-transparent',
                        'py-4'
                    );
                    navbar.classList.add('py-2');
                } else {
                    navbar.classList.remove(
                        'scrolled-nav',
                        'py-2'
                    );
                    navbar.classList.add(
                        'bg-transparent',
                        'border-transparent',
                        'py-4'
                    );
                }

                ticking = false;
            });

            ticking = true;
        }
    }

    window.addEventListener('scroll', applyScroll, { passive: true });
    applyScroll();

    // =========================
    // OUR TESTS DROPDOWN
    // =========================
    const dropdown = document.getElementById('tests-dropdown');
    const testsMenu = document.getElementById('tests-menu');
    const chevron = document.getElementById('tests-chevron');
    let dropTimer;

    function openDrop() {
        clearTimeout(dropTimer);
        dropdown.classList.add('open');
        if (chevron) {
            chevron.style.transform = 'rotate(180deg)';
        }
    }

    function closeDrop() {
        dropTimer = setTimeout(() => {
            dropdown.classList.remove('open');
            if (chevron) {
                chevron.style.transform = 'rotate(0deg)';
            }
        }, 120);
    }

    if (testsMenu && dropdown) {
        testsMenu.addEventListener('mouseenter', openDrop);
        testsMenu.addEventListener('mouseleave', closeDrop);

        dropdown.addEventListener('mouseenter', () => {
            clearTimeout(dropTimer);
        });

        dropdown.addEventListener('mouseleave', closeDrop);
    }

    // =========================
    // MOBILE DRAWER
    // =========================
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileDrawer = document.getElementById('mobile-drawer');

    if (mobileMenuToggle && mobileDrawer) {
        mobileMenuToggle.addEventListener('click', function () {
            mobileDrawer.classList.remove(
                'opacity-0',
                'invisible',
                'translate-x-full'
            );

            mobileDrawer.classList.add(
                'opacity-100',
                'visible',
                'translate-x-0'
            );

            document.body.style.overflow = 'hidden';
        });
    }

    if (mobileMenuClose && mobileDrawer) {
        mobileMenuClose.addEventListener('click', function () {
            mobileDrawer.classList.add(
                'opacity-0',
                'invisible',
                'translate-x-full'
            );

            mobileDrawer.classList.remove(
                'opacity-100',
                'visible',
                'translate-x-0'
            );

            document.body.style.overflow = '';
        });
    }

    // Close drawer click outside
    document.addEventListener('click', function (e) {
        if (
            mobileDrawer &&
            mobileDrawer.classList.contains('visible') &&
            !mobileDrawer.contains(e.target) &&
            mobileMenuToggle &&
            !mobileMenuToggle.contains(e.target)
        ) {
            mobileDrawer.classList.add(
                'opacity-0',
                'invisible',
                'translate-x-full'
            );

            mobileDrawer.classList.remove(
                'opacity-100',
                'visible',
                'translate-x-0'
            );

            document.body.style.overflow = '';
        }

        if (testsMenu && !testsMenu.contains(e.target)) {
            closeDrop();
        }
    });

    // =========================
    // MOBILE ACCORDION
    // =========================
    const accordionBtn = document.getElementById('mobile-tests-accordion');
    const accordionContent = document.getElementById('mobile-tests-content');
    const accordionChevron = document.getElementById('mobile-accordion-chevron');

    if (accordionBtn && accordionContent) {
        accordionBtn.addEventListener('click', function () {
            const isOpen =
                accordionContent.style.maxHeight &&
                accordionContent.style.maxHeight !== '0px';

            if (isOpen) {
                accordionContent.style.maxHeight = '0px';
                if (accordionChevron) {
                    accordionChevron.style.transform = 'rotate(0deg)';
                }
            } else {
                accordionContent.style.maxHeight =
                    accordionContent.scrollHeight + 'px';

                if (accordionChevron) {
                    accordionChevron.style.transform = 'rotate(180deg)';
                }
            }
        });
    }

    // =========================
    // TEST CARD HOVER EFFECT
    // =========================
    document.querySelectorAll('.test-card').forEach(function (card) {
        const accent = card.dataset.accent;

        card.addEventListener('mouseenter', function () {
            document.querySelectorAll('.test-card').forEach(function (c) {
                if (c !== card) {
                    c.style.transform = 'scale(0.96)';
                }
            });

            const label = card.querySelector('.test-doc-label');
            const doc = card.querySelector('.test-doc');

            if (label) label.style.color = accent;
            if (doc) doc.style.borderColor = accent + '55';
        });

        card.addEventListener('mouseleave', function () {
            document.querySelectorAll('.test-card').forEach(function (c) {
                c.style.transform = '';
            });

            const label = card.querySelector('.test-doc-label');
            const doc = card.querySelector('.test-doc');

            if (label) label.style.color = '';
            if (doc) doc.style.borderColor = '';
        });
    });
})();
</script>