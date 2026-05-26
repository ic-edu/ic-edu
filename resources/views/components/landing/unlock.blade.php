@push('styles')
<style>
    .rotating-earth {
        animation: rotateEarth 60s linear infinite;
        transform-origin: center;
    }
    @keyframes rotateEarth {
        from { transform: rotate(0deg); }
        to   { transform: rotate(360deg); }
    }
    
    .floating-cloud {
        animation: cloudFloat 6s ease-in-out infinite;
    }
    @keyframes cloudFloat {
        0%, 100% { transform: translateY(0); }
        50%      { transform: translateY(-20px); }
    }
    .earth-section, .earth-wrap {
        overflow: hidden;
    }
</style>
@endpush

<section class="earth-section relative bg-white pt-24 pb-0 text-center">
    <div class="hidden sm:block absolute top-[10%] left-[8%] floating-cloud" style="animation-delay: 0s;">
        <img src="{{ asset('assets/maskot/awan 1.png') }}" alt="Cloud" class="w-20 lg:w-32">
    </div>
    <div class="hidden sm:block absolute bottom-[15%] left-[5%] floating-cloud" style="animation-delay: 3s;">
        <img src="{{ asset('assets/maskot/awan 3.png') }}" alt="Cloud" class="w-16 lg:w-28">
    </div>
    <div class="hidden md:block absolute bottom-[35%] left-[25%] floating-cloud" style="animation-delay: 1.3s;">
        <img src="{{ asset('assets/maskot/awan 2.png') }}" alt="Cloud" class="w-20 lg:w-28">
    </div>
    <div class="hidden sm:block absolute top-[15%] right-[12%] floating-cloud" style="animation-delay: 2s;">
        <img src="{{ asset('assets/maskot/awan 5.png') }}" alt="Cloud" class="w-20 lg:w-32">
    </div>
    <div class="hidden sm:block absolute bottom-[25%] right-[5%] floating-cloud" style="animation-delay: 4.5s;">
        <img src="{{ asset('assets/maskot/awan 4.png') }}" alt="Cloud" class="w-20 lg:w-32">
    </div>
    
    <div class="relative z-10 px-[5%] mb-12">
        <h2 class="text-3xl sm:text-4xl lg:text-6xl font-extrabold mb-8 leading-tight text-[#1a3a5a]">
            {!! $attributes->get('title', 'Unlock English Skills <br> Anytime, Anywhere') !!}
        </h2>
        <a href="{{ $attributes->get('buttonLink', '#') }}"
           class="inline-block bg-[#1a3a5a] hover:bg-[#2c4e7a] text-white px-8 sm:px-12 py-3.5 sm:py-4 rounded-full font-bold text-base sm:text-xl transition-all shadow-xl shadow-blue-100">
            {{ $attributes->get('buttonText', "Get Started – It's Free Trial") }}
        </a>
    </div>
    
    <div class="earth-wrap flex justify-center relative">
        <div class="w-[240px] sm:w-[360px] lg:w-[500px] -mb-40 sm:-mb-56 lg:-mb-80">
            <img src="{{ asset($attributes->get('earthImage', 'assets/maskot/bumi.png')) }}" class="rotating-earth w-full h-auto opacity-90" alt="World Map">
        </div>
    </div>
</section>