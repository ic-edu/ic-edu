@extends('layouts.user')

@section('title', $examType->name . ' Preparation')

@section('content')
<section class="w-full relative pt-40 pb-32 flex flex-col items-center justify-center overflow-hidden select-none bg-gradient-to-br from-slate-50 via-slate-100 via-40% to-[#1A456C] text-center">
    <div class="max-w-[800px] mx-auto px-[5%] relative z-10 text-white" data-aos="fade-up" data-aos-duration="1000">
        <h1 class="font-sans font-extrabold text-4xl md:text-5xl lg:text-[3rem] mb-6 leading-tight drop-shadow-sm">
            {!! nl2br(e($examType->page_content['hero_title'])) !!}
        </h1>
        <p class="font-sans text-base md:text-lg mb-10 font-medium opacity-95 leading-relaxed max-w-[700px] mx-auto">
            {{ $examType->page_content['hero_subtitle'] }}
        </p>
        <div>
            <a href="{{ route($examType->page_content['practice_route'] ?? 'test_taker.exam.index') }}" class="inline-block bg-[#1a3a5a] text-white font-bold px-12 py-3.5 rounded-full hover:bg-[#152e4a] transition-all shadow-lg text-sm md:text-base">
                Practice Now
            </a>
        </div>
    </div>

    <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-[0]">
        <svg class="relative block w-[calc(100%+1.3px)] h-[50px] md:h-[80px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C59.71,118.06,155.43,109.84,233.15,92.83c83.15-18.17,159.95-46.06,242.21-59.5Z" fill="#ffffff"></path>
        </svg>
    </div>
</section>

