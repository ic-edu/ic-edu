<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Exam Results Are Ready</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #e8eaee;
            color: #0d1f35;
            -webkit-font-smoothing: antialiased;
        }

        .wrapper {
            max-width: 580px;
            margin: 44px auto;
            padding: 0 16px 44px;
        }

        /* Gold accent stripe */
        .accent-bar {
            height: 4px;
            background: #b89840;
        }

        /* Main card */
        .card {
            background: #ffffff;
            border: 1px solid #cdd2db;
            border-top: none;
        }

        /* ── Header ── */
        .header {
            background: #0d1f35;
            padding: 40px 44px 36px;
            text-align: center;
        }
        .header-brand {
            font-size: 0.58rem;
            font-weight: 800;
            letter-spacing: 0.24em;
            text-transform: uppercase;
            color: rgba(184, 152, 64, 0.85);
            margin-bottom: 22px;
        }
        .header-title {
            color: #ffffff;
            font-size: 1.45rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.25;
        }
        .header-subtitle {
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.80rem;
            font-weight: 400;
            margin-top: 10px;
            letter-spacing: 0.01em;
        }

        /* ── Body ── */
        .body {
            padding: 40px 44px;
        }

        .greeting {
            font-size: 1rem;
            font-weight: 700;
            color: #0d1f35;
            margin-bottom: 10px;
        }

        .text {
            font-size: 0.875rem;
            color: #5a6478;
            line-height: 1.78;
            margin-bottom: 30px;
        }

        /* ── Official Report Box ── */
        .report-box {
            border: 1px solid #c8cdd8;
            border-left: 3px solid #0d1f35;
            margin-bottom: 32px;
        }

        .report-head {
            background: #f4f5f8;
            border-bottom: 1px solid #c8cdd8;
            padding: 11px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .report-head-label {
            font-size: 0.58rem;
            font-weight: 800;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: #8892a4;
        }
        .report-head-date {
            font-size: 0.58rem;
            font-weight: 500;
            color: #a0a8b8;
        }

        .report-body {
            padding: 28px 24px;
        }

        .exam-type-label {
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 0.13em;
            text-transform: uppercase;
            color: #9aa3b5;
            margin-bottom: 14px;
        }

        .score-row {
            display: flex;
            align-items: baseline;
            gap: 5px;
            margin-bottom: 5px;
        }
        .score-num {
            font-size: 3.2rem;
            font-weight: 900;
            color: #0d1f35;
            line-height: 1;
            letter-spacing: -0.03em;
        }
        .score-denom {
            font-size: 1.1rem;
            font-weight: 400;
            color: #b4bcc8;
        }
        .score-caption {
            font-size: 0.7rem;
            color: #9aa3b5;
            margin-bottom: 20px;
        }

        .score-divider {
            height: 1px;
            background: #eaecf0;
            margin-bottom: 18px;
        }

        /* Status badges — rectangular, institutional */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 13px;
            font-size: 0.62rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            border-radius: 2px;
        }
        .status-passed {
            background: #ecf7f2;
            color: #186a40;
            border: 1px solid #b0d9c4;
        }
        .status-failed {
            background: #fdf2f2;
            color: #a91b1b;
            border: 1px solid #efbcbc;
        }
        .status-pending {
            background: #f4f5f8;
            color: #68768a;
            border: 1px solid #cdd2db;
        }

        /* ── Section Breakdown ── */
        .section-block {
            margin-top: 22px;
            padding-top: 22px;
            border-top: 1px solid #eaecf0;
        }
        .section-block-label {
            font-size: 0.58rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            color: #9aa3b5;
            margin-bottom: 14px;
        }
        .section-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #f0f2f6;
            font-size: 0.82rem;
        }
        .section-item:last-child { border-bottom: none; }
        .section-item-name { color: #5a6478; }
        .section-item-score {
            font-weight: 700;
            color: #0d1f35;
        }

        /* ── CTA Button ── */
        .cta {
            text-align: center;
            margin-bottom: 30px;
        }
        .cta a {
            display: inline-block;
            background: #0d1f35;
            color: #ffffff;
            text-decoration: none;
            padding: 15px 42px;
            font-size: 0.83rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            border-radius: 3px;
        }

        /* ── Footer ── */
        .footer {
            background: #f4f5f8;
            border-top: 1px solid #cdd2db;
            padding: 20px 44px;
            text-align: center;
        }
        .footer p {
            font-size: 0.68rem;
            color: #96a0b2;
            line-height: 1.75;
        }

        /* ── Mobile ── */
        @media (max-width: 600px) {
            .wrapper { padding: 0 10px 28px; margin: 18px auto; }
            .header  { padding: 28px 22px 24px; }
            .body    { padding: 28px 22px; }
            .footer  { padding: 18px 22px; }
            .header-title { font-size: 1.25rem; }
            .score-num    { font-size: 2.6rem; }
        }
    </style>
</head>
<body>
<div class="wrapper">

    <div class="accent-bar"></div>

    <div class="card">

        {{-- Header --}}
        <div class="header">
            <p class="header-brand">{{ config('app.name') }}</p>
            <h1 class="header-title">Your Results Are Ready!</h1>
            <p class="header-subtitle">{{ $attempt->exam->title }}</p>
        </div>

        {{-- Body --}}
        <div class="body">

            <p class="greeting">Hi, {{ $attempt->user->name }}!</p>
            <p class="text">
                Your submission for <strong>{{ $attempt->exam->title }}</strong> has been reviewed and graded.
                Here is your result summary:
            </p>

            {{-- Official Result Report --}}
            <div class="report-box">
                <div class="report-head">
                    <span class="report-head-label">Official Result Summary</span>
                    <span class="report-head-date">{{ now()->format('d M Y') }}</span>
                </div>
                <div class="report-body">

                    <div class="exam-type-label">{{ $attempt->exam->examType->name ?? 'Exam' }} &mdash; Final Score</div>

                    <div class="score-row">
                        <span class="score-num">{{ number_format($attempt->converted_score, 1) }}</span>
                        <span class="score-denom">/ {{ $attempt->exam->examType->max_score ?? 100 }}</span>
                    </div>
                    <div class="score-caption">Converted Score</div>

                    <div class="score-divider"></div>

                    @if($attempt->is_passed === true)
                        <span class="status-badge status-passed">&#10003;&nbsp; PASSED</span>
                    @elseif($attempt->is_passed === false)
                        <span class="status-badge status-failed">&#10007;&nbsp; NOT PASSED</span>
                    @else
                        <span class="status-badge status-pending">No Passing Threshold</span>
                    @endif

                    @if(!empty($attempt->section_scores) && $attempt->exam->examType?->show_section_scores)
                    <div class="section-block">
                        <div class="section-block-label">Section Breakdown</div>
                        @foreach($attempt->section_scores as $section => $score)
                        <div class="section-item">
                            <span class="section-item-name">{{ $section }}</span>
                            <span class="section-item-score">{{ number_format($score, 1) }}</span>
                        </div>
                        @endforeach
                    </div>
                    @endif

                </div>
            </div>

            <div class="cta">
                <a href="{{ url('/dashboard') }}">View Full Results</a>
            </div>

            <p class="text" style="margin-bottom:0;">
                If you have any questions about your result, please contact your examiner or institution directly.
            </p>

        </div>

        {{-- Footer --}}
        <div class="footer">
            <p>This is an automated notification from <strong>{{ config('app.name') }}</strong>.<br>Please do not reply to this email.</p>
        </div>

    </div>
</div>
</body>
</html>
