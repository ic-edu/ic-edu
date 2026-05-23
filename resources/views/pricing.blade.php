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
                    Get Started - It's Free Trial
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
    <div class="absolute bottom-0 left-0 w-full overflow-hidden leading- z-10">
        <svg class="relative block w-[calc(100%+1.3px)] h-[50px] md:h-[80px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C59.71,118.06,155.43,109.84,233.15,92.83c83.15-18.17,159.95-46.06,242.21-59.5Z" fill="#ffffff"></path>
        </svg>
    </div>
</section>

<div class="bg-white pb-32 pt-8">
    <div class="max-w-[1400px] mx-auto px-[4%] w-full">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">
            <div class="group border-[1.5px] border-[#1a3a5a]/30 hover:border-[#1a3a5a] rounded-[2.5rem] p-7 flex flex-col bg-white transition-all duration-500 ease-[cubic-bezier(0.23,1,0.32,1)] hover:-translate-y-3 hover:scale-[1.02] hover:shadow-[0_30px_60px_-15px_rgba(26,58,90,0.2)] cursor-pointer">
                <div class="text-center mb-6">
                    <h3 class="text-3xl font-black text-[#1a3a5a] mb-4">TOEIC</h3>
                    <p class="text-[11px] font-bold text-[#1a3a5a] mb-6 h-12 leading-relaxed">Master the Test of English for International Communication. Tailored for the global workplace.</p>
                    <div class="text-[2.2rem] font-black text-[#1a3a5a] mb-3">Rp. 200.00</div>
                    <span class="bg-[#1a3a5a] text-white text-[10px] font-bold px-4 py-1.5 rounded-full inline-block">Unlimited Lifetime Access</span>
                </div>
                <hr class="border-[#1a3a5a]/20 mb-5">
                <div class="flex-grow">
                    <h4 class="font-extrabold text-xs text-[#1a3a5a] mb-3">Features</h4>
                    <ul class="text-[11px] text-[#1a3a5a] font-bold space-y-2.5 mb-6">
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Listening Practice</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Reading Comprehension</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Business Vocabulary</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Grammar Exercises</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Mini TOEIC Quizzes</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Timed Practice Tests</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Score Prediction</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Explanation & Discussion</li>
                    </ul>
                    <h4 class="font-extrabold text-xs text-[#1a3a5a] mb-3">Usage</h4>
                    <ul class="text-[11px] text-[#1a3a5a] font-bold space-y-2.5 mb-8">
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Unlimited Module Access</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Full-Length Simulation Tests</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Progress Tracking</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Mobile Friendly Learning</li>
                    </ul>
                </div>
                <div class="mt-auto pt-4">
                    <a href="#" class="block w-full text-center bg-[#70b2c4] text-white font-extrabold text-xs py-3.5 rounded-full hover:bg-[#5c98a9] transition-colors">
                        Try For Free Trial
                    </a>
                </div>
            </div>

            {{-- TOEFL CARD --}}
            <div class="group border-[1.5px] border-[#1a3a5a]/30 hover:border-[#1a3a5a] rounded-[2.5rem] p-7 flex flex-col bg-white transition-all duration-500 ease-[cubic-bezier(0.23,1,0.32,1)] hover:-translate-y-3 hover:scale-[1.02] hover:shadow-[0_30px_60px_-15px_rgba(26,58,90,0.2)] cursor-pointer">
                <div class="text-center mb-6">
                    <h3 class="text-3xl font-black text-[#1a3a5a] mb-4">TOEFL</h3>
                    <p class="text-[11px] font-bold text-[#1a3a5a] mb-6 h-12 leading-relaxed">Designed for academic excellence and university admissions globally.</p>
                    <div class="text-[2.2rem] font-black text-[#1a3a5a] mb-3">Rp. 200.00</div>
                    <span class="bg-[#1a3a5a] text-white text-[10px] font-bold px-4 py-1.5 rounded-full inline-block">Unlimited Lifetime Access</span>
                </div>
                <hr class="border-[#1a3a5a]/20 mb-5">
                <div class="flex-grow">
                    <h4 class="font-extrabold text-xs text-[#1a3a5a] mb-3">Features</h4>
                    <ul class="text-[11px] text-[#1a3a5a] font-bold space-y-2.5 mb-6">
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Academic Reading</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Listening Exercises</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Speaking Practice</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Essay Writing Tasks</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Grammar & Structure</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Integrated Skill Practice</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> TOEFL Simulation Tests</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> AI-Based Evaluation</li>
                    </ul>
                    <h4 class="font-extrabold text-xs text-[#1a3a5a] mb-3">Usage</h4>
                    <ul class="text-[11px] text-[#1a3a5a] font-bold space-y-2.5 mb-8">
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Unlimited Practice Sessions</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Detailed Performance Analysis</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Progress Dashboard</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Certificate of Completion</li>
                    </ul>
                </div>
                <div class="mt-auto pt-4">
                    <a href="#" class="block w-full text-center bg-[#70b2c4] text-white font-extrabold text-xs py-3.5 rounded-full hover:bg-[#5c98a9] transition-colors">
                        Try For Free Trial
                    </a>
                </div>
            </div>

            {{-- IELTS CARD --}}
            <div class="group border-[1.5px] border-[#1a3a5a]/30 hover:border-[#1a3a5a] rounded-[2.5rem] p-7 flex flex-col bg-white transition-all duration-500 ease-[cubic-bezier(0.23,1,0.32,1)] hover:-translate-y-3 hover:scale-[1.02] hover:shadow-[0_30px_60px_-15px_rgba(26,58,90,0.2)] cursor-pointer">
                <div class="text-center mb-6">
                    <h3 class="text-3xl font-black text-[#1a3a5a] mb-4">IELTS</h3>
                    <p class="text-[11px] font-bold text-[#1a3a5a] mb-6 h-12 leading-relaxed">High-standard preparation for scholarship and immigration requirements.</p>
                    <div class="text-[2.2rem] font-black text-[#1a3a5a] mb-3">Rp. 200.00</div>
                    <span class="bg-[#1a3a5a] text-white text-[10px] font-bold px-4 py-1.5 rounded-full inline-block">Unlimited Lifetime Access</span>
                </div>
                <hr class="border-[#1a3a5a]/20 mb-5">
                <div class="flex-grow">
                    <h4 class="font-extrabold text-xs text-[#1a3a5a] mb-3">Features</h4>
                    <ul class="text-[11px] text-[#1a3a5a] font-bold space-y-2.5 mb-6">
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Listening Training</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Academic & General Reading</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Writing Task 1 & 2</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Speaking Mock Test</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Vocabulary Builder</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Band Score Estimation</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Real Test Simulation</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Feedback & Explanation</li>
                    </ul>
                    <h4 class="font-extrabold text-xs text-[#1a3a5a] mb-3">Usage</h4>
                    <ul class="text-[11px] text-[#1a3a5a] font-bold space-y-2.5 mb-8">
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Unlimited Module Access</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Band Progress Monitoring</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Multi-Device Access</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Practice History Tracking</li>
                    </ul>
                </div>
                <div class="mt-auto pt-4">
                    <a href="#" class="block w-full text-center bg-[#70b2c4] text-white font-extrabold text-xs py-3.5 rounded-full hover:bg-[#5c98a9] transition-colors">
                        Try For Free Trial
                    </a>
                </div>
            </div>

            {{-- LMS CARD --}}
            <div class="group border-[1.5px] border-[#1a3a5a]/30 hover:border-[#1a3a5a] rounded-[2.5rem] p-7 flex flex-col bg-white transition-all duration-500 ease-[cubic-bezier(0.23,1,0.32,1)] hover:-translate-y-3 hover:scale-[1.02] hover:shadow-[0_30px_60px_-15px_rgba(26,58,90,0.2)] cursor-pointer">
                <div class="text-center mb-6">
                    <h3 class="text-3xl font-black text-[#1a3a5a] mb-4">LMS</h3>
                    <p class="text-[11px] font-bold text-[#1a3a5a] mb-6 h-12 leading-relaxed">Learning Management System. A complete digital ecosystem for language mastery.</p>
                    <div class="text-[2.2rem] font-black text-[#1a3a5a] mb-3">Rp. 200.00</div>
                    <span class="bg-[#1a3a5a] text-white text-[10px] font-bold px-4 py-1.5 rounded-full inline-block">Unlimited Lifetime Access</span>
                </div>
                <hr class="border-[#1a3a5a]/20 mb-5">
                <div class="flex-grow">
                    <h4 class="font-extrabold text-xs text-[#1a3a5a] mb-3">Features</h4>
                    <ul class="text-[11px] text-[#1a3a5a] font-bold space-y-2.5 mb-6">
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Listening Modules</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Reading Modules</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Writing Modules</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Grammar Lessons</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Vocabulary Practice</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Interactive Quizzes</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Video Learning Materials</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Downloadable Resources</li>
                    </ul>
                    <h4 class="font-extrabold text-xs text-[#1a3a5a] mb-3">Learning System</h4>
                    <ul class="text-[11px] text-[#1a3a5a] font-bold space-y-2.5 mb-8">
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Structured Learning Path</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Progress Tracking</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Unlimited Course Access</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Multi-Level Materials</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Practice & Evaluation</li>
                        <li class="flex items-start gap-2"><span class="text-blue-500 font-black">•</span> Student Performance Reports.</li>
                    </ul>
                </div>
                <div class="mt-auto pt-4">
                    <a href="#" class="block w-full text-center bg-[#70b2c4] text-white font-extrabold text-xs py-3.5 rounded-full hover:bg-[#5c98a9] transition-colors">
                        Try For Free Trial
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection