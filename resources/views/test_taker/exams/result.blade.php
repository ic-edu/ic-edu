@extends('layouts.test_taker')
@section('title', 'Exam Result')

@section('content')
<div class="ec__page-wrapper">
@php
    $score      = (float)($attempt->converted_score ?? 0);
    $maxScore   = (float)($attempt->exam->examType->max_score ?? 100);
    $pct        = $maxScore > 0 ? min(100, ($score / $maxScore) * 100) : 0;
    $isPassed   = $attempt->is_passed;

    $sectionMeta = [
        'speaking'  => ['label' => 'Speaking',  'color' => '#1A456C', 'bg' => '#eef3fb', 'border' => '#c7ddf0'],
        'listening' => ['label' => 'Listening', 'color' => '#6FAFB5', 'bg' => '#edf7f8', 'border' => '#b5dde1'],
        'reading'   => ['label' => 'Reading',   'color' => '#1e6fa5', 'bg' => '#e8f3fa', 'border' => '#aaced8'],
        'writing'   => ['label' => 'Writing',   'color' => '#3d8f96', 'bg' => '#e8f5f6', 'border' => '#9fd0d4'],
    ];
    $fallbackColors  = ['#1A456C', '#6FAFB5', '#1e6fa5', '#3d8f96'];
    $fallbackBgs     = ['#eef3fb', '#edf7f8', '#e8f3fa', '#e8f5f6'];
    $fallbackBorders = ['#c7ddf0', '#b5dde1', '#aaced8', '#9fd0d4'];

    $sectionScores = $attempt->section_scores ?? [];
    $sectionMax    = !empty($sectionScores) ? max(array_values($sectionScores)) : 1;

    // Map section title (lowercase) → Section model untuk preview URL
    $dbSections = $attempt->exam->sections()->orderBy('order_position')->get();
    $dbSectionMap = $dbSections->keyBy(fn($s) => strtolower(trim($s->title)));

    $sectionImgMap = [
        'speak'  => '/assets/sections/speaking.png',
        'listen' => '/assets/sections/listening.png',
        'read'   => '/assets/sections/reading.png',
        'writ'   => '/assets/sections/writing.png',
    ];
@endphp

{{-- ══════════════════════════════════════
     PAGE HEADER
══════════════════════════════════════ --}}
<div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:14px; margin-bottom:24px;">
    <div>
        <div style="display:flex; align-items:center; gap:7px; margin-bottom:9px;">
            <a href="{{ route('test_taker.exam.my_exams') }}"
               style="display:inline-flex; align-items:center; gap:4px; font-size:11.5px; font-weight:700; color:var(--muted); text-decoration:none; transition:color .18s;"
               onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--muted)'">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
                My Exams
            </a>
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" style="color:#cbd5e1"><path stroke="currentColor" stroke-width="2" d="M9 18l6-6-6-6"/></svg>
            <span style="font-size:11.5px; font-weight:600; color:var(--text);">Result</span>
        </div>
        <h1 style="font-family:'Poppins',sans-serif; font-size:1.65rem; font-weight:800; color:var(--text); letter-spacing:-0.025em; line-height:1.15; margin:0 0 5px;">Exam Result</h1>
        <p style="font-size:0.82rem; color:var(--muted); margin:0;">{{ $attempt->exam->title }}</p>
    </div>

    <x-test_taker.exam.pass-badge :is-passed="$isPassed" />
</div>

{{-- ══════════════════════════════════════
     HERO CARD — Score + Info
══════════════════════════════════════ --}}
<div class="anim-in d1" style="background:white; border-radius:20px; border:1px solid var(--border); overflow:hidden; box-shadow:0 4px 24px rgba(26,69,108,0.07); margin-bottom:20px;">

    <div style="height:3px; background:linear-gradient(90deg, var(--primary) 0%, var(--secondary) 60%, #3d8f96 100%);"></div>

    <div style="display:grid; grid-template-columns:auto 1fr; align-items:stretch;">

        {{-- Ring chart panel --}}
        <x-test_taker.exam.score-ring :score="$score" :max-score="$maxScore" :pct="$pct" />

        {{-- Details + Actions --}}
        <div style="padding:28px 32px; display:flex; flex-direction:column; justify-content:center;">

            <p style="font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.09em; color:var(--secondary); margin:0 0 6px;">{{ $attempt->exam->examType->name ?? 'Exam' }}</p>
            <h2 style="font-family:'Poppins',sans-serif; font-size:1.35rem; font-weight:800; color:var(--text); margin:0 0 20px; letter-spacing:-0.02em; line-height:1.25;">{{ $attempt->exam->title }}</h2>

            {{-- Overall progress bar --}}
            <div style="margin-bottom:20px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:7px;">
                    <span style="font-size:11px; font-weight:700; color:var(--muted);">Overall Score</span>
                    <span style="font-family:'Poppins',sans-serif; font-size:11px; font-weight:800; color:var(--primary);">{{ number_format($score, 1) }} / {{ number_format($maxScore, 0) }}</span>
                </div>
                <div style="height:9px; border-radius:99px; background:#e8eef8; overflow:hidden;">
                    <div style="height:100%; border-radius:99px; width:{{ $pct }}%; background:linear-gradient(90deg, var(--primary), var(--secondary)); transition:width 1.2s cubic-bezier(.34,1.2,.64,1);"></div>
                </div>
            </div>

            {{-- Date meta --}}
            <div style="display:flex; gap:20px; flex-wrap:wrap; margin-bottom:24px;">
                <div style="display:flex; align-items:center; gap:7px;">
                    <div style="width:30px; height:30px; border-radius:9px; background:#eef3fb; border:1px solid #c7ddf0; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <svg width="13" height="13" fill="none" stroke="var(--primary)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                    </div>
                    <div>
                        <div style="font-size:9.5px; font-weight:800; text-transform:uppercase; letter-spacing:0.08em; color:var(--muted); line-height:1.2;">Started</div>
                        <div style="font-size:12px; font-weight:700; color:var(--text); line-height:1.3;">{{ $attempt->started_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>
                <div style="display:flex; align-items:center; gap:7px;">
                    <div style="width:30px; height:30px; border-radius:9px; background:#edf7f8; border:1px solid #b5dde1; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <svg width="13" height="13" fill="none" stroke="var(--secondary)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 3.5"/></svg>
                    </div>
                    <div>
                        <div style="font-size:9.5px; font-weight:800; text-transform:uppercase; letter-spacing:0.08em; color:var(--muted); line-height:1.2;">Finished</div>
                        <div style="font-size:12px; font-weight:700; color:var(--text); line-height:1.3;">{{ $attempt->finished_at ? $attempt->finished_at->format('d M Y, H:i') : '—' }}</div>
                    </div>
                </div>
            </div>

            {{-- Action --}}
            <div>
                <a href="{{ route('test_taker.exam.score_report', $attempt->id) }}"
                   style="display:inline-flex; align-items:center; gap:8px; padding:11px 22px; background:linear-gradient(135deg,var(--primary),#1e5a8a); color:white; border-radius:12px; font-size:13px; font-weight:800; text-decoration:none; box-shadow:0 6px 18px rgba(26,69,108,0.3); transition:all .2s; font-family:'Poppins',sans-serif;"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 28px rgba(26,69,108,0.4)';"
                   onmouseout="this.style.transform='none'; this.style.boxShadow='0 6px 18px rgba(26,69,108,0.3)';">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 15V3m0 12l-4-4m4 4l4-4M3 18v2a1 1 0 001 1h16a1 1 0 001-1v-2"/></svg>
                    Download Score Report
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════
     SECTION SCORES
══════════════════════════════════════ --}}
@if(!empty($sectionScores))
@php $secCount = count($sectionScores); @endphp

