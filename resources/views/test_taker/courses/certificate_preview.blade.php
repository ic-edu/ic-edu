@extends('layouts.test_taker')
@section('title', 'Course Certificate - ' . $course->title)

@section('content')
<div style="max-width: 900px; margin: 0 auto; width: 100%;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <a href="{{ route('test_taker.course.show', $course->id) }}" class="anim-in d1" style="display: inline-flex; align-items: center; gap: 6px; font-size: 0.85rem; font-weight: 700; color: var(--muted); text-decoration: none; transition: color .2s;"
           onmouseover="this.style.color='var(--blue)'" onmouseout="this.style.color='var(--muted)'">
            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            Back to Course
        </a>

        <a href="{{ route('test_taker.course.certificate.download', $course->id) }}" class="anim-in d1" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 12px; font-size: 0.85rem; font-weight: 800; background: linear-gradient(135deg, var(--blue), var(--indigo)); color: white; text-decoration: none; box-shadow: 0 4px 12px rgba(37,99,235,0.2); transition: all .2s;"
           onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Download PDF
        </a>
    </div>

    <div class="card anim-in d2" style="padding: 40px; text-align: center; background: #fff;">
        <div style="border: 8px solid #f8fafc; padding: 40px; position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; left: 0; width: 100px; height: 100px; border-right: 2px solid var(--blue); border-bottom: 2px solid var(--blue); border-bottom-right-radius: 20px;"></div>
            <div style="position: absolute; bottom: 0; right: 0; width: 100px; height: 100px; border-left: 2px solid var(--blue); border-top: 2px solid var(--blue); border-top-left-radius: 20px;"></div>
            
            <h1 style="font-size: 2.5rem; font-weight: 900; color: #0f172a; font-family: 'Times New Roman', serif; margin-bottom: 10px;">
                CERTIFICATE OF COMPLETION
            </h1>
            <p style="font-size: 1rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 40px;">
                This is proudly presented to
            </p>
            
            <h2 style="font-size: 3rem; font-weight: 700; color: var(--blue); font-family: 'Great Vibes', 'Brush Script MT', cursive; border-bottom: 2px solid #e2e8f0; display: inline-block; padding: 0 40px 10px; margin-bottom: 30px;">
                {{ Auth::user()->name }}
            </h2>
            
            <p style="font-size: 1rem; color: #475569; line-height: 1.6; max-width: 600px; margin: 0 auto 40px;">
                For successfully completing all modules and requirements for the course:<br>
                <strong style="font-size: 1.25rem; color: #1e293b; display: inline-block; margin-top: 10px;">{{ $course->title }}</strong>
            </p>
            
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 60px;">
                <div style="text-align: left;">
                    <p style="font-size: 0.8rem; color: #64748b; font-weight: 700;">Certificate ID: {{ $certificate->certificate_code }}</p>
                    <p style="font-size: 0.8rem; color: #64748b; font-weight: 700;">Issued On: {{ $certificate->issued_at->format('F d, Y') }}</p>
                </div>
                <div style="text-align: center;">
                    <div style="width: 150px; border-bottom: 2px solid #cbd5e1; margin-bottom: 10px;"></div>
                    <p style="font-size: 0.8rem; color: #0f172a; font-weight: 800; text-transform: uppercase;">Instructor / Admin</p>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection
