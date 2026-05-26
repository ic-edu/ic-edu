@props([
    'label',
    'color',
    'bg',
    'border',
    'score',
    'sectionMax',
    'secPct',
    'imgSrc'    => null,
    'previewUrl',
    'animDelay' => '0.05s',
])

@once('sec-portrait-styles')
@push('styles')
<style>
.sec-portrait-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 18px;
}
.sec-portrait-card {
    background: white;
    border-radius: 18px;
    border: 1px solid var(--border);
    box-shadow: 0 2px 12px rgba(26,69,108,0.05);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform .2s, box-shadow .2s, border-color .2s;
}
.sec-portrait-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(26,69,108,0.11);
    border-color: var(--secondary);
}
.sec-portrait-img {
    height: 200px;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: flex-end;
    justify-content: center;
}
.sec-preview-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 10px 18px;
    border-radius: 10px;
    border: 1.5px solid var(--sec-bdr);
    background: var(--sec-bg);
    color: var(--sec-col);
    font-size: 12px;
    font-weight: 800;
    text-decoration: none;
    transition: background .2s, color .2s, border-color .2s, transform .15s;
    letter-spacing: 0.01em;
    width: 100%;
    justify-content: center;
}
.sec-preview-btn:hover {
    background: var(--sec-col);
    color: white;
    border-color: var(--sec-col);
    transform: translateY(-1px);
}
@media (max-width: 640px) {
    .sec-portrait-grid { grid-template-columns: 1fr; }
}
</style>
@endpush
@endonce

<div class="sec-portrait-card anim-in" style="animation-delay:{{ $animDelay }};">

    {{-- IMAGE AREA --}}
    <div class="sec-portrait-img" style="background:{{ $bg }};">
        <div style="position:absolute;inset:0;opacity:0.05;background-image:radial-gradient(circle,{{ $color }} 1px,transparent 1px);background-size:16px 16px;pointer-events:none;"></div>
        <div style="position:absolute;top:-24px;right:-24px;width:100px;height:100px;border-radius:50%;background:{{ $color }};opacity:0.08;pointer-events:none;"></div>

        <div style="position:absolute;top:12px;left:12px;z-index:2;background:{{ $color }};color:white;font-size:9px;font-weight:800;letter-spacing:0.07em;text-transform:uppercase;padding:3px 10px;border-radius:99px;">
            {{ $label }}
        </div>


        @if($imgSrc)
        <img src="{{ $imgSrc }}" alt="{{ $label }}"
             style="position:relative;z-index:2;max-height:220px;max-width:95%;object-fit:contain;object-position:bottom;filter:drop-shadow(0 6px 14px rgba(0,0,0,0.12));"/>
        @endif
    </div>

    {{-- CONTENT --}}
    <div style="padding:16px 18px 18px;display:flex;flex-direction:column;flex:1;">
        <div style="margin-bottom:14px;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                <span style="font-size:10.5px;font-weight:700;color:var(--muted);">Score</span>
                <span style="font-size:10.5px;font-weight:800;color:{{ $color }};">{{ number_format($secPct, 1) }}%</span>
            </div>
            <div style="height:7px;border-radius:99px;background:#e8eef8;overflow:hidden;">
                <div style="height:100%;border-radius:99px;width:{{ $secPct }}%;background:{{ $color }};transition:width 1.3s cubic-bezier(.34,1.2,.64,1);"></div>
            </div>
        </div>

        <div style="flex:1;"></div>

        <a href="{{ $previewUrl }}" class="sec-preview-btn" style="--sec-col:{{ $color }};--sec-bg:{{ $bg }};--sec-bdr:{{ $border }};">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            Preview
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
        </a>
    </div>
</div>
