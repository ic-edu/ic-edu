<div class="py-12">
    @php
        $currentQuestion = $this->currentQuestion;
    @endphp

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
        {{-- Question Area --}}
        <div class="flex-1 bg-white shadow-sm sm:rounded-lg p-6 border border-gray-100">
            {{-- Header --}}
            <div class="flex justify-between items-center border-b pb-4 mb-6">
                <span class="text-sm font-semibold text-indigo-600 uppercase tracking-wider">
                    Question {{ $currentQuestionIndex + 1 }} of {{ $questions->count() }}
                </span>

                <div class="flex items-center gap-2 font-bold" x-data="{
                    timeLeft: {{ $remainingSeconds }},
                
                    get formattedTime() {
                        const totalSeconds = Math.floor(this.timeLeft);
                        const hours = Math.floor(totalSeconds / 3600);
                        const minutes = Math.floor((totalSeconds % 3600) / 60);
                        const seconds = totalSeconds % 60;
                        return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                    },
                
                    init() {
                        let timer = setInterval(() => {
                            if (this.timeLeft > 0) {
                                this.timeLeft--;
                            } else {
                                clearInterval(timer);
                                if (this.timeLeft > -1) {
                                    alert('Times Up!');
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
                        Loading...
                    </span>
                </div>
            </div>

            <div class="relative min-h-[450px]">
                {{-- Loading Overlay --}}
                <div wire:loading.flex wire:target="nextQuestion,previousQuestion,goToQuestion"
                    class="absolute inset-0 z-50 bg-white/80 backdrop-blur-[2px] flex flex-col items-center justify-center rounded-lg">

                    <svg class="animate-spin h-10 w-10 text-indigo-600 mb-3" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span class="text-indigo-600 font-semibold animate-pulse">Loading Question...</span>
                </div>

                {{-- Question Content --}}
                <div wire:loading.class="opacity-50 blur-sm transition-all duration-200">
                    @if ($currentQuestion)

                        {{-- Media --}}
                        @if ($currentQuestion->media_path)
                            <div class="mb-6 bg-gray-50 p-4 rounded-xl border border-dashed border-gray-300">
                                @if (str_contains($currentQuestion->media_path, '.mp3'))
                                    <audio controls preload="metadata" controlsList="nodownload noplaybackrate"
                                        oncontextmenu="return false" class="w-full"
                                        wire:key="audio-{{ $currentQuestion->id }}">
                                        <source src="{{ asset('storage/' . $currentQuestion->media_path) }}">
                                    </audio>
                                @else
                                    <img src="{{ asset('storage/' . $currentQuestion->media_path) }}"
                                        alt="Question Media"
                                        class="mx-auto rounded-lg max-h-[320px] w-auto object-contain" />
                                @endif
                            </div>
                        @endif

                        {{-- Question Text --}}
                        <div class="prose max-w-none mb-8 text-gray-800 text-lg">
                            {!! $currentQuestion->question_text !!}
                        </div>

                        <div class="space-y-4">
                            @if ($currentQuestion->type === 'multiple_choice')
                                {{-- Multiple Choice --}}
                                <div class="space-y-3">
                                    @foreach ($currentQuestion->options as $option)
                                        <label wire:key="option-{{ $option->id }}"
                                            class="flex items-center p-4 border-2 rounded-xl cursor-pointer transition
                                            {{ isset($selectedAnswers[$currentQuestion->id]) && $selectedAnswers[$currentQuestion->id] == $option->id
                                                ? 'border-indigo-500 bg-indigo-50'
                                                : 'border-gray-100 hover:border-gray-200' }}">
                                            <input type="radio" name="question_{{ $currentQuestion->id }}"
                                                wire:model.live="selectedAnswers.{{ $currentQuestion->id }}"
                                                value="{{ $option->id }}"
                                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">

                                            <span class="ml-4 text-gray-700 font-medium">
                                                {{ $option->option_text }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            @elseif($currentQuestion->type === 'short_answer')
                                {{-- Short Answer --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Your Answer:</label>
                                    <input type="text" wire:model.blur="selectedAnswers.{{ $currentQuestion->id }}"
                                        class="w-full p-4 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                                        placeholder="Type your answer here..." autocomplete="off">
                                </div>
                            @elseif($currentQuestion->type === 'essay')
                                {{-- Essay --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Write your essay
                                        below:</label>
                                    <textarea wire:model.live.debounce.1000ms="selectedAnswers.{{ $currentQuestion->id }}" rows="8"
                                        class="w-full p-4 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                                        placeholder="Type your essay here..."></textarea>
                                    <p class="text-right text-xs text-gray-400 mt-1">
                                        Characters: <span x-data
                                            x-text="$wire.selectedAnswers[{{ $currentQuestion->id }}]?.length || 0"></span>
                                    </p>
                                </div>
                            @elseif($currentQuestion->type === 'audio_record')
                                {{-- Audio Record --}}
                                @php
                                    $finalAudioUrl = '';
                                    $answer = $selectedAnswers[$currentQuestion->id] ?? null;
                                    $isAnswered = !empty($answer);

                                    if ($isAnswered) {
                                        if (is_object($answer) && method_exists($answer, 'temporaryUrl')) {
                                            $finalAudioUrl = $answer->temporaryUrl();
                                        } elseif (is_string($answer)) {
                                            if (str_starts_with($answer, 'livewire-file:')) {
                                                $filename = explode(':', $answer)[1] ?? '';
                                                $finalAudioUrl = url('livewire/preview-file/' . $filename);
                                            } else {
                                                $finalAudioUrl = asset('storage/' . $answer);
                                            }
                                        }
                                    }
                                @endphp

                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 bg-gray-50">

                                    @if ($isAnswered)
                                        <div
                                            class="mb-4 bg-emerald-100 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg flex items-center justify-center gap-2 shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="font-bold">Audio Answers Saved</span>
                                        </div>
                                    @endif

                                    <div x-data="{
                                        recording: false,
                                        mediaRecorder: null,
                                        audioChunks: [],
                                        audioUrl: '{{ $finalAudioUrl }}',
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
                                                    };
                                                    this.mediaRecorder.start();
                                                    this.recording = true;
                                                })
                                                .catch(e => alert('Microphone access denied.'));
                                        },
                                    
                                        stopRecording() {
                                            if (this.mediaRecorder) {
                                                this.mediaRecorder.stop();
                                                this.recording = false;
                                            }
                                        },
                                    
                                        uploadAudio(blob) {
                                            this.uploading = true;
                                            let file = new File([blob], 'answer.webm', { type: 'audio/webm' });
                                    
                                            $wire.upload('selectedAnswers.{{ $currentQuestion->id }}', file,
                                                () => { this.uploading = false; },
                                                () => {
                                                    this.uploading = false;
                                                    alert('Upload Failed');
                                                }
                                            );
                                        }
                                    }">

                                        <div x-show="audioUrl" class="mb-4 bg-white p-2 rounded border shadow-sm">
                                            <p class="text-xs text-gray-500 mb-1 ml-1">Preview Answer:</p>
                                            <audio :src="audioUrl" controls class="w-full h-8"
                                                controlsList="nodownload"></audio>
                                        </div>

                                        <div class="flex justify-center gap-3">
                                            <button x-show="!recording" @click="startRecording()" type="button"
                                                class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition shadow flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                                </svg>
                                                <span x-text="audioUrl ? 'Re-record' : 'Start Recording'"></span>
                                            </button>

                                            <button x-show="recording" @click="stopRecording()" type="button"
                                                style="display: none;"
                                                class="px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition shadow animate-pulse flex items-center gap-2">
                                                <div class="h-3 w-3 bg-white rounded-sm"></div>
                                                Stop Recording
                                            </button>
                                        </div>

                                        {{-- Loading Text --}}
                                        <div x-show="uploading" style="display: none;"
                                            class="mt-3 text-sm text-indigo-600 text-center font-bold">
                                            Uploading...
                                        </div>

                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Navigation Button --}}
                        <div class="flex justify-between mt-10 pt-6 border-t border-gray-100">
                            <button wire:click="previousQuestion" wire:loading.attr="disabled"
                                @disabled($currentQuestionIndex === 0)
                                class="px-6 py-2 bg-white border border-gray-300 rounded-lg disabled:opacity-30">
                                Back
                            </button>

                            <button wire:click="nextQuestion" wire:loading.attr="disabled"
                                @disabled($currentQuestionIndex === $questions->count() - 1)
                                class="px-6 py-2 bg-indigo-600 text-white rounded-lg disabled:opacity-30">
                                Next
                            </button>
                        </div>

                    @endif
                </div>
            </div>
        </div>

        {{-- Sidebar Navigation --}}
        <div class="w-full md:w-80">
            <div class="bg-white shadow-sm rounded-lg p-6 border border-gray-100 sticky top-6">
                <h3 class="text-sm font-bold uppercase mb-4 border-b pb-2">
                    Navigation
                </h3>

                <div class="grid grid-cols-5 gap-2">
                    @foreach ($questions as $index => $q)
                        <button wire:click="goToQuestion({{ $index }})" wire:loading.attr="disabled"
                            class="h-10 w-10 text-xs font-bold rounded-lg transition-all
                            {{ $currentQuestionIndex === $index
                                ? 'bg-indigo-600 text-white ring-2 ring-indigo-300'
                                : (isset($selectedAnswers[$q->id]) && !empty($selectedAnswers[$q->id])
                                    ? 'bg-emerald-500 text-white'
                                    : 'bg-gray-100 text-gray-600 hover:bg-gray-200') }}">
                            {{ $index + 1 }}
                        </button>
                    @endforeach
                </div>

                <button wire:click="finishExam" wire:loading.attr="disabled" type="button"
                    class="w-full mt-8 bg-emerald-600 text-white py-3 rounded-xl
                    font-bold shadow-md hover:bg-emerald-700 transition">
                    Finish Exam
                </button>
            </div>
        </div>

    </div>

    <script>
        window.addEventListener('beforeunload', function(e) {
            e.preventDefault();
            e.returnValue = '';
        });
    </script>
</div>
