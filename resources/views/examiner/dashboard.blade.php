@extends('layouts.examiner')

@section('topbar')
    @include('components.examiner.topbar')
@endsection

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-12 gap-6 lg:gap-8">

    <div class="xl:col-span-8 flex flex-col gap-6 lg:gap-8">

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

            <div class="seamless-card rounded-2xl p-5 text-center">
                <div class="w-12 h-12 mx-auto bg-blue-50 rounded-2xl flex items-center justify-center mb-3 text-xl">
                    📋
                </div>

                <p class="text-2xl font-bold text-slate-800">
                    {{ $assignedReviews }}
                </p>

                <p class="text-xs uppercase tracking-wider text-slate-400 mt-1">
                    Assigned Reviews
                </p>
            </div>

            <div class="seamless-card rounded-2xl p-5 text-center">
                <div class="w-12 h-12 mx-auto bg-orange-50 rounded-2xl flex items-center justify-center mb-3 text-xl">
                    ⏳
                </div>

                <p class="text-2xl font-bold text-slate-800">
                    {{ $pendingReviews }}
                </p>

                <p class="text-xs uppercase tracking-wider text-slate-400 mt-1">
                    Pending Reviews
                </p>
            </div>

            <div class="seamless-card rounded-2xl p-5 text-center">
                <div class="w-12 h-12 mx-auto bg-green-50 rounded-2xl flex items-center justify-center mb-3 text-xl">
                    ✅
                </div>

                <p class="text-2xl font-bold text-slate-800">
                    {{ $completedReviews }}
                </p>

                <p class="text-xs uppercase tracking-wider text-slate-400 mt-1">
                    Completed
                </p>
            </div>

            <div class="seamless-card rounded-2xl p-5 text-center">
                <div class="w-12 h-12 mx-auto bg-purple-50 rounded-2xl flex items-center justify-center mb-3 text-xl">
                    🗓️
                </div>

                <p class="text-2xl font-bold text-slate-800">
                    {{ $gradedToday }}
                </p>

                <p class="text-xs uppercase tracking-wider text-slate-400 mt-1">
                    Graded Today
                </p>
            </div>

        </div>

        <div class="seamless-card rounded-3xl p-6">
            <div class="flex items-center justify-between gap-4 mb-5">
                <div>
                    <h3 class="text-xl font-bold text-slate-900">
                        Recent Submissions
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Latest assigned exams waiting for your manual review.
                    </p>
                </div>

                <span class="rounded-full bg-blue-50 px-4 py-2 text-xs font-bold text-blue-900">
                    {{ $pendingReviews }} waiting
                </span>
            </div>

            @forelse($recentSubmissions as $attempt)
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 rounded-2xl border border-slate-100 bg-white p-4 mb-3 hover:shadow-md transition">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-xl">
                        📝
                    </div>

                    <div>
                        <h4 class="font-bold text-slate-900">
                            {{ $attempt->exam->title ?? 'Untitled Exam' }}
                        </h4>

                        <p class="text-sm text-slate-500 mt-1">
                            Submission from
                            <span class="font-semibold text-slate-700">
                                {{ $attempt->user->name ?? 'Unknown User' }}
                            </span>

                            @if($attempt->user?->email)
                            <span class="text-slate-400">
                                ({{ $attempt->user->email }})
                            </span>
                            @endif
                        </p>

                        <div class="flex flex-wrap items-center gap-2 mt-3">
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                {{ $attempt->exam->examType->name ?? 'Exam' }}
                            </span>

                            <span class="rounded-full bg-orange-50 px-3 py-1 text-xs font-semibold text-orange-600">
                                Pending Review
                            </span>

                            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                {{ $attempt->submitted_at ? $attempt->submitted_at->diffForHumans() : 'No submit time' }}
                            </span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('examiner.grading', $attempt->id) }}"
                    class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-bold text-white hover:bg-blue-700 transition">
                    Review Now
                </a>
            </div>
            @empty
            <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-10 text-center">
                <div class="text-5xl mb-4">📭</div>

                <h4 class="font-bold text-slate-800">
                    No pending submissions
                </h4>

                <p class="text-sm text-slate-500 mt-2">
                    New assigned submissions will appear here after admin assigns them to you.
                </p>
            </div>
            @endforelse
        </div>

    </div>

    <div class="xl:col-span-4 flex flex-col gap-6">

        <div class="seamless-card rounded-3xl p-7">

            <h3 class="text-2xl font-bold text-slate-900 mb-6">
                Examiner Profile
            </h3>

            <div class="flex flex-col items-center text-center">

                <div class="w-24 h-24 rounded-full border-4 border-blue-900 flex items-center justify-center text-4xl font-bold text-blue-900">
                    EX
                </div>

                <h4 class="mt-5 text-2xl font-bold text-slate-900">
                    {{ auth()->user()->name }}
                </h4>

                <p class="text-slate-400 text-sm uppercase tracking-wider mt-1">
                    Examiner
                </p>

            </div>

            <div class="grid grid-cols-2 gap-3 mt-7">
                <div class="rounded-2xl bg-slate-50 p-4 text-center">
                    <p class="text-2xl font-bold text-slate-900">
                        {{ $completedReviews }}
                    </p>

                    <p class="text-xs text-slate-400 uppercase tracking-wider mt-1">
                        Reviews
                    </p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-4 text-center">
                    <p class="text-2xl font-bold text-slate-900">
                        {{ $completionRate }}%
                    </p>

                    <p class="text-xs text-slate-400 uppercase tracking-wider mt-1">
                        Completion
                    </p>
                </div>
            </div>

        </div>

        <div class="seamless-card rounded-3xl p-7">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h3 class="text-xl font-bold text-slate-900">
                        Review Progress
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Completed reviews from your assigned submissions.
                    </p>
                </div>
            </div>

            <div class="mt-6">
                <div class="flex justify-between text-sm mb-2">
                    <span class="font-semibold text-slate-700">
                        Completion Rate
                    </span>

                    <span class="font-bold text-blue-900">
                        {{ $completionRate }}%
                    </span>
                </div>

                <div class="h-3 w-full rounded-full bg-slate-100 overflow-hidden">
                    <div class="h-full rounded-full bg-blue-900"
                        style="width: {{ $completionRate }}%;">
                    </div>
                </div>

                <p class="text-xs text-slate-400 mt-3">
                    {{ $completedReviews }} completed from {{ $assignedReviews }} assigned reviews.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection