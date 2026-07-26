@extends('layouts.user')

@section('title', 'Courses')

@push('styles')
<style>
    .floating-cloud {
        animation: floatCloud 4s ease-in-out infinite;
    }

    @keyframes floatCloud {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }
</style>
@endpush

@section('content')
{{-- 1. Courses Hero Section --}}
<x-courses.hero />

{{-- 2. Main Filtering and Grid Section --}}
<div class="bg-[#f8fafc] min-h-screen pt-25 pb-16">
    <div class="max-w-[1400px] mx-auto px-[4%] w-full">
        <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-8 items-start w-full">

            {{-- Filter Sidebar Component --}}
            <x-courses.filter-sidebar />

            <div class="w-full flex flex-col">
                {{-- Search & Tag Bar Component --}}
                <x-courses.search-bar />

                {{-- Courses Grid Container --}}
                <main id="courseContainer" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 w-full">
                    @php
                        use App\Models\CourseEnrollment;
                        $enrolledCourseIds = auth()->check()
                            ? CourseEnrollment::where('user_id', auth()->id())->pluck('course_id')->toArray()
                            : [];
                    @endphp

                    @forelse($courses as $course)
                        <x-course-card 
                            :course="$course" 
                            :isEnrolled="in_array($course->id, $enrolledCourseIds)" 
                            :index="$loop->index" 
                        />
                    @empty
                        <div class="col-span-full py-16 text-center border-2 border-dashed border-slate-200 rounded-3xl bg-white">
                            <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center mx-auto mb-4">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="1.8">
                                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-slate-700">No Courses Available</h3>
                            <p class="text-sm text-slate-400 mt-1">Our instructors are preparing new lessons. Check back soon!</p>
                        </div>
                    @endforelse
                </main>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const cards = Array.from(document.querySelectorAll('#courseContainer .cc__card'));
    const filterButtons = document.querySelectorAll('.level-filter-btn');
    const searchEl = document.getElementById('course-search');

    let activeFilter = 'all';
    let searchQuery = '';

    function applyFilters() {
        cards.forEach(card => {
            const level = (card.dataset.level || '').trim();
            const title = (card.dataset.title || '').trim();
            
            const matchFilter = activeFilter === 'all' || level === activeFilter;
            const matchSearch = title.includes(searchQuery);
            
            if (matchFilter && matchSearch) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    filterButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            // Remove active classes
            filterButtons.forEach(b => {
                b.classList.remove('bg-[#1a456c]', 'text-white');
                b.classList.add('text-slate-600', 'hover:bg-slate-200');
            });
            // Add active class to clicked button
            this.classList.add('bg-[#1a456c]', 'text-white');
            this.classList.remove('text-slate-600', 'hover:bg-slate-200');

            activeFilter = this.dataset.filter;
            applyFilters();
        });
    });

    if (searchEl) {
        searchEl.addEventListener('input', function () {
            searchQuery = this.value.trim().toLowerCase();
            applyFilters();
        });
    }
});
</script>
@endpush
@endsection