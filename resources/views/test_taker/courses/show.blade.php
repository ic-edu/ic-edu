@extends('layouts.test_taker')
@section('title', $course->title)

@section('content')
@php
    $tl = is_array($course->target_level)
        ? ($course->target_level[0] ?? 'Intermediate')
        : ($course->target_level ?? 'Intermediate');
    $displayLevel = is_array($course->target_level)
        ? implode(' · ', $course->target_level)
        : ($tl);
    $levelMap = [
        'Beginner'     => ['color' => '#059669', 'soft' => 'rgba(5,150,105,0.07)'],
        'Intermediate' => ['color' => '#d97706', 'soft' => 'rgba(217,119,6,0.07)'],
        'Advanced'     => ['color' => '#dc2626', 'soft' => 'rgba(220,38,38,0.07)'],
    ];
    $lc          = $levelMap[$tl] ?? $levelMap['Intermediate'];
    $firstLesson = $course->modules->first()?->lessons->first();
    $hasCert     = isset($certificate) && $certificate;

    $typeIconMap = [
        'video' => 'play-circle',
        'pdf'   => 'file-text',
        'text'  => 'align-left',
        'audio' => 'headphones',
        'link'  => 'external-link',
        'quiz'  => 'help-circle',
    ];
@endphp

<div class="ec__page-wrapper cd__page">

    {{-- ── Flash ── --}}
    @if(session('success'))
        <div class="cd__flash cd__flash--success">
            <x-lucide-check-circle class="cd__flash-icon" />
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="cd__flash cd__flash--error">
            <x-lucide-alert-circle class="cd__flash-icon" />
            {{ session('error') }}
        </div>
    @endif

    {{-- ── Breadcrumb ── --}}
    <div class="cd__breadcrumb">
        <a href="{{ route('test_taker.course.index') }}" class="cd__back">
            <x-lucide-arrow-left style="width:14px;height:14px;" />
            Browse Courses
        </a>
        <span class="cd__breadcrumb-sep">/</span>
        <span class="cd__breadcrumb-current">{{ Str::limit($course->title, 40) }}</span>
    </div>

    {{-- ── Course Header ── --}}
    <div class="cd__header" style="border-left: 4px solid #1A456C;">
        <div>
            <span class="cd__level-pill" style="background: {{ $lc['soft'] }}; color: {{ $lc['color'] }};">
                <x-lucide-bar-chart-2 style="width:11px;height:11px;" />
                {{ $displayLevel }}
            </span>
            <h1 class="cd__title">{{ $course->title }}</h1>
            <div class="cd__meta">
                <span class="cd__meta-chip">
                    <x-lucide-layers style="width:13px;height:13px;" />
                    {{ $course->modules_count }} modules
                </span>
                <span class="cd__meta-sep"></span>
                <span class="cd__meta-chip">
                    <x-lucide-book-open style="width:13px;height:13px;" />
                    {{ $totalLessons }} lessons
                </span>
                <span class="cd__meta-sep"></span>
                <span class="cd__meta-chip">
                    <x-lucide-clock style="width:13px;height:13px;" />
                    {{ $totalDuration > 0 ? $totalDuration . ' min' : 'Self-paced' }}
                </span>
                <span class="cd__meta-sep"></span>
                <span class="cd__meta-chip">
                    <x-lucide-users style="width:13px;height:13px;" />
                    {{ $course->enrollments_count }} enrolled
                </span>
            </div>
        </div>
    </div>

    {{-- ── Two-Column Layout ── --}}
    <div class="cd__layout">

        {{-- ══════════ LEFT — Main Content ══════════ --}}
        <div class="cd__main">

            {{-- About --}}
            @if($course->description)
                <section class="cd__section">
                    <h2 class="cd__section-title">
                        <x-lucide-info style="width:15px;height:15px;color:var(--primary);" />
                        About This Course
                    </h2>
                    <div class="cd__description">
                        {!! $course->description !!}
                    </div>
                </section>
            @endif

            {{-- Course Content / Modules --}}
            <section class="cd__section">
                <div class="cd__section-header">
                    <h2 class="cd__section-title">
                        <x-lucide-layout-list style="width:15px;height:15px;color:var(--primary);" />
                        Course Content
                    </h2>
                    <span class="cd__section-meta">{{ $course->modules_count }} modules · {{ $totalLessons }} lessons</span>
                </div>

                @if($isEnrolled)
                <div class="cd__accordion" style="display: flex; flex-direction: column; gap: 12px; margin-top: 16px;">
                    @foreach($course->modules as $idx => $module)
                    <div class="cd__accordion-item" style="border: 1.5px solid var(--border); border-radius: 14px; overflow: hidden; background: white;">
                        
                        {{-- Accordion Header --}}
                        <button type="button" class="cd__accordion-btn" data-target="acc-{{ $idx }}" style="width: 100%; display: flex; align-items: center; justify-content: space-between; padding: 18px 20px; background: var(--base); border: none; cursor: pointer; text-align: left; transition: background 0.2s;">
                            <div style="display: flex; align-items: center; gap: 14px;">
                                <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(26,69,108,0.1); color: #1A456C; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 800;">
                                    {{ str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }}
                                </div>
                                <div>
                                    <h3 style="font-size: 0.95rem; font-weight: 800; color: var(--text); margin: 0 0 3px;">{{ $module->title }}</h3>
                                    <p style="font-size: 0.75rem; color: var(--muted); margin: 0;">
                                        {{ $module->lessons->count() }} lessons
                                        @if($module->lessons->sum('duration_minutes'))
                                            · {{ $module->lessons->sum('duration_minutes') }} min
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <svg class="cd__accordion-icon" id="icon-{{ $idx }}" style="width: 18px; height: 18px; color: var(--muted); transition: transform 0.3s; transform: {{ $idx === 0 ? 'rotate(180deg)' : 'rotate(0deg)' }};" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        {{-- Accordion Body --}}
                        <div class="cd__accordion-body" id="acc-{{ $idx }}" style="display: {{ $idx === 0 ? 'block' : 'none' }}; border-top: 1px solid var(--border);">
                            <div class="cd__panel-lessons" style="padding: 8px 20px 20px;">
                                @foreach($module->lessons as $lesson)
                                @php $typeIcon = $typeIconMap[$lesson->type] ?? 'file'; @endphp
                                <a href="{{ route('test_taker.course.lesson', [$course->id, $lesson->id]) }}"
                                   class="cd__lesson" style="margin: 0; padding: 12px 8px; border-bottom: 1px solid var(--border); border-radius: 0;">
                                    <div class="cd__lesson-icon">
                                        <x-dynamic-component :component="'lucide-' . $typeIcon" style="width:12px;height:12px;" />
                                    </div>
                                    <div class="cd__lesson-info">
                                        <span class="cd__lesson-title">{{ $lesson->title }}</span>
                                        <div class="cd__lesson-meta">
                                            <span>{{ ucfirst($lesson->type) }}</span>
                                            @if($lesson->duration_minutes)
                                                <span class="cd__dot"></span>
                                                <span>{{ $lesson->duration_minutes }} min</span>
                                            @endif
                                        </div>
                                    </div>
                                    <x-lucide-chevron-right class="cd__lesson-arrow" />
                                </a>
                                @endforeach
                            </div>
                        </div>

                    </div>
                    @endforeach
                </div>

                @else
                {{-- Enrollment gate --}}
                <div class="cd__content-gate">
                    <div class="cd__gate-icon">
                        <x-lucide-lock style="width:22px;height:22px;color:#1A456C;" />
                    </div>
                    <p class="cd__gate-title">Enroll to Access Course Content</p>
                    <p class="cd__gate-desc">This course has {{ $course->modules_count }} modules and {{ $totalLessons }} lessons waiting for you. Enroll for free to unlock all materials.</p>
                    <form action="{{ route('test_taker.course.enroll', $course->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="cd__gate-btn">
                            <x-lucide-plus-circle style="width:15px;height:15px;" />
                            Enroll Now — Free
                        </button>
                    </form>
                </div>
                @endif
            </section>

        </div>

        {{-- ══════════ RIGHT — Sticky Sidebar ══════════ --}}
        <aside class="cd__sidebar">
            <div class="cd__sidebar-card">

                {{-- Level icon area --}}
                <div class="cd__sidebar-thumb" style="background: rgba(26,69,108,0.07); border-bottom: 2px solid #1A456C;">
                    <div class="cd__sidebar-icon" style="background: #1A456C;">
                        <x-lucide-book-open style="width:28px;height:28px;color:white;" />
                    </div>
                    <span class="cd__sidebar-level" style="color: #1A456C;">{{ $displayLevel }}</span>
                </div>

                {{-- Stats --}}
                <div class="cd__sidebar-stats">
                    <div class="cd__stat">
                        <x-lucide-layers class="cd__stat-icon" />
                        <span class="cd__stat-label">Modules</span>
                        <span class="cd__stat-val">{{ $course->modules_count }}</span>
                    </div>
                    <div class="cd__stat">
                        <x-lucide-book-open class="cd__stat-icon" />
                        <span class="cd__stat-label">Lessons</span>
                        <span class="cd__stat-val">{{ $totalLessons }}</span>
                    </div>
                    <div class="cd__stat">
                        <x-lucide-clock class="cd__stat-icon" />
                        <span class="cd__stat-label">Duration</span>
                        <span class="cd__stat-val">{{ $totalDuration > 0 ? $totalDuration . ' min' : '—' }}</span>
                    </div>
                    <div class="cd__stat">
                        <x-lucide-users class="cd__stat-icon" />
                        <span class="cd__stat-label">Students</span>
                        <span class="cd__stat-val">{{ $course->enrollments_count }}</span>
                    </div>
                </div>

                {{-- Enrollment status --}}
                <div class="cd__sidebar-status">
                    @if($isEnrolled)
                        <div class="cd__enrolled-badge">
                            <x-lucide-check-circle style="width:14px;height:14px;" />
                            You're enrolled in this course
                        </div>
                    @else
                        <div class="cd__not-enrolled-note">
                            <x-lucide-info style="width:13px;height:13px;flex-shrink:0;" />
                            Free to enroll — start anytime
                        </div>
                    @endif
                </div>

                {{-- CTA --}}
                <div class="cd__sidebar-cta">
                    @if($hasCert)
                        <a href="{{ route('test_taker.course.certificate.preview', $course->id) }}"
                           class="cd__btn cd__btn--cert">
                            <x-lucide-award style="width:16px;height:16px;" />
                            View Certificate
                        </a>
                    @endif

                    @if($isEnrolled)
                        @if($firstLesson)
                            <a href="{{ route('test_taker.course.lesson', [$course->id, $firstLesson->id]) }}"
                               class="cd__btn cd__btn--primary" style="background: #1A456C;">
                                <x-lucide-play-circle style="width:16px;height:16px;" />
                                {{ $hasCert ? 'Review Course' : 'Start Learning' }}
                            </a>
                        @endif
                    @else
                        <form action="{{ route('test_taker.course.enroll', $course->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="cd__btn cd__btn--primary" style="background: #1A456C; width:100%; border:none; cursor:pointer; font-family:inherit;">
                                <x-lucide-plus-circle style="width:16px;height:16px;" />
                                Enroll Now — Free
                            </button>
                        </form>
                    @endif
                </div>

            </div>
        </aside>

    </div>
