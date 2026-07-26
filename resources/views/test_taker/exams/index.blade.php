@extends('layouts.test_taker')
@section('title', 'Browse Exams')

@section('content')
<div class="ec__page-wrapper">

    {{-- PAGE HEADER --}}
    <div class="ec__page-header">
        <div>
            <div class="ec__breadcrumb">
                <span class="ec__breadcrumb-root">Portal</span>
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                    <path d="M4.5 3L7.5 6L4.5 9" stroke="#94a3b8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="ec__breadcrumb-current">Browse Exams</span>
            </div>
            <h1 class="ec__page-title">Browse Exams</h1>
            <p class="ec__page-subtitle">Discover and enroll in available simulation exams and tryouts.</p>
        </div>

        {{-- Search --}}
        <div class="ec__search-wrap">
            <svg class="ec__search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="text" class="page-search-input" placeholder="Search exams...">
        </div>
    </div>

    {{-- FILTER + COUNT ROW --}}
    <div class="ec__filter-row">
        <div class="ec__filter-tabs">
            <button class="filter-tab active-tab">All Exams</button>
            <button class="filter-tab">IELTS</button>
            <button class="filter-tab">TOEIC</button>
            <button class="filter-tab">TOEFL</button>
            <button class="filter-tab">Latest</button>
        </div>
        <div class="ec__filter-right">
            <span class="ec__count-text">
                <span class="ec__count-number">{{ count($exams) }}</span> exam{{ count($exams) !== 1 ? 's' : '' }} available
            </span>
            <div class="ec__view-toggle">
                <button class="view-toggle-btn active" id="btn-grid-view" title="Grid View" aria-label="Grid View">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="1" y="1" width="6" height="6" rx="1.5" fill="currentColor"/>
                        <rect x="9" y="1" width="6" height="6" rx="1.5" fill="currentColor"/>
                        <rect x="1" y="9" width="6" height="6" rx="1.5" fill="currentColor"/>
                        <rect x="9" y="9" width="6" height="6" rx="1.5" fill="currentColor"/>
                    </svg>
                </button>
                <button class="view-toggle-btn" id="btn-list-view" title="List View" aria-label="List View">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="1" y="2" width="14" height="2.5" rx="1.25" fill="currentColor"/>
                        <rect x="1" y="6.75" width="14" height="2.5" rx="1.25" fill="currentColor"/>
                        <rect x="1" y="11.5" width="14" height="2.5" rx="1.25" fill="currentColor"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- EXAMS GRID --}}
    <div class="ec__grid view-grid" id="exam-grid-container">
        @forelse($exams as $exam)
        @php
            $typeName = $exam->examType->name ?? 'Exam';

            $gradients = [
                'TOEIC' => 'linear-gradient(135deg, #0f3460 0%, #1A456C 60%, #16637a 100%)',
                'IELTS' => 'linear-gradient(135deg, #064e3b 0%, #065f46 60%, #047857 100%)',
                'TOEFL' => 'linear-gradient(135deg, #450a0a 0%, #7f1d1d 60%, #991b1b 100%)',
            ];
            $gradient = $gradients[$typeName] ?? 'linear-gradient(135deg, #1A456C 0%, #2c6b8a 100%)';

            $isActive = ($exam->status ?? 'active') === 'active';
        @endphp

        <div class="ec__card anim-in d{{ $loop->index % 5 + 1 }}"
             data-type="{{ strtolower($typeName) }}"
             data-title="{{ strtolower($exam->title) }}">

            {{-- Thumbnail (background gradient is dynamic, inline required) --}}
            <div class="ec__thumb" style="background: {{ $gradient }};">
                <div class="ec__thumb-circle-lg"></div>
                <div class="ec__thumb-circle-sm"></div>
                <div class="ec__thumb-dots"></div>
                <div class="ec__thumb-line"></div>
                <span class="ec__thumb-watermark">{{ $typeName }}</span>
                <span class="ec__thumb-badge-type">{{ $typeName }}</span>
                @if($isActive)
                    <span class="ec__thumb-badge-dur ec__thumb-badge-dur--active">Active</span>
                @else
                    <span class="ec__thumb-badge-dur ec__thumb-badge-dur--inactive">Inactive</span>
                @endif
            </div>

            {{-- Body --}}
            <div class="ec__body">
                <h3 class="ec__title">{{ $exam->title }}</h3>
                <p class="ec__desc">{{ $exam->description ?? 'A comprehensive simulation exam to test your skills and readiness.' }}</p>
            </div>

            {{-- Footer --}}
            <a href="{{ route('test_taker.exam.detail', $exam->id) }}" class="ec__footer">
                <span class="ec__footer-text">View Details</span>
                <span class="ec__footer-arrow">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                    </svg>
                </span>
            </a>

        </div>
        @empty

        {{-- Empty State --}}
        <div class="ec__empty-state">
            <div class="ec__empty-icon">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#1A456C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
            </div>
            <h3 class="ec__empty-title">No Exams Available</h3>
            <p class="ec__empty-text">Check back later or contact your administrator when new exams are published.</p>
        </div>

        @endforelse
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const cards        = Array.from(document.querySelectorAll('#exam-grid-container .ec__card'));
    const filterTabs   = document.querySelectorAll('.filter-tab');
    const searchInput  = document.querySelector('.page-search-input');
    const gridBtn      = document.getElementById('btn-grid-view');
    const listBtn      = document.getElementById('btn-list-view');
    const container    = document.getElementById('exam-grid-container');
    const countEl      = document.querySelector('.ec__count-number');

    let activeFilter = 'all';
    let searchQuery  = '';

    /* ── apply both search + filter together ── */
    function applyFilters() {
        let visible = 0;
        cards.forEach(card => {
            const type  = (card.dataset.type  || '').trim();
            const title = (card.dataset.title || '').trim();
            const matchFilter = activeFilter === 'all' || type === activeFilter;
            const matchSearch = title.includes(searchQuery);
            const show = matchFilter && matchSearch;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        if (countEl) countEl.textContent = visible;
    }

    /* ── filter tabs ── */
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function () {
            filterTabs.forEach(t => t.classList.remove('active-tab'));
            this.classList.add('active-tab');
            const label = this.textContent.trim().toLowerCase();
            activeFilter = (label === 'all exams' || label === 'latest') ? 'all' : label;
            applyFilters();
        });
    });

    /* ── search ── */
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            searchQuery = this.value.trim().toLowerCase();
            applyFilters();
        });
    }

    /* ── view toggle ── */
    if (gridBtn && listBtn && container) {
        gridBtn.addEventListener('click', function () {
            gridBtn.classList.add('active');
            listBtn.classList.remove('active');
            container.classList.replace('view-list', 'view-grid');
            cards.forEach(c => c.classList.remove('ec__card--list'));
        });

        listBtn.addEventListener('click', function () {
            listBtn.classList.add('active');
            gridBtn.classList.remove('active');
            container.classList.replace('view-grid', 'view-list');
            cards.forEach(c => c.classList.add('ec__card--list'));
        });
    }
});
</script>
@endpush
