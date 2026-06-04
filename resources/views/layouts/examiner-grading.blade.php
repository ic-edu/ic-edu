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

    <main class="grading-layout-main min-h-screen px-6 py-6 lg:px-10 mt-5">

        <div class="grading-header sticky top-0 z-30 mb-8 rounded-3xl border border-slate-200/70 bg-white/80 backdrop-blur-xl shadow-sm">

            <div class="grading-header-inner flex items-center justify-between px-6 py-5">

                <div class="grading-header-left flex items-center gap-5 min-w-0">

                    <a href="{{ route('examiner.exam-reviews') }}"
                        class="grading-back-btn inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-800">

                        <x-lucide-arrow-left class="w-4 h-4" />

                        <span>
                            Back
                        </span>
                    </a>

                    <div class="grading-header-divider h-8 w-px bg-slate-200"></div>

                    <div class="grading-title-box min-w-0">

                        <h1 class="grading-title text-2xl font-black tracking-tight text-slate-900">
                            Grading Workspace
                        </h1>

                        <p class="grading-subtitle mt-1 text-sm text-slate-500">
                            Review speaking & writing submissions professionally
                        </p>

                    </div>

                </div>

                <div class="grading-profile flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-2 shadow-sm">

                    <div class="grading-profile-avatar flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-black text-blue-700">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>

                    <div class="grading-profile-text leading-tight min-w-0">

                        <p class="grading-profile-name text-sm font-bold text-slate-800 truncate">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="grading-profile-role text-xs text-slate-400">
                            Examiner
                        </p>

                    </div>
                </div>
            </div>
        </div>

        <div class="grading-content mx-auto max-w-6xl">

            {{ $slot ?? '' }}

            @yield('content')
        </div>
    </main>

    <style>
        @media (max-width: 640px) {
            body {
                overflow-x: hidden !important;
                background: #f4f6f9 !important;
            }

            .grading-layout-main {
                padding: 0 !important;
                padding-bottom: 8.5rem !important;
                background: #f4f6f9 !important;
                width: 100% !important;
                max-width: 100% !important;
                overflow-x: hidden !important;
            }

            .grading-content {
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            /* =========================
               MOBILE HEADER
            ========================= */
            .grading-header {
                position: relative !important;
                top: auto !important;
                z-index: 30 !important;
                margin: 0 !important;
                margin-bottom: 1rem !important;
                padding: 0.85rem !important;
                border: 0 !important;
                border-radius: 0 !important;
                background: #f4f6f9 !important;
                box-shadow: none !important;
                backdrop-filter: none !important;
            }

            .grading-header-inner {
                display: grid !important;
                grid-template-columns: 1fr auto !important;
                grid-template-areas:
                    "back profile"
                    "title title";
                align-items: center !important;
                gap: 0.85rem !important;
                padding: 1rem !important;
                border-radius: 1.35rem !important;
                border: 1px solid #e5edf5 !important;
                background: #ffffff !important;
                box-shadow: 0 10px 28px rgba(15, 23, 42, 0.07) !important;
            }

            .grading-header-left {
                display: contents !important;
            }

            .grading-back-btn {
                grid-area: back !important;
                width: fit-content !important;
                padding: 0.68rem 0.9rem !important;
                border-radius: 1rem !important;
                font-size: 0.78rem !important;
                white-space: nowrap !important;
            }

            .grading-back-btn svg {
                width: 1rem !important;
                height: 1rem !important;
            }

            .grading-header-divider {
                display: none !important;
            }

            .grading-title-box {
                grid-area: title !important;
                width: 100% !important;
                min-width: 0 !important;
            }

            .grading-title {
                font-size: 1.65rem !important;
                line-height: 2rem !important;
                margin: 0 !important;
                letter-spacing: -0.03em !important;
            }

            .grading-subtitle {
                margin-top: 0.35rem !important;
                font-size: 0.82rem !important;
                line-height: 1.35rem !important;
                max-width: 100% !important;
            }

            .grading-profile {
                grid-area: profile !important;
                max-width: 155px !important;
                width: auto !important;
                padding: 0.55rem 0.65rem !important;
                border-radius: 1rem !important;
                gap: 0.55rem !important;
            }

            .grading-profile-avatar {
                width: 2.25rem !important;
                height: 2.25rem !important;
                min-width: 2.25rem !important;
                border-radius: 0.9rem !important;
                font-size: 0.72rem !important;
            }

            .grading-profile-text {
                min-width: 0 !important;
            }

            .grading-profile-name {
                font-size: 0.75rem !important;
                line-height: 1rem !important;
                max-width: 82px !important;
                white-space: normal !important;
                display: -webkit-box !important;
                -webkit-line-clamp: 2 !important;
                -webkit-box-orient: vertical !important;
                overflow: hidden !important;
            }

            .grading-profile-role {
                font-size: 0.65rem !important;
                line-height: 0.9rem !important;
            }
        }
    </style>
</body>

</html>