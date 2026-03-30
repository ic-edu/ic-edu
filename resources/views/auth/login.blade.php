<x-guest-layout>

{{-- Full-page gradient background --}}
<div class="min-h-screen w-full relative flex"
     style="background: linear-gradient(135deg, #dbeafe 0%, #c7d2fe 40%, #bfdbfe 70%, #e0f2fe 100%);">

    {{-- LEFT SIDE: Form --}}
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
                    Welcome back
                </h1>
                <p class="text-slate-600 text-sm">
                    Sign in to continue your language journey.
                </p>
            </div>

            {{-- FORM --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <x-input-label for="email" value="Email" class="text-sm text-slate-700"/>
                    <x-text-input id="email"
                        class="mt-1.5 w-full rounded-full bg-white/80 border-0 shadow-md focus:ring-2 focus:ring-blue-400"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required autofocus autocomplete="username"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-sm"/>
                </div>

                {{-- Password --}}
                <div>
                    <x-input-label for="password" value="Password" class="text-sm text-slate-700"/>
                    <x-text-input id="password"
                        class="mt-1.5 w-full rounded-full bg-white/80 border-0 shadow-md focus:ring-2 focus:ring-blue-400"
                        type="password"
                        name="password"
                        required autocomplete="current-password"/>
                    <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-sm"/>
                </div>

                {{-- Remember + Forgot --}}
                <div class="flex items-center justify-between text-sm mt-2">
                    <label class="flex items-center gap-2 text-slate-600">
                        <input id="remember_me"
                               type="checkbox"
                               class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-600"
                               name="remember">
                        Remember me
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-slate-500 hover:text-blue-600 transition">
                            Forgot password?
                        </a>
                    @endif
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full py-3 mt-2 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold shadow-lg hover:opacity-90 transition">
                    Log in
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

            {{-- Register --}}
            <p class="text-sm text-slate-600 mt-6 text-center">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-blue-600 font-medium">
                    Register
                </a>
            </p>

        </div>
    </div>

    {{-- RIGHT SIDE: Gambar mengapung di atas gradient --}}
    <div class="hidden md:flex md:w-1/2 items-center">

        <div class="w-full" style="padding: 6rem 2.5rem 6rem 2rem;">
            <div class="rounded-[28px] overflow-hidden"
                 style="height: 500px; box-shadow: 0 30px 80px rgba(0,0,0,0.18), 0 8px 24px rgba(0,0,0,0.10);">
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1400&q=80"
                     class="w-full h-full object-cover"
                     alt="Education Illustration">
            </div>
        </div>

    </div>

</div>

</x-guest-layout>