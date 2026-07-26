@extends('layouts.test_taker')
@section('title', 'My Courses')

@section('content')
@php
    $cntTotal     = $enrollments->count();
    $cntActive    = $enrollments->filter(fn($e) => $e->status === 'active')->count();
    $cntGraduated = $enrollments->filter(fn($e) => $e->status === 'graduated')->count();
    $cntDropped   = $enrollments->filter(fn($e) => $e->status === 'dropped')->count();
@endphp

<div class="mco__page ec__page-wrapper">

    {{-- ── HEADER ── --}}
    <div class="mco__header anim-in d1">
        <div>
            <div class="ec__breadcrumb">
                <span class="ec__breadcrumb-root">Portal</span>
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                    <path d="M4.5 3L7.5 6L4.5 9" stroke="#94a3b8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="ec__breadcrumb-current">My Courses</span>
            </div>
            <h1 class="ec__page-title">My Courses</h1>
            <p class="ec__page-subtitle">Your enrolled learning paths — track progress and continue anytime.</p>
        </div>
        <a href="{{ route('test_taker.course.index') }}" class="mco__browse-btn">
            <x-lucide-compass style="width:14px;height:14px;" />
            Browse Courses
        </a>
    </div>

    {{-- ── FLASH ── --}}
    @if(session('success'))
    <div class="mco__flash mco__flash--ok">
        <x-lucide-check-circle style="width:14px;height:14px;flex-shrink:0;" />
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mco__flash mco__flash--err">
        <x-lucide-alert-circle style="width:14px;height:14px;flex-shrink:0;" />
        {{ session('error') }}
    </div>
    @endif

    {{-- ── STAT STRIP ── --}}
    <div class="mco__stats anim-in d2">
        <div class="mco__stat">
            <span class="mco__stat-num">{{ $cntTotal }}</span>
            <span class="mco__stat-label">Total Enrolled</span>
        </div>
        <div class="mco__stat-div"></div>
        <div class="mco__stat">
            <span class="mco__stat-num" style="color:#059669;">{{ $cntActive }}</span>
            <span class="mco__stat-label">In Progress</span>
        </div>
        <div class="mco__stat-div"></div>
        <div class="mco__stat">
            <span class="mco__stat-num" style="color:#1A456C;">{{ $cntGraduated }}</span>
            <span class="mco__stat-label">Completed</span>
        </div>
        @if($cntDropped)
        <div class="mco__stat-div"></div>
        <div class="mco__stat">
            <span class="mco__stat-num" style="color:#dc2626;">{{ $cntDropped }}</span>
            <span class="mco__stat-label">Dropped</span>
        </div>
        @endif
    </div>

    {{-- ── COURSE LIST ── --}}
    @if($enrollments->isEmpty())
    <div class="mco__empty anim-in d3">
        <div class="mco__empty-icon">
            <x-lucide-book-open style="width:32px;height:32px;color:#1A456C;opacity:0.5;" />
        </div>
        <h3 class="mco__empty-title">No courses yet</h3>
        <p class="mco__empty-text">You haven't enrolled in any courses. Browse our catalog to get started.</p>
        <a href="{{ route('test_taker.course.index') }}" class="mco__empty-cta">
            Browse Courses
            <x-lucide-arrow-right style="width:14px;height:14px;" />
        </a>
    </div>
    @else
    <div class="mco__list anim-in d3">
        @foreach($enrollments as $enrollment)
        @php
            $course = $enrollment->course;

            $tl = is_array($course->target_level)
                ? ($course->target_level[0] ?? 'Intermediate')
                : ($course->target_level ?? 'Intermediate');

            $levelMap = [
                'Beginner'     => ['color' => '#059669', 'soft' => 'rgba(5,150,105,0.08)'],
                'Intermediate' => ['color' => '#d97706', 'soft' => 'rgba(217,119,6,0.08)'],
                'Advanced'     => ['color' => '#dc2626', 'soft' => 'rgba(220,38,38,0.08)'],
            ];
            $lc = $levelMap[$tl] ?? $levelMap['Intermediate'];

            $statusMap = [
                'active'    => ['label' => 'In Progress', 'color' => '#059669', 'bg' => 'rgba(5,150,105,0.08)',  'icon' => 'play-circle'],
                'graduated' => ['label' => 'Completed',   'color' => '#1A456C', 'bg' => 'rgba(26,69,108,0.08)', 'icon' => 'award'],
                'dropped'   => ['label' => 'Dropped',     'color' => '#dc2626', 'bg' => 'rgba(220,38,38,0.08)', 'icon' => 'x-circle'],
            ];
            $st = $statusMap[$enrollment->status] ?? $statusMap['active'];

            $enrolledDate = $enrollment->enrolled_at
                ? $enrollment->enrolled_at->format('d M Y')
                : $enrollment->created_at->format('d M Y');

            $firstLesson = $course->modules->first()?->lessons->first();
        @endphp

        <div class="mco__row anim-in d{{ ($loop->index % 4) + 1 }}">

            {{-- Thumbnail --}}
            <div class="mco__thumb">
                @if($course->thumbnail_path)
                    <img src="{{ asset('storage/' . $course->thumbnail_path) }}" class="mco__thumb-img">
                @else
                    <x-lucide-book-open style="width:22px;height:22px;color:#1A456C;opacity:0.8;" />
                @endif
            </div>

            {{-- Course info --}}
            <div class="mco__info">
                <div class="mco__info-top">
                    <h3 class="mco__title">{{ $course->title }}</h3>
                    <span class="mco__level-tag" style="color:{{ $lc['color'] }}; background:{{ $lc['soft'] }};">
                        {{ $tl }}
                    </span>
                </div>
                <p class="mco__desc">
                    {{ $course->description ? Str::limit(strip_tags($course->description), 100) : 'Structured lessons to build your skills step by step.' }}
                </p>
                <div class="mco__meta">
                    <span class="mco__meta-item">
                        <x-lucide-layers style="width:11px;height:11px;" />
                        {{ $course->modules_count ?? 0 }} modules
                    </span>
                    <span class="mco__meta-dot"></span>
                    <span class="mco__meta-item">
                        <x-lucide-calendar style="width:11px;height:11px;" />
                        Enrolled {{ $enrolledDate }}
                    </span>
                </div>
            </div>

            {{-- Status badge --}}
            <div class="mco__status-col">
                <span class="mco__status-badge" style="color:{{ $st['color'] }}; background:{{ $st['bg'] }};">
                    <x-dynamic-component :component="'lucide-' . $st['icon']" style="width:11px;height:11px;" />
                    {{ $st['label'] }}
                </span>
            </div>

            {{-- Actions --}}
            <div class="mco__action-col">
                @if($enrollment->status === 'active' && $firstLesson)
                    <a href="{{ route('test_taker.course.lesson', [$course->id, $firstLesson->id]) }}"
                       class="mco__btn-continue">
                        <x-lucide-play style="width:12px;height:12px;" />
                        Continue
                    </a>
                @endif
                <a href="{{ route('test_taker.course.show', $course->id) }}"
                   class="mco__btn-detail">
                    <x-lucide-arrow-right style="width:14px;height:14px;" />
                </a>
            </div>

        </div>
        @endforeach
    </div>
    @endif

