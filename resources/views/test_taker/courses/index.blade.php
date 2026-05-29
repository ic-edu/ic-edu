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
        <x-course-card 
            :course="$course" 
            :isEnrolled="in_array($course->id, $enrolledCourseIds)" 
            :index="$loop->index" 
        />
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

/* Card styles are now handled by course-card component */

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
