@extends('layouts.examiner')

@section('content')
<div class="greeting-box p-6 sm:p-2 bg-transparent text-black text-left mb-6 anim-in d1">
    <h1 class="text-3xl font-bold font-dmSans tracking-tight sm:text-2xl text-redDefault">
        Examiner Dashboard
    </h1>

    <p class="text-gray-600 mt-2 font-poppins text-sm">
        Manage assessments and review student submissions efficiently.
    </p>
</div>

<div class="grid grid-cols-1 xl:grid-cols-12 gap-6 lg:gap-8">

    {{-- LEFT CONTENT --}}
    <div class="xl:col-span-8 flex flex-col gap-6 lg:gap-8">

        {{-- OVERVIEW CARDS --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

            <div class="seamless-card rounded-2xl p-5 text-center">
                <div
                    class="w-12 h-12 mx-auto bg-blue-50 rounded-2xl flex items-center justify-center mb-3 text-xl">
                    📋
                </div>

                <p class="text-2xl font-bold text-slate-800">24</p>

                <p class="text-xs uppercase tracking-wider text-slate-400 mt-1">
                    Assigned Reviews
                </p>
            </div>

            <div class="seamless-card rounded-2xl p-5 text-center">
                <div
                    class="w-12 h-12 mx-auto bg-orange-50 rounded-2xl flex items-center justify-center mb-3 text-xl">
                    ⏳
                </div>

                <p class="text-2xl font-bold text-slate-800">8</p>

                <p class="text-xs uppercase tracking-wider text-slate-400 mt-1">
                    Pending Reviews
                </p>
            </div>

            <div class="seamless-card rounded-2xl p-5 text-center">
                <div
                    class="w-12 h-12 mx-auto bg-green-50 rounded-2xl flex items-center justify-center mb-3 text-xl">
                    ✅
                </div>

                <p class="text-2xl font-bold text-slate-800">56</p>

                <p class="text-xs uppercase tracking-wider text-slate-400 mt-1">
                    Completed
                </p>
            </div>

            <div class="seamless-card rounded-2xl p-5 text-center">
                <div
                    class="w-12 h-12 mx-auto bg-purple-50 rounded-2xl flex items-center justify-center mb-3 text-xl">
                    ⭐
                </div>

                <p class="text-2xl font-bold text-slate-800">6.8</p>

                <p class="text-xs uppercase tracking-wider text-slate-400 mt-1">
                    Avg Score
                </p>
            </div>

        </div>

    </div>

    {{-- RIGHT SIDEBAR --}}
    <div class="xl:col-span-4">

        <div class="seamless-card rounded-3xl p-7">

            <h3 class="text-2xl font-bold text-slate-900 mb-6">
                Examiner Profile
            </h3>

            <div class="flex flex-col items-center text-center">

                <div
                    class="w-24 h-24 rounded-full border-4 border-blue-900 flex items-center justify-center text-4xl font-bold text-blue-900">
                    EX
                </div>

                <h4 class="mt-5 text-2xl font-bold text-slate-900">
                    {{ auth()->user()->name }}
                </h4>

                <p class="text-slate-400 text-sm uppercase tracking-wider mt-1">
                    Examiner
                </p>

            </div>

        </div>

    </div>

</div>

@endsection