</div>

<style>
/* ─────────────────────────────────────────
   COURSE DETAIL PAGE  (prefix: cd__)
───────────────────────────────────────── */
.cd__page { width: 100%; }

/* Flash */
.cd__flash {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 20px;
}
.cd__flash--success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
.cd__flash--error   { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
.cd__flash-icon { width: 16px; height: 16px; flex-shrink: 0; }

/* Breadcrumb */
.cd__breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 22px;
}
.cd__back {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    font-weight: 700;
    color: var(--muted);
    text-decoration: none;
    transition: color 0.2s;
}
.cd__back:hover { color: var(--primary); }
.cd__breadcrumb-sep { font-size: 12px; color: var(--border); }
.cd__breadcrumb-current { font-size: 12px; color: var(--text); font-weight: 600; }

/* Header */
.cd__header {
    padding: 20px 24px;
    background: white;
    border: 1.5px solid var(--border);
    border-radius: 16px;
    margin-bottom: 24px;
}
.cd__level-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 12px;
    border-radius: 99px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    margin-bottom: 10px;
}
.cd__title {
    font-size: 22px;
    font-weight: 800;
    color: var(--text);
    font-family: 'Poppins', sans-serif;
    line-height: 1.3;
    margin: 0 0 14px;
}
.cd__meta {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}
.cd__meta-chip {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    color: var(--muted);
    font-weight: 500;
}
.cd__meta-sep {
    width: 3px;
    height: 3px;
    border-radius: 50%;
    background: var(--border);
}

