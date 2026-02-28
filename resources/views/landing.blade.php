<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IC.EDU — Master English, Master the World</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --blue:      #2563eb;
            --blue-lt:   #3b82f6;
            --blue-pale: #eff6ff;
            --blue-mid:  #dbeafe;
            --indigo:    #4f46e5;
            --navy:      #0f172a;
            --slate:     #475569;
            --slate-lt:  #94a3b8;
            --border:    #e2e8f0;
            --bg:        #f8faff;
            --white:     #ffffff;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--white);
            color: var(--navy);
            overflow-x: hidden;
        }

        /* ─── UTILS ─── */
        .container { max-width: 1160px; margin: 0 auto; padding: 0 5%; }
        a { text-decoration: none; }
        .btn {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.7rem 1.6rem; border-radius: 50px;
            font-weight: 700; font-size: 0.9rem;
            transition: all 0.25s; cursor: pointer; border: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .btn-blue  { background: var(--blue); color: #fff; box-shadow: 0 4px 16px rgba(37,99,235,0.25); }
        .btn-blue:hover  { background: #1d4ed8; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(37,99,235,0.35); }
        .btn-outline { background: transparent; color: var(--blue); border: 2px solid var(--blue); }
        .btn-outline:hover { background: var(--blue-pale); }
        .btn-white  { background: #fff; color: var(--blue); box-shadow: 0 4px 16px rgba(0,0,0,0.1); }
        .btn-white:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.15); }
        .tag {
            display: inline-block;
            background: var(--blue-pale); color: var(--blue);
            font-size: 0.72rem; font-weight: 700;
            letter-spacing: 0.08em; text-transform: uppercase;
            padding: 0.35rem 0.9rem; border-radius: 50px;
            margin-bottom: 1rem;
        }

        /* ─── SCROLL REVEAL ─── */
        .reveal { opacity: 0; transform: translateY(28px); transition: opacity 0.65s ease, transform 0.65s ease; }
        .reveal.up  { opacity: 1; transform: translateY(0); }
        .d1 { transition-delay: 0.1s; } .d2 { transition-delay: 0.2s; }
        .d3 { transition-delay: 0.3s; } .d4 { transition-delay: 0.4s; }

        /* ─── NAVBAR ─── */
        #navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 200;
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid transparent;
            transition: all 0.3s;
        }
        #navbar.scrolled {
            background: rgba(255,255,255,0.97);
            border-bottom-color: var(--border);
            box-shadow: 0 2px 20px rgba(0,0,0,0.06);
        }
        .nav-inner {
            display: flex; align-items: center; justify-content: space-between;
            padding: 1.1rem 5%; max-width: 1300px; margin: 0 auto;
        }
        .nav-logo img { height: 38px; }
        .nav-links { display: flex; align-items: center; gap: 2.2rem; }
        .nav-links a { font-size: 0.9rem; font-weight: 600; color: var(--slate); transition: color 0.2s; }
        .nav-links a:hover { color: var(--blue); }
        .nav-actions { display: flex; align-items: center; gap: 0.75rem; }

        /* ─── HERO ─── */
        .hero {
            padding: 9rem 5% 5rem;
            background: linear-gradient(160deg, #f0f7ff 0%, #e8f0fe 40%, #f8faff 100%);
            position: relative; overflow: hidden;
        }
        .hero::after {
            content: '';
            position: absolute; bottom: 0; left: 0; right: 0; height: 80px;
            background: linear-gradient(to bottom, transparent, var(--white));
        }
        .hero-inner {
            max-width: 1160px; margin: 0 auto;
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 3rem; align-items: center;
        }
        .hero-eyebrow {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: var(--blue-pale); border: 1px solid var(--blue-mid);
            color: var(--blue); font-size: 0.8rem; font-weight: 700;
            padding: 0.4rem 1rem; border-radius: 50px; margin-bottom: 1.5rem;
        }
        .hero-eyebrow-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: var(--blue); animation: blink 2s infinite;
        }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.3} }
        .hero h1 {
            font-size: clamp(2.4rem, 4.5vw, 3.6rem);
            font-weight: 800; line-height: 1.1;
            letter-spacing: -0.03em; margin-bottom: 1.25rem;
        }
        .hero h1 .blue { color: var(--blue); }
        .hero-sub {
            font-size: 1.05rem; color: var(--slate);
            line-height: 1.75; margin-bottom: 2rem; max-width: 460px;
        }
        .hero-actions { display: flex; gap: 0.875rem; flex-wrap: wrap; margin-bottom: 2.5rem; }
        .hero-trust {
            display: flex; align-items: center; gap: 0.75rem;
            font-size: 0.82rem; color: var(--slate-lt);
        }
        .trust-avatars { display: flex; }
        .trust-avatars img {
            width: 32px; height: 32px; border-radius: 50%;
            border: 2px solid white; margin-right: -8px; object-fit: cover;
        }
        /* Hero visual */
        .hero-visual { position: relative; }
        .hero-img-wrap {
            border-radius: 28px; overflow: hidden;
            box-shadow: 0 32px 80px rgba(37,99,235,0.15), 0 8px 24px rgba(0,0,0,0.08);
            animation: floatY 6s ease-in-out infinite;
            aspect-ratio: 5/6; max-height: 520px;
        }
        .hero-img-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; }
        @keyframes floatY { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
        .hero-chip {
            position: absolute;
            background: white; border-radius: 16px;
            padding: 0.75rem 1.1rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            font-size: 0.8rem; font-weight: 700; color: var(--navy);
            animation: floatChip 5s ease-in-out infinite;
        }
        .hero-chip-sub { font-size: 0.7rem; font-weight: 500; color: var(--slate-lt); margin-top: 2px; }
        .chip-a { top: 10%; left: -48px; animation-delay: 0s; }
        .chip-b { bottom: 18%; right: -44px; animation-delay: -2s; }
        .chip-c { top: 48%; left: -52px; animation-delay: -4s; }
        @keyframes floatChip { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-7px)} }
        .chip-icon { font-size: 1.2rem; margin-bottom: 3px; }

        /* ─── STATS BAND ─── */
        .stats-band {
            background: var(--white); border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border); padding: 2.5rem 5%;
        }
        .stats-inner {
            max-width: 900px; margin: 0 auto;
            display: grid; grid-template-columns: repeat(4,1fr);
            gap: 1rem; text-align: center;
        }
        .stat-item { padding: 0.5rem; }
        .stat-num {
            font-size: 2rem; font-weight: 800;
            color: var(--blue); letter-spacing: -0.03em;
        }
        .stat-label { font-size: 0.82rem; color: var(--slate); margin-top: 0.25rem; font-weight: 500; }
        .stat-divider { border-right: 1px solid var(--border); }

        /* ─── SECTION ─── */
        .section { padding: 6rem 5%; }
        .section-hd { text-align: center; max-width: 600px; margin: 0 auto 3.5rem; }
        .section-hd h2 {
            font-size: clamp(1.8rem, 3vw, 2.5rem);
            font-weight: 800; letter-spacing: -0.025em;
            line-height: 1.15; margin-bottom: 0.875rem;
        }
        .section-hd p { font-size: 1rem; color: var(--slate); line-height: 1.7; }

        /* ─── FEATURES / WHY ─── */
        .why-grid {
            display: grid; grid-template-columns: repeat(4,1fr); gap: 1.5rem;
        }
        .why-card {
            background: var(--bg); border: 1px solid var(--border);
            border-radius: 20px; padding: 1.75rem;
            transition: all 0.3s; cursor: default;
        }
        .why-card:hover { background: white; box-shadow: 0 12px 40px rgba(37,99,235,0.1); transform: translateY(-4px); border-color: var(--blue-mid); }
        .why-icon {
            width: 52px; height: 52px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; margin-bottom: 1.1rem;
        }
        .why-card h4 { font-size: 0.97rem; font-weight: 700; margin-bottom: 0.5rem; }
        .why-card p { font-size: 0.82rem; color: var(--slate); line-height: 1.6; }

        /* ─── MARQUEE ─── */
        .marquee-wrap {
            overflow: hidden; padding: 1.25rem 0;
            background: var(--blue-pale);
            border-top: 1px solid var(--blue-mid); border-bottom: 1px solid var(--blue-mid);
        }
        .marquee-track {
            display: flex; gap: 2.5rem; width: max-content;
            animation: marquee 28s linear infinite;
        }
        .marquee-track:hover { animation-play-state: paused; }
        @keyframes marquee { from{transform:translateX(0)} to{transform:translateX(-50%)} }
        .marquee-item {
            display: flex; align-items: center; gap: 0.6rem;
            font-size: 0.82rem; font-weight: 700; color: var(--blue);
            letter-spacing: 0.06em; text-transform: uppercase; white-space: nowrap;
        }
        .m-dot { width: 5px; height: 5px; border-radius: 50%; background: var(--blue-lt); flex-shrink: 0; }

        /* ─── COURSES / CATEGORIES ─── */
        .cat-grid {
            display: grid; grid-template-columns: repeat(4,1fr); gap: 1.25rem;
        }
        .cat-card {
            border-radius: 20px; overflow: hidden;
            border: 1px solid var(--border); background: var(--white);
            transition: all 0.3s; cursor: pointer; position: relative;
        }
        .cat-card:hover { transform: translateY(-5px); box-shadow: 0 16px 48px rgba(37,99,235,0.12); border-color: var(--blue-mid); }
        .cat-thumb {
            height: 140px;
            display: flex; align-items: center; justify-content: center;
            font-size: 4rem; position: relative; overflow: hidden;
        }
        .cat-thumb-deco {
            position: absolute; width: 100px; height: 100px; border-radius: 50%;
            opacity: 0.25; right: -20px; bottom: -20px;
        }
        .cat-body { padding: 1.25rem; }
        .cat-badge {
            font-size: 0.68rem; font-weight: 700; letter-spacing: 0.07em;
            text-transform: uppercase; padding: 0.25rem 0.7rem;
            border-radius: 50px; margin-bottom: 0.6rem; display: inline-block;
        }
        .cat-body h3 { font-size: 0.97rem; font-weight: 700; margin-bottom: 0.4rem; }
        .cat-body p { font-size: 0.78rem; color: var(--slate); line-height: 1.5; margin-bottom: 0.875rem; }
        .cat-footer {
            display: flex; align-items: center; justify-content: space-between;
            padding-top: 0.75rem; border-top: 1px solid var(--border);
        }
        .cat-meta { font-size: 0.75rem; color: var(--slate-lt); font-weight: 500; }
        .cat-btn {
            width: 30px; height: 30px; border-radius: 50%;
            background: var(--blue-pale);
            display: flex; align-items: center; justify-content: center;
            transition: background 0.2s;
        }
        .cat-card:hover .cat-btn { background: var(--blue); }
        .cat-card:hover .cat-btn svg { stroke: white; }

        /* ─── HOW IT WORKS ─── */
        .how-section {
            background: linear-gradient(135deg, #f0f7ff 0%, #e8f0fe 100%);
            padding: 6rem 5%;
        }
        .how-grid {
            display: grid; grid-template-columns: repeat(3,1fr); gap: 2rem;
            position: relative; margin-top: 3.5rem;
        }
        .how-line {
            position: absolute; top: 44px;
            left: calc(16.66% + 1.5rem); right: calc(16.66% + 1.5rem);
            height: 2px;
            background: repeating-linear-gradient(to right, var(--blue-mid) 0, var(--blue-mid) 8px, transparent 8px, transparent 16px);
        }
        .how-card {
            background: white; border-radius: 24px;
            padding: 2rem 1.75rem; text-align: center;
            border: 1px solid var(--blue-mid);
            box-shadow: 0 4px 20px rgba(37,99,235,0.06);
            position: relative; z-index: 1;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .how-card:hover { transform: translateY(-5px); box-shadow: 0 16px 48px rgba(37,99,235,0.12); }
        .how-num {
            width: 56px; height: 56px; border-radius: 50%;
            background: var(--blue); color: white;
            font-size: 1.2rem; font-weight: 800;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.25rem; font-family: 'Plus Jakarta Sans', sans-serif;
            box-shadow: 0 6px 20px rgba(37,99,235,0.3);
        }
        .how-card h4 { font-size: 1rem; font-weight: 700; margin-bottom: 0.6rem; }
        .how-card p { font-size: 0.83rem; color: var(--slate); line-height: 1.65; }

        /* ─── TESTIMONIALS ─── */
        .testi-grid {
            display: grid; grid-template-columns: repeat(3,1fr); gap: 1.25rem;
        }
        .testi-card {
            background: var(--bg); border: 1px solid var(--border);
            border-radius: 20px; padding: 1.75rem;
            transition: all 0.3s;
        }
        .testi-card:hover { background: white; box-shadow: 0 12px 40px rgba(37,99,235,0.08); transform: translateY(-3px); }
        .testi-stars { color: #f59e0b; font-size: 0.9rem; margin-bottom: 1rem; letter-spacing: 2px; }
        .testi-text { font-size: 0.88rem; color: var(--slate); line-height: 1.75; font-style: italic; margin-bottom: 1.25rem; }
        .testi-author { display: flex; align-items: center; gap: 0.75rem; }
        .testi-avatar { width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 2px solid var(--blue-mid); }
        .testi-name { font-size: 0.87rem; font-weight: 700; color: var(--navy); }
        .testi-role { font-size: 0.75rem; color: var(--slate-lt); margin-top: 1px; }
        /* Featured card */
        .testi-card.featured {
            background: var(--blue); border-color: var(--blue);
            box-shadow: 0 16px 48px rgba(37,99,235,0.25);
        }
        .testi-card.featured .testi-text { color: rgba(255,255,255,0.85); }
        .testi-card.featured .testi-name { color: white; }
        .testi-card.featured .testi-role { color: rgba(255,255,255,0.6); }
        .testi-card.featured .testi-stars { color: #fbbf24; }

        /* ─── FEATURE SPLIT ─── */
        .split-section { padding: 6rem 5%; }
        .split-inner {
            max-width: 1160px; margin: 0 auto;
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 4rem; align-items: center;
        }
        .split-inner.reverse { }
        .split-img {
            border-radius: 24px; overflow: hidden;
            box-shadow: 0 24px 64px rgba(37,99,235,0.12);
        }
        .split-img img { width: 100%; display: block; }
        .split-content h2 {
            font-size: clamp(1.75rem, 2.5vw, 2.2rem);
            font-weight: 800; letter-spacing: -0.025em;
            line-height: 1.2; margin-bottom: 1rem;
        }
        .split-content p { font-size: 0.95rem; color: var(--slate); line-height: 1.75; margin-bottom: 1.5rem; }
        .check-list { list-style: none; display: flex; flex-direction: column; gap: 0.6rem; margin-bottom: 1.75rem; }
        .check-list li {
            display: flex; align-items: center; gap: 0.6rem;
            font-size: 0.9rem; font-weight: 600; color: var(--navy);
        }
        .check-list li::before {
            content: '✓';
            display: flex; align-items: center; justify-content: center;
            width: 22px; height: 22px; border-radius: 50%;
            background: var(--blue-pale); color: var(--blue);
            font-size: 0.75rem; font-weight: 800; flex-shrink: 0;
        }

        /* ─── CTA BANNER ─── */
        .cta-section { padding: 5rem 5%; }
        .cta-box {
            max-width: 1160px; margin: 0 auto;
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 50%, #4f46e5 100%);
            border-radius: 32px; padding: 4rem;
            display: grid; grid-template-columns: 1fr auto;
            gap: 2rem; align-items: center;
            position: relative; overflow: hidden;
        }
        .cta-box::before {
            content: '';
            position: absolute; top: -80px; right: 200px;
            width: 300px; height: 300px; border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }
        .cta-box::after {
            content: '';
            position: absolute; bottom: -60px; right: -60px;
            width: 250px; height: 250px; border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }
        .cta-box h2 {
            font-size: clamp(1.6rem, 2.5vw, 2rem);
            font-weight: 800; color: white; margin-bottom: 0.75rem;
            letter-spacing: -0.025em;
        }
        .cta-box p { font-size: 0.95rem; color: rgba(255,255,255,0.75); line-height: 1.65; }
        .cta-actions { display: flex; gap: 0.875rem; flex-direction: column; flex-shrink: 0; }
        .cta-note { font-size: 0.72rem; color: rgba(255,255,255,0.5); text-align: center; margin-top: 0.4rem; }

        /* ─── FOOTER ─── */
        footer {
            background: var(--navy);
            padding: 4rem 5% 2rem;
        }
        .footer-top {
            display: grid; grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 3rem; padding-bottom: 3rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            margin-bottom: 2rem;
        }
        .footer-brand img { height: 34px; margin-bottom: 1rem; filter: brightness(10); }
        .footer-brand p { font-size: 0.83rem; color: rgba(255,255,255,0.45); line-height: 1.7; max-width: 240px; }
        .footer-col h5 { font-size: 0.82rem; font-weight: 700; color: white; letter-spacing: 0.06em; text-transform: uppercase; margin-bottom: 1.1rem; }
        .footer-col a { display: block; font-size: 0.83rem; color: rgba(255,255,255,0.45); margin-bottom: 0.65rem; transition: color 0.2s; }
        .footer-col a:hover { color: rgba(255,255,255,0.85); }
        .footer-bottom {
            display: flex; align-items: center; justify-content: space-between;
            font-size: 0.78rem; color: rgba(255,255,255,0.3); flex-wrap: wrap; gap: 0.5rem;
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 960px) {
            .hero-inner, .split-inner, .cta-box { grid-template-columns: 1fr; }
            .hero-visual { display: none; }
            .why-grid, .cat-grid { grid-template-columns: repeat(2,1fr); }
            .how-grid, .testi-grid { grid-template-columns: 1fr; }
            .how-line { display: none; }
            .stats-inner { grid-template-columns: repeat(2,1fr); }
            .stat-divider:nth-child(2) { border-right: none; }
            .footer-top { grid-template-columns: 1fr 1fr; }
            .nav-links { display: none; }
        }
        @media (max-width: 560px) {
            .why-grid, .cat-grid { grid-template-columns: 1fr; }
            .stats-inner { grid-template-columns: 1fr 1fr; }
            .cta-actions { flex-direction: column; }
        }
    </style>
</head>
<body>

{{-- ═══════════ NAVBAR ═══════════ --}}
<nav id="navbar">
    <div class="nav-inner">
        <div class="nav-logo">
            <img src="{{ asset('assets/ic_edu_logo.png') }}" alt="IC EDU">
        </div>
        <div class="nav-links">
            <a href="#why">Why IC.EDU</a>
            <a href="#courses">Courses</a>
            <a href="#how">How it Works</a>
            <a href="#testimonials">Reviews</a>
        </div>
        <div class="nav-actions">
            <a href="{{ route('login') }}" class="btn btn-outline" style="padding:0.55rem 1.3rem;">Sign In</a>
            <a href="{{ route('register') }}" class="btn btn-blue" style="padding:0.55rem 1.3rem;">Get Started</a>
        </div>
    </div>
</nav>

{{-- ═══════════ HERO ═══════════ --}}
<section class="hero">
    <div class="hero-inner">
        {{-- Left --}}
        <div>
            <div class="hero-eyebrow">
                <span class="hero-eyebrow-dot"></span>
                #1 English Learning Platform
            </div>
            <h1>
                Unlock English Skills That<br>
                <span class="blue">Move You Forward</span>
            </h1>
            <p class="hero-sub">
                Master in-demand English skills — from IELTS to daily conversation. Learn at your own pace, track your growth, and stay ahead.
            </p>
            <div class="hero-actions">
                <a href="{{ route('register') }}" class="btn btn-blue" style="padding:0.875rem 1.75rem; font-size:0.97rem;">
                    Start Learning Free
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                <a href="#courses" class="btn btn-outline" style="padding:0.875rem 1.75rem; font-size:0.97rem;">
                    Browse Courses
                </a>
            </div>
            <div class="hero-trust">
                <div class="trust-avatars">
                    <img src="https://ui-avatars.com/api/?name=Rina+K&background=3b82f6&color=fff&size=64" alt="">
                    <img src="https://ui-avatars.com/api/?name=Budi+S&background=6366f1&color=fff&size=64" alt="">
                    <img src="https://ui-avatars.com/api/?name=Sari+W&background=0d9488&color=fff&size=64" alt="">
                    <img src="https://ui-avatars.com/api/?name=Dian+A&background=f59e0b&color=fff&size=64" alt="">
                </div>
                <span><strong style="color:var(--navy);">12,000+</strong> students already learning</span>
            </div>
        </div>
        {{-- Right --}}
        <div class="hero-visual">
            <div class="hero-img-wrap">
                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=800&q=80" alt="Students">
            </div>
            <div class="hero-chip chip-a">
                <div class="chip-icon">🎯</div>
                <div>IELTS Score</div>
                <div class="hero-chip-sub">Band 7.5 achieved!</div>
            </div>
            <div class="hero-chip chip-b">
                <div class="chip-icon">🔥</div>
                <div>21-Day Streak</div>
                <div class="hero-chip-sub">Keep it going!</div>
            </div>
            <div class="hero-chip chip-c">
                <div class="chip-icon">🟢</div>
                <div>Live Session</div>
                <div class="hero-chip-sub">47 students joined</div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════ STATS ═══════════ --}}
<div class="stats-band">
    <div class="stats-inner">
        @php $stats = [['2.5K+','Premium Courses'],['500K+','Active Learners'],['98%','Satisfaction Rate'],['2M+','Certificates Issued']]; @endphp
        @foreach($stats as $i => [$num, $label])
        <div class="stat-item reveal d{{ $i+1 }} {{ $i < 3 ? 'stat-divider' : '' }}">
            <div class="stat-num">{{ $num }}</div>
            <div class="stat-label">{{ $label }}</div>
        </div>
        @endforeach
    </div>
</div>

{{-- ═══════════ WHY IC.EDU ═══════════ --}}
<section class="section" id="why">
    <div class="container">
        <div class="section-hd reveal">
            <span class="tag">Why Choose Us</span>
            <h2>Smart Learning, Real Results</h2>
            <p>We make learning effective, enjoyable, and personalized — so you stay motivated and actually finish what you start.</p>
        </div>
        <div class="why-grid">
            @php
            $whys = [
                ['🧠','#eff6ff','Learn Smarter','Personalized AI-powered lessons adapt to your level and goals. No wasted time on things you already know.'],
                ['📅','#f5f3ff','Built for Your Schedule','Learn anytime, anywhere. Pick up where you left off on any device, even on your coffee break.'],
                ['🏆','#fef9c3','Learn from the Best','Expert instructors. Top-tier professionals and practitioners who know what they\'re teaching.'],
                ['🤝','#dcfce7','Community-Powered','Join groups, ask questions, and build your confidence with others on the same journey.'],
            ];
            @endphp
            @foreach($whys as $i => [$icon,$bg,$title,$desc])
            <div class="why-card reveal d{{ $i+1 }}">
                <div class="why-icon" style="background:{{ $bg }};">{{ $icon }}</div>
                <h4>{{ $title }}</h4>
                <p>{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════ MARQUEE ═══════════ --}}
<div class="marquee-wrap">
    <div class="marquee-track">
        @php $items = ['IELTS Preparation','TOEFL Training','Academic Writing','Public Speaking','Grammar Mastery','Vocabulary Builder','Listening Skills','Pronunciation','Business English','TOEIC Prep','Reading Skills','Daily Conversation']; @endphp
        @foreach(array_merge($items, $items) as $item)
        <div class="marquee-item"><span class="m-dot"></span>{{ $item }}</div>
        @endforeach
    </div>
</div>

{{-- ═══════════ COURSES CATEGORIES ═══════════ --}}
<section class="section" id="courses" style="background: var(--bg);">
    <div class="container">
        <div class="section-hd reveal">
            <span class="tag">Course Categories</span>
            <h2>Every Skill You Need to Speak with Confidence</h2>
            <p>Structured, expert-led courses designed for real-world English — not just exams.</p>
        </div>
        <div class="cat-grid">
            @php
            $cats = [
                ['🎧','Listening','#dbeafe','#1d4ed8','#eff6ff','Foundation','24 Lessons · All Levels','Advanced Listening Comprehension','Train your ear with native speakers, podcasts, and IELTS audio.'],
                ['🗣️','Speaking','#ede9fe','#6d28d9','#f5f3ff','Most Popular','18 Lessons · Beginner+','Fluent & Confident Speaking','Break the fear barrier with structured drills and live speaking clubs.'],
                ['📖','Reading','#dcfce7','#15803d','#f0fdf4','Academic','20 Lessons · Intermediate','Academic Reading Mastery','Speed-read complex texts and master skimming & scanning techniques.'],
                ['✍️','Grammar','#fef9c3','#a16207','#fefce8','Core Skill','32 Lessons · All Levels','English Grammar Deep Dive','From basic tenses to complex clauses — build the grammar foundation.'],
            ];
            @endphp
            @foreach($cats as $i => [$emoji,$cat,$thumbBg,$thumbAccent,$badgeBg,$badge,$meta,$title,$desc])
            <div class="cat-card reveal d{{ $i+1 }}">
                <div class="cat-thumb" style="background: {{ $thumbBg }};">
                    <span>{{ $emoji }}</span>
                    <div class="cat-thumb-deco" style="background: {{ $thumbAccent }};"></div>
                </div>
                <div class="cat-body">
                    <span class="cat-badge" style="background:{{ $badgeBg }}; color:{{ $thumbAccent }};">{{ $badge }}</span>
                    <h3>{{ $title }}</h3>
                    <p>{{ $desc }}</p>
                    <div class="cat-footer">
                        <span class="cat-meta">{{ $meta }}</span>
                        <div class="cat-btn">
                            <svg width="13" height="13" fill="none" stroke="var(--blue)" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div style="text-align:center; margin-top:2.5rem;" class="reveal">
            <a href="{{ route('course.index') }}" class="btn btn-blue" style="padding:0.875rem 2rem; font-size:0.97rem;">
                View All Courses
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- ═══════════ FEATURE SPLIT ═══════════ --}}
<section class="split-section">
    <div class="split-inner">
        <div class="split-img reveal">
            <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?auto=format&fit=crop&w=800&q=80" alt="Built to keep you going">
        </div>
        <div class="split-content reveal d2">
            <span class="tag">Built to Keep You Going</span>
            <h2>Stay consistent with tools that actually work</h2>
            <p>Stay consistent with gamified streaks, progress tracking, peer groups, and notifications that motivate — not annoy.</p>
            <ul class="check-list">
                <li>Smart Learning Streaks</li>
                <li>Gamified Progress</li>
                <li>Peer Groups & Discussions</li>
                <li>Mobile Friendly</li>
                <li>Certificates That Matter</li>
            </ul>
            <a href="{{ route('register') }}" class="btn btn-blue">Start Learning Free</a>
        </div>
    </div>
