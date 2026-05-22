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

    // Untuk menampung skor dan masukan manual
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

        // Ambil data attempt beserta relasi user, exam, dan examType
        $this->attempt = $attempt->load(['user', 'exam.examType']);
        $this->answers = AttemptAnswer::with('question')
            ->where('exam_attempt_id', $this->attempt->id)
            ->get();

        // Inisialisasi memori untuk inputan Examiner
        foreach ($this->answers as $ans) {
            $this->scores[$ans->id] = $ans->score ?? 0;
            $this->feedbacks[$ans->id] = $ans->feedback ?? '';
        }
    }

    // Auto-save nilai saat Dosen mengetik skor/feedback
    public function updated($property, $value)
    {
        $parts = explode('.', $property);
        if (count($parts) == 2) {
            $field = $parts[0]; // 'scores' atau 'feedbacks'
            $answerId = $parts[1];

            $columnToUpdate = $field === 'scores' ? 'score' : 'feedback';

            AttemptAnswer::where('id', $answerId)->update([
                $columnToUpdate => $value
            ]);

            // Hitung ulang skor menggunakan scoring engine ExamType
            $this->recalculateScore();
        }
    }

    /**
     * Hitung ulang skor total berdasarkan scoring_method ExamType.
     * Dipanggil setiap kali Examiner menyimpan nilai soal.
     */
    protected function recalculateScore(): void
    {
        $examType = $this->attempt->exam->examType;

        // 1. Kumpulkan semua jawaban terkini dari DB
        $allAnswers = AttemptAnswer::with([
            'question.questionGroup.subsection.section',
        ])->where('exam_attempt_id', $this->attempt->id)->get();

        // 2. Hitung raw score (total poin yang diperoleh)
        $rawScore = (int) $allAnswers->sum('score');

        // 3. Hitung total soal (untuk formula raw)
        $totalQuestions = $allAnswers->count();

        // 4. Bangun sectionRaws & sectionTotals (per nama section)
        $sectionRaws   = [];
        $sectionTotals = [];
        foreach ($allAnswers as $ans) {
            $sectionName = $ans->question->questionGroup->subsection->section->title ?? 'Unknown';
            $sectionRaws[$sectionName]   = ($sectionRaws[$sectionName]   ?? 0) + ($ans->score ?? 0);
            $sectionTotals[$sectionName] = ($sectionTotals[$sectionName] ?? 0) + ($ans->question->points ?? 0);
        }

        // 5. Gunakan engine calculateScore dari ExamType
        $result = $examType->calculateScore(
            rawScore: $rawScore,
            totalQuestions: $totalQuestions,
            sectionRaws: $sectionRaws,
            sectionTotals: $sectionTotals,
        );

        // 6. Simpan hasil ke attempt
        $this->attempt->update([
            'raw_score'       => $rawScore,
            'converted_score' => $result['converted_score'],
            'section_scores'  => $result['section_scores'],
            'is_passed'       => $result['is_passed'],
        ]);

        // Refresh data attempt di component
        $this->attempt->refresh();
    }

    public function finalizeGrading()
    {
        // Pastikan skor akhir dihitung ulang sebelum finalisasi
        $this->recalculateScore();

        // Ubah status jadi graded
        $this->attempt->update(['status' => ExamAttemptStatus::GRADED->value]);

        // Kirim notifikasi email ke test taker
        app(ExamNotificationService::class)->notifyTestTakerGraded($this->attempt);

        session()->flash('success', 'Penilaian selesai! Skor akhir berhasil disimpan.');
        return redirect()->route('examiner.exam-manage'); // Kembali ke antrean ujian
    }
};
?>

<div class="min-h-screen bg-gray-100 p-8 font-sans">
    <div class="max-w-5xl mx-auto">

        {{-- Header Data Peserta --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Lembar Penilaian (Examiner)</h1>
                <p class="text-gray-600 mt-1">Ujian: <span class="font-semibold">{{ $attempt->exam->title }}</span></p>
                <p class="text-gray-600">Peserta: <span class="font-semibold">{{ $attempt->user->name ?? 'Unknown' }}</span>
                    <span class="text-sm text-gray-400 ml-1">({{ $attempt->user->email ?? '-' }})</span>
                </p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500 uppercase tracking-wide">Skor Final ({{ $attempt->exam->examType->scoring_method ?? 'raw' }})</p>
                <p class="text-4xl font-black text-indigo-600">{{ number_format($attempt->converted_score ?? 0, 1) }}</p>
                <p class="text-xs text-gray-400 mt-1">Raw Score: {{ $attempt->raw_score ?? 0 }} poin</p>
                @if($attempt->is_passed !== null)
                <span class="inline-block mt-1 px-3 py-1 rounded-full text-xs font-bold {{ $attempt->is_passed ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $attempt->is_passed ? '✓ LULUS' : '✗ TIDAK LULUS' }}
                </span>
                @endif
            </div>
        </div>

        {{-- Looping Jawaban Peserta --}}
        <div class="space-y-6">
            @foreach($answers as $index => $ans)
                @php
                    $q = $ans->question;
                    $type = strtolower(trim(str_replace(' ', '_', $q->type)));
                    $maxPoints = $q->points ?? 1;
                @endphp

                <div class="bg-white p-6 rounded-xl shadow-sm border {{ $type === 'multiple_choice' ? 'border-gray-200 opacity-80' : 'border-indigo-200' }}">
                    
                    {{-- Soal --}}
                    <div class="flex gap-4 mb-4">
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-800 text-white rounded-full flex items-center justify-center font-bold">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <span class="text-xs font-bold uppercase px-2 py-1 bg-gray-100 rounded-md mb-2 inline-block">
                                {{ str_replace('_', ' ', $type) }}
                            </span>
                            <div class="prose max-w-none text-gray-800">{!! $q->question_text !!}</div>
                        </div>
                    </div>
                </div>

                {{-- Jawaban Peserta --}}
                <div class="ml-12 p-4 bg-yellow-50 rounded-lg border border-yellow-100 mb-6">
                    <p class="text-sm font-semibold text-yellow-800 mb-2">Jawaban Peserta:</p>

                    @if($type === 'multiple_choice')
                    @php
                    $opt = $q->options->where('id', $ans->selected_option_id)->first();
                    @endphp
                    <div class="flex items-center gap-2">
                        <span class="text-lg">{!! $opt->option_text ?? '<i class="text-gray-400">Tidak dijawab</i>' !!}</span>
                        @if($opt && $opt->is_correct)
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">BENAR</span>
                        @else
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold">SALAH</span>
                        @endif
                    </div>

                    @elseif($type === 'short_answer')
                    <p class="text-lg text-gray-800">{{ $ans->answer_text ?? '-' }}</p>

                    @elseif($type === 'essay')
                    <p class="text-gray-800 whitespace-pre-wrap">{{ $ans->essay_content ?? '-' }}</p>

                    @elseif($type === 'record' || $type === 'audio_record')
                    @if($ans->audio_answer_path)
                    <audio controls class="w-full max-w-md h-10">
                        <source src="{{ asset('storage/' . str_replace('public/', '', $ans->audio_answer_path)) }}">
                    </audio>
                    @else
                    <p class="text-gray-500 italic">Tidak ada rekaman audio.</p>
                    @endif
                    @endif
                </div>

                {{-- Area Penilaian (Hanya bisa diedit untuk selain Multiple Choice) --}}
                <div class="ml-12 flex flex-col md:flex-row gap-4 items-start bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <div class="w-full md:w-32">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Skor (Maks: {{ $maxPoints }})</label>
                        <input type="number" max="{{ $maxPoints }}" min="0" step="1"
                            wire:model.blur="scores.{{ $ans->id }}"
                            {{ $type === 'multiple_choice' ? 'disabled' : '' }}
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 {{ $type === 'multiple_choice' ? 'bg-gray-200' : 'bg-white font-bold text-indigo-700' }}">
                    </div>
                    <div class="flex-1 w-full">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Feedback / Catatan Examiner</label>
                        <input type="text"
                            wire:model.blur="feedbacks.{{ $ans->id }}"
                            placeholder="Opsional: Berikan masukan atas jawaban ini..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                    </div>
                    <div wire:loading wire:target="scores.{{ $ans->id }}, feedbacks.{{ $ans->id }}" class="mt-6 text-emerald-600 text-sm font-bold animate-pulse">
                        Tersimpan!
                    </div>
                </div>

            @endforeach
        </div>

        {{-- Tombol Simpan Final --}}
        <div class="mt-8 bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex justify-between items-center sticky bottom-6">
            <div>
                <p class="text-gray-600">Skor Final: <strong class="text-2xl text-indigo-600 ml-2">{{ number_format($attempt->converted_score ?? 0, 1) }}</strong>
                    <span class="text-sm text-gray-400 ml-1">/ {{ $attempt->exam->examType->max_score ?? 100 }}</span>
                </p>
                @if(!empty($attempt->section_scores))
                <div class="flex gap-3 mt-1">
                    @foreach($attempt->section_scores as $sectionName => $sectionScore)
                    <span class="text-xs text-gray-500">{{ $sectionName }}: <strong class="text-indigo-500">{{ $sectionScore }}</strong></span>
                    @endforeach
                </div>
                @endif
            </div>
            <button wire:click="finalizeGrading" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-md transition-colors">
                Konfirmasi & Selesai Penilaian ✓
            </button>
        </div>

    </div>
</div>