/* Two-column layout */
.cd__layout {
    display: grid;
    grid-template-columns: 1fr 280px;
    gap: 20px;
    align-items: start;
}
@media (max-width: 900px) {
    .cd__layout { grid-template-columns: 1fr; }
    .cd__sidebar { order: -1; margin-bottom: 8px; position: relative; top: auto; z-index: 1; }
}
@media (max-width: 700px) {
    .cd__breadcrumb { flex-wrap: wrap; }
    .cd__header { padding: 16px; }
    .cd__section { padding: 16px; }
    .cd__accordion-btn { padding: 14px 14px !important; }
    .cd__panel-lessons { padding: 8px 14px 16px !important; }
    .cd__gate-btn { width: 100%; justify-content: center; }
    .cd__content-gate { padding: 24px 16px; }
    .cd__title { font-size: 1.25rem; }
}

/* Main column */
.cd__main { display: flex; flex-direction: column; gap: 16px; }

/* Section */
.cd__section {
    background: white;
    border: 1.5px solid var(--border);
    border-radius: 16px;
    padding: 22px 24px;
}
.cd__section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
}
.cd__section-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 800;
    color: var(--text);
    margin: 0 0 18px;
    text-transform: uppercase;
    letter-spacing: 0.06em;
}
.cd__section-header .cd__section-title { margin-bottom: 0; }
.cd__section-meta { font-size: 12px; color: var(--muted); font-weight: 500; }

