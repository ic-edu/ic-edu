@push('styles')
<style>
    /* Animasi Bumi Berputar */
    .rotating-earth {
        animation: rotateEarth 60s linear infinite;
        transform-origin: center;
    }

    @keyframes rotateEarth {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* Animasi Awan Melayang */
    .floating-cloud {
        animation: cloudFloat 6s ease-in-out infinite;
        z-index: 1;
    }

    @keyframes cloudFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    /* Small sizing & soft opacity on mobile */
    .floating-cloud img {
        width: 44px;
        opacity: 0.25;
        transition: all 0.3s ease;
    }

    /* Larger sizing & normal opacity on desktop */
    @media (min-width: 1025px) {
        .floating-cloud img {
            width: 110px;
            opacity: 0.85;
        }
    }
</style>
@endpush

{{-- SECTION: UNLOCK ENGLISH SKILLS --}}
<section class="relative bg-white pt-32 pb-0 overflow-hidden text-center">
    <div class="absolute top-[8%] left-[2%] sm:left-[8%] floating-cloud" style="animation-delay: 0s;">
        <img src="{{ asset('assets/maskot/awan 1.png') }}" alt="Cloud">
    </div>
    <div class="absolute bottom-[12%] left-[2%] sm:left-[5%] floating-cloud" style="animation-delay: 3s;">
        <img src="{{ asset('assets/maskot/awan 3.png') }}" alt="Cloud">
    </div>
    <div class="absolute bottom-[30%] left-[10%] sm:left-[25%] floating-cloud" style="animation-delay: 1.3s;">
        <img src="{{ asset('assets/maskot/awan 2.png') }}" alt="Cloud">
    </div>
    <div class="absolute top-[12%] right-[2%] sm:right-[12%] floating-cloud" style="animation-delay: 2s;">
        <img src="{{ asset('assets/maskot/awan 5.png') }}" alt="Cloud">
    </div>
    <div class="absolute bottom-[20%] right-[2%] sm:right-[5%] floating-cloud" style="animation-delay: 4.5s;">
        <img src="{{ asset('assets/maskot/awan 4.png') }}" alt="Cloud">
    </div>
    
    <div class="relative z-10 px-[5%] mb-16">
        <h2 class="text-3xl sm:text-4xl lg:text-6xl font-extrabold mb-8 lg:mb-10 leading-tight text-[#1a3a5a]">
            Unlock English Skills <br> Anytime, Anywhere
        </h2>
        <a href="{{ route('register') }}" class="inline-block bg-[#1a3a5a] hover:bg-[#2c4e7a] text-white px-8 py-3.5 sm:px-12 sm:py-4 rounded-full font-bold text-lg sm:text-xl transition-all shadow-xl shadow-blue-100">
            Get Started – It's Free Trial
        </a>
    </div>
    
    <div class="flex justify-center relative">
        <div class="w-full max-w-[280px] sm:max-w-[320px] lg:max-w-[500px] -mb-36 sm:-mb-52 lg:-mb-80">
            <img src="{{ asset('assets/maskot/bumi.png') }}" class="rotating-earth w-full h-auto opacity-90" alt="World Map">
        </div>
    </div>
</section>
