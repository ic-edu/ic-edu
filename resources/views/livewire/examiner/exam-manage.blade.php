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
    public $type = null;

    public function mount($type = null)
    {
        $this->type = $type;
    }

    public function rendering($view)
    {
        $view->layout('layouts.examiner');
    }

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
        // 1. Ambil HANYA ujian yang statusnya 'finished' dan examiner_id sesuai dengan ID penguji yang login
        $query = ExamAttempt::with(['user', 'exam'])
            ->where('status', ExamAttemptStatus::FINISHED->value)
            ->where('examiner_id', auth()->id());

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

        if (!empty($this->type)) {
            $query->whereHas('exam.examType', function ($q) {
                $q->whereRaw('LOWER(name) = ?', [strtolower($this->type)]);
            });
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

<div class="min-h-screen bg-transparent p-2 font-poppins">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="mb-6 anim-in d1">
            <h1 class="text-3xl font-bold font-dmSans tracking-tight text-slate-900">Antrean Penilaian Ujian</h1>
            <p class="text-slate-500 mt-2 text-sm font-poppins">Pilih peserta yang telah menyelesaikan ujian untuk memberikan skor manual pada
                esai atau rekaman suara.</p>
        </div>

        {{-- Filter & Search Bar --}}
        <div
            class="seamless-card rounded-[2rem] p-5 border border-slate-100 mb-6 flex flex-col md:flex-row gap-4 justify-between items-center anim-in d2">

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
                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
            </div>

            <div class="w-full md:w-1/3">
                <select wire:model.live="selectedExam"
                    class="w-full py-3 px-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    <option value="">-- Semua Ujian --</option>
                    @foreach ($exams as $ex)
                    <option value="{{ $ex->id }}">{{ $ex->title }}</option>
                    @endforeach
                </select>
            </div>

            <div wire:loading class="class=" text-brand-primary text-sm font-bold animate-pulse w-full md:w-auto text-right">
                Memuat data...
            </div>
        </div>

        {{-- Tabel Data --}}
        <div class="bg-white rounded-[2rem] border border-slate-100 overflow-hidden shadow-sm anim-in d3">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-[0.7rem] uppercase tracking-[0.2em] text-slate-400">
                            <th class="px-6 py-5 font-bold">Nama Peserta</th>
                            <th class="px-6 py-5 font-bold">Ujian</th>
                            <th class="px-6 py-5 font-bold text-center">Waktu Submit</th>
                            <th class="px-6 py-5 font-bold text-center">Skor (Auto)</th>
                            <th class="px-6 py-5 font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($attempts as $att)
                        <tr class="hover:bg-slate-50 transition-colors duration-200">
                            <td class="px-6 py-5">
                                <div class="font-bold text-slate-800">
                                    {{ $att->user->name ?? 'User Tidak Diketahui' }}
                                </div>
                                <div class="text-sm text-slate-500 mt-0.5">{{ $att->user->email ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="font-semibold text-gray-700">{{ $att->exam->title ?? 'Ujian Dihapus' }}
                                </div>
                                <div class="text-xs text-gray-400">ID Sesi: <span
                                        class="font-mono">{{ substr($att->id, 0, 8) }}...</span></div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <div class="text-sm text-gray-700">
                                    {{ \Carbon\Carbon::parse($att->submitted_at)->format('d M Y') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($att->submitted_at)->format('H:i') }} WIB
                                </div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span
                                    class="px-4 py-1.5 bg-blue-100 text-blue-700 rounded-full font-bold text-xs">
                                    {{ number_format($att->converted_score ?? 0, 1) }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <a href="{{ route('examiner.grading', ['attempt' => $att->id]) }}"
                                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white hover:opacity-90 rounded-xl font-bold text-xs transition-all shadow-sm hover:-translate-y-0.5">
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
                            <td colspan="5" class="py-20 text-center text-slate-500">
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
            <div class="p-5 border-t border-slate-100 bg-slate-50">
                {{ $attempts->links() }}
            </div>
            @endif
        </div>

    </div>
</div>