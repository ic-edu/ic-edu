<?php

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Enums\ExamAttemptStatus;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.test_taker')]
class extends Component {
    public Exam $exam;
    public int $totalQuestions = 0;
    public bool $isEnrolled = false;

    public function mount(Exam $exam)
    {
        $this->exam = $exam->load([
            'sections' => fn($q) => $q->orderBy('order_position'),
            'sections.subsections' => fn($q) => $q->orderBy('order_position')
                ->withCount('questions')
                ->select(['id', 'section_id', 'title', 'order_position']),
            'examType',
        ]);
        $this->totalQuestions = $this->exam->total_questions;

        // Check enrollment
        $userId = Auth::id();
        $enrollment = \App\Models\ExamEnrollment::where('user_id', $userId)
            ->where('exam_id', $this->exam->id)
            ->first();

        if ($enrollment) {
            $this->isEnrolled = true;
        }
    }

    public function enroll()
    {
        $userId = Auth::id();

        // Cek lagi untuk mencegah double-enrollment
        $existing = \App\Models\ExamEnrollment::where('user_id', $userId)
            ->where('exam_id', $this->exam->id)
            ->first();

        if (!$existing) {
            \App\Models\ExamEnrollment::create([
                'user_id' => $userId,
                'exam_id' => $this->exam->id,
                'enrolled_at' => now(),
                'status' => 'active'
            ]);
        }

        session()->flash('success', 'Berhasil mendaftar ujian! Silakan klik tombol Start Exam untuk memulai.');
        return redirect()->route('test_taker.exam.detail', $this->exam->id);
    }
};
?>

