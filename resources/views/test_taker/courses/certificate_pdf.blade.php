<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate of Completion</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: #ffffff;
            color: #0f172a;
        }
        .cert-container {
            width: 100%;
            height: 100%;
            padding: 40px;
            box-sizing: border-box;
            border: 10px solid #f8fafc;
            position: relative;
        }
        .cert-border {
            border: 2px solid #e2e8f0;
            padding: 40px;
            height: 90%;
            text-align: center;
        }
        .title {
            font-size: 40px;
            font-weight: bold;
            color: #0f172a;
            margin-top: 20px;
            margin-bottom: 10px;
            font-family: 'Times New Roman', serif;
        }
        .subtitle {
            font-size: 16px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 40px;
        }
        .recipient {
            font-size: 48px;
            font-weight: bold;
            color: #2563eb;
            border-bottom: 2px solid #e2e8f0;
            display: inline-block;
            padding: 0 40px 10px 40px;
            margin-bottom: 30px;
            font-family: 'Times New Roman', serif;
            font-style: italic;
        }
        .description {
            font-size: 18px;
            color: #475569;
            line-height: 1.6;
            margin-bottom: 50px;
        }
        .course-title {
            font-size: 24px;
            font-weight: bold;
            color: #1e293b;
            margin-top: 10px;
        }
        .footer {
            width: 100%;
            margin-top: 60px;
        }
        .footer table {
            width: 100%;
        }
        .footer td {
            width: 50%;
            vertical-align: bottom;
        }
        .footer-left {
            text-align: left;
            font-size: 14px;
            color: #64748b;
        }
        .footer-right {
            text-align: right;
            padding-right: 40px;
        }
        .signature-line {
            width: 200px;
            border-bottom: 1px solid #0f172a;
            margin-left: auto;
            margin-bottom: 5px;
        }
        .signature-text {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            color: #0f172a;
        }
    </style>
</head>
<body>
    <div class="cert-container">
        <div class="cert-border">
            <div class="title">CERTIFICATE OF COMPLETION</div>
            <div class="subtitle">This is proudly presented to</div>
            
            <div class="recipient">{{ Auth::user()->name }}</div>
            
            <div class="description">
                For successfully completing all modules and requirements for the course:<br>
                <div class="course-title">{{ $course->title }}</div>
            </div>
            
            <div class="footer">
                <table>
                    <tr>
                        <td class="footer-left">
                            <strong>Certificate ID:</strong> {{ $certificate->certificate_code }}<br>
                            <strong>Issued On:</strong> {{ $certificate->issued_at->format('F d, Y') }}
                        </td>
                        <td class="footer-right">
                            <div class="signature-line"></div>
                            <div class="signature-text">Instructor / Admin</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
