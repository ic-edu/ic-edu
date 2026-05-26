@props(['question', 'answer', 'number'])

@php
    $selected    = $answer?->selected_option_id;
    $isCorrect   = $answer?->selectedOption?->is_correct ?? false;
    $skipped     = !$selected;
    $score       = $answer?->score ?? 0;

    if ($skipped)       { $status = 'skipped';   $statusColor = '#d97706'; $statusBg = '#fef9ec'; $statusBorder = '#fde68a'; }
    elseif ($isCorrect) { $status = 'correct';   $statusColor = '#15803d'; $statusBg = '#f0fdf4'; $statusBorder = '#86efac'; }
    else                { $status = 'incorrect'; $statusColor = '#dc2626'; $statusBg = '#fef2f2'; $statusBorder = '#fca5a5'; }

    $statusLabels = ['correct' => '✓ Correct', 'incorrect' => '✗ Incorrect', 'skipped' => '— Not answered'];
    $optionLabels = ['A','B','C','D','E'];
@endphp

@once('sr-mc-styles')
@push('styles')
<style>
.sr-question-card {
    background: white;
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 16px;
    transition: box-shadow .2s;
}
.sr-question-card:hover { box-shadow: 0 4px 20px rgba(26,69,108,0.08); }
.sr-q-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 18px;
    border-bottom: 1px solid var(--border);
}
.sr-q-body { padding: 18px; }
.sr-option {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 11px 14px;
    border-radius: 10px;
    border: 1.5px solid transparent;
    margin-bottom: 8px;
    transition: background .15s;
    cursor: default;
}
.sr-option:last-child { margin-bottom: 0; }
.sr-option--neutral  { background: #f8faff; border-color: var(--border); }
.sr-option--correct  { background: #f0fdf4; border-color: #86efac; }
.sr-option--wrong    { background: #fef2f2; border-color: #fca5a5; }
.sr-option-letter {
    width: 26px;
    height: 26px;
    border-radius: 7px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 800;
    flex-shrink: 0;
    margin-top: 1px;
}
.sr-option-text {
    font-size: 13px;
    line-height: 1.6;
    flex: 1;
}
</style>
@endpush
@endonce

<div class="sr-question-card" id="q-{{ $question->id }}">

    {{-- Header: number + status + score --}}
    <div class="sr-q-header" style="background:{{ $statusBg }};">
        <div style="display:flex;align-items:center;gap:10px;">
            <div style="width:30px;height:30px;border-radius:8px;background:var(--primary);color:white;font-family:'Poppins',sans-serif;font-size:12px;font-weight:900;display:flex;align-items:center;justify-content:center;flex-shrink:0;">{{ $number }}</div>
            <div>
                <span style="font-size:11px;font-weight:800;color:{{ $statusColor }};">{{ $statusLabels[$status] }}</span>
                <span style="font-size:10px;color:var(--muted);margin-left:6px;">Multiple Choice</span>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:6px;background:white;border:1.5px solid {{ $statusBorder }};border-radius:8px;padding:5px 12px;">
            <span style="font-family:'Poppins',sans-serif;font-size:13px;font-weight:900;color:{{ $statusColor }};">{{ $score }}</span>
            <span style="font-size:11px;color:var(--muted);">/ {{ $question->points }}</span>
        </div>
    </div>

    <div class="sr-q-body">

        {{-- Question media --}}
        @if($question->audio_path)
        <div style="margin-bottom:14px;">
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
        <div style="font-size:14px;line-height:1.75;color:var(--text);margin-bottom:16px;font-weight:500;">{!! $question->question_text !!}</div>
        @endif

        {{-- Options --}}
        <div>
            @foreach($question->options as $i => $option)
            @php
                $isSelected   = $option->id === $selected;
                $isOptCorrect = $option->is_correct;

                if ($isOptCorrect && $isSelected)  $cls = 'sr-option--correct';   // user correct
                elseif ($isOptCorrect)             $cls = 'sr-option--correct';   // show correct answer
                elseif ($isSelected && !$isCorrect)$cls = 'sr-option--wrong';     // user wrong
                else                               $cls = 'sr-option--neutral';

                $letterBg = match(true) {
                    $isOptCorrect => '#22c55e',
                    $isSelected && !$isOptCorrect => '#ef4444',
                    default => '#e2e8f0',
                };
                $letterColor = ($isOptCorrect || ($isSelected && !$isOptCorrect)) ? 'white' : '#64748b';
            @endphp
            <div class="sr-option {{ $cls }}">
                <div class="sr-option-letter" style="background:{{ $letterBg }};color:{{ $letterColor }};">{{ $optionLabels[$i] ?? chr(65+$i) }}</div>
                <div class="sr-option-text" style="color:{{ $isOptCorrect ? '#15803d' : ($isSelected && !$isOptCorrect ? '#dc2626' : 'var(--text)') }}; font-weight:{{ ($isOptCorrect || $isSelected) ? '600' : '400' }};">
                    {!! $option->option_text !!}
                    @if($isOptCorrect && !$isSelected)
                    <span style="display:inline-block;margin-left:8px;font-size:10px;font-weight:800;color:#15803d;background:#dcfce7;border:1px solid #86efac;padding:1px 7px;border-radius:99px;">Correct Answer</span>
                    @elseif($isSelected && $isOptCorrect)
                    <span style="display:inline-block;margin-left:8px;font-size:10px;font-weight:800;color:#15803d;background:#dcfce7;border:1px solid #86efac;padding:1px 7px;border-radius:99px;">✓ Your Choice</span>
                    @elseif($isSelected && !$isOptCorrect)
                    <span style="display:inline-block;margin-left:8px;font-size:10px;font-weight:800;color:#dc2626;background:#fee2e2;border:1px solid #fca5a5;padding:1px 7px;border-radius:99px;">✗ Your Choice</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
