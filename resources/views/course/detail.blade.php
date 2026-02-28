<x-app-layout>
<div class="flex min-h-screen" style="background: #f8faff;">

    {{-- SIDEBAR (sama persis dengan index) --}}
    <aside class="hidden md:flex flex-col w-60 py-6 px-4 fixed h-full z-10 overflow-y-auto"
           style="background: #ffffff; border-right: 1px solid #eef0f6;">

        <div class="mb-8 px-2">
            <img src="{{ asset('assets/ic_edu_logo.png') }}" class="w-36 h-auto" alt="IC EDU">
        </div>

        <nav class="flex flex-col gap-1 text-sm">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest px-3 mb-1">Main</p>
            @php
            $navMain = [
                ['label' => 'Dashboard',    'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'route' => 'dashboard', 'active' => false],
                ['label' => 'Courses',      'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.75 19 7.5 19s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'route' => 'course.index', 'active' => true],
                ['label' => 'My Progress',  'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'route' => '#', 'active' => false],
                ['label' => 'Schedule',     'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'route' => '#', 'active' => false],
                ['label' => 'Certificates', 'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z', 'route' => '#', 'active' => false],
            ];
            @endphp
            @foreach($navMain as $n)
            <a href="{{ $n['route'] !== '#' ? route($n['route']) : '#' }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-all"
               style="{{ $n['active'] ? 'background:#1e3a5f; color:white;' : 'color:#64748b;' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $n['icon'] }}"/>
                </svg>
                {{ $n['label'] }}
            </a>
            @endforeach

            <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest px-3 mt-5 mb-1">Exams</p>
            @php
            $navExams = [
                ['label' => 'IELTS',  'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                ['label' => 'TOEFL', 'icon' => 'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222'],
                ['label' => 'TOEIC', 'icon' => 'M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z'],
            ];
            @endphp
            @foreach($navExams as $n)
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-all" style="color:#64748b;">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $n['icon'] }}"/>
                </svg>
                {{ $n['label'] }}
            </a>
            @endforeach

            <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest px-3 mt-5 mb-1">Account</p>
            @php
            $navAccount = [
                ['label' => 'Notifications', 'icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'],
                ['label' => 'Settings',      'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
            ];
            @endphp
            @foreach($navAccount as $n)
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-all" style="color:#64748b;">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $n['icon'] }}"/>
                </svg>
                {{ $n['label'] }}
            </a>
            @endforeach
        </nav>

        <div class="mt-auto pt-4 border-t" style="border-color: #eef0f6;">
            <div class="flex items-center gap-3 px-2">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=1e3a5f&color=fff&size=36"
                     class="w-9 h-9 rounded-full flex-shrink-0" alt="avatar">
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-slate-800 truncate">{{ auth()->user()->name ?? 'Student' }}</p>
                    <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email ?? '' }}</p>
                </div>
            </div>
        </div>
    </aside>

    {{-- MAIN --}}
    <main class="flex-1 md:ml-60 flex flex-col min-h-screen">

        {{-- TOP BAR --}}
        <div class="sticky top-0 z-10 flex items-center justify-between px-8 py-4 bg-white border-b" style="border-color: #eef0f6;">
            <div class="flex items-center gap-3">
                {{-- Back button --}}
                <a href="{{ route('course.index') }}"
                   class="flex items-center justify-center w-9 h-9 rounded-xl border transition-all hover:bg-slate-50"
                   style="border-color: #e2e8f0;">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <div class="flex items-center gap-2 text-xs text-slate-400 mb-0.5">
                        <a href="{{ route('course.index') }}" class="hover:text-blue-600 transition-colors">Courses</a>
                        <span>/</span>
                        <span class="text-slate-600 font-medium">Advanced Listening Comprehension</span>
                    </div>
                    <h1 class="text-lg font-bold text-slate-900 leading-tight">Course Detail</h1>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium border transition-all hover:bg-slate-50"
                        style="border-color: #e2e8f0; color: #64748b;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                    Save
                </button>
                <button class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white shadow-md hover:shadow-lg transition-all"
                        style="background: linear-gradient(135deg, #1e3a5f, #2563eb);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Enroll Now
                </button>
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="flex-1 px-8 py-6">
            <div class="flex gap-6 items-start">

                {{-- ══ LEFT: MAIN CONTENT ══ --}}
                <div class="flex-1 min-w-0 flex flex-col gap-5">

                    {{-- HERO BANNER --}}
                    <div class="rounded-2xl overflow-hidden relative"
                         style="background: linear-gradient(135deg, #bfdbfe 0%, #93c5fd 60%, #dbeafe 100%); min-height: 220px;">
                        <div class="p-7 relative z-10">
                            {{-- Breadcrumb badge --}}
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold mb-4"
                                  style="background: white; color: #1d4ed8;">
                                🎧 Listening Course
                            </span>
                            <h2 class="text-2xl font-bold text-slate-900 mb-2 leading-snug max-w-lg">
                                Advanced Listening Comprehension
                            </h2>
                            <p class="text-slate-600 text-sm max-w-md leading-relaxed mb-5">
                                Master listening skills through real-world audio, podcasts, and IELTS listening exercises. Train your ear to understand any accent.
                            </p>
                            {{-- Quick meta --}}
                            <div class="flex flex-wrap gap-4">
                                @php
                                $metas = [
                                    ['⏱️','Duration','12 Hours'],
                                    ['📚','Lessons','24 Lessons'],
                                    ['🎯','Level','Intermediate'],
                                    ['🌐','Language','English'],
                                    ['📅','Updated','Jan 2025'],
                                ];
                                @endphp
                                @foreach($metas as [$icon,$label,$val])
                                <div class="flex items-center gap-1.5 bg-white/70 backdrop-blur rounded-xl px-3 py-1.5">
                                    <span class="text-sm">{{ $icon }}</span>
                                    <span class="text-xs text-slate-500">{{ $label }}:</span>
                                    <span class="text-xs font-semibold text-slate-700">{{ $val }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        {{-- Deco emoji --}}
                        <div class="absolute right-8 top-1/2 -translate-y-1/2 text-[100px] opacity-20 select-none hidden lg:block">
                            🎧
                        </div>
                        <div class="absolute -bottom-6 -right-6 w-32 h-32 rounded-full opacity-20"
                             style="background: #3b82f6;"></div>
                    </div>

                    {{-- TABS --}}
                    <div class="bg-white rounded-2xl border overflow-hidden" style="border-color: #eef0f6;">
                        <div class="flex border-b" style="border-color: #eef0f6;" id="courseTabs">
                            @php
                            $tabs = ['Overview','Curriculum','Instructor','Reviews'];
                            @endphp
                            @foreach($tabs as $i => $tab)
                            <button onclick="showTab('{{ strtolower($tab) }}')"
                                    id="tab-{{ strtolower($tab) }}"
                                    class="tab-btn px-6 py-3.5 text-sm font-semibold transition-all border-b-2 {{ $i === 0 ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
                                {{ $tab }}
                            </button>
                            @endforeach
                        </div>

                        {{-- TAB: OVERVIEW --}}
                        <div id="panel-overview" class="tab-panel p-6">
                            <h3 class="font-bold text-slate-800 mb-3">What You'll Learn</h3>
                            <div class="grid grid-cols-2 gap-2.5 mb-6">
                                @php
                                $learns = [
                                    'Understand native speaker conversations at natural speed',
                                    'Identify key information in lectures and podcasts',
                                    'Master all IELTS listening question types',
                                    'Develop note-taking strategies for academic listening',
                                    'Recognize different English accents (British, American, Australian)',
                                    'Improve listening stamina for long audio passages',
                                ];
                                @endphp
                                @foreach($learns as $item)
                                <div class="flex items-start gap-2.5">
                                    <div class="w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5"
                                         style="background: #dbeafe;">
                                        <svg class="w-3 h-3" fill="none" stroke="#1d4ed8" stroke-width="3" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-slate-600 leading-snug">{{ $item }}</span>
                                </div>
                                @endforeach
                            </div>

                            <div class="border-t pt-5" style="border-color: #eef0f6;">
                                <h3 class="font-bold text-slate-800 mb-3">Course Description</h3>
                                <div class="text-sm text-slate-600 leading-relaxed space-y-3">
                                    <p>This comprehensive listening course is designed for learners at the intermediate level who want to significantly improve their ability to understand spoken English in academic, professional, and everyday contexts.</p>
                                    <p>Through carefully graded audio materials — from natural conversations to academic lectures — you'll develop the listening strategies used by fluent English speakers. Each lesson includes authentic audio, comprehension checks, vocabulary focus, and targeted exercises.</p>
                                    <p>By the end of this course, you will feel confident tackling IELTS Listening sections, understanding fast-paced conversations, and extracting key information from a wide variety of audio sources.</p>
                                </div>
                            </div>

                            <div class="border-t pt-5 mt-5" style="border-color: #eef0f6;">
                                <h3 class="font-bold text-slate-800 mb-3">Requirements</h3>
                                <ul class="space-y-2">
                                    @foreach(['Pre-intermediate English level (A2+)','Headphones or speakers recommended','Commitment of at least 3–4 hours per week','No prior IELTS experience needed'] as $req)
                                    <li class="flex items-center gap-2.5 text-sm text-slate-600">
                                        <div class="w-1.5 h-1.5 rounded-full bg-blue-400 flex-shrink-0"></div>
                                        {{ $req }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        {{-- TAB: CURRICULUM --}}
                        <div id="panel-curriculum" class="tab-panel p-6 hidden">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="font-bold text-slate-800">Course Curriculum</h3>
                                    <p class="text-xs text-slate-500 mt-0.5">6 sections · 24 lessons · 12h total</p>
                                </div>
                                <button class="text-xs font-semibold text-blue-600 hover:underline">Expand All</button>
                            </div>

                            @php
                            $sections = [
                                ['Section 1: Foundations of Listening', [
                                    ['Introduction & Course Overview','5:20','free'],
                                    ['How English Sounds Work','12:45','free'],
                                    ['Stress, Rhythm & Intonation','15:30','locked'],
                                    ['Listening for Gist vs. Detail','14:10','locked'],
                                ]],
                                ['Section 2: Everyday Conversations', [
                                    ['Informal Conversations','18:00','locked'],
                                    ['Phone Calls & Voicemails','16:30','locked'],
                                    ['Discussions & Debates','20:15','locked'],
                                    ['News & Current Affairs','22:40','locked'],
                                ]],
                                ['Section 3: Academic Listening', [
                                    ['University Lectures – Part 1','25:00','locked'],
                                    ['University Lectures – Part 2','28:30','locked'],
                                    ['Seminars & Tutorials','24:15','locked'],
                                ]],
                                ['Section 4: IELTS Listening Practice', [
                                    ['IELTS Section 1 & 2 Strategies','20:00','locked'],
                                    ['IELTS Section 3 & 4 Strategies','22:00','locked'],
                                    ['Full Mock Test + Analysis','45:00','locked'],
                                ]],
                            ];
                            @endphp

                            <div class="space-y-3" id="curriculum-accordion">
                                @foreach($sections as $si => [$sTitle, $lessons])
                                <div class="border rounded-xl overflow-hidden" style="border-color: #eef0f6;">
                                    <button onclick="toggleSection({{ $si }})"
                                            class="w-full flex items-center justify-between px-4 py-3.5 text-left hover:bg-slate-50 transition-colors">
                                        <div class="flex items-center gap-3">
                                            <div class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-bold"
                                                 style="background: #dbeafe; color: #1d4ed8;">
                                                {{ $si + 1 }}
                                            </div>
                                            <span class="text-sm font-semibold text-slate-800">{{ $sTitle }}</span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <span class="text-xs text-slate-400">{{ count($lessons) }} lessons</span>
                                            <svg class="w-4 h-4 text-slate-400 transition-transform section-chevron-{{ $si }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </button>
                                    <div class="section-body-{{ $si }} border-t divide-y" style="border-color: #f1f5f9;">
                                        @foreach($lessons as $li => [$lTitle, $dur, $access])
                                        <div class="flex items-center justify-between px-4 py-3 hover:bg-slate-50/50 transition-colors">
                                            <div class="flex items-center gap-3">
                                                <div class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0"
                                                     style="background: {{ $access === 'free' ? '#dcfce7' : '#f1f5f9' }};">
                                                    @if($access === 'free')
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="#15803d" stroke-width="2.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                    </svg>
                                                    @else
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                    </svg>
                                                    @endif
                                                </div>
                                                <span class="text-sm text-slate-700">{{ $lTitle }}</span>
                                                @if($access === 'free')
                                                <span class="text-xs px-2 py-0.5 rounded-full font-semibold"
                                                      style="background: #dcfce7; color: #15803d;">Preview</span>
                                                @endif
                                            </div>
                                            <span class="text-xs text-slate-400 font-medium">{{ $dur }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- TAB: INSTRUCTOR --}}
                        <div id="panel-instructor" class="tab-panel p-6 hidden">
                            <div class="flex items-start gap-5 mb-6">
                                <img src="https://ui-avatars.com/api/?name=Sarah+Mitchell&background=1e3a5f&color=fff&size=96"
                                     class="w-20 h-20 rounded-2xl flex-shrink-0" alt="Instructor">
                                <div>
                                    <h3 class="font-bold text-slate-800 text-lg">Sarah Mitchell</h3>
                                    <p class="text-sm text-blue-600 font-medium mb-2">Senior English Language Instructor</p>
                                    <div class="flex flex-wrap gap-3 text-xs text-slate-500">
                                        <span class="flex items-center gap-1">⭐ 4.9 Rating</span>
                                        <span class="flex items-center gap-1">👥 3,240 Students</span>
                                        <span class="flex items-center gap-1">📚 8 Courses</span>
                                        <span class="flex items-center gap-1">🎓 12 Years Experience</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-sm text-slate-600 leading-relaxed space-y-3">
                                <p>Sarah Mitchell is a Cambridge-certified English language instructor with over 12 years of experience teaching IELTS, TOEFL, and academic English to students across Southeast Asia and Europe.</p>
                                <p>She holds a Master's degree in Applied Linguistics from the University of Edinburgh and has helped thousands of students achieve their target IELTS bands — many going from 5.5 to 7.5 within 6 months.</p>
                                <p>Her teaching philosophy centers on making listening practice engaging and contextually rich, using authentic materials rather than scripted exercises to prepare students for real-world English.</p>
                            </div>
                        </div>

                        {{-- TAB: REVIEWS --}}
                        <div id="panel-reviews" class="tab-panel p-6 hidden">
                            {{-- Rating summary --}}
                            <div class="flex gap-8 items-center mb-6 p-5 rounded-2xl" style="background: #f8faff;">
                                <div class="text-center flex-shrink-0">
                                    <div class="text-5xl font-bold text-slate-900" style="line-height:1;">4.8</div>
                                    <div class="text-yellow-400 text-lg my-1">★★★★★</div>
                                    <div class="text-xs text-slate-500">Course Rating</div>
                                </div>
                                <div class="flex-1">
                                    @php $bars = [[5,78],[4,15],[3,5],[2,1],[1,1]]; @endphp
                                    @foreach($bars as [$star,$pct])
                                    <div class="flex items-center gap-2.5 mb-1.5">
                                        <span class="text-xs text-slate-500 w-4 text-right">{{ $star }}</span>
                                        <span class="text-yellow-400 text-xs">★</span>
                                        <div class="flex-1 h-2 rounded-full" style="background: #e2e8f0;">
                                            <div class="h-2 rounded-full" style="width:{{ $pct }}%; background: #f59e0b;"></div>
                                        </div>
                                        <span class="text-xs text-slate-500 w-8">{{ $pct }}%</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Review cards --}}
                            <div class="space-y-4">
                                @php
                                $reviews = [
                                    ['Rina K','3b82f6','5','2 weeks ago','This course completely changed my approach to listening. Sarah\'s explanations are crystal clear and the audio materials feel very authentic. My IELTS listening jumped from 6.0 to 7.5!'],
                                    ['Budi S','6366f1','5','1 month ago','Excellent structure. I especially loved the IELTS mock section — it\'s exactly like the real test. The note-taking strategies alone were worth enrolling.'],
                                    ['Dian A','0d9488','4','3 weeks ago','Great course overall. Some lessons could be a bit shorter but the content quality is top-notch. Would definitely recommend to anyone preparing for IELTS.'],
                                ];
                                @endphp
                                @foreach($reviews as [$name,$color,$rating,$time,$text])
                                <div class="flex gap-4 p-4 rounded-2xl border" style="border-color: #eef0f6;">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($name) }}&background={{ $color }}&color=fff&size=64"
                                         class="w-10 h-10 rounded-full flex-shrink-0" alt="{{ $name }}">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-sm font-bold text-slate-800">{{ $name }}</span>
                                            <span class="text-xs text-slate-400">{{ $time }}</span>
                                        </div>
                                        <div class="text-yellow-400 text-xs mb-2">{{ str_repeat('★', (int)$rating) }}</div>
                                        <p class="text-sm text-slate-600 leading-relaxed">{{ $text }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>

                {{-- ══ RIGHT: STICKY ENROLLMENT CARD ══ --}}
                <div class="w-80 flex-shrink-0">
                    <div class="sticky top-24 flex flex-col gap-4">

                        {{-- Enrollment card --}}
                        <div class="bg-white rounded-2xl border overflow-hidden shadow-sm" style="border-color: #eef0f6;">

                            {{-- Thumbnail --}}
                            <div class="h-44 flex items-center justify-center relative"
                                 style="background: linear-gradient(135deg, #bfdbfe 0%, #93c5fd 100%);">
                                <span class="text-7xl select-none">🎧</span>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <button class="w-14 h-14 rounded-full bg-white/80 backdrop-blur flex items-center justify-center shadow-lg hover:bg-white transition-all hover:scale-105">
                                        <svg class="w-6 h-6 text-blue-600 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                    </button>
                                </div>
                                <span class="absolute top-3 right-3 bg-white/90 text-xs font-bold text-blue-700 px-2.5 py-1 rounded-full">Preview</span>
                            </div>

                            <div class="p-5">
                                {{-- Price --}}
                                <div class="flex items-baseline gap-2 mb-1">
                                    <span class="text-2xl font-bold text-slate-900">Rp 299.000</span>
                                </div>
                                <p class="text-xs text-slate-400 mb-4">One-time payment · Lifetime access</p>

                                {{-- CTA --}}
                                <button class="w-full py-3 rounded-xl text-sm font-bold text-white mb-2.5 transition-all hover:shadow-lg hover:-translate-y-0.5"
                                        style="background: linear-gradient(135deg, #1e3a5f, #2563eb);">
                                    Enroll Now
                                </button>
                                <button class="w-full py-3 rounded-xl text-sm font-semibold border transition-all hover:bg-slate-50"
                                        style="border-color: #e2e8f0; color: #475569;">
                                    Try Free Preview
                                </button>

                                <p class="text-center text-xs text-slate-400 mt-3">30-day money-back guarantee</p>

                                {{-- Includes --}}
                                <div class="border-t mt-4 pt-4" style="border-color: #eef0f6;">
                                    <p class="text-xs font-bold text-slate-700 mb-3 uppercase tracking-wide">This course includes:</p>
                                    @php
                                    $includes = [
                                        ['📺','12 hours of on-demand video'],
                                        ['📄','24 downloadable resources'],
                                        ['📱','Mobile & desktop access'],
                                        ['🔁','Unlimited replay access'],
                                        ['🏅','Certificate of completion'],
                                        ['💬','Community discussion access'],
                                    ];
                                    @endphp
                                    <div class="space-y-2">
                                        @foreach($includes as [$icon,$text])
                                        <div class="flex items-center gap-2.5 text-xs text-slate-600">
                                            <span>{{ $icon }}</span>
                                            <span>{{ $text }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Share card --}}
                        <div class="bg-white rounded-2xl border p-4" style="border-color: #eef0f6;">
                            <p class="text-xs font-bold text-slate-700 mb-3 uppercase tracking-wide">Share this course</p>
                            <div class="flex gap-2">
                                @foreach(['WhatsApp','Twitter','LinkedIn','Copy Link'] as $s)
                                <button class="flex-1 py-2 rounded-xl text-xs font-semibold border transition-all hover:bg-slate-50"
                                        style="border-color: #e2e8f0; color: #475569;">
                                    {{ $s === 'Copy Link' ? '🔗' : ($s === 'WhatsApp' ? '💬' : ($s === 'Twitter' ? '𝕏' : 'in')) }}
                                </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Related courses --}}
                        <div class="bg-white rounded-2xl border p-4" style="border-color: #eef0f6;">
                            <p class="text-xs font-bold text-slate-700 mb-3 uppercase tracking-wide">Related Courses</p>
                            @php
                            $related = [
                                ['🗣️','Confident English Speaking','#ede9fe','#7c3aed','18 Lessons'],
                                ['📖','Academic Reading Mastery','#dcfce7','#16a34a','20 Lessons'],
                            ];
                            @endphp
                            <div class="space-y-3">
                                @foreach($related as [$emoji,$title,$bg,$accent,$lessons])
                                <a href="#" class="flex items-center gap-3 p-3 rounded-xl transition-all hover:shadow-sm group"
                                   style="background: {{ $bg }};">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl flex-shrink-0 bg-white shadow-sm">
                                        {{ $emoji }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-semibold text-slate-800 leading-snug group-hover:text-blue-700 transition-colors truncate">{{ $title }}</p>
                                        <p class="text-xs mt-0.5" style="color: {{ $accent }};">{{ $lessons }}</p>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </main>
</div>

<script>
    // ── TAB SWITCHING ──
    function showTab(name) {
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
        document.querySelectorAll('.tab-btn').forEach(b => {
            b.classList.remove('border-blue-600','text-blue-600');
            b.classList.add('border-transparent','text-slate-500');
        });
        document.getElementById('panel-' + name).classList.remove('hidden');
        const btn = document.getElementById('tab-' + name);
        btn.classList.add('border-blue-600','text-blue-600');
        btn.classList.remove('border-transparent','text-slate-500');
    }

    // ── CURRICULUM ACCORDION ──
    function toggleSection(i) {
        const body = document.querySelector('.section-body-' + i);
        const chevron = document.querySelector('.section-chevron-' + i);
        const isHidden = body.style.display === 'none' || body.style.display === '';
        body.style.display = isHidden ? 'block' : 'none';
        chevron.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
    }
    // Open first section by default
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[class^="section-body-"]').forEach((el, i) => {
            el.style.display = i === 0 ? 'block' : 'none';
        });
    });
</script>

</x-app-layout>