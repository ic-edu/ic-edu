@extends('layouts.test_taker')
@section('title', 'Dashboard')

@section('content')
{{-- PAGE HEADER HERO --}}
<div class="relative w-full rounded-[2rem] bg-brand-primary p-8 lg:p-10 text-white mb-8 overflow-hidden shadow-xl shadow-brand-primary/10 anim-in d1 flex items-center justify-start gap-8 lg:gap-12">
    {{-- Glassmorphic Notification Bell --}}
    <div class="absolute top-6 right-6 z-20">
        @php
            $unreadCount = auth()->user()->unreadNotifications->count();
        @endphp
        <button onclick="openNotifPanel()" class="w-10 h-10 rounded-2xl bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all duration-200 backdrop-blur-md relative border border-white/10 active:scale-95 group/notif" aria-label="Open notifications">
            <x-lucide-bell class="w-5 h-5 transition-transform group-hover/notif:rotate-12" />
            @if($unreadCount > 0)
                <div class="absolute top-2.5 right-2.5 w-2.5 h-2.5 bg-rose-500 rounded-full ring-2 ring-brand-primary animate-pulse"></div>
            @endif
        </button>
    </div>

    {{-- Decorative Background Elements --}}
    <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/2 pointer-events-none"></div>
    <div class="absolute bottom-0 left-10 w-32 h-32 bg-brand-secondary opacity-20 rounded-full blur-2xl pointer-events-none"></div>
    
    {{-- Hero Mascot Container (now on the left) --}}
    <div id="hero-mascot" class="relative z-10 items-center justify-center self-stretch min-w-[130px] lg:min-w-[160px]" style="display:flex; perspective: 600px;">
        <img id="mascot-img" src="{{ asset('assets/maskot/hero.png') }}" 
             alt="Mascot" 
             class="object-contain w-24 lg:w-40 xl:w-48 select-none mascot-3d" 
             draggable="false" />
    </div>

    {{-- Text Content --}}
    <div class="relative z-10 max-w-xl">
        <h1 class="text-3xl lg:text-4xl !text-white font-black font-heading tracking-tight mb-2 flex items-center gap-2">
            @php
                $hour = date('H');
                if ($hour < 12) $greeting = 'Good Morning';
                elseif ($hour < 18) $greeting = 'Good Afternoon';
                else $greeting = 'Good Evening';
            @endphp
            {{ $greeting }}, {{ explode(' ', auth()->user()->name)[0] ?? 'Student' }}! 
            <span class="inline-block transform origin-bottom-right hover:rotate-12 transition-transform cursor-default">👋</span>
        </h1>
        <p class="text-blue-100 font-medium text-sm lg:text-base mb-6 leading-relaxed">
            @if($activeEnrollments->isNotEmpty())
                @php $firstEnrollment = $activeEnrollments->first(); @endphp
                @if($firstEnrollment->progress_pct >= 100)
                    You've completed <span class="font-bold text-white">"{{ $firstEnrollment->course->title }}"</span>! 🎉
                    Amazing work — explore more courses to keep growing.
                @else
                    You're <span class="font-bold text-white">{{ $firstEnrollment->progress_pct }}% through</span>
                    <span class="font-bold text-white">"{{ $firstEnrollment->course->title }}"</span> — keep going, you're doing great!
                @endif
            @elseif($finishedExams > 0)
                Great work on completing {{ $finishedExams }} exam{{ $finishedExams > 1 ? 's' : '' }}! 
                Ready to take the next step? Browse a course to level up your skills. 🎯
            @else
                Welcome aboard! 🎉 Start your learning journey by enrolling in a course or taking a mock exam.
            @endif
        </p>
        
        @if($activeEnrollments->isNotEmpty())
            <a href="{{ route('test_taker.course.show', $activeEnrollments->first()->course->id) }}" class="inline-flex items-center gap-2 bg-white text-brand-primary font-bold px-5 py-2.5 rounded-xl hover:bg-slate-50 hover:scale-105 transition-all shadow-md text-sm">
                <x-lucide-play class="w-4 h-4 fill-brand-primary" />
                Resume Learning
            </a>
        @else
            <a href="{{ route('test_taker.course.index') }}" class="inline-flex items-center gap-2 bg-white text-brand-primary font-bold px-5 py-2.5 rounded-xl hover:bg-slate-50 hover:scale-105 transition-all shadow-md text-sm">
                <x-lucide-search class="w-4 h-4" />
                Find a Course
            </a>
        @endif
    </div>
