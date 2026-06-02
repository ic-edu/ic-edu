@extends('layouts.user')

@section('title', 'Pricing')

@push('styles')
<style>
    .floating-cloud {
        animation: floatCloud 4s ease-in-out infinite;
    }

    @keyframes floatCloud {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    /* Custom Transitions for Panels */
    .tab-panel {
        transition: opacity 0.4s cubic-bezier(0.16, 1, 0.3, 1), transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
</style>
@endpush

@section('content')
{{-- 1. Hero Section --}}
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
    <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none z-10">
        <svg class="relative block w-[calc(100%+1.3px)] h-[50px] md:h-[80px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C59.71,118.06,155.43,109.84,233.15,92.83c83.15-18.17,159.95-46.06,242.21-59.5Z" fill="#ffffff"></path>
        </svg>
    </div>
</section>
<x-landing.pricingcard/>
<x-landing.unlock/>

{{-- 2. Switcher & Main Layout --}}
<div class="bg-white pb-32 pt-12">
    <div class="max-w-[1400px] mx-auto px-[4%] w-full">
        
        {{-- Segmented Tab Switcher --}}
        <div class="flex justify-center mb-16" data-aos="fade-up" data-aos-duration="1000">
            <div class="bg-slate-100 p-1.5 rounded-full inline-flex border border-slate-200/60 shadow-sm relative z-20">
                <button id="tab-exam" onclick="switchTab('exam')" class="px-6 md:px-8 py-3 rounded-full text-xs md:text-sm font-extrabold transition-all duration-300 flex items-center gap-2 bg-[#1A456C] text-white shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2Z" />
                    </svg>
                    Mock Test (Token)
                </button>
                <button id="tab-course" onclick="switchTab('course')" class="px-6 md:px-8 py-3 rounded-full text-xs md:text-sm font-extrabold transition-all duration-300 flex items-center gap-2 text-slate-600 hover:text-[#1A456C]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-16.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-16.25v16.25" />
                    </svg>
                    Learning Courses (Individual)
                </button>
            </div>
        </div>

        {{-- ──────────────── PANEL 1: EXAM TOKENS ──────────────── --}}
        <div id="panel-exam" class="tab-panel opacity-100 transform translate-y-0" data-aos="fade-up" data-aos-duration="1000">
            <div class="text-center max-w-xl mx-auto mb-12">
                <span class="text-xs font-extrabold tracking-widest text-[#70b2c4] bg-[#70b2c4]/10 px-4 py-1.5 rounded-full uppercase">Token System</span>
                <h2 class="text-3xl font-black text-[#1a3a5a] mt-3 mb-4">Choose Your Mock Test Category</h2>
                <p class="text-xs text-slate-500 font-semibold leading-relaxed">
                    Purchase token credits to unlock full exam simulation sets. Standard items are graded automatically, and Writing/Speaking items receive detailed transcripts and evaluation from certified human Examiners.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-stretch">
                {{-- TOEIC CARD --}}
                <div class="group border-[1.5px] border-[#1a3a5a]/20 hover:border-[#1a3a5a] rounded-[2.5rem] p-8 flex flex-col bg-white transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_30px_60px_-15px_rgba(26,58,90,0.15)]">
                    <div class="text-center mb-6">
                        <h3 class="text-3xl font-black text-[#1a3a5a] mb-4">TOEIC</h3>
                        <p class="text-[11px] font-bold text-slate-500 h-10 leading-relaxed">Master the Test of English for International Communication. Tailored for the global workplace.</p>
                    </div>
                    
                    <hr class="border-slate-100 mb-6">

                    {{-- TOEIC Package Radio Group --}}
                    <div class="space-y-3 mb-8 flex-grow">
                        <div class="relative">
                            <input type="radio" id="toeic-p1" name="toeic_pack" value="1" checked class="peer sr-only">
                            <label for="toeic-p1" class="block border-2 border-slate-100 peer-checked:border-[#1A456C] peer-checked:bg-slate-50/50 rounded-2xl p-4 cursor-pointer transition-all hover:border-[#1A456C]/30">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="font-extrabold text-xs text-slate-800 block">1 Token (1 Test)</span>
                                        <span class="text-[10px] text-slate-400 font-semibold">Standard diagnostic</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="font-black text-sm text-[#1A456C] block">Rp 75.000</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div class="relative">
                            <input type="radio" id="toeic-p3" name="toeic_pack" value="3" class="peer sr-only">
                            <label for="toeic-p3" class="block border-2 border-slate-100 peer-checked:border-[#1A456C] peer-checked:bg-slate-50/50 rounded-2xl p-4 cursor-pointer transition-all hover:border-[#1A456C]/30">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="font-extrabold text-xs text-slate-800 block flex items-center gap-1.5">
                                            3 Tokens
                                            <span class="bg-red-100 text-red-600 text-[8px] font-extrabold px-1.5 py-0.5 rounded-md">Save 16%</span>
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-semibold">3x Simulation Tests</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="font-black text-sm text-[#1A456C] block">Rp 189.000</span>
                                        <span class="text-[9px] text-slate-400 line-through font-bold">Rp 225.000</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div class="relative">
                            <input type="radio" id="toeic-p5" name="toeic_pack" value="5" class="peer sr-only">
                            <label for="toeic-p5" class="block border-2 border-slate-100 peer-checked:border-[#1A456C] peer-checked:bg-slate-50/50 rounded-2xl p-4 cursor-pointer transition-all hover:border-[#1A456C]/30">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="font-extrabold text-xs text-slate-800 block flex items-center gap-1.5">
                                            5 Tokens
                                            <span class="bg-[#1A456C] text-white text-[8px] font-extrabold px-1.5 py-0.5 rounded-md">Best Deal</span>
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-semibold">5x Simulation Tests</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="font-black text-sm text-[#1A456C] block">Rp 299.000</span>
                                        <span class="text-[9px] text-slate-400 line-through font-bold">Rp 375.000</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <h4 class="font-extrabold text-xs text-[#1a3a5a] mb-3">Features</h4>
                        <ul class="text-[10px] text-[#1a3a5a] font-bold space-y-2 mb-6 text-left">
                            <li class="flex items-center gap-2"><span class="text-blue-500 font-black">•</span> Listening Practice</li>
                            <li class="flex items-center gap-2"><span class="text-blue-500 font-black">•</span> Reading Comprehension</li>
                            <li class="flex items-center gap-2"><span class="text-blue-500 font-black">•</span> Business Vocabulary</li>
                            <li class="flex items-center gap-2"><span class="text-blue-500 font-black">•</span> Grammar Exercises</li>
                            <li class="flex items-center gap-2"><span class="text-blue-500 font-black">•</span> Mini TOEIC Quizzes</li>
                            <li class="flex items-center gap-2"><span class="text-blue-500 font-black">•</span> Timed Practice Tests</li>
                            <li class="flex items-center gap-2"><span class="text-blue-500 font-black">•</span> Score Prediction</li>
                            <li class="flex items-center gap-2"><span class="text-blue-500 font-black">•</span> Explanation & Discussion</li>
                        </ul>
                        <button class="w-full text-center bg-[#70b2c4] text-white font-extrabold text-xs py-3.5 rounded-2xl hover:bg-[#5c98a9] transition-all hover:shadow-md">
                            Buy TOEIC Tokens
                        </button>
                    </div>
                </div>

                {{-- TOEFL CARD --}}
                <div class="group border-[1.5px] border-[#1a3a5a]/20 hover:border-[#1a3a5a] rounded-[2.5rem] p-8 flex flex-col bg-white transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_30px_60px_-15px_rgba(26,58,90,0.15)] relative">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-[#1A456C] text-white text-[9px] font-extrabold px-4 py-1.5 rounded-full uppercase tracking-wider shadow-md">
                        Popular
                    </div>
                    <div class="text-center mb-6 mt-2">
                        <h3 class="text-3xl font-black text-[#1a3a5a] mb-4">TOEFL</h3>
                        <p class="text-[11px] font-bold text-slate-500 h-10 leading-relaxed">Designed for academic excellence and university admissions globally.</p>
                    </div>
                    
                    <hr class="border-slate-100 mb-6">

                    {{-- TOEFL Package Radio Group --}}
                    <div class="space-y-3 mb-8 flex-grow">
                        <div class="relative">
                            <input type="radio" id="toefl-p1" name="toefl_pack" value="1" checked class="peer sr-only">
                            <label for="toefl-p1" class="block border-2 border-slate-100 peer-checked:border-[#1A456C] peer-checked:bg-slate-50/50 rounded-2xl p-4 cursor-pointer transition-all hover:border-[#1A456C]/30">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="font-extrabold text-xs text-slate-800 block">1 Token (1 Test)</span>
                                        <span class="text-[10px] text-slate-400 font-semibold">Standard diagnostic</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="font-black text-sm text-[#1A456C] block">Rp 99.000</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div class="relative">
                            <input type="radio" id="toefl-p3" name="toefl_pack" value="3" class="peer sr-only">
                            <label for="toefl-p3" class="block border-2 border-slate-100 peer-checked:border-[#1A456C] peer-checked:bg-slate-50/50 rounded-2xl p-4 cursor-pointer transition-all hover:border-[#1A456C]/30">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="font-extrabold text-xs text-slate-800 block flex items-center gap-1.5">
                                            3 Tokens
                                            <span class="bg-red-100 text-red-600 text-[8px] font-extrabold px-1.5 py-0.5 rounded-md">Save 16%</span>
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-semibold">3x Simulation Tests</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="font-black text-sm text-[#1A456C] block">Rp 249.000</span>
                                        <span class="text-[9px] text-slate-400 line-through font-bold">Rp 297.000</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div class="relative">
                            <input type="radio" id="toefl-p5" name="toefl_pack" value="5" class="peer sr-only">
                            <label for="toefl-p5" class="block border-2 border-slate-100 peer-checked:border-[#1A456C] peer-checked:bg-slate-50/50 rounded-2xl p-4 cursor-pointer transition-all hover:border-[#1A456C]/30">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="font-extrabold text-xs text-slate-800 block flex items-center gap-1.5">
                                            5 Tokens
                                            <span class="bg-[#1A456C] text-white text-[8px] font-extrabold px-1.5 py-0.5 rounded-md">Best Deal</span>
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-semibold">5x Simulation Tests</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="font-black text-sm text-[#1A456C] block">Rp 399.000</span>
                                        <span class="text-[9px] text-slate-400 line-through font-bold">Rp 495.000</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <h4 class="font-extrabold text-xs text-[#1a3a5a] mb-3">Features</h4>
                        <ul class="text-[10px] text-[#1a3a5a] font-bold space-y-2 mb-6 text-left">
                            <li class="flex items-center gap-2"><span class="text-blue-500 font-black">•</span> Academic Reading</li>
                            <li class="flex items-center gap-2"><span class="text-blue-500 font-black">•</span> Listening Exercises</li>
                            <li class="flex items-center gap-2"><span class="text-blue-500 font-black">•</span> Speaking Practice</li>
                            <li class="flex items-center gap-2"><span class="text-blue-500 font-black">•</span> Essay Writing Tasks</li>
                            <li class="flex items-center gap-2"><span class="text-blue-500 font-black">•</span> Grammar & Structure</li>
                            <li class="flex items-center gap-2"><span class="text-blue-500 font-black">•</span> Integrated Skill Practice</li>
                            <li class="flex items-center gap-2"><span class="text-blue-500 font-black">•</span> TOEFL Simulation Tests</li>
                            <li class="flex items-center gap-2"><span class="text-blue-500 font-black">•</span> AI & Human Examiner Scoring</li>
                        </ul>
                        <button class="w-full text-center bg-[#1A456C] text-white font-extrabold text-xs py-3.5 rounded-2xl hover:bg-[#152e4a] transition-all hover:shadow-lg">
                            Buy TOEFL Tokens
                        </button>
                    </div>
                </div>

                {{-- IELTS CARD --}}
                <div class="group border-[1.5px] border-[#1a3a5a]/20 hover:border-[#1a3a5a] rounded-[2.5rem] p-8 flex flex-col bg-white transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_30px_60px_-15px_rgba(26,58,90,0.15)]">
                    <div class="text-center mb-6">
                        <h3 class="text-3xl font-black text-[#1a3a5a] mb-4">IELTS</h3>
                        <p class="text-[11px] font-bold text-slate-500 h-10 leading-relaxed">High-standard preparation for scholarship and immigration requirements.</p>
                    </div>
                    
                    <hr class="border-slate-100 mb-6">

                    {{-- IELTS Package Radio Group --}}
                    <div class="space-y-3 mb-8 flex-grow">
                        <div class="relative">
                            <input type="radio" id="ielts-p1" name="ielts_pack" value="1" checked class="peer sr-only">
                            <label for="ielts-p1" class="block border-2 border-slate-100 peer-checked:border-[#1A456C] peer-checked:bg-slate-50/50 rounded-2xl p-4 cursor-pointer transition-all hover:border-[#1A456C]/30">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="font-extrabold text-xs text-slate-800 block">1 Token (1 Test)</span>
                                        <span class="text-[10px] text-slate-400 font-semibold">Standard diagnostic</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="font-black text-sm text-[#1A456C] block">Rp 125.000</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div class="relative">
                            <input type="radio" id="ielts-p3" name="ielts_pack" value="3" class="peer sr-only">
                            <label for="ielts-p3" class="block border-2 border-slate-100 peer-checked:border-[#1A456C] peer-checked:bg-slate-50/50 rounded-2xl p-4 cursor-pointer transition-all hover:border-[#1A456C]/30">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="font-extrabold text-xs text-slate-800 block flex items-center gap-1.5">
                                            3 Tokens
                                            <span class="bg-red-100 text-red-600 text-[8px] font-extrabold px-1.5 py-0.5 rounded-md">Save 15%</span>
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-semibold">3x Simulation Tests</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="font-black text-sm text-[#1A456C] block">Rp 319.000</span>
                                        <span class="text-[9px] text-slate-400 line-through font-bold">Rp 375.000</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div class="relative">
                            <input type="radio" id="ielts-p5" name="ielts_pack" value="5" class="peer sr-only">
                            <label for="ielts-p5" class="block border-2 border-slate-100 peer-checked:border-[#1A456C] peer-checked:bg-slate-50/50 rounded-2xl p-4 cursor-pointer transition-all hover:border-[#1A456C]/30">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="font-extrabold text-xs text-slate-800 block flex items-center gap-1.5">
                                            5 Tokens
                                            <span class="bg-[#1A456C] text-white text-[8px] font-extrabold px-1.5 py-0.5 rounded-md">Best Deal</span>
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-semibold">5x Simulation Tests</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="font-black text-sm text-[#1A456C] block">Rp 499.000</span>
                                        <span class="text-[9px] text-slate-400 line-through font-bold">Rp 625.000</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <h4 class="font-extrabold text-xs text-[#1a3a5a] mb-3">Features</h4>
                        <ul class="text-[10px] text-[#1a3a5a] font-bold space-y-2 mb-6 text-left">
                            <li class="flex items-center gap-2"><span class="text-blue-500 font-black">•</span> Listening Training</li>
                            <li class="flex items-center gap-2"><span class="text-blue-500 font-black">•</span> Academic & General Reading</li>
                            <li class="flex items-center gap-2"><span class="text-blue-500 font-black">•</span> Writing Task 1 & 2</li>
                            <li class="flex items-center gap-2"><span class="text-blue-500 font-black">•</span> Speaking Mock Test</li>
                            <li class="flex items-center gap-2"><span class="text-blue-500 font-black">•</span> Vocabulary Builder</li>
                            <li class="flex items-center gap-2"><span class="text-blue-500 font-black">•</span> Band Score Estimation</li>
                            <li class="flex items-center gap-2"><span class="text-blue-500 font-black">•</span> Real Test Simulation</li>
                            <li class="flex items-center gap-2"><span class="text-blue-500 font-black">•</span> Examiner Evaluation & Feedback</li>
                        </ul>
                        <button class="w-full text-center bg-[#70b2c4] text-white font-extrabold text-xs py-3.5 rounded-2xl hover:bg-[#5c98a9] transition-all hover:shadow-md">
                            Buy IELTS Tokens
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ──────────────── PANEL 2: LEARNING COURSES ──────────────── --}}
        <div id="panel-course" class="tab-panel hidden opacity-0 transform translate-y-4" data-aos="fade-up" data-aos-duration="1000">
            <div class="text-center max-w-xl mx-auto mb-12">
                <span class="text-xs font-extrabold tracking-widest text-[#70b2c4] bg-[#70b2c4]/10 px-4 py-1.5 rounded-full uppercase">LMS Courses</span>
                <h2 class="text-3xl font-black text-[#1a3a5a] mt-3 mb-4">Explore Learning Courses</h2>
                <p class="text-xs text-slate-500 font-semibold leading-relaxed">
                    Purchase individual structured video training courses to master specific language sections. One-time payment, permanent lifetime access.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($courses as $course)
                    @php
                        // Determine price based on target level
                        $level = is_array($course->target_level) ? ($course->target_level[0] ?? 'Intermediate') : ($course->target_level ?? 'Intermediate');
                        $priceVal = $course->price ?? 149000;
                        $priceText = 'Rp ' . number_format($priceVal, 0, ',', '.');
                        $levelColor = 'bg-amber-100 text-amber-800 border-amber-200';
                        if ($level === 'Beginner') {
                            $levelColor = 'bg-emerald-100 text-emerald-800 border-emerald-200';
                        } elseif ($level === 'Advanced') {
                            $levelColor = 'bg-rose-100 text-rose-800 border-rose-200';
                        }
                    @endphp
                    <div class="group bg-white rounded-3xl border border-slate-150 hover:border-[#1a3a5a]/20 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col hover:-translate-y-1">
                        <!-- Course Image/Thumbnail -->
                        <div class="relative h-48 bg-slate-50 flex items-center justify-center overflow-hidden border-b border-slate-100">
                            @if($course->thumbnail_path)
                                <img src="{{ asset('storage/' . $course->thumbnail_path) }}" alt="{{ $course->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <!-- Decorative Placeholder with Brand Color -->
                                <div class="absolute inset-0 bg-gradient-to-br from-slate-50 to-slate-100/50 flex items-center justify-center">
                                    <div class="w-14 h-14 rounded-2xl bg-[#1A456C] flex items-center justify-center shadow-md">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                                        </svg>
                                    </div>
                                </div>
                            @endif
                            <!-- Floating Price Tag -->
                            <div class="absolute top-4 right-4 bg-emerald-500 text-white font-black text-sm px-4 py-1.5 rounded-full shadow-lg z-10">
                                {{ $priceText }}
                            </div>
                        </div>
                        
                        <!-- Body -->
                        <div class="p-6 flex-grow flex flex-col">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-[10px] font-extrabold uppercase tracking-wider px-2 py-0.5 rounded-md border {{ $levelColor }}">
                                    {{ $level }}
                                </span>
                                <span class="text-[10px] font-bold text-slate-400">
                                    {{ $course->modules_count ?? 0 }} Modules
                                </span>
                            </div>
                            
                            <h3 class="font-extrabold text-base text-slate-800 mb-2 leading-snug group-hover:text-[#1A456C] transition-colors">
                                {{ $course->title }}
                            </h3>
                            
                            <p class="text-xs text-slate-500 leading-relaxed line-clamp-3 mb-6">
                                {{ strip_tags($course->description) ?: 'Master your target exam skills step-by-step with structured video lectures, customized worksheets, and progress evaluation.' }}
                            </p>
                            
                            <!-- Meta information -->
                            <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400 font-bold">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <span>{{ $course->enrollments_count ?? 0 }} Students</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                    </svg>
                                    <span>Lifetime Access</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Button -->
                        <div class="px-6 pb-6">
                            <a href="{{ route('test_taker.course.show', $course->id) }}" class="block w-full text-center bg-[#1A456C] text-white font-extrabold text-xs py-3.5 rounded-2xl hover:bg-[#152e4a] transition-all hover:shadow-lg">
                                Buy Course
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center border-2 border-dashed border-slate-200 rounded-3xl bg-slate-50">
                        <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <h4 class="font-extrabold text-sm text-slate-700">No Active Courses Available</h4>
                        <p class="text-[11px] text-slate-400 mt-1">Our instructors are preparing courses for you. Check back soon!</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    function switchTab(type) {
        const examBtn = document.getElementById('tab-exam');
        const courseBtn = document.getElementById('tab-course');
        const examPanel = document.getElementById('panel-exam');
        const coursePanel = document.getElementById('panel-course');

        if (type === 'exam') {
            // Button Styles Toggle
            examBtn.className = "px-6 md:px-8 py-3 rounded-full text-xs md:text-sm font-extrabold transition-all duration-300 flex items-center gap-2 bg-[#1A456C] text-white shadow-md";
            courseBtn.className = "px-6 md:px-8 py-3 rounded-full text-xs md:text-sm font-extrabold transition-all duration-300 flex items-center gap-2 text-slate-600 hover:text-[#1A456C]";
            
            // Panel Transition Styles
            coursePanel.classList.add('opacity-0', 'translate-y-4');
            setTimeout(() => {
                coursePanel.classList.add('hidden');
                examPanel.classList.remove('hidden');
                setTimeout(() => {
                    examPanel.classList.remove('opacity-0', 'translate-y-4');
                    examPanel.classList.add('opacity-100', 'translate-y-0');
                }, 50);
            }, 300);
        } else {
            // Button Styles Toggle
            courseBtn.className = "px-6 md:px-8 py-3 rounded-full text-xs md:text-sm font-extrabold transition-all duration-300 flex items-center gap-2 bg-[#1A456C] text-white shadow-md";
            examBtn.className = "px-6 md:px-8 py-3 rounded-full text-xs md:text-sm font-extrabold transition-all duration-300 flex items-center gap-2 text-slate-600 hover:text-[#1A456C]";
            
            // Panel Transition Styles
            examPanel.classList.add('opacity-0', 'translate-y-4');
            setTimeout(() => {
                examPanel.classList.add('hidden');
                coursePanel.classList.remove('hidden');
                setTimeout(() => {
                    coursePanel.classList.remove('opacity-0', 'translate-y-4');
                    coursePanel.classList.add('opacity-100', 'translate-y-0');
                }, 50);
            }, 300);
        }
    }
</script>
@endpush
@endsection