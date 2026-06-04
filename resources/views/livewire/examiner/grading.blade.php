<?php

use App\Models\ExamAttempt;
use App\Models\AttemptAnswer;
use App\Enums\ExamAttemptStatus;
use App\Services\ExamNotificationService;
use Livewire\Component;

new class extends Component
{
    public ExamAttempt $attempt;
    public $answers = [];

    public array $scores = [];
    public array $feedbacks = [];

    public function rendering($view)
    {
        $view->layout('layouts.examiner-grading');
    }

    public function mount(ExamAttempt $attempt)
    {
        if ($attempt->status === ExamAttemptStatus::GRADED->value) {
            abort(403, 'Ujian ini sudah selesai dinilai. Anda tidak dapat menilai ulang.');
        }

        if ($attempt->status !== ExamAttemptStatus::FINISHED->value) {
            abort(403, 'Ujian ini masih dikerjakan oleh peserta atau belum selesai.');
        }

        $this->attempt = $attempt->load(['user', 'exam.examType']);

        $this->answers = AttemptAnswer::with(['question.questionGroup', 'question.options'])
            ->where('exam_attempt_id', $this->attempt->id)
            ->get();

        foreach ($this->answers as $ans) {
            $this->scores[$ans->id] = $ans->score ?? 0;
            $this->feedbacks[$ans->id] = $ans->feedback ?? '';
        }
    }

    public function updated($property, $value)
    {
        $parts = explode('.', $property);

        if (count($parts) == 2) {
            $field = $parts[0];
            $answerId = $parts[1];

            $columnToUpdate = $field === 'scores' ? 'score' : 'feedback';

            AttemptAnswer::where('id', $answerId)->update([
                $columnToUpdate => $value,
            ]);

            $this->recalculateScore();
        }
    }

    protected function recalculateScore(): void
    {
        $examType = $this->attempt->exam->examType;

        $allAnswers = AttemptAnswer::with([
            'question.questionGroup.subsection.section',
        ])
            ->where('exam_attempt_id', $this->attempt->id)
            ->get();

        $rawScore = (int) $allAnswers->sum('score');
        $totalQuestions = $allAnswers->count();

        $sectionRaws = [];
        $sectionTotals = [];

        foreach ($allAnswers as $ans) {
            $sectionName = $ans->question->questionGroup->subsection->section->title ?? 'Unknown';

            $sectionRaws[$sectionName] = ($sectionRaws[$sectionName] ?? 0) + ($ans->score ?? 0);
            $sectionTotals[$sectionName] = ($sectionTotals[$sectionName] ?? 0) + ($ans->question->points ?? 0);
        }

        $result = $examType->calculateScore(
            rawScore: $rawScore,
            totalQuestions: $totalQuestions,
            sectionRaws: $sectionRaws,
            sectionTotals: $sectionTotals,
        );

        $this->attempt->update([
            'raw_score'       => $rawScore,
            'converted_score' => $result['converted_score'],
            'section_scores'  => $result['section_scores'],
            'is_passed'       => $result['is_passed'],
        ]);

        $this->attempt->refresh();
    }

    public function finalizeGrading()
    {
        $this->recalculateScore();

        $this->attempt->update([
            'status' => ExamAttemptStatus::GRADED->value,
        ]);

        app(ExamNotificationService::class)->notifyTestTakerGraded($this->attempt);

        session()->flash('success', 'Penilaian selesai! Skor akhir berhasil disimpan.');

        return redirect()->route('examiner.exam-reviews');
    }
};
?>