</section>

{{-- ═══════════ HOW IT WORKS ═══════════ --}}
<section class="how-section" id="how">
    <div class="container">
        <div class="section-hd reveal">
            <span class="tag">The Process</span>
            <h2>Simple Steps to English Fluency</h2>
            <p>From zero to confident speaker — our proven 3-step path gets you there faster than you think.</p>
        </div>
        <div class="how-grid">
            <div class="how-line"></div>
            @php
            $steps = [
                ['01','📋','Take a Placement Test','We assess your level across all 4 skills — Listening, Speaking, Reading, and Writing — in under 15 minutes.'],
                ['02','🗺️','Get Your Personal Path','Our system builds a custom curriculum based on your goals, schedule, and target score or fluency level.'],
                ['03','🏆','Learn, Practice & Achieve','Complete lessons, join live sessions, take mock tests, and earn certificates as you hit each milestone.'],
            ];
            @endphp
            @foreach($steps as $i => [$num,$icon,$title,$desc])
            <div class="how-card reveal d{{ $i+1 }}">
                <div class="how-num">{{ $num }}</div>
                <div style="font-size:2rem; margin-bottom:0.875rem;">{{ $icon }}</div>
                <h4>{{ $title }}</h4>
                <p>{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════ COMMUNITY SPLIT ═══════════ --}}
