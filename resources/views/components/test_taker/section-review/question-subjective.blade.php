@props(['question', 'answer', 'number'])

@php
    $typeLabels = [
        'short_answer'  => 'Short Answer',
        'essay'         => 'Essay',
        'record'        => 'Audio Recording',
        'audio_record'  => 'Audio Recording',
    ];
    $typeLabel = $typeLabels[$question->type] ?? ucfirst($question->type);
    $score     = $answer?->score;
    $hasScore  = $score !== null;
    $feedback  = $answer?->feedback;
    $hasAnswer = $answer && ($answer->answer_text || $answer->essay_content || $answer->audio_answer_path);
@endphp

<div class="sr-question-card" id="q-{{ $question->id }}">

    {{-- Header --}}
    <div class="sr-q-header" style="background:#e8f3fa;">
        <div style="display:flex;align-items:center;gap:10px;">
            <div style="width:30px;height:30px;border-radius:8px;background:#1e6fa5;color:white;font-family:'Poppins',sans-serif;font-size:12px;font-weight:900;display:flex;align-items:center;justify-content:center;flex-shrink:0;">{{ $number }}</div>
            <div>
                <span style="font-size:11px;font-weight:800;color:#1e6fa5;">{{ $typeLabel }}</span>
                @if(!$hasAnswer)
                <span style="font-size:10px;color:#d97706;margin-left:6px;font-weight:700;">— Not answered</span>
                @endif
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:6px;background:white;border:1.5px solid #aaced8;border-radius:8px;padding:5px 12px;">
            @if($hasScore)
            <span style="font-family:'Poppins',sans-serif;font-size:13px;font-weight:900;color:#1e6fa5;">{{ $score }}</span>
            <span style="font-size:11px;color:var(--muted);">/ {{ $question->points }}</span>
            @else
            <span style="font-size:11px;font-weight:700;color:var(--muted);">Not graded</span>
            @endif
        </div>
    </div>

    <div class="sr-q-body">

        {{-- Question media --}}
        @if($question->audio_path)
        <div style="margin-bottom:14px;">
            <div style="font-size:10px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:6px;">Question Audio</div>
            <audio controls style="width:100%;border-radius:8px;height:36px;">
                <source src="{{ Storage::url($question->audio_path) }}" type="audio/mpeg">
            </audio>
        </div>
        @endif
        @if($question->image_path)
        <div style="margin-bottom:14px;text-align:center;">
            <img src="{{ Storage::url($question->image_path) }}" alt="Question image"
                 style="max-width:100%;max-height:240px;border-radius:10px;object-fit:contain;"/>
        </div>
        @endif

        {{-- Question text --}}
        @if($question->question_text)
        <div style="font-size:14px;line-height:1.75;color:var(--text);margin-bottom:18px;font-weight:500;">{!! $question->question_text !!}</div>
        @endif

        {{-- User's answer --}}
        <div style="border-top:1px solid var(--border);padding-top:16px;">
            <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:0.08em;color:var(--muted);margin-bottom:10px;">Your Answer</div>

            @if(!$hasAnswer)
            <div style="background:#fef9ec;border:1px solid #fde68a;border-radius:10px;padding:14px 16px;font-size:13px;color:#d97706;font-weight:600;text-align:center;">
                This question was not answered
            </div>

            @elseif($question->type === 'record' || $question->type === 'audio_record')
            @if($answer->audio_answer_path)
            <div style="background:#f8faff;border:1px solid var(--border);border-radius:10px;padding:14px 16px;">
                <div style="font-size:11px;font-weight:600;color:var(--muted);margin-bottom:8px;">Your audio recording:</div>
                <audio controls style="width:100%;border-radius:8px;height:36px;">
                    <source src="{{ Storage::url($answer->audio_answer_path) }}" type="audio/mpeg">
                </audio>
            </div>
            @else
            <div style="background:#fef9ec;border:1px solid #fde68a;border-radius:10px;padding:14px 16px;font-size:13px;color:#d97706;text-align:center;">
                No recording found
            </div>
            @endif

            @elseif($question->type === 'essay')
            <div style="background:#f8faff;border:1px solid var(--border);border-radius:10px;padding:16px;font-size:13px;line-height:1.8;color:var(--text);white-space:pre-wrap;min-height:80px;">{{ $answer->essay_content ?: '—' }}</div>

            @else
            <div style="background:#f8faff;border:1px solid var(--border);border-radius:10px;padding:12px 16px;font-size:13px;color:var(--text);font-weight:500;">{{ $answer->answer_text ?: '—' }}</div>
            @endif
        </div>

        {{-- Examiner feedback --}}
        @if($hasScore || $feedback)
        <div style="margin-top:16px;border-top:1px solid var(--border);padding-top:16px;">
            <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:0.08em;color:var(--muted);margin-bottom:10px;">Examiner Grading</div>

            <div style="display:flex;align-items:center;gap:10px;margin-bottom:{{ $feedback ? '12px' : '0' }};">
                <div style="display:flex;align-items:center;gap:6px;background:#e8f3fa;border:1.5px solid #aaced8;border-radius:10px;padding:8px 16px;">
                    <svg width="13" height="13" fill="none" stroke="#1e6fa5" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                    <span style="font-family:'Poppins',sans-serif;font-size:15px;font-weight:900;color:#1e6fa5;">{{ $score ?? '?' }}</span>
                    <span style="font-size:11px;color:var(--muted);">/ {{ $question->points }} pts</span>
                </div>
                @if(!$hasScore)
                <span style="font-size:11px;color:var(--muted);">Not yet graded by examiner</span>
                @endif
            </div>

            @if($feedback)
            <div style="background:#f8faff;border-left:3px solid #6FAFB5;border-radius:0 10px 10px 0;padding:12px 16px;">
                <div style="font-size:10px;font-weight:700;color:var(--secondary);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:5px;">Feedback</div>
                <div style="font-size:13px;line-height:1.7;color:var(--text);">{{ $feedback }}</div>
            </div>
            @endif
        </div>
        @endif

    </div>
</div>
