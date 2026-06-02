@push('styles')
<style>
    /* ── Hero doodle decorations ── */
    .hero-doodle {
        position: absolute;
        opacity: 0.18;
        pointer-events: none;
    }
</style>
@endpush

{{--  SECTION 1 -  Hero --}}
<section class="w-full bg-white pt-24 pb-16 lg:pt-36 lg:pb-24 px-[5%] overflow-hidden">
    <div class="max-w-[1140px] mx-auto flex flex-col-reverse lg:flex-row items-center justify-between gap-12">
        <div class="w-full lg:max-w-[550px] flex flex-col items-center lg:items-start text-center lg:text-left">
            <span class="inline-block bg-slate-100 text-[#2b4c7e] text-xs lg:text-sm font-semibold px-4 py-1.5 rounded-full mb-6">
                #1 English Learning Platform
            </span>
            
            <h1 class="text-3xl sm:text-4xl lg:text-[42px] font-extrabold text-[#1a365d] leading-tight mb-5 tracking-tight">
                Unlock English Skills That <br>
                <span class="text-[#55b6bb]">Move You Forward</span>
            </h1>
            
            <p class="text-sm lg:text-base text-slate-600 leading-relaxed mb-8 max-w-[500px]">
                Master in-demand English skills — from IELTS, TOEIC, TOEFL to daily conversation. Learn at your own pace, track your growth, and stay ahead.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto mb-10">
                <a href="#" class="inline-block px-7 py-3 rounded-full text-sm font-bold text-white bg-[#1d3557] hover:bg-[#14243b] transition-all text-center shadow-md">
                    Start Learning Free
                </a>
                <a href="#" class="inline-block px-7 py-3 rounded-full text-sm font-bold text-[#1d3557] bg-transparent border-2 border-[#1d3557] hover:bg-[#1d3557] hover:text-white transition-all text-center shadow-sm">
                    Browse Courses
                </a>
            </div>
            
            <div class="flex flex-col sm:flex-row items-center gap-3">
                <div class="flex -space-x-2">
                    <div class="w-8 h-8 rounded-full bg-blue-500 text-white border-2 border-white flex items-center justify-center text-[10px] font-bold">RK</div>
                    <div class="w-8 h-8 rounded-full bg-indigo-500 text-white border-2 border-white flex items-center justify-center text-[10px] font-bold">BS</div>
                    <div class="w-8 h-8 rounded-full bg-emerald-500 text-white border-2 border-white flex items-center justify-center text-[10px] font-bold">SM</div>
                    <div class="w-8 h-8 rounded-full bg-amber-500 text-white border-2 border-white flex items-center justify-center text-[10px] font-bold">DA</div>
                </div>
                <p class="text-xs lg:text-sm text-slate-500">
                    <strong class="text-slate-700">12,000+</strong> students already learning
                </p>
            </div>
        </div>
        <div class="w-full lg:flex-1 flex justify-center lg:justify-end lg:pr-8 relative z-10" data-aos="fade-left" data-aos-duration="1000">
            <div class="relative w-[260px] h-[260px] sm:w-[350px] sm:h-[350px] lg:w-[380px] lg:h-[380px] flex items-center justify-center">
                <div class="w-full h-full bg-[#1A456C] rounded-full shadow-xl"></div>
                <img src="{{ asset('assets/maskot/hero maskot.png') }}" 
                    alt="IC EDU Mascot" 
                    class="absolute w-[125%] sm:w-[130%] h-auto object-contain drop-shadow-[0_25px_35px_rgba(0,0,0,0.3)] z-20 -bottom-8 -right-4 lg:-right-8">
            </div>
        </div>
    </div>
</section>
