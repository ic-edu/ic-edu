@props(['group'])

@if($group->instruction || $group->passage_text || $group->image_path || $group->audio_path || $group->title)
<div style="background:#f8faff;border:1px solid var(--border);border-radius:14px;overflow:hidden;margin-bottom:16px;">

    {{-- Title / Instruction --}}
    @if($group->title || $group->instruction)
    <div style="padding:16px 20px;border-bottom:{{ ($group->passage_text || $group->image_path || $group->audio_path) ? '1px solid var(--border)' : 'none' }};">
        @if($group->title)
        <div style="font-family:'Poppins',sans-serif;font-size:13px;font-weight:800;color:var(--text);margin-bottom:{{ $group->instruction ? '6px' : '0' }};">{{ $group->title }}</div>
        @endif
        @if($group->instruction)
        <div style="font-size:12.5px;color:var(--muted);line-height:1.7;">{!! $group->instruction !!}</div>
        @endif
    </div>
    @endif

    {{-- Audio player --}}
    @if($group->audio_path)
    <div style="padding:14px 20px;border-bottom:{{ ($group->passage_text || $group->image_path) ? '1px solid var(--border)' : 'none' }};background:white;">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
            <div style="width:32px;height:32px;border-radius:9px;background:#edf7f8;border:1px solid #b5dde1;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="14" height="14" fill="none" stroke="var(--secondary)" stroke-width="2" viewBox="0 0 24 24"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M19.07 4.93a10 10 0 010 14.14M15.54 8.46a5 5 0 010 7.07"/></svg>
            </div>
            <span style="font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:0.06em;">Audio</span>
        </div>
        <audio controls style="width:100%;border-radius:8px;height:36px;">
            <source src="{{ Storage::url($group->audio_path) }}" type="audio/mpeg">
        </audio>
    </div>
    @endif

    {{-- Image --}}
    @if($group->image_path)
    <div style="padding:14px 20px;border-bottom:{{ $group->passage_text ? '1px solid var(--border)' : 'none' }};background:white;text-align:center;">
        <img src="{{ Storage::url($group->image_path) }}" alt="Question image"
             style="max-width:100%;max-height:360px;border-radius:10px;object-fit:contain;cursor:zoom-in;box-shadow:0 2px 12px rgba(0,0,0,0.08);"
             onclick="this.style.maxHeight=this.style.maxHeight==='none'?'360px':'none'"/>
    </div>
    @endif

    {{-- Passage text --}}
    @if($group->passage_text)
    <div style="padding:20px;max-height:420px;overflow-y:auto;">
        <div style="font-size:13px;line-height:1.85;color:#374151;">{!! $group->passage_text !!}</div>
    </div>
    @endif

</div>
@endif