</div>

<style>
    @media (max-width: 767px) {
        #hero-mascot { display: none !important; }
    }
    
    .mascot-3d {
        transform-style: preserve-3d;
        filter: drop-shadow(0 20px 30px rgba(0,0,0,0.25));
        transition: filter 0.3s ease, transform 0.15s ease-out;
        will-change: transform;
    }
    
    .mascot-3d.tilting {
        filter: drop-shadow(0 30px 40px rgba(0,0,0,0.35));
    }
</style>

<script>
    (function() {
        const mascot = document.getElementById('mascot-img');
        const banner = document.querySelector('#hero-mascot');
        if (!mascot || !banner) return;

        banner.addEventListener('mousemove', function(e) {
            const rect = mascot.getBoundingClientRect();
            const cx = rect.left + rect.width / 2;
            const cy = rect.top + rect.height / 2;
            const dx = (e.clientX - cx) / (rect.width / 2);
            const dy = (e.clientY - cy) / (rect.height / 2);
            const rotX = (-dy * 18).toFixed(1);
            const rotY = (dx * 18).toFixed(1);
            const lift = (-Math.abs(dy) * 6 - 12).toFixed(1);

            mascot.classList.add('tilting');
            mascot.style.transform = `translateY(${lift}px) rotateX(${rotX}deg) rotateY(${rotY}deg) scale(1.05)`;
        });

        banner.addEventListener('mouseleave', function() {
            mascot.classList.remove('tilting');
            mascot.style.transform = '';
        });
    })();
</script>

