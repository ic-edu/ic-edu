@extends('layouts.test_taker')
@section('title', $lesson->title)

@section('content')
<div style="max-width: 1100px; margin: 0 auto; width: 100%;">

    {{-- BACK LINK --}}
    <a href="{{ route('test_taker.course.show', $course->id) }}" class="anim-in d1" style="display: inline-flex; align-items: center; gap: 6px; font-size: 0.82rem; font-weight: 700; color: var(--muted); text-decoration: none; margin-bottom: 20px; transition: color .2s;"
       onmouseover="this.style.color='var(--blue)'" onmouseout="this.style.color='var(--muted)'">
        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
        {{ $course->title }}
    </a>

    <div style="display: grid; grid-template-columns: 1fr; gap: 24px;" class="lesson-layout">

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
                    @if(str_contains($lesson->content_url ?? '', 'youtube.com') || str_contains($lesson->content_url ?? '', 'youtu.be'))
                        @php
                            preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $lesson->content_url, $matches);
                            $youtubeId = $matches[1] ?? '';
                        @endphp
                        <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}?rel=0" 
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;"
                                allowfullscreen></iframe>
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
                <div style="padding: 60px 40px; text-align: center; background: var(--base);">
                    <div style="font-size: 4rem; margin-bottom: 16px;">🔗</div>
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--text); margin-bottom: 8px;">External Resource</h3>
                    <p style="font-size: 0.85rem; color: var(--muted); margin-bottom: 24px; max-width: 400px; margin-left: auto; margin-right: auto;">
                        This lesson links to an external resource. Click below to open it in a new tab.
                    </p>
                    <a href="{{ $lesson->content_url }}" target="_blank" rel="noopener"
                       style="display: inline-flex; align-items: center; gap: 8px; padding: 14px 28px; border-radius: 14px; background: var(--blue); color: white; font-size: 0.88rem; font-weight: 700; text-decoration: none; box-shadow: 0 4px 16px rgba(37,99,235,0.25); transition: all .2s;"
                       onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                        Open Resource
                        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
                @endif

                {{-- QUIZ placeholder --}}
                @if($lesson->type === 'quiz')
                <div style="padding: 60px 40px; text-align: center; background: var(--base);">
                    <div style="font-size: 4rem; margin-bottom: 16px;">🧩</div>
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--text); margin-bottom: 8px;">Practice Quiz</h3>
                    <p style="font-size: 0.85rem; color: var(--muted);">Quiz feature coming soon!</p>
                </div>
                @endif
            </div>

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
                <a href="{{ route('test_taker.course.lesson', [$course->id, $nextLesson->id]) }}"
                   style="display: flex; align-items: center; gap: 10px; padding: 14px 20px; border-radius: 14px; background: var(--surface); border: 1.5px solid var(--border); text-decoration: none; transition: all .2s; flex: 1; max-width: 50%; text-align: right; justify-content: flex-end;"
                   onmouseover="this.style.borderColor='var(--blue)'" onmouseout="this.style.borderColor='var(--border)'">
                    <div style="min-width: 0;">
                        <p style="font-size: 0.65rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Next</p>
                        <p style="font-size: 0.82rem; font-weight: 700; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $nextLesson->title }}</p>
                    </div>
                    <svg style="width:18px;height:18px;color:var(--muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                @else
                <div></div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    @media (min-width: 1024px) {
        .lesson-layout { grid-template-columns: 1fr; }
    }
</style>
@endsection
