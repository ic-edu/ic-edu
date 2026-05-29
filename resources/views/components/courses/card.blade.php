@props([
    'tag' => null,
    'tagColor' => 'bg-indigo-700 text-white',
    'image',
    'rating',
    'students',
    'title',
    'instructor',
    'duration',
    'level',
    'price'
])

<div class="course-card bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full group"
    data-price="{{ $price }}" data-duration="{{ $duration }}">
    <div class="relative overflow-hidden aspect-video bg-slate-100">
        @if($tag)
            <span class="absolute top-3 left-3 {{ $tagColor }} text-[10px] font-black px-2.5 py-1 rounded-md uppercase tracking-wider z-10">{{ $tag }}</span>
        @endif
        <img src="{{ asset($image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $title }}">
    </div>
    <div class="p-5 flex flex-col flex-grow">
        <div class="flex items-center gap-1 mb-2 text-amber-500 font-bold text-xs">
            <span>★ {{ $rating }}</span> <span class="text-slate-400 font-normal">({{ $students }} students)</span>
        </div>
        <h3 class="text-xl font-black text-slate-800 leading-tight mb-1 group-hover:text-blue-600 transition-colors">{{ $title }}</h3>
        <p class="text-xs font-semibold text-slate-400 mb-6">{{ $instructor }}</p>

        <div class="mt-auto mb-6 flex flex-wrap gap-2">
            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-md">🕒 {{ $duration }} hours</span>
            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-md">📊 {{ $level }}</span>
        </div>
        <div class="flex items-center justify-between pt-3 border-t border-slate-100">
            @if($price == 0 || strtolower($price) === 'free')
                <span class="text-xl font-black text-indigo-700">Free</span>
            @else
                <span class="text-xl font-black text-slate-800">${{ $price }}</span>
            @endif
        </div>
    </div>
</div>
