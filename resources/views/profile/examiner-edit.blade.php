@extends('layouts.examiner')

@section('title', 'Examiner Settings')

@section('content')
<div class="max-w-5xl mx-auto w-full">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-black tracking-tight text-slate-900 font-dmSans">
            Account Settings
        </h1>

        <p class="text-sm text-slate-500 mt-2 font-poppins">
            Manage your examiner profile information, password, and account security.
        </p>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">

        {{-- Left Profile Summary --}}
        <div class="xl:col-span-4">
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-7 sticky top-6">

                <div class="flex flex-col items-center text-center">

                    <div
                        class="w-24 h-24 rounded-full border-4 border-blue-900 flex items-center justify-center text-4xl font-black text-blue-900">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>

                    <h2 class="mt-5 text-2xl font-black text-slate-900">
                        {{ auth()->user()->name }}
                    </h2>

                    <p class="text-slate-400 text-sm uppercase tracking-wider mt-1 font-bold">
                        Examiner
                    </p>

                    <div class="mt-5 inline-flex rounded-full bg-blue-100 text-blue-700 px-4 py-2 text-xs font-bold">
                        Active Account
                    </div>

                </div>

            </div>
        </div>

        {{-- Right Forms --}}
        <div class="xl:col-span-8 space-y-6">

            {{-- Profile Information --}}
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6 anim-in d1">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Update Password --}}
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6 anim-in d2">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="bg-white rounded-[2rem] border border-red-200 shadow-sm p-6 anim-in d3">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>

    </div>

</div>
@endsection