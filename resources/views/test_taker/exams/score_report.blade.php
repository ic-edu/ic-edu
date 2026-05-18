<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Score Report - {{ $exam->title }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #0f172a;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 2px dashed #e2e8f0;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #0f172a;
            font-size: 28px;
            margin: 0 0 5px 0;
        }

        .header p {
            color: #64748b;
            font-size: 14px;
            margin: 0;
        }

        .info-table {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 10px;
            border-bottom: 1px solid #f1f5f9;
        }

        .info-label {
            font-weight: bold;
            color: #64748b;
            font-size: 12px;
            text-transform: uppercase;
        }

        .info-value {
            font-weight: bold;
            color: #0f172a;
            font-size: 14px;
        }

        .score-highlight {
            width: 100%;
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            margin-bottom: 40px;
            padding: 20px;
        }

        .score-highlight-table {
            width: 100%;
            text-align: center;
        }

        .score-box h3 {
            font-size: 12px;
            text-transform: uppercase;
            color: #1d4ed8;
            margin: 0 0 5px 0;
        }

        .score-number {
            font-size: 40px;
            font-weight: bold;
            color: #2563eb;
            margin: 0;
        }

        .cefr-badge {
            background-color: #2563eb;
            color: white;
            padding: 15px;
            border-radius: 8px;
        }

        .cefr-level {
            font-size: 30px;
            font-weight: bold;
            margin: 0;
        }

        .cefr-desc {
            font-size: 11px;
            text-transform: uppercase;
            margin: 0;
        }

        .breakdown-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 5px;
        }

        .section-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .section-header td {
            background-color: #f8faff;
            padding: 10px;
            font-weight: bold;
            border-bottom: 2px solid #e2e8f0;
        }

        .subsection-row td {
            padding: 8px 10px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }

        .footer-note {
            margin-top: 50px;
            text-align: center;
            font-size: 11px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2 style="color: #2563eb; margin: 0 0 10px 0;">IC-EDU</h2>
        <h1>OFFICIAL SCORE REPORT</h1>
        <p>This is a simulation report and cannot be used as an official credential.</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="25%"><div class="info-label">Nama Peserta</div><div class="info-value">{{ $user->name }}</div></td>
            <td width="25%"><div class="info-label">ID / Email</div><div class="info-value">{{ $user->email }}</div></td>
            <td width="25%"><div class="info-label">Nama Ujian</div><div class="info-value">{{ $exam->title }}</div></td>
            <td width="25%"><div class="info-label">Tanggal</div><div class="info-value">{{ $generated_at }}</div></td>
        </tr>
    </table>

    <div class="score-highlight">
        <table class="score-highlight-table">
            <tr>
                <td width="33%" class="score-box">
                    <h3>Total Score</h3>
                    <div class="score-number">{{ $attempt->converted_score }}</div>
                </td>
                <td width="34%" class="score-box" style="border-left: 2px solid #bfdbfe; border-right: 2px solid #bfdbfe;">
                    <h3>Raw Score / Percentage</h3>
                    <div style="font-size: 28px; font-weight: bold; color: #0f172a;">{{ $total_earned }} <span style="font-size: 16px; color: #60a5fa;">/ {{ $total_max }}</span></div>
                    <div style="font-size: 12px; font-weight: bold; color: #64748b;">{{ $percentage }}% Accuracy</div>
                </td>
                <td width="33%">
                    <div class="cefr-badge">
                        <div class="cefr-level">{{ $cefr_level }}</div>
                        <div class="cefr-desc">{{ $cefr_description }}</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="breakdown-title">Score Breakdown</div>
    
    @foreach($sections_data as $sectionName => $sectionData)
    <table class="section-table">
        <tr class="section-header">
            <td width="80%">{{ $sectionName }}</td>
            <td width="20%" align="right" style="color: #2563eb;">{{ $sectionData['earned_points'] }} / {{ $sectionData['max_points'] }}</td>
        </tr>
        @foreach($sectionData['subsections'] as $subName => $subData)
        <tr class="subsection-row">
            <td style="padding-left: 20px; color: #64748b;">{{ $subName }}</td>
            <td align="right"><b>{{ $subData['earned_points'] }}</b> / {{ $subData['max_points'] }}</td>
        </tr>
        @endforeach
    </table>
    @endforeach

    <div class="footer-note">
        Verifikasi skor digital melalui sistem IC-EDU.<br>
        Dokumen ini dihasilkan secara otomatis pada {{ $generated_at }}.
    </div>

</body>
</html>
