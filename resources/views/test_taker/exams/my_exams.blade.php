@extends('layouts.test_taker')
@section('title', 'My Exams')

@section('content')
<div class="me__page-wrapper">

    {{-- PAGE HEADER --}}
    <div class="me__page-header anim-in d1">
        <div>
            <h1 class="me__page-title">My Exams</h1>
            <p class="me__page-subtitle">Track your progress across all enrolled exam simulations.</p>
        </div>
        @if($enrollments->count() > 0)
        <div class="me__header-badge">
            <span class="me__header-badge-num">{{ $enrollments->count() }}</span>
            <span class="me__header-badge-label">Enrolled</span>
        </div>
        @endif
    </div>

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
    <div class="me__alert me__alert--success anim-in d1">
        <x-lucide-check-circle style="width:16px;height:16px;flex-shrink:0;" />
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="me__alert me__alert--error anim-in d1">
        <x-lucide-alert-circle style="width:16px;height:16px;flex-shrink:0;" />
        {{ session('error') }}
    </div>
    @endif

    {{-- STATS BAR --}}
    @if($enrollments->count() > 0)
    @php
        $cntNew     = $enrollments->filter(fn($e) => !$e->exam->attempts->first())->count();
        $cntOngoing = $enrollments->filter(fn($e) => $e->exam->attempts->first()?->status === 'ongoing')->count();
        $cntDone    = $enrollments->filter(fn($e) => in_array($e->exam->attempts->first()?->status, ['finished','graded']))->count();
    @endphp
    <div class="me__stats-bar anim-in d2">
        <div class="me__stat-chip">
            <div class="me__stat-chip-icon me__stat-chip-icon--new">
                <x-lucide-book-open style="width:14px;height:14px;" />
            </div>
            <div>
                <span class="me__stat-chip-num">{{ $cntNew }}</span>
                <span class="me__stat-chip-label">Not Started</span>
            </div>
        </div>
        <div class="me__stat-divider"></div>
        <div class="me__stat-chip">
            <div class="me__stat-chip-icon me__stat-chip-icon--ongoing">
                <x-lucide-play-circle style="width:14px;height:14px;" />
            </div>
            <div>
                <span class="me__stat-chip-num">{{ $cntOngoing }}</span>
                <span class="me__stat-chip-label">In Progress</span>
            </div>
        </div>
        <div class="me__stat-divider"></div>
        <div class="me__stat-chip">
            <div class="me__stat-chip-icon me__stat-chip-icon--done">
                <x-lucide-check-circle style="width:14px;height:14px;" />
            </div>
            <div>
                <span class="me__stat-chip-num">{{ $cntDone }}</span>
                <span class="me__stat-chip-label">Completed</span>
            </div>
        </div>
    </div>
    @endif

    {{-- EXAMS GRID --}}
    <div class="me__grid">
        @forelse($enrollments as $enrollment)
        @php
            $exam          = $enrollment->exam;
            $latestAttempt = $exam->attempts->first();

            $gradients = [
                'linear-gradient(135deg, #1A456C 0%, #1e5a8a 50%, #6FAFB5 100%)',
                'linear-gradient(135deg, #0f3460 0%, #1A456C 60%, #2c7a8a 100%)',
                'linear-gradient(135deg, #162d4a 0%, #1A456C 50%, #4f969b 100%)',
            ];
            $grad = $gradients[$exam->id % count($gradients)];

            $attemptStatus = $latestAttempt?->status ?? null;
            $statusMap = [
                null       => ['label' => 'Not Started',    'cls' => 'me__status--new'],
                'ongoing'  => ['label' => 'In Progress',    'cls' => 'me__status--ongoing'],
                'finished' => ['label' => 'Pending Review', 'cls' => 'me__status--pending'],
                'graded'   => ['label' => 'Graded',         'cls' => 'me__status--graded'],
            ];
            $status = $statusMap[$attemptStatus] ?? $statusMap[null];
            $enrolledDate = $enrollment->enrolled_at
                ? $enrollment->enrolled_at->format('d M Y')
                : $enrollment->created_at->format('d M Y');
        @endphp
        <div class="me__card anim-in d{{ ($loop->index % 4) + 1 }}">

            {{-- CARD IMAGE AREA --}}
            <div class="me__card-img" style="background: {{ $grad }};">
                <div class="me__card-dots"></div>
                <div class="me__card-circle-tr"></div>
                <div class="me__card-circle-bl"></div>
                <span class="me__card-watermark">{{ $exam->examType->name ?? 'EXAM' }}</span>

                <span class="me__type-badge">{{ $exam->examType->name ?? 'Exam' }}</span>
                <span class="me__status-badge {{ $status['cls'] }}">{{ $status['label'] }}</span>

                <div class="me__card-chips">
                    <span class="me__chip">
                        <x-lucide-clock style="width:10px;height:10px;" />
                        {{ $exam->total_duration ?? 120 }} min
                    </span>
                </div>
            </div>

            {{-- CARD BODY --}}
            <div class="me__card-body">
                <h3 class="me__card-title">{{ $exam->title }}</h3>
                @if($exam->description)
                <p class="me__card-desc">{{ Str::limit(strip_tags($exam->description), 85) }}</p>
                @else
                <p class="me__card-desc">A comprehensive exam simulation to test your readiness.</p>
                @endif

                <div class="me__card-meta">
                    <span class="me__meta-item">
                        <x-lucide-calendar style="width:11px;height:11px;" />
                        Enrolled {{ $enrolledDate }}
                    </span>
                    @if($attemptStatus === 'graded' && $latestAttempt->converted_score)
                    <span class="me__score-badge">
                        Score: <strong>{{ number_format($latestAttempt->converted_score, 1) }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            {{-- CARD FOOTER --}}
            <div class="me__card-footer">
                @if($attemptStatus === 'finished')
                    <button disabled class="me__btn me__btn--disabled">
                        <x-lucide-check style="width:15px;height:15px;" />
                        Exam Completed
                    </button>
                @elseif($attemptStatus === 'graded')
                    <a href="{{ route('test_taker.exam.result', $latestAttempt->id) }}" class="me__btn me__btn--result">
                        <x-lucide-bar-chart-2 style="width:15px;height:15px;" />
                        View Results
                    </a>
                @else
                    <form action="{{ route('test_taker.exam.start', $exam->id) }}" method="POST" style="flex:1;min-width:0;">
                        @csrf
                        @if($attemptStatus === 'ongoing')
                            <button type="submit" class="me__btn me__btn--resume">
                                <x-lucide-play style="width:15px;height:15px;" />
                                Resume Exam
                            </button>
                        @else
                            <button type="submit" class="me__btn me__btn--start">
                                <x-lucide-play style="width:15px;height:15px;" />
                                Start Exam
                            </button>
                        @endif
                    </form>
                @endif

                <a href="{{ route('test_taker.exam.detail', $exam->id) }}" class="me__detail-link">
                    Details
                    <x-lucide-arrow-right style="width:13px;height:13px;" />
                </a>
            </div>

        </div>
        @empty
        <div class="me__empty">
            <div class="me__empty-icon-wrap">
                <x-lucide-clipboard-list style="width:36px;height:36px;" />
            </div>
            <h3 class="me__empty-title">No enrolled exams yet</h3>
            <p class="me__empty-desc">Browse available exam simulations and enroll to start practicing.</p>
            <a href="{{ route('test_taker.exam.index') }}" class="me__empty-btn">
                Browse Exams
                <x-lucide-arrow-right style="width:14px;height:14px;" />
            </a>
        </div>
        @endforelse
    </div>

</div>
@endsection
