@push('styles')
<style>
    /* ── Marquee scroll ── */
    .marquee-track {
        animation: marquee 28s linear infinite;
    }

    @keyframes marquee {
        from { transform: translateX(0); }
        to { transform: translateX(-50%); }
    }
</style>
@endpush

{{-- MARQUEE STRIP --}}
<div class="marquee-strip overflow-hidden py-5 bg-blue-50 border-y border-blue-100">
    <div class="marquee-track flex gap-10 w-max">
        @php
        $marqueeItems = [
            'IELTS Preparation', 'TOEFL Training', 'Academic Writing', 'Public Speaking',
            'Grammar Mastery', 'Vocabulary Builder', 'Listening Skills', 'Pronunciation',
            'Business English', 'TOEIC Prep', 'Reading Skills', 'Daily Conversation',
        ];
        @endphp
        @foreach(array_merge($marqueeItems, $marqueeItems) as $item)
        <div class="marquee-item flex items-center gap-2.5 text-xs font-bold text-blue-600 uppercase tracking-widest whitespace-nowrap">
            <span class="w-[5px] h-[5px] rounded-full bg-blue-400 flex-shrink-0"></span>
            {{ $item }}
        </div>
        @endforeach
    </div>
</div>