.cd__description {
    font-size: 14.5px;
    color: #374151;
    line-height: 1.85;
}
.cd__description p { margin: 0 0 10px; }
.cd__description p:last-child { margin-bottom: 0; }

/* ── Tab layout ── */
.cd__tabs {
    display: flex;
    overflow-x: auto;
    border-bottom: 2px solid var(--border);
    margin-bottom: 0;
    gap: 0;
    scrollbar-width: none;
}
.cd__tabs::-webkit-scrollbar { display: none; }

.cd__tab {
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 2px;
    padding: 10px 16px 11px;
    background: none;
    border: none;
    border-bottom: 3px solid transparent;
    margin-bottom: -2px;
    border-radius: 8px 8px 0 0;
    cursor: pointer;
    font-family: inherit;
    text-align: left;
    color: var(--muted);
    transition: color 0.2s, border-color 0.2s, background 0.2s;
}
.cd__tab:hover { color: var(--text); background: rgba(26,69,108,0.04); }
.cd__tab--active {
    font-weight: 700;
    background: rgba(26,69,108,0.08);
}

.cd__tab-num {
    font-size: 9px;
    font-weight: 800;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    opacity: 0.55;
}
.cd__tab--active .cd__tab-num { opacity: 1; }
.cd__tab-label {
    font-size: 13px;
    font-weight: 600;
    white-space: nowrap;
}
.cd__tab--active .cd__tab-label { font-weight: 800; }

/* Tab panels */
.cd__tab-panel { display: none; }
.cd__tab-panel--active { display: block; }

/* Panel header */
.cd__panel-head {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    padding: 16px 0 12px;
    border-bottom: 1px solid var(--border);
    margin-bottom: 4px;
}
.cd__panel-step {
    font-size: 10.5px;
    font-weight: 800;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    display: block;
    margin-bottom: 3px;
    color: #1A456C;
}
.cd__panel-title {
    font-size: 15.5px;
    font-weight: 800;
    color: var(--text);
    margin: 0;
    line-height: 1.3;
}
.cd__panel-meta {
    font-size: 12px;
    color: var(--muted);
    white-space: nowrap;
    padding-top: 2px;
    flex-shrink: 0;
}

/* Lesson rows inside panel */
.cd__panel-lessons {
    display: flex;
    flex-direction: column;
}

/* Shared lesson row styles */
.cd__lesson {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    color: inherit;
    padding: 9px 4px;
    border-bottom: 1px solid var(--border);
    transition: background 0.15s;
    border-radius: 8px;
    margin: 0 -4px;
}
.cd__lesson:last-child { border-bottom: none; }
.cd__lesson:hover:not(.cd__lesson--locked) { background: var(--base); }
.cd__lesson--locked { opacity: 0.45; cursor: not-allowed; pointer-events: none; }

