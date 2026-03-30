@extends('layouts.test_taker')
@section('title', 'My Dashboard')

@section('content')
<div class="dash-grid">

    {{-- LEFT COLUMN  --}}
    <div style="display:flex;flex-direction:column;gap:22px;">

        {{-- HERO WELCOME CARD --}}
        <div class="hero-card anim-in d1">
            <div class="hero-grid-dots"></div>
            <div class="glow-1"></div>
            <div class="glow-2"></div>
            <div class="hero-inner">
                <div>
                    <span style="display:inline-block;background:rgba(255,255,255,0.15);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.2);color:rgba(255,255,255,0.9);font-size:0.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;padding:4px 12px;border-radius:99px;margin-bottom:14px;">
                        🎓 IC-EDU Student Portal
                    </span>
                    <h2 style="font-size:2rem;font-weight:900;color:white;line-height:1.1;margin-bottom:10px;">
                        Welcome back,<br>
                        <span style="background:linear-gradient(90deg,#93c5fd,#c4b5fd);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">
                            {{ explode(' ', auth()->user()->name ?? 'Student')[0] }}! 👋
                        </span>
                    </h2>
                    <p style="font-size:0.85rem;color:rgba(255,255,255,0.65);margin-bottom:20px;max-width:380px;line-height:1.7;">
                        You have completed <strong style="color:white;">{{ $finishedExams ?? 0 }} Exams</strong> and currently have <strong style="color:white;">{{ $inProgressExams ?? 0 }} simulations</strong> in progress. Let's conquer the next one!
                    </p>
                    <div class="hero-inner-actions">
                        <a href="#" style="display:inline-flex;align-items:center;gap:8px;background:white;color:#2563eb;font-size:0.82rem;font-weight:700;padding:10px 20px;border-radius:12px;text-decoration:none;transition:all .2s;box-shadow:0 4px 16px rgba(0,0,0,0.15);">
                            Browse Exams (Courses)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
                
                {{-- Progress ring --}}
                <div class="mobile-hide" style="text-align:center;flex-shrink:0;">
                    <div style="position:relative;display:inline-block;">
                        <svg width="110" height="110" viewBox="0 0 36 36" style="transform:rotate(-90deg);">
                            <circle cx="18" cy="18" r="15.9" fill="none" stroke="rgba(255,255,255,0.12)" stroke-width="2.5"/>
                            <circle cx="18" cy="18" r="15.9" fill="none"
                                    stroke="white" stroke-width="2.5"
                                    stroke-dasharray="85 15" stroke-linecap="round"
                                    style="filter:drop-shadow(0 0 6px rgba(255,255,255,0.6));"/>
                        </svg>
                        <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;">
                            <span style="font-size:1.5rem;font-weight:900;color:white;line-height:1;">A+</span>
                            <span style="font-size:0.62rem;color:rgba(255,255,255,0.6);font-weight:600;text-transform:uppercase;letter-spacing:.06em;">Status</span>
                        </div>
                    </div>
                    <p style="color:rgba(255,255,255,0.7);font-size:0.75rem;font-weight:600;margin-top:6px;">Avg. Accuracy</p>
                </div>
            </div>
        </div>

        {{-- ── STAT MINI CARDS ── --}}
        <div class="stats-grid anim-in d2">
            <div class="stat-card">
                <div class="stat-icon" style="background:#eff6ff;">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.75 19 7.5 19s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div>
                    <p style="font-size:1.6rem;font-weight:900;color:var(--text);line-height:1;">{{ $finishedExams ?? 0 }}</p>
                    <p style="font-size:0.78rem;font-weight:600;color:var(--muted);margin-top:2px;">Finished Exams</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#f5f3ff;">
                    <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div>
                    <p style="font-size:1.6rem;font-weight:900;color:var(--text);line-height:1;">{{ $inProgressExams ?? 0 }}</p>
                    <p style="font-size:0.78rem;font-weight:600;color:var(--muted);margin-top:2px;">In Progress</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#fffbeb;">
                    <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p style="font-size:1.6rem;font-weight:900;color:var(--text);line-height:1;">{{ number_format($avgScore ?? 0, 1) }}</p>
                    <p style="font-size:0.78rem;font-weight:600;color:var(--muted);margin-top:2px;">Average Score</p>
                </div>
            </div>
        </div>

        {{-- ── CONTINUE LEARNING (IN PROGRESS EXAMS) ── --}}
        <div class="anim-in d3">
            <div class="sec-hd">
                <span class="sec-title">Continue Simulation</span>
                <a href="#" class="sec-link">View all exams →</a>
            </div>
            <div style="display:flex;flex-direction:column;gap:10px;">
                @forelse($recentPendingExams ?? [] as $attempt)
                <div class="course-card" onclick="window.location='{{ route('test_taker.exam.detail', $attempt->exam->id) }}'">
                    <div class="course-thumb" style="background:#dbeafe; color: #2563eb;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;">
                            <p style="font-size:0.85rem;font-weight:700;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $attempt->exam->title ?? 'Unknown Exam' }}
                            </p>
                            <span style="font-size:0.65rem;font-weight:700;color:#2563eb;background:#dbeafe;padding:3px 9px;border-radius:99px;flex-shrink:0;margin-left:10px;">
                                In Progress
                            </span>
                        </div>
                        <p style="font-size:0.73rem;color:var(--muted);margin-bottom:8px;">
                            {{ $attempt->exam->examType->name ?? 'Simulation' }} · Started {{ $attempt->started_at->diffForHumans() }}
                        </p>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div class="prog-bar" style="flex:1;">
                                <div class="prog-fill" style="width:50%;background:#2563eb;"></div>
                            </div>
                            <span style="font-size:0.72rem;font-weight:700;color:#2563eb;flex-shrink:0;">Resume</span>
                        </div>
                    </div>
                </div>
                @empty
                <div style="padding: 24px; text-align: center; border: 1.5px dashed var(--border); border-radius: 18px;">
                    <p style="font-size: 0.85rem; color: var(--muted); font-weight: 600;">No pending exams. Start a new one to show up here!</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- ── EXPLORE CATEGORIES ── --}}
        <div class="anim-in d4">
            <div class="sec-hd">
                <span class="sec-title">Explore Categories</span>
            </div>
            <div class="cat-strip flex gap-3 overflow-x-auto pb-2">
                @foreach($examCategories ?? [] as $idx => $cat)
                @php
                    $colors = [
                        ['icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>', 'bg'=>'#dbeafe', 'tx'=>'#2563eb'],
                        ['icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>', 'bg'=>'#ede9fe', 'tx'=>'#7c3aed'],
                        ['icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>', 'bg'=>'#dcfce7', 'tx'=>'#16a34a'],
                        ['icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>', 'bg'=>'#fef9c3', 'tx'=>'#ca8a04'],
                        ['icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.75 19 7.5 19s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>', 'bg'=>'#fce7f3', 'tx'=>'#db2777'],
                    ];
                    $c = $colors[$idx % count($colors)];
                @endphp
                <div class="cat-pill min-w-[140px]" style="background:{{ $c['bg'] }};">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="{{ $c['tx'] }}" viewBox="0 0 24 24">
                        {!! $c['icon'] !!}
                    </svg>
                    <div>
                        <p style="font-size:0.8rem;font-weight:700;color:var(--text);line-height:1.2;">{{ $cat->name }}</p>
                        <p style="font-size:0.68rem;color:var(--muted);line-height:1.2;margin-top:2px;">{{ $cat->exams_count }} exams</p>
                    </div>
                </div>
                @endforeach
                
                @if(isset($examCategories) && count($examCategories) == 0)
                <p style="font-size:0.75rem; color: var(--muted);">No exam categories found in the database.</p>
                @endif
            </div>
        </div>

    </div>
    {{-- END LEFT --}}

    {{-- RIGHT COLUMN  --}}
    <div style="display:flex;flex-direction:column;gap:22px;">

        {{-- ── PERFORMANCE SUMMARY ── --}}
        <div class="card card-pad anim-in d1">
            <div class="sec-hd">
                <span class="sec-title">Accuracy Rate</span>
                <span style="font-size:0.72rem;font-weight:600;color:var(--muted);">All Time</span>
            </div>

            {{-- Donut --}}
            <div style="display:flex;justify-content:center;margin-bottom:18px;">
                <div class="donut-wrap">
                    <svg width="100" height="100" viewBox="0 0 36 36" style="transform: rotate(-90deg);">
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#e8eef8" stroke-width="3"/>
                        <circle cx="18" cy="18" r="15.9" fill="none"
                                stroke="url(#perfGrad)" stroke-width="3"
                                stroke-dasharray="{{ min(100, $avgScore ?? 0) }} {{ max(0, 100 - ($avgScore ?? 0)) }}" stroke-linecap="round"/>
                        <defs>
                            <linearGradient id="perfGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" style="stop-color:#2563eb"/>
                                <stop offset="100%" style="stop-color:#6366f1"/>
                            </linearGradient>
                        </defs>
                    </svg>
                    <div style="position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                        <span style="font-size:1.4rem;font-weight:900;color:var(--text);">{{ number_format($avgScore ?? 0, 1) }}</span>
                        <span style="font-size:0.6rem;color:var(--muted);font-weight:600;">Average</span>
                    </div>
                </div>
            </div>

            <p style="font-size:0.75rem; color:var(--muted); text-align:center; font-weight:600;">
                Keep practicing to increase your score!
            </p>
        </div>

        {{-- ── QUICK ACTIONS ── --}}
        <div class="card card-pad anim-in d3">
            <p class="sec-title" style="margin-bottom:12px;">Quick Actions</p>
            <div style="display:flex;flex-direction:column;gap:8px;">
                <a href="#" style="display:flex;align-items:center;gap:12px;background:#eff6ff;border:1.5px solid transparent;border-radius:14px;padding:12px 16px;cursor:pointer;width:100%;text-align:left;transition:all .2s;text-decoration:none;"
                   onmouseover="this.style.borderColor='#2563eb';this.style.background='white'"
                   onmouseout="this.style.borderColor='transparent';this.style.background='#eff6ff'">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span style="font-size:0.82rem;font-weight:700;color:#2563eb;">Find Simulations</span>
                    <svg style="margin-left:auto;color:#2563eb;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="{{ route('profile.edit') }}" style="display:flex;align-items:center;gap:12px;background:#f5f3ff;border:1.5px solid transparent;border-radius:14px;padding:12px 16px;cursor:pointer;width:100%;text-align:left;transition:all .2s;text-decoration:none;"
                   onmouseover="this.style.borderColor='#7c3aed';this.style.background='white'"
                   onmouseout="this.style.borderColor='transparent';this.style.background='#f5f3ff'">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span style="font-size:0.82rem;font-weight:700;color:#7c3aed;">Setup My Profile</span>
                    <svg style="margin-left:auto;color:#7c3aed;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>

    </div>
    {{-- END RIGHT --}}

</div>
@endsection
