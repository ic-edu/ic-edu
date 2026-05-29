@props(['score', 'maxScore', 'pct'])
@php
    $r    = 52;
    $circ = 2 * M_PI * $r;
    $dash = $circ * (1 - ($pct / 100));
@endphp

<div style="padding:32px 36px; display:flex; flex-direction:column; align-items:center; justify-content:center; background:linear-gradient(160deg,#f8faff 0%,#f0f5fb 100%); border-right:1px solid var(--border); min-width:220px;">
    <p style="font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.1em; color:var(--muted); margin:0 0 16px; text-align:center;">Final Score</p>

    <div style="position:relative; width:128px; height:128px; margin-bottom:16px;">
        <svg width="128" height="128" viewBox="0 0 128 128" style="transform:rotate(-90deg); overflow:visible;">
            <circle cx="64" cy="64" r="{{ $r }}" fill="none" stroke="#e8eef8" stroke-width="11"/>
            <circle cx="64" cy="64" r="{{ $r }}" fill="none"
                stroke="url(#score-ring-grad)"
                stroke-width="11"
                stroke-linecap="round"
                stroke-dasharray="{{ $circ }}"
                stroke-dashoffset="{{ $dash }}"
                style="transition:stroke-dashoffset 1.4s cubic-bezier(.34,1.2,.64,1);"/>
            <defs>
                <linearGradient id="score-ring-grad" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#1A456C"/>
                    <stop offset="100%" stop-color="#6FAFB5"/>
                </linearGradient>
            </defs>
        </svg>
        <div style="position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center;">
            <span style="font-family:'Poppins',sans-serif; font-size:2rem; font-weight:900; color:var(--text); line-height:1; letter-spacing:-0.05em;">{{ number_format($score, 0) }}</span>
            <span style="font-size:10px; font-weight:700; color:var(--muted); margin-top:2px;">/ {{ number_format($maxScore, 0) }}</span>
        </div>
    </div>

    <div style="background:var(--primary); color:white; font-size:11px; font-weight:800; padding:5px 16px; border-radius:99px; letter-spacing:0.04em;">
        {{ number_format($pct, 1) }}%
    </div>
</div>
