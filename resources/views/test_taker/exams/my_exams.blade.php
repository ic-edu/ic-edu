@extends('layouts.test_taker')
@section('title', 'My Exams')

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
                <span class="ec__breadcrumb-current">My Exams</span>
            </div>
            <h1 class="ec__page-title">My Exams</h1>
            <p class="ec__page-subtitle">Track your progress and continue your enrolled exam simulations.</p>
        </div>
    </div>

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
    <div class="me__alert me__alert--success">
        <x-lucide-check-circle style="width:15px;height:15px;flex-shrink:0;" />
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="me__alert me__alert--error">
        <x-lucide-alert-circle style="width:15px;height:15px;flex-shrink:0;" />
        {{ session('error') }}
    </div>
    @endif

    {{-- FILTER ROW --}}
    @php
        $cntNew     = $enrollments->filter(fn($e) => !$e->exam->attempts->first())->count();
        $cntOngoing = $enrollments->filter(fn($e) => $e->exam->attempts->first()?->status === 'ongoing')->count();
        $cntDone    = $enrollments->filter(fn($e) => in_array($e->exam->attempts->first()?->status, ['finished','graded']))->count();
    @endphp
    <div class="ec__filter-row">
        <div class="me__filter-chips">
            <span class="me__filter-chip me__filter-chip--new">
                <x-lucide-book-open style="width:11px;height:11px;" />
                {{ $cntNew }} Not Started
            </span>
            <span class="me__filter-chip me__filter-chip--ongoing">
                <x-lucide-play-circle style="width:11px;height:11px;" />
                {{ $cntOngoing }} In Progress
            </span>
            <span class="me__filter-chip me__filter-chip--done">
                <x-lucide-check-circle style="width:11px;height:11px;" />
                {{ $cntDone }} Completed
            </span>
        </div>
        <span class="ec__count-text">
            <span class="ec__count-number">{{ $enrollments->count() }}</span>
            exam{{ $enrollments->count() !== 1 ? 's' : '' }} enrolled
        </span>
    </div>

    {{-- CARDS GRID --}}
    <div class="ec__grid">
        @forelse($enrollments as $enrollment)
        @php
            $exam          = $enrollment->exam;
            $latestAttempt = $exam->attempts->first();
            $attemptStatus = $latestAttempt?->status ?? null;

            $gradients = [
                'TOEIC' => 'linear-gradient(135deg, #0f3460 0%, #1A456C 60%, #16637a 100%)',
                'IELTS' => 'linear-gradient(135deg, #1a3a5c 0%, #1e4d6b 60%, #1a5276 100%)',
                'TOEFL' => 'linear-gradient(135deg, #0d3b4f 0%, #1A456C 60%, #117a65 100%)',
            ];
            $typeName = $exam->examType->name ?? 'Exam';
            $grad = $gradients[$typeName] ?? 'linear-gradient(135deg, #1A456C 0%, #2c6b8a 100%)';

            $statusMap = [
                null       => ['label' => 'Not Started',    'cls' => 'me__sbadge--new'],
                'ongoing'  => ['label' => 'In Progress',    'cls' => 'me__sbadge--ongoing'],
                'finished' => ['label' => 'Pending Review', 'cls' => 'me__sbadge--pending'],
                'graded'   => ['label' => 'Graded',         'cls' => 'me__sbadge--graded'],
            ];
            $status = $statusMap[$attemptStatus] ?? $statusMap[null];

            $enrolledDate = $enrollment->enrolled_at
                ? $enrollment->enrolled_at->format('d M Y')
                : $enrollment->created_at->format('d M Y');

            // Smart "Details" link — result page when graded, exam detail otherwise
            $detailsUrl = ($attemptStatus === 'graded' && $latestAttempt)
                ? route('test_taker.exam.result', $latestAttempt->id)
                : route('test_taker.exam.detail', $exam->id);
        @endphp

        <div class="ec__card anim-in d{{ ($loop->index % 5) + 1 }}">

            {{-- THUMB --}}
            <div class="ec__thumb" style="background: {{ $grad }};">
                <div class="ec__thumb-circle-lg"></div>
                <div class="ec__thumb-circle-sm"></div>
                <div class="ec__thumb-dots"></div>
                <div class="ec__thumb-line"></div>
                <span class="ec__thumb-watermark">{{ $typeName }}</span>
                <span class="ec__thumb-badge-type">{{ $typeName }}</span>
                <span class="me__sbadge {{ $status['cls'] }}">{{ $status['label'] }}</span>
            </div>

            {{-- BODY --}}
            <div class="ec__body">
                <h3 class="ec__title">{{ $exam->title }}</h3>
                <p class="ec__desc">
                    {{ $exam->description ? Str::limit(strip_tags($exam->description), 90) : 'A comprehensive exam simulation to test your skills and readiness.' }}
                </p>

                <div class="me__meta-row">
                    <span class="me__meta-pill">
                        <x-lucide-calendar style="width:10px;height:10px;" />
                        {{ $enrolledDate }}
                    </span>
                    <span class="me__meta-pill">
                        <x-lucide-clock style="width:10px;height:10px;" />
                        {{ $exam->total_duration ?? 120 }} min
                    </span>
                    @if($attemptStatus === 'graded' && $latestAttempt?->converted_score)
                    <span class="me__meta-pill me__meta-pill--score">
                        Score {{ number_format($latestAttempt->converted_score, 1) }}
                    </span>
                    @endif
                </div>
            </div>

            {{-- FOOTER ACTION --}}
            <div class="me__footer-action">
                @if($attemptStatus === 'finished')
                    <span class="me__action-label me__action-label--pending">
                        <x-lucide-clock-4 style="width:13px;height:13px;" />
                        Pending Review
                    </span>
                @elseif($attemptStatus === 'graded')
                    <span class="me__action-label me__action-label--graded">
                        <x-lucide-star style="width:13px;height:13px;" />
                        Graded
                    </span>
                @elseif($attemptStatus === 'ongoing')
                    <form action="{{ route('test_taker.exam.start', $exam->id) }}" method="POST" style="display:contents;">
                        @csrf
                        <button type="submit" class="me__action-btn me__action-btn--resume">
                            <x-lucide-play style="width:13px;height:13px;" />
                            Resume Exam
                        </button>
                    </form>
                @else
                    <form action="{{ route('test_taker.exam.start', $exam->id) }}" method="POST" style="display:contents;">
                        @csrf
                        <button type="submit" class="me__action-btn me__action-btn--start">
                            <x-lucide-play style="width:13px;height:13px;" />
                            Start Exam
                        </button>
                    </form>
                @endif

                <a href="{{ $detailsUrl }}" class="ec__footer-arrow">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                    </svg>
                </a>
            </div>

        </div>
        @empty

        {{-- EMPTY STATE --}}
        <div class="ec__empty-state">
            <div class="ec__empty-icon">
                <x-lucide-clipboard-list style="width:36px;height:36px;color:#1A456C;opacity:0.7;" />
            </div>
            <h3 class="ec__empty-title">No enrolled exams yet</h3>
            <p class="ec__empty-text">Browse available exam simulations and enroll to start practicing.</p>
            <a href="{{ route('test_taker.exam.index') }}" class="me__empty-btn">
                Browse Exams
                <x-lucide-arrow-right style="width:14px;height:14px;" />
            </a>
        </div>

        @endforelse
    </div>

</div>
@endsection
