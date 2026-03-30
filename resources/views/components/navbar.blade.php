{{-- ══════════════════════════════════════════════NAVBAR STYLES══════════════════════════════════════════════ --}}
<style>
    /* Test card: orb + doc stack */
    .test-card { position: relative; cursor: pointer; }

    .test-orb {
        position: absolute;
        inset: 0; border-radius: 50%;
        transform: scale(0.72);
        transition: transform .4s cubic-bezier(.34,1.56,.64,1), opacity .3s ease;
        opacity: 0;
        z-index: 0;
    }
    .test-card:hover .test-orb,
    .test-card.active .test-orb  { transform: scale(1); opacity: 1; }

    /* doc stack */
    .test-doc {
        position: relative; z-index: 1;
        background: #fff;
        border: 1.5px solid #e8edf4;
        border-radius: 14px;
        padding: 14px 16px 20px;
        width: 120px;
        transition: transform .35s cubic-bezier(.34,1.4,.64,1), box-shadow .3s ease;
        box-shadow: 0 2px 12px rgba(0,0,0,.06);
    }
    .test-doc-back {
        position: absolute; top: -6px; right: -6px;
        width: 120px; height: 100%;
        background: #fff;
        border: 1.5px solid #e8edf4;
        border-radius: 14px;
        z-index: 0;
        transition: transform .35s cubic-bezier(.34,1.4,.64,1);
    }
    .test-doc-label {
        font-size: 0.82rem; font-weight: 800;
        color: #0f172a; line-height: 1.2;
        margin-bottom: 14px;
    }
    .test-doc-line {
        height: 7px; border-radius: 99px;
        background: #e8edf4; margin-bottom: 7px;
    }
    .test-doc-dot {
        width: 10px; height: 10px; border-radius: 50%;
        background: #e8edf4; display: inline-block;
        margin-right: 6px; flex-shrink: 0;
    }

    /* hover state */
    .test-card:hover .test-doc,
    .test-card.active .test-doc {
        transform: rotate(-4deg) translateY(-6px);
        box-shadow: 0 16px 40px rgba(0,0,0,.14);
    }
    .test-card:hover .test-doc-back,
    .test-card.active .test-doc-back {
        transform: rotate(5deg) translateY(-2px);
    }

    /* active (selected) doc: colored label */
    .test-card.active .test-doc-label { color: inherit; }
    .test-card.active .test-doc       { border-color: transparent; }

    /* dropdown fade-slide */
    #tests-dropdown {
        transform-origin: top center;
    }
    #tests-dropdown.open {
        opacity: 1 !important;
        visibility: visible !important;
        transform: translateY(0) !important;
        pointer-events: auto !important;
    }

    /* pill underline nav link */
    .nav-pill {
        position: relative;
        padding-bottom: 2px;
    }
    .nav-pill::after {
        content: '';
        position: absolute; bottom: -2px; left: 0; right: 0;
        height: 2px; border-radius: 99px;
        background: #2563eb;
        transform: scaleX(0);
        transition: transform .25s ease;
        transform-origin: left;
    }
    .nav-pill:hover::after,
    .nav-pill.active::after { transform: scaleX(1); }

    /* shimmer on Get Started */
    @keyframes shimmer {
        0%   { background-position: -200% center; }
        100% { background-position:  200% center; }
    }
    .btn-shimmer {
        background-size: 200% auto;
        background-image: linear-gradient(90deg, #2563eb 0%, #818cf8 40%, #2563eb 100%);
        animation: shimmer 3s linear infinite;
    }
    .btn-shimmer:hover { animation-duration: 1.2s; }
</style>

{{-- ══════════════════════════════════════════════NAVBAR══════════════════════════════════════════════ --}}
<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-transparent border-b border-transparent">
    <div class="max-w-[1300px] mx-auto flex items-center justify-between px-[5%] py-4">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="flex-shrink-0">
            <img src="{{ asset('assets/ic_edu_logo.png') }}" alt="IC EDU" class="h-9">
        </a>

        {{-- Centre nav links --}}
        <div class="hidden md:flex items-center gap-7">

            <a href="{{ url('/') }}" class="nav-link nav-pill text-sm font-semibold text-slate-700 hover:text-blue-600 transition-colors">Home</a>
            <a href="#courses"      class="nav-link nav-pill text-sm font-semibold text-slate-700 hover:text-blue-600 transition-colors">Courses</a>

            {{-- ── OUR TESTS MEGA-DROPDOWN ── --}}
            <div class="relative" id="tests-menu">

                <button id="tests-btn" type="button"
                    class="nav-link nav-pill inline-flex items-center gap-1.5 text-sm font-semibold text-slate-700 hover:text-blue-600 transition-colors select-none">
                    Our Tests
                    <svg id="tests-chevron" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"
                         style="transition:transform .25s ease;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                {{-- Mega Panel --}}
                <div id="tests-dropdown"
                     class="absolute top-[calc(100%+18px)] left-0 w-[520px] bg-white/95 backdrop-blur-2xl rounded-3xl border border-slate-100 shadow-[0_32px_80px_rgba(0,0,0,0.14)] p-6 opacity-0 invisible pointer-events-none"
                     style="transform: translateY(10px); transition: opacity .25s ease, transform .3s cubic-bezier(.34,1.2,.64,1), visibility .25s;">

                    {{-- caret aligned under button --}}
                    <div class="absolute -top-[7px] left-8 w-3.5 h-3.5 bg-white border-l border-t border-slate-100 rotate-45 rounded-tl-sm"></div>

                    {{-- Header --}}
                    <div class="mb-5 px-1">
                        <p class="text-[0.68rem] font-bold text-slate-400 uppercase tracking-[0.12em]">Pick Your Test</p>
                        <p class="text-xs text-slate-500 mt-0.5">Choose the exam you need and start achieving your goals</p>
                    </div>

                    {{-- Test Cards --}}
                    <div class="flex items-end justify-between gap-2 px-1" id="test-cards-row">
                        @php
                        $tests = [
                            ['id'=>'ielts',  'label'=>"IELTS\nAcademic", 'name'=>'IELTS',  'sub'=>'Academic',   'orb'=>'#dbeafe', 'accent'=>'#2563eb', 'desc'=>'International standard, accepted worldwide'],
                            ['id'=>'toefl',  'label'=>"TOEFL\niBT",      'name'=>'TOEFL',  'sub'=>'iBT',        'orb'=>'#ede9fe', 'accent'=>'#7c3aed', 'desc'=>'Required for US university admissions'],
                            ['id'=>'toeic',  'label'=>"TOEIC\nListening",'name'=>'TOEIC',  'sub'=>'L&R',        'orb'=>'#fef9c3', 'accent'=>'#d97706', 'desc'=>'Gold standard for workplace English'],
                        ];
                        @endphp
                        @foreach($tests as $i => $t)
                            <a href="#"
                               class="test-card flex-1 flex flex-col items-center gap-3 pt-4 pb-3 rounded-2xl transition-all duration-200 hover:bg-slate-50 group"
                               data-id="{{ $t['id'] }}"
                               data-accent="{{ $t['accent'] }}"
                               data-orb="{{ $t['orb'] }}">

                                {{-- Orb + doc stack --}}
                                <div class="relative w-[130px] h-[150px] flex items-center justify-center">
                                    {{-- Orb --}}
                                    <div class="test-orb w-[110px] h-[110px] top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"
                                         style="background: {{ $t['orb'] }};"></div>
                                    {{-- Back doc --}}
                                    <div class="test-doc-back"></div>
                                    {{-- Front doc --}}
                                    <div class="test-doc">
                                        <div class="test-doc-label">{{ str_replace('\n', '<br>', e($t['label'])) }}</div>
                                        @for($r=0;$r<3;$r++)
                                        <div class="flex items-center mb-1.5">
                                            <span class="test-doc-dot"></span>
                                            <div class="test-doc-line flex-1" style="width:{{ [70,55,80][$r] }}%;"></div>
                                        </div>
                                        @endfor
                                    </div>
                                </div>

                                {{-- Label --}}
                                <div class="text-center">
                                    <div class="text-sm font-bold text-slate-800 group-hover:text-blue-600 transition-colors leading-tight">
                                        {{ $t['name'] }} <span class="font-normal text-slate-400">{{ $t['sub'] }}</span>
                                    </div>
                                    <div class="text-[0.68rem] text-slate-400 mt-0.5 leading-tight px-1">{{ $t['desc'] }}</div>
                                </div>

                            </a>
                        @endforeach
                    </div>

                </div>
            </div>
            {{-- ── END DROPDOWN ── --}}

            <a href="#pricing" class="nav-link nav-pill text-sm font-semibold text-slate-700 hover:text-blue-600 transition-colors">Pricing</a>

        </div>

        {{-- CTA --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}" id="btn-signin"
               class="inline-flex items-center px-5 py-2 rounded-full text-sm font-bold text-slate-700 border-2 border-slate-200 hover:border-blue-500 hover:text-blue-600 transition-all">
                Sign In
            </a>
            <a href="{{ route('register') }}"
               class="inline-flex items-center px-5 py-2.5 rounded-full text-sm font-bold text-white btn-shimmer shadow-lg shadow-blue-300/40 hover:shadow-blue-400/50 hover:-translate-y-0.5 transition-all">
                Get Started
            </a>
        </div>

    </div>
</nav>

{{-- ══════════════════════════════════════════════NAVBAR SCRIPT══════════════════════════════════════════════ --}}
<script>
(function () {
    const navbar    = document.getElementById('navbar');
    const navLinks  = navbar.querySelectorAll('.nav-link');
    const dropdown  = document.getElementById('tests-dropdown');
    const testsMenu = document.getElementById('tests-menu');
    const chevron   = document.getElementById('tests-chevron');
    let   timer;

    /* ── Scroll: transparent → frosted white ── */
    function applyScroll() {
        const scrolled = window.scrollY > 60;
        navbar.classList.toggle('bg-white/95',      scrolled);
        navbar.classList.toggle('backdrop-blur-xl',  scrolled);
        navbar.classList.toggle('border-slate-200',  scrolled);
        navbar.classList.toggle('shadow-sm',         scrolled);
        navbar.classList.toggle('bg-transparent',   !scrolled);
        navbar.classList.toggle('border-transparent',!scrolled);
    }
    window.addEventListener('scroll', applyScroll, { passive: true });
    applyScroll();

    /* ── Dropdown open / close ── */
    function openDrop() {
        clearTimeout(timer);
        dropdown.classList.add('open');
        chevron.style.transform = 'rotate(180deg)';
    }
    function closeDrop() {
        timer = setTimeout(() => {
            dropdown.classList.remove('open');
            chevron.style.transform = 'rotate(0deg)';
        }, 120);
    }
    testsMenu.addEventListener('mouseenter', openDrop);
    testsMenu.addEventListener('mouseleave', closeDrop);
    dropdown.addEventListener('mouseenter',  () => clearTimeout(timer));
    dropdown.addEventListener('mouseleave',  closeDrop);
    document.addEventListener('click', e => { if (!testsMenu.contains(e.target)) closeDrop(); });

    /* ── Test card: orb colour + active state ── */
    const cards = document.querySelectorAll('.test-card');
    cards.forEach(card => {
        const accentColor = card.dataset.accent;
        const orbColor    = card.dataset.orb;

        card.addEventListener('mouseenter', () => {
            /* lift sibling cards slightly */
            cards.forEach(c => {
                if (c !== card) c.style.transform = 'scale(0.96)';
            });
            /* colour the doc label & border */
            const label = card.querySelector('.test-doc-label');
            const doc   = card.querySelector('.test-doc');
            if (label) label.style.color = accentColor;
            if (doc)   doc.style.borderColor = accentColor + '55';
        });

        card.addEventListener('mouseleave', () => {
            cards.forEach(c => { c.style.transform = ''; });
            const label = card.querySelector('.test-doc-label');
            const doc   = card.querySelector('.test-doc');
            if (label) label.style.color = '';
            if (doc)   doc.style.borderColor = '';
        });
    });
})();
</script>