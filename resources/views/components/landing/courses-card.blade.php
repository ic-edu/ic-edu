<section class="py-20 overflow-hidden bg-white">
    <div class="max-w-[1400px] mx-auto px-[5%] md:pl-[7%] flex flex-col gap-0 items-start">
        
        <div class="max-w-3xl mx-auto w-full text-center mb-12" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-black text-[#1a3a5a] mb-6 leading-tight tracking-tight">
                Learn smarter through the <br class="hidden md:block"> IC EDU LMS
            </h2>
            <p class="text-slate-500 text-sm md:text-base leading-relaxed font-medium">
                Our Learning Management System is designed to make English learning more flexible, interactive, and measurable. Access lessons, complete exercises, and track your progress in one place.
            </p>
        </div>

        @php
        // Tambahin 'padding' biar panjang pil-nya beda-beda secara acak
        $services = [
            [
                'title'   => 'Listening', 
                'color'   => '#1a3a5a', 
                'text'    => 'text-white', 
                'padding' => 'pr-[150px] md:pr-[420px]', // Paling panjang
                'desc'    => 'Focus on workplace communication skills, including business conversations and emails.'
            ],
            [
                'title'   => 'Writing', 
                'color'   => '#6b9b9b', 
                'text'    => 'text-[#1a3a5a]', 
                'padding' => 'pr-[100px] md:pr-[300px]', // Sedang
                'desc'    => 'Designed for academic and international purposes, covering listening, reading, writing, and speaking.'
            ],
            [
                'title'   => 'Speaking', 
                'color'   => '#c4c4c4', 
                'text'    => 'text-[#1a3a5a]', 
                'padding' => 'pr-[120px] md:pr-[360px]', // Agak panjang
                'desc'    => 'Focuses on academic English used in universities, including lectures and campus discussions.'
            ],
            [
                'title'   => 'Grammar', 
                'color'   => '#2b4c7e', 
                'text'    => 'text-white',
                'padding' => 'pr-[80px] md:pr-[240px]', // Paling pendek, tapi ga buntet
                'desc'    => 'A flexible learning system to track progress, access materials, and improve skills at your own pace.'
            ],
        ];
        @endphp

        @foreach($services as $service)
        <div class="group flex items-center w-fit cursor-pointer">
            
            <div style="background-color: {{ $service['color'] }}" 
                 class="rounded-full flex items-center pl-8 py-4 md:pl-12 md:py-6 {{ $service['padding'] }} transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)]">
                
                <h2 class="text-[40px] md:text-[50px] font-black {{ $service['text'] }} tracking-tighter whitespace-nowrap leading-none mt-1">
                    {{ $service['title'] }}
                </h2>
                
                <div class="overflow-hidden max-w-0 opacity-0 group-hover:max-w-[280px] md:group-hover:max-w-[340px] group-hover:opacity-100 group-hover:ml-8 transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)]">
                    <p class="{{ $service['text'] }} text-sm md:text-[16px] font-medium w-[240px] md:w-[320px] leading-snug opacity-90">
                        {{ $service['desc'] }}
                    </p>
                </div>
            </div>

            <div class="overflow-hidden max-w-0 opacity-0 group-hover:max-w-[120px] group-hover:opacity-100 group-hover:ml-4 transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)]">
                
                <div style="background-color: {{ $service['color'] }}" 
                     class="w-16 h-16 md:w-[100px] md:h-[100px] rounded-full flex items-center justify-center transform -translate-x-full group-hover:translate-x-0 transition-transform duration-700 delay-75 hover:brightness-110">
                    
                    <svg class="w-8 h-8 md:w-12 md:h-12 {{ $service['text'] }} transform transition-transform duration-300 group-hover:rotate-12" fill="none" stroke="currentColor" stroke-width="3.5" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25" />
                    </svg>
                </div>
            </div>

        </div>
        @endforeach

    </div>
</section>