<div class="grid grid-cols-1 xl:grid-cols-12 gap-6 lg:gap-8">
    
    <div class="xl:col-span-8 flex flex-col gap-6 lg:gap-8">

        {{-- 1. OVERVIEW CARDS --}}
        <div class="anim-in d2">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                {{-- Card 1: Average Score --}}
                <div class="seamless-card rounded-2xl p-5 flex flex-col items-center justify-center text-center hover:-translate-y-1 transition-all group relative">
                    @if(!empty($avgScoresGrouped) && count($avgScoresGrouped) > 0)
                        <div class="absolute top-2.5 right-2.5 z-10">
                            <select id="avgScoreTypeSelector" class="text-[0.55rem] border-0 bg-slate-50 hover:bg-slate-100 text-slate-500 hover:text-brand-primary font-bold focus:ring-0 py-0.5 pl-1.5 pr-6 rounded-lg cursor-pointer transition-all shadow-sm" onchange="updateAvgScoreDisplay(this.value)">
                                @foreach($avgScoresGrouped as $typeName => $score)
                                    <option value="{{ $typeName }}">{{ $typeName }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mb-3 group-hover:scale-110 transition-transform">
                        <x-lucide-target class="w-6 h-6" stroke-width="2.5" />
                    </div>
                    @php
                        $firstTypeName = !empty($avgScoresGrouped) ? array_key_first($avgScoresGrouped) : null;
                        $displayScore = $firstTypeName ? $avgScoresGrouped[$firstTypeName] : 0.0;
                    @endphp
                    <p id="avgScoreDisplay" class="text-xl font-black text-slate-800 leading-none">{{ number_format($displayScore, 1) }}</p>
                    <p class="text-[0.65rem] font-bold text-slate-400 mt-1 uppercase tracking-wider">Avg. Score</p>
                </div>
                
                {{-- Card 2: Active Courses --}}
                <div class="seamless-card rounded-2xl p-5 flex flex-col items-center justify-center text-center hover:-translate-y-1 transition-all group">
                    <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 mb-3 group-hover:scale-110 transition-transform">
                        <x-lucide-book-open class="w-6 h-6" stroke-width="2.5" />
                    </div>
                    <p class="text-xl font-black text-slate-800 leading-none">{{ $activeCourses }}</p>
                    <p class="text-[0.65rem] font-bold text-slate-400 mt-1 uppercase tracking-wider">Active Courses</p>
                </div>

                {{-- Card 3: Mock Tests --}}
                <div class="seamless-card rounded-2xl p-5 flex flex-col items-center justify-center text-center hover:-translate-y-1 transition-all group">
                    <div class="w-12 h-12 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600 mb-3 group-hover:scale-110 transition-transform">
                        <x-lucide-file-text class="w-6 h-6" stroke-width="2.5" />
                    </div>
                    <p class="text-xl font-black text-slate-800 leading-none">{{ $finishedExams }}</p>
                    <p class="text-[0.65rem] font-bold text-slate-400 mt-1 uppercase tracking-wider">Mock Tests</p>
                </div>

                {{-- Card 4: Pending Exams --}}
                <div class="seamless-card rounded-2xl p-5 flex flex-col items-center justify-center text-center hover:-translate-y-1 transition-all group">
                    <div class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-500 mb-3 group-hover:scale-110 transition-transform">
                        <x-lucide-clock class="w-6 h-6" stroke-width="2.5" />
                    </div>
                    <p class="text-xl font-black text-slate-800 leading-none">{{ $inProgressExams }}</p>
                    <p class="text-[0.65rem] font-bold text-slate-400 mt-1 uppercase tracking-wider">Pending Exams</p>
                </div>
            </div>
        </div>

        {{-- 2. SCORE PROGRESSION CHART --}}
        <div class="seamless-card rounded-[2rem] p-6 lg:p-8 anim-in d2">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-heading text-lg font-bold text-slate-800">Score Progression</h2>
                @if(!empty($chartDataGrouped))
                    <select id="chartExamTypeSelector" class="text-[0.65rem] border-slate-200 rounded-full text-brand-primary font-bold focus:ring-brand-primary bg-slate-50 shadow-sm py-1 pl-3 pr-8 cursor-pointer hover:bg-slate-100 transition-colors" onchange="updateChartData()">
                        @foreach($chartDataGrouped as $typeName => $data)
                            <option value="{{ $typeName }}">{{ $typeName }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
            @if(empty($chartDataGrouped))
                <div class="text-center py-8 border border-dashed border-slate-200 rounded-xl bg-slate-50">
                    <p class="text-sm text-slate-500 mb-2">No completed exams yet.</p>
                    <p class="text-xs text-slate-400">Take a mock test to see your progress chart!</p>
                </div>
            @else
                <div id="scoreChart" class="w-full h-[250px]"></div>
            @endif
        </div>

        {{-- 3. READY TO TAKE A TEST --}}
        <div class="seamless-card rounded-[2rem] p-6 lg:p-8 anim-in d2">
            <h2 class="font-heading text-lg font-bold text-slate-800 mb-5">Ready to take the exam?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                
                @forelse($examCategories->take(3) as $category)
                @php
                    $colors = ['blue', 'emerald', 'amber', 'purple', 'rose'];
                    $color = $colors[$loop->index % count($colors)];
                @endphp
                <div class="border border-slate-100 bg-slate-50 rounded-2xl p-5 hover:border-brand-primary hover:shadow-md cursor-pointer transition-all text-center group relative overflow-hidden flex flex-col">
                    <div class="absolute top-0 left-0 w-full h-1 bg-{{ $color }}-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform"></div>
                    <div class="w-12 h-12 bg-white shadow-sm rounded-2xl mx-auto flex items-center justify-center text-{{ $color }}-600 mb-4 group-hover:rotate-6 transition-transform border border-{{ $color }}-50 font-black text-sm uppercase">
                        {{ substr($category->name, 0, 5) }}
                    </div>
                    <h3 class="font-heading font-bold text-slate-800 mb-1 text-sm">{{ $category->name }}</h3>
                    <p class="text-[0.65rem] font-medium text-slate-500">{{ $category->exams_count }} exams available</p>
                    <a href="{{ route('test_taker.exam.index') }}" class="mt-auto pt-4 w-full block py-2 bg-white text-brand-primary border border-slate-200 rounded-xl text-xs font-bold group-hover:bg-brand-primary group-hover:text-white transition-colors shadow-sm">Take Exam</a>
                </div>
                @empty
                <div class="col-span-3 text-center py-4 text-slate-500 text-sm">
                    No exams available at the moment.
                </div>
                @endforelse

            </div>
        </div>

        {{-- 4. COURSE IN PROGRESS --}}
        <div class="seamless-card rounded-[2rem] p-6 lg:p-8 anim-in d3">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-5 gap-3">
                <div class="flex items-center gap-5">
                    <h2 class="font-heading text-lg font-bold text-slate-800">Course in Progress</h2>
                </div>
                <a href="{{ route('test_taker.course.index') }}" class="text-[0.7rem] font-bold px-3 py-1.5 bg-brand-light text-brand-primary rounded-lg hover:bg-brand-primary hover:text-white transition-colors shadow-sm flex items-center justify-center gap-1.5 whitespace-nowrap">
                    <x-lucide-search class="w-3.5 h-3.5" stroke-width="3" /> Browse Courses 
                </a>
            </div>

            @if($activeEnrollments->isEmpty())
                <div class="text-center py-10 px-4">
                    <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <x-lucide-book-open class="w-8 h-8 text-slate-300" />
                    </div>
                    <h3 class="font-heading font-bold text-slate-700 mb-1">No courses yet</h3>
                    <p class="text-sm text-slate-400 mb-5">Enroll in a course and start learning today!</p>
                    <a href="{{ route('test_taker.course.index') }}" class="inline-flex items-center gap-2 bg-brand-primary text-white font-bold px-5 py-2.5 rounded-xl hover:opacity-90 transition-all shadow-md text-sm">
                        <x-lucide-search class="w-4 h-4" /> Browse Courses
                    </a>
                </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($activeEnrollments as $enrollment)
                @php
                    $course = $enrollment->course;
                    $colors = ['indigo', 'emerald', 'amber', 'rose', 'blue'];
                    $color = $colors[$loop->index % count($colors)];
                    $tl = is_array($course->target_level) ? ($course->target_level[0] ?? 'All Levels') : ($course->target_level ?? 'All Levels');
                    $resumeUrl = $enrollment->last_lesson_id 
                        ? route('test_taker.course.lesson', ['course' => $course->id, 'lesson' => $enrollment->last_lesson_id])
                        : route('test_taker.course.show', $course->id);
                @endphp
                <a href="{{ $resumeUrl }}" class="border border-slate-100 bg-slate-50 rounded-2xl p-5 hover:border-brand-secondary transition-colors shadow-sm flex flex-col group cursor-pointer text-left">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-[10px] bg-{{ $color }}-100 text-{{ $color }}-600 flex items-center justify-center font-bold text-xs uppercase group-hover:scale-105 transition-transform">
                            {{ substr($course->title, 0, 2) }}
                        </div>
                        <div>
                            <h3 class="font-heading font-black text-sm text-slate-800 leading-tight group-hover:text-brand-primary transition-colors whitespace-nowrap overflow-hidden text-ellipsis max-w-[140px]">{{ $course->title }}</h3>
                            <p class="text-[0.65rem] text-slate-400 font-semibold">{{ $tl }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4 text-[0.65rem] text-slate-400 font-bold mb-4 px-1">
                        <span class="flex items-center gap-1"><x-lucide-layers class="w-3.5 h-3.5 text-slate-300" /> {{ $course->modules->count() }} Modules</span>
                    </div>

                    <div class="mt-auto">
                        <div class="text-[0.65rem] font-bold text-slate-800 mb-1.5 px-0.5">{{ $enrollment->progress_pct }}% Complete</div>
                        <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden mb-3">
                            <div class="bg-{{ $color }}-500 h-full rounded-full transition-all duration-1000" style="width: {{ $enrollment->progress_pct }}%"></div>
                        </div>

                        <div class="flex items-center justify-between text-[0.6rem] text-slate-400 font-bold">
                            <span class="flex items-center gap-1"><x-lucide-monitor-play class="w-3 h-3 text-slate-300" /> {{ $enrollment->completed_lessons }}/{{ $enrollment->total_lessons }} Lessons</span>
                            <span class="text-brand-primary group-hover:underline">Continue →</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
        </div>

    </div>

    <div class="xl:col-span-4 flex flex-col gap-6 lg:gap-8 anim-in d2">

        {{-- WEEKLY GOAL CARD --}}
        <div class="seamless-card rounded-[2rem] p-6 lg:p-7 relative overflow-hidden">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-48 h-48 rounded-full bg-orange-50 blur-3xl pointer-events-none -z-10"></div>
            
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <img src="https://raw.githubusercontent.com/Tarikul-Islam-Anik/Animated-Fluent-Emojis/master/Emojis/Travel%20and%20places/Fire.png" alt="Fire" class="w-8 h-8 object-contain drop-shadow" />
                    <div>
                        <h3 class="font-heading font-black text-lg text-slate-800 tracking-tight">Weekly Goal</h3>
                        <p class="text-[0.65rem] text-slate-500 font-bold uppercase tracking-wider mt-0.5">Keep the momentum!</p>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-orange-400 to-rose-500 text-white px-3 py-1 rounded-xl shadow-lg shadow-orange-500/20 flex items-center gap-1">
                    <span class="text-base font-black drop-shadow-sm">{{ $activeDaysCount }}</span>
                    <span class="text-[0.6rem] font-bold uppercase tracking-wide opacity-90">Days</span>
                </div>
            </div>

            <div class="relative flex justify-between items-center mb-6">
                <div class="absolute top-1/2 left-3 right-3 h-1 bg-slate-100 -translate-y-1/2 z-0 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-orange-400 to-rose-400 transition-all duration-1000" style="width: {{ ($activeDaysCount / 7) * 100 }}%"></div>
                </div>
                @foreach($streakDays as $status)
                    <div class="z-10 flex flex-col items-center gap-1.5 group">
                        @if($status['active'])
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-orange-400 to-amber-500 text-white flex items-center justify-center font-bold text-[0.65rem] ring-[3px] ring-white shadow-sm">
                                <x-lucide-check class="w-4 h-4 ml-0.5" />
                            </div>
                            <span class="text-[0.6rem] font-extrabold text-orange-600">{{ $status['short'] }}</span>
                        @else
                            <div class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center ring-[3px] ring-white {{ $status['is_today'] ? 'border-orange-400 ring-orange-50' : 'group-hover:border-orange-300' }} transition-all">
                                <div class="w-1.5 h-1.5 rounded-full {{ $status['is_today'] ? 'bg-orange-400' : 'bg-slate-200 group-hover:bg-orange-300' }} transition-colors"></div>
                            </div>
                            <span class="text-[0.6rem] font-bold {{ $status['is_today'] ? 'text-orange-500' : 'text-slate-400' }} transition-colors">{{ $status['short'] }}</span>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="bg-orange-50 rounded-2xl p-3 border border-orange-100 flex gap-3 items-center">
                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center flex-shrink-0 shadow-sm">
                    <img src="https://raw.githubusercontent.com/Tarikul-Islam-Anik/Animated-Fluent-Emojis/master/Emojis/Activities/Party%20Popper.png" alt="Party" class="w-4 h-4 object-contain" />
                </div>
                <p class="text-[0.65rem] text-slate-600 font-semibold leading-relaxed">
                    You've been active for <span class="font-extrabold text-orange-600">{{ $activeDaysCount }} day{{ $activeDaysCount != 1 ? 's' : '' }}</span> this week!
                </p>
            </div>
        </div>

        {{-- RECENT EXAM RESULTS CARD --}}
        <div class="seamless-card rounded-[2rem] p-6 lg:p-7">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-heading font-black text-base text-slate-800 tracking-tight">Recent Exam Results</h3>
                <a href="{{ route('test_taker.exam.my_exams') }}" class="text-[0.65rem] font-bold text-brand-primary hover:underline">View All</a>
            </div>

            <div class="flex flex-col gap-3">
                @for($i = 0; $i < 3; $i++)
                    @if(isset($recentResults[$i]))
                        @php
                            $result = $recentResults[$i];
                            $passingScore = $result->exam->examType->passing_score ?? null;
                            $isPassed = $passingScore ? $result->converted_score >= $passingScore : null;
                            $scoreColor = $isPassed === true ? 'green' : ($isPassed === false ? 'red' : 'blue');
                        @endphp
                        <div class="bg-slate-50 rounded-xl p-3 border border-slate-100 flex items-center justify-between hover:border-brand-primary transition-colors group">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-{{ $scoreColor }}-50 text-{{ $scoreColor }}-600 flex items-center justify-center font-black text-xs shadow-sm border border-{{ $scoreColor }}-100">
                                    {{ number_format($result->converted_score, 1) }}
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800 leading-tight truncate max-w-[130px] mb-0.5">{{ $result->exam->title }}</h4>
                                    <div class="flex items-center gap-1.5">
                                        <p class="text-[0.6rem] font-medium text-slate-400 flex items-center gap-1">
                                            <x-lucide-calendar class="w-3 h-3" /> {{ $result->updated_at->format('d M Y') }}
                                        </p>
                                        @if($isPassed === true)
                                            <span class="text-[0.55rem] font-extrabold bg-green-100 text-green-700 px-1.5 py-0.5 rounded-full">✓ PASSED</span>
                                        @elseif($isPassed === false)
                                            <span class="text-[0.55rem] font-extrabold bg-red-100 text-red-600 px-1.5 py-0.5 rounded-full">✗ BELOW</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('test_taker.exam.score_report', $result->id) }}" title="View Score Report" class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:bg-brand-primary hover:text-white hover:border-brand-primary transition-colors shadow-sm">
                                <x-lucide-chevron-right class="w-4 h-4" />
                            </a>
                        </div>
                    @else
                        <div class="border border-dashed border-slate-200 bg-slate-50/30 rounded-xl p-3 flex items-center justify-center h-[58px] text-[0.65rem] text-slate-400 font-semibold italic">
                            No recent exam
                        </div>
                    @endif
                @endfor
            </div>
        </div>

        {{-- CERTIFICATES EARNED --}}
        <div class="seamless-card rounded-[2rem] p-6 lg:p-7 anim-in d3">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-yellow-50 flex items-center justify-center">
                        <x-lucide-award class="w-5 h-5 text-yellow-500" />
                    </div>
                    <h2 class="font-heading text-base font-bold text-slate-800">Certificates Earned</h2>
                </div>
                <span class="text-[0.65rem] font-bold text-slate-400 bg-slate-50 px-3 py-1 rounded-full border border-slate-100">{{ $certificates->count() }} total</span>
            </div>

            <div class="flex flex-col gap-3">
                @for($i = 0; $i < 3; $i++)
                    @if(isset($certificates[$i]))
                        @php
                            $cert = $certificates[$i];
                        @endphp
                        <div class="relative bg-gradient-to-br from-yellow-50 to-amber-50 border border-yellow-100 rounded-2xl p-4 flex flex-col gap-2 hover:shadow-md hover:border-yellow-200 transition-all group overflow-hidden">
                            <div class="absolute top-0 right-0 w-16 h-16 bg-yellow-200 opacity-20 rounded-full -translate-y-4 translate-x-4 pointer-events-none"></div>
                            <div class="flex items-center gap-2">
                                <x-lucide-award class="w-5 h-5 text-yellow-500 flex-shrink-0" />
                                <h4 class="text-xs font-black text-slate-800 leading-tight truncate">{{ $cert->course->title }}</h4>
                            </div>
                            <p class="text-[0.6rem] font-medium text-slate-400 flex items-center gap-1">
                                <x-lucide-calendar class="w-3 h-3" /> Issued {{ $cert->issued_at->format('d M Y') }}
                            </p>
                            <a href="{{ route('test_taker.course.certificate.download', $cert->course_id) }}" 
                               class="mt-1 w-full text-center text-[0.65rem] font-bold py-1.5 rounded-xl bg-white border border-yellow-200 text-yellow-700 hover:bg-yellow-500 hover:text-white hover:border-yellow-500 transition-all shadow-sm flex items-center justify-center gap-1">
                                <x-lucide-download class="w-3 h-3" /> Download
                            </a>
                        </div>
                    @else
                        <div class="border border-dashed border-yellow-100/50 bg-yellow-50/10 rounded-2xl p-4 flex flex-col items-center justify-center h-[116px] text-center text-[0.65rem] text-slate-400 font-semibold italic">
                            <x-lucide-award class="w-5 h-5 mb-1 text-slate-300" />
                            <span>No certificate earned</span>
                        </div>
                    @endif
                @endfor
            </div>
        </div>

        {{-- SCORE REPORTS EARNED --}}
        <div class="seamless-card rounded-[2rem] p-6 lg:p-7 anim-in d3">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
                        <x-lucide-file-text class="w-5 h-5 text-blue-500" />
                    </div>
                    <h2 class="font-heading text-base font-bold text-slate-800">Score Reports</h2>
                </div>
                <span class="text-[0.65rem] font-bold text-slate-400 bg-slate-50 px-3 py-1 rounded-full border border-slate-100">{{ $recentResults->count() }} total</span>
            </div>

            <div class="flex flex-col gap-3">
                @for($i = 0; $i < 3; $i++)
                    @if(isset($recentResults[$i]))
                        @php
                            $result = $recentResults[$i];
                            $passingScore = $result->exam->examType->passing_score ?? null;
                            $isPassed = $passingScore ? $result->converted_score >= $passingScore : null;
                            $scoreColor = $isPassed === true ? 'green' : ($isPassed === false ? 'red' : 'blue');
                        @endphp
                        <div class="relative bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 rounded-2xl p-4 flex flex-col gap-2 hover:shadow-md hover:border-blue-200 transition-all group overflow-hidden">
                            <div class="absolute top-0 right-0 w-16 h-16 bg-blue-200 opacity-20 rounded-full -translate-y-4 translate-x-4 pointer-events-none"></div>
                            <div class="flex items-start justify-between gap-2">
                                <div class="flex items-center gap-2">
                                    <x-lucide-file-text class="w-5 h-5 text-blue-500 flex-shrink-0" />
                                    <h4 class="text-xs font-black text-slate-800 leading-tight truncate max-w-[120px]">{{ $result->exam->title }}</h4>
                                </div>
                                <span class="text-[0.6rem] font-extrabold bg-{{ $scoreColor }}-100 text-{{ $scoreColor }}-700 px-2 py-0.5 rounded-full whitespace-nowrap">
                                    {{ number_format($result->converted_score, 1) }}
                                </span>
                            </div>
                            <p class="text-[0.6rem] font-medium text-slate-400 flex items-center gap-1">
                                <x-lucide-calendar class="w-3 h-3" /> Graded {{ $result->updated_at->format('d M Y') }}
                            </p>
                            <a href="{{ route('test_taker.exam.score_report', $result->id) }}" 
                               class="mt-1 w-full text-center text-[0.65rem] font-bold py-1.5 rounded-xl bg-white border border-blue-200 text-blue-700 hover:bg-blue-500 hover:text-white hover:border-blue-500 transition-all shadow-sm flex items-center justify-center gap-1">
                                <x-lucide-eye class="w-3 h-3" /> View Report
                            </a>
                        </div>
                    @else
                        <div class="border border-dashed border-blue-100/50 bg-blue-50/10 rounded-2xl p-4 flex flex-col items-center justify-center h-[116px] text-center text-[0.65rem] text-slate-400 font-semibold italic">
                            <x-lucide-file-text class="w-5 h-5 mb-1 text-slate-300" />
                            <span>No exam report</span>
                        </div>
                    @endif
                @endfor
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var avgScoresData = @json($avgScoresGrouped ?? []);

    function updateAvgScoreDisplay(val) {
        var score = avgScoresData[val] !== undefined ? avgScoresData[val] : 0.0;
        document.getElementById('avgScoreDisplay').textContent = Number(score).toFixed(1);
    }

    var groupedData = @json($chartDataGrouped ?? []);
    var scoreChart;

    document.addEventListener("DOMContentLoaded", function() {
        if(Object.keys(groupedData).length > 0) {
            var selector = document.getElementById('chartExamTypeSelector');
            var initialType = selector.value;
            var initialData = groupedData[initialType];

            var options = {
                series: [{
                    name: 'Score',
                    data: initialData.data
                }],
                chart: {
                    type: 'area',
                    height: 250,
                    fontFamily: 'Poppins, sans-serif',
                    toolbar: { show: false },
                    zoom: { enabled: false }
                },
                colors: ['#2563eb'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.05,
                        stops: [0, 100]
                    }
                },
                dataLabels: { enabled: true, style: { fontSize: '10px' }, offsetY: -5, background: { enabled: true, foreColor: '#2563eb', padding: 4, borderRadius: 2, borderWidth: 0 } },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                xaxis: {
                    categories: initialData.labels,
                    labels: {
                        style: { colors: '#94a3b8', fontSize: '10px' }
                    },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: {
                        style: { colors: '#94a3b8', fontSize: '10px' }
                    }
                },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4,
                    yaxis: { lines: { show: true } }
                }
            };
            
            scoreChart = new ApexCharts(document.querySelector("#scoreChart"), options);
            scoreChart.render();
        }
    });

    function updateChartData() {
        var type = document.getElementById('chartExamTypeSelector').value;
        var newData = groupedData[type];
        if (scoreChart && newData) {
            scoreChart.updateOptions({
                xaxis: { categories: newData.labels }
            });
            scoreChart.updateSeries([{
                name: 'Score',
                data: newData.data
            }]);
        }
    }
</script>
@endpush