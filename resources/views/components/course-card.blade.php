@props(['course', 'isEnrolled' => false, 'index' => 0])

@php
    $tl = is_array($course->target_level)
        ? ($course->target_level[0] ?? 'Intermediate')
        : ($course->target_level ?? 'Intermediate');

    $displayLevel = is_array($course->target_level)
        ? implode(' · ', $course->target_level)
        : ($course->target_level ?? 'Course');

    $levelMap = [
        'Beginner'     => ['color' => '#059669', 'soft' => 'rgba(5,150,105,0.07)',  'deco' => 'rgba(5,150,105,1)',   'filter' => 'beginner'],
        'Intermediate' => ['color' => '#d97706', 'soft' => 'rgba(217,119,6,0.07)',  'deco' => 'rgba(217,119,6,1)',   'filter' => 'intermediate'],
        'Advanced'     => ['color' => '#dc2626', 'soft' => 'rgba(220,38,38,0.07)',  'deco' => 'rgba(220,38,38,1)',   'filter' => 'advanced'],
    ];
    $lc = $levelMap[$tl] ?? $levelMap['Intermediate'];
@endphp

<div class="cc__card anim-in d{{ $index % 5 + 1 }}"
     data-level="{{ $lc['filter'] }}"
     data-title="{{ strtolower($course->title) }}">

    {{-- ── Thumbnail ── --}}
    <div class="cc__thumb">
        {{-- Decorative circles --}}
        <div class="cc__deco-ring cc__deco-ring--lg"></div>
        <div class="cc__deco-ring cc__deco-ring--sm"></div>
        <div class="cc__deco-grid"></div>

        @if($course->thumbnail_path)
            <img src="{{ asset('storage/' . $course->thumbnail_path) }}"
                 alt="{{ $course->title }}"
                 class="cc__thumb-img">
        @else
            {{-- Icon illustration --}}
            <div class="cc__thumb-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                </svg>
            </div>
        @endif

        {{-- Level badge --}}
        <span class="cc__level-badge">{{ $displayLevel }}</span>

        {{-- Module count --}}
        <span class="cc__module-chip">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
            </svg>
            {{ $course->modules_count ?? 0 }} modules
        </span>

        {{-- Enrolled state chip --}}
        @if($isEnrolled)
            <span class="cc__enrolled-chip">
                <svg width="10" height="10" viewBox="0 0 12 10" fill="none">
                    <path d="M1 5L4 8L11 1" stroke="#1A456C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Enrolled
            </span>
        @endif
    </div>

    {{-- ── Body ── --}}
    <div class="cc__body">
        <h3 class="cc__title">{{ $course->title }}</h3>
        <p class="cc__desc">{{ strip_tags($course->description) ?: 'Explore structured lessons designed to build your skills step by step.' }}</p>

        <div class="cc__meta">
            <div class="cc__meta-item">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                <span>{{ $course->enrollments_count ?? 0 }} students</span>
            </div>
            <div class="cc__meta-dot"></div>
            <div class="cc__meta-item">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
                <span>Self-paced</span>
            </div>
        </div>
    </div>

    {{-- ── Footer CTA ── --}}
    <div class="cc__card-footer">
        @if($isEnrolled)
            <a href="{{ route('test_taker.course.show', $course->id) }}" class="cc__btn cc__btn--continue">
                Continue Learning
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                </svg>
            </a>
        @else
            <a href="{{ route('test_taker.course.show', $course->id) }}" class="cc__btn cc__btn--view">
                View Course
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                </svg>
            </a>
        @endif
    </div>

</div>

@pushOnce('styles')
<style>
/* Card Base */
.cc__card {
    background: white;
    border-radius: 18px;
    border: 1.5px solid var(--border, #e2e8f0);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.25s cubic-bezier(0.4,0,0.2,1),
                box-shadow 0.25s cubic-bezier(0.4,0,0.2,1),
                border-color 0.25s;
}
.cc__card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 40px rgba(26,69,108,0.12);
    border-color: rgba(26,69,108,0.3);
}

/* Thumb */
.cc__thumb {
    position: relative;
    height: 156px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background: rgba(26,69,108,0.07);
    border-top: 3px solid #1A456C;
}
.cc__thumb-img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.cc__thumb-icon {
    width: 60px;
    height: 60px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    z-index: 1;
    background: #1A456C;
    box-shadow: 0 8px 24px rgba(26,69,108,0.25);
}

/* Decorative elements */
.cc__deco-ring {
    position: absolute;
    border-radius: 50%;
    opacity: 0.12;
    background: #1A456C;
}
.cc__deco-ring--lg {
    width: 130px; height: 130px;
    top: -40px; right: -40px;
}
.cc__deco-ring--sm {
    width: 80px; height: 80px;
    bottom: -28px; left: -28px;
    opacity: 0.07;
}
.cc__deco-grid {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,0.25) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.25) 1px, transparent 1px);
    background-size: 24px 24px;
}

/* Badges */
.cc__level-badge {
    position: absolute;
    top: 14px; left: 14px;
    padding: 4px 10px;
    border-radius: 99px;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: white;
    z-index: 2;
    background: #1A456C;
}
.cc__module-chip {
    position: absolute;
    bottom: 14px; right: 14px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 99px;
    font-size: 10px;
    font-weight: 700;
    color: #334155;
    background: rgba(255,255,255,0.88);
    backdrop-filter: blur(6px);
    border: 1px solid rgba(255,255,255,0.6);
    z-index: 2;
}
.cc__enrolled-chip {
    position: absolute;
    top: 14px; right: 14px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 99px;
    font-size: 10px;
    font-weight: 800;
    background: rgba(255,255,255,0.92);
    color: #0f172a;
    border: 1.5px solid rgba(255,255,255,0.7);
    backdrop-filter: blur(6px);
    z-index: 2;
}

/* Body */
.cc__body {
    padding: 18px 20px 14px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.cc__title {
    font-size: 14px;
    font-weight: 800;
    color: var(--text, #0f172a);
    line-height: 1.4;
    margin: 0 0 7px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.cc__desc {
    font-size: 12px;
    color: var(--muted, #64748b);
    line-height: 1.65;
    margin: 0;
    flex: 1;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.cc__meta {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 14px;
    padding-top: 12px;
    border-top: 1px solid var(--border, #e2e8f0);
}
.cc__meta-item {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    color: var(--muted, #64748b);
    font-weight: 500;
}
.cc__meta-dot {
    width: 3px; height: 3px;
    border-radius: 50%;
    background: var(--border, #e2e8f0);
    flex-shrink: 0;
}

/* Footer */
.cc__card-footer { padding: 0 20px 20px; }
.cc__btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 11px 16px;
    border-radius: 11px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    font-family: inherit;
    box-sizing: border-box;
}
.cc__btn--view { color: white; background: #1A456C; }
.cc__btn--view:hover { filter: brightness(1.1); transform: scale(1.015); }
.cc__btn--continue {
    background: var(--base, #f8fafc);
    color: var(--primary, #1A456C);
    border: 1.5px solid var(--border, #e2e8f0);
}
.cc__btn--continue:hover { border-color: var(--primary, #1A456C); background: white; }
</style>
@endPushOnce
