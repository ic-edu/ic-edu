<?php

use App\Models\Exam;
use App\Models\ExamAttempt;

use Livewire\Component;

new class extends Component {
    public Exam $exam;
    public int $totalQuestions = 0;

    public function mount(Exam $exam)
    {
        $this->exam = $exam;
    }

    public function startSimulation()
    {
        $userId = Auth::id();

        $existingAttempt = ExamAttempt::where('user_id', $userId)->where('exam_id', $this->exam->id)->where('status', 'ongoing')->first();

        if ($existingAttempt) {
            return redirect()->route('test_taker.simulator.exam', ['attempt' => $existingAttempt->id]);
        }

        $newAttempt = ExamAttempt::create([
            'user_id' => $userId,
            'exam_id' => $this->exam->id,
            'started_at' => now(),
            'status' => 'ongoing',
        ]);

        return redirect()->route('test_taker.simulator.exam', ['attempt' => $newAttempt->id]);
    }
};
?>

<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

        <!-- Header -->
        <div class="px-8 py-8 border-b border-gray-100 bg-gray-50">
            <h1 class="text-2xl font-bold text-gray-900">
                {{ $exam->title }}
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Simulasi Ujian Computer Based Test (CBT)
            </p>
        </div>

        <!-- Informasi -->
        <div class="px-8 py-8 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-5">
                Informasi Simulasi
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <div class="bg-gray-50 rounded-lg p-5 text-center border">
                    <p class="text-xs text-gray-500">Durasi Waktu</p>
                    <p class="mt-1 text-xl font-semibold text-gray-900">
                        {{ $exam->duration ?? 120 }} Menit
                    </p>
                </div>

                <div class="bg-gray-50 rounded-lg p-5 text-center border">
                    <p class="text-xs text-gray-500">Total Soal</p>
                    <p class="mt-1 text-xl font-semibold text-gray-900">
                        {{ $exam->total_questions }} Soal
                    </p>
                </div>

                <div class="bg-gray-50 rounded-lg p-5 text-center border">
                    <p class="text-xs text-gray-500">Passing Grade</p>
                    <p class="mt-1 text-xl font-semibold text-gray-900">
                        {{ $exam->passing_grade ?? 'N/A' }}
                    </p>
                </div>

            </div>
        </div>

        <!-- Instruksi -->
        <div class="px-8 py-8">
            <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">
                Peraturan & Instruksi
            </h2>

            <div class="prose max-w-none text-gray-600 text-sm">
                {!! $exam->description ?? '<p>Tidak ada instruksi khusus untuk ujian ini.</p>' !!}
            </div>

            <ul class="mt-5 space-y-2 text-sm text-gray-600 list-disc pl-5">
                <li>Pastikan koneksi internet stabil sebelum memulai.</li>
                <li>Waktu ujian tetap berjalan meskipun browser ditutup.</li>
                <li>Jangan menekan tombol <b>Refresh (F5)</b> atau <b>Back</b>.</li>
                <li>Pilih tempat yang tenang agar audio terdengar jelas.</li>
            </ul>
        </div>

        <!-- Footer / CTA -->
        <div class="px-8 py-6 bg-gray-50 border-t border-gray-100 flex justify-end">
            <button wire:click="startSimulation" wire:loading.attr="disabled"
                class="inline-flex items-center px-6 py-3 rounded-lg text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] transition shadow-sm">

                <span wire:loading.remove wire:target="startSimulation">
                    Mulai Simulasi
                </span>

                <span wire:loading wire:target="startSimulation">
                    Mempersiapkan...
                </span>

            </button>
        </div>

    </div>

</div>
