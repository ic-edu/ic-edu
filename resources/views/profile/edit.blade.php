@if(Auth::user()?->isTestTaker() || !Auth::user()?->isExaminer())
    @extends('layouts.test_taker')
    @section('title', 'Account Settings')
    
    @section('content')
    <div style="max-width: 900px; margin: 0 auto; width: 100%;">
        
        <div style="margin-bottom: 32px;">
            <h1 style="font-size: 1.8rem; font-weight: 900; color: var(--text); letter-spacing: -0.02em;">Account Settings</h1>
            <p style="font-size: 0.85rem; color: var(--muted); margin-top: 6px;">Manage your profile information, password, and security.</p>
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 24px;">
            {{-- Profile Information --}}
            <div class="card card-pad anim-in d1">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Update Password --}}
            <div class="card card-pad anim-in d2">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="card card-pad anim-in d3" style="border-color: #fca5a5;">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>

    </div>
    @endsection

@else
    {{-- DEFAULT BREEZE LAYOUT FOR EXAMINER / ADMIN --}}
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Profile') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
@endif
