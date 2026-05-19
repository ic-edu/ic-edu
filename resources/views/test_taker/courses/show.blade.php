@extends('layouts.test_taker')
@section('title', $course->title)

@section('content')
<div style="max-width: 900px; margin: 0 auto; width: 100%;">

    {{-- BACK LINK --}}
    <a href="{{ route('test_taker.course.index') }}" class="anim-in d1" style="display: inline-flex; align-items: center; gap: 6px; font-size: 0.82rem; font-weight: 700; color: var(--muted); text-decoration: none; margin-bottom: 24px; transition: color .2s;"
       onmouseover="this.style.color='var(--blue)'" onmouseout="this.style.color='var(--muted)'">
        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
        Back to Browse Courses
    </a>

    {{-- SUCCESS / ERROR FLASH --}}
    @if(session('success'))
    <div class="anim-in d1" style="padding: 14px 20px; border-radius: 14px; background: #f0fdf4; border: 1.5px solid #bbf7d0; color: #15803d; font-size: 0.85rem; font-weight: 700; margin-bottom: 20px;">
        ✅ {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="anim-in d1" style="padding: 14px 20px; border-radius: 14px; background: #fef2f2; border: 1.5px solid #fecaca; color: #991b1b; font-size: 0.85rem; font-weight: 700; margin-bottom: 20px;">
        ❌ {{ session('error') }}
    </div>
    @endif

    {{-- COURSE HEADER --}}
    @php
        $gradients = [
            'linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #4f46e5 100%)',
            'linear-gradient(135deg, #064e3b 0%, #059669 50%, #0d9488 100%)',
            'linear-gradient(135deg, #7c2d12 0%, #ea580c 50%, #f59e0b 100%)',
        ];
        $grad = $gradients[$course->id % count($gradients)];
    @endphp
    <div class="card anim-in d1" style="overflow: hidden; margin-bottom: 24px;">
        <div style="background: {{ $grad }}; padding: 40px 32px; position: relative; overflow: hidden;">
            <div style="position:absolute;inset:0;opacity:0.06;background-image:radial-gradient(circle,white 1px,transparent 1px);background-size:20px 20px;pointer-events:none;"></div>
            <div style="position:absolute;width:200px;height:200px;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,0.12),transparent 65%);top:-50px;right:-30px;pointer-events:none;"></div>

            <div style="position: relative; z-index: 2;">
                <span style="display:inline-block;background:rgba(255,255,255,0.15);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.2);color:rgba(255,255,255,0.9);font-size:0.65rem;font-weight:800;letter-spacing:.08em;text-transform:uppercase;padding:4px 12px;border-radius:99px;margin-bottom:14px;">
                    🎓 {{ is_array($course->target_level) ? implode(' - ', $course->target_level) : ($course->target_level ?? 'Course') }}
                </span>
                <h1 style="font-size: 1.8rem; font-weight: 900; color: white; line-height: 1.2; margin-bottom: 10px;">
                    {{ $course->title }}
                </h1>
                <p style="font-size: 0.85rem; color: rgba(255,255,255,0.7); max-width: 500px; line-height: 1.7;">
                    Learning Management System — IC-EDU
                </p>
            </div>
        </div>

        {{-- STATS ROW --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); border-top: 1px solid var(--border);">
            <div style="padding: 20px 24px; text-align: center; border-right: 1px solid var(--border);">
                <p style="font-size: 0.6rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 6px;">Modules</p>
                <p style="font-size: 1.3rem; font-weight: 900; color: var(--text);">{{ $course->modules_count }}</p>
            </div>
            <div style="padding: 20px 24px; text-align: center; border-right: 1px solid var(--border);">
                <p style="font-size: 0.6rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 6px;">Lessons</p>
                <p style="font-size: 1.3rem; font-weight: 900; color: var(--text);">{{ $totalLessons }}</p>
            </div>
            <div style="padding: 20px 24px; text-align: center; border-right: 1px solid var(--border);">
                <p style="font-size: 0.6rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 6px;">Duration</p>
                <p style="font-size: 1.3rem; font-weight: 900; color: var(--text);">{{ $totalDuration }} <span style="font-size: 0.7rem; font-weight: 700; color: var(--muted);">min</span></p>
            </div>
            <div style="padding: 20px 24px; text-align: center;">
                <p style="font-size: 0.6rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 6px;">Enrolled</p>
                @if($isEnrolled)
                <span style="display:inline-block;padding:4px 10px;border-radius:99px;font-size:0.7rem;font-weight:800;background:#f0fdf4;color:#16a34a;">✓ Enrolled</span>
                @else
                <span style="display:inline-block;padding:4px 10px;border-radius:99px;font-size:0.7rem;font-weight:800;background:#fef2f2;color:#dc2626;">Not Yet</span>
                @endif
            </div>
        </div>
    </div>

    {{-- DESCRIPTION --}}
    @if($course->description)
    <div class="card card-pad anim-in d2" style="margin-bottom: 24px;">
        <h2 style="font-size: 0.75rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 16px;">About This Course</h2>
        <div style="font-size: 0.85rem; color: #374151; line-height: 1.8;">
            {!! $course->description !!}
        </div>
    </div>
    @endif

    {{-- MODULES & LESSONS --}}
    <div class="card card-pad anim-in d3" style="margin-bottom: 24px;">
        <h2 style="font-size: 0.75rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 20px;">Course Content</h2>
        
        <div style="display: flex; flex-direction: column; gap: 16px;">
            @foreach($course->modules as $idx => $module)
            <div style="border: 1px solid var(--border); border-radius: 16px; overflow: hidden;">
                {{-- Module Header --}}
                <div style="padding: 16px 20px; background: var(--base); display: flex; align-items: center; gap: 14px; cursor: pointer;"
                     onclick="this.nextElementSibling.style.display = this.nextElementSibling.style.display === 'none' ? 'block' : 'none'">
                    <div style="width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, var(--blue), var(--indigo)); color: white; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 900; flex-shrink: 0;">
                        {{ $idx + 1 }}
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <p style="font-size: 0.9rem; font-weight: 800; color: var(--text);">{{ $module->title }}</p>
                        <p style="font-size: 0.72rem; color: var(--muted); margin-top: 2px;">{{ $module->lessons->count() }} lessons
                            @if($module->lessons->sum('duration_minutes'))
                            · {{ $module->lessons->sum('duration_minutes') }} min
                            @endif
                        </p>
                    </div>
                    <svg style="width: 18px; height: 18px; color: var(--muted); flex-shrink: 0; transition: transform .2s;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>

                {{-- Lessons List --}}
                <div style="{{ $idx === 0 ? '' : 'display: none;' }}">
                    @foreach($module->lessons as $lesson)
                    @php
                        $typeIcons = ['video' => '🎬', 'pdf' => '📄', 'text' => '📝', 'audio' => '🎧', 'link' => '🔗', 'quiz' => '🧩'];
                        $icon = $typeIcons[$lesson->type] ?? '📄';
                        $canAccess = $isEnrolled || $lesson->is_previewable;
                    @endphp
                    <a href="{{ $canAccess ? route('test_taker.course.lesson', [$course->id, $lesson->id]) : '#' }}"
                       style="display: flex; align-items: center; gap: 14px; padding: 14px 20px; border-top: 1px solid var(--border); text-decoration: none; transition: background .15s; {{ !$canAccess ? 'opacity: 0.5; cursor: not-allowed;' : '' }}"
                       {{ !$canAccess ? '' : 'onmouseover=this.style.background="#f8faff" onmouseout=this.style.background="transparent"' }}>
                        <span style="font-size: 1.2rem; flex-shrink: 0;">{{ $icon }}</span>
                        <div style="flex: 1; min-width: 0;">
                            <p style="font-size: 0.82rem; font-weight: 700; color: var(--text);">{{ $lesson->title }}</p>
                            <div style="display: flex; gap: 10px; align-items: center; margin-top: 3px;">
                                <span style="font-size: 0.68rem; font-weight: 600; color: var(--muted); text-transform: uppercase;">{{ $lesson->type }}</span>
                                @if($lesson->duration_minutes)
                                <span style="font-size: 0.68rem; color: var(--muted);">· {{ $lesson->duration_minutes }} min</span>
                                @endif
                                @if($lesson->is_previewable)
                                <span style="font-size: 0.6rem; font-weight: 700; color: #16a34a; background: #f0fdf4; padding: 2px 6px; border-radius: 4px;">FREE</span>
                                @endif
                            </div>
                        </div>
                        @if($canAccess)
                        <svg style="width: 16px; height: 16px; color: var(--muted); flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        @else
                        <svg style="width: 16px; height: 16px; color: var(--muted); flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        @endif
                    </a>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- CTA --}}
    <div class="anim-in d4" style="text-align: right; margin-bottom: 40px;">
        @if($isEnrolled)
            @php
                $firstLesson = $course->modules->first()?->lessons->first();
            @endphp
            @if($firstLesson)
            <a href="{{ route('test_taker.course.lesson', [$course->id, $firstLesson->id]) }}"
               style="display: inline-flex; align-items: center; gap: 10px; padding: 14px 32px; border-radius: 14px; font-size: 0.9rem; font-weight: 800; background: linear-gradient(135deg, var(--blue), var(--indigo)); color: white; text-decoration: none; box-shadow: 0 6px 20px rgba(37,99,235,0.3); transition: all .2s;"
               onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Start Learning
            </a>
            @endif
        @else
            <form action="{{ route('test_taker.course.enroll', $course->id) }}" method="POST" style="display: inline-block;">
                @csrf
                <button type="submit"
                        style="display: inline-flex; align-items: center; gap: 10px; padding: 14px 32px; border-radius: 14px; font-size: 0.9rem; font-weight: 800; background: linear-gradient(135deg, var(--primary), #1e5282); color: white; border: none; cursor: pointer; box-shadow: 0 6px 20px rgba(26,69,108,0.3); transition: all .2s;"
                        onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Enroll Now — Free
                </button>
            </form>
        @endif
    </div>
</div>
@endsection
