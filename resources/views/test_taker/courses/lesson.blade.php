@extends('layouts.course_player')
@section('title', $lesson->title)

@section('content')
<div style="max-width: 900px; margin: 0 auto; width: 100%; padding: 32px 24px;">

        {{-- MAIN CONTENT --}}
        <div>
            {{-- LESSON HEADER --}}
            <div class="card card-pad anim-in d1" style="margin-bottom: 24px;">
                @php
                    $typeIcons = ['video' => '🎬', 'pdf' => '📄', 'text' => '📝', 'audio' => '🎧', 'link' => '🔗', 'quiz' => '🧩'];
                    $typeLabels = \App\Models\CourseLesson::types();
                @endphp
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                    <span style="font-size: 1.6rem;">{{ $typeIcons[$lesson->type] ?? '📄' }}</span>
                    <div>
                        <span style="font-size: 0.65rem; font-weight: 800; color: var(--blue); text-transform: uppercase; letter-spacing: 0.06em;">
                            {{ $typeLabels[$lesson->type] ?? $lesson->type }} · {{ $lesson->module->title }}
                        </span>
                        <h1 style="font-size: 1.4rem; font-weight: 900; color: var(--text); line-height: 1.3; margin-top: 4px;">
                            {{ $lesson->title }}
                        </h1>
                    </div>
                </div>

                @if($lesson->duration_minutes)
                <div style="display: flex; align-items: center; gap: 6px; font-size: 0.78rem; color: var(--muted); font-weight: 600;">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Estimated: {{ $lesson->duration_minutes }} minutes
                </div>
                @endif
            </div>

            {{-- CONTENT AREA --}}
            <div class="card anim-in d2" style="margin-bottom: 24px; overflow: hidden;">

                {{-- VIDEO --}}
                @if($lesson->type === 'video')
                <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; background: #000;">
                    @if(str_contains($lesson->content_url ?? '', 'youtube') || str_contains($lesson->content_url ?? '', 'youtu.be'))
                        @php
                            $youtubeId = '';
                            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $lesson->content_url, $match)) {
                                $youtubeId = $match[1];
                            }
                        @endphp
                        @if($youtubeId)
                        <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}?rel=0" 
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        @else
                        <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; color: white;">
                            <p>Invalid YouTube URL.</p>
                        </div>
                        @endif
                    @elseif($lesson->file_path)
                        <video controls style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                            <source src="{{ asset('storage/' . $lesson->file_path) }}">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; color: white;">
                            <a href="{{ $lesson->content_url }}" target="_blank" style="color: white; text-decoration: underline; font-size: 0.9rem;">
                                Open Video in New Tab →
                            </a>
                        </div>
                    @endif
                </div>
                @endif

                {{-- AUDIO --}}
                @if($lesson->type === 'audio')
                <div style="padding: 40px; text-align: center; background: linear-gradient(135deg, #1e1b4b, #312e81);">
                    <div style="font-size: 4rem; margin-bottom: 20px;">🎧</div>
                    <audio controls style="width: 100%; max-width: 500px; margin: 0 auto;">
                        @if($lesson->file_path)
                        <source src="{{ asset('storage/' . $lesson->file_path) }}">
                        @else
                        <source src="{{ $lesson->content_url }}">
                        @endif
                        Your browser does not support the audio element.
                    </audio>
                    <p style="font-size: 0.78rem; color: rgba(255,255,255,0.6); margin-top: 16px; font-weight: 600;">
                        Listen carefully. You may replay the audio as needed.
                    </p>
                </div>
                @endif

                {{-- PDF --}}
                @if($lesson->type === 'pdf')
                <div style="height: 600px; background: #f1f5f9;">
                    @if($lesson->file_path)
                    <iframe src="{{ asset('storage/' . $lesson->file_path) }}" 
                            style="width: 100%; height: 100%; border: none;"></iframe>
                    @elseif($lesson->content_url)
                    <iframe src="{{ $lesson->content_url }}" 
                            style="width: 100%; height: 100%; border: none;"></iframe>
                    @else
                    <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: var(--muted);">
                        <p>PDF file not available.</p>
                    </div>
                    @endif
                </div>
                @endif

                {{-- TEXT / ARTICLE --}}
                @if($lesson->type === 'text')
                <div style="padding: 32px;" class="lesson-text-content">
                    <style>
                        .lesson-text-content h2 { font-size: 1.3rem; font-weight: 800; color: var(--text); margin: 24px 0 12px; line-height: 1.3; }
                        .lesson-text-content h3 { font-size: 1.05rem; font-weight: 700; color: var(--text); margin: 20px 0 10px; }
                        .lesson-text-content p { font-size: 0.88rem; color: #374151; line-height: 1.8; margin-bottom: 14px; }
                        .lesson-text-content ul, .lesson-text-content ol { font-size: 0.88rem; color: #374151; line-height: 1.8; padding-left: 24px; margin-bottom: 14px; }
                        .lesson-text-content li { margin-bottom: 6px; }
                        .lesson-text-content blockquote { border-left: 4px solid var(--blue); background: #f0f4ff; padding: 14px 20px; border-radius: 0 12px 12px 0; margin: 16px 0; font-size: 0.88rem; color: #1e3a8a; font-style: italic; }
                        .lesson-text-content table { width: 100%; border-collapse: collapse; margin: 16px 0; font-size: 0.82rem; }
                        .lesson-text-content th, .lesson-text-content td { padding: 10px 14px; border: 1px solid var(--border); text-align: left; }
                        .lesson-text-content th { background: var(--base); font-weight: 700; }
                        .lesson-text-content strong { color: var(--text); }
                        .lesson-text-content em { color: #6b7280; }
                        .lesson-text-content s { color: #ef4444; text-decoration: line-through; }
                    </style>
                    {!! $lesson->text_content !!}
                </div>
                @endif

                {{-- LINK --}}
                @if($lesson->type === 'link')
                <div style="padding: 60px 40px; text-align: center; background: #f8fafc; border: 1px solid var(--border); border-radius: 12px; margin: 20px;">
                    <div style="width: 80px; height: 80px; border-radius: 50%; background: #eff6ff; color: var(--blue); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <svg style="width:40px;height:40px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--text); margin-bottom: 8px;">External Resource</h3>
                    <p style="font-size: 0.85rem; color: var(--muted); max-width: 400px; margin: 0 auto 24px; line-height: 1.6;">
                        This lesson requires you to read or view an external resource. Click the button below to securely open the link in a new tab.
                    </p>
                    <a href="{{ $lesson->content_url }}" target="_blank" rel="noopener"
                       style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 8px; background: var(--blue); color: white; font-size: 0.9rem; font-weight: 700; text-decoration: none; transition: all 0.2s; box-shadow: 0 4px 12px rgba(37,99,235,0.2);">
                        Open External Link
                        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
                @endif

                {{-- QUIZ --}}
                @if($lesson->type === 'quiz')
                <div style="padding: 60px 40px; text-align: center; background: var(--base);">
                    <div style="font-size: 4rem; margin-bottom: 16px;">🧩</div>
                    @if($lesson->exam_id)
                        @php
                            $attempt = \App\Models\ExamAttempt::where('user_id', Auth::id())
                                ->where('exam_id', $lesson->exam_id)
                                ->latest()
                                ->first();
                        @endphp

                        @if($attempt && $attempt->status === \App\Enums\ExamAttemptStatus::GRADED->value)
                            @php $passing = $lesson->passing_score ?? 0; @endphp
                            @if($attempt->converted_score >= $passing)
                                <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--success); margin-bottom: 8px;">Quiz Completed</h3>
                                <p style="font-size: 0.85rem; color: var(--text); margin-bottom: 16px;">Your Score: <strong>{{ $attempt->converted_score }}</strong> (Passed, minimum {{ $passing }})</p>
                                <a href="{{ route('test_taker.exam.score_report', $attempt->id) }}" class="btn btn-primary" style="display: inline-block;">
                                    Download Score Report
                                </a>
                            @else
                                <h3 style="font-size: 1.1rem; font-weight: 800; color: #dc2626; margin-bottom: 8px;">Score Below Target</h3>
                                <p style="font-size: 0.85rem; color: var(--muted); margin-bottom: 16px;">Your Score: <strong>{{ $attempt->converted_score }}</strong> (Requires at least {{ $passing }} to proceed)</p>
                                <form action="{{ route('test_taker.course.quiz.start', [$course->id, $lesson->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="display: inline-flex; align-items: center; gap: 8px; padding: 14px 28px; border-radius: 14px; background: #dc2626; color: white; font-size: 0.88rem; font-weight: 700; text-decoration: none; border: none; cursor: pointer; box-shadow: 0 4px 16px rgba(220, 38, 38, 0.25);">
                                        Retake Quiz
                                    </button>
                                </form>
                            @endif
                        @elseif($attempt && $attempt->status === \App\Enums\ExamAttemptStatus::FINISHED->value)
                            <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--text); margin-bottom: 8px;">Quiz is being Graded</h3>
                            <p style="font-size: 0.85rem; color: var(--muted);">Your answers are being reviewed by the examiner.</p>
                        @elseif($attempt && $attempt->status === \App\Enums\ExamAttemptStatus::ONGOING->value)
                            <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--text); margin-bottom: 8px;">Quiz Ongoing</h3>
                            <form action="{{ route('test_taker.course.quiz.start', [$course->id, $lesson->id]) }}" method="POST">
                                @csrf
                                <button type="submit" style="display: inline-flex; align-items: center; gap: 8px; padding: 14px 28px; border-radius: 14px; background: var(--warning); color: white; font-size: 0.88rem; font-weight: 700; text-decoration: none; border: none; cursor: pointer; box-shadow: 0 4px 16px rgba(245, 158, 11, 0.25);">
                                    Resume Quiz
                                </button>
                            </form>
                        @else
                            <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--text); margin-bottom: 8px;">Ready to test your skills?</h3>
                            <p style="font-size: 0.85rem; color: var(--muted); margin-bottom: 24px;">This quiz will test your understanding of the material.</p>
                            
                            @if($isEnrolled)
                            <form action="{{ route('test_taker.course.quiz.start', [$course->id, $lesson->id]) }}" method="POST">
                                @csrf
                                <button type="submit" style="display: inline-flex; align-items: center; gap: 8px; padding: 14px 28px; border-radius: 14px; background: var(--blue); color: white; font-size: 0.88rem; font-weight: 700; text-decoration: none; border: none; cursor: pointer; box-shadow: 0 4px 16px rgba(37,99,235,0.25);">
                                    Start Quiz
                                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </button>
                            </form>
                            @else
                            <button disabled style="display: inline-flex; align-items: center; gap: 8px; padding: 14px 28px; border-radius: 14px; background: var(--muted); color: white; font-size: 0.88rem; font-weight: 700; text-decoration: none; border: none; cursor: not-allowed;">
                                Enroll in Course to Start Quiz
                            </button>
                            @endif
                        @endif
                    @else
                        <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--text); margin-bottom: 8px;">Practice Quiz</h3>
                        <p style="font-size: 0.85rem; color: var(--muted);">The instructor has not attached a quiz to this lesson.</p>
                    @endif
                </div>
                @endif
            </div>

            {{-- MARK AS COMPLETE (For non-quiz lessons) --}}
            @if($isEnrolled && $lesson->type !== 'quiz')
                <div class="anim-in d3" style="display: flex; justify-content: flex-end; margin-bottom: 24px;">
                    @if($isCompleted)
                        <div style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 12px; background: #ecfdf5; border: 1px solid #10b981; color: #047857; font-size: 0.88rem; font-weight: 700;">
                            <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            Lesson Completed
                        </div>
                    @else
                        <form action="{{ route('test_taker.course.lesson.complete', [$course->id, $lesson->id]) }}" method="POST">
                            @csrf
                            <button id="btn-mark-complete" type="submit" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 12px; background: #10b981; color: white; border: none; cursor: pointer; font-size: 0.88rem; font-weight: 700; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25); transition: all 0.2s;">
                                <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Mark as Complete
                            </button>
                        </form>
                    @endif
                </div>
            @endif

            {{-- NAVIGATION --}}
            <div class="anim-in d3" style="display: flex; justify-content: space-between; gap: 16px; margin-bottom: 40px;">
                @if($prevLesson)
                <a href="{{ route('test_taker.course.lesson', [$course->id, $prevLesson->id]) }}"
                   style="display: flex; align-items: center; gap: 10px; padding: 14px 20px; border-radius: 14px; background: var(--surface); border: 1.5px solid var(--border); text-decoration: none; transition: all .2s; flex: 1; max-width: 50%;"
                   onmouseover="this.style.borderColor='var(--blue)'" onmouseout="this.style.borderColor='var(--border)'">
                    <svg style="width:18px;height:18px;color:var(--muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <div style="min-width: 0;">
                        <p style="font-size: 0.65rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Previous</p>
                        <p style="font-size: 0.82rem; font-weight: 700; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $prevLesson->title }}</p>
                    </div>
                </a>
                @else
                <div></div>
                @endif

                @if($nextLesson)
                    @if($isEnrolled && !$isCompleted)
                    <div style="display: flex; align-items: center; gap: 10px; padding: 14px 20px; border-radius: 14px; background: #f8fafc; border: 1.5px solid var(--border); opacity: 0.6; cursor: not-allowed; flex: 1; max-width: 50%; text-align: right; justify-content: flex-end;" title="Complete this lesson to continue">
                        <div style="min-width: 0;">
                            <p style="font-size: 0.65rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Locked</p>
                            <p style="font-size: 0.82rem; font-weight: 700; color: var(--muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Complete this lesson</p>
                        </div>
                        <svg style="width:18px;height:18px;color:var(--muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    @else
                    <a href="{{ route('test_taker.course.lesson', [$course->id, $nextLesson->id]) }}"
                       style="display: flex; align-items: center; gap: 10px; padding: 14px 20px; border-radius: 14px; background: var(--surface); border: 1.5px solid var(--border); text-decoration: none; transition: all .2s; flex: 1; max-width: 50%; text-align: right; justify-content: flex-end;"
                       onmouseover="this.style.borderColor='var(--blue)'" onmouseout="this.style.borderColor='var(--border)'">
                        <div style="min-width: 0;">
                            <p style="font-size: 0.65rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Next</p>
                            <p style="font-size: 0.82rem; font-weight: 700; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $nextLesson->title }}</p>
                        </div>
                        <svg style="width:18px;height:18px;color:var(--muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                    @endif
                @else
                <a href="{{ route('test_taker.course.show', $course->id) }}"
                   style="display: flex; align-items: center; gap: 10px; padding: 14px 20px; border-radius: 14px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none; text-decoration: none; transition: all .2s; flex: 1; max-width: 50%; text-align: right; justify-content: flex-end; box-shadow: 0 4px 12px rgba(16,185,129,0.3);"
                   onmouseover="this.style.filter='brightness(1.1)'" onmouseout="this.style.filter='brightness(1)'">
                    <div style="min-width: 0;">
                        <p style="font-size: 0.65rem; font-weight: 800; color: rgba(255,255,255,0.8); text-transform: uppercase;">Course Finished</p>
                        <p style="font-size: 0.88rem; font-weight: 800; color: white; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Complete Course</p>
                    </div>
                    <svg style="width:20px;height:20px;color:white;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </a>
                @endif
            </div>
        </div>
    </div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('btn-mark-complete');
    if (!btn) return;

    const type = "{{ $lesson->type }}";
    
    // Strict enforcement for video and audio
    if (type === 'video' || type === 'audio') {
        const mediaElement = document.querySelector(type);
        if (mediaElement) {
            btn.disabled = true;
            btn.style.opacity = '0.5';
            btn.style.cursor = 'not-allowed';
            btn.title = "Please finish the media to unlock";

            mediaElement.addEventListener('ended', function() {
                btn.disabled = false;
                btn.style.opacity = '1';
                btn.style.cursor = 'pointer';
                btn.title = "";
            });
        } else {
            // It might be a YouTube iframe, which is harder to track without API.
            // As a fallback, we unlock after a standard 10 seconds delay.
            btn.disabled = true;
            btn.style.opacity = '0.5';
            btn.style.cursor = 'not-allowed';
            btn.title = "Please watch the content (unlocks shortly)";
            setTimeout(() => {
                btn.disabled = false;
                btn.style.opacity = '1';
                btn.style.cursor = 'pointer';
                btn.title = "";
            }, 10000);
        }
    } 
    // Strict enforcement for text, pdf, link (forces scrolling)
    else {
        btn.disabled = true;
        btn.style.opacity = '0.5';
        btn.style.cursor = 'not-allowed';
        btn.title = "Please scroll to the bottom of the page to unlock";

        function checkScroll() {
            // Allow a 50px buffer from the absolute bottom
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 50) {
                btn.disabled = false;
                btn.style.opacity = '1';
                btn.style.cursor = 'pointer';
                btn.title = "";
                window.removeEventListener('scroll', checkScroll);
            }
        }
        
        window.addEventListener('scroll', checkScroll);
        // Check immediately in case content is short and already fits screen
        checkScroll();
    }
});
</script>
@endpush
@endsection
