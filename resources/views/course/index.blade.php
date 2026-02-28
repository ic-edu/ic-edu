<x-app-layout>
<div class="flex min-h-screen" style="background: #f8faff;">

    {{-- SIDEBAR --}}
    <aside class="hidden md:flex flex-col w-60 py-6 px-4 fixed h-full z-10 overflow-y-auto"
           style="background: #ffffff; border-right: 1px solid #eef0f6;">

        {{-- Logo --}}
        <div class="mb-8 px-2">
            <img src="{{ asset('assets/ic_edu_logo.png') }}" class="w-36 h-auto" alt="IC EDU">
        </div>

        {{-- Nav --}}
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
                ['label' => 'IELTS',    'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                ['label' => 'TOEFL',    'icon' => 'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222'],
                ['label' => 'TOEIC',    'icon' => 'M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z'],
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

        {{-- User profile bottom --}}
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
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Courses</h1>
                <p class="text-sm text-slate-500 mt-0.5">Discover and enroll in English learning courses.</p>
            </div>
            <div class="flex items-center gap-3">
                {{-- Search --}}
                <div class="relative">
                    <input type="text" placeholder="Search courses..."
                           class="rounded-xl pl-10 pr-4 py-2.5 text-sm border focus:ring-2 focus:ring-blue-300 focus:border-blue-300 outline-none"
                           style="background: #f8faff; border-color: #e2e8f0; width: 220px;">
                    <svg class="w-4 h-4 absolute left-3 top-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                {{-- New Course CTA --}}
                <a href="#"
                   class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white shadow-md hover:shadow-lg transition-all"
                   style="background: linear-gradient(135deg, #1e3a5f, #2563eb);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Enroll Course
                </a>
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="flex-1 px-8 py-6">

            {{-- FILTER TABS --}}
            <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
                <div class="flex gap-2 flex-wrap">
                    @php
                    $tabs = [
                        ['label' => 'All Courses', 'active' => true],
                        ['label' => 'Listening',   'active' => false],
                        ['label' => 'Speaking',    'active' => false],
                        ['label' => 'Reading',     'active' => false],
                        ['label' => 'Grammar',     'active' => false],
                        ['label' => 'Writing',     'active' => false],
                        ['label' => 'IELTS Prep',  'active' => false],
                        ['label' => 'TOEFL Prep',  'active' => false],
                    ];
                    @endphp
                    @foreach($tabs as $tab)
                    <button class="px-4 py-2 rounded-xl text-sm font-medium transition-all border"
                            style="{{ $tab['active']
                                ? 'background:#1e3a5f; color:white; border-color:#1e3a5f;'
                                : 'background:white; color:#64748b; border-color:#e2e8f0;' }}">
                        {{ $tab['label'] }}
                    </button>
                    @endforeach
                </div>
                {{-- View toggle --}}
                <div class="flex gap-1 bg-white border rounded-xl p-1" style="border-color: #e2e8f0;">
                    <button class="p-2 rounded-lg" style="background: #1e3a5f;">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 3h7v7H3V3zm11 0h7v7h-7V3zm0 11h7v7h-7v-7zM3 14h7v7H3v-7z"/>
                        </svg>
                    </button>
                    <button class="p-2 rounded-lg text-slate-400 hover:text-slate-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- COURSE GRID --}}
            @php
            $courses = [
                [
                    'category' => 'Listening',
                    'title'    => 'Advanced Listening Comprehension',
                    'desc'     => 'Master listening skills through real-world audio, podcasts, and IELTS listening exercises.',
                    'date'     => '10 Jan 2025',
                    'students' => '1,240',
                    'status'   => 'Published',
                    'level'    => 'Intermediate',
                    'lessons'  => 24,
                    'bg'       => '#dbeafe',
                    'badge_bg' => '#eff6ff',
                    'badge_tx' => '#1d4ed8',
                    'accent'   => '#3b82f6',
                    'emoji'    => '🎧',
                    'img_bg'   => 'linear-gradient(135deg, #bfdbfe 0%, #93c5fd 100%)',
                ],
                [
                    'category' => 'Speaking',
                    'title'    => 'Confident English Speaking',
                    'desc'     => 'Build fluency and confidence through structured speaking practice and pronunciation drills.',
                    'date'     => '12 Jan 2025',
                    'students' => '980',
                    'status'   => 'Published',
                    'level'    => 'Beginner',
                    'lessons'  => 18,
                    'bg'       => '#ede9fe',
                    'badge_bg' => '#f5f3ff',
                    'badge_tx' => '#6d28d9',
                    'accent'   => '#7c3aed',
                    'emoji'    => '🗣️',
                    'img_bg'   => 'linear-gradient(135deg, #ddd6fe 0%, #c4b5fd 100%)',
                ],
                [
                    'category' => 'Reading',
                    'title'    => 'Academic Reading Mastery',
                    'desc'     => 'Improve reading speed and comprehension with academic texts, skimming & scanning techniques.',
                    'date'     => '14 Jan 2025',
                    'students' => '760',
                    'status'   => 'Published',
                    'level'    => 'Advanced',
                    'lessons'  => 20,
                    'bg'       => '#dcfce7',
                    'badge_bg' => '#f0fdf4',
                    'badge_tx' => '#15803d',
                    'accent'   => '#16a34a',
                    'emoji'    => '📖',
                    'img_bg'   => 'linear-gradient(135deg, #bbf7d0 0%, #86efac 100%)',
                ],
                [
                    'category' => 'Grammar',
                    'title'    => 'English Grammar Essentials',
                    'desc'     => 'From tenses to complex sentence structures — build a solid grammar foundation step by step.',
                    'date'     => '15 Jan 2025',
                    'students' => '2,100',
                    'status'   => 'Published',
                    'level'    => 'Beginner',
                    'lessons'  => 32,
                    'bg'       => '#fef9c3',
                    'badge_bg' => '#fefce8',
                    'badge_tx' => '#a16207',
                    'accent'   => '#ca8a04',
                    'emoji'    => '✍️',
                    'img_bg'   => 'linear-gradient(135deg, #fef08a 0%, #fde047 100%)',
                ],
                [
                    'category' => 'Writing',
                    'title'    => 'IELTS Writing Task 1 & 2',
                    'desc'     => 'Learn how to write high-scoring essays and reports for IELTS with structured templates.',
                    'date'     => '16 Jan 2025',
                    'students' => '870',
                    'status'   => 'Published',
                    'level'    => 'Intermediate',
                    'lessons'  => 22,
                    'bg'       => '#fce7f3',
                    'badge_bg' => '#fdf2f8',
                    'badge_tx' => '#9d174d',
                    'accent'   => '#db2777',
                    'emoji'    => '📝',
                    'img_bg'   => 'linear-gradient(135deg, #fbcfe8 0%, #f9a8d4 100%)',
                ],
                [
                    'category' => 'IELTS Prep',
                    'title'    => 'Complete IELTS 7.0+ Program',
                    'desc'     => 'A comprehensive IELTS preparation covering all 4 skills with mock tests and scoring tips.',
                    'date'     => '18 Jan 2025',
                    'students' => '3,450',
                    'status'   => 'Published',
                    'level'    => 'All Levels',
                    'lessons'  => 48,
                    'bg'       => '#e0f2fe',
                    'badge_bg' => '#f0f9ff',
                    'badge_tx' => '#0369a1',
                    'accent'   => '#0284c7',
                    'emoji'    => '🏆',
                    'img_bg'   => 'linear-gradient(135deg, #bae6fd 0%, #7dd3fc 100%)',
                ],
            ];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($courses as $course)
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 group flex flex-col"
                     style="border: 1px solid #eef0f6;">

                    {{-- Illustration area --}}
                    <div class="relative h-48 flex items-center justify-center overflow-hidden"
                         style="background: {{ $course['img_bg'] }};">

                        {{-- Category badge --}}
                        <div class="absolute top-4 left-4 px-3 py-1.5 rounded-xl text-xs font-semibold shadow-sm"
                             style="background: white; color: {{ $course['badge_tx'] }};">
                            {{ $course['category'] }}
                        </div>

                        {{-- Level badge --}}
                        <div class="absolute top-4 right-4 px-3 py-1.5 rounded-xl text-xs font-medium"
                             style="background: rgba(255,255,255,0.7); color: #475569;">
                            {{ $course['level'] }}
                        </div>

                        {{-- Central emoji illustration --}}
                        <div class="text-7xl group-hover:scale-110 transition-transform duration-300 select-none">
                            {{ $course['emoji'] }}
                        </div>

                        {{-- Decorative circles --}}
                        <div class="absolute -bottom-4 -right-4 w-20 h-20 rounded-full opacity-30"
                             style="background: {{ $course['accent'] }};"></div>
                        <div class="absolute -top-4 -left-4 w-14 h-14 rounded-full opacity-20"
                             style="background: {{ $course['accent'] }};"></div>
                    </div>

                    {{-- Content --}}
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-bold text-slate-800 text-base leading-snug mb-2 group-hover:text-blue-700 transition-colors">
                            {{ $course['title'] }}
                        </h3>
                        <p class="text-xs text-slate-500 leading-relaxed mb-4 flex-1">
                            {{ $course['desc'] }}
                        </p>

                        {{-- Meta row --}}
                        <div class="grid grid-cols-3 gap-2 pt-4 border-t mb-4" style="border-color: #f1f5f9;">
                            <div>
                                <p class="text-xs text-slate-400 mb-0.5">Created</p>
                                <p class="text-xs font-semibold text-slate-700">{{ $course['date'] }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 mb-0.5">Students</p>
                                <p class="text-xs font-semibold text-slate-700">{{ $course['students'] }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 mb-0.5">Status</p>
                                <span class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold"
                                      style="background: #dcfce7; color: #15803d;">
                                    {{ $course['status'] }}
                                </span>
                            </div>
                        </div>

                        {{-- Lessons + CTA --}}
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $course['lessons'] }} Lessons</span>
                            </div>
                            <a href="{{ route('course.detail', 1) }}"
                               class="px-4 py-2 rounded-xl text-xs font-semibold text-white shadow-sm hover:shadow-md transition-all"
                               style="background: {{ $course['accent'] }};">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </main>
</div>
</x-app-layout>