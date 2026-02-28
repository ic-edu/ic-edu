<x-guest-layout>

{{-- Full-page gradient background --}}
<div class="min-h-screen w-full relative flex"
     style="background: linear-gradient(135deg, #dbeafe 0%, #c7d2fe 40%, #bfdbfe 70%, #e0f2fe 100%);">

    {{-- LEFT SIDE: Form (tidak diubah sama sekali) --}}
    <div class="w-full md:w-1/2 flex items-center justify-center px-16">

        <div class="w-full max-w-md">

            {{-- LOGO --}}
            <div class="mb-6">
                <img src="{{ asset('assets/ic_edu_logo.png') }}"
                     class="w-48 h-auto"
                     alt="IC EDU Logo">
            </div>

            {{-- Heading --}}
            <div class="space-y-2 mb-6">
                <h1 class="text-4xl font-semibold text-slate-900 leading-tight">
                    Create an account
                </h1>
                <p class="text-slate-600 text-sm">
                    Sign up and start your language journey.
                </p>
            </div>

            {{-- FORM --}}
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                {{-- Name --}}
                <div>
                    <x-input-label for="name" value="Full name" class="text-sm text-slate-700"/>
                    <x-text-input id="name"
                        class="mt-1.5 w-full rounded-full bg-white/80 border-0 shadow-md focus:ring-2 focus:ring-blue-400"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-sm"/>
                </div>

                {{-- Email --}}
                <div>
                    <x-input-label for="email" value="Email" class="text-sm text-slate-700"/>
                    <x-text-input id="email"
                        class="mt-1.5 w-full rounded-full bg-white/80 border-0 shadow-md focus:ring-2 focus:ring-blue-400"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required />
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-sm"/>
                </div>

                {{-- Password --}}
                <div>
                    <x-input-label for="password" value="Password" class="text-sm text-slate-700"/>
                    <x-text-input id="password"
                        class="mt-1.5 w-full rounded-full bg-white/80 border-0 shadow-md focus:ring-2 focus:ring-blue-400"
                        type="password"
                        name="password"
                        required />
                    <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-sm"/>
                </div>

                {{-- Confirm --}}
                <div>
                    <x-input-label for="password_confirmation" value="Confirm Password" class="text-sm text-slate-700"/>
                    <x-text-input id="password_confirmation"
                        class="mt-1.5 w-full rounded-full bg-white/80 border-0 shadow-md focus:ring-2 focus:ring-blue-400"
                        type="password"
                        name="password_confirmation"
                        required />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-sm"/>
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full py-3 mt-2 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold shadow-lg hover:opacity-90 transition">
                    Submit
                </button>

            </form>

            {{-- Divider --}}
            <div class="flex items-center gap-4 text-xs text-slate-500 mt-6">
                <div class="flex-1 h-px bg-slate-400"></div>
                OR
                <div class="flex-1 h-px bg-slate-400"></div>
            </div>

            {{-- Google --}}
            <button class="w-full mt-4 flex items-center justify-center gap-3 py-3 rounded-full border border-slate-300 bg-white/80 backdrop-blur shadow-sm hover:bg-white transition font-medium">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg"
                     class="w-5 h-5"
                     alt="Google">
                Continue with Google
            </button>

            {{-- Login --}}
            <p class="text-sm text-slate-600 mt-6 text-center">
                Already have an account?
                <a href="{{ route('login') }}" class="text-blue-600 font-medium">
                    Sign in
                </a>
            </p>

        </div>
    </div>

    {{-- RIGHT SIDE: Gambar mengapung DI ATAS gradient --}}
    <div class="hidden md:flex md:w-1/2 items-center">

        {{-- padding atas sejajar logo, bawah sejajar "Already have an account?", kanan diberi margin --}}
        <div class="w-full" style="padding: 6rem 2.5rem 6rem 2rem;">
            <div class="rounded-[28px] overflow-hidden"
                 style="height: 100%; min-height: 500px; box-shadow: 0 30px 80px rgba(0,0,0,0.18), 0 8px 24px rgba(0,0,0,0.10);">
                <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?auto=format&fit=crop&w=1400&q=80"
                     class="w-full h-full object-cover"
                     alt="Team working">
            </div>
        </div>

    </div>

</div>

</x-guest-layout>