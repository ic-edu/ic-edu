<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('tenant.active.app_name') }} - New Submission</title>
</head>

<body style="
    margin:0;
    padding:0;
    background:#f4f7fb;
    font-family:Arial, Helvetica, sans-serif;
">

    <div style="
        max-width:680px;
        margin:40px auto;
        background:#ffffff;
        border-radius:32px;
        overflow:hidden;
        box-shadow:0 10px 30px rgba(15,23,42,.08);
    ">


        <div style="
            padding:28px 42px;
            border-bottom:1px solid #eef2f7;
            display:flex;
            align-items:center;
            justify-content:space-between;
            background:#ffffff;
        ">

            <div style="background:#ffffff;padding:25px;border-bottom:1px solid #d8e2ef;text-align:center;">
                <img
                    src="{{ $message->embed(public_path(config('tenant.active.logo_light'))) }}"
                    alt="{{ config('tenant.active.app_name') }} Logo"
                    style="max-width:140px;height:auto;"
                >
            </div>

            <span style="
                font-size:14px;
                font-weight:600;
                color:#94a3b8;
                letter-spacing:.3px;
            ">
                {{ now()->format('d M Y') }}
            </span>
        </div>

        <div style="
            padding:50px 40px;
            background:linear-gradient(135deg,#173b63,#285fa0);
            text-align:center;
            color:white;
        ">

            <img src="{{ $message->embed(public_path('assets/maskot/pen maskot.png')) }}"
                width="180"
                style="
                    margin-bottom:24px;
                    display:block;
                    margin-left:auto;
                    margin-right:auto;
                    filter:drop-shadow(0 10px 20px rgba(0,0,0,.15));
            ">

            <h1 style="
                margin:0;
                font-size:42px;
                line-height:1.15;
                letter-spacing:-1px;
                font-weight:800;
                line-height:1.2;
            ">
                New Submission <br>
                Needs Grading
            </h1>

            <p style="
                margin-top:18px;
                font-size:17px;
                line-height:1.8;
                max-width:520px;
                margin:18px auto 0;
                color:rgba(255,255,255,.85);
            ">
                A student has completed an exam and is now waiting
                for your review and grading.
            </p>

        </div>

        <div style="padding:40px;">

            <div style="
                background:#f8fbff;
                border:1px solid #dbeafe;
                border-radius:24px;
                padding:28px;
            ">

                <h2 style="
                    margin-top:0;
                    margin-bottom:24px;
                    color:#173b63;
                    font-size:20px;
                ">
                    Submission Details
                </h2>

                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="padding:12px 0;color:#64748b;">Student</td>
                        <td style="padding:12px 0;font-weight:700;color:#0f172a;">
                            {{ $attempt->user->name }}
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:12px 0;color:#64748b;">Email</td>
                        <td style="padding:12px 0;color:#2563eb;">
                            {{ $attempt->user->email }}
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:12px 0;color:#64748b;">Exam</td>
                        <td style="padding:12px 0;font-weight:700;color:#0f172a;">
                            {{ $attempt->exam->title }}
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:12px 0;color:#64748b;">Type</td>
                        <td style="padding:12px 0;">
                            {{ $attempt->exam->examType->name ?? 'TOEIC' }}
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:12px 0;color:#64748b;">Submitted</td>
                        <td style="padding:12px 0;">
                            {{ $attempt->created_at->format('d M Y - H:i') }}
                        </td>
                    </tr>
                </table>

            </div>

            <div style="
                margin-top:24px;
                background:#fff7ed;
                border:1px solid #fed7aa;
                color:#9a3412;
                border-radius:20px;
                padding:18px 20px;
                font-size:14px;
                line-height:1.7;
            ">
                ⚠ This submission may contain essay or speaking answers
                that require manual assessment from an examiner.
            </div>

            <div style="text-align:center;margin-top:36px;">

                <a href="{{ url('/examiner/exam-reviews') }}"
                    style="
                        display:inline-block;
                        background:linear-gradient(135deg,#173b63,#285fa0);
                        color:white;
                        text-decoration:none;
                        padding:16px 34px;
                        border-radius:999px;
                        font-size:15px;
                        font-weight:700;
                        box-shadow:0 8px 20px rgba(37,99,235,.25);
                   ">
                    Go To Grading Panel
                </a>

            </div>

        </div>
        
        <div style="
            padding:28px;
            text-align:center;
            font-size:13px;
            color:#94a3b8;
            border-top:1px solid #eef2f7;
            background:#fcfdff;
        ">

            <div style="margin-bottom:10px;">
                IC EDU — English Learning & Certification Platform
            </div>

            <div>
                This is an automated email notification.
            </div>

        </div>

    </div>

</body>

</html>