<div class="grading-page min-h-screen bg-gray-100 p-8 font-sans">
    <div class="grading-container max-w-5xl mx-auto">

        {{-- SUMMARY CARD --}}
        <div class="grading-summary-card bg-white p-6 rounded-xl shadow-sm border border-gray-200 mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Lembar Penilaian
                </h1>

                <p class="text-gray-600 mt-1">
                    Ujian:
                    <span class="font-semibold">
                        {{ $attempt->exam->title }}
                    </span>
                </p>

                <p class="text-gray-600">
                    Peserta:
                    <span class="font-semibold">
                        {{ $attempt->user->name ?? 'Unknown' }}
                    </span>

                    <span class="text-sm text-gray-400 ml-1">
                        ({{ $attempt->user->email ?? '-' }})
                    </span>
                </p>
            </div>

            <div class="grading-summary-status text-right">
                <p class="text-sm text-gray-500 uppercase tracking-wide">
                    Status
                </p>

                <p class="mt-2 inline-flex rounded-full bg-amber-50 px-4 py-2 text-sm font-bold text-amber-700">
                    In Review
                </p>

                <p class="text-xs text-gray-400 mt-2 max-w-[220px]">
                    Skor final dihitung setelah penilaian dikonfirmasi.
                </p>
            </div>
        </div>

        {{-- QUESTION LIST --}}
        <div class="grading-mobile-full space-y-6">
            @php
                $lastGroupId = null;
            @endphp

            @foreach($answers as $index => $ans)
                @php
                    $q = $ans->question;
                    $group = $q->questionGroup;
                    $type = strtolower(trim(str_replace(' ', '_', $q->type)));
                    $maxPoints = $q->points ?? 1;
                @endphp

                @if($group && $group->id !== $lastGroupId)
                    @php $lastGroupId = $group->id; @endphp

                    {{-- GROUP CONTEXT --}}
                    <div class="grading-group-card bg-slate-200/50 p-5 rounded-xl border border-slate-300/40 mb-4 mt-8 first:mt-0">
                        @if($group->title)
                            <h4 class="font-extrabold text-xs text-slate-800 uppercase tracking-wider mb-2">
                                {{ $group->title }}
                            </h4>
                        @endif

                        @if($group->instruction)
                            <p class="text-[11px] text-slate-500 font-semibold mb-3 italic">
                                {{ $group->instruction }}
                            </p>
                        @endif

                        @if($group->passage_text)
                            <div class="prose max-w-none text-xs text-slate-700 bg-white p-4 rounded-lg border border-slate-200/50 mb-3 shadow-inner leading-relaxed">
                                {!! $group->passage_text !!}
                            </div>
                        @endif

                        @if($group->audio_path)
                            <div class="mb-3">
                                <audio controls class="h-10 w-full max-w-md">
                                    <source src="{{ asset('storage/' . $group->audio_path) }}">
                                </audio>
                            </div>
                        @endif

                        @if($group->image_path)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $group->image_path) }}"
                                    alt="Group Image"
                                    class="max-w-md rounded-lg shadow-sm border border-slate-200">
                            </div>
                        @endif
                    </div>
                @endif

                {{-- QUESTION CARD --}}
                <div class="grading-question-card bg-white p-6 rounded-xl shadow-sm border {{ $type === 'multiple_choice' ? 'border-gray-200 opacity-80' : 'border-indigo-200' }}">

                    <div class="grading-question-inner flex gap-4 mb-4">
                        <div class="grading-number flex-shrink-0 w-8 h-8 bg-gray-800 text-white rounded-full flex items-center justify-center font-bold">
                            {{ $index + 1 }}
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="prose max-w-none text-gray-800 font-bold mb-3 text-sm leading-relaxed">
                                {!! $q->question_text !!}
                            </div>

                            @if($q->image_path)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $q->image_path) }}"
                                        alt="Question Image"
                                        class="max-w-md rounded-lg shadow-sm border border-gray-200">
                                </div>
                            @endif

                            @if($q->audio_path)
                                <div class="mb-3">
                                    <audio controls class="h-10">
                                        <source src="{{ asset('storage/' . $q->audio_path) }}">
                                    </audio>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- STUDENT ANSWER --}}
                    <div class="answer-box ml-12 p-4 bg-yellow-50 rounded-lg border border-yellow-100 mb-6">
                        <p class="answer-label text-sm font-semibold text-yellow-800 mb-2">
                            Jawaban Peserta:
                        </p>

                        @if($type === 'multiple_choice')
                            @php
                                $opt = $q->options->where('id', $ans->selected_option_id)->first();
                            @endphp

                            <div class="flex items-center gap-2">
                                <span class="text-lg">
                                    {!! $opt->option_text ?? '<i class="text-gray-400">Tidak dijawab</i>' !!}
                                </span>

                                @if($opt && $opt->is_correct)
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">
                                        BENAR
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold">
                                        SALAH
                                    </span>
                                @endif
                            </div>

                        @elseif($type === 'short_answer')
                            <p class="text-lg text-gray-800">
                                {{ $ans->answer_text ?? '-' }}
                            </p>

                        @elseif($type === 'essay')
                            <p class="text-gray-800 whitespace-pre-wrap">
                                {{ $ans->essay_content ?? '-' }}
                            </p>

                        @elseif($type === 'record' || $type === 'audio_record')
                            @if($ans->audio_answer_path)
                                <audio controls class="w-full max-w-md h-10">
                                    <source src="{{ asset('storage/' . str_replace('public/', '', $ans->audio_answer_path)) }}">
                                </audio>
                            @else
                                <p class="text-gray-500 italic">
                                    Tidak ada rekaman audio.
                                </p>
                            @endif
                        @endif
                    </div>

                    {{-- SCORING --}}
                    <div class="grading-score-box ml-12 flex flex-col md:flex-row gap-4 items-start bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div class="w-full md:w-32">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">
                                Skor (Maks: {{ $maxPoints }})
                            </label>

                            <input type="number"
                                max="{{ $maxPoints }}"
                                min="0"
                                step="1"
                                wire:model.blur="scores.{{ $ans->id }}"
                                {{ $type === 'multiple_choice' ? 'disabled' : '' }}
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 {{ $type === 'multiple_choice' ? 'bg-gray-200' : 'bg-white font-bold text-indigo-700' }}">
                        </div>

                        <div class="flex-1 w-full">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">
                                Feedback / Catatan Examiner
                            </label>

                            <input type="text"
                                wire:model.blur="feedbacks.{{ $ans->id }}"
                                placeholder="Opsional: Berikan masukan atas jawaban ini..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                        </div>

                        <div wire:loading
                            wire:target="scores.{{ $ans->id }}, feedbacks.{{ $ans->id }}"
                            class="mt-6 text-emerald-600 text-sm font-bold animate-pulse">
                            Tersimpan!
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        {{-- FINAL BAR --}}
        <div class="grading-final-bar mt-8 bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex justify-between items-center sticky bottom-6">
            <div>
                <p class="text-sm font-bold text-slate-800">
                    Finalize Assessment
                </p>

                <p class="text-xs text-slate-500 mt-1">
                    Pastikan semua skor dan feedback sudah diisi sebelum menyelesaikan penilaian.
                </p>
            </div>

            <button wire:click="finalizeGrading"
                wire:loading.attr="disabled"
                class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-md transition-colors disabled:opacity-60 disabled:cursor-not-allowed">

                <span wire:loading.remove wire:target="finalizeGrading">
                    Konfirmasi & Selesai Penilaian ✓
                </span>

                <span wire:loading wire:target="finalizeGrading">
                    Menyimpan...
                </span>
            </button>
        </div>

    </div>
