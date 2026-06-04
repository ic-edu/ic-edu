<?php

use App\Models\ExamAttempt;
use App\Models\Exam;
use App\Enums\ExamAttemptStatus;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $search = '';
    public $selectedExam = '';
    public $selectedType = '';

    public function rendering($view)
    {
        $view->layout('layouts.examiner');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedExam()
    {
        $this->resetPage();
    }

    public function updatingSelectedType()
    {
        $this->resetPage();
    }

    public function filterType($type = '')
    {
        $this->selectedType = $type;
        $this->resetPage();
    }

    public function with()
    {
        $query = ExamAttempt::with([
            'user',
            'exam.examType',
        ])
            ->where('status', ExamAttemptStatus::FINISHED->value)
            ->whereDoesntHave('exam.courseLessons');

        if (!empty($this->search)) {
            $query->where(function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                    ->orWhereHas('exam', function ($q) {
                        $q->where('title', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if (!empty($this->selectedExam)) {
            $query->where('exam_id', $this->selectedExam);
        }

        if (!empty($this->selectedType)) {
            $query->whereHas('exam.examType', function ($q) {
                $q->whereRaw('LOWER(name) = ?', [strtolower($this->selectedType)]);
            });
        }

        return [
            'attempts' => $query->latest('submitted_at')->paginate(10),
            'exams' => Exam::with('examType')->orderBy('title')->get(),
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
                    <path d="M4.5 3L7.5 6L4.5 9" stroke="#94a3b8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="ec__breadcrumb-current">Exam Reviews</span>
            </div>

            <h1 class="ec__page-title">
                Exam Review Queue
            </h1>

            <p class="ec__page-subtitle">
                Review completed exam submissions and provide manual scores for speaking or writing answers.
            </p>
        </div>

        {{-- Search --}}
        <div class="ec__search-wrap">
            <svg class="ec__search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.35-4.35" />
            </svg>

            <input type="text"
                wire:model.live.debounce.500ms="search"
                class="page-search-input"
                placeholder="Search participant or exam...">
        </div>
    </div>

    {{-- FILTER + COUNT ROW --}}
    <div class="ec__filter-row">
        <div class="ec__filter-tabs">

            <button type="button"
                wire:click="filterType('')"
                class="filter-tab {{ empty($selectedType) ? 'active-tab' : '' }}">
                All Reviews
            </button>

            <button type="button"
                wire:click="filterType('ielts')"
                class="filter-tab {{ $selectedType === 'ielts' ? 'active-tab' : '' }}">
                IELTS
            </button>

            <button type="button"
                wire:click="filterType('toeic')"
                class="filter-tab {{ $selectedType === 'toeic' ? 'active-tab' : '' }}">
                TOEIC
            </button>

            <button type="button"
                wire:click="filterType('toefl')"
                class="filter-tab {{ $selectedType === 'toefl' ? 'active-tab' : '' }}">
                TOEFL
            </button>

            <button type="button"
                wire:click="$set('selectedExam', '')"
                class="filter-tab">
                Latest
            </button>

        </div>

        <div class="ec__filter-right">
            <span class="ec__count-text">
                <span class="ec__count-number">{{ $attempts->total() }}</span>
                submission{{ $attempts->total() !== 1 ? 's' : '' }} waiting
            </span>

            <select wire:model.live="selectedExam"
                class="page-search-input"
                style="width: 220px; cursor: pointer;">
                <option value="">All Exams</option>
                @foreach ($exams as $exam)
                <option value="{{ $exam->id }}">
                    {{ $exam->title }}
                </option>
                @endforeach
            </select>

            <div class="ec__view-toggle">
                <button type="button" class="view-toggle-btn active" id="btn-grid-view" title="Grid View" aria-label="Grid View">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <rect x="1" y="1" width="6" height="6" rx="1.5" fill="currentColor" />
                        <rect x="9" y="1" width="6" height="6" rx="1.5" fill="currentColor" />
                        <rect x="1" y="9" width="6" height="6" rx="1.5" fill="currentColor" />
                        <rect x="9" y="9" width="6" height="6" rx="1.5" fill="currentColor" />
                    </svg>
                </button>

                <button type="button" class="view-toggle-btn" id="btn-list-view" title="List View" aria-label="List View">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <rect x="1" y="2" width="14" height="2.5" rx="1.25" fill="currentColor" />
                        <rect x="1" y="6.75" width="14" height="2.5" rx="1.25" fill="currentColor" />
                        <rect x="1" y="11.5" width="14" height="2.5" rx="1.25" fill="currentColor" />
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
    <div class="ec__grid view-grid" id="exam-grid-container">

        @forelse($attempts as $att)
        @php
        $exam = $att->exam;
        $typeName = $exam?->examType?->name ?? 'Exam';

        $gradients = [
        'TOEIC' => 'linear-gradient(135deg, #0f3460 0%, #1A456C 60%, #16637a 100%)',
        'IELTS' => 'linear-gradient(135deg, #1a3a5c 0%, #1e4d6b 60%, #1a5276 100%)',
        'TOEFL' => 'linear-gradient(135deg, #0d3b4f 0%, #1A456C 60%, #117a65 100%)',
        ];

        $gradient = $gradients[$typeName] ?? 'linear-gradient(135deg, #1A456C 0%, #2c6b8a 100%)';
        @endphp

        {{-- MOBILE LIST ITEM --}}
        <a href="{{ route('examiner.grading', $att->id) }}"
            class="sm:hidden block rounded-2xl border border-slate-200 bg-white p-4 mb-3 shadow-sm active:scale-[0.99] transition">

            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0 flex-1">

                    <span class="inline-flex mb-2 rounded-full bg-blue-50 px-3 py-1 text-[0.65rem] font-black uppercase tracking-wide text-[#1A456C]">
                        {{ $typeName }}
                    </span>

                    <h3 class="text-sm font-black leading-5 text-slate-900">
                        {{ $exam->title ?? 'Ujian Dihapus' }}
                    </h3>

                    <p class="mt-1 text-xs leading-5 text-slate-500">
                        Submission from
                        <strong class="text-slate-700">
                            {{ $att->user->name ?? 'User Tidak Diketahui' }}
                        </strong>
                    </p>

                    @if($att->user?->email)
                    <p class="text-[0.7rem] leading-4 text-slate-400 break-all">
                        {{ $att->user->email }}
                    </p>
                    @endif

                    <div class="mt-3 flex flex-wrap gap-2">
                        <span class="rounded-full bg-slate-50 border border-slate-200 px-2.5 py-1 text-[0.65rem] font-bold text-slate-500">
                            {{ $att->submitted_at ? \Carbon\Carbon::parse($att->submitted_at)->format('d M Y, H:i') : '-' }}
                        </span>

                        <span class="rounded-full bg-blue-50 px-2.5 py-1 text-[0.65rem] font-black text-blue-700">
                            Score: {{ number_format($att->converted_score ?? 0, 1) }}
                        </span>
                    </div>
                </div>

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-blue-50 text-[#1A456C] font-black">
                    →
                </div>
            </div>
        </a>

        {{-- DESKTOP CARD --}}
        <div class="ec__card hidden sm:flex anim-in d{{ $loop->index % 5 + 1 }} cursor-pointer"
            onclick="window.location.href='{{ route('examiner.grading', $att->id) }}'"
            role="link"
            tabindex="0"
            onkeydown="if(event.key === 'Enter') window.location.href='{{ route('examiner.grading', $att->id) }}'"
            data-type="{{ strtolower($typeName) }}"
            data-title="{{ strtolower(($exam->title ?? '') . ' ' . ($att->user->name ?? '') . ' ' . ($att->user->email ?? '')) }}">

            {{-- Thumbnail --}}
            <div class="ec__thumb" style="background: {{ $gradient }};">
                <div class="ec__thumb-circle-lg"></div>
                <div class="ec__thumb-circle-sm"></div>
                <div class="ec__thumb-dots"></div>
                <div class="ec__thumb-line"></div>

                <span class="ec__thumb-watermark">
                    {{ $typeName }}
                </span>

                <span class="ec__thumb-badge-type">
                    {{ $typeName }}
                </span>

                <span class="ec__thumb-badge-dur ec__thumb-badge-dur--active">
                    Pending
                </span>
            </div>

            {{-- Body --}}
            <div class="ec__body">
                <h3 class="ec__title">
                    {{ $exam->title ?? 'Ujian Dihapus' }}
                </h3>

                <p class="ec__desc">
                    Submission from
                    <strong>{{ $att->user->name ?? 'User Tidak Diketahui' }}</strong>
                    {{ $att->user->email ? '(' . $att->user->email . ')' : '' }}
                </p>

                <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 14px;">
                    <span style="font-size: .7rem; font-weight: 800; color: #64748b; background: #f8fafc; border: 1px solid #e2e8f0; padding: 7px 10px; border-radius: 999px;">
                        Submitted: {{ $att->submitted_at ? \Carbon\Carbon::parse($att->submitted_at)->format('d M Y, H:i') : '-' }} WIB
                    </span>

                    <span style="font-size: .7rem; font-weight: 900; color: #1d4ed8; background: #dbeafe; padding: 7px 10px; border-radius: 999px;">
                        Auto Score: {{ number_format($att->converted_score ?? 0, 1) }}
                    </span>

                    <span style="font-size: .7rem; font-weight: 800; color: #64748b; background: #f8fafc; border: 1px solid #e2e8f0; padding: 7px 10px; border-radius: 999px;">
                        ID: {{ substr($att->id, 0, 8) }}...
                    </span>
                </div>
            </div>

            {{-- Footer --}}
            <a href="{{ route('examiner.grading', ['attempt' => $att->id]) }}"
                class="ec__footer"
                onclick="event.stopPropagation();">

                <span class="ec__footer-text">
                    Review Now
                </span>

                <span class="ec__footer-arrow">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14" />
                        <path d="m12 5 7 7-7 7" />
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
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                    <line x1="16" y1="13" x2="8" y2="13" />
                    <line x1="16" y1="17" x2="8" y2="17" />
                </svg>
            </div>

            <h3 class="ec__empty-title">
                No Reviews Available
            </h3>

            <p class="ec__empty-text">
                There are no completed exam submissions waiting for manual grading.
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
    document.addEventListener('DOMContentLoaded', function() {
        const gridBtn = document.getElementById('btn-grid-view');
        const listBtn = document.getElementById('btn-list-view');
        const container = document.getElementById('exam-grid-container');

        function getCards() {
            return Array.from(document.querySelectorAll('#exam-grid-container .ec__card'));
        }

        if (gridBtn && listBtn && container) {
            gridBtn.addEventListener('click', function() {
                gridBtn.classList.add('active');
                listBtn.classList.remove('active');
                container.classList.replace('view-list', 'view-grid');
                getCards().forEach(c => c.classList.remove('ec__card--list'));
            });

            listBtn.addEventListener('click', function() {
                listBtn.classList.add('active');
                gridBtn.classList.remove('active');
                container.classList.replace('view-grid', 'view-list');
                getCards().forEach(c => c.classList.add('ec__card--list'));
            });
        }
    });
</script>
@endpush

<style>
    @media (max-width: 640px) {
        .ec__page-wrapper {
            padding: 1rem !important;
            border-radius: 1.5rem !important;
            margin: 1rem !important;
            margin-bottom: 6rem !important;
            width: auto !important;
            max-width: calc(100vw - 2rem) !important;
            overflow: hidden !important;
        }

        .ec__page-header {
            display: flex !important;
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 1rem !important;
            margin-bottom: 1.25rem !important;
        }

        .ec__breadcrumb {
            font-size: 0.65rem !important;
            letter-spacing: 0.12em !important;
            margin-bottom: 0.5rem !important;
        }

        .ec__page-title {
            font-size: 1.55rem !important;
            line-height: 1.9rem !important;
            margin-bottom: 0.4rem !important;
        }

        .ec__page-subtitle {
            font-size: 0.82rem !important;
            line-height: 1.4rem !important;
        }

        .ec__search-wrap {
            width: 100% !important;
            max-width: 100% !important;
        }

        .ec__search-wrap .page-search-input {
            width: 100% !important;
            height: 44px !important;
            font-size: 0.82rem !important;
            border-radius: 1rem !important;
        }

        .ec__filter-row {
            display: flex !important;
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 1rem !important;
            margin-bottom: 1.25rem !important;
            padding-bottom: 1rem !important;
            border-bottom: 1px solid #e5edf5 !important;
        }

        .ec__filter-tabs {
            display: flex !important;
            gap: 0.5rem !important;
            overflow-x: auto !important;
            padding-bottom: 0.25rem !important;
            scrollbar-width: none !important;
        }

        .ec__filter-tabs::-webkit-scrollbar {
            display: none !important;
        }

        .filter-tab {
            flex: 0 0 auto !important;
            height: 38px !important;
            padding: 0 1rem !important;
            border-radius: 999px !important;
            font-size: 0.76rem !important;
            white-space: nowrap !important;
        }

        .ec__filter-right {
            display: grid !important;
            grid-template-columns: 1fr !important;
            gap: 0.75rem !important;
        }

        .ec__count-text {
            font-size: 0.78rem !important;
            line-height: 1.2rem !important;
        }

        .ec__filter-right select.page-search-input {
            width: 100% !important;
            height: 44px !important;
            border-radius: 1rem !important;
            font-size: 0.82rem !important;
        }

        .ec__view-toggle {
            display: none !important;
        }

        .ec__grid {
            display: flex !important;
            flex-direction: column !important;
            gap: 0.75rem !important;
        }

        /* MOBILE LIST MODE */
        .ec__page-wrapper {
            padding: 1rem !important;
            border-radius: 1.5rem !important;
            margin: 1rem !important;
            margin-bottom: 6rem !important;
            width: auto !important;
            max-width: calc(100vw - 2rem) !important;
            overflow: hidden !important;
        }

        .ec__page-header {
            display: flex !important;
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 1rem !important;
            margin-bottom: 1.25rem !important;
        }

        .ec__breadcrumb {
            font-size: 0.65rem !important;
            letter-spacing: 0.12em !important;
            margin-bottom: 0.5rem !important;
        }

        .ec__page-title {
            font-size: 1.5rem !important;
            line-height: 1.85rem !important;
            margin-bottom: 0.4rem !important;
        }

        .ec__page-subtitle {
            font-size: 0.82rem !important;
            line-height: 1.45rem !important;
        }

        .ec__search-wrap {
            width: 100% !important;
        }

        .ec__search-wrap .page-search-input {
            width: 100% !important;
            height: 44px !important;
            border-radius: 1rem !important;
            font-size: 0.82rem !important;
        }

        .ec__filter-row {
            display: flex !important;
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 1rem !important;
            margin-bottom: 1.25rem !important;
            padding-bottom: 1rem !important;
            border-bottom: 1px solid #e5edf5 !important;
        }

        .ec__filter-tabs {
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 0.5rem !important;
        }

        .filter-tab {
            height: 36px !important;
            padding: 0 0.95rem !important;
            border-radius: 999px !important;
            font-size: 0.74rem !important;
            white-space: nowrap !important;
        }

        .ec__filter-right {
            display: flex !important;
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 0.75rem !important;
        }

        .ec__count-text {
            font-size: 0.78rem !important;
            line-height: 1.25rem !important;
        }

        .ec__filter-right select.page-search-input {
            width: 100% !important;
            height: 44px !important;
            border-radius: 1rem !important;
            font-size: 0.82rem !important;
        }

        .ec__view-toggle {
            display: none !important;
        }

        .ec__grid {
            display: flex !important;
            flex-direction: column !important;
            gap: 0.8rem !important;
        }

        /* compact list card */
        .ec__card {
            width: 100% !important;
            max-width: 100% !important;
            min-height: auto !important;
            display: block !important;
            position: relative !important;
            padding: 1rem !important;
            border-radius: 1.25rem !important;
            background: #ffffff !important;
            border: 1px solid #e5edf5 !important;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06) !important;
            overflow: hidden !important;
            cursor: pointer !important;
        }

        /* hide big thumbnail on mobile */
        .ec__thumb {
            display: none !important;
        }

        .ec__thumb-watermark,
        .ec__thumb-badge-dur {
            display: none !important;
        }

        /* if type badge is inside thumbnail, keep it hidden too */
        .ec__thumb-badge-type {
            display: none !important;
        }

        .ec__card-body,
        .ec__card-content,
        .ec__content {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            padding: 0 !important;
        }

        /* add exam type badge via existing data-type */
        .ec__card::before {
            content: attr(data-type);
            display: inline-flex;
            width: fit-content;
            margin-bottom: 0.65rem;
            padding: 0.35rem 0.7rem;
            border-radius: 999px;
            background: #eef6ff;
            color: #1A456C;
            font-size: 0.65rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .ec__card-title,
        .ec__title {
            font-size: 0.98rem !important;
            line-height: 1.3rem !important;
            margin-bottom: 0.35rem !important;
            color: #0f172a !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
        }

        .ec__card-subtitle,
        .ec__subtitle,
        .ec__meta-text {
            font-size: 0.78rem !important;
            line-height: 1.3rem !important;
            color: #64748b !important;
            margin-bottom: 0.75rem !important;
            word-break: break-word !important;
        }

        .ec__meta,
        .ec__badges,
        .ec__info-row {
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 0.45rem !important;
            margin-top: 0.65rem !important;
            max-width: 100% !important;
        }

        .ec__meta span,
        .ec__badges span,
        .ec__info-row span {
            font-size: 0.66rem !important;
            line-height: 1rem !important;
            padding: 0.35rem 0.6rem !important;
            border-radius: 999px !important;
            max-width: 100% !important;
            white-space: normal !important;
        }

        .ec__action-row,
        .ec__card-footer {
            margin-top: 0.85rem !important;
            padding-top: 0.8rem !important;
            border-top: 1px solid #eef2f7 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 0.75rem !important;
        }

        .ec__card-action,
        .ec__review-link {
            font-size: 0.78rem !important;
            font-weight: 900 !important;
            color: #1A456C !important;
        }

        .ec__arrow,
        .ec__card-arrow {
            width: 2rem !important;
            height: 2rem !important;
            min-width: 2rem !important;
            border-radius: 999px !important;
        }

        nav[role="navigation"] {
            margin-bottom: 5rem !important;
        }

        pagination,
        nav[role="navigation"] {
            margin-bottom: 5rem !important;
        }

        @media (max-width: 640px) {
        .ec__card.hidden,
        .ec__card.hidden.sm\:flex {
            display: none !important;
        }
    }
    }
</style>