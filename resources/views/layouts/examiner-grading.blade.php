<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('assets/icidu_logo.png') }}">

    <title>Grading Workspace - IC EDU</title>

    @vite([
    'resources/css/app.css',
    'resources/css/test_taker.css',
    'resources/js/app.js'
    ])
</head>

<body class="bg-slate-50 font-[Poppins]">

    <main class="min-h-screen px-6 py-6 lg:px-10">

        <div
            class="sticky top-0 z-30 mb-8 rounded-3xl border border-slate-200/70 bg-white/80 backdrop-blur-xl shadow-sm">

            <div class="flex items-center justify-between px-6 py-5">

                <div class="flex items-center gap-5">

                    <a href="{{ route('examiner.exam-reviews') }}"
                        class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-800">

                        <x-lucide-arrow-left class="w-4 h-4" />

                        <span>
                            Back
                        </span>
                    </a>

                    <div class="h-8 w-px bg-slate-200"></div>

                    <div>

                        <h1 class="text-2xl font-black tracking-tight text-slate-900">
                            Grading Workspace
                        </h1>

                        <p class="mt-1 text-sm text-slate-500">
                            Review speaking & writing submissions professionally
                        </p>

                    </div>

                </div>

                <div class="flex items-center gap-3">
                    <div
                        class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-2 shadow-sm">

                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-sm font-black text-blue-700">

                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}

                        </div>

                        <div class="leading-tight">

                            <p class="text-sm font-bold text-slate-800">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="text-xs text-slate-400">
                                Examiner
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mx-auto max-w-6xl">

            {{ $slot ?? '' }}

            @yield('content')
        </div>
    </main>
</body>
</html>