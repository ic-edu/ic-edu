<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Score Report - {{ $exam->title }}</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #0d1f35;
            background: #ffffff;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }

        /* ── Page content area ── */
        .page-body {
            padding: 26px 44px 40px;
        }

        /* ── Section labels ── */
        .section-label {
            font-size: 7px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #8892a4;
            border-bottom: 1px solid #e5e8ee;
            padding-bottom: 7px;
            margin-bottom: 14px;
        }

        /* ── Candidate info ── */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 26px;
        }

        .info-label {
            font-size: 7px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #8892a4;
            margin-bottom: 3px;
        }

        .info-value {
            font-size: 10px;
            font-weight: bold;
            color: #0d1f35;
        }

        /* ── Score panel header strip ── */
        .score-panel-head {
            background: #eef0f5;
            border: 1px solid #c4cad6;
            border-bottom: none;
            padding: 8px 16px;
        }

        .score-panel-head-label {
            font-size: 7px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #8892a4;
        }

        /* ── Score panel table ── */
        .score-panel-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #c4cad6;
            border-top: 3px solid #0d1f35;
            margin-bottom: 28px;
        }

        .score-col {
            text-align: center;
            vertical-align: middle;
            padding: 22px 16px;
        }

        .col-label {
            font-size: 7px;
            font-weight: bold;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #8892a4;
            margin-bottom: 10px;
        }

        .score-big {
            font-family: 'Georgia', 'Times New Roman', serif;
            font-size: 48px;
            font-weight: bold;
            color: #0d1f35;
            line-height: 1;
        }

        .score-raw-num {
            font-family: 'Georgia', 'Times New Roman', serif;
            font-size: 30px;
            font-weight: bold;
            color: #0d1f35;
            line-height: 1;
        }

        .score-raw-denom {
            font-size: 13px;
            font-weight: normal;
            color: #b0b8c8;
        }

        .score-pct {
            font-size: 10px;
            font-weight: bold;
            color: #5a6478;
            margin-top: 6px;
        }

        /* ── CEFR cell ── */
        .cefr-cell {
            background: #0d1f35;
            text-align: center;
            vertical-align: middle;
            padding: 22px 16px;
        }

        .cefr-level-text {
            font-family: 'Georgia', 'Times New Roman', serif;
            font-size: 36px;
            font-weight: bold;
            color: #ffffff;
            line-height: 1;
        }

        .cefr-desc-text {
            font-size: 8px;
            font-weight: bold;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5);
            margin-top: 10px;
        }

        /* ── Score Breakdown ── */
        .breakdown-label {
            font-size: 8px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #0d1f35;
            margin-bottom: 8px;
        }

        .breakdown-thick-rule {
            height: 2px;
            background: #0d1f35;
            margin-bottom: 16px;
        }

        .section-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .section-head td {
            background: #f0f2f6;
            padding: 9px 12px;
            font-size: 10px;
            font-weight: bold;
            color: #0d1f35;
            border-top: 1px solid #c4cad6;
            border-bottom: 1px solid #c4cad6;
        }

        .section-score-right {
            text-align: right;
        }

        .sub-row td {
            padding: 7px 12px;
            font-size: 10px;
            color: #5a6478;
            border-bottom: 1px solid #f0f2f4;
        }

        .sub-name {
            padding-left: 26px !important;
        }

        .sub-score {
            text-align: right;
            font-weight: bold;
            color: #0d1f35;
        }

        /* ── Document footer ── */
        .doc-footer {
            margin-top: 36px;
            border-top: 1px solid #c4cad6;
            padding-top: 12px;
            text-align: center;
        }

        .doc-footer p {
            font-size: 8px;
            color: #9aa3b5;
            line-height: 1.75;
        }
    </style>
</head>
<body>

{{-- Gold accent stripe --}}
<div style="height: 4px; background: #b89840; margin: 0; padding: 0;"></div>

