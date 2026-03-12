<?php

use App\Models\ExamAttempt;
use App\Models\QuestionGroup;
use App\Models\Question;
use App\Models\AttemptAnswer;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;

new class extends Component {
    use WithFileUploads;

    public ExamAttempt $attempt;
    public array $groupIds = [];
    public int $currentIndex = 0;
    public array $answers = [];

    public int $remainingSeconds = 0;
    public array $flatQuestions = [];

    public function mount(ExamAttempt $attempt)
    {
        $this->attempt = $attempt;

        $durationInSeconds = ($this->attempt->exam->total_duration ?? 120) * 60;
        $elapsedSeconds = Carbon::parse($this->attempt->started_at)->diffInSeconds(now());
        $this->remainingSeconds = max(0, $durationInSeconds - $elapsedSeconds);

        $this->groupIds = DB::table('question_groups')->join('subsections', 'question_groups.subsection_id', '=', 'subsections.id')->join('sections', 'subsections.section_id', '=', 'sections.id')->where('sections.exam_id', $this->attempt->exam_id)->orderBy('sections.order_position')->orderBy('subsections.order_position')->orderBy('question_groups.order_position')->pluck('question_groups.id')->toArray();

        if (!empty($this->groupIds)) {
            $groups = QuestionGroup::with([
                'questions' => function ($q) {
                    $q->orderBy('order_position')->select('id', 'question_group_id');
                },
            ])
                ->whereIn('id', $this->groupIds)
                ->get();

            $globalQuestionNumber = 1;
            foreach ($this->groupIds as $gIndex => $gId) {
                $group = $groups->firstWhere('id', $gId);
                if ($group) {
                    foreach ($group->questions as $q) {
                        $this->flatQuestions[] = [
                            'id' => $q->id,
                            'group_index' => $gIndex,
                            'number' => $globalQuestionNumber++,
                        ];
                    }
                }
            }
        }

        $existingAnswers = AttemptAnswer::where('exam_attempt_id', $this->attempt->id)->get();
        foreach ($existingAnswers as $ans) {
            if ($ans->selected_option_id) {
                $this->answers[$ans->question_id] = $ans->selected_option_id;
            } elseif ($ans->answer_text) {
                $this->answers[$ans->question_id] = $ans->answer_text;
            } elseif ($ans->essay_content) {
                $this->answers[$ans->question_id] = $ans->essay_content;
            } elseif ($ans->audio_answer_path) {
                $this->answers[$ans->question_id] = $ans->audio_answer_path;
            }
        }

        foreach ($this->flatQuestions as $fq) {
            if (!array_key_exists($fq['id'], $this->answers)) {
                $this->answers[$fq['id']] = null;
            }
        }
    }

    public function getCurrentGroupProperty()
    {
        if (empty($this->groupIds)) {
            return null;
        }
        return QuestionGroup::with(['questions.options', 'subsection.section'])->find($this->groupIds[$this->currentIndex]);
    }

    public function nextGroup()
    {
        if ($this->currentIndex < count($this->groupIds) - 1) {
            $this->currentIndex++;
        }
    }
    public function prevGroup()
    {
        if ($this->currentIndex > 0) {
            $this->currentIndex--;
        }
    }
    public function goToGroup($groupIndex)
    {
        $this->currentIndex = $groupIndex;
    }

    public function updated($property, $value)
    {
        if (str_starts_with($property, 'answers.')) {
            $questionId = explode('.', $property)[1];
            $question = Question::find($questionId);

            if (!$question) {
                return;
            }

            $jenisSoal = strtolower(trim(str_replace(' ', '_', $question->type)));

            $dataToUpdate = [];

            if ($jenisSoal === 'multiple_choice') {
                $dataToUpdate['selected_option_id'] = $value;
            } elseif ($jenisSoal === 'short_answer') {
                $dataToUpdate['answer_text'] = $value;
            } elseif ($jenisSoal === 'essay') {
                $dataToUpdate['essay_content'] = $value;
            } elseif ($jenisSoal === 'record' || $jenisSoal === 'audio_record') {
                if (is_object($value)) {
                    $path = $value->store('answers/audios', 'public');
                    $dataToUpdate['audio_answer_path'] = $path;
                    $this->answers[$questionId] = $path;
                }
            }

            if (!empty($dataToUpdate)) {
                AttemptAnswer::updateOrCreate(['exam_attempt_id' => $this->attempt->id, 'question_id' => $questionId], $dataToUpdate);
            }
        }
    }

    public function finishExam()
    {
        $this->attempt->update([
            'status' => 'finished',
            'submitted_at' => now(),
        ]);

        $allAnswers = AttemptAnswer::with('question.options')->where('exam_attempt_id', $this->attempt->id)->get();

        $totalAutoScore = 0;

        foreach ($allAnswers as $ans) {
            $question = $ans->question;
            if (!$question) {
                continue;
            }

            $jenisSoal = strtolower(trim(str_replace(' ', '_', $question->type)));

            if ($jenisSoal === 'multiple_choice') {
                $selectedOption = $question->options->where('id', $ans->selected_option_id)->first();

                if ($selectedOption && $selectedOption->is_correct) {
                    $points = $question->points ?? 10;
                    $ans->update(['score' => $points]);
                    $totalAutoScore += $points;
                } else {
                    $ans->update(['score' => 0]);
                }
            }
        }

        $this->attempt->update(['total_score' => $totalAutoScore]);

        session()->flash('success', 'Ujian berhasil dikumpulkan! Pilihan ganda dinilai otomatis, esai menunggu pemeriksa.');
        return redirect('/');
    }
};
?>

