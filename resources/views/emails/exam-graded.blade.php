<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your English Test Result Is Ready</title>
</head>

<body style="margin:0;padding:0;background:#eef3f8;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;color:#102033;">

@php
    $examTitle = $attempt->exam->title ?? 'English Test';
    $examType = $attempt->exam->examType->name ?? 'English Test';
    $studentName = $attempt->user->name ?? 'Student';
    $maxScore = $attempt->exam->examType->max_score ?? 100;
    $convertedScore = number_format($attempt->converted_score ?? 0, 1);
    $resultDate = now()->format('d M Y');

    $passed = $attempt->is_passed;
@endphp

<div style="width:100%;background:#eef3f8;padding:36px 0;">
    <div style="max-width:620px;margin:0 auto;padding:0 16px;">

        <div style="background:#ffffff;border-radius:28px;overflow:hidden;border:1px solid #d9e3ef;box-shadow:0 18px 45px rgba(15,35,60,0.08);">

            <div style="background:#1A456C;padding:34px 34px 38px;text-align:center;position:relative;">

                <div style="font-size:11px;font-weight:900;letter-spacing:4px;text-transform:uppercase;color:#98d7e4;margin-bottom:20px;">
                    {{ config('tenant.active.app_name') }}
                </div>

                <img
                    src="{{ $message->embed(public_path('assets/maskot/verify_mascot.png')) }}"
                    alt="Result Verified"
                    style="width:112px;max-width:112px;height:auto;display:block;margin:0 auto 18px;"
                >

                <h1 style="margin:0;color:#ffffff;font-size:28px;line-height:1.25;font-weight:900;letter-spacing:-0.5px;">
                    Your Results Are Ready!
                </h1>

                <p style="margin:10px 0 0;color:#c8dae8;font-size:14px;line-height:1.6;">
                    {{ $examTitle }}
                </p>
            </div>

            <div style="padding:34px 38px 36px;">

                <p style="margin:0 0 12px;font-size:17px;font-weight:800;color:#102033;">
                    Hi, {{ $studentName }}!
                </p>

                <p style="margin:0 0 28px;font-size:14px;line-height:1.8;color:#5d6b80;">
                    Your submission for <strong style="color:#1A456C;">{{ $examTitle }}</strong> has been reviewed.
                    Here is your official result summary.
                </p>

                <div style="border:1px solid #d8e2ef;border-radius:22px;overflow:hidden;background:#fbfdff;margin-bottom:28px;">

                    <div style="background:#f4f8fc;border-bottom:1px solid #d8e2ef;padding:14px 20px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="font-size:10px;font-weight:900;letter-spacing:3px;text-transform:uppercase;color:#8b9ab0;">
                                    Official Result Summary
                                </td>
                                <td align="right" style="font-size:11px;font-weight:700;color:#9aa7b8;">
                                    {{ $resultDate }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div style="padding:26px 24px;">

                        <p style="margin:0 0 12px;font-size:11px;font-weight:900;letter-spacing:2px;text-transform:uppercase;color:#8b9ab0;">
                            {{ $examType }} — Final Score
                        </p>

                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="vertical-align:bottom;">
                                    <span style="font-size:54px;line-height:1;font-weight:950;color:#102033;letter-spacing:-2px;">
                                        {{ $convertedScore }}
                                    </span>
                                    <span style="font-size:18px;color:#9aa7b8;">
                                        / {{ number_format($maxScore, 1) }}
                                    </span>

                                    <p style="margin:8px 0 0;font-size:12px;color:#7b8aa0;">
                                        Converted Score
                                    </p>
                                </td>

                                <td align="right" style="vertical-align:bottom;">
                                    @if($passed === true)
                                        <span style="display:inline-block;background:#e9f8f1;color:#147a48;border:1px solid #bfe7d0;border-radius:999px;padding:9px 14px;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:1px;">
                                            Passed
                                        </span>
                                    @elseif($passed === false)
                                        <span style="display:inline-block;background:#fff3f3;color:#b42323;border:1px solid #f2c4c4;border-radius:999px;padding:9px 14px;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:1px;">
                                            Not Passed
                                        </span>
                                    @else
                                        <span style="display:inline-block;background:#eef3f8;color:#66758a;border:1px solid #d6e0ec;border-radius:999px;padding:9px 14px;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:1px;">
                                            Reviewed
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        </table>

                        @if(!empty($attempt->section_scores))
                            <div style="height:1px;background:#e8eef5;margin:24px 0 18px;"></div>

                            <p style="margin:0 0 12px;font-size:11px;font-weight:900;letter-spacing:2px;text-transform:uppercase;color:#8b9ab0;">
                                Section Breakdown
                            </p>

                            @foreach($attempt->section_scores as $section => $score)
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #edf2f7;">
                                    <tr>
                                        <td style="padding:10px 0;font-size:13px;color:#5d6b80;">
                                            {{ $section }}
                                        </td>
                                        <td align="right" style="padding:10px 0;font-size:13px;font-weight:800;color:#1A456C;">
                                            {{ number_format($score, 1) }}
                                        </td>
                                    </tr>
                                </table>
                            @endforeach
                        @endif

                    </div>
                </div>

                <div style="text-align:center;margin-bottom:28px;">
                    <a href="{{ url('/dashboard') }}"
                        style="display:inline-block;background:#102033;color:#ffffff;text-decoration:none;font-size:14px;font-weight:800;padding:15px 28px;border-radius:14px;box-shadow:0 10px 24px rgba(16,32,51,0.18);">
                        View Full Results
                    </a>
                </div>

                <p style="margin:0;font-size:13px;line-height:1.75;color:#65758a;text-align:center;">
                    Keep learning and improving your English skills with IC EDU.
                    Your full score report is available in your dashboard.
                </p>
            </div>

            <div style="background:#f5f8fc;border-top:1px solid #dde7f2;padding:22px 30px;text-align:center;">
                <p style="margin:0;font-size:12px;line-height:1.7;color:#8b9ab0;">
                    This is an automated notification from <strong>{{ config('tenant.active.app_name') }}</strong>.<br>
                    Please do not reply to this email.
                </p>
            </div>

        </div>
    </div>
</div>

</body>
</html>