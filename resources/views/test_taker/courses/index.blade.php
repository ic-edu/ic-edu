@extends('layouts.test_taker')
@section('title', 'Browse Courses')

@section('content')
@php
use App\Models\CourseEnrollment;
$enrolledCourseIds = auth()->check()
    ? CourseEnrollment::where('user_id', auth()->id())->pluck('course_id')->toArray()
    : [];
@endphp

<div class="ec__page-wrapper cc__page">

    {{-- ── PAGE HEADER ── --}}
    <div class="cc__header anim-in d1">
        <div>
            <div class="cc__breadcrumb">
                <span class="cc__breadcrumb-root">Portal</span>
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                    <path d="M4.5 3L7.5 6L4.5 9" stroke="#94a3b8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="cc__breadcrumb-current">Browse Courses</span>
            </div>
            <h1 class="cc__page-title">Browse Courses</h1>
            <p class="cc__page-subtitle">Structured learning paths to sharpen your skills and ace your exams.</p>
        </div>

        <div class="cc__search-wrap">
            <svg class="cc__search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="text" class="cc__search-input" id="course-search" placeholder="Search courses...">
        </div>
    </div>

    {{-- ── FILTER + COUNT ROW ── --}}
    <div class="cc__filter-row">
        <div class="cc__filter-tabs">
            <button class="cc__filter-tab cc__filter-tab--active" data-filter="all">All Courses</button>
            <button class="cc__filter-tab" data-filter="beginner">
                <span class="cc__filter-dot" style="background:#059669;"></span>Beginner
            </button>
            <button class="cc__filter-tab" data-filter="intermediate">
                <span class="cc__filter-dot" style="background:#d97706;"></span>Intermediate
            </button>
            <button class="cc__filter-tab" data-filter="advanced">
                <span class="cc__filter-dot" style="background:#dc2626;"></span>Advanced
            </button>
        </div>
        <span class="cc__count">
            <span class="cc__count-num" id="course-count">{{ count($courses) }}</span>
            course{{ count($courses) !== 1 ? 's' : '' }} available
        </span>
    </div>

    {{-- ── COURSES GRID ── --}}
    <div class="cc__grid" id="course-grid">

        @forelse($courses as $course)
        @php
            $tl = is_array($course->target_level)
                ? ($course->target_level[0] ?? 'Intermediate')
                : ($course->target_level ?? 'Intermediate');

            $displayLevel = is_array($course->target_level)
                ? implode(' · ', $course->target_level)
                : ($course->target_level ?? 'Course');

            $levelMap = [
                'Beginner'     => ['color' => '#059669', 'soft' => 'rgba(5,150,105,0.07)',  'deco' => 'rgba(5,150,105,1)',   'filter' => 'beginner'],
                'Intermediate' => ['color' => '#d97706', 'soft' => 'rgba(217,119,6,0.07)',  'deco' => 'rgba(217,119,6,1)',   'filter' => 'intermediate'],
                'Advanced'     => ['color' => '#dc2626', 'soft' => 'rgba(220,38,38,0.07)',  'deco' => 'rgba(220,38,38,1)',   'filter' => 'advanced'],
            ];
            $lc         = $levelMap[$tl] ?? $levelMap['Intermediate'];
            $isEnrolled = in_array($course->id, $enrolledCourseIds);
        @endphp

        <div class="cc__card anim-in d{{ $loop->index % 5 + 1 }}"
             data-level="{{ $lc['filter'] }}"
             data-title="{{ strtolower($course->title) }}">

            {{-- ── Thumbnail ── --}}
            <div class="cc__thumb">

                {{-- Decorative circles --}}
                <div class="cc__deco-ring cc__deco-ring--lg"></div>
                <div class="cc__deco-ring cc__deco-ring--sm"></div>
                <div class="cc__deco-grid"></div>

                @if($course->thumbnail_path)
                    <img src="{{ asset('storage/' . $course->thumbnail_path) }}"
                         alt="{{ $course->title }}"
                         class="cc__thumb-img">
                @else
                    {{-- Icon illustration --}}
                    <div class="cc__thumb-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                        </svg>
                    </div>
                @endif

                {{-- Level badge --}}
                <span class="cc__level-badge">{{ $displayLevel }}</span>

                {{-- Module count --}}
                <span class="cc__module-chip">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                    </svg>
                    {{ $course->modules_count }} modules
                </span>

                {{-- Enrolled state chip --}}
                @if($isEnrolled)
                    <span class="cc__enrolled-chip">
                        <svg width="10" height="10" viewBox="0 0 12 10" fill="none">
                            <path d="M1 5L4 8L11 1" stroke="#1A456C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Enrolled
                    </span>
                @endif
            </div>

            {{-- ── Body ── --}}
            <div class="cc__body">
                <h3 class="cc__title">{{ $course->title }}</h3>
                <p class="cc__desc">{{ strip_tags($course->description) ?: 'Explore structured lessons designed to build your skills step by step.' }}</p>

                <div class="cc__meta">
                    <div class="cc__meta-item">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                        <span>{{ $course->enrollments_count }} students</span>
                    </div>
                    <div class="cc__meta-dot"></div>
                    <div class="cc__meta-item">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <span>Self-paced</span>
                    </div>
                </div>
            </div>

            {{-- ── Footer CTA ── --}}
            <div class="cc__card-footer">
                @if($isEnrolled)
                    <a href="{{ route('test_taker.course.show', $course->id) }}" class="cc__btn cc__btn--continue">
                        Continue Learning
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('test_taker.course.show', $course->id) }}" class="cc__btn cc__btn--view">
                        View Course
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                        </svg>
                    </a>
                @endif
            </div>

        </div>
        @empty

        {{-- ── Empty State ── --}}
        <div class="cc__empty">
            <div class="cc__empty-icon">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#1A456C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                </svg>
            </div>
            <h3 class="cc__empty-title">No Courses Yet</h3>
            <p class="cc__empty-text">New courses are being prepared. Check back soon.</p>
        </div>

        @endforelse
    </div>

