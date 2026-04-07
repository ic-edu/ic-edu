@extends('layouts.test_taker')
@section('title', 'Dashboard')

@section('content')
{{-- PAGE HEADER --}}
<div class="flex items-end justify-between mb-6 anim-in d1">
    <div>
        <h1 class="font-heading text-2xl font-black text-slate-800">Activity Overview</h1>
        <p class="text-[0.8rem] font-medium text-slate-500 mt-1">Let's learn something new today!</p>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-12 gap-6 lg:gap-8">
    
    <div class="xl:col-span-8 flex flex-col gap-6 lg:gap-8">

        {{-- 1. OVERVIEW CARDS --}}
        <div class="anim-in d2">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                {{-- Card 1: Target --}}
                <div class="seamless-card rounded-2xl p-5 flex flex-col items-center justify-center text-center hover:-translate-y-1 transition-all group">
                    <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mb-3 group-hover:scale-110 transition-transform">
                        <x-lucide-target class="w-6 h-6" stroke-width="2.5" />
                    </div>
                    <p class="text-xl font-black text-slate-800 leading-none">7.5</p>
                    <p class="text-[0.65rem] font-bold text-slate-400 mt-1 uppercase tracking-wider">IELTS Target</p>
                </div>
                
                {{-- Card 2: Band --}}
                <div class="seamless-card rounded-2xl p-5 flex flex-col items-center justify-center text-center hover:-translate-y-1 transition-all group">
                    <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 mb-3 group-hover:scale-110 transition-transform">
                        <x-lucide-bar-chart-2 class="w-6 h-6" stroke-width="2.5" />
                    </div>
                    <p class="text-xl font-black text-slate-800 leading-none">6.5</p>
                    <p class="text-[0.65rem] font-bold text-slate-400 mt-1 uppercase tracking-wider">Current Band</p>
                </div>

                {{-- Card 3: Mock Tests --}}
                <div class="seamless-card rounded-2xl p-5 flex flex-col items-center justify-center text-center hover:-translate-y-1 transition-all group">
                    <div class="w-12 h-12 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600 mb-3 group-hover:scale-110 transition-transform">
                        <x-lucide-file-text class="w-6 h-6" stroke-width="2.5" />
                    </div>
                    <p class="text-xl font-black text-slate-800 leading-none">12</p>
                    <p class="text-[0.65rem] font-bold text-slate-400 mt-1 uppercase tracking-wider">Mock Tests</p>
                </div>

                {{-- Card 4: Hours --}}
                <div class="seamless-card rounded-2xl p-5 flex flex-col items-center justify-center text-center hover:-translate-y-1 transition-all group">
                    <div class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-500 mb-3 group-hover:scale-110 transition-transform">
                        <x-lucide-clock class="w-6 h-6" stroke-width="2.5" />
                    </div>
                    <p class="text-xl font-black text-slate-800 leading-none flex items-baseline">48<span class="text-xs font-bold ml-0.5 text-slate-400">h</span></p>
                    <p class="text-[0.65rem] font-bold text-slate-400 mt-1 uppercase tracking-wider">Hours Spent</p>
                </div>
            </div>
        </div>

        {{-- 2. READY TO TAKE A TEST --}}
        <div class="seamless-card rounded-[2rem] p-6 lg:p-8 anim-in d2">
            <h2 class="font-heading text-lg font-bold text-slate-800 mb-5">Ready to take the exam?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                
                {{-- IELTS Card --}}
                <div class="border border-slate-100 bg-slate-50 rounded-2xl p-5 hover:border-brand-primary hover:shadow-md cursor-pointer transition-all text-center group relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-blue-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform"></div>
                    <div class="w-12 h-12 bg-white shadow-sm rounded-2xl mx-auto flex items-center justify-center text-blue-600 mb-4 group-hover:rotate-6 transition-transform border border-blue-50 font-black text-sm">
                        IELTS
                    </div>
                    <h3 class="font-heading font-bold text-slate-800 mb-1 text-sm">IELTS Simulation</h3>
                    <p class="text-[0.65rem] font-medium text-slate-500">Full 4 sections (L, R, W, S)</p>
                    <button class="mt-4 w-full py-2 bg-white text-brand-primary border border-slate-200 rounded-xl text-xs font-bold group-hover:bg-brand-primary group-hover:text-white transition-colors shadow-sm">Take Exam</button>
                </div>

                {{-- TOEIC Card --}}
                <div class="border border-slate-100 bg-slate-50 rounded-2xl p-5 hover:border-brand-primary hover:shadow-md cursor-pointer transition-all text-center group relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-emerald-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform"></div>
                    <div class="w-12 h-12 bg-white shadow-sm rounded-2xl mx-auto flex items-center justify-center text-emerald-600 mb-4 group-hover:rotate-6 transition-transform border border-emerald-50 font-black text-sm">
                        TOEIC
                    </div>
                    <h3 class="font-heading font-bold text-slate-800 mb-1 text-sm">TOEIC Simulation</h3>
                    <p class="text-[0.65rem] font-medium text-slate-500">Listening & Reading</p>
                    <button class="mt-4 w-full py-2 bg-white text-brand-primary border border-slate-200 rounded-xl text-xs font-bold group-hover:bg-brand-primary group-hover:text-white transition-colors shadow-sm">Take Exam</button>
                </div>

                {{-- TOEFL Card --}}
                <div class="border border-slate-100 bg-slate-50 rounded-2xl p-5 hover:border-brand-primary hover:shadow-md cursor-pointer transition-all text-center group relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-amber-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform"></div>
                    <div class="w-12 h-12 bg-white shadow-sm rounded-2xl mx-auto flex items-center justify-center text-amber-600 mb-4 group-hover:rotate-6 transition-transform border border-amber-50 font-black text-sm">
                        TOEFL
                    </div>
                    <h3 class="font-heading font-bold text-slate-800 mb-1 text-sm">TOEFL ITP / iBT</h3>
                    <p class="text-[0.65rem] font-medium text-slate-500">Academic language skills</p>
                    <button class="mt-4 w-full py-2 bg-white text-brand-primary border border-slate-200 rounded-xl text-xs font-bold group-hover:bg-brand-primary group-hover:text-white transition-colors shadow-sm">Take Exam</button>
                </div>

            </div>
        </div>

        {{-- 3. COURSE IN PROGRESS --}}
        <div class="seamless-card rounded-[2rem] p-6 lg:p-8 anim-in d3">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-5 gap-3">
                <div class="flex items-center gap-5">
                    <h2 class="font-heading text-lg font-bold text-slate-800">Course in Progress</h2>
                    <div class="text-[0.65rem] font-bold text-slate-400 flex gap-4 mt-0.5">
                        <span class="text-brand-primary border-b-[3px] border-brand-primary pb-1 cursor-pointer hover:text-brand-primary">All</span>
                        <span class="cursor-pointer border-b-[3px] border-transparent hover:text-slate-600 pb-1 transition-colors">Active</span>
                        <span class="cursor-pointer border-b-[3px] border-transparent hover:text-slate-600 pb-1 transition-colors">Completed</span>
                    </div>
                </div>
                <a href="#" class="text-[0.7rem] font-bold px-3 py-1.5 bg-brand-light text-brand-primary rounded-lg hover:bg-brand-primary hover:text-white transition-colors shadow-sm flex items-center justify-center gap-1.5 whitespace-nowrap">
                    <x-lucide-plus class="w-3.5 h-3.5" stroke-width="3" /> Add new 
                </a>
            </div>

            @php
                $courses = [
                    ['title' => 'IELTS Reading Master', 'level' => 'Advanced Level', 'category' => 'RD', 'progress' => 65, 'lessons' => '12/20', 'hours' => '4', 'color' => 'indigo', 'teacher' => 'Diana Harlow'],
                    ['title' => 'TOEFL Listening Build', 'level' => 'Intermediate Level', 'category' => 'LS', 'progress' => 45, 'lessons' => '5/12', 'hours' => '3', 'color' => 'emerald', 'teacher' => 'David Stone'],
                    ['title' => 'Grammar Builder', 'level' => 'Beginner Level', 'category' => 'GR', 'progress' => 88, 'lessons' => '22/25', 'hours' => '1', 'color' => 'amber', 'teacher' => 'Daniel Hill'],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($courses as $course)
                <div class="border border-slate-100 bg-slate-50 rounded-2xl p-5 hover:border-brand-secondary transition-colors shadow-sm flex flex-col group cursor-pointer">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-[10px] bg-{{ $course['color'] }}-100 text-{{ $course['color'] }}-600 flex items-center justify-center font-bold text-xs uppercase group-hover:scale-105 transition-transform">
                            {{ $course['category'] }}
                        </div>
                        <div>
                            <h3 class="font-heading font-black text-sm text-slate-800 leading-tight group-hover:text-brand-primary transition-colors">{{ $course['title'] }}</h3>
                            <p class="text-[0.65rem] text-slate-400 font-semibold">{{ $course['level'] }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4 text-[0.65rem] text-slate-400 font-bold mb-4 px-1">
                        <span class="flex items-center gap-1"><x-lucide-calendar class="w-3.5 h-3.5 text-slate-300" /> 90</span>
                        <span class="flex items-center gap-1"><x-lucide-clock class="w-3.5 h-3.5 text-slate-300" /> 90</span>
                        <span class="flex items-center gap-1"><x-lucide-users class="w-3.5 h-3.5 text-slate-300" /> 52</span>
                    </div>

                    <div class="mt-auto">
                        <div class="text-[0.65rem] font-bold text-slate-800 mb-1.5 px-0.5">{{ $course['progress'] }}% Finish</div>
                        <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden mb-3">
                            <div class="bg-{{ $course['color'] }}-500 h-full rounded-full transition-all duration-1000" style="width: {{ $course['progress'] }}%"></div>
                        </div>

                        <div class="flex items-center justify-between text-[0.6rem] text-slate-400 font-bold border-b border-slate-200 pb-3 mb-3">
                            <span class="flex items-center gap-1"><x-lucide-monitor-play class="w-3 h-3 text-slate-300" /> {{ $course['lessons'] }} Lessons</span>
                            <span>{{ $course['hours'] }} hours left</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($course['teacher']) }}&background=e2e8f0&color=64748b" class="w-7 h-7 rounded-full" alt="Teacher">
                                <div>
                                    <p class="text-[0.65rem] font-bold text-slate-800 leading-none">{{ $course['teacher'] }}</p>
                                    <p class="text-[0.55rem] text-slate-400 mt-0.5">Teacher</p>
                                </div>
                            </div>
                            <button class="text-[0.55rem] font-bold px-2.5 py-1 border border-slate-200 bg-white rounded-md text-slate-500 hover:bg-slate-100 transition-colors">Follow</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    <div class="xl:col-span-4 flex flex-col gap-6 lg:gap-8 anim-in d2">

        <div class="seamless-card rounded-[2rem] p-6 lg:p-8 flex flex-col gap-8 relative overflow-hidden">
            
            {{-- PROFILE INFO --}}
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-heading text-lg font-bold text-slate-800">Profile</h2>
                    <button class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-50 text-slate-400 transition-colors"><x-lucide-more-vertical class="w-5 h-5" /></button>
                </div>

                <div class="flex flex-col items-center mt-2 group cursor-pointer pt-2">
                    <div class="relative mb-5">
                        {{-- Circular progress outline --}}
                        <svg class="absolute inset-0 w-full h-full transform -rotate-90 group-hover:scale-105 transition-transform" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="48" fill="transparent" stroke="#f1f5f9" stroke-width="4" />
                            <circle cx="50" cy="50" r="48" fill="transparent" stroke="#1A456C" stroke-width="4" stroke-dasharray="300" stroke-dashoffset="100" class="transition-all duration-1000 group-hover:stroke-[#6FAFB5]" />
                        </svg>
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Archie Schmidt') }}&background=f8fafc&color=1A456C&size=120&bold=true" 
                            alt="Avatar" 
                            class="w-24 h-24 rounded-full border-[5px] border-white object-cover m-1 shadow-sm">
                    </div>

                    <h3 class="font-heading text-lg font-black text-slate-800 flex items-center gap-1.5 flex-wrap justify-center">
                        {{ auth()->user()->name ?? 'Archie Schmidt' }}
                        <x-lucide-badge-check class="w-4 h-4 text-brand-primary fill-brand-primary" stroke="white" />
                    </h3>
                    <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-wider">Student</p>
                </div>
            </div>

            {{-- Divider --}}
            <hr class="border-slate-100 border-dashed relative z-10" />

            {{-- STREAK INFO --}}
            <div class="relative z-10">
                {{-- Decorative background glow specifically for streak --}}
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-48 h-48 rounded-full bg-orange-50 blur-3xl pointer-events-none -z-10"></div>
                
                {{-- Header Streak --}}
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <img src="https://raw.githubusercontent.com/Tarikul-Islam-Anik/Animated-Fluent-Emojis/master/Emojis/Travel%20and%20places/Fire.png" alt="Fire" class="w-8 h-8 object-contain drop-shadow" />
                        <div>
                            <h3 class="font-heading font-black text-lg text-slate-800 tracking-tight">Your Streak</h3>
                            <p class="text-[0.65rem] text-slate-500 font-bold uppercase tracking-wider mt-0.5">Keep it going!</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-end">
                        <div class="bg-gradient-to-br from-orange-400 to-rose-500 text-white px-3 py-1 rounded-xl shadow-lg shadow-orange-500/20 flex items-center gap-1 transform hover:scale-105 transition-transform cursor-default">
                            <span class="text-base font-black drop-shadow-sm">3</span>
                            <span class="text-[0.6rem] font-bold uppercase tracking-wide opacity-90">Days</span>
                        </div>
                    </div>
                </div>

                {{-- Streak Days --}}
                @php
                    $streakDays = [
                        ['day' => 'Mon', 'short' => 'M', 'active' => true],
                        ['day' => 'Tue', 'short' => 'T', 'active' => true],
                        ['day' => 'Wed', 'short' => 'W', 'active' => true],
                        ['day' => 'Thu', 'short' => 'T', 'active' => false],
                        ['day' => 'Fri', 'short' => 'F', 'active' => false],
                        ['day' => 'Sat', 'short' => 'S', 'active' => false],
                        ['day' => 'Sun', 'short' => 'S', 'active' => false],
                    ];
                @endphp

                <div class="relative flex justify-between items-center mb-6">
                    {{-- Connecting line --}}
                    <div class="absolute top-1/2 left-3 right-3 h-1 bg-slate-100 -translate-y-1/2 z-0 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-orange-400 to-rose-400 transition-all duration-1000" style="width: 40%"></div>
                    </div>

                    @foreach($streakDays as $index => $status)
                        <div class="z-10 flex flex-col items-center gap-1.5 group">
                            @if($status['active'])
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-orange-400 to-amber-500 text-white flex items-center justify-center font-bold text-[0.65rem] ring-[3px] ring-white shadow-sm stroke-[3px]">
                                    <x-lucide-check class="w-4 h-4 ml-0.5" />
                                </div>
                                <span class="text-[0.6rem] font-extrabold text-orange-600">{{ $status['short'] }}</span>
                            @else
                                <div class="w-8 h-8 rounded-full bg-white border border-slate-200 text-slate-300 flex items-center justify-center ring-[3px] ring-white transition-all group-hover:border-orange-300">
                                    <div class="w-1.5 h-1.5 rounded-full bg-slate-200 group-hover:bg-orange-300 transition-colors"></div>
                                </div>
                                <span class="text-[0.6rem] font-bold text-slate-400 group-hover:text-slate-600 transition-colors">{{ $status['short'] }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- Motivational footer --}}
                <div class="bg-orange-50 rounded-2xl p-3 border border-orange-100 flex gap-3 items-center">
                    <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center flex-shrink-0 shadow-sm">
                        <img src="https://raw.githubusercontent.com/Tarikul-Islam-Anik/Animated-Fluent-Emojis/master/Emojis/Activities/Party%20Popper.png" alt="Party" class="w-4 h-4 object-contain" />
                    </div>
                    <div>
                        <p class="text-[0.65rem] text-slate-600 font-semibold leading-relaxed">
                            <span class="font-extrabold text-orange-600">4 more days</span> left to unlock a Premium Mock Test voucher!
                        </p>
                    </div>
                </div>
            </div>
            
        </div>

    </div>

</div>
@endsection