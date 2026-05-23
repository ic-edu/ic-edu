@extends('layouts.test_taker')
@section('title', 'Exam Result')

@section('content')
<div style="max-width: 800px; margin: 0 auto; width: 100%;">

    {{-- HEADER --}}
    <div style="margin-bottom: 32px;">
        <h1 style="font-size: 1.8rem; font-weight: 900; color: var(--text); letter-spacing: -0.02em;">Exam Result</h1>
        <p style="font-size: 0.85rem; color: var(--muted); margin-top: 6px;">Here is your detailed exam result below.</p>
    </div>

    {{-- RESULT CARD --}}
    <div class="card anim-in d1">

        {{-- Score Banner --}}
        <div style="background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%); padding: 40px 32px; border-radius: 16px 16px 0 0; text-align: center;">
            <p style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(255,255,255,0.7); margin-bottom: 8px;">Final Score</p>
            <div style="font-size: 4.5rem; font-weight: 900; color: white; line-height: 1; letter-spacing: -0.04em;">
                {{ number_format($attempt->converted_score ?? 0, 1) }}
            </div>
            <p style="font-size: 0.85rem; color: rgba(255,255,255,0.6); margin-top: 8px;">
                out of {{ $attempt->exam->examType->max_score ?? 100 }}
            </p>

            @if($attempt->is_passed !== null)
                <div style="margin-top: 20px;">
                    <span style="display: inline-block; padding: 8px 24px; border-radius: 99px; font-size: 0.85rem; font-weight: 800;
                        background: {{ $attempt->is_passed ? 'rgba(34,197,94,0.25)' : 'rgba(239,68,68,0.25)' }};
                        color: {{ $attempt->is_passed ? '#86efac' : '#fca5a5' }};
                        border: 1.5px solid {{ $attempt->is_passed ? 'rgba(34,197,94,0.4)' : 'rgba(239,68,68,0.4)' }};">
                        {{ $attempt->is_passed ? '✓ LULUS' : '✗ TIDAK LULUS' }}
                    </span>
                </div>
            @endif
        </div>

        {{-- Detail Section --}}
        <div style="padding: 32px;">

            {{-- Section Scores --}}
            @if(!empty($attempt->section_scores))
            <div style="margin-bottom: 28px;">
                <p style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--muted); margin-bottom: 16px;">Score Per Section</p>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 12px;">
                    @foreach($attempt->section_scores as $sectionName => $sectionScore)
                    <div style="background: var(--surface); border: 1.5px solid var(--border); border-radius: 12px; padding: 16px; text-align: center;">
                        <p style="font-size: 0.7rem; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">{{ $sectionName }}</p>
                        <p style="font-size: 1.6rem; font-weight: 900; color: var(--blue);">{{ $sectionScore }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Exam Info --}}
            <div style="border-top: 1.5px solid var(--border); padding-top: 24px; display: flex; flex-direction: column; gap: 16px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.8rem; font-weight: 700; color: var(--muted);">Exam Title</span>
                    <span style="font-size: 0.9rem; font-weight: 800; color: var(--text);">{{ $attempt->exam->title }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.8rem; font-weight: 700; color: var(--muted);">Started At</span>
                    <span style="font-size: 0.9rem; font-weight: 700; color: var(--text);">{{ $attempt->started_at->format('d M Y, H:i') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.8rem; font-weight: 700; color: var(--muted);">Ended At</span>
                    <span style="font-size: 0.9rem; font-weight: 700; color: var(--text);">{{ $attempt->finished_at ? $attempt->finished_at->format('d M Y, H:i') : 'N/A' }}</span>
                </div>
            </div>

            <a href="{{ route('test_taker.exam.score_report', $attempt->id) }}" class="btn btn-primary">
                Download Score Report
            </a>

            {{-- Back Button --}}
            <div style="margin-top: 32px;">
                <a href="{{ route('test_taker.exam.my_exams') }}"
                   style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 12px; background: var(--blue); color: white; font-size: 0.85rem; font-weight: 800; text-decoration: none; transition: filter 0.2s;"
                   onmouseover="this.style.filter='brightness(1.1)';"
                   onmouseout="this.style.filter='brightness(1)';">
                    ← Back to My Exams
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
