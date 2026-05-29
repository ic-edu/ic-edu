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
    'iteration',
    'animDelay' => '0.05s',
])

@once('sec-landscape-styles')
@push('styles')
<style>
.sec-landscape-card {
    display: flex;
    background: white;
    border-radius: 20px;
    border: 1px solid var(--border);
    box-shadow: 0 4px 20px rgba(26,69,108,0.06);
    overflow: hidden;
    transition: transform .2s, box-shadow .2s;
    min-height: 240px;
}
.sec-landscape-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 36px rgba(26,69,108,0.12);
}
.sec-landscape-img {
    width: 42%;
    flex-shrink: 0;
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
@media (max-width: 900px) {
    .sec-landscape-card { flex-direction: column; }
    .sec-landscape-img  { width: 100%; height: 220px; }
}
</style>
@endpush
@endonce

<div class="sec-landscape-card anim-in" style="animation-delay:{{ $animDelay }};">

    {{-- IMAGE PANEL --}}
    <div class="sec-landscape-img" style="background:{{ $bg }};">
        <div style="position:absolute;inset:0;opacity:0.06;background-image:radial-gradient(circle,{{ $color }} 1px,transparent 1px);background-size:18px 18px;pointer-events:none;"></div>
        <div style="position:absolute;top:-30px;right:-30px;width:130px;height:130px;border-radius:50%;background:{{ $color }};opacity:0.08;pointer-events:none;"></div>
        <div style="position:absolute;bottom:-20px;left:-20px;width:80px;height:80px;border-radius:50%;background:{{ $color }};opacity:0.06;pointer-events:none;"></div>

        <div style="position:absolute;top:16px;left:16px;z-index:2;background:{{ $color }};color:white;font-size:10px;font-weight:800;letter-spacing:0.07em;text-transform:uppercase;padding:4px 12px;border-radius:99px;">
            Section {{ $iteration }}
        </div>

        @if($imgSrc)
        <img src="{{ $imgSrc }}" alt="{{ $label }}"
             style="position:relative;z-index:2;max-height:280px;max-width:95%;object-fit:contain;object-position:bottom;filter:drop-shadow(0 8px 20px rgba(0,0,0,0.15));"/>
        @endif
    </div>

    {{-- CONTENT PANEL --}}
    <div style="flex:1;padding:28px 32px;display:flex;flex-direction:column;justify-content:center;">
        <p style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:0.1em;color:{{ $color }};margin:0 0 4px;">{{ $label }}</p>
        <p style="font-size:0.8rem;color:var(--muted);margin:0 0 20px;font-weight:500;">Section score breakdown</p>


        <div style="margin-bottom:24px;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:7px;">
                <span style="font-size:11px;font-weight:700;color:var(--muted);">Achievement</span>
                <span style="font-size:11px;font-weight:800;color:{{ $color }};">{{ number_format($secPct, 1) }}%</span>
            </div>
            <div style="height:10px;border-radius:99px;background:#e8eef8;overflow:hidden;">
                <div style="height:100%;border-radius:99px;width:{{ $secPct }}%;background:linear-gradient(90deg,{{ $color }},{{ $border }});transition:width 1.3s cubic-bezier(.34,1.2,.64,1);"></div>
            </div>
        </div>

        <a href="{{ $previewUrl }}" class="sec-preview-btn" style="--sec-col:{{ $color }};--sec-bg:{{ $bg }};--sec-bdr:{{ $border }};">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            Preview Section
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
        </a>
    </div>
</div>
