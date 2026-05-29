<?php

use App\Models\ExamAttempt;
use App\Models\Course;
use App\Enums\ExamAttemptStatus;
use Livewire\Component;
use Livewire\WithPagination;

return new class extends Component {
    use WithPagination;

    public $search = '';
    public $selectedCourse = '';

    public function rendering($view)
    {
        $view->layout('layouts.examiner');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCourse()
    {
        $this->resetPage();
    }

    public function with()
    {
        $query = ExamAttempt::with([
            'user',
            'exam.courseLessons.module.course',
        ])
            ->where('status', ExamAttemptStatus::FINISHED->value)
            ->where('examiner_id', auth()->id())
            ->whereHas('exam.courseLessons');

        if (!empty($this->search)) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->selectedCourse)) {
            $query->whereHas('exam.courseLessons.module.course', function ($q) {
                $q->where('id', $this->selectedCourse);
            });
        }

        return [
            'attempts' => $query->latest('submitted_at')->paginate(10),
            'courses' => Course::orderBy('title')->get(),
        ];
    }
};
?>

<div class="ec__page-wrapper">

    {{-- PAGE HEADER --}}
    <div class="ec__page-header">
        <div>
            <div class="ec__breadcrumb">
                <span class="ec__breadcrumb-root">Examiner</span>
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                    <path d="M4.5 3L7.5 6L4.5 9" stroke="#94a3b8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="ec__breadcrumb-current">Course Reviews</span>
            </div>

            <h1 class="ec__page-title">
                Course Review Queue
            </h1>

            <p class="ec__page-subtitle">
                Review completed course assignments and provide manual scores.
            </p>
        </div>

        {{-- Search --}}
        <div class="ec__search-wrap">
            <svg class="ec__search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/>
                <path d="m21 21-4.35-4.35"/>
            </svg>

            <input type="text"
                wire:model.live.debounce.500ms="search"
                class="page-search-input"
                placeholder="Search participant...">
        </div>
    </div>

    {{-- FILTER + COUNT ROW --}}
    <div class="ec__filter-row">
        <div class="ec__filter-tabs">
            <button type="button" class="filter-tab active-tab">
                All Course Reviews
            </button>
        </div>

        <div class="ec__filter-right">
            <span class="ec__count-text">
                <span class="ec__count-number">{{ $attempts->total() }}</span>
                submission{{ $attempts->total() !== 1 ? 's' : '' }} waiting
            </span>

            <select wire:model.live="selectedCourse"
                class="page-search-input"
                style="width: 220px; cursor: pointer;">
                <option value="">All Courses</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}">
                        {{ $course->title }}
                    </option>
                @endforeach
            </select>

            <div class="ec__view-toggle">
                <button type="button" class="view-toggle-btn active" id="btn-grid-view" title="Grid View" aria-label="Grid View">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <rect x="1" y="1" width="6" height="6" rx="1.5" fill="currentColor"/>
                        <rect x="9" y="1" width="6" height="6" rx="1.5" fill="currentColor"/>
                        <rect x="1" y="9" width="6" height="6" rx="1.5" fill="currentColor"/>
                        <rect x="9" y="9" width="6" height="6" rx="1.5" fill="currentColor"/>
                    </svg>
                </button>

                <button type="button" class="view-toggle-btn" id="btn-list-view" title="List View" aria-label="List View">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <rect x="1" y="2" width="14" height="2.5" rx="1.25" fill="currentColor"/>
                        <rect x="1" y="6.75" width="14" height="2.5" rx="1.25" fill="currentColor"/>
                        <rect x="1" y="11.5" width="14" height="2.5" rx="1.25" fill="currentColor"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- LOADING --}}
    <div wire:loading class="text-sm font-bold text-blue-700 mb-4">
        Loading review queue...
    </div>

    {{-- REVIEW LIST --}}
    <div class="ec__grid view-grid" id="course-grid-container">

        @forelse($attempts as $att)
            @php
                $courseTitle = $att->exam->courseLessons->first()?->module?->course?->title ?? 'Unknown Course';
                $lessonTitle = $att->exam->courseLessons->first()?->title ?? 'Unknown Lesson';

                $gradient = 'linear-gradient(135deg, #0d3b4f 0%, #1A456C 60%, #16637a 100%)';
            @endphp

            <div class="ec__card anim-in d{{ $loop->index % 5 + 1 }}"
                data-type="course"
                data-title="{{ strtolower(($courseTitle) . ' ' . ($att->user->name ?? '') . ' ' . ($att->user->email ?? '')) }}">

                {{-- Thumbnail --}}
                <div class="ec__thumb" style="background: {{ $gradient }};">
                    <div class="ec__thumb-circle-lg"></div>
                    <div class="ec__thumb-circle-sm"></div>
                    <div class="ec__thumb-dots"></div>
                    <div class="ec__thumb-line"></div>

                    <span class="ec__thumb-watermark" style="font-size: 3rem;">
                        COURSE
                    </span>

                    <span class="ec__thumb-badge-type">
                        Assignment
                    </span>

                    <span class="ec__thumb-badge-dur ec__thumb-badge-dur--active">
                        Pending
                    </span>
                </div>

                {{-- Body --}}
                <div class="ec__body">
                    <h3 class="ec__title">
                        {{ $courseTitle }}
                    </h3>

                    <p class="ec__desc" style="margin-bottom: 8px;">
                        <strong>Lesson:</strong> {{ $lessonTitle }}
                    </p>

                    <p class="ec__desc">
                        Submission from
                        <strong>{{ $att->user->name ?? 'User' }}</strong>
                        {{ $att->user->email ? '(' . $att->user->email . ')' : '' }}
                    </p>

                    <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 14px;">
                        <span style="font-size: .7rem; font-weight: 800; color: #64748b; background: #f8fafc; border: 1px solid #e2e8f0; padding: 7px 10px; border-radius: 999px;">
                            Submitted: {{ $att->submitted_at ? \Carbon\Carbon::parse($att->submitted_at)->format('d M Y, H:i') : '-' }}
                        </span>

                        <span style="font-size: .7rem; font-weight: 900; color: #1d4ed8; background: #dbeafe; padding: 7px 10px; border-radius: 999px;">
                            Auto Score: {{ number_format($att->converted_score ?? 0, 1) }}
                        </span>
                    </div>
                </div>

                {{-- Footer --}}
                <a href="{{ route('examiner.grading', ['attempt' => $att->id]) }}" class="ec__footer">
                    <span class="ec__footer-text">
                        Review Now
                    </span>

                    <span class="ec__footer-arrow">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"/>
                            <path d="m12 5 7 7-7 7"/>
                        </svg>
                    </span>
                </a>

            </div>
        @empty

            {{-- Empty State --}}
            <div class="ec__empty-state">
                <div class="ec__empty-icon">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none"
                        stroke="#1A456C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                </div>

                <h3 class="ec__empty-title">
                    No Reviews Available
                </h3>

                <p class="ec__empty-text">
                    There are no completed course assignments waiting for manual grading.
                </p>
            </div>

        @endforelse

    </div>

    {{-- PAGINATION --}}
    @if ($attempts->hasPages())
        <div class="mt-6">
            {{ $attempts->links() }}
        </div>
    @endif

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const gridBtn   = document.getElementById('btn-grid-view');
    const listBtn   = document.getElementById('btn-list-view');
    const container = document.getElementById('course-grid-container');

    function getCards() {
        return Array.from(document.querySelectorAll('#course-grid-container .ec__card'));
    }

    if (gridBtn && listBtn && container) {
        gridBtn.addEventListener('click', function () {
            gridBtn.classList.add('active');
            listBtn.classList.remove('active');
            container.classList.replace('view-list', 'view-grid');
            getCards().forEach(c => c.classList.remove('ec__card--list'));
        });

        listBtn.addEventListener('click', function () {
            listBtn.classList.add('active');
            gridBtn.classList.remove('active');
            container.classList.replace('view-grid', 'view-list');
            getCards().forEach(c => c.classList.add('ec__card--list'));
        });
    }
});
</script>
@endpush
