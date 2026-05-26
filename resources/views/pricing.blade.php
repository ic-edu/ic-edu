@extends('layouts.user')

@section('title', 'Pricing')

@section('content')
<section class="w-full relative pt-40 pb-32 flex items-center overflow-hidden select-none bg-gradient-to-br from-slate-50 via-slate-100 via-40% to-[#1A456C]">
    <div class="absolute top-[12%] right-[10%] floating-cloud" style="animation-delay: 0s; z-index: 1;">
        <img src="{{ asset('assets/maskot/awan 6.png') }}" alt="Cloud" class="w-20 lg:w-28 opacity-80">
    </div>
    <div class="absolute bottom-[8%] left-[55%] floating-cloud" style="animation-delay: 2.5s; z-index: 1;">
        <img src="{{ asset('assets/maskot/awan 7.png') }}" alt="Cloud" class="w-24 lg:w-32 opacity-75">
    </div>
    <div class="max-w-[1300px] mx-auto px-[5%] w-full relative z-10 flex flex-col lg:flex-row items-center justify-between gap-12 lg:gap-8">
        <div class="w-full lg:w-3/5 text-slate-800" data-aos="fade-right" data-aos-duration="1000">
            <h1 class="font-sans font-extrabold text-4xl md:text-5xl lg:text-[3.5rem] mb-6 leading-tight drop-shadow-sm text-[#1a3a5a]">
                Unlimited practice for your chosen test category.
            </h1>
            <p class="font-sans text-base md:text-lg mb-10 font-medium max-w-[600px] text-slate-600 leading-relaxed">
                For intensive preparation, you can add additional mock-test credits to your plan. Tailor your learning experience and start practicing immediately after signing up.
            </p>
            <div>
                <a href="#" class="inline-block bg-[#1a3a5a] text-white font-bold px-8 py-3.5 rounded-full hover:bg-[#152e4a] transition-all shadow-lg text-sm md:text-base">
                    Get Started - Its Free Trial
                </a>
            </div>
        </div>
        <div class="w-full lg:w-2/5 text-center lg:text-right text-white select-none" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
            <p class="text-xl md:text-2xl font-black mb-1 text-white drop-shadow-sm uppercase tracking-wider">Discount for Student</p>
            <div class="relative inline-block text-left lg:text-right">
                <h2 class="text-[8rem] md:text-[10rem] font-extrabold leading-none text-white drop-shadow-[0_0_0_3px_#000000] tracking-tighter relative z-10">
                    30%
                </h2>
            </div>
        </div>
    </div>
</section>
<x-landing.pricingcard/>
<x-landing.unlock/>

@endsection