<div style="margin-bottom:14px; display:flex; align-items:center; gap:9px;">
    <div style="width:4px; height:18px; background:linear-gradient(to bottom, var(--primary), var(--secondary)); border-radius:99px;"></div>
    <span style="font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:0.09em; color:var(--text);">Score Per Section</span>
    <span style="font-size:11px; font-weight:600; color:var(--muted); margin-left:2px;">— {{ $secCount }} section{{ $secCount > 1 ? 's' : '' }}</span>
</div>

{{-- 2 sections: landscape --}}
@if($secCount === 2)
<div style="display:flex; flex-direction:column; gap:16px;">
    @foreach($sectionScores as $rawName => $sectionScore)
    @php
        $key    = strtolower(trim($rawName));
        $meta   = $sectionMeta[$key] ?? null;
        $idx    = $loop->index;
        $imgSrc = collect($sectionImgMap)->first(fn($v, $k) => str_contains($key, $k));
    @endphp
    <x-test_taker.exam.section-card-landscape
        :label="$meta ? $meta['label'] : ucfirst($rawName)"
        :color="$meta ? $meta['color'] : $fallbackColors[$idx % 4]"
        :bg="$meta ? $meta['bg'] : $fallbackBgs[$idx % 4]"
        :border="$meta ? $meta['border'] : $fallbackBorders[$idx % 4]"
        :score="$sectionScore"
        :section-max="$sectionMax"
        :sec-pct="$sectionMax > 0 ? min(100, ($sectionScore / $sectionMax) * 100) : 0"
        :img-src="$imgSrc"
        :preview-url="isset($dbSectionMap[strtolower(trim($rawName))]) ? route('test_taker.exam.section.review', [$attempt->id, $dbSectionMap[strtolower(trim($rawName))]->id]) : route('test_taker.exam.score_report', $attempt->id)"
        :iteration="$loop->iteration"
        :anim-delay="(0.05 + $loop->index * 0.08) . 's'"
    />
    @endforeach
</div>

{{-- 4 sections: 2×2 portrait grid --}}
@else
<div class="sec-portrait-grid">
    @foreach($sectionScores as $rawName => $sectionScore)
    @php
        $key    = strtolower(trim($rawName));
        $meta   = $sectionMeta[$key] ?? null;
        $idx    = $loop->index;
        $imgSrc = collect($sectionImgMap)->first(fn($v, $k) => str_contains($key, $k));
    @endphp
    <x-test_taker.exam.section-card-portrait
        :label="$meta ? $meta['label'] : ucfirst($rawName)"
        :color="$meta ? $meta['color'] : $fallbackColors[$idx % 4]"
        :bg="$meta ? $meta['bg'] : $fallbackBgs[$idx % 4]"
        :border="$meta ? $meta['border'] : $fallbackBorders[$idx % 4]"
        :score="$sectionScore"
        :section-max="$sectionMax"
        :sec-pct="$sectionMax > 0 ? min(100, ($sectionScore / $sectionMax) * 100) : 0"
        :img-src="$imgSrc"
        :preview-url="isset($dbSectionMap[strtolower(trim($rawName))]) ? route('test_taker.exam.section.review', [$attempt->id, $dbSectionMap[strtolower(trim($rawName))]->id]) : route('test_taker.exam.score_report', $attempt->id)"
        :anim-delay="(0.05 + $loop->index * 0.06) . 's'"
    />
    @endforeach
</div>
@endif

@endif

</div>{{-- ec__page-wrapper --}}
@endsection
