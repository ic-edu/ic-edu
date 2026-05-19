<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Exam Results Are Ready</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f1f5f9; color: #1e293b; }
        .wrapper { max-width: 560px; margin: 40px auto; padding: 0 16px; }
        .card { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%); padding: 36px 40px; text-align: center; }
        .header .icon { width: 56px; height: 56px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 24px; }
        .header h1 { color: white; font-size: 1.4rem; font-weight: 800; line-height: 1.3; }
        .header p { color: rgba(255,255,255,0.85); font-size: 0.85rem; margin-top: 6px; }
        .body { padding: 36px 40px; }
        .greeting { font-size: 1rem; font-weight: 700; color: #1e293b; margin-bottom: 12px; }
        .text { font-size: 0.88rem; color: #475569; line-height: 1.7; margin-bottom: 24px; }
        .score-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; margin-bottom: 24px; }
        .score-box .exam-name { font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.06em; color: #94a3b8; margin-bottom: 8px; }
        .score-main { display: flex; align-items: baseline; gap: 6px; margin-bottom: 4px; }
        .score-main .value { font-size: 2.5rem; font-weight: 900; color: #2563eb; line-height: 1; }
        .score-main .max { font-size: 1rem; font-weight: 600; color: #94a3b8; }
        .score-label { font-size: 0.75rem; color: #64748b; }
        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 99px; font-size: 0.72rem; font-weight: 800; margin-top: 12px; }
        .status-passed { background: #dcfce7; color: #16a34a; }
        .status-failed { background: #fee2e2; color: #dc2626; }
        .status-pending { background: #f1f5f9; color: #64748b; }
        .section-scores { margin-top: 16px; padding-top: 16px; border-top: 1px solid #e2e8f0; }
        .section-scores .label { font-size: 0.68rem; font-weight: 800; text-transform: uppercase; color: #94a3b8; letter-spacing: 0.05em; margin-bottom: 10px; }
        .section-row { display: flex; justify-content: space-between; font-size: 0.8rem; color: #475569; padding: 4px 0; }
        .section-row span:last-child { font-weight: 700; color: #1e293b; }
        .cta { text-align: center; margin-bottom: 28px; }
        .cta a { display: inline-block; background: linear-gradient(135deg, #2563eb, #4f46e5); color: white; text-decoration: none; padding: 14px 32px; border-radius: 12px; font-size: 0.88rem; font-weight: 800; }
        .footer { text-align: center; padding: 0 40px 32px; }
        .footer p { font-size: 0.75rem; color: #94a3b8; line-height: 1.6; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="card">
        <div class="header">
            <div class="icon">🎓</div>
            <h1>Your Results Are Ready!</h1>
            <p>{{ $attempt->exam->title }}</p>
        </div>
        <div class="body">
            <p class="greeting">Hi, {{ $attempt->user->name }}!</p>
            <p class="text">
                Your submission for <strong>{{ $attempt->exam->title }}</strong> has been reviewed and graded.
                Here is your result summary:
            </p>

            <div class="score-box">
                <div class="exam-name">{{ $attempt->exam->examType->name ?? 'Exam' }} &mdash; Final Score</div>
                <div class="score-main">
                    <span class="value">{{ number_format($attempt->converted_score, 1) }}</span>
                    <span class="max">/ {{ $attempt->exam->examType->max_score ?? 100 }}</span>
                </div>
                <div class="score-label">Converted Score</div>

                @if($attempt->is_passed === true)
                    <span class="status-badge status-passed">✓ PASSED</span>
                @elseif($attempt->is_passed === false)
                    <span class="status-badge status-failed">✗ NOT PASSED</span>
                @else
                    <span class="status-badge status-pending">No Passing Threshold</span>
                @endif

                @if(!empty($attempt->section_scores) && $attempt->exam->examType?->show_section_scores)
                <div class="section-scores">
                    <div class="label">Section Breakdown</div>
                    @foreach($attempt->section_scores as $section => $score)
                    <div class="section-row">
                        <span>{{ $section }}</span>
                        <span>{{ number_format($score, 1) }}</span>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="cta">
                <a href="{{ url('/dashboard') }}">View Full Results</a>
            </div>

            <p class="text" style="margin-bottom:0;">
                If you have any questions about your result, please contact your examiner or institution directly.
            </p>
        </div>
        <div class="footer">
            <p>This is an automated notification from <strong>{{ config('app.name') }}</strong>.<br>Please do not reply to this email.</p>
        </div>
    </div>
</div>
</body>
</html>