<div class="py-12 bg-gray-50 min-h-screen font-sans">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">

        {{-- KIRI: AREA SOAL (QUESTION AREA) --}}
        <div class="flex-1 bg-white shadow-sm sm:rounded-lg p-6 border border-gray-100 relative min-h-[600px]">

            {{-- Header & Timer Alpine.js --}}
            <div class="flex justify-between items-center border-b pb-4 mb-6">
                <span class="text-sm font-semibold text-indigo-600 uppercase tracking-wider">
                    @if ($this->currentGroup)
                        {{ $this->currentGroup->subsection->section->title }} »
                        {{ $this->currentGroup->subsection->title }}
                    @endif
                </span>

                <div class="flex items-center gap-2 font-bold" x-data="{
                    timeLeft: {{ $remainingSeconds }},
                    get formattedTime() {
                        const h = Math.floor(this.timeLeft / 3600).toString().padStart(2, '0');
                        const m = Math.floor((this.timeLeft % 3600) / 60).toString().padStart(2, '0');
                        const s = (this.timeLeft % 60).toString().padStart(2, '0');
                        return `${h}:${m}:${s}`;
                    },
                    init() {
                        let timer = setInterval(() => {
                            if (this.timeLeft > 0) {
                                this.timeLeft--;
                            } else {
                                clearInterval(timer);
                                if (this.timeLeft > -1) {
                                    alert('Waktu Habis!');
                                    $wire.finishExam();
                                    this.timeLeft = -1;
                                }
                            }
                        }, 1000);
                    }
                }">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-colors duration-300"
                        :class="timeLeft < 300 ? 'text-red-600 animate-pulse' : 'text-gray-600'" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-mono text-xl transition-colors duration-300"
                        :class="timeLeft < 300 ? 'text-red-600' : 'text-gray-800'" x-text="formattedTime">
                        Memuat Waktu...
                    </span>
                </div>
            </div>

            {{-- Loading Overlay --}}
            <div wire:loading.flex wire:target="nextGroup,prevGroup,goToGroup"
                class="absolute inset-0 z-50 bg-white/80 backdrop-blur-[2px] flex flex-col items-center justify-center rounded-lg">
                <svg class="animate-spin h-10 w-10 text-indigo-600 mb-3" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span class="text-indigo-600 font-semibold animate-pulse">Memuat Soal...</span>
            </div>

            {{-- Soal --}}
            <div wire:loading.class="opacity-50 blur-sm transition-all duration-200" class="pb-20">
                @if ($this->currentGroup)

                    {{-- Media Soal --}}
                    @if ($this->currentGroup->audio_path || $this->currentGroup->image_path)
                        <div class="mb-6 bg-gray-50 p-4 rounded-xl border border-dashed border-gray-300">
                            @if ($this->currentGroup->audio_path)
                                <audio controls preload="metadata" controlsList="nodownload" class="w-full">
                                    <source
                                        src="{{ asset('storage/' . str_replace('public/', '', $this->currentGroup->audio_path)) }}">
                                </audio>
                            @endif
                            @if ($this->currentGroup->image_path)
                                <img src="{{ asset('storage/' . str_replace('public/', '', $this->currentGroup->image_path)) }}"
                                    alt="Group Media"
                                    class="mx-auto mt-4 rounded-lg max-h-[320px] w-auto object-contain">
                            @endif
                        </div>
                    @endif

                    @if ($this->currentGroup->passage_text)
                        <div
                            class="prose max-w-none mb-8 text-gray-800 bg-yellow-50 p-6 rounded-xl border border-yellow-200">
                            {!! $this->currentGroup->passage_text !!}
                        </div>
                        <hr class="my-6 border-gray-200">
                    @endif

                    {{-- Looping Pertanyaan --}}
                    <div class="space-y-12">
                        @foreach ($this->currentGroup->questions as $index => $question)
                            <div>
                                {{-- Teks Soal & Media Level Soal --}}
                                <div class="flex gap-4 mb-4">
                                    <div
                                        class="flex-shrink-0 w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold">
                                        {{-- Cari nomor urut global dari flatQuestions --}}
                                        @php
                                            $qNumber =
                                                collect($flatQuestions)->firstWhere('id', $question->id)['number'] ??
                                                '?';
                                        @endphp
                                        {{ $qNumber }}
                                    </div>
                                    <div class="prose max-w-none text-lg text-gray-800 pt-1">
                                        {!! $question->question_text !!}
                                    </div>
                                </div>

                                @if ($question->image_path)
                                    <div
                                        class="ml-12 mb-4 bg-gray-50 p-3 rounded-lg border border-dashed border-gray-300 inline-block">
                                        <img src="{{ asset('storage/' . str_replace('public/', '', $question->image_path)) }}"
                                            class="max-h-64 rounded-lg w-auto object-contain">
                                    </div>
                                @endif
                                @if ($question->audio_path)
                                    <div
                                        class="ml-12 mb-4 bg-gray-50 p-3 rounded-lg border border-dashed border-gray-300 inline-block w-full max-w-sm">
                                        <audio controls class="w-full h-10">
                                            <source
                                                src="{{ asset('storage/' . str_replace('public/', '', $question->audio_path)) }}">
                                        </audio>
                                    </div>
                                @endif

                                {{-- Input Jawaban --}}
                                <div class="ml-12">

                                    {{-- Multiple Choice --}}
                                    @if ($question->type === 'multiple_choice')
                                        <div class="space-y-3">
                                            @foreach ($question->options as $option)
                                                <label wire:key="option-{{ $option->id }}"
                                                    class="flex items-start p-4 border-2 rounded-xl cursor-pointer transition
                                                    {{ isset($answers[$question->id]) && $answers[$question->id] == $option->id ? 'border-indigo-500 bg-indigo-50' : 'border-gray-100 hover:border-gray-200' }}">
                                                    <div class="flex items-center h-5 mt-1">
                                                        <input type="radio" name="question_{{ $question->id }}"
                                                            wire:model.live="answers.{{ $question->id }}"
                                                            value="{{ $option->id }}"
                                                            class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                                    </div>
                                                    <div class="ml-3 text-gray-700 prose prose-sm max-w-none [&>p]:m-0">
                                                        {!! $option->option_text !!}
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>

                                        {{-- Short Answer --}}
                                    @elseif($question->type === 'short_answer')
                                        <div>
                                            <input type="text" wire:key="short-answer-{{ $question->id }}"
                                                wire:model.live.debounce.1000ms="answers.{{ $question->id }}"
                                                class="w-full p-4 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-colors"
                                                placeholder="Ketik jawaban Anda di sini..." autocomplete="off">

                                            <div wire:loading wire:target="answers.{{ $question->id }}"
                                                class="text-indigo-600 text-xs font-semibold mt-2 animate-pulse flex items-center gap-1">
                                                <svg class="animate-spin h-3 w-3 text-indigo-600"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                                Saving...
                                            </div>
                                        </div>

                                        {{-- Essay --}}
                                    @elseif($question->type === 'essay')
                                        <div>
                                            <textarea wire:model.live.debounce.1000ms="answers.{{ $question->id }}" rows="6"
                                                class="w-full p-4 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                                                placeholder="Type your essay here..."></textarea>
                                            <p class="text-right text-xs text-gray-400 mt-1">
                                                Characters: <span x-data
                                                    x-text="($wire.answers[{{ $question->id }}] || '').length"></span>
                                            </p>
                                        </div>

                                        {{-- Audio Record --}}
                                    @elseif($question->type === 'record')
                                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 bg-gray-50">

                                            @php
                                                $existingAudio = '';
                                                if (
                                                    isset($answers[$question->id]) &&
                                                    is_string($answers[$question->id])
                                                ) {
                                                    $existingAudio = asset(
                                                        'storage/' .
                                                            str_replace('public/', '', $answers[$question->id]),
                                                    );
                                                }
                                            @endphp

                                            @if ($existingAudio)
                                                <div
                                                    class="mb-4 bg-emerald-100 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg flex items-center gap-2 shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="font-bold">Audio Answer Saved</span>
                                                </div>
                                            @endif

                                            <div x-data="{
                                                recording: false,
                                                mediaRecorder: null,
                                                audioChunks: [],
                                                audioUrl: '{{ $existingAudio }}',
                                                uploading: false,
                                            
                                                startRecording() {
                                                    navigator.mediaDevices.getUserMedia({ audio: true })
                                                        .then(stream => {
                                                            this.mediaRecorder = new MediaRecorder(stream);
                                                            this.audioChunks = [];
                                                            this.mediaRecorder.ondataavailable = e => this.audioChunks.push(e.data);
                                            
                                                            this.mediaRecorder.onstop = () => {
                                                                let blob = new Blob(this.audioChunks, { type: 'audio/webm' });
                                                                this.audioUrl = URL.createObjectURL(blob);
                                                                this.uploadAudio(blob);
                                                                stream.getTracks().forEach(track => track.stop());
                                                            };
                                            
                                                            this.mediaRecorder.start();
                                                            this.recording = true;
                                                        })
                                                        .catch(e => alert('Microphone access is required to record audio.'));
                                                },
                                            
                                                stopRecording() {
                                                    if (this.mediaRecorder) {
                                                        this.mediaRecorder.stop();
                                                        this.recording = false;
                                                    }
                                                },
                                            
                                                uploadAudio(blob) {
                                                    this.uploading = true;
                                                    let file = new File([blob], 'recording_{{ $question->id }}.webm', { type: 'audio/webm' });
                                                    $wire.upload('answers.{{ $question->id }}', file,
                                                        () => { this.uploading = false; },
                                                        () => {
                                                            this.uploading = false;
                                                            alert('Failed to Upload.');
                                                        }
                                                    );
                                                }
                                            }">
                                                <div x-show="audioUrl"
                                                    class="mb-5 bg-white p-3 rounded-lg border shadow-sm"
                                                    style="display: {{ $existingAudio ? 'block' : 'none' }};">
                                                    <p class="text-xs text-gray-500 mb-2">Preview:</p>
                                                    <audio :src="audioUrl" controls class="w-full h-10"
                                                        controlsList="nodownload"></audio>
                                                </div>

                                                <div class="flex items-center gap-4">
                                                    <button x-show="!recording" @click="startRecording()"
                                                        type="button"
                                                        class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition shadow flex items-center gap-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                                        </svg>
                                                        <span
                                                            x-text="audioUrl ? 'Rekam Ulang' : 'Mulai Merekam'"></span>
                                                    </button>

                                                    <button x-show="recording" @click="stopRecording()"
                                                        type="button" style="display: none;"
                                                        class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition shadow animate-pulse flex items-center gap-2">
                                                        <div class="h-3 w-3 bg-white rounded-sm"></div>
                                                        Stop Recording
                                                    </button>

                                                    <div x-show="uploading" style="display: none;"
                                                        class="text-indigo-600 text-sm font-bold flex items-center gap-2">
                                                        <svg class="animate-spin h-5 w-5 text-indigo-600"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24">
                                                            <circle class="opacity-25" cx="12" cy="12"
                                                                r="10" stroke="currentColor" stroke-width="4">
                                                            </circle>
                                                            <path class="opacity-75" fill="currentColor"
                                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                            </path>
                                                        </svg>
                                                        Uploading Audio...
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Tombol Navigasi Bawah --}}
                    <div
                        class="flex justify-between absolute bottom-6 left-6 right-6 pt-6 border-t border-gray-100 bg-white">
                        <button wire:click="prevGroup" wire:loading.attr="disabled" @disabled($currentIndex === 0)
                            class="px-6 py-2 bg-white border border-gray-300 rounded-lg disabled:opacity-30 transition hover:bg-gray-50">
                            Back
                        </button>
                        <div wire:loading wire:target="answers"
                            class="text-indigo-600 font-medium animate-pulse mt-2">
                            Saving...</div>
                        <button wire:click="nextGroup" wire:loading.attr="disabled" @disabled($currentIndex === count($groupIds) - 1)
                            class="px-6 py-2 bg-indigo-600 text-white rounded-lg disabled:opacity-30 transition hover:bg-indigo-700">
                            Next
                        </button>
                    </div>
                @endif
            </div>
        </div>

        {{-- Sidebar Navigasi --}}
        <div class="w-full md:w-80">
            <div class="bg-white shadow-sm rounded-lg p-6 border border-gray-100 sticky top-6">
                <h3 class="text-sm font-bold uppercase mb-4 border-b pb-2">
                    Navigation
                </h3>

                {{-- Grid Angka Soal --}}
                <div class="grid grid-cols-5 gap-2 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                    @foreach ($flatQuestions as $fq)
                        <button wire:click="goToGroup({{ $fq['group_index'] }})" wire:loading.attr="disabled"
                            class="h-10 w-10 text-xs font-bold rounded-lg transition-all
                            {{ $currentIndex === $fq['group_index']
                                ? 'bg-indigo-600 text-white ring-2 ring-indigo-300'
                                : (isset($answers[$fq['id']]) && !empty($answers[$fq['id']])
                                    ? 'bg-emerald-500 text-white shadow-sm'
                                    : 'bg-gray-100 text-gray-600 hover:bg-gray-200 border border-gray-200') }}">
                            {{ $fq['number'] }}
                        </button>
                    @endforeach
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100">
                    <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
                        <div class="w-3 h-3 rounded bg-emerald-500"></div> Answered
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500 mb-4">
                        <div class="w-3 h-3 rounded bg-gray-100 border border-gray-200"></div> Not Answered
                    </div>
                </div>

                <button wire:click="finishExam" wire:loading.attr="disabled" type="button"
                    onclick="return confirm('Apakah Anda yakin ingin mengumpulkan ujian ini? Anda tidak bisa mengubah jawaban setelah ini.') || event.stopImmediatePropagation()"
                    class="w-full mt-2 bg-emerald-600 text-white py-3 rounded-xl font-bold shadow-md hover:bg-emerald-700 transition">
                    Finish Exam
                </button>
            </div>
        </div>

    </div>

    {{-- Script Pencegah Refresh/Tutup Tab --}}
    <script>
        window.addEventListener('beforeunload', function(e) {
            e.preventDefault();
            e.returnValue = '';
        });
    </script>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c7c7c7;
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a0a0a0;
        }
    </style>
</div>
