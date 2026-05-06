<?php

use App\Models\ExamAttempt;
use App\Models\Exam;
use App\Enums\ExamAttemptStatus;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    // Properti untuk filter pencarian
    public $search = '';
    public $selectedExam = '';

    // Reset halaman ke 1 setiap kali user mengetik pencarian
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingSelectedExam()
    {
        $this->resetPage();
    }

    // Menggunakan method with() agar data di-load secara dinamis per halaman (Pagination)
    public function with()
    {
        // 1. Ambil HANYA ujian yang statusnya 'finished' (sudah dikumpulkan)
        $query = ExamAttempt::with(['user', 'exam'])->where('status', ExamAttemptStatus::FINISHED->value);

        // 2. Filter berdasarkan nama peserta
        if (!empty($this->search)) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        // 3. Filter berdasarkan Ujian tertentu
        if (!empty($this->selectedExam)) {
            $query->where('exam_id', $this->selectedExam);
        }

        return [
            // Urutkan dari yang paling baru dikumpulkan
            'attempts' => $query->latest('submitted_at')->paginate(10),

            // Untuk dropdown filter pilihan ujian
            'exams' => Exam::orderBy('title')->get(),
        ];
    }
};
?>

<div class="min-h-screen bg-gray-50 p-8 font-sans">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Antrean Penilaian Ujian</h1>
            <p class="text-gray-500 mt-2">Pilih peserta yang telah menyelesaikan ujian untuk memberikan skor manual pada
                esai atau rekaman suara.</p>
        </div>

        {{-- Filter & Search Bar --}}
        <div
            class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-6 flex flex-col md:flex-row gap-4 justify-between items-center">

            <div class="w-full md:w-1/3 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" wire:model.live.debounce.500ms="search"
                    placeholder="Cari nama atau email peserta..."
                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="w-full md:w-1/3">
                <select wire:model.live="selectedExam"
                    class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-gray-700">
                    <option value="">-- Semua Ujian --</option>
                    @foreach ($exams as $ex)
                        <option value="{{ $ex->id }}">{{ $ex->title }}</option>
                    @endforeach
                </select>
            </div>

            <div wire:loading class="text-indigo-600 text-sm font-semibold animate-pulse w-full md:w-auto text-right">
                Memuat data...
            </div>
        </div>

        {{-- Tabel Data --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-xs uppercase tracking-wider text-gray-500">
                            <th class="p-4 font-bold">Nama Peserta</th>
                            <th class="p-4 font-bold">Ujian</th>
                            <th class="p-4 font-bold text-center">Waktu Submit</th>
                            <th class="p-4 font-bold text-center">Skor (Auto)</th>
                            <th class="p-4 font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($attempts as $att)
                            <tr class="hover:bg-indigo-50/50 transition-colors">
                                <td class="p-4">
                                    <div class="font-bold text-gray-800">
                                        {{ $att->user->name ?? 'User Tidak Diketahui' }}</div>
                                    <div class="text-sm text-gray-500">{{ $att->user->email ?? '-' }}</div>
                                </td>
                                <td class="p-4">
                                    <div class="font-semibold text-gray-700">{{ $att->exam->title ?? 'Ujian Dihapus' }}
                                    </div>
                                    <div class="text-xs text-gray-400">ID Sesi: <span
                                            class="font-mono">{{ substr($att->id, 0, 8) }}...</span></div>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="text-sm text-gray-700">
                                        {{ \Carbon\Carbon::parse($att->submitted_at)->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($att->submitted_at)->format('H:i') }} WIB</div>
                                </td>
                                <td class="p-4 text-center">
                                    <span
                                        class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full font-bold text-sm">
                                        {{ number_format($att->converted_score ?? 0, 1) }}
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    <a href="{{ route('examiner.grading', ['attempt' => $att->id]) }}"
                                        class="inline-flex items-center gap-1 px-4 py-2 bg-emerald-100 text-emerald-700 hover:bg-emerald-200 rounded-lg font-semibold text-sm transition-colors cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                        Nilai Sekarang
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Tidak ada data antrean penilaian ujian yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Links --}}
            @if ($attempts->hasPages())
                <div class="p-4 border-t border-gray-200 bg-gray-50">
                    {{ $attempts->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
