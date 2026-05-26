@props(['isPassed' => null])

@if($isPassed === true)
<div style="display:inline-flex; align-items:center; gap:10px; background:#f0fdf4; border:1.5px solid #86efac; border-radius:16px; padding:12px 20px; box-shadow:0 4px 16px rgba(34,197,94,0.1);">
    <div style="width:32px; height:32px; border-radius:10px; background:linear-gradient(135deg,#22c55e,#16a34a); display:flex; align-items:center; justify-content:center; box-shadow:0 4px 10px rgba(34,197,94,0.3); flex-shrink:0;">
        <svg width="15" height="15" fill="none" stroke="white" stroke-width="3" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
    </div>
    <div>
        <div style="font-family:'Poppins',sans-serif; font-size:12px; font-weight:800; color:#15803d; text-transform:uppercase; letter-spacing:0.07em; line-height:1.2;">Lulus</div>
        <div style="font-size:11px; color:#4ade80; font-weight:600; line-height:1.2;">Congratulations! 🎉</div>
    </div>
</div>
@elseif($isPassed === false)
<div style="display:inline-flex; align-items:center; gap:10px; background:#fef2f2; border:1.5px solid #fca5a5; border-radius:16px; padding:12px 20px; box-shadow:0 4px 16px rgba(239,68,68,0.1);">
    <div style="width:32px; height:32px; border-radius:10px; background:linear-gradient(135deg,#ef4444,#dc2626); display:flex; align-items:center; justify-content:center; box-shadow:0 4px 10px rgba(239,68,68,0.3); flex-shrink:0;">
        <svg width="15" height="15" fill="none" stroke="white" stroke-width="3" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg>
    </div>
    <div>
        <div style="font-family:'Poppins',sans-serif; font-size:12px; font-weight:800; color:#dc2626; text-transform:uppercase; letter-spacing:0.07em; line-height:1.2;">Tidak Lulus</div>
        <div style="font-size:11px; color:#f87171; font-weight:600; line-height:1.2;">Keep practicing!</div>
    </div>
</div>
@endif
