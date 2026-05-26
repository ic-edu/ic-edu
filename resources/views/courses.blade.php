@extends('layouts.user')

@section('title', 'Courses')

@push('styles')
<style>
    .floating-cloud {
        animation: floatCloud 4s ease-in-out infinite;
    }

    @keyframes floatCloud {
        0%,
        100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }
</style>
@endpush

@section('content')
<x-landing.hero/>
<x-landing.strip/>

<div class="bg-white min-h-screen pt-8 md:pt-16 pb-16">
    <div class="max-w-[1400px] mx-auto px-[5%] md:px-[4%] w-full">

        <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-6 lg:gap-8 items-start w-full">

            <aside class="bg-white p-5 md:p-6 rounded-2xl border border-slate-200 shadow-sm relative lg:sticky lg:top-40 z-30 w-full mb-2 lg:mb-0">
                
                <div class="mb-6">
                    <h2 class="text-xl font-extrabold text-[#1a456c] mb-1">Search</h2>
                    <p class="text-xs font-semibold text-slate-400 mb-4 uppercase tracking-wider">Find your course</p>
                    
                    <div class="relative w-full">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <input type="text"
                            placeholder="Search courses..."
                            class="w-full pl-11 pr-4 py-3 bg-slate-100 text-slate-700 placeholder-slate-400 rounded-full border-0 focus:outline-none focus:ring-0 focus:border-0 text-base md:text-sm transition-all shadow-sm">
                    </div>
                </div>
                
                <hr class="border-slate-100 mb-6">
                
                <div>
                    <h2 class="text-xl font-extrabold text-[#1a456c] mb-1">Filters</h2>
                    <p class="text-xs font-semibold text-slate-400 mb-5 uppercase tracking-wider">Refine search</p>

                    <div class="space-y-4">
                        
                        <div class="border-b border-slate-100 pb-3">
                            <div onclick="toggleCategories()" class="flex items-center justify-between cursor-pointer group select-none mb-2">
                                <span class="text-sm font-bold text-slate-600 group-hover:text-blue-600 transition-colors">Categories</span>
                                <div class="flex items-center gap-2">
                                    <svg id="categoryIcon" class="w-4 h-4 text-slate-400 group-hover:text-blue-600 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            
                            <ul id="categoryList" class="space-y-3 pl-2 hidden transition-all duration-300 mt-3">
                                <li>
                                    <a href="#" class="flex items-center justify-between text-sm font-bold text-blue-600 hover:text-blue-700 transition-colors">
                                        <span>All Courses</span>
                                        <span class="bg-blue-100 text-blue-600 text-[10px] px-2 py-0.5 rounded-full">120</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center justify-between text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">
                                        <span>Grammar</span>
                                        <span class="bg-slate-100 text-slate-500 text-[10px] px-2 py-0.5 rounded-full">45</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center justify-between text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">
                                        <span>Speaking</span>
                                        <span class="bg-slate-100 text-slate-500 text-[10px] px-2 py-0.5 rounded-full">32</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center justify-between text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">
                                        <span>Listening</span>
                                        <span class="bg-slate-100 text-slate-500 text-[10px] px-2 py-0.5 rounded-full">28</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center justify-between text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">
                                        <span>Writing</span>
                                        <span class="bg-slate-100 text-slate-500 text-[10px] px-2 py-0.5 rounded-full">15</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div onclick="sortCards('price', this)" class="border-b border-slate-100 pb-3 flex items-center justify-between cursor-pointer group select-none">
                            <span class="text-sm font-bold text-slate-600 group-hover:text-blue-600 transition-colors">Price</span>
                            <div class="flex items-center gap-2">
                                <span class="sort-indicator text-[10px] font-bold text-blue-600 hidden"></span>
                                <svg class="sort-icon w-4 h-4 text-slate-400 group-hover:text-blue-600 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                </svg>
                            </div>
                        </div>

                        <div onclick="sortCards('duration', this)" class="border-b border-slate-100 pb-3 flex items-center justify-between cursor-pointer group select-none">
                            <span class="text-sm font-bold text-slate-600 group-hover:text-blue-600 transition-colors">Duration</span>
                            <div class="flex items-center gap-2">
                                <span class="sort-indicator text-[10px] font-bold text-blue-600 hidden"></span>
                                <svg class="sort-icon w-4 h-4 text-slate-400 group-hover:text-blue-600 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

            </aside>

            <div class="w-full flex flex-col">
                <main id="courseContainer" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 w-full">
                    </main>
            </div>
        </div>
    </div>
</div>
 <x-landing.unlock/>

@push('scripts')
<script>
    function toggleCategories() {
        const list = document.getElementById('categoryList');
        const icon = document.getElementById('categoryIcon');
        
        list.classList.toggle('hidden');
        if (list.classList.contains('hidden')) {
            icon.style.transform = 'rotate(0deg)';
        } else {
            icon.style.transform = 'rotate(180deg)';
        }
    }

    let currentSort = { column: null, direction: 'asc' };

    function sortCards(type, element) {
        const container = document.getElementById('courseContainer');
        const cards = Array.from(container.getElementsByClassName('course-card'));
        
        if (currentSort.column === type) {
            currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
        } else {
            currentSort.column = type;
            currentSort.direction = 'asc';
        }

        cards.sort((a, b) => {
            let valA = parseFloat(a.getAttribute(`data-${type}`));
            let valB = parseFloat(b.getAttribute(`data-${type}`));

            if (currentSort.direction === 'asc') {
                return valA - valB;
            } else {
                return valB - valA;
            }
        });

        container.innerHTML = '';
        cards.forEach(card => container.appendChild(card));
        updateUI(element, type);
    }

    function updateUI(activeElement, type) {
        document.querySelectorAll('.sort-indicator').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.sort-icon').forEach(el => {
            el.style.transform = 'rotate(0deg)';
        });

        const indicator = activeElement.querySelector('.sort-indicator');
        const icon = activeElement.querySelector('.sort-icon');
        
        indicator.classList.remove('hidden');
        
        if (type === 'price') {
            indicator.textContent = currentSort.direction === 'asc' ? 'Low to High' : 'High to Low';
        } else if (type === 'duration') {
            indicator.textContent = currentSort.direction === 'asc' ? 'Shortest' : 'Longest';
        }

        if (currentSort.direction === 'desc') {
            icon.style.transform = 'rotate(180deg)';
        }
    }
</script>
@endpush
@endsection