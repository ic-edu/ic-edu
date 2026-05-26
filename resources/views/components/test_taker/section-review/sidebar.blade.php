@props(['attempt', 'section', 'flatQuestions'])

@once('sr-sidebar-styles')
@push('styles')
<style>
.sr-sidebar {
    background: white;
    border-radius: 18px;
    border: 1px solid var(--border);
    box-shadow: 0 2px 12px rgba(26,69,108,0.06);
    overflow: hidden;
}
.sr-sidebar-inner {
    padding: 20px;
}
.sr-qnum-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 6px;
    margin-top: 14px;
}
.sr-qnum {
    aspect-ratio: 1;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 800;
    text-decoration: none;
    transition: transform .15s, box-shadow .15s;
    cursor: pointer;
}
.sr-qnum:hover {
    transform: scale(1.12);
    box-shadow: 0 3px 10px rgba(0,0,0,0.15);
}
.sr-qnum--correct   { background: #dcfce7; color: #15803d; border: 1.5px solid #86efac; }
.sr-qnum--incorrect { background: #fee2e2; color: #dc2626; border: 1.5px solid #fca5a5; }
.sr-qnum--subjective{ background: #e8f3fa; color: #1e6fa5; border: 1.5px solid #aaced8; }
.sr-qnum--pending   { background: #f1f5f9; color: #94a3b8; border: 1.5px solid #e2e8f0; }
.sr-qnum--skipped   { background: #fef9ec; color: #d97706; border: 1.5px solid #fde68a; }
</style>
@endpush
@endonce

@php
    $mcCorrect   = 0;
    $mcIncorrect = 0;
    $mcSkipped   = 0;
    $subjTotal   = 0;
    $subjEarned  = 0;

    foreach ($flatQuestions as $q) {
        $ans = $q['answer'];
        if ($q['type'] === 'multiple_choice') {
            if (!$ans || !$ans->selected_option_id) { $mcSkipped++; continue; }
            $ans->selectedOption?->is_correct ? $mcCorrect++ : $mcIncorrect++;
        } else {
            $subjTotal  += $q['points'];
            $subjEarned += $ans?->score ?? 0;
        }
    }
    $totalQ = $flatQuestions->count();
@endphp

<div class="sr-sidebar">
    {{-- Section header --}}
    <div style="padding:18px 20px 14px; border-bottom:1px solid var(--border); background:linear-gradient(135deg,var(--primary),#1e5a8a);">
        <div style="font-size:9px;font-weight:800;text-transform:uppercase;letter-spacing:0.1em;color:rgba(255,255,255,0.6);margin-bottom:4px;">Reviewing</div>
        <div style="font-family:'Poppins',sans-serif;font-size:15px;font-weight:800;color:white;line-height:1.25;">{{ $section->title }}</div>
        <div style="font-size:11px;color:rgba(255,255,255,0.65);margin-top:3px;">{{ $attempt->exam->title }}</div>
    </div>

    <div class="sr-sidebar-inner">
        {{-- MC score summary --}}
        @if($mcCorrect + $mcIncorrect + $mcSkipped > 0)
        <div style="margin-bottom:16px;">
            <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:0.08em;color:var(--muted);margin-bottom:8px;">Multiple Choice</div>
            <div style="display:flex;gap:8px;">
                <div style="flex:1;text-align:center;background:#f0fdf4;border:1px solid #86efac;border-radius:10px;padding:8px 4px;">
                    <div style="font-family:'Poppins',sans-serif;font-size:1.2rem;font-weight:900;color:#15803d;line-height:1;">{{ $mcCorrect }}</div>
                    <div style="font-size:9px;font-weight:700;color:#16a34a;margin-top:2px;">Correct</div>
                </div>
                <div style="flex:1;text-align:center;background:#fef2f2;border:1px solid #fca5a5;border-radius:10px;padding:8px 4px;">
                    <div style="font-family:'Poppins',sans-serif;font-size:1.2rem;font-weight:900;color:#dc2626;line-height:1;">{{ $mcIncorrect }}</div>
                    <div style="font-size:9px;font-weight:700;color:#dc2626;margin-top:2px;">Incorrect</div>
                </div>
                @if($mcSkipped > 0)
                <div style="flex:1;text-align:center;background:#fef9ec;border:1px solid #fde68a;border-radius:10px;padding:8px 4px;">
                    <div style="font-family:'Poppins',sans-serif;font-size:1.2rem;font-weight:900;color:#d97706;line-height:1;">{{ $mcSkipped }}</div>
                    <div style="font-size:9px;font-weight:700;color:#d97706;margin-top:2px;">Skip</div>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Subjective score --}}
        @if($subjTotal > 0)
        <div style="margin-bottom:16px;">
            <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:0.08em;color:var(--muted);margin-bottom:8px;">Subjective</div>
            <div style="background:#e8f3fa;border:1px solid #aaced8;border-radius:10px;padding:10px 12px;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:11px;font-weight:700;color:var(--muted);">Total Score</span>
                <span style="font-family:'Poppins',sans-serif;font-size:14px;font-weight:900;color:#1e6fa5;">{{ $subjEarned }} / {{ $subjTotal }}</span>
            </div>
        </div>
        @endif

        {{-- Question grid --}}
        <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:0.08em;color:var(--muted);margin-bottom:2px;">Questions ({{ $totalQ }})</div>
        <div class="sr-qnum-grid">
            @foreach($flatQuestions as $q)
            @php
                $ans = $q['answer'];
                if ($q['type'] === 'multiple_choice') {
                    if (!$ans || !$ans->selected_option_id) {
                        $cls = 'sr-qnum--skipped';
                    } elseif ($ans->selectedOption?->is_correct) {
                        $cls = 'sr-qnum--correct';
                    } else {
                        $cls = 'sr-qnum--incorrect';
                    }
                } else {
                    $cls = $ans ? 'sr-qnum--subjective' : 'sr-qnum--pending';
                }
            @endphp
            <a href="#q-{{ $q['id'] }}" class="sr-qnum {{ $cls }}">{{ $q['number'] }}</a>
            @endforeach
        </div>

        {{-- Legend --}}
        <div style="margin-top:16px;display:flex;flex-direction:column;gap:5px;">
            <div style="font-size:9px;font-weight:800;text-transform:uppercase;letter-spacing:0.08em;color:var(--muted);margin-bottom:2px;">Description</div>
            <div style="display:flex;align-items:center;gap:6px;">
                <div style="width:12px;height:12px;border-radius:3px;background:#dcfce7;border:1px solid #86efac;flex-shrink:0;"></div>
                <span style="font-size:10px;color:var(--muted);">Correct</span>
            </div>
            <div style="display:flex;align-items:center;gap:6px;">
                <div style="width:12px;height:12px;border-radius:3px;background:#fee2e2;border:1px solid #fca5a5;flex-shrink:0;"></div>
                <span style="font-size:10px;color:var(--muted);">Incorrect</span>
            </div>
            <div style="display:flex;align-items:center;gap:6px;">
                <div style="width:12px;height:12px;border-radius:3px;background:#fef9ec;border:1px solid #fde68a;flex-shrink:0;"></div>
                <span style="font-size:10px;color:var(--muted);">Not answered</span>
            </div>
            <div style="display:flex;align-items:center;gap:6px;">
                <div style="width:12px;height:12px;border-radius:3px;background:#e8f3fa;border:1px solid #aaced8;flex-shrink:0;"></div>
                <span style="font-size:10px;color:var(--muted);">Subjective / Essay</span>
            </div>
        </div>
    </div>
</div>