</div>

<style>
/* ─────────────────────────────────────────
   MY COURSES PAGE  (prefix: mco__)
───────────────────────────────────────── */
.mco__page { width: 100%; }

.mco__header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}
.mco__browse-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 18px;
    border-radius: 11px;
    background: var(--base);
    border: 1.5px solid var(--border);
    font-size: 13px;
    font-weight: 700;
    color: var(--primary);
    text-decoration: none;
    transition: background .2s, border-color .2s;
    white-space: nowrap;
    flex-shrink: 0;
    align-self: center;
}
.mco__browse-btn:hover { background: white; border-color: var(--primary); }

.mco__flash {
    display: flex; align-items: center; gap: 9px;
    padding: 11px 14px; border-radius: 10px;
    font-size: 13px; font-weight: 600; margin-bottom: 20px;
}
.mco__flash--ok  { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
.mco__flash--err { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }

.mco__stats {
    display: flex;
    align-items: center;
    background: white;
    border: 1.5px solid var(--border);
    border-radius: 14px;
    padding: 16px 24px;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 12px;
}
.mco__stat { display: flex; flex-direction: column; align-items: center; gap: 3px; flex: 1; min-width: 80px; }
.mco__stat-num   { font-size: 22px; font-weight: 900; color: var(--text); font-family: 'Poppins', sans-serif; line-height: 1; }
.mco__stat-label { font-size: 11px; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: .06em; text-align: center; }
.mco__stat-div   { width: 1px; height: 36px; background: var(--border); flex-shrink: 0; margin: 0 4px; }

.mco__list { display: flex; flex-direction: column; gap: 10px; }

.mco__row {
    display: flex;
    align-items: center;
    gap: 16px;
    background: white;
    border: 1.5px solid var(--border);
    border-left: 3px solid #1A456C;
    border-radius: 14px;
    padding: 16px 18px;
    transition: box-shadow .2s, border-color .2s, transform .2s;
}
.mco__row:hover {
    box-shadow: 0 6px 24px rgba(26,69,108,0.08);
    transform: translateX(2px);
}

.mco__thumb {
    width: 52px; height: 52px;
    border-radius: 13px;
    background: rgba(26,69,108,0.07);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; overflow: hidden;
}
.mco__thumb-img { width: 100%; height: 100%; object-fit: cover; }

.mco__info { flex: 1; min-width: 0; }
.mco__info-top {
    display: flex; align-items: center; gap: 8px;
    margin-bottom: 4px; flex-wrap: wrap;
}
.mco__title {
    font-size: 14px; font-weight: 800; color: var(--text); margin: 0;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 360px;
}
.mco__level-tag {
    font-size: 10px; font-weight: 800; letter-spacing: .07em;
    text-transform: uppercase; padding: 3px 9px; border-radius: 99px;
    white-space: nowrap; flex-shrink: 0;
}
.mco__desc {
    font-size: 12px; color: var(--muted); margin: 0 0 7px; line-height: 1.5;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.mco__meta { display: flex; align-items: center; gap: 6px; }
.mco__meta-item {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 11px; color: var(--muted); font-weight: 500;
}
.mco__meta-dot { width: 3px; height: 3px; border-radius: 50%; background: var(--border); }

.mco__status-col { flex-shrink: 0; }
.mco__status-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 12px; border-radius: 99px;
    font-size: 11px; font-weight: 700;
}

.mco__action-col { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }
.mco__btn-continue {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 14px; border-radius: 10px;
    background: #1A456C; color: white;
    font-size: 12px; font-weight: 700; text-decoration: none;
    white-space: nowrap; transition: filter .2s, transform .2s;
}
.mco__btn-continue:hover { filter: brightness(1.1); transform: translateY(-1px); }
.mco__btn-detail {
    width: 34px; height: 34px; border-radius: 9px;
    background: var(--base); border: 1.5px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    color: var(--muted); text-decoration: none;
    transition: background .2s, border-color .2s, color .2s;
}
.mco__btn-detail:hover { background: white; border-color: var(--primary); color: var(--primary); }

.mco__empty {
    text-align: center; padding: 56px 24px;
    border: 1.5px dashed var(--border); border-radius: 18px; background: white;
}
.mco__empty-icon {
    width: 64px; height: 64px; border-radius: 18px;
    background: rgba(26,69,108,0.06);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
}
.mco__empty-title { font-size: 16px; font-weight: 800; color: var(--text); margin: 0 0 6px; }
.mco__empty-text  { font-size: 13px; color: var(--muted); margin: 0 0 20px; }
.mco__empty-cta {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 10px 22px; border-radius: 11px;
    background: #1A456C; color: white;
    font-size: 13px; font-weight: 700; text-decoration: none;
    transition: filter .2s;
}
.mco__empty-cta:hover { filter: brightness(1.1); }

@media (max-width: 700px) {
    .mco__status-col { display: none; }
    .mco__desc { display: none; }
    .mco__title { max-width: 100%; white-space: normal; }
    .mco__info-top { flex-wrap: wrap; }
    .mco__row { flex-wrap: wrap; padding: 14px; gap: 12px; }
    .mco__action-col { width: 100%; justify-content: flex-end; padding-top: 8px; border-top: 1px dashed var(--border); }
    .mco__stats { padding: 16px; gap: 16px; }
    .mco__stat { min-width: 40%; }
    .mco__stat-div { display: none; }
}
</style>

@endsection