<section class="w-full bg-white pt-16 pb-32 relative">
    <div class="max-w-[1000px] mx-auto px-[5%]">
        
        <h2 class="text-4xl font-black text-center text-[#1a3a5a] mb-16 drop-shadow-sm">{{ $examType->page_content['what_is_title'] }}</h2>

        <div class="relative w-full max-w-[600px] h-[400px] mx-auto mb-20">
            <div class="absolute top-0 left-4 md:left-10 w-[300px] h-[300px] rounded-full overflow-hidden bg-slate-200 border-[6px] border-white shadow-xl z-10 flex items-center justify-center">
                <img src="{{ asset('assets/test1.png') }}" alt="Students" class="w-full h-full object-cover text-slate-400 text-sm font-bold text-center">
            </div>
            
            <div class="absolute bottom-0 right-4 md:right-10 w-[300px] h-[300px] rounded-full overflow-hidden bg-slate-300 border-[6px] border-white shadow-xl z-20 flex items-center justify-center">
                <img src="{{ asset('assets/test2.png') }}" alt="Student" class="w-full h-full object-cover text-slate-500 text-sm font-bold text-center">
            </div>

            {{-- Floating bubbles --}}
            @if(isset($examType->page_content['bubbles']))
                @php
                    $bubblePositions = [
                        0 => 'top-[5%] right-[30%]',
                        1 => 'top-[35%] right-[-7%]',
                        2 => 'top-[40%] left-[-10%]',
                        3 => 'bottom-[2%] left-[30%]'
                    ];
                @endphp
                @foreach($examType->page_content['bubbles'] as $index => $bubble)
                    @if(isset($bubblePositions[$index]))
                        @php
                            $bubbleText = is_array($bubble) ? ($bubble['bubble'] ?? '') : $bubble;
                        @endphp
                        <div class="absolute {{ $bubblePositions[$index] }} z-30 bg-[#1a3a5a] text-white px-10 py-4 rounded-full font-bold shadow-lg text-sm">{{ $bubbleText }}</div>
                    @endif
                @endforeach
            @endif
        </div>

        <div class="text-[#1a3a5a] font-extrabold text-[13px] md:text-[15px] leading-relaxed mb-10 text-justify">
            @foreach($examType->page_content['what_is_description'] as $para)
                @php
                    $paraText = is_array($para) ? ($para['paragraph'] ?? '') : $para;
                @endphp
                <p class="mb-4">{{ $paraText }}</p>
            @endforeach
        </div>

        <ul class="space-y-4 text-[13px] md:text-[15px] text-[#1a3a5a] font-extrabold mb-24">
            @php
                $featureIcons = [
                    0 => '<svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                    1 => '<svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>',
                    2 => '<svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>',
                    3 => '<svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>',
                    4 => '<svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>'
                ];
            @endphp
            @foreach($examType->page_content['features'] as $index => $feature)
                @php
                    $featureText = is_array($feature) ? ($feature['feature'] ?? '') : $feature;
                @endphp
                <li class="flex items-center gap-4">
                    {!! $featureIcons[$index] ?? $featureIcons[0] !!}
                    <span>{{ $featureText }}</span>
                </li>
            @endforeach
        </ul>

        <div class="bg-[#e4eff1] rounded-[2.5rem] p-8 md:p-14 flex flex-col md:flex-row gap-12 items-start shadow-sm border border-[#d3e3e6]">
            
            <div class="w-full md:w-1/3 flex flex-col items-center justify-between">
                <h3 class="text-[1.8rem] font-black text-[#1a3a5a] w-full text-center md:text-left mb-8">{{ $examType->name }} Test</h3>
                
                <div class="w-full max-w-[220px] mb-10">
                    <img src="{{ asset('assets/maskot/owltest.png') }}" alt="Owl Mascot" class="w-full h-auto object-contain">
                </div>
                
                <a href="{{ route($examType->page_content['practice_route'] ?? 'test_taker.exam.index') }}" class="bg-[#1a3a5a] text-white font-bold px-12 py-3 rounded-full hover:bg-[#152e4a] transition-all shadow-md text-sm">
                    Try Now
                </a>
            </div>
            
            <div class="w-full md:w-2/3 flex flex-col gap-6 pt-2">
                @foreach($examType->page_content['accordion_items'] as $index => $item)
                    <div class="border-b-[3px] border-[#1a3a5a]/10 pb-5 accordion-item">
                        <div class="flex items-center justify-between text-[#1a3a5a] mb-2 cursor-pointer select-none" onclick="toggleAccordion(this)">
                            <h4 class="text-[1.1rem] md:text-[1.25rem] font-black">{{ $item['title'] }}</h4>
                            <span class="text-{{ $loop->first ? '3' : '2' }}xl font-black leading-none accordion-icon">{{ $loop->first ? '-' : '+' }}</span>
                        </div>
                        
                        <p class="text-xs md:text-sm font-extrabold text-[#1a3a5a]/80 mb-4">{{ $item['subtitle'] }}</p>
                        
                        <div class="accordion-content {{ $loop->first ? '' : 'hidden' }} overflow-hidden transition-all duration-300">
                            <ul class="space-y-4 text-xs md:text-[13px] text-[#1a3a5a] leading-relaxed">
                                @foreach($item['bullets'] as $bullet)
                                    @php
                                        $bulletText = is_array($bullet) ? ($bullet['bullet'] ?? '') : $bullet;
                                    @endphp
                                    <li class="flex items-start gap-2.5">
                                        <span class="text-[#1a3a5a] font-black mt-0.5">•</span>
                                        <p>{!! preg_replace('/^([^:]+):/', '<span class="font-black">$1:</span>', e($bulletText)) !!}</p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function toggleAccordion(headerElement) {
        const parent = headerElement.closest('.accordion-item');
        const content = parent.querySelector('.accordion-content');
        const icon = headerElement.querySelector('.accordion-icon');

        const isHidden = content.classList.contains('hidden');

        if (isHidden) {
            content.classList.remove('hidden');
            icon.textContent = '-';
            icon.classList.remove('text-2xl');
            icon.classList.add('text-3xl'); 
        } else {
            content.classList.add('hidden');
            icon.textContent = '+';
            icon.classList.remove('text-3xl');
            icon.classList.add('text-2xl');
        }
    }
</script>
@endpush
@endsection