.cd__lesson-icon {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    background: rgba(26,69,108,0.07);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #1A456C;
    flex-shrink: 0;
}

/* Enrollment gate */
.cd__content-gate {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 36px 24px 28px;
    gap: 10px;
}
.cd__gate-icon {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: rgba(26,69,108,0.08);
    border: 1.5px solid rgba(26,69,108,0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 6px;
}
.cd__gate-title {
    font-size: 15px;
    font-weight: 800;
    color: var(--text);
    margin: 0;
}
.cd__gate-desc {
    font-size: 13px;
    color: var(--muted);
    line-height: 1.65;
    margin: 0;
    max-width: 380px;
}
.cd__gate-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    margin-top: 6px;
    padding: 11px 24px;
    background: #1A456C;
    color: white;
    border: none;
    border-radius: 11px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    font-family: inherit;
    transition: filter 0.2s, transform 0.2s;
}
.cd__gate-btn:hover { filter: brightness(1.1); transform: translateY(-1px); }

.cd__lesson-info { flex: 1; min-width: 0; }
.cd__lesson-title {
    display: block;
    font-size: 13.5px;
    font-weight: 700;
    color: var(--text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.cd__lesson-meta {
    display: flex;
    align-items: center;
    gap: 5px;
    margin-top: 3px;
    font-size: 12px;
    color: var(--muted);
}
.cd__dot {
    width: 2px; height: 2px;
    border-radius: 50%;
    background: var(--muted);
}
.cd__preview-chip {
    padding: 1px 7px;
    border-radius: 99px;
    font-size: 10px;
    font-weight: 700;
    background: #f0fdf4;
    color: #16a34a;
    border: 1px solid #bbf7d0;
}
.cd__lesson-arrow {
    width: 14px;
    height: 14px;
    color: var(--muted);
    flex-shrink: 0;
}

/* Sidebar */
.cd__sidebar { position: sticky; top: 24px; }
.cd__sidebar-card {
    background: white;
    border: 1.5px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
}
.cd__sidebar-thumb {
    height: 120px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 10px;
}
.cd__sidebar-icon {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}
.cd__sidebar-level {
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.cd__sidebar-stats {
    padding: 16px 20px;
    border-bottom: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.cd__stat {
    display: flex;
    align-items: center;
    gap: 10px;
}
.cd__stat-icon { width: 14px; height: 14px; color: var(--muted); flex-shrink: 0; }
.cd__stat-label { flex: 1; font-size: 12px; color: var(--muted); }
.cd__stat-val   { font-size: 13px; font-weight: 800; color: var(--text); }

.cd__sidebar-status { padding: 14px 20px; border-bottom: 1px solid var(--border); }
.cd__enrolled-badge {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 12px;
    font-weight: 700;
    color: #16a34a;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 9px;
    padding: 9px 12px;
}
.cd__not-enrolled-note {
    display: flex;
    align-items: flex-start;
    gap: 7px;
    font-size: 12px;
    color: var(--muted);
    line-height: 1.5;
    padding: 2px 0;
}

.cd__sidebar-cta {
    padding: 16px 20px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.cd__btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 11px 16px;
    border-radius: 11px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s;
    font-family: inherit;
    text-align: center;
}
.cd__btn--primary {
    color: white;
}
.cd__btn--primary:hover { filter: brightness(1.1); transform: translateY(-1px); }
.cd__btn--cert {
    background: var(--base);
    color: var(--primary);
    border: 1.5px solid var(--border);
}
.cd__btn--cert:hover { border-color: var(--primary); background: white; }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.cd__accordion-btn');
    buttons.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const targetBody = document.getElementById(targetId);
            const icon = this.querySelector('.cd__accordion-icon');
            
            if (targetBody.style.display === 'none' || targetBody.style.display === '') {
                targetBody.style.display = 'block';
                icon.style.transform = 'rotate(180deg)';
            } else {
                targetBody.style.display = 'none';
                icon.style.transform = 'rotate(0deg)';
            }
        });
    });
});
</script>
@endpush

@endsection
