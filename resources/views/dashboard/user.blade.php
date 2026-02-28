<x-app-layout>
<div class="flex min-h-screen" style="background: #f0f4ff;">

    {{-- SIDEBAR --}}
    <aside class="hidden md:flex flex-col items-center w-16 py-8 gap-6 fixed h-full z-10"
           style="background: #ffffff; border-right: 1px solid #e8eef8;">

        {{-- Logo icon --}}
        <div class="mb-4">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                 style="background: linear-gradient(135deg, #3b82f6, #6366f1);">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.75 19 7.5 19s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        </div>

        {{-- Nav icons --}}
        @php
        $navItems = [
            ['icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'active' => true],
            ['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.75 19 7.5 19s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'active' => false],
            ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'active' => false],
            ['icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'active' => false],
            ['icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9', 'active' => false],
            ['icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'active' => false],
        ];
        @endphp

        @foreach($navItems as $item)
        <button class="w-10 h-10 rounded-xl flex items-center justify-center transition-all"
                style="{{ $item['active'] ? 'background: linear-gradient(135deg, #3b82f6, #6366f1); color: white;' : 'color: #94a3b8;' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $item['icon'] }}"/>
            </svg>
        </button>
        @endforeach

        {{-- Settings at bottom --}}
        <div class="mt-auto">
            <button class="w-10 h-10 rounded-xl flex items-center justify-center" style="color: #94a3b8;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </button>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 md:ml-16 p-6 overflow-y-auto">

        {{-- TOP NAV --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-lg font-semibold text-slate-700">Dashboard overview</h1>
            <div class="flex items-center gap-4">
                {{-- Search --}}
                <div class="relative">
                    <input type="text" placeholder="Search courses..."
                           class="rounded-full pl-10 pr-4 py-2 text-sm border-0 shadow-sm focus:ring-2 focus:ring-blue-300"
                           style="background: white; width: 200px;">
                    <svg class="w-4 h-4 absolute left-3 top-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                {{-- Notif --}}
                <button class="relative w-9 h-9 rounded-full flex items-center justify-center bg-white shadow-sm">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="absolute -top-0.5 -right-0.5 w-3 h-3 rounded-full text-white text-[8px] flex items-center justify-center font-bold"
                          style="background: #ef4444;">3</span>
                </button>
                {{-- Avatar --}}
                <div class="flex items-center gap-2">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=3b82f6&color=fff&size=36"
                         class="w-9 h-9 rounded-full shadow-sm" alt="avatar">
                    <div class="hidden lg:block">
                        <p class="text-sm font-semibold text-slate-800 leading-tight">{{ auth()->user()->name ?? 'Student' }}</p>
                        <p class="text-xs text-slate-500">{{ auth()->user()->email ?? '' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- GRID LAYOUT --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- ===== LEFT + CENTER (2/3) ===== --}}
            <div class="lg:col-span-2 flex flex-col gap-5">

                {{-- HERO BANNER --}}
                <div class="rounded-2xl p-7 relative overflow-hidden"
                     style="background: linear-gradient(135deg, #dbeafe 0%, #c7d2fe 60%, #bfdbfe 100%); min-height: 180px;">
                    <div class="relative z-10 max-w-xs">
                        <h2 class="text-3xl font-bold text-slate-800 leading-tight mb-2">
                            Hi, {{ auth()->user()->name ?? 'Student' }} 👋<br>
                            what do you want<br>to learn today?
                        </h2>
                        <p class="text-slate-500 text-sm mb-5">
                            Discover courses, track progress, and achieve your learning goals seamlessly.
                        </p>
                        <a href="#"
                           class="inline-block px-5 py-2.5 rounded-full text-sm font-semibold text-slate-700 bg-white shadow-md hover:shadow-lg transition">
                            Explore courses
                        </a>
                    </div>
                    {{-- Decorative blob --}}
                    <div class="absolute -right-10 -top-10 w-64 h-64 rounded-full opacity-30"
                         style="background: radial-gradient(circle, #6366f1, transparent 70%);"></div>
                    <div class="absolute right-16 bottom-0 w-40 h-40 rounded-full opacity-20"
                         style="background: radial-gradient(circle, #3b82f6, transparent 70%);"></div>
                    {{-- Illustration placeholder --}}
                    <img src="https://illustrations.popsy.co/blue/student-with-laptop.svg"
                         class="absolute right-8 bottom-0 h-40 opacity-90 hidden lg:block"
                         alt="student illustration"
                         onerror="this.style.display='none'">
                </div>

                {{-- COURSE CATEGORY CARDS (horizontal scroll) --}}
                <div>
                    <div class="flex gap-4 overflow-x-auto pb-2" style="scrollbar-width: none;">
                        @php
                        $categories = [
                            ['label' => 'IELTS Prep', 'count' => '24 Courses', 'color' => '#dbeafe', 'emoji' => '📝'],
                            ['label' => 'TOEFL Prep', 'count' => '18 Courses', 'color' => '#ede9fe', 'emoji' => '🎓'],
                            ['label' => 'Speaking', 'count' => '32 Courses', 'color' => '#dcfce7', 'emoji' => '🗣️'],
                            ['label' => 'Writing', 'count' => '15 Courses', 'color' => '#fef9c3', 'emoji' => '✍️'],
                            ['label' => 'Grammar', 'count' => '40 Courses', 'color' => '#fce7f3', 'emoji' => '📖'],
                        ];
                        @endphp
                        @foreach($categories as $cat)
                        <div class="flex-shrink-0 rounded-2xl p-4 cursor-pointer hover:shadow-md transition-all"
                             style="background: {{ $cat['color'] }}; min-width: 130px;">
                            <div class="text-3xl mb-3">{{ $cat['emoji'] }}</div>
                            <p class="text-sm font-semibold text-slate-700">{{ $cat['label'] }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $cat['count'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- STAT CARDS ROW --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    {{-- Courses Completed --}}
                    <div class="rounded-2xl p-5 bg-white shadow-sm flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0"
                             style="background: #eff6ff;">
                            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png"
                                 class="w-9 h-9" alt="trophy"
                                 onerror="this.src='https://via.placeholder.com/36'">
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-slate-800">12 <span class="text-base font-medium text-slate-500">Courses</span></p>
                            <p class="text-sm font-semibold text-slate-700">Completed</p>
                            <p class="text-xs text-slate-400 mt-0.5">Keep up the great work!</p>
                        </div>
                    </div>

                    {{-- App / Study Streak --}}
                    <div class="rounded-2xl p-5 bg-white shadow-sm flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0"
                             style="background: #f5f3ff;">
                            <img src="https://cdn-icons-png.flaticon.com/512/1828/1828884.png"
                                 class="w-9 h-9" alt="streak"
                                 onerror="this.src='https://via.placeholder.com/36'">
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-slate-800">7 <span class="text-base font-medium text-slate-500">Days</span></p>
                            <p class="text-sm font-semibold text-slate-700">Study Streak 🔥</p>
                            <p class="text-xs text-slate-400 mt-0.5">Don't break the chain!</p>
                        </div>
                    </div>

                </div>

                {{-- TODAY'S SCHEDULE --}}
                <div class="rounded-2xl bg-white shadow-sm p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-slate-800">Today's Schedule</h3>
                        <span class="text-xs text-blue-500 font-medium cursor-pointer hover:underline">View all</span>
                    </div>

                    {{-- Timeline --}}
                    <div class="flex text-xs text-slate-400 gap-0 mb-3 border-b pb-2" style="border-color: #f1f5f9;">
                        @foreach(['09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00'] as $t)
                        <div class="flex-1 text-center">{{ $t }}</div>
                        @endforeach
                    </div>

                    @php
                    $schedules = [
                        ['title' => 'IELTS Reading Practice', 'start' => 1, 'span' => 2, 'color' => '#dbeafe', 'text' => '#1d4ed8'],
                        ['title' => 'Grammar Workshop', 'start' => 3, 'span' => 2, 'color' => '#ede9fe', 'text' => '#6d28d9'],
                        ['title' => 'Speaking Session', 'start' => 5, 'span' => 2, 'color' => '#dcfce7', 'text' => '#15803d'],
                        ['title' => 'Vocabulary Quiz', 'start' => 2, 'span' => 3, 'color' => '#fef9c3', 'text' => '#a16207'],
                    ];
                    @endphp

                    <div class="space-y-2">
                        @foreach($schedules as $s)
                        <div class="flex items-center gap-2">
                            <div class="flex-shrink-0 w-1 h-8 rounded-full" style="background: {{ $s['text'] }};"></div>
                            <div class="flex-1 rounded-xl px-4 py-2 flex items-center gap-2"
                                 style="background: {{ $s['color'] }};">
                                <div class="w-6 h-6 rounded-full overflow-hidden flex-shrink-0">
                                    <img src="https://ui-avatars.com/api/?name=IC&background=3b82f6&color=fff&size=24" class="w-full h-full">
                                </div>
                                <span class="text-sm font-medium" style="color: {{ $s['text'] }};">{{ $s['title'] }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- ===== RIGHT COLUMN (1/3) ===== --}}
            <div class="flex flex-col gap-5">

                {{-- PERFORMANCE REPORT --}}
                <div class="rounded-2xl bg-white shadow-sm p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-slate-800">Performance Report</h3>
                        <button class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Avatar + Name --}}
                    <div class="flex flex-col items-center mb-5">
                        <div class="relative mb-3">
                            {{-- Donut ring --}}
                            <svg class="w-24 h-24 -rotate-90" viewBox="0 0 36 36">
                                <circle cx="18" cy="18" r="15.9" fill="none" stroke="#e8eef8" stroke-width="3"/>
                                <circle cx="18" cy="18" r="15.9" fill="none" stroke="url(#grad)" stroke-width="3"
                                        stroke-dasharray="70 30" stroke-linecap="round"/>
                                <defs>
                                    <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="0%">
                                        <stop offset="0%" style="stop-color:#3b82f6"/>
                                        <stop offset="100%" style="stop-color:#6366f1"/>
                                    </linearGradient>
                                </defs>
                            </svg>
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=3b82f6&color=fff&size=64"
                                 class="w-16 h-16 rounded-full absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 shadow-md"
                                 alt="avatar">
                        </div>
                        <p class="font-semibold text-slate-800">{{ auth()->user()->name ?? 'Student' }}</p>
                        <p class="text-xs text-slate-500">Intermediate Level</p>
                    </div>

                    {{-- Stats --}}
                    <div class="grid grid-cols-3 gap-2 text-center">
                        @php
                        $stats = [
                            ['label' => 'Course', 'value' => '80%', 'color' => '#3b82f6', 'bg' => '#eff6ff', 'icon' => '📚'],
                            ['label' => 'Badge', 'value' => '5', 'color' => '#6366f1', 'bg' => '#f5f3ff', 'icon' => '🏅'],
                            ['label' => 'Cert.', 'value' => '2', 'color' => '#f59e0b', 'bg' => '#fffbeb', 'icon' => '🏆'],
                        ];
                        @endphp
                        @foreach($stats as $s)
                        <div class="rounded-xl py-3 px-1" style="background: {{ $s['bg'] }};">
                            <p class="text-lg">{{ $s['icon'] }}</p>
                            <p class="text-sm font-bold mt-1" style="color: {{ $s['color'] }};">{{ $s['value'] }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $s['label'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- UPCOMING ASSIGNMENTS --}}
                <div class="rounded-2xl bg-white shadow-sm p-5">
                    <h3 class="font-semibold text-slate-800 mb-4">Upcoming Assignment</h3>

                    @php
                    $assignments = [
                        ['title' => 'IELTS Writing Task 2', 'due' => 'Due 25 Feb 2025 · 10:00 AM', 'color' => '#dbeafe', 'icon' => '✍️'],
                        ['title' => 'Pronunciation Exercise', 'due' => 'Due 26 Feb 2025 · 02:00 PM', 'color' => '#ede9fe', 'icon' => '🗣️'],
                        ['title' => 'Grammar Mock Test', 'due' => 'Due 28 Feb 2025 · 09:00 AM', 'color' => '#dcfce7', 'icon' => '📋'],
                    ];
                    @endphp

                    <div class="space-y-3">
                        @foreach($assignments as $a)
                        <div class="flex items-center gap-3 rounded-xl p-3" style="background: {{ $a['color'] }};">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center text-xl flex-shrink-0 bg-white shadow-sm">
                                {{ $a['icon'] }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-700">{{ $a['title'] }}</p>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $a['due'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- PROGRESS OVERVIEW --}}
                <div class="rounded-2xl bg-white shadow-sm p-5">
                    <h3 class="font-semibold text-slate-800 mb-4">Skills Progress</h3>
                    @php
                    $skills = [
                        ['label' => 'Listening', 'pct' => 75, 'color' => '#3b82f6'],
                        ['label' => 'Reading',   'pct' => 60, 'color' => '#6366f1'],
                        ['label' => 'Writing',   'pct' => 45, 'color' => '#f59e0b'],
                        ['label' => 'Speaking',  'pct' => 55, 'color' => '#10b981'],
                    ];
                    @endphp
                    <div class="space-y-3">
                        @foreach($skills as $sk)
                        <div>
                            <div class="flex justify-between text-xs text-slate-600 mb-1">
                                <span>{{ $sk['label'] }}</span>
                                <span class="font-semibold">{{ $sk['pct'] }}%</span>
                            </div>
                            <div class="w-full h-2 rounded-full" style="background: #e8eef8;">
                                <div class="h-2 rounded-full" style="width: {{ $sk['pct'] }}%; background: {{ $sk['color'] }};"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </main>
</div>
</x-app-layout>