</div>

<style>
/* ─────────────────────────────────────────
   COURSE BROWSE PAGE
───────────────────────────────────────── */
.cc__page { width: 100%; }

/* Header */
.cc__header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 28px;
    flex-wrap: wrap;
}
.cc__breadcrumb {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 10px;
}
.cc__breadcrumb-root {
    font-size: 0.7rem;
    font-weight: 700;
    color: var(--secondary);
    text-transform: uppercase;
    letter-spacing: 0.08em;
}
.cc__breadcrumb-current {
    font-size: 0.7rem;
    font-weight: 700;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.08em;
}
.cc__page-title {
    font-size: 22px;
    font-weight: 800;
    color: var(--text);
    font-family: 'Poppins', sans-serif;
    margin: 0 0 4px;
    letter-spacing: -0.01em;
}
.cc__page-subtitle { font-size: 13px; color: var(--muted); margin: 0; }

/* Search */
.cc__search-wrap { position: relative; flex-shrink: 0; }
.cc__search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--muted);
    pointer-events: none;
}
.cc__search-input {
    padding: 9px 14px 9px 36px;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    font-size: 13px;
    background: white;
    color: var(--text);
    width: 220px;
    outline: none;
    font-family: inherit;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.cc__search-input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(26,69,108,0.07);
}

/* Filter row */
.cc__filter-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}
.cc__filter-tabs { display: flex; gap: 6px; flex-wrap: wrap; }
.cc__filter-tab {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 16px;
    border-radius: 99px;
    border: 1.5px solid var(--border);
    background: white;
    font-size: 12px;
    font-weight: 700;
    color: var(--muted);
    cursor: pointer;
    transition: all 0.2s;
    font-family: inherit;
}
.cc__filter-tab:hover { border-color: var(--primary); color: var(--primary); }
.cc__filter-tab--active { background: var(--primary); color: white; border-color: var(--primary); }
.cc__filter-tab--active .cc__filter-dot { box-shadow: 0 0 0 1.5px rgba(255,255,255,0.5); }
.cc__filter-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    flex-shrink: 0;
}
.cc__count { font-size: 12px; color: var(--muted); font-weight: 500; white-space: nowrap; }
.cc__count-num { font-weight: 800; color: var(--text); }

/* Grid */
.cc__grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(min(100%, 300px), 1fr));
    gap: 20px;
}

/* Card */
.cc__card {
    background: white;
    border-radius: 18px;
    border: 1.5px solid var(--border);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.25s cubic-bezier(0.4,0,0.2,1),
                box-shadow 0.25s cubic-bezier(0.4,0,0.2,1),
                border-color 0.25s;
}
.cc__card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 40px rgba(26,69,108,0.12);
    border-color: rgba(26,69,108,0.3);
}

/* Thumb */
.cc__thumb {
    position: relative;
    height: 156px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background: rgba(26,69,108,0.07);
    border-top: 3px solid #1A456C;
}
.cc__thumb-img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.cc__thumb-icon {
    width: 60px;
    height: 60px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    z-index: 1;
    background: #1A456C;
    box-shadow: 0 8px 24px rgba(26,69,108,0.25);
}

