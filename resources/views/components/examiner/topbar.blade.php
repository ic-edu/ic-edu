@php
use App\Models\ExamAttempt;
use App\Enums\ExamAttemptStatus;

$user = auth()->user();

$hour = date('H');

if ($hour < 12) {
    $greeting='Good Morning' ;
    } elseif ($hour < 18) {
    $greeting='Good Afternoon' ;
    } else {
    $greeting='Good Evening' ;
    }

    $firstName=explode(' ', $user?->name ?? ' Examiner')[0];

    $pendingReviews=ExamAttempt::where('examiner_id', $user?->id)
    ->where('status', ExamAttemptStatus::FINISHED->value)
    ->count();

    $completedReviews = ExamAttempt::where('examiner_id', $user?->id)
    ->where('status', ExamAttemptStatus::GRADED->value)
    ->count();

    $assignedReviews = ExamAttempt::where('examiner_id', $user?->id)->count();

    $unreadNotifications = $user ? $user->unreadNotifications()->count() : 0;
    @endphp

    <div class="examiner-topbar relative overflow-hidden rounded-[2rem] bg-[#1A456C] px-8 py-8 shadow-xl mt-5 mb-8 mx-0 mr-8">

        <div class="absolute -right-24 -top-24 h-72 w-72 rounded-full bg-white/10"></div>
        <div class="absolute right-40 -bottom-24 h-64 w-64 rounded-full bg-cyan-300/10"></div>
        <div class="absolute left-10 bottom-8 h-24 w-24 rounded-full bg-white/5"></div>

        <button type="button"
            class="examiner-notification-trigger examiner-topbar-notification absolute right-7 top-7 z-30 flex h-12 w-12 items-center justify-center rounded-2xl border border-white/15 bg-white/10 text-white hover:bg-white/20 transition">

            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0a3 3 0 01-6 0m6 0H9" />
            </svg>

            @if($unreadNotifications > 0)
            <span class="absolute -right-1 -top-1 flex h-5 min-w-5 items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold text-white">
                {{ $unreadNotifications > 9 ? '9+' : $unreadNotifications }}
            </span>
            @endif
        </button>

        <div class="examiner-topbar-inner relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8 pr-14">

            <div class="flex items-center gap-7">

                <div class="examiner-topbar-mascot hidden md:flex h-40 w-40 shrink-0 items-center justify-center">
                    <img
                        src="{{ asset('assets/maskot/pen maskot.png') }}"
                        alt="Examiner Mascot"
                        class="h-36 w-auto drop-shadow-2xl">
                </div>

                <div class="examiner-topbar-copy max-w-2xl">
                    <div class="mb-4 inline-flex items-center rounded-full bg-white/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-blue-100">
                        Examiner Workspace
                    </div>

                    <h1 class="examiner-topbar-title text-3xl lg:text-4xl !text-white font-black font-heading tracking-tight mb-3 flex items-center gap-2">
                        {{ $greeting }}, {{ $firstName }}!
                        <span class="inline-block transform origin-bottom-right hover:rotate-12 transition-transform cursor-default">👋</span>
                    </h1>

                    <p class="examiner-topbar-desc text-blue-100 font-medium text-sm lg:text-base mb-6 leading-relaxed">
                        @if($pendingReviews > 0)
                        You have <span class="font-bold text-white">{{ $pendingReviews }} pending review{{ $pendingReviews > 1 ? 's' : '' }}</span>
                        waiting for assessment. Keep the grading queue moving smoothly.
                        @elseif($completedReviews > 0)
                        Great work! You have completed <span class="font-bold text-white">{{ $completedReviews }} review{{ $completedReviews > 1 ? 's' : '' }}</span>.
                        New assigned submissions will appear in your queue.
                        @else
                        Welcome aboard. Assigned submissions from admin will appear here once students finish their exams.
                        @endif
                    </p>

                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('examiner.exam-reviews') }}"
                            class="inline-flex items-center gap-2 bg-white text-[#1A456C] font-bold px-5 py-2.5 rounded-xl hover:bg-slate-50 hover:scale-105 transition-all shadow-md text-sm">
                            <span>📋</span>
                            Review Queue
                        </a>
                    </div>
                </div>

            </div>

            <div class="hidden xl:grid grid-cols-2 gap-3 min-w-[260px]">
                <div class="rounded-2xl border border-white/10 bg-white/10 px-5 py-5 text-center">
                    <p class="text-3xl font-black text-white">
                        {{ $assignedReviews }}
                    </p>
                    <p class="mt-1 text-[11px] uppercase tracking-wider text-blue-100">
                        Assigned
                    </p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/10 px-5 py-5 text-center">
                    <p class="text-3xl font-black text-white">
                        {{ $completedReviews }}
                    </p>
                    <p class="mt-1 text-[11px] uppercase tracking-wider text-blue-100">
                        Completed
                    </p>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 640px) {
            .examiner-topbar {
                margin: 1rem 1rem 1.5rem 1rem !important;
                padding: 1.5rem !important;
                border-radius: 1.5rem !important;
                min-height: auto !important;
            }

            .examiner-topbar-notification {
                top: 1rem !important;
                right: 1rem !important;
                width: 2.75rem !important;
                height: 2.75rem !important;
                border-radius: 1rem !important;
            }

            .examiner-topbar-inner {
                padding-right: 0 !important;
                gap: 1rem !important;
            }

            .examiner-topbar-mascot {
                display: none !important;
            }

            .examiner-topbar-copy {
                max-width: 100% !important;
                padding-right: 3.25rem !important;
            }

            .examiner-topbar-copy>div:first-child {
                font-size: 0.62rem !important;
                padding: 0.45rem 0.8rem !important;
                margin-bottom: 1rem !important;
                letter-spacing: 0.14em !important;
            }

            .examiner-topbar-title {
                display: block !important;
                font-size: 1.75rem !important;
                line-height: 2.05rem !important;
                margin-bottom: 0.85rem !important;
            }

            .examiner-topbar-title span {
                display: inline-block !important;
                margin-left: 0.25rem !important;
            }

            .examiner-topbar-desc {
                font-size: 0.82rem !important;
                line-height: 1.45rem !important;
                margin-bottom: 1.25rem !important;
            }

            .examiner-topbar a {
                width: fit-content !important;
                padding: 0.75rem 1.1rem !important;
                font-size: 0.8rem !important;
                border-radius: 0.9rem !important;
            }

            .examiner-topbar .absolute.-right-24 {
                width: 11rem !important;
                height: 11rem !important;
                right: -4rem !important;
                top: -4rem !important;
            }

            .examiner-topbar .absolute.right-40 {
                width: 9rem !important;
                height: 9rem !important;
                right: -2rem !important;
                bottom: -3rem !important;
            }

            .examiner-topbar .absolute.left-10 {
                width: 6rem !important;
                height: 6rem !important;
                left: -2rem !important;
                bottom: 1rem !important;
            }
        }
    </style>