{{-- Navy header bar --}}
<div style="background: #0d1f35; margin: 0; padding: 18px 44px;">
    <table width="100%" style="border-collapse: collapse;">
        <tr>
            <td style="vertical-align: middle;">
                <div style="font-size: 7px; font-weight: bold; letter-spacing: 3px; text-transform: uppercase; color: #b89840; margin-bottom: 8px;">
                    {{ config('app.name', 'IC-EDU') }}
                </div>
                <div style="font-size: 15px; font-weight: bold; letter-spacing: 3px; text-transform: uppercase; color: #ffffff; margin-bottom: 6px;">
                    Official Score Report
                </div>
                <div style="font-size: 8px; color: rgba(255,255,255,0.38); font-style: italic;">
                    This is a simulation report and cannot be used as an official credential.
                </div>
            </td>
            <td style="vertical-align: middle; text-align: right; width: 110px;">
                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(90)->margin(0)->generate(route('test_taker.exam.result', $attempt->id))) !!}"
                     alt="QR Code"
                     style="width: 72px; height: 72px; display: block; margin-left: auto; border: 3px solid rgba(255,255,255,0.10);">
                <div style="font-size: 7px; color: rgba(255,255,255,0.38); text-align: right; margin-top: 4px; letter-spacing: 1px; text-transform: uppercase;">
                    Scan to Verify
                </div>
            </td>
        </tr>
    </table>
</div>

{{-- Thin gold separator --}}
<div style="height: 1px; background: #6b5520; margin: 0; padding: 0;"></div>

<div class="page-body">

    {{-- Candidate Information --}}
    <div class="section-label">Candidate Information</div>
    <table class="info-table">
        <tr>
            <td style="vertical-align: top; padding-right: 16px; width: 25%;">
                <div class="info-label">Nama Peserta</div>
                <div class="info-value">{{ $user->name }}</div>
            </td>
            <td style="vertical-align: top; padding-right: 16px; width: 25%;">
                <div class="info-label">ID / Email</div>
                <div class="info-value">{{ $user->email }}</div>
            </td>
            <td style="vertical-align: top; padding-right: 16px; width: 25%;">
                <div class="info-label">Nama Ujian</div>
                <div class="info-value">{{ $exam->title }}</div>
            </td>
            <td style="vertical-align: top; width: 25%;">
                <div class="info-label">Tanggal</div>
                <div class="info-value">{{ $generated_at }}</div>
            </td>
        </tr>
    </table>

    {{-- Score Panel --}}
    <div class="score-panel-head">
        <span class="score-panel-head-label">Performance Summary</span>
    </div>
    <table class="score-panel-table">
        <tr>
            {{-- Total Score --}}
            <td class="score-col" style="width: 32%; background: #f7f8fb; border-right: 1px solid #c4cad6;">
                <div class="col-label">Total Score</div>
                <div class="score-big">{{ $attempt->converted_score }}</div>
            </td>

            {{-- Raw Score / Percentage --}}
            <td class="score-col" style="width: 36%; background: #f7f8fb; border-right: 1px solid #c4cad6;">
                <div class="col-label">Raw Score &nbsp;/&nbsp; Percentage</div>
                <div class="score-raw-num">
                    {{ $total_earned }}<span class="score-raw-denom"> / {{ $total_max }}</span>
                </div>
                <div class="score-pct">{{ $percentage }}% Accuracy</div>
            </td>

            {{-- CEFR Level --}}
            <td class="cefr-cell" style="width: 32%;">
                <div class="cefr-level-text">{{ $cefr_level }}</div>
                <div style="height: 2px; background: #b89840; width: 36px; margin: 9px auto; font-size: 1px; line-height: 0;">&nbsp;</div>
                <div class="cefr-desc-text">{{ $cefr_description }}</div>
            </td>
        </tr>
    </table>

    {{-- Score Breakdown --}}
    <div class="breakdown-label">Score Breakdown</div>
    <div class="breakdown-thick-rule"></div>

    @foreach($sections_data as $sectionName => $sectionData)
    <table class="section-table">
        <tr class="section-head">
            <td>{{ $sectionName }}</td>
            <td class="section-score-right" style="width: 20%;">
                {{ $sectionData['earned_points'] }} / {{ $sectionData['max_points'] }}
            </td>
        </tr>
        @foreach($sectionData['subsections'] as $subName => $subData)
        <tr class="sub-row">
            <td class="sub-name">{{ $subName }}</td>
            <td class="sub-score" style="width: 20%;">
                <b>{{ $subData['earned_points'] }}</b> / {{ $subData['max_points'] }}
            </td>
        </tr>
        @endforeach
    </table>
    @endforeach

    {{-- Document Footer --}}
    <div class="doc-footer">
        <p>
            Verifikasi skor digital melalui sistem IC-EDU.<br>
            Dokumen ini dihasilkan secara otomatis pada {{ $generated_at }}.
        </p>
    </div>

</div>
</body>
</html>
