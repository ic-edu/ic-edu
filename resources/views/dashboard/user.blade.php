@extends('layouts.dashboard')
@section('title', 'My Dashboard')

@push('styles')
<style>
    /* ────────────────────────────────────────────────────
       ROOT TOKENS
    ──────────────────────────────────────────────────── */
    :root {
        --blue:    #2563eb;
        --indigo:  #6366f1;
        --surface: #ffffff;
        --base:    #f0f4ff;
        --border:  #e4eaf6;
        --text:    #0f172a;
        --muted:   #64748b;
        --sidebar: 72px;
    }

    /* ────────────────────────────────────────────────────
       LAYOUT SHELL
    ──────────────────────────────────────────────────── */
    .dash-shell  { display: flex; min-height: 100vh; }
    .dash-main   { flex: 1; margin-left: var(--sidebar); min-height: 100vh; display: flex; flex-direction: column; }

    /* ────────────────────────────────────────────────────
       SIDEBAR
    ──────────────────────────────────────────────────── */
    .sidebar {
        position: fixed; left: 0; top: 0; bottom: 0;
        width: var(--sidebar);
        background: var(--surface);
        border-right: 1px solid var(--border);
        display: flex; flex-direction: column; align-items: center;
        padding: 18px 0 20px;
        z-index: 100;
    }
    .sidebar-logo {
        width: 40px; height: 40px; border-radius: 12px;
        background: linear-gradient(135deg, var(--blue), var(--indigo));
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 28px; flex-shrink: 0;
        box-shadow: 0 6px 20px rgba(37,99,235,0.35);
    }
    .sidebar-nav { display: flex; flex-direction: column; gap: 6px; flex: 1; align-items: center; }

    .s-btn {
        position: relative;
        width: 44px; height: 44px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        color: #94a3b8; border: none; background: transparent;
        cursor: pointer; transition: all .2s ease;
    }
    .s-btn:hover { background: #f0f4ff; color: var(--blue); }
    .s-btn.active {
        background: linear-gradient(135deg, var(--blue), var(--indigo));
        color: white;
        box-shadow: 0 6px 18px rgba(37,99,235,0.30);
    }
    /* tooltip on hover */
    .s-btn .tip {
        position: absolute; left: 56px;
        background: #1e293b; color: white;
        font-size: 0.72rem; font-weight: 600;
        padding: 5px 10px; border-radius: 8px;
        white-space: nowrap; pointer-events: none;
        opacity: 0; transform: translateX(-6px);
        transition: all .2s ease;
    }
    .s-btn:hover .tip { opacity: 1; transform: translateX(0); }

    .sidebar-bottom { margin-top: auto; display: flex; flex-direction: column; align-items: center; gap: 8px; }
    .sidebar-avatar {
        width: 36px; height: 36px; border-radius: 50%;
        border: 2px solid var(--blue);
        overflow: hidden; cursor: pointer;
    }

    /* ────────────────────────────────────────────────────
       TOP BAR
    ──────────────────────────────────────────────────── */
    .topbar {
        height: 66px; display: flex; align-items: center; justify-content: space-between;
        padding: 0 28px;
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        position: sticky; top: 0; z-index: 50;
    }
    .topbar-search {
        position: relative; display: flex; align-items: center;
    }
    .topbar-search input {
        background: var(--base); border: 1.5px solid var(--border);
        border-radius: 12px; padding: 8px 14px 8px 38px;
        font-size: 0.82rem; font-family: inherit; width: 240px;
        outline: none; color: var(--text); transition: border-color .2s;
    }
    .topbar-search input:focus { border-color: var(--blue); background: white; }
    .topbar-search svg { position: absolute; left: 12px; color: #94a3b8; pointer-events: none; }

    .topbar-right { display: flex; align-items: center; gap: 14px; }
    .notif-btn {
        width: 38px; height: 38px; border-radius: 12px;
        background: var(--base); border: 1.5px solid var(--border);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; position: relative; transition: all .2s;
    }
    .notif-btn:hover { border-color: var(--blue); background: white; }
    .notif-badge {
        position: absolute; top: -3px; right: -3px;
        width: 16px; height: 16px; border-radius: 50%;
        background: #ef4444; color: white;
        font-size: 0.6rem; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        border: 2px solid white;
    }

    .user-chip {
        display: flex; align-items: center; gap: 10px;
        background: var(--base); border: 1.5px solid var(--border);
        border-radius: 14px; padding: 5px 14px 5px 6px;
        cursor: pointer; transition: all .2s;
    }
    .user-chip:hover { border-color: var(--blue); background: white; }
    .user-chip img { width: 28px; height: 28px; border-radius: 8px; }

    /* ────────────────────────────────────────────────────
       PAGE CONTENT WRAPPER
    ──────────────────────────────────────────────────── */
    .page-body { padding: 24px 28px 40px; flex: 1; }

    /* ────────────────────────────────────────────────────
       CARDS
    ──────────────────────────────────────────────────── */
    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 20px;
        overflow: hidden;
    }
    .card-pad { padding: 22px; }

    /* ────────────────────────────────────────────────────
       HERO WELCOME CARD
    ──────────────────────────────────────────────────── */
    .hero-card {
        border-radius: 24px;
        padding: 32px;
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #4f46e5 100%);
        min-height: 200px;
    }
    .hero-card .glow-1 {
        position: absolute; width: 320px; height: 320px; border-radius: 50%;
        background: radial-gradient(circle, rgba(255,255,255,0.12), transparent 65%);
        top: -80px; right: -60px; pointer-events: none;
    }
    .hero-card .glow-2 {
        position: absolute; width: 200px; height: 200px; border-radius: 50%;
        background: radial-gradient(circle, rgba(99,102,241,0.5), transparent 65%);
        bottom: -60px; left: 40%; pointer-events: none;
    }
    .hero-grid-dots {
        position: absolute; inset: 0; pointer-events: none; opacity: 0.07;
        background-image: radial-gradient(circle, white 1px, transparent 1px);
        background-size: 24px 24px;
    }

    /* ────────────────────────────────────────────────────
       STAT MINI CARDS
    ──────────────────────────────────────────────────── */
    .stat-card {
        border-radius: 20px; padding: 20px;
        display: flex; align-items: center; gap: 16px;
        background: var(--surface); border: 1px solid var(--border);
        transition: transform .2s, box-shadow .2s;
    }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 32px rgba(0,0,0,0.07); }
    .stat-icon {
        width: 52px; height: 52px; border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem; flex-shrink: 0;
    }

    /* ────────────────────────────────────────────────────
       CATEGORY PILLS (scroll)
    ──────────────────────────────────────────────────── */
    .cat-strip { display: flex; gap: 10px; overflow-x: auto; padding-bottom: 4px; }
    .cat-strip::-webkit-scrollbar { display: none; }
    .cat-pill {
        flex-shrink: 0; border-radius: 14px; padding: 12px 18px;
        display: flex; align-items: center; gap: 10px;
        cursor: pointer; border: 1.5px solid transparent;
        transition: all .2s; white-space: nowrap;
    }
    .cat-pill:hover { border-color: var(--blue); background: white !important; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.07); }

    /* ────────────────────────────────────────────────────
       PROGRESS BARS
    ──────────────────────────────────────────────────── */
    .prog-bar { height: 8px; border-radius: 99px; background: #e8eef8; overflow: hidden; }
    .prog-fill { height: 100%; border-radius: 99px; transition: width 1s cubic-bezier(.34,1.2,.64,1); }

    /* ────────────────────────────────────────────────────
       DONUT (SVG)
    ──────────────────────────────────────────────────── */
    .donut-wrap { position: relative; width: 100px; height: 100px; }
    .donut-wrap svg { transform: rotate(-90deg); }
    .donut-center {
        position: absolute; inset: 0;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
    }

    /* ────────────────────────────────────────────────────
       SCHEDULE ITEM
    ──────────────────────────────────────────────────── */
    .schedule-item {
        display: flex; align-items: center; gap: 14px;
        padding: 12px 14px; border-radius: 14px;
        transition: background .2s;
    }
    .schedule-item:hover { background: var(--base); }
    .sched-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
    .sched-time { font-size: 0.72rem; font-weight: 700; color: var(--muted); width: 44px; flex-shrink: 0; }

    /* ────────────────────────────────────────────────────
       ASSIGNMENT CARD
    ──────────────────────────────────────────────────── */
    .assign-row {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 14px; border-radius: 14px;
        transition: background .2s; cursor: default;
    }
    .assign-row:hover { background: var(--base); }
    .assign-icon {
        width: 40px; height: 40px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; flex-shrink: 0;
    }

    /* ────────────────────────────────────────────────────
       COURSE CARD (continue learning)
    ──────────────────────────────────────────────────── */
    .course-card {
        border-radius: 18px; padding: 16px;
        display: flex; gap: 14px; align-items: center;
        border: 1.5px solid var(--border);
        background: var(--surface);
        transition: all .2s; cursor: pointer;
    }
    .course-card:hover { border-color: var(--blue); box-shadow: 0 6px 24px rgba(37,99,235,0.1); transform: translateY(-1px); }
    .course-thumb {
        width: 52px; height: 52px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; flex-shrink: 0;
    }

    /* ────────────────────────────────────────────────────
       BADGE / ACHIEVEMENT
    ──────────────────────────────────────────────────── */
    .badge-item {
        display: flex; flex-direction: column; align-items: center; gap: 6px;
        padding: 14px 10px; border-radius: 16px;
        border: 1.5px solid var(--border);
        transition: all .2s; cursor: default;
    }
    .badge-item:hover { border-color: var(--blue); background: #f0f4ff; transform: translateY(-2px); }

    /* ────────────────────────────────────────────────────
       SECTION HEADERS
    ──────────────────────────────────────────────────── */
    .sec-hd { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
    .sec-title { font-size: 0.92rem; font-weight: 700; color: var(--text); }
    .sec-link { font-size: 0.75rem; font-weight: 600; color: var(--blue); cursor: pointer; }
    .sec-link:hover { text-decoration: underline; }

    /* ────────────────────────────────────────────────────
       ANIMATIONS
    ──────────────────────────────────────────────────── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .anim-in { animation: fadeUp .5s ease both; }
    .d1 { animation-delay: .05s; }
    .d2 { animation-delay: .1s; }
    .d3 { animation-delay: .15s; }
    .d4 { animation-delay: .2s; }
    .d5 { animation-delay: .25s; }
    .d6 { animation-delay: .3s; }
    .d7 { animation-delay: .35s; }

    /* ────────────────────────────────────────────────────
       STREAK FIRE
    ──────────────────────────────────────────────────── */
    @keyframes flicker {
        0%,100% { transform: scale(1) rotate(-3deg); }
        50%     { transform: scale(1.1) rotate(3deg); }
    }
    .fire-emoji { display: inline-block; animation: flicker 1.4s ease-in-out infinite; }
</style>
@endpush

@section('content')
<div class="dash-shell">

    {{-- ════════════════════════════════════════
         SIDEBAR
    ════════════════════════════════════════ --}}
    <aside class="sidebar">
        {{-- Logo --}}
        <div class="sidebar-logo">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.75 19 7.5 19s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
        </div>

        {{-- Nav --}}
        <nav class="sidebar-nav">
            @php
            $sideNav = [
                ['tip'=>'Dashboard', 'active'=>true,  'path'=>'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                ['tip'=>'My Courses', 'active'=>false, 'path'=>'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.75 19 7.5 19s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                ['tip'=>'Schedule',   'active'=>false, 'path'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ['tip'=>'Progress',   'active'=>false, 'path'=>'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                ['tip'=>'Messages',   'active'=>false, 'path'=>'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
            ];
            @endphp
            @foreach($sideNav as $item)
                <button class="s-btn {{ $item['active'] ? 'active' : '' }}">
                    <span class="tip">{{ $item['tip'] }}</span>
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ $item['active'] ? '2.2' : '1.8' }}" d="{{ $item['path'] }}"/>
                    </svg>
                </button>
            @endforeach
        </nav>

        {{-- Bottom --}}
        <div class="sidebar-bottom">
            <button class="s-btn">
                <span class="tip">Settings</span>
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </button>
            <div class="sidebar-avatar">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'U') }}&background=2563eb&color=fff&size=36"
                     alt="avatar" style="width:100%;height:100%;object-fit:cover;">
            </div>
        </div>
    </aside>

    {{-- ════════════════════════════════════════
         MAIN AREA
    ════════════════════════════════════════ --}}
    <div class="dash-main">

        {{-- TOP BAR --}}
        <header class="topbar">
            <div class="flex items-center gap-4">
                <div>
                    <p class="text-xs text-slate-400 font-medium leading-none mb-0.5">Good morning ☀️</p>
                    <h1 class="text-[0.97rem] font-bold text-slate-800 leading-none">
                        {{ auth()->user()->name ?? 'Student' }}
                    </h1>
                </div>
                <div style="width:1px;height:28px;background:var(--border);"></div>
                <div class="topbar-search">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" placeholder="Search courses, lessons…">
                </div>
            </div>

            <div class="topbar-right">
                {{-- Streak chip --}}
                <div style="display:flex;align-items:center;gap:7px;background:#fff7ed;border:1.5px solid #fed7aa;border-radius:12px;padding:6px 14px;">
                    <span class="fire-emoji" style="font-size:1rem;">🔥</span>
                    <span style="font-size:0.78rem;font-weight:800;color:#c2410c;">7 Day Streak</span>
                </div>

                {{-- Notif --}}
                <div class="notif-btn">
                    <svg class="w-[18px] h-[18px] text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="notif-badge">3</span>
                </div>

                {{-- User chip --}}
                <div class="user-chip">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'U') }}&background=2563eb&color=fff&size=32"
                         alt="avatar">
                    <div class="hidden lg:block">
                        <p style="font-size:0.78rem;font-weight:700;color:var(--text);line-height:1.2;">{{ auth()->user()->name ?? 'Student' }}</p>
                        <p style="font-size:0.68rem;color:var(--muted);line-height:1.2;">Intermediate</p>
                    </div>
                    <svg class="w-3.5 h-3.5 hidden lg:block" style="color:var(--muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
        </header>

        {{-- PAGE BODY --}}
        <div class="page-body">
            <div class="grid" style="grid-template-columns: 1fr 300px; gap: 22px; align-items: start;">

                {{-- ████ LEFT COLUMN ████ --}}
                <div style="display:flex;flex-direction:column;gap:22px;">

                    {{-- ── HERO WELCOME CARD ── --}}
                    <div class="hero-card anim-in d1">
                        <div class="hero-grid-dots"></div>
                        <div class="glow-1"></div>
                        <div class="glow-2"></div>
                        <div style="position:relative;z-index:2;display:grid;grid-template-columns:1fr auto;align-items:center;gap:20px;">
                            <div>
                                <span style="display:inline-block;background:rgba(255,255,255,0.15);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.2);color:rgba(255,255,255,0.9);font-size:0.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;padding:4px 12px;border-radius:99px;margin-bottom:14px;">
                                    🎓 IC.EDU Dashboard
                                </span>
                                <h2 style="font-size:2rem;font-weight:900;color:white;line-height:1.1;margin-bottom:10px;">
                                    Welcome back,<br>
                                    <span style="background:linear-gradient(90deg,#93c5fd,#c4b5fd);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">
                                        {{ explode(' ', auth()->user()->name ?? 'Student')[0] }}! 👋
                                    </span>
                                </h2>
                                <p style="font-size:0.85rem;color:rgba(255,255,255,0.65);margin-bottom:20px;max-width:380px;line-height:1.7;">
                                    You're on a <strong style="color:white;">7-day streak</strong>! Keep it up — you're just 3 lessons away from your next badge.
                                </p>
                                <div style="display:flex;gap:10px;flex-wrap:wrap;">
                                    <a href="#" style="display:inline-flex;align-items:center;gap:8px;background:white;color:#2563eb;font-size:0.82rem;font-weight:700;padding:10px 20px;border-radius:12px;text-decoration:none;transition:all .2s;box-shadow:0 4px 16px rgba(0,0,0,0.15);">
                                        Continue Learning
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                    </a>
                                    <a href="#" style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.12);color:white;font-size:0.82rem;font-weight:600;padding:10px 20px;border-radius:12px;text-decoration:none;border:1px solid rgba(255,255,255,0.2);transition:all .2s;">
                                        Browse Courses
                                    </a>
                                </div>
                            </div>
                            {{-- Progress ring --}}
                            <div style="text-align:center;flex-shrink:0;" class="hidden lg:block">
                                <div style="position:relative;display:inline-block;">
                                    <svg width="110" height="110" viewBox="0 0 36 36" style="transform:rotate(-90deg);">
                                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="rgba(255,255,255,0.12)" stroke-width="2.5"/>
                                        <circle cx="18" cy="18" r="15.9" fill="none"
                                                stroke="white" stroke-width="2.5"
                                                stroke-dasharray="75 25" stroke-linecap="round"
                                                style="filter:drop-shadow(0 0 6px rgba(255,255,255,0.6));"/>
                                    </svg>
                                    <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;">
                                        <span style="font-size:1.5rem;font-weight:900;color:white;line-height:1;">75%</span>
                                        <span style="font-size:0.62rem;color:rgba(255,255,255,0.6);font-weight:600;text-transform:uppercase;letter-spacing:.06em;">Done</span>
                                    </div>
                                </div>
                                <p style="color:rgba(255,255,255,0.7);font-size:0.75rem;font-weight:600;margin-top:6px;">Course Progress</p>
                            </div>
                        </div>
                    </div>

                    {{-- ── STAT MINI CARDS ── --}}
                    <div class="grid grid-cols-3 gap-4 anim-in d2">
                        @php
                        $statCards = [
                            ['emoji'=>'📚', 'val'=>'12', 'unit'=>'Courses', 'sub'=>'Completed', 'bg'=>'#eff6ff', 'accent'=>'#2563eb'],
                            ['emoji'=>'🏅', 'val'=>'5',  'unit'=>'Badges', 'sub'=>'Earned', 'bg'=>'#f5f3ff', 'accent'=>'#6366f1'],
                            ['emoji'=>'🏆', 'val'=>'2',  'unit'=>'Certs', 'sub'=>'Achieved', 'bg'=>'#fffbeb', 'accent'=>'#d97706'],
                        ];
                        @endphp
                        @foreach($statCards as $sc)
                        <div class="stat-card">
                            <div class="stat-icon" style="background:{{ $sc['bg'] }};">{{ $sc['emoji'] }}</div>
                            <div>
                                <p style="font-size:1.6rem;font-weight:900;color:var(--text);line-height:1;">{{ $sc['val'] }}</p>
                                <p style="font-size:0.78rem;font-weight:600;color:var(--muted);margin-top:2px;">{{ $sc['sub'] }} {{ $sc['unit'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- ── CONTINUE LEARNING ── --}}
                    <div class="anim-in d3">
                        <div class="sec-hd">
                            <span class="sec-title">Continue Learning</span>
                            <span class="sec-link">View all courses →</span>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            @php
                            $courses = [
                                ['emoji'=>'📝', 'bg'=>'#dbeafe', 'title'=>'IELTS Academic — Writing Task 2', 'sub'=>'Module 4 of 8 · Academic Writing', 'pct'=>48, 'color'=>'#2563eb', 'tag'=>'In Progress'],
                                ['emoji'=>'🎤', 'bg'=>'#dcfce7', 'title'=>'Fluent Speaking Bootcamp', 'sub'=>'Module 2 of 6 · Speaking Skills', 'pct'=>28, 'color'=>'#16a34a', 'tag'=>'New Lesson'],
                                ['emoji'=>'📖', 'bg'=>'#ede9fe', 'title'=>'TOEFL iBT Complete Prep', 'sub'=>'Module 6 of 10 · Test Preparation', 'pct'=>62, 'color'=>'#7c3aed', 'tag'=>'Almost Done'],
                            ];
                            @endphp
                            @foreach($courses as $c)
                            <div class="course-card">
                                <div class="course-thumb" style="background:{{ $c['bg'] }};">{{ $c['emoji'] }}</div>
                                <div style="flex:1;min-width:0;">
                                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;">
                                        <p style="font-size:0.85rem;font-weight:700;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $c['title'] }}</p>
                                        <span style="font-size:0.65rem;font-weight:700;color:{{ $c['color'] }};background:{{ $c['bg'] }};padding:3px 9px;border-radius:99px;flex-shrink:0;margin-left:10px;">{{ $c['tag'] }}</span>
                                    </div>
                                    <p style="font-size:0.73rem;color:var(--muted);margin-bottom:8px;">{{ $c['sub'] }}</p>
                                    <div style="display:flex;align-items:center;gap:10px;">
                                        <div class="prog-bar" style="flex:1;">
                                            <div class="prog-fill" style="width:{{ $c['pct'] }}%;background:{{ $c['color'] }};"></div>
                                        </div>
                                        <span style="font-size:0.72rem;font-weight:700;color:{{ $c['color'] }};flex-shrink:0;">{{ $c['pct'] }}%</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- ── EXPLORE CATEGORIES ── --}}
                    <div class="anim-in d4">
                        <div class="sec-hd">
                            <span class="sec-title">Explore Categories</span>
                            <span class="sec-link">All categories →</span>
                        </div>
                        <div class="cat-strip">
                            @php
                            $cats = [
                                ['label'=>'IELTS Prep',  'count'=>'24 courses', 'emoji'=>'📝', 'bg'=>'#dbeafe'],
                                ['label'=>'TOEFL Prep',  'count'=>'18 courses', 'emoji'=>'🎓', 'bg'=>'#ede9fe'],
                                ['label'=>'Speaking',    'count'=>'32 courses', 'emoji'=>'🗣️', 'bg'=>'#dcfce7'],
                                ['label'=>'Writing',     'count'=>'15 courses', 'emoji'=>'✍️', 'bg'=>'#fef9c3'],
                                ['label'=>'Grammar',     'count'=>'40 courses', 'emoji'=>'📖', 'bg'=>'#fce7f3'],
                                ['label'=>'TOEIC Prep',  'count'=>'12 courses', 'emoji'=>'🏆', 'bg'=>'#fff7ed'],
                            ];
                            @endphp
                            @foreach($cats as $cat)
                            <div class="cat-pill" style="background:{{ $cat['bg'] }};">
                                <span style="font-size:1.3rem;">{{ $cat['emoji'] }}</span>
                                <div>
                                    <p style="font-size:0.8rem;font-weight:700;color:var(--text);">{{ $cat['label'] }}</p>
                                    <p style="font-size:0.68rem;color:var(--muted);">{{ $cat['count'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- ── TODAY'S SCHEDULE ── --}}
                    <div class="card anim-in d5">
                        <div class="card-pad" style="border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
                            <div>
                                <p class="sec-title">Today's Schedule</p>
                                <p style="font-size:0.72rem;color:var(--muted);margin-top:2px;">{{ now()->format('l, d F Y') }}</p>
                            </div>
                            <span class="sec-link">View calendar →</span>
                        </div>
                        <div style="padding:10px 8px;">
                            @php
                            $schedules = [
                                ['time'=>'09:00', 'title'=>'IELTS Reading Practice', 'duration'=>'60 min', 'color'=>'#2563eb', 'bg'=>'#eff6ff', 'emoji'=>'📖'],
                                ['time'=>'11:00', 'title'=>'Grammar Workshop', 'duration'=>'45 min', 'color'=>'#7c3aed', 'bg'=>'#f5f3ff', 'emoji'=>'📝'],
                                ['time'=>'13:30', 'title'=>'Live Speaking Session', 'duration'=>'90 min', 'color'=>'#16a34a', 'bg'=>'#f0fdf4', 'emoji'=>'🎤'],
                                ['time'=>'15:00', 'title'=>'Vocabulary Quiz', 'duration'=>'30 min', 'color'=>'#d97706', 'bg'=>'#fffbeb', 'emoji'=>'🧩'],
                            ];
                            @endphp
                            @foreach($schedules as $s)
                            <div class="schedule-item">
                                <span class="sched-time">{{ $s['time'] }}</span>
                                <span class="sched-dot" style="background:{{ $s['color'] }};"></span>
                                <div style="flex:1;display:flex;align-items:center;justify-content:space-between;background:{{ $s['bg'] }};border-radius:12px;padding:10px 14px;">
                                    <div style="display:flex;align-items:center;gap:10px;">
                                        <span style="font-size:1.1rem;">{{ $s['emoji'] }}</span>
                                        <p style="font-size:0.82rem;font-weight:600;color:var(--text);">{{ $s['title'] }}</p>
                                    </div>
                                    <span style="font-size:0.7rem;font-weight:600;color:{{ $s['color'] }};background:white;padding:3px 8px;border-radius:8px;">{{ $s['duration'] }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
                {{-- ████ END LEFT ████ --}}

                {{-- ████ RIGHT COLUMN ████ --}}
                <div style="display:flex;flex-direction:column;gap:22px;">

                    {{-- ── PERFORMANCE RING ── --}}
                    <div class="card card-pad anim-in d1">
                        <div class="sec-hd">
                            <span class="sec-title">Performance</span>
                            <span style="font-size:0.72rem;font-weight:600;color:var(--muted);">This Month</span>
                        </div>

                        {{-- Donut --}}
                        <div style="display:flex;justify-content:center;margin-bottom:18px;">
                            <div class="donut-wrap">
                                <svg width="100" height="100" viewBox="0 0 36 36">
                                    <circle cx="18" cy="18" r="15.9" fill="none" stroke="#e8eef8" stroke-width="3"/>
                                    <circle cx="18" cy="18" r="15.9" fill="none"
                                            stroke="url(#perfGrad)" stroke-width="3"
                                            stroke-dasharray="75 25" stroke-linecap="round"/>
                                    <defs>
                                        <linearGradient id="perfGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                            <stop offset="0%" style="stop-color:#2563eb"/>
                                            <stop offset="100%" style="stop-color:#6366f1"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <div class="donut-center">
                                    <span style="font-size:1.4rem;font-weight:900;color:var(--text);">75%</span>
                                    <span style="font-size:0.6rem;color:var(--muted);font-weight:600;">Overall</span>
                                </div>
                            </div>
                        </div>

                        {{-- Skills --}}
                        @php
                        $skills = [
                            ['label'=>'Listening', 'pct'=>75, 'color'=>'#2563eb'],
                            ['label'=>'Reading',   'pct'=>60, 'color'=>'#6366f1'],
                            ['label'=>'Writing',   'pct'=>45, 'color'=>'#f59e0b'],
                            ['label'=>'Speaking',  'pct'=>55, 'color'=>'#10b981'],
                        ];
                        @endphp
                        <div style="display:flex;flex-direction:column;gap:12px;">
                            @foreach($skills as $sk)
                            <div>
                                <div style="display:flex;justify-content:space-between;margin-bottom:5px;">
                                    <span style="font-size:0.75rem;font-weight:600;color:var(--muted);">{{ $sk['label'] }}</span>
                                    <span style="font-size:0.75rem;font-weight:700;color:var(--text);">{{ $sk['pct'] }}%</span>
                                </div>
                                <div class="prog-bar">
                                    <div class="prog-fill" style="width:{{ $sk['pct'] }}%;background:{{ $sk['color'] }};"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- ── UPCOMING ASSIGNMENTS ── --}}
                    <div class="card anim-in d2">
                        <div class="card-pad" style="border-bottom:1px solid var(--border);">
                            <div class="sec-hd" style="margin-bottom:0;">
                                <span class="sec-title">Assignments</span>
                                <span class="sec-link">See all →</span>
                            </div>
                        </div>
                        <div style="padding:8px;">
                            @php
                            $assignments = [
                                ['title'=>'IELTS Writing Task 2', 'due'=>'Due Feb 25 · 10:00 AM', 'emoji'=>'✍️', 'bg'=>'#eff6ff', 'urgent'=>true],
                                ['title'=>'Pronunciation Exercise', 'due'=>'Due Feb 26 · 02:00 PM', 'emoji'=>'🗣️', 'bg'=>'#f5f3ff', 'urgent'=>false],
                                ['title'=>'Grammar Mock Test', 'due'=>'Due Feb 28 · 09:00 AM', 'emoji'=>'📋', 'bg'=>'#f0fdf4', 'urgent'=>false],
                            ];
                            @endphp
                            @foreach($assignments as $a)
                            <div class="assign-row">
                                <div class="assign-icon" style="background:{{ $a['bg'] }};">{{ $a['emoji'] }}</div>
                                <div style="flex:1;min-width:0;">
                                    <p style="font-size:0.82rem;font-weight:700;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $a['title'] }}</p>
                                    <p style="font-size:0.7rem;color:var(--muted);margin-top:2px;">{{ $a['due'] }}</p>
                                </div>
                                @if($a['urgent'])
                                <span style="font-size:0.62rem;font-weight:700;color:#dc2626;background:#fef2f2;border:1px solid #fecaca;padding:2px 8px;border-radius:99px;flex-shrink:0;">Soon</span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- ── BADGES / ACHIEVEMENTS ── --}}
                    <div class="card card-pad anim-in d3">
                        <div class="sec-hd">
                            <span class="sec-title">Achievements</span>
                            <span class="sec-link">All badges →</span>
                        </div>
                        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;">
                            @php
                            $badges = [
                                ['emoji'=>'🔥', 'label'=>'Streak 7', 'earned'=>true],
                                ['emoji'=>'📚', 'label'=>'Bookworm', 'earned'=>true],
                                ['emoji'=>'🎤', 'label'=>'Speaker', 'earned'=>true],
                                ['emoji'=>'🏆', 'label'=>'Champion', 'earned'=>true],
                                ['emoji'=>'⚡', 'label'=>'Fast Learn', 'earned'=>true],
                                ['emoji'=>'🔒', 'label'=>'???', 'earned'=>false],
                            ];
                            @endphp
                            @foreach($badges as $b)
                            <div class="badge-item" style="{{ !$b['earned'] ? 'opacity:.35;filter:grayscale(1);' : '' }}">
                                <span style="font-size:1.5rem;">{{ $b['emoji'] }}</span>
                                <span style="font-size:0.65rem;font-weight:700;color:var(--muted);">{{ $b['label'] }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- ── QUICK ACTIONS ── --}}
                    <div class="anim-in d4">
                        <p class="sec-title" style="margin-bottom:12px;">Quick Actions</p>
                        <div style="display:flex;flex-direction:column;gap:8px;">
                            @php
                            $actions = [
                                ['emoji'=>'🎯', 'label'=>'Take a Mock Test', 'color'=>'#2563eb', 'bg'=>'#eff6ff'],
                                ['emoji'=>'📅', 'label'=>'Book Speaking Session', 'color'=>'#16a34a', 'bg'=>'#f0fdf4'],
                                ['emoji'=>'📊', 'label'=>'View Full Report', 'color'=>'#7c3aed', 'bg'=>'#f5f3ff'],
                            ];
                            @endphp
                            @foreach($actions as $act)
                            <button style="display:flex;align-items:center;gap:12px;background:{{ $act['bg'] }};border:1.5px solid transparent;border-radius:14px;padding:12px 16px;cursor:pointer;width:100%;text-align:left;transition:all .2s;font-family:inherit;"
                                    onmouseover="this.style.borderColor='{{ $act['color'] }}';this.style.background='white'"
                                    onmouseout="this.style.borderColor='transparent';this.style.background='{{ $act['bg'] }}'">
                                <span style="font-size:1.2rem;">{{ $act['emoji'] }}</span>
                                <span style="font-size:0.82rem;font-weight:700;color:{{ $act['color'] }};">{{ $act['label'] }}</span>
                                <svg style="margin-left:auto;color:{{ $act['color'] }};" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                            @endforeach
                        </div>
                    </div>

                </div>
                {{-- ████ END RIGHT ████ --}}

            </div>
        </div>
        {{-- END PAGE BODY --}}

    </div>
    {{-- END MAIN --}}

</div>
@endsection