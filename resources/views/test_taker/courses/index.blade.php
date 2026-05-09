@extends('layouts.test_taker')
@section('title', 'Browse Courses')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; width: 100%;">
    
    {{-- HEADER --}}
    <div style="margin-bottom: 32px;" class="anim-in d1">
        <h1 style="font-size: 1.8rem; font-weight: 900; color: var(--text); letter-spacing: -0.02em;">Browse Courses</h1>
        <p style="font-size: 0.85rem; color: var(--muted); margin-top: 6px;">Explore learning materials to prepare for your exams and improve your skills.</p>
    </div>

    {{-- COURSES GRID --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 340px), 1fr)); gap: 24px;">
        @forelse($courses as $course)
        @php
            $levelColors = [
                'Beginner'     => ['bg' => 'linear-gradient(135deg, #bbf7d0, #86efac)', 'tx' => '#15803d', 'accent' => '#16a34a', 'emoji' => '🌱'],
                'Intermediate' => ['bg' => 'linear-gradient(135deg, #bfdbfe, #93c5fd)', 'tx' => '#1d4ed8', 'accent' => '#2563eb', 'emoji' => '📚'],
                'Advanced'     => ['bg' => 'linear-gradient(135deg, #fecaca, #fca5a5)', 'tx' => '#991b1b', 'accent' => '#dc2626', 'emoji' => '🚀'],
            ];
            $c = $levelColors[$course->target_level] ?? $levelColors['Intermediate'];
        @endphp

        <div class="card anim-in d{{ ($loop->index % 5) + 1 }}" style="display: flex; flex-direction: column; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer;"
             onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(37,99,235,0.1)';"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';"
             onclick="window.location='{{ route('test_taker.course.show', $course->id) }}'">

            {{-- Thumbnail / Illustration --}}
            <div style="height: 180px; position: relative; display: flex; align-items: center; justify-content: center; overflow: hidden; background: {{ $c['bg'] }};">
                @if($course->thumbnail_path)
                    <img src="{{ asset('storage/' . $course->thumbnail_path) }}" alt="{{ $course->title }}" 
                         style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <div style="font-size: 4rem; filter: drop-shadow(0 8px 16px rgba(0,0,0,0.1)); user-select: none;">
                        {{ $c['emoji'] }}
                    </div>
                @endif

                {{-- Level Badge --}}
                <div style="position: absolute; top: 16px; left: 16px; background: rgba(255,255,255,0.9); padding: 4px 10px; border-radius: 8px; font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: {{ $c['tx'] }}; backdrop-filter: blur(4px);">
                    {{ $course->target_level ?? 'Course' }}
                </div>

                {{-- Module Count Badge --}}
                <div style="position: absolute; top: 16px; right: 16px; background: rgba(255,255,255,0.8); padding: 4px 10px; border-radius: 8px; font-size: 0.65rem; font-weight: 800; color: #334155; backdrop-filter: blur(4px);">
                    📦 {{ $course->modules_count }} Modules
                </div>

                <div style="position: absolute; bottom: -30px; right: -30px; width: 100px; height: 100px; border-radius: 50%; opacity: 0.2; background: {{ $c['accent'] }}; filter: blur(20px);"></div>
            </div>

            {{-- Content --}}
            <div style="padding: 24px; display: flex; flex-direction: column; flex: 1;">
                <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--text); line-height: 1.3; margin-bottom: 8px;">
                    {{ $course->title }}
                </h3>
                <p style="font-size: 0.8rem; color: var(--muted); line-height: 1.6; margin-bottom: 20px; flex: 1; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    {{ strip_tags($course->description) }}
                </p>

                {{-- Meta --}}
                <div style="display: flex; gap: 16px; padding-top: 16px; border-top: 1px solid var(--border); margin-bottom: 20px;">
                    <div>
                        <p style="font-size: 0.65rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">Students</p>
                        <span style="font-size: 0.85rem; font-weight: 900; color: var(--text);">{{ $course->enrollments_count }}</span>
                    </div>
                    <div>
                        <p style="font-size: 0.65rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">Status</p>
                        <span style="display: inline-block; padding: 3px 8px; border-radius: 99px; font-size: 0.65rem; font-weight: 800; background: #ecfdf5; color: #16a34a;">
                            ● Published
                        </span>
                    </div>
                </div>

                <a href="{{ route('test_taker.course.show', $course->id) }}" 
                   style="display: block; width: 100%; text-align: center; padding: 12px; border-radius: 12px; background: {{ $c['accent'] }}; color: white; font-size: 0.85rem; font-weight: 800; text-decoration: none; transition: filter 0.2s;"
                   onmouseover="this.style.filter='brightness(1.1)';" onmouseout="this.style.filter='brightness(1)';">
                    View Course
                </a>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; padding: 60px 20px; text-align: center; background: white; border: 1.5px dashed var(--border); border-radius: 20px;">
            <div style="font-size: 3rem; margin-bottom: 16px;">📭</div>
            <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--text);">No Courses Available</h3>
            <p style="font-size: 0.85rem; color: var(--muted); margin-top: 8px;">Check back later for new learning materials.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
