@extends('layouts.test_taker')

@section('title', 'Courses')

@section('content')
<div class="courses-page relative w-full h-full pb-20">
    <div class="greeting-box p-6 sm:p-2 bg-transparent text-black drop-shadow-none shadow-none text-left mb-6">
        <h1 class="text-3xl font-bold font-dmSans tracking-tight sm:text-2xl text-redDefault">Courses</h1>
        <p class="text-gray-600 mt-2 font-poppins text-sm">Explore and manage your courses here.</p>
    </div>

    <!-- Search and Filter Bar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 mx-6 sm:mx-2">
        <div class="relative w-full md:w-96 group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <x-lucide-search class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" />
            </div>
            <input type="text" class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all shadow-sm placeholder-gray-400" placeholder="Search for courses, subjects, or keywords...">
        </div>
        
        <div class="flex items-center gap-3">
            <button class="flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm">
                <x-lucide-filter class="w-4 h-4" />
                Filters
            </button>
            <div class="relative">
                <select class="px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all shadow-sm appearance-none pr-10 relative cursor-pointer min-w-[140px]">
                    <option>Most Popular</option>
                    <option>Newest</option>
                    <option>Highest Rated</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <x-lucide-chevron-down class="w-4 h-4 text-gray-400" />
                </div>
            </div>
        </div>
    </div>

    <!-- Course Content Here -->
    <div class="course-list grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 auto-rows-min mx-6 sm:mx-2">
        <x-test_taker.card 
            title="IELTS Reading Masterclass" 
            image="https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?q=80&w=800&fit=crop"
            badge="Intermediate"
            duration="14h 20m"
            lessons="32 Lessons"
            progress="45"
            description="Master skimming and scanning techniques to ace your IELTS Reading test within the time limit."
        />
        
        <x-test_taker.card 
            title="Advanced English Grammar" 
            image="https://images.unsplash.com/photo-1546410531-bb4caa6b424d?q=80&w=800&fit=crop"
            badge="Advanced"
            duration="28h 15m"
            lessons="64 Lessons"
            progress="100"
            description="Deep dive into complex sentence structures, tenses, and academic writing mechanics."
        />

        <x-test_taker.card 
            title="TOEFL iBT Speaking Prep" 
            image="https://images.unsplash.com/photo-1516321497487-e288fb19713f?q=80&w=800&fit=crop"
            badge="All Levels"
            duration="8h 45m"
            lessons="18 Lessons"
            progress="0"
            description="Practice speaking confidently with native-like pronunciation and structured responses for the TOEFL test."
        />
        
        <x-test_taker.card 
            title="Business English Communication" 
            image="https://images.unsplash.com/photo-1573164713988-8665fc963095?q=80&w=800&fit=crop"
            badge="Intermediate"
            duration="5h 30m"
            lessons="12 Lessons"
            progress="15"
            description="Learn to write professional emails, conduct meetings, and negotiate effectively in a corporate environment."
        />

        <x-test_taker.card 
            title="TOEIC Listening & Reading" 
            image="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=800&fit=crop"
            badge="Beginner"
            duration="12h 00m"
            lessons="24 Lessons"
            progress="0"
            description="Comprehensive preparation covering all sections of the TOEIC test, focusing on workplace English."
        />

        <x-test_taker.card 
            title="English Idioms & Phrasal Verbs" 
            image="https://images.unsplash.com/photo-1543269865-cbf427effbad?q=80&w=800&fit=crop"
            badge="Advanced"
            duration="4h 45m"
            lessons="10 Lessons"
            progress="5"
            description="Sound more like a native speaker by mastering common expressions, idioms, and phrasal verbs."
        />
    </div>
</div>
@endsection