</div>

<style>
    @media (max-width: 640px) {
        body {
            overflow-x: hidden !important;
            background: #f4f6f9 !important;
        }

        .grading-page {
            padding: 0 !important;
            padding-bottom: 8.5rem !important;
            background: #f4f6f9 !important;
        }

        .grading-container {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .grading-summary-card {
            margin: 0.85rem !important;
            margin-bottom: 1rem !important;
            padding: 1rem !important;
            border-radius: 1.35rem !important;
            display: grid !important;
            grid-template-columns: 1fr !important;
            gap: 0.9rem !important;
            align-items: start !important;
        }

        .grading-summary-card h1 {
            font-size: 1.35rem !important;
            line-height: 1.7rem !important;
        }

        .grading-summary-card p {
            font-size: 0.8rem !important;
            line-height: 1.3rem !important;
        }

        .grading-summary-status {
            text-align: left !important;
        }

        .grading-summary-status p:first-child {
            font-size: 0.68rem !important;
            line-height: 1rem !important;
        }

        .grading-summary-status .inline-flex {
            margin-top: 0.35rem !important;
            padding: 0.45rem 0.8rem !important;
            font-size: 0.75rem !important;
        }

        .grading-summary-status .text-xs {
            max-width: 100% !important;
        }

        .grading-mobile-full {
            width: 100vw !important;
            max-width: 100vw !important;
            margin-left: calc(50% - 50vw) !important;
            margin-right: calc(50% - 50vw) !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        .grading-mobile-full > * + * {
            margin-top: 1rem !important;
        }

        .grading-group-card {
            width: 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            border-radius: 0 !important;
            border-left: 0 !important;
            border-right: 0 !important;
            box-shadow: none !important;
            padding: 0.9rem 1rem !important;
        }

        .grading-question-card {
            width: 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            padding: 1rem !important;
            border-radius: 0 !important;
            border-left: none !important;
            border-right: none !important;
            box-shadow: none !important;
            overflow: hidden !important;
        }

        .grading-question-inner {
            gap: 0.8rem !important;
            margin-bottom: 1rem !important;
        }

        .grading-number {
            width: 2.1rem !important;
            height: 2.1rem !important;
            min-width: 2.1rem !important;
            font-size: 0.85rem !important;
        }

        .grading-question-card .prose {
            font-size: 0.85rem !important;
            line-height: 1.35rem !important;
        }

        .grading-question-card img {
            width: 100% !important;
            max-width: 100% !important;
            height: auto !important;
            border-radius: 0.85rem !important;
        }

        .grading-question-card audio {
            width: 100% !important;
            max-width: 100% !important;
        }

        .answer-box {
            margin-left: 0 !important;
            margin-bottom: 1rem !important;
            padding: 0 !important;
            background: transparent !important;
            border: 0 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
        }

        .answer-label {
            margin-bottom: 0.45rem !important;
            color: #92400e !important;
            font-size: 0.72rem !important;
            font-weight: 900 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.04em !important;
        }

        .answer-box .text-lg {
            font-size: 0.95rem !important;
            line-height: 1.35rem !important;
        }

        .answer-box p,
        .answer-box span {
            word-break: break-word !important;
        }

        .answer-box audio {
            margin-top: 0.4rem !important;
            width: 100% !important;
        }

        .grading-score-box {
            margin-left: 0 !important;
            padding: 0.9rem !important;
            border-radius: 1rem !important;
            gap: 0.85rem !important;
        }

        .grading-score-box label {
            font-size: 0.66rem !important;
            line-height: 1rem !important;
        }

        .grading-score-box input {
            width: 100% !important;
            border-radius: 0.9rem !important;
            font-size: 0.9rem !important;
        }

        .grading-final-bar {
            position: fixed !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            z-index: 60 !important;
            margin: 0 !important;
            padding: 0.85rem 1rem !important;
            border-radius: 1.25rem 1.25rem 0 0 !important;
            display: grid !important;
            grid-template-columns: 1fr 1.25fr !important;
            gap: 0.75rem !important;
            align-items: center !important;
            box-shadow: 0 -12px 30px rgba(15, 23, 42, 0.14) !important;
        }

        .grading-final-bar p {
            font-size: 0.72rem !important;
            line-height: 1.1rem !important;
        }

        .grading-final-bar button {
            width: 100% !important;
            padding: 0.85rem 0.7rem !important;
            border-radius: 1rem !important;
            font-size: 0.8rem !important;
            line-height: 1.2rem !important;
        }

        .grading-final-bar span {
            font-size: 0.68rem !important;
        }
    }
</style>