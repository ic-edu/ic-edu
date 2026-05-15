@extends('layouts.test_taker')
@section('title', 'My Courses')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; width: 100%;">

    {{-- HEADER --}}
    <div style="margin-bottom: 32px;" class="anim-in d1">
        <h1 style="font-size: 1.8rem; font-weight: 900; color: var(--text); letter-spacing: -0.02em;">My Courses</h1>
        <p style="font-size: 0.85rem; color: var(--muted); margin-top: 6px;">Courses you have enrolled in. Continue your learning journey!</p>
    </div>

    {{-- SUCCESS FLASH --}}
    @if(session('success'))
    <div class="anim-in d1" style="padding: 14px 20px; border-radius: 14px; background: #f0fdf4; border: 1.5px solid #bbf7d0; color: #15803d; font-size: 0.85rem; font-weight: 700; margin-bottom: 24px;">
        ✅ {{ session('success') }}
    </div>
    @endif

    {{-- ENROLLED COURSES --}}
    <div style="display: flex; flex-direction: column; gap: 16px;">
        @forelse($enrollments as $enrollment)
        @php
            $course = $enrollment->course;
            $statusColors = [
                'active'    => ['bg' => '#f0fdf4', 'tx' => '#16a34a', 'label' => '🟢 Active'],
                'graduated' => ['bg' => '#eff6ff', 'tx' => '#2563eb', 'label' => '🎓 Graduated'],
                'dropped'   => ['bg' => '#fef2f2', 'tx' => '#dc2626', 'label' => '🔴 Dropped'],
            ];
            $sc = $statusColors[$enrollment->status] ?? $statusColors['active'];
        @endphp
        <div class="card anim-in d{{ ($loop->index % 5) + 1 }}" style="display: flex; gap: 20px; padding: 20px; align-items: center; transition: all .2s; cursor: pointer;"
             onmouseover="this.style.borderColor='var(--blue)'; this.style.boxShadow='0 6px 24px rgba(37,99,235,0.08)';"
             onmouseout="this.style.borderColor='var(--border)'; this.style.boxShadow='none';"
             onclick="window.location='{{ route('test_taker.course.show', $course->id) }}'">

            {{-- Thumbnail --}}
            <div style="width: 100px; height: 72px; border-radius: 12px; overflow: hidden; flex-shrink: 0; background: linear-gradient(135deg, #bfdbfe, #93c5fd); display: flex; align-items: center; justify-content: center;">
                @if($course->thumbnail_path)
                    <img src="{{ asset('storage/' . $course->thumbnail_path) }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <span style="font-size: 2rem;">📚</span>
                @endif
            </div>

            {{-- Info --}}
            <div style="flex: 1; min-width: 0;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                    <h3 style="font-size: 0.95rem; font-weight: 800; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ $course->title }}
                    </h3>
                    <span style="font-size: 0.6rem; font-weight: 700; background: {{ $sc['bg'] }}; color: {{ $sc['tx'] }}; padding: 3px 8px; border-radius: 6px; flex-shrink: 0;">
                        {{ $sc['label'] }}
                    </span>
                </div>
                <p style="font-size: 0.75rem; color: var(--muted);">
                    {{ $course->modules_count ?? 0 }} modules
                    · Enrolled {{ $enrollment->enrolled_at ? $enrollment->enrolled_at->diffForHumans() : 'recently' }}
                </p>
            </div>

            {{-- Arrow --}}
            <svg style="width: 20px; height: 20px; color: var(--muted); flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
        @empty
        <div style="padding: 60px 20px; text-align: center; background: white; border: 1.5px dashed var(--border); border-radius: 20px;">
            <div style="font-size: 3rem; margin-bottom: 16px;">📚</div>
            <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--text);">No Enrolled Courses</h3>
            <p style="font-size: 0.85rem; color: var(--muted); margin-top: 8px; margin-bottom: 24px;">You haven't enrolled in any courses yet.</p>
            <a href="{{ route('test_taker.course.index') }}"
               style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 12px; background: var(--blue); color: white; font-size: 0.85rem; font-weight: 700; text-decoration: none;">
                Browse Courses →
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection
