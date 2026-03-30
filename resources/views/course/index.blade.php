@extends('layouts.test_taker')
@section('title', 'Browse Courses')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; width: 100%;">
    
    {{-- HEADER SECTION --}}
    <div class="flex-col-mobile" style="margin-bottom: 32px; gap: 16px;">
        <div>
            <h1 style="font-size: 1.8rem; font-weight: 900; color: var(--text); letter-spacing: -0.02em;">Browse Courses</h1>
            <p style="font-size: 0.85rem; color: var(--muted); margin-top: 6px;">Discover and enroll in English learning courses to improve your skills.</p>
        </div>
        <button style="display: flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 12px; font-size: 0.85rem; font-weight: 800; background: linear-gradient(135deg, var(--blue), var(--indigo)); color: white; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(37,99,235,0.25); transition: all .2s;"
                onmouseover="this.style.transform='translateY(-2px)';"
                onmouseout="this.style.transform='translateY(0)';">
            <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Enroll Course
        </button>
    </div>

    {{-- FILTER TABS --}}
    <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 32px;">
        @php
        $tabs = ['All Courses', 'Listening', 'Speaking', 'Reading', 'Grammar', 'Writing', 'IELTS Prep'];
        @endphp
        @foreach($tabs as $idx => $tab)
        <button style="padding: 10px 18px; border-radius: 12px; font-size: 0.8rem; font-weight: 700; cursor: pointer; transition: all .2s; {{ $idx === 0 ? 'background: var(--text); color: white; border: none; box-shadow: 0 4px 12px rgba(15,23,42,0.15);' : 'background: white; color: var(--muted); border: 1.5px solid var(--border);' }}"
                @if($idx !== 0)
                onmouseover="this.style.borderColor='var(--blue)'; this.style.color='var(--blue)';"
                onmouseout="this.style.borderColor='var(--border)'; this.style.color='var(--muted)';"
                @endif>
            {{ $tab }}
        </button>
        @endforeach
    </div>

    {{-- COURSES GRID --}}
    @php
    $courses = [
        [
            'category' => 'Listening',
            'title'    => 'Advanced Listening Comprehension',
            'desc'     => 'Master listening skills through real-world audio, podcasts, and IELTS exercises.',
            'students' => '1,240',
            'level'    => 'Intermediate',
            'lessons'  => 24,
            'bg'       => 'linear-gradient(135deg, #bfdbfe 0%, #93c5fd 100%)',
            'tx'       => '#1d4ed8',
            'accent'   => '#3b82f6',
            'emoji'    => '🎧',
        ],
        [
            'category' => 'Speaking',
            'title'    => 'Confident English Speaking',
            'desc'     => 'Build fluency and confidence through structured speaking practice and drills.',
            'students' => '980',
            'level'    => 'Beginner',
            'lessons'  => 18,
            'bg'       => 'linear-gradient(135deg, #ddd6fe 0%, #c4b5fd 100%)',
            'tx'       => '#6d28d9',
            'accent'   => '#7c3aed',
            'emoji'    => '🗣️',
        ],
        [
            'category' => 'Reading',
            'title'    => 'Academic Reading Mastery',
            'desc'     => 'Improve reading speed and comprehension with academic texts & scanning techniques.',
            'students' => '760',
            'level'    => 'Advanced',
            'lessons'  => 20,
            'bg'       => 'linear-gradient(135deg, #bbf7d0 0%, #86efac 100%)',
            'tx'       => '#15803d',
            'accent'   => '#16a34a',
            'emoji'    => '📖',
        ],
        [
            'category' => 'Grammar',
            'title'    => 'English Grammar Essentials',
            'desc'     => 'From tenses to complex sentence structures — build a solid grammar foundation.',
            'students' => '2,100',
            'level'    => 'Beginner',
            'lessons'  => 32,
            'bg'       => 'linear-gradient(135deg, #fef08a 0%, #fde047 100%)',
            'tx'       => '#a16207',
            'accent'   => '#ca8a04',
            'emoji'    => '✍️',
        ],
        [
            'category' => 'Writing',
            'title'    => 'IELTS Writing Task 1 & 2',
            'desc'     => 'Learn how to write high-scoring essays and reports for IELTS with templates.',
            'students' => '870',
            'level'    => 'Intermediate',
            'lessons'  => 22,
            'bg'       => 'linear-gradient(135deg, #fbcfe8 0%, #f9a8d4 100%)',
            'tx'       => '#9d174d',
            'accent'   => '#db2777',
            'emoji'    => '📝',
        ],
        [
            'category' => 'IELTS Prep',
            'title'    => 'Complete IELTS 7.0+ Program',
            'desc'     => 'A comprehensive IELTS preparation covering all 4 skills with mock tests.',
            'students' => '3,450',
            'level'    => 'All Levels',
            'lessons'  => 48,
            'bg'       => 'linear-gradient(135deg, #bae6fd 0%, #7dd3fc 100%)',
            'tx'       => '#0369a1',
            'accent'   => '#0284c7',
            'emoji'    => '🏆',
        ],
    ];
    @endphp

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 300px), 1fr)); gap: 24px;">
        @foreach($courses as $course)
        <div class="card anim-in d{{ ($loop->index % 6) + 1 }}" style="display: flex; flex-direction: column; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer;"
             onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(37,99,235,0.1)';"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
            
            {{-- Illustration Area --}}
            <div style="height: 180px; position: relative; display: flex; align-items: center; justify-content: center; overflow: hidden; background: {{ $course['bg'] }};">
                
                {{-- Category Badge --}}
                <div style="position: absolute; top: 16px; left: 16px; background: rgba(255,255,255,0.95); padding: 4px 10px; border-radius: 8px; font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: {{ $course['tx'] }}; backdrop-filter: blur(4px); box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    {{ $course['category'] }}
                </div>
                
                {{-- Level Badge --}}
                <div style="position: absolute; top: 16px; right: 16px; background: rgba(255,255,255,0.8); padding: 4px 10px; border-radius: 8px; font-size: 0.65rem; font-weight: 800; color: #334155; backdrop-filter: blur(4px);">
                    {{ $course['level'] }}
                </div>

                {{-- Emoji Icon --}}
                <div style="font-size: 4.5rem; filter: drop-shadow(0 8px 16px rgba(0,0,0,0.1)); user-select: none; transition: transform 0.3s;"
                     onmouseover="this.style.transform='scale(1.1) rotate(5deg)';"
                     onmouseout="this.style.transform='scale(1) rotate(0)';">
                    {{ $course['emoji'] }}
                </div>

                {{-- Decorative Shapes --}}
                <div style="position: absolute; bottom: -30px; right: -30px; width: 100px; height: 100px; border-radius: 50%; opacity: 0.2; background: {{ $course['accent'] }}; filter: blur(20px);"></div>
                <div style="position: absolute; top: -20px; left: -20px; width: 80px; height: 80px; border-radius: 50%; opacity: 0.15; background: {{ $course['accent'] }};"></div>
            </div>

            {{-- Content Area --}}
            <div style="padding: 24px; display: flex; flex-direction: column; flex: 1;">
                <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--text); line-height: 1.3; margin-bottom: 8px;">
                    {{ $course['title'] }}
                </h3>
                <p style="font-size: 0.82rem; color: var(--muted); line-height: 1.6; margin-bottom: 20px; flex: 1;">
                    {{ $course['desc'] }}
                </p>

                {{-- Meta Info --}}
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; padding-top: 16px; border-top: 1px solid var(--border); margin-bottom: 20px;">
                    <div>
                        <p style="font-size: 0.65rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">Students</p>
                        <p style="font-size: 0.85rem; font-weight: 800; color: var(--text);">{{ $course['students'] }}</p>
                    </div>
                    <div>
                        <p style="font-size: 0.65rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">Lessons</p>
                        <div style="display: flex; align-items: center; gap: 4px; font-size: 0.85rem; font-weight: 800; color: var(--text);">
                            <svg style="width:14px; height:14px; color:var(--blue);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $course['lessons'] }} Items
                        </div>
                    </div>
                </div>

                {{-- Action Button --}}
                <a href="{{ route('course.detail', 1) }}" 
                   style="display: block; width: 100%; text-align: center; padding: 12px; border-radius: 12px; background: var(--base); color: var(--blue); font-size: 0.85rem; font-weight: 800; text-decoration: none; transition: all 0.2s; border: 1.5px solid transparent;"
                   onmouseover="this.style.borderColor='var(--blue)'; this.style.background='white';"
                   onmouseout="this.style.borderColor='transparent'; this.style.background='var(--base)';">
                    Enroll Now
                </a>
            </div>
        </div>
        @endforeach
    </div>
    
</div>
@endsection