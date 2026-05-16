@extends('layouts.user')

@section('title', 'Home')

@push('styles')
@endpush

@section('content')
{{-- Area Hero Tetap Bisa Dipencet di Mana Saja --}}
<section id="hero-carousel-section" class="w-full relative pt-36 pb-28 flex items-center overflow-hidden cursor-pointer select-none" 
         style="background-image: url('{{ asset('assets/background.png') }}'); background-size: cover; background-position: center;">
    
    {{-- CAROUSEL CONTAINER --}}
    <div class="max-w-[1200px] mx-auto px-[5%] w-full relative min-h-[550px] md:min-h-[480px] flex flex-col justify-center">
        
        <div class="carousel-slide duration-750 ease-in-out grid grid-cols-1 lg:grid-cols-[400px_1fr] gap-8 lg:gap-16 items-center w-full transition-all" id="slide-1">
            <div class="flex justify-center items-center order-first lg:order-none" data-aos="fade-right" data-aos-duration="1000">
                <img src="{{ asset('assets/maskot/belajar laptop.png') }}" 
                     class="w-[260px] lg:w-[320px] drop-shadow-[0_15px_25px_rgba(26,69,108,0.25)] transition-transform duration-300 hover:scale-105" 
                     alt="Owl LMS Mascot">
            </div>
            <div class="text-center lg:text-left" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                <h1 class="font-sans font-extrabold text-4xl md:text-5xl lg:text-[3.2rem] text-white mb-6 leading-tight lg:leading-[1.2]">
                    Learning Management System
                </h1>
                <p class="font-sans text-base md:text-lg text-white/90 leading-relaxed font-medium max-w-[850px] mx-auto lg:mx-0">
                    Boost your English skills with IC EDU through interactive learning designed for speaking confidence, grammar mastery, IELTS & TOEFL preparation, and professional communication to help you succeed in academics and global careers.
                </p>
            </div>
        </div>

        <div class="carousel-slide duration-750 ease-in-out grid grid-cols-1 lg:grid-cols-[1fr_400px] gap-8 lg:gap-16 items-center w-full transition-all hidden opacity-0" id="slide-2">
            <div class="text-center lg:text-left">
                <h1 class="font-sans font-extrabold text-4xl md:text-5xl lg:text-[3.2rem] text-white mb-6 leading-tight lg:leading-[1.2]">
                    Unlimited practice for your chosen test category.
                </h1>
                <p class="font-sans text-base md:text-lg text-white/90 leading-relaxed font-medium max-w-[750px] mx-auto lg:mx-0 mb-8">
                    For intensive preparation, you can add additional mock-test credits to your plan. Tailor your learning experience and start practicing immediately after signing up.
                </p>
                <div>
                    <a href="#" class="inline-block bg-[#1a3a5a] text-white font-bold px-8 py-4 rounded-xl hover:bg-[#152e4a] transition-all shadow-lg text-sm md:text-base hover:translate-y-[-2px] relative z-50 pointer-events-auto">
                        Get Started - Its Free Trial
                    </a>
                </div>
            </div>

            <div class="flex flex-col items-center justify-center text-center text-white lg:items-end order-first lg:order-none">
                <span class="text-lg md:text-xl font-bold tracking-wide opacity-90 mb-2">Discount for Student</span>
                <span class="text-[8rem] md:text-[10rem] lg:text-[12rem] font-black leading-none tracking-tighter drop-shadow-xl select-none">
                    30%
                </span>
            </div>
        </div>

        <div class="absolute bottom-[-50px] lg:bottom-[-40px] left-1/2 -translate-x-1/2 flex space-x-2.5 z-30 pointer-events-auto">
            <button onclick="event.stopPropagation(); goToSlide(1)" id="dot-1" class="w-2.5 h-2.5 rounded-full bg-white transition-all duration-300" aria-label="Slide 1"></button>
            <button onclick="event.stopPropagation(); goToSlide(2)" id="dot-2" class="w-2.5 h-2.5 rounded-full bg-white/40 transition-all duration-300" aria-label="Slide 2"></button>
        </div>

    </div>
</section>

{{-- JAVASCRIPT SLIDER --}}
@push('scripts')
<script>
    let currentSlide = 1;
    const totalSlides = 2;
    let autoSlideInterval;

    function goToSlide(slideIndex) {
        const slide1 = document.getElementById('slide-1');
        const slide2 = document.getElementById('slide-2');
        const dot1 = document.getElementById('dot-1');
        const dot2 = document.getElementById('dot-2');

        if (slideIndex === 1) {
            slide2.classList.add('hidden', 'opacity-0');
            slide1.classList.remove('hidden', 'opacity-0');
            
            // Efek Aktif Dot 1
            dot1.classList.replace('bg-white/40', 'bg-white');
            dot2.classList.replace('bg-white', 'bg-white/40');
            
            currentSlide = 1;
        } else {
            slide1.classList.add('hidden', 'opacity-0');
            slide2.classList.remove('hidden', 'opacity-0');
            
            // Efek Aktif Dot 2
            dot2.classList.replace('bg-white/40', 'bg-white');
            dot1.classList.replace('bg-white', 'bg-white/40');
            
            currentSlide = 2;
        }
    }

    function nextSlide() {
        let targetSlide = currentSlide + 1;
        if (targetSlide > totalSlides) {
            targetSlide = 1;
        }
        goToSlide(targetSlide);
    }

    function startAutoSlide() {
        autoSlideInterval = setInterval(nextSlide, 3000); // 3 Detik otomatis geser
    }

    function resetAutoSlide() {
        clearInterval(autoSlideInterval);
        startAutoSlide();
    }

    // Klik di mana saja untuk geser slide
    document.getElementById('hero-carousel-section').addEventListener('click', function(e) {
        if (e.target.closest('a')) return;
        nextSlide();
        resetAutoSlide();
    });

    startAutoSlide();
</script>
@endpush
@endsection