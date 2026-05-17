@extends('layouts.user')

@section('title', 'Home')

@push('styles')
<style>
    .floating-cloud {
        animation: floatCloud 4s ease-in-out infinite;
    }
    @keyframes floatCloud {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
</style>
@endpush

@section('content')
<section class="w-full relative pt-40 pb-28 flex items-center overflow-hidden select-none" 
         style="background-image: url('{{ asset('assets/background.png') }}'); background-size: cover; background-position: center;">
    <div class="max-w-[1300px] mx-auto px-[5%] w-full relative min-h-[500px] md:min-h-[440px] flex flex-col justify-center">
        <div class="grid grid-cols-1 lg:grid-cols-[1.2fr_0.8fr] gap-8 lg:gap-4 items-center w-full">
            <div class="text-center lg:text-left pr-0 lg:pr-6" data-aos="fade-right" data-aos-duration="1000">
                <h1 class="font-sans font-extrabold text-4xl md:text-5xl lg:text-[3.2rem] text-[#1a3a5a] mb-6 leading-tight lg:leading-[1.2] tracking-tight">
                    Master English Fluency with Our Smart Learning Management System.
                </h1>
                <p class="font-sans text-sm md:text-base text-[#1a3a5a]/90 leading-relaxed font-medium max-w-[640px] mx-auto lg:mx-0 mb-10">
                    Boost your English skills with IC EDU through interactive learning designed for speaking confidence, grammar mastery, IELTS & TOEFL preparation, and professional communication to help you succeed in academics and global careers.
                </p>
                <div>
                    <a href="#" class="inline-block bg-[#1a3a5a] text-white font-bold px-8 py-3.5 rounded-xl hover:bg-[#152e4a] transition-all shadow-lg text-sm md:text-base relative z-50">
                        Get Started
                    </a>
                </div>
            </div>
            <div class="relative flex justify-center lg:justify-end items-center order-first lg:order-none h-[420px] w-full" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                <img src="{{ asset('assets/maskot/awan 7.png') }}" 
                     class="absolute top-6 right-[-20px] lg:right-[-40px] w-[70px] md:w-[90px] opacity-85 pointer-events-none select-none floating-cloud" 
                     style="animation-delay: 0.5s;"
                     alt="Cloud Top">

                <img src="{{ asset('assets/maskot/pen maskot.png') }}" 
                     class="w-[300px] md:w-[380px] lg:w-[450px] lg:mr-[-30px] drop-shadow-[0_15px_30px_rgba(0,0,0,0.15)] transition-transform duration-300 hover:scale-105 relative z-10" 
                     alt="Owl Pencil Mascot">

                <img src="{{ asset('assets/maskot/awan 6.png') }}" 
                     class="absolute bottom-2 left-[15%] lg:left-[0px] w-[90px] md:w-[120px] opacity-90 pointer-events-none select-none floating-cloud" 
                     alt="Cloud Bottom">   
            </div>
        </div>
    </div>
</section>


<div class="bg-[#f8fafc] min-h-screen pt-32 pb-16">
    <div class="max-w-[1400px] mx-auto px-[4%] w-full">
        
        <div class="mb-10 w-full">
            <div class="relative w-full max-w-[1200px] mx-auto mb-6">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" 
                       placeholder="Search for courses, instructors, or skills..." 
                       class="w-full pl-12 pr-4 py-3.5 bg-[#e2e8f0] text-slate-700 placeholder-slate-500 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm md:text-base transition-all">
            </div>

            <div class="flex flex-wrap items-center justify-start gap-3 max-w-[1200px] mx-auto">
                <button class="px-5 py-2 rounded-full text-sm font-medium bg-[#f1f5f9] text-slate-600 hover:bg-slate-200 transition-all">IELTS</button>
                <button class="px-5 py-2 rounded-full text-sm font-medium bg-[#f1f5f9] text-slate-600 hover:bg-slate-200 transition-all">TOEFL</button>
                <button class="px-5 py-2 rounded-full text-sm font-medium bg-[#f1f5f9] text-slate-600 hover:bg-slate-200 transition-all">Grammar</button>
                <button class="px-5 py-2 rounded-full text-sm font-medium bg-[#f1f5f9] text-slate-600 hover:bg-slate-200 transition-all">Speaking</button>
                <button class="px-6 py-2 rounded-full text-sm font-bold bg-[#1a456c] text-white shadow-sm transition-all">All Courses</button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-8 items-start w-full">
            
            <aside class="bg-[#f1f5f9] p-6 rounded-2xl border border-slate-100 shadow-sm sticky top-28">
                <h2 class="text-xl font-extrabold text-[#1a456c] mb-1">Filters</h2>
                <p class="text-xs font-semibold text-slate-400 mb-6 uppercase tracking-wider">Refine your search</p>
                
                <div class="space-y-5">
                    <div class="border-b border-slate-200 pb-3 flex items-center justify-between cursor-pointer group">
                        <span class="text-sm font-bold text-slate-600 group-hover:text-blue-600 transition-colors">Sort</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>

                    <div class="border-b border-slate-200 pb-3 flex items-center justify-between cursor-pointer group">
                        <span class="text-sm font-bold text-slate-600 group-hover:text-blue-600 transition-colors">Level</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>

                    <div class="border-b border-slate-200 pb-3 flex items-center justify-between cursor-pointer group">
                        <span class="text-sm font-bold text-slate-600 group-hover:text-blue-600 transition-colors">Category</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>

                    <div class="border-b border-slate-200 pb-3 flex items-center justify-between cursor-pointer group">
                        <span class="text-sm font-bold text-slate-600 group-hover:text-blue-600 transition-colors">Price</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>

                    <div class="border-b border-slate-200 pb-3 flex items-center justify-between cursor-pointer group">
                        <span class="text-sm font-bold text-slate-600 group-hover:text-blue-600 transition-colors">Duration</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>

                    <div class="border-b border-slate-200 pb-3 flex items-center justify-between cursor-pointer group">
                        <span class="text-sm font-bold text-slate-600 group-hover:text-blue-600 transition-colors">Certification</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <button class="w-full mt-6 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl transition-all shadow-md text-sm">
                    Apply Filters
                </button>
            </aside>

            <main class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 w-full">
                
                <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full group">
                    <div class="relative overflow-hidden aspect-video bg-slate-100">
                        <span class="absolute top-3 left-3 bg-indigo-700 text-white text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider z-10">Popular</span>
                        <img src="{{ asset('assets/course-demo.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Course Cover">
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="flex items-center gap-1 mb-2 text-amber-500 font-bold text-xs">
                            <span>★ 4.5</span> <span class="text-slate-400 font-normal">(120 students)</span>
                        </div>
                        <h3 class="text-xl font-black text-slate-800 leading-tight mb-1 group-hover:text-blue-600 transition-colors">English Grammar for Beginners</h3>
                        <p class="text-xs font-semibold text-slate-400 mb-6">John Smith</p>
                        
                        <div class="mt-auto mb-5">
                            <div class="flex items-center justify-between text-[11px] font-bold text-slate-500 mb-1.5">
                                <span>Progress</span>
                                <span>65%</span>
                            </div>
                            <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-blue-600 h-full rounded-full" style="width: 65%;"></div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                            <span class="text-xl font-black text-indigo-700">Free</span>
                            <a href="#" class="text-xs font-bold text-slate-400 hover:text-blue-600 transition-colors">Continue Learning</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full group">
                    <div class="relative overflow-hidden aspect-video bg-slate-100">
                        <span class="absolute top-3 left-3 bg-lime-500 text-slate-900 text-[10px] font-black px-2.5 py-1 rounded-md uppercase tracking-wider z-10">Best Seller</span>
                        <img src="{{ asset('assets/instructor-demo.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Course Cover">
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="flex items-center gap-1 mb-2 text-amber-500 font-bold text-xs">
                            <span>★ 4.8</span> <span class="text-slate-400 font-normal">(315 students)</span>
                        </div>
                        <h3 class="text-xl font-black text-slate-800 leading-tight mb-1 group-hover:text-blue-600 transition-colors">English Grammar for Beginners</h3>
                        <p class="text-xs font-semibold text-slate-400 mb-6">John Smith</p>
                        
                        <div class="mt-auto mb-6 flex flex-wrap gap-2">
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-md">🕒 12 hours</span>
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-md">📊 Advanced</span>
                        </div>

                        <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                            <span class="text-xl font-black text-slate-800">$49.99</span>
                            <a href="#" class="text-xs font-bold text-indigo-700 hover:text-blue-600 transition-colors">View Details</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full group">
                    <div class="relative overflow-hidden aspect-video bg-slate-100">
                        <span class="absolute top-3 left-3 bg-indigo-700 text-white text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider z-10">Popular</span>
                        <img src="{{ asset('assets/course-demo.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Course Cover">
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="flex items-center gap-1 mb-2 text-amber-500 font-bold text-xs">
                            <span>★ 4.5</span> <span class="text-slate-400 font-normal">(120 students)</span>
                        </div>
                        <h3 class="text-xl font-black text-slate-800 leading-tight mb-1 group-hover:text-blue-600 transition-colors">English Grammar for Beginners</h3>
                        <p class="text-xs font-semibold text-slate-400 mb-6">John Smith</p>
                        
                        <div class="mt-auto mb-5">
                            <div class="flex items-center justify-between text-[11px] font-bold text-slate-500 mb-1.5">
                                <span>Progress</span>
                                <span>65%</span>
                            </div>
                            <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-blue-600 h-full rounded-full" style="width: 65%;"></div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                            <span class="text-xl font-black text-indigo-700">Free</span>
                            <a href="#" class="text-xs font-bold text-slate-400 hover:text-blue-600 transition-colors">Continue Learning</a>
                        </div>
                    </div>
                </div>

            </main>
        </div>

    </div>
</div>
@endsection