<section class="split-section">
    <div class="split-inner">
        <div class="split-content reveal">
            <span class="tag">You're Not Learning Alone</span>
            <h2>Join a community of learners from across the world</h2>
            <p>At IC.EDU, learning means more than just watching lessons — it's about growing together. Our vibrant community connects learners from around the world so you can discuss topics, share progress, and find the accountability partner you need.</p>
            <ul class="check-list">
                <li>Weekly Live Speaking Clubs</li>
                <li>Peer Study Groups</li>
                <li>Native Speaker Exchange</li>
                <li>24/7 Discussion Forums</li>
            </ul>
            <a href="{{ route('register') }}" class="btn btn-blue">Join Our Community</a>
        </div>
        <div class="split-img reveal d2">
            <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=800&q=80" alt="Community">
        </div>
    </div>
</section>

{{-- ═══════════ TESTIMONIALS ═══════════ --}}
<section class="section" id="testimonials" style="background: var(--bg);">
    <div class="container">
        <div class="section-hd reveal">
            <span class="tag">Student Stories</span>
            <h2>Stories from IC.EDU Learners</h2>
            <p>Thousands are growing their skills, switching careers, and achieving more. Here's what they're saying.</p>
        </div>
        <div class="testi-grid">
            @php
            $testis = [
                ['Rina Kusuma','IELTS Score: 7.5 → 8.0','I never thought I could hit 8.0. The speaking modules and weekly live practice sessions were the complete game-changer for me. I finally feel confident!','Rina+K','3b82f6',false],
                ['Budi Santoso','TOEFL iBT: 89 → 107','IC.EDU helped me fix grammar issues I didn\'t even know I had. My writing score jumped from 22 to 28 in just 6 weeks. Unbelievable results.','Budi+S','6366f1',true],
                ['Sari Wijaya','Business English Graduate','IC.EDU helped me land my dream job at a multinational company. The business English course prepared me perfectly for every interview I had.','Sari+W','0d9488',false],
            ];
            @endphp
            @foreach($testis as $i => [$name,$role,$text,$initials,$color,$featured])
            <div class="testi-card reveal d{{ $i+1 }} {{ $featured ? 'featured' : '' }}">
                <div class="testi-stars">★★★★★</div>
                <p class="testi-text">"{{ $text }}"</p>
                <div class="testi-author">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($initials) }}&background={{ $color }}&color=fff&size=80"
                         class="testi-avatar" alt="{{ $name }}">
                    <div>
                        <div class="testi-name">{{ $name }}</div>
                        <div class="testi-role">{{ $role }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════ CTA BANNER ═══════════ --}}
<section class="cta-section">
    <div class="cta-box reveal">
        <div>
            <h2>Ready to Grow<br>with IC.EDU?</h2>
            <p>Join over 12,000 students who are already on their path to English fluency. Your first 7 days are completely free — no credit card required.</p>
        </div>
        <div class="cta-actions">
            <a href="{{ route('register') }}" class="btn btn-white" style="padding:0.875rem 1.75rem; font-size:0.95rem; justify-content:center;">
                Get Started — It's Free
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <a href="{{ route('login') }}" style="text-align:center; font-size:0.85rem; color:rgba(255,255,255,0.6); font-weight:500; padding:0.5rem;">
                Already have an account? Sign In
            </a>
            <div class="cta-note">No credit card · Cancel anytime</div>
        </div>
    </div>
</section>

{{-- ═══════════ FOOTER ═══════════ --}}
<footer>
    <div class="footer-top" style="max-width:1160px; margin:0 auto;">
        <div class="footer-brand">
            <img src="{{ asset('assets/ic_edu_logo.png') }}" alt="IC EDU">
            <p>IC.EDU is a global online learning platform that helps you gain in-demand language skills to advance in your career.</p>
        </div>
        <div class="footer-col">
            <h5>Explore</h5>
            <a href="#">Home</a>
            <a href="#">Courses</a>
            <a href="#">Mentors</a>
            <a href="#">Community</a>
            <a href="#">Pricing</a>
        </div>
        <div class="footer-col">
            <h5>Company</h5>
            <a href="#">About Us</a>
            <a href="#">Blog</a>
            <a href="#">Press</a>
            <a href="#">Careers</a>
            <a href="#">Contact</a>
        </div>
        <div class="footer-col">
            <h5>Support</h5>
            <a href="#">Help Center</a>
            <a href="#">Terms of Service</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Cookie Settings</a>
            <a href="#">Scholarships</a>
        </div>
    </div>
    <div class="footer-bottom" style="max-width:1160px; margin:0 auto;">
        <span>© 2025 IC.EDU. All rights reserved.</span>
        <span>Made with ❤️ for English learners everywhere</span>
    </div>
</footer>

<script>
    // Navbar scroll
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 50);
    });

    // Scroll reveal
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('up'); observer.unobserve(e.target); } });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>

</body>
</html>