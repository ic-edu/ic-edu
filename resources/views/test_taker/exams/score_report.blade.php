<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Score Report &mdash; {{ $exam->title }}</title>
    <style>{!! file_get_contents(resource_path('css/pdf/score-report.css')) !!}</style>
</head>
<body>

@php
    $logoPath   = public_path('assets/ic_edu_logo.png');
    $logoB64    = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : null;
    $percentage = $percentage ?? 0;
    $isPassing  = $percentage >= 60;

    $blockColors = ['section-block', 'section-block-teal', 'section-block-gold'];
    $progressColors = ['progress-fill-blue', 'progress-fill-teal', 'progress-fill-gold'];
@endphp

{{-- ── WATERMARK ── --}}
@if($logoB64)
<img class="watermark" src="data:image/png;base64,{{ $logoB64 }}" alt="">
@endif

{{-- ════════════════════════════════════
     HEADER — navy bg, logo + brand + QR
════════════════════════════════════ --}}
<div class="header-main">
    <table width="100%" style="border-collapse:collapse;">
        <tr>
            {{-- Logo --}}
            <td style="vertical-align:middle; width:68px;">
                @if($logoB64)
                <img class="header-logo-img"
                     src="data:image/png;base64,{{ $logoB64 }}"
                     alt="IC-EDU">
                @endif
            </td>

            {{-- Brand --}}
            <td style="vertical-align:middle; padding-left:14px; border-left:1px solid rgba(255,255,255,0.15);">
                <div class="header-brand">{{ config('app.name', 'IC-EDU') }}</div>
                <div class="header-brand-sub">English Proficiency Assessment</div>
            </td>

            {{-- Report info --}}
            <td style="vertical-align:middle; text-align:right; padding-right:16px;">
                <div class="header-report-label">Score Report</div>
                <div class="header-report-date">{{ $generated_at }}</div>
            </td>

            {{-- QR Code --}}
            <td style="vertical-align:middle; text-align:right; width:80px;">
                <img class="header-qr-img"
                     src="data:image/svg+xml;base64,{!! base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(90)->margin(0)->generate(route('test_taker.exam.result', $attempt->id))) !!}"
                     alt="QR">
                <div class="header-qr-label">Scan to Verify</div>
            </td>
        </tr>
    </table>
</div>

{{-- Teal + gold accent strips --}}
<div class="accent-teal"></div>
<div class="accent-gold"></div>

{{-- ════════════════════════════════════
     CANDIDATE INFO BAR
════════════════════════════════════ --}}
<div class="info-bar">
    <table width="100%" style="border-collapse:collapse;">
        <tr>
            <td style="vertical-align:middle; width:28%; padding-right:20px;">
                <div class="info-bar-label">Candidate Name</div>
                <div class="info-bar-value">{{ $user->name }}</div>
            </td>
            <td style="width:1px;" class="info-bar-divider">&nbsp;</td>
            <td style="vertical-align:middle; width:32%; padding:0 20px;">
                <div class="info-bar-label">Email / Candidate ID</div>
                <div class="info-bar-value">{{ $user->email }}</div>
            </td>
            <td style="width:1px;" class="info-bar-divider">&nbsp;</td>
            <td style="vertical-align:middle; width:26%; padding:0 20px;">
                <div class="info-bar-label">Exam Title</div>
                <div class="info-bar-value">{{ $exam->title }}</div>
            </td>
            <td style="width:1px;" class="info-bar-divider">&nbsp;</td>
            <td style="vertical-align:middle; padding-left:20px;">
                <div class="info-bar-label">Report Date</div>
                <div class="info-bar-value">{{ $generated_at }}</div>
            </td>
        </tr>
    </table>
</div>

{{-- ════════════════════════════════════
     PAGE BODY
════════════════════════════════════ --}}
<div class="page-body">

    {{-- ── SCORE CARDS ── --}}
    <table class="score-cards-table">
        <tr>
            {{-- Total Score — navy card --}}
            <td class="score-card score-card-blue" style="width:33%;">
                <div class="card-label-light">Total Score</div>
                <div class="score-big-white">{{ $attempt->converted_score }}</div>
                <div class="score-sub-light">{{ $percentage }}% Overall Accuracy</div>
            </td>

            {{-- Raw Score — white card --}}
            <td class="score-card score-card-white" style="width:34%;">
                <div class="card-label-dark">Raw Score &nbsp;&bull;&nbsp; Accuracy</div>
                <div class="score-big-dark">{{ $total_earned }}<span style="font-size:14px; color:#b0bac8; font-weight:normal;"> / {{ $total_max }}</span></div>
                <div class="score-sub-dark">{{ $percentage }}% Correct</div>
            </td>

            {{-- CEFR Level — navy card --}}
            <td class="score-card score-card-blue" style="width:33%;">
                <div class="card-label-light">CEFR Level</div>
                <div class="cefr-level">{{ $cefr_level }}</div>
                <div class="cefr-rule">&nbsp;</div>
                <div class="cefr-desc">{{ $cefr_description }}</div>
            </td>
        </tr>
    </table>

    {{-- ── SCORE BREAKDOWN ── --}}
    <div class="breakdown-label">Score Breakdown by Section</div>

    @foreach($sections_data as $sectionName => $sectionData)
    @php
        $sMax    = $sectionData['max_points'];
        $sEarn   = $sectionData['earned_points'];
        $sPct    = $sMax > 0 ? round(($sEarn / $sMax) * 100) : 0;
    @endphp

    <div class="section-block">
        {{-- Section header --}}
        <table width="100%" style="border-collapse:collapse;">
            <tr>
                <td class="section-name">{{ $sectionName }}</td>
                <td class="section-score-text" style="width:35%;">
                    {{ $sEarn }} / {{ $sMax }}
                    <span class="section-pct-text">&nbsp;({{ $sPct }}%)</span>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="progress-track">
                        <div class="progress-fill-blue" style="width:{{ $sPct }}%;"></div>
                    </div>
                </td>
            </tr>
        </table>

        {{-- Sub-sections --}}
        @foreach($sectionData['subsections'] as $subName => $subData)
        @php
            $subMax  = $subData['max_points'];
            $subEarn = $subData['earned_points'];
            $subPct  = $subMax > 0 ? round(($subEarn / $subMax) * 100) : 0;
            $subFill = $subPct >= 70 ? '#1A456C' : ($subPct >= 50 ? '#C9A84C' : '#e05252');
        @endphp
        <div class="sub-block">
            <table width="100%" style="border-collapse:collapse;">
                <tr>
                    <td class="sub-name">&#8227;&nbsp; {{ $subName }}</td>
                    <td class="sub-score" style="width:35%;">
                        {{ $subEarn }} / {{ $subMax }}
                        <span class="sub-pct">&nbsp;({{ $subPct }}%)</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="progress-track-sm">
                            <div class="progress-fill-sm" style="width:{{ $subPct }}%; background:{{ $subFill }};"></div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        @endforeach
    </div>

    @endforeach

    {{-- ── FOOTER ── --}}
    <div class="doc-footer">
        <p>
            This score report is automatically generated by the IC-EDU Assessment Platform.<br>
            To verify the authenticity of this document, scan the QR code or visit the IC-EDU portal.<br>
            Generated on {{ $generated_at }} &nbsp;&bull;&nbsp; Unauthorized reproduction or alteration is strictly prohibited.
        </p>
    </div>

</div>
</body>
</html>
