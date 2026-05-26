@extends('layouts.test_taker')
@section('title', 'Review — ' . $section->title)

@section('content')
@php
    $examTitle   = $attempt->exam->title;
    $sectionTitle = $section->title;
    $qNum = 0; // global counter
@endphp

<div class="ec__page-wrapper" style="padding:0;">

    {{-- ── TOP HEADER BAR ── --}}
    <div style="padding:20px 28px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;background:white;border-radius:20px 20px 0 0;">
        <div>
            <div style="display:flex;align-items:center;gap:7px;margin-bottom:8px;">
                <a href="{{ route('test_taker.exam.result', $attempt->id) }}"
                   style="display:inline-flex;align-items:center;gap:4px;font-size:11.5px;font-weight:700;color:var(--muted);text-decoration:none;transition:color .18s;"
                   onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--muted)'">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
                    Exam Result
                </a>
                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" style="color:#cbd5e1"><path stroke="currentColor" stroke-width="2" d="M9 18l6-6-6-6"/></svg>
                <span style="font-size:11.5px;font-weight:600;color:var(--text);">Review</span>
            </div>
            <h1 style="font-family:'Poppins',sans-serif;font-size:1.4rem;font-weight:800;color:var(--text);letter-spacing:-0.02em;line-height:1.2;margin:0 0 4px;">{{ $sectionTitle }}</h1>
            <p style="font-size:0.82rem;color:var(--muted);margin:0;">{{ $examTitle }}</p>
        </div>

        {{-- Section score badge --}}
        @php
            $sectionScores = $attempt->section_scores ?? [];
            $sectionScore  = collect($sectionScores)->first(fn($v, $k) => strtolower(trim($k)) === strtolower(trim($sectionTitle)));
        @endphp
        @if($sectionScore !== null)
        <div style="background:var(--primary);color:white;border-radius:14px;padding:12px 22px;text-align:center;">
            <div style="font-size:9.5px;font-weight:800;text-transform:uppercase;letter-spacing:0.1em;opacity:0.7;margin-bottom:3px;">Section Score</div>
            <div style="font-family:'Poppins',sans-serif;font-size:1.6rem;font-weight:900;line-height:1;letter-spacing:-0.03em;">{{ $sectionScore }}</div>
        </div>
        @endif
    </div>

    {{-- ── TWO-COLUMN LAYOUT ── --}}
    <div class="sr__shell">

        {{-- SIDEBAR --}}
        <div class="sr__sidebar-wrap">
            <x-test_taker.section-review.sidebar
                :attempt="$attempt"
                :section="$section"
                :flat-questions="$flatQuestions"
            />
        </div>

        {{-- MAIN CONTENT --}}
        <div class="sr__main">

            @forelse($section->subsections as $subsection)

            {{-- Subsection header --}}
            <div style="margin-bottom:20px;">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                    <div style="width:28px;height:28px;border-radius:8px;background:linear-gradient(135deg,var(--primary),var(--secondary));display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 3px 8px rgba(26,69,108,0.2);">
                        <span style="font-size:11px;font-weight:900;color:white;">{{ $loop->iteration }}</span>
                    </div>
                    <div>
                        <h2 style="font-family:'Poppins',sans-serif;font-size:1rem;font-weight:800;color:var(--text);margin:0;letter-spacing:-0.01em;">{{ $subsection->title }}</h2>
                    </div>
                </div>

                {{-- Subsection instruction / media --}}
                @if($subsection->instructions || $subsection->instruction_audio_path || $subsection->instruction_image_path)
                <div style="background:#f0f5fb;border:1px solid #c7ddf0;border-left:3px solid var(--primary);border-radius:0 10px 10px 0;padding:12px 16px;margin-bottom:16px;">
                    @if($subsection->instructions)
                    <div style="font-size:12.5px;line-height:1.7;color:#374151;">{!! $subsection->instructions !!}</div>
                    @endif
                    @if($subsection->instruction_audio_path)
                    <div style="margin-top:10px;">
                        <audio controls style="width:100%;height:34px;border-radius:6px;">
                            <source src="{{ Storage::url($subsection->instruction_audio_path) }}" type="audio/mpeg">
                        </audio>
                    </div>
                    @endif
                    @if($subsection->instruction_image_path)
                    <div style="margin-top:10px;text-align:center;">
                        <img src="{{ Storage::url($subsection->instruction_image_path) }}" style="max-width:100%;max-height:200px;border-radius:8px;object-fit:contain;"/>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            {{-- Question Groups --}}
            @foreach($subsection->questionGroups as $group)

            {{-- Split layout (passage kiri, soal kanan) --}}
            @if($group->group_type === 'split' && ($group->passage_text || $group->image_path || $group->audio_path))
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;align-items:start;">

                {{-- Left: passage/media --}}
                <div style="position:sticky;top:20px;">
                    <x-test_taker.section-review.group-header :group="$group" />
                </div>

                {{-- Right: questions --}}
                <div>
                    @if($group->title || $group->instruction)
                    <div style="margin-bottom:12px;">
                        @if($group->title)<div style="font-size:12px;font-weight:800;color:var(--text);margin-bottom:4px;">{{ $group->title }}</div>@endif
                        @if($group->instruction)<div style="font-size:12px;color:var(--muted);line-height:1.6;">{!! $group->instruction !!}</div>@endif
                    </div>
                    @endif
                    @foreach($group->questions as $question)
                    @php $qNum++; $ans = $answers->get($question->id); @endphp
                    @if($question->type === 'multiple_choice')
                        <x-test_taker.section-review.question-mc :question="$question" :answer="$ans" :number="$qNum" />
                    @else
                        <x-test_taker.section-review.question-subjective :question="$question" :answer="$ans" :number="$qNum" />
                    @endif
                    @endforeach
                </div>
            </div>

            {{-- Default layout (stacked) --}}
            @else
            <div style="margin-bottom:20px;">
                <x-test_taker.section-review.group-header :group="$group" />
                @foreach($group->questions as $question)
                @php $qNum++; $ans = $answers->get($question->id); @endphp
                @if($question->type === 'multiple_choice')
                    <x-test_taker.section-review.question-mc :question="$question" :answer="$ans" :number="$qNum" />
                @else
                    <x-test_taker.section-review.question-subjective :question="$question" :answer="$ans" :number="$qNum" />
                @endif
                @endforeach
            </div>
            @endif

            @endforeach

            @empty
            <div style="text-align:center;padding:60px 20px;color:var(--muted);">
                <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 16px;display:block;opacity:0.3;"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <p style="font-size:14px;font-weight:600;">Tidak ada soal di section ini.</p>
            </div>
            @endforelse

        </div>{{-- sr__main --}}
    </div>{{-- sr__shell --}}

</div>{{-- ec__page-wrapper --}}

@push('styles')
<style>
.sr__shell {
    display: grid;
    grid-template-columns: 276px 1fr;
    gap: 20px;
    align-items: start;
    padding: 20px 28px 40px;
}
.sr__sidebar-wrap {
    position: sticky;
    top: 20px;
    max-height: calc(100vh - 80px);
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: #c7ddf0 transparent;
}
.sr__sidebar-wrap::-webkit-scrollbar { width: 4px; }
.sr__sidebar-wrap::-webkit-scrollbar-thumb { background: #c7ddf0; border-radius: 99px; }
.sr__main { min-width: 0; }

html { scroll-behavior: smooth; }

@media (max-width: 1024px) {
    .sr__shell { grid-template-columns: 1fr; }
    .sr__sidebar-wrap { position: static; max-height: none; }
}
@media (max-width: 640px) {
    .sr__shell { padding: 16px 16px 40px; gap: 16px; }
}
</style>
@endpush
@endsection