/* Decorative elements */
.cc__deco-ring {
    position: absolute;
    border-radius: 50%;
    opacity: 0.12;
    background: #1A456C;
}
.cc__deco-ring--lg {
    width: 130px; height: 130px;
    top: -40px; right: -40px;
}
.cc__deco-ring--sm {
    width: 80px; height: 80px;
    bottom: -28px; left: -28px;
    opacity: 0.07;
}
.cc__deco-grid {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,0.25) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.25) 1px, transparent 1px);
    background-size: 24px 24px;
}

/* Badges */
.cc__level-badge {
    position: absolute;
    top: 14px; left: 14px;
    padding: 4px 10px;
    border-radius: 99px;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: white;
    z-index: 2;
    background: #1A456C;
}
.cc__module-chip {
    position: absolute;
    bottom: 14px; right: 14px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 99px;
    font-size: 10px;
    font-weight: 700;
    color: #334155;
    background: rgba(255,255,255,0.88);
    backdrop-filter: blur(6px);
    border: 1px solid rgba(255,255,255,0.6);
    z-index: 2;
}
.cc__enrolled-chip {
    position: absolute;
    top: 14px; right: 14px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 99px;
    font-size: 10px;
    font-weight: 800;
    background: rgba(255,255,255,0.92);
    color: #0f172a;
    border: 1.5px solid rgba(255,255,255,0.7);
    backdrop-filter: blur(6px);
    z-index: 2;
}

/* Body */
.cc__body {
    padding: 18px 20px 14px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.cc__title {
    font-size: 14px;
    font-weight: 800;
    color: var(--text);
    line-height: 1.4;
    margin: 0 0 7px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.cc__desc {
    font-size: 12px;
    color: var(--muted);
    line-height: 1.65;
    margin: 0;
    flex: 1;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.cc__meta {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 14px;
    padding-top: 12px;
    border-top: 1px solid var(--border);
}
.cc__meta-item {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    color: var(--muted);
    font-weight: 500;
}
.cc__meta-dot {
    width: 3px; height: 3px;
    border-radius: 50%;
    background: var(--border);
    flex-shrink: 0;
}

/* Footer */
.cc__card-footer { padding: 0 20px 20px; }
.cc__btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 11px 16px;
    border-radius: 11px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    font-family: inherit;
    box-sizing: border-box;
}
.cc__btn--view { color: white; background: #1A456C; }
.cc__btn--view:hover { filter: brightness(1.1); transform: scale(1.015); }
.cc__btn--continue {
    background: var(--base);
    color: var(--primary);
    border: 1.5px solid var(--border);
}
.cc__btn--continue:hover { border-color: var(--primary); background: white; }

/* Empty state */
.cc__empty {
    grid-column: 1 / -1;
    padding: 64px 24px;
    text-align: center;
    background: white;
    border: 1.5px dashed var(--border);
    border-radius: 20px;
}
.cc__empty-icon {
    width: 60px; height: 60px;
    border-radius: 16px;
    background: rgba(26,69,108,0.06);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
}
.cc__empty-title { font-size: 16px; font-weight: 800; color: var(--text); margin: 0 0 6px; }
.cc__empty-text  { font-size: 13px; color: var(--muted); margin: 0; }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const cards      = Array.from(document.querySelectorAll('#course-grid .cc__card'));
    const filterTabs = document.querySelectorAll('.cc__filter-tab');
    const searchEl   = document.getElementById('course-search');
    const countEl    = document.getElementById('course-count');

    let activeFilter = 'all';
    let searchQuery  = '';

    function applyFilters() {
        let visible = 0;
        cards.forEach(card => {
            const level = (card.dataset.level || '').trim();
            const title = (card.dataset.title || '').trim();
            const matchFilter = activeFilter === 'all' || level === activeFilter;
            const matchSearch = title.includes(searchQuery);
            const show = matchFilter && matchSearch;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        if (countEl) countEl.textContent = visible;
    }

    filterTabs.forEach(tab => {
        tab.addEventListener('click', function () {
            filterTabs.forEach(t => t.classList.remove('cc__filter-tab--active'));
            this.classList.add('cc__filter-tab--active');
            activeFilter = this.dataset.filter;
            applyFilters();
        });
    });

    if (searchEl) {
        searchEl.addEventListener('input', function () {
            searchQuery = this.value.trim().toLowerCase();
            applyFilters();
        });
    }
});
</script>
@endpush

@endsection