<div x-data="{ showConfirm: false }">
<div class="ed__page-wrapper">

    {{-- BREADCRUMB --}}
    <div class="ed__breadcrumb">
        <a href="{{ route('test_taker.exam.index') }}" class="ed__back">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 12H5m7-7-7 7 7 7"/>
            </svg>
            Browse Exams
        </a>
        <span class="ed__breadcrumb-sep">/</span>
        <span class="ed__breadcrumb-current">{{ Str::limit($exam->title, 40) }}</span>
    </div>

    {{-- EXAM HEADER CARD --}}
    <div class="ed__header-card anim-in d1">
        @php
            $gradients = [
                'linear-gradient(135deg, #1A456C 0%, #1e5a8a 50%, #6FAFB5 100%)',
                'linear-gradient(135deg, #0f3460 0%, #1A456C 60%, #2c7a8a 100%)',
                'linear-gradient(135deg, #162d4a 0%, #1A456C 50%, #4f969b 100%)',
            ];
            $grad = $gradients[$exam->id % count($gradients)];
        @endphp
        <div class="ed__header-bg" style="background: {{ $grad }};">
            <div class="ed__header-dots"></div>
            <div class="ed__header-circle-tr"></div>
            <div class="ed__header-circle-bl"></div>
            <span class="ed__header-watermark">{{ $exam->examType->name ?? 'EXAM' }}</span>

            <div class="ed__header-content">
                <span class="ed__type-badge">{{ $exam->examType->name ?? 'Exam' }}</span>
                <h1 class="ed__header-title">{{ $exam->title }}</h1>
                <p class="ed__header-subtitle">Computer Based Test (CBT) Simulation</p>
            </div>
        </div>
    </div>

    {{-- 2-COLUMN MAIN LAYOUT --}}
    <div class="ed__main-layout">

        {{-- LEFT COLUMN --}}
        <div class="ed__content-col">

            {{-- SECTIONS OVERVIEW --}}
            <div class="card card-pad anim-in d2" style="margin-bottom: 24px;">
                <div class="ed__section-header">
                    <div class="ed__section-accent"></div>
                    <span class="ed__section-label">Exam Sections</span>
                </div>
                <div class="ed__sections-grid">
                    @foreach($exam->sections as $idx => $section)
                    <div class="ed__section-card">

                        {{-- IMAGE AREA --}}
                        <div class="ed__section-img-area">

                            <span class="ed__section-badge">{{ $section->title }}</span>

                            <div class="ed__section-deco-circle-1"></div>
                            <div class="ed__section-deco-circle-2"></div>

                            @php
                                $sectionSlug = strtolower(str_replace(' ', '-', $section->title));
                                $imgPath = 'assets/sections/' . $sectionSlug . '.png';
                                $imgFallback = 'assets/sections/default.png';
                            @endphp
                            <img
                                src="{{ asset(file_exists(public_path($imgPath)) ? $imgPath : $imgFallback) }}"
                                alt="{{ $section->title }}"
                                class="ed__section-illustration"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            >
                            <div class="ed__section-img-fallback" style="display:none;">
                                <svg width="48" height="48" fill="none" stroke="#1A456C"
                                     stroke-width="1.5" viewBox="0 0 24 24" opacity="0.3">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>

                            @if($section->duration)
                            <div class="ed__section-duration">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/>
                                    <path stroke-linecap="round" d="M12 6v6l4 2"/>
                                </svg>
                                <span>{{ $section->duration }} min</span>
                            </div>
                            @endif

                        </div>

                        {{-- CARD BODY --}}
                        <div class="ed__section-body">

                            <div class="ed__section-body-top">
                                <h3 class="ed__section-title">{{ $section->title }}</h3>
                                @if($section->description)
                                <p class="ed__section-desc">{{ Str::limit(strip_tags($section->description), 80) }}</p>
                                @endif
                            </div>

                            @if($section->subsections && $section->subsections->count() > 0)
                            <div class="ed__section-footer">
                                <p class="ed__subsection-label">What's inside</p>
                                <div class="ed__subsection-list">
                                    @foreach($section->subsections as $sub)
                                    <div class="ed__subsection-item">
                                        <span class="ed__part-number">Part {{ $loop->iteration }}</span>
                                        <span class="ed__part-divider">—</span>
                                        <span class="ed__part-title">{{ $sub->title }}</span>
                                        @if(isset($sub->questions_count) && $sub->questions_count > 0)
                                        <span class="ed__part-count">{{ $sub->questions_count }} soal</span>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>
                    @endforeach
                    @if($exam->sections->count() === 0)
                    <div style="text-align:center; padding: 32px 20px; grid-column: 1/-1;">
                        <p style="font-size:13px; color:var(--muted); font-weight:500;">No sections available yet.</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- RULES & INSTRUCTIONS --}}
            <div class="card card-pad anim-in d3" style="margin-bottom: 24px;">
                <div class="ed__section-header">
                    <div class="ed__section-accent"></div>
                    <span class="ed__section-label">Rules & Instructions</span>
                </div>

                @if($exam->description)
                <div class="ed__description">
                    {!! $exam->description !!}
                </div>
                @endif

                <div class="ed__rules-grid">
                    @php
                    $rules = [
                        ['icon' => 'globe',        'color' => '#3b82f6', 'title' => 'Connection', 'text' => 'Ensure you have a stable internet connection before starting.'],
                        ['icon' => 'timer',        'color' => '#f59e0b', 'title' => 'Timer',      'text' => 'The timer continues running even if you close the browser.'],
                        ['icon' => 'ban',          'color' => '#ef4444', 'title' => 'No Refresh', 'text' => 'Do not press Refresh (F5) or the Back button during the exam.'],
                        ['icon' => 'volume-x',     'color' => '#6b7280', 'title' => 'Quiet Zone', 'text' => 'Choose a quiet place so audio can be heard clearly.'],
                        ['icon' => 'check-circle', 'color' => '#10b981', 'title' => 'Review',     'text' => 'Review your answers carefully before submitting the exam.'],
                        ['icon' => 'shield',       'color' => '#8b5cf6', 'title' => 'Integrity',  'text' => 'Complete the exam independently without outside help.'],
                    ];
                    @endphp
                    @foreach($rules as $rule)
                    <div class="ed__rule-card">
                        <div class="ed__rule-icon" style="color: {{ $rule['color'] }}; background: {{ $rule['color'] }}18; border-color: {{ $rule['color'] }}35;">
                            <x-dynamic-component :component="'lucide-' . $rule['icon']" style="width: 18px; height: 18px;" />
                        </div>
                        <p class="ed__rule-title">{{ $rule['title'] }}</p>
                        <p class="ed__rule-text">{{ $rule['text'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN — EXAM OVERVIEW SIDEBAR --}}
        <div class="ed__overview-col">
            <div class="ed__overview-card anim-in d2">

                {{-- HEADER --}}
                <div class="ed__section-header">
                    <div class="ed__section-accent"></div>
                    <span class="ed__section-label">Exam Overview</span>
                </div>

                {{-- STATS LIST --}}
                <div class="ed__overview-stats">
                    <div class="ed__ov-stat">
                        <div class="ed__ov-stat-icon" style="color: var(--primary);">
                            <x-lucide-clock style="width:16px; height:16px;" />
                        </div>
                        <div class="ed__ov-stat-info">
                            <span class="ed__ov-stat-label">Duration</span>
                            <span class="ed__ov-stat-value">{{ $exam->total_duration ?? 120 }} Min</span>
                        </div>
                    </div>
                    <div class="ed__ov-stat">
                        <div class="ed__ov-stat-icon" style="color: var(--secondary);">
                            <x-lucide-help-circle style="width:16px; height:16px;" />
                        </div>
                        <div class="ed__ov-stat-info">
                            <span class="ed__ov-stat-label">Questions</span>
                            <span class="ed__ov-stat-value">{{ $totalQuestions }}</span>
                        </div>
                    </div>
                    <div class="ed__ov-stat">
                        <div class="ed__ov-stat-icon" style="color: #8b5cf6;">
                            <x-lucide-layers style="width:16px; height:16px;" />
                        </div>
                        <div class="ed__ov-stat-info">
                            <span class="ed__ov-stat-label">Sections</span>
                            <span class="ed__ov-stat-value">{{ $exam->sections->count() }}</span>
                        </div>
                    </div>
                    <div class="ed__ov-stat">
                        <div class="ed__ov-stat-icon" style="color: #f59e0b;">
                            <x-lucide-tag style="width:16px; height:16px;" />
                        </div>
                        <div class="ed__ov-stat-info">
                            <span class="ed__ov-stat-label">Type</span>
                            <span class="ed__ov-stat-value">{{ $exam->examType->name ?? 'CBT' }}</span>
                        </div>
                    </div>
                    <div class="ed__ov-stat">
                        <div class="ed__ov-stat-icon" style="color: #10b981;">
                            <x-lucide-monitor style="width:16px; height:16px;" />
                        </div>
                        <div class="ed__ov-stat-info">
                            <span class="ed__ov-stat-label">Mode</span>
                            <span class="ed__ov-stat-value">{{ ucfirst($exam->mode ?? 'Online') }}</span>
                        </div>
                    </div>
                </div>

                {{-- ENROLLMENT STATUS --}}
                <div class="ed__ov-enroll-row">
                    @if($isEnrolled)
                    <span class="ed__enroll-badge ed__enroll-badge--yes">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                        Enrolled
                    </span>
                    @else
                    <span class="ed__enroll-badge ed__enroll-badge--no">Not Enrolled</span>
                    @endif
                </div>

                <div class="ed__ov-divider"></div>

                {{-- CTA BUTTONS --}}
                <div class="ed__overview-cta">
                    @if($isEnrolled)
                        @php
                            $latestAttempt = $exam->attempts()->where('user_id', auth()->id())->latest()->first();
                        @endphp
                        @if($latestAttempt && $latestAttempt->status === ExamAttemptStatus::FINISHED->value)
                            <button disabled class="ed__btn ed__btn--disabled" style="width:100%;">
                                Exam Completed
                            </button>
                        @else
                            <form action="{{ route('test_taker.exam.start', $exam->id) }}" method="POST">
                                @csrf
                                @if($latestAttempt && $latestAttempt->status === ExamAttemptStatus::ONGOING->value)
                                    <button type="submit" class="ed__btn ed__btn--resume" style="width:100%;">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Resume Exam
                                    </button>
                                @else
                                    <button type="submit" class="ed__btn ed__btn--start" style="width:100%;">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Start Exam
                                    </button>
                                @endif
                            </form>
                        @endif
                    @else
                        <button @click="showConfirm = true" class="ed__btn ed__enroll-btn" style="width:100%;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                            </svg>
                            Enroll Now
                        </button>
                    @endif
                </div>

            </div>
        </div>

    </div>

</div>

{{-- CONFIRMATION MODAL (Alpine client-side = instant, wire:click for server action) --}}
<template x-teleport="body">
    <div x-show="showConfirm" x-transition.opacity.duration.200ms
         class="ed__modal-overlay"
         x-cloak>
        <div @click.outside="showConfirm = false" x-show="showConfirm" x-transition.scale.origin.center.duration.200ms
             class="ed__modal-box">
            <div class="ed__modal-icon">
                <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <h3 class="ed__modal-title">Confirm Enrollment</h3>
            <p class="ed__modal-body">
                You're about to enroll in this exam. It will be added to your My Exams menu and you can start it anytime.
            </p>
            <div class="ed__modal-actions">
                <button @click="showConfirm = false" class="ed__modal-cancel">
                    Cancel
                </button>
                <button wire:click="enroll" wire:loading.attr="disabled" class="ed__modal-confirm">
                    <span wire:loading.remove wire:target="enroll">Confirm Enrollment</span>
                    <span wire:loading wire:target="enroll">Processing...</span>
                </button>
            </div>
        </div>
    </div>
</template>
<style>[x-cloak] { display: none !important; }</style>
</div>
