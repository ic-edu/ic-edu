<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Submission Needs Grading</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f1f5f9; color: #1e293b; }
        .wrapper { max-width: 560px; margin: 40px auto; padding: 0 16px; }
        .card { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #d97706 0%, #ea580c 100%); padding: 36px 40px; text-align: center; }
        .header .icon { width: 56px; height: 56px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 24px; }
        .header h1 { color: white; font-size: 1.4rem; font-weight: 800; line-height: 1.3; }
        .header p { color: rgba(255,255,255,0.85); font-size: 0.85rem; margin-top: 6px; }
        .body { padding: 36px 40px; }
        .greeting { font-size: 1rem; font-weight: 700; color: #1e293b; margin-bottom: 12px; }
        .text { font-size: 0.88rem; color: #475569; line-height: 1.7; margin-bottom: 24px; }
        .info-box { background: #fffbeb; border: 1px solid #fde68a; border-radius: 12px; padding: 20px 24px; margin-bottom: 24px; }
        .info-row { display: flex; justify-content: space-between; align-items: center; padding: 6px 0; font-size: 0.83rem; border-bottom: 1px solid #fef3c7; }
        .info-row:last-child { border-bottom: none; }
        .info-row .info-label { color: #92400e; font-weight: 600; }
        .info-row .info-value { color: #1e293b; font-weight: 700; text-align: right; max-width: 60%; }
        .alert-badge { background: #fef3c7; border: 1px solid #fde68a; border-radius: 10px; padding: 12px 16px; margin-bottom: 24px; display: flex; gap: 10px; align-items: flex-start; }
        .alert-badge .icon { font-size: 1rem; flex-shrink: 0; margin-top: 1px; }
        .alert-badge p { font-size: 0.8rem; color: #92400e; line-height: 1.5; }
        .cta { text-align: center; margin-bottom: 28px; }
        .cta a { display: inline-block; background: linear-gradient(135deg, #d97706, #ea580c); color: white; text-decoration: none; padding: 14px 32px; border-radius: 12px; font-size: 0.88rem; font-weight: 800; }
        .footer { text-align: center; padding: 0 40px 32px; }
        .footer p { font-size: 0.75rem; color: #94a3b8; line-height: 1.6; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="card">
        <div class="header">
            <div class="icon">📋</div>
            <h1>New Submission to Grade</h1>
            <p>Action required from you</p>
        </div>
        <div class="body">
            <p class="greeting">Hi, {{ $examiner->name }}!</p>
            <p class="text">
                A test taker has completed their exam and their submission is now waiting for your review.
                Please grade it at your earliest convenience.
            </p>

            <div class="info-box">
                <div class="info-row">
                    <span class="info-label">Test Taker</span>
                    <span class="info-value">{{ $attempt->user->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $attempt->user->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Exam</span>
                    <span class="info-value">{{ $attempt->exam->title }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Exam Type</span>
                    <span class="info-value">{{ $attempt->exam->examType->name ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Submitted At</span>
                    <span class="info-value">{{ $attempt->finished_at?->format('d M Y, H:i') ?? 'Just now' }}</span>
                </div>
            </div>

            <div class="alert-badge">
                <span class="icon">⚠️</span>
                <p>
                    This exam may contain <strong>essay or voice recording</strong> answers that require manual scoring.
                    Automated scoring for objective questions has already been calculated.
                </p>
            </div>

            <div class="cta">
                <a href="{{ url('/examiner/dashboard') }}">Go to Grading Panel</a>
            </div>

            <p class="text" style="margin-bottom:0;">
                The test taker will be notified automatically once you submit the final grade.
            </p>
        </div>
        <div class="footer">
            <p>This is an automated notification from <strong>{{ config('app.name') }}</strong>.<br>Please do not reply to this email.</p>
        </div>
    </div>
</div>
</body>
</html>
