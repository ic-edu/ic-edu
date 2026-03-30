<?php

use App\Models\ExamAttempt;
use App\Models\QuestionGroup;
use App\Models\Question;
use App\Models\AttemptAnswer;
use App\Models\Section;
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

    // Section instruction state
    public bool $showingSectionInstruction = true;
    public ?int $currentSectionId = null;
    public array $sectionMap = []; // groupIndex => section_id

    public function mount(ExamAttempt $attempt)
    {
        $this->attempt = $attempt;

        $durationInSeconds = ($this->attempt->exam->total_duration ?? 120) * 60;
        $elapsedSeconds = Carbon::parse($this->attempt->started_at)->diffInSeconds(now());
        $this->remainingSeconds = max(0, $durationInSeconds - $elapsedSeconds);

        $groupData = DB::table('question_groups')
            ->join('subsections', 'question_groups.subsection_id', '=', 'subsections.id')
            ->join('sections', 'subsections.section_id', '=', 'sections.id')
            ->where('sections.exam_id', $this->attempt->exam_id)
            ->orderBy('sections.order_position')
            ->orderBy('subsections.order_position')
            ->orderBy('question_groups.order_position')
            ->select('question_groups.id', 'sections.id as section_id')
            ->get();

        $this->groupIds = $groupData->pluck('id')->toArray();
        foreach ($groupData as $i => $row) {
            $this->sectionMap[$i] = $row->section_id;
        }

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

        // Set initial section
        if (!empty($this->sectionMap)) {
            $this->currentSectionId = $this->sectionMap[0] ?? null;
            $this->showingSectionInstruction = true;
        }
    }

    public function getCurrentGroupProperty()
    {
        if (empty($this->groupIds)) {
            return null;
        }
        return QuestionGroup::with(['questions.options', 'subsection.section'])->find($this->groupIds[$this->currentIndex]);
    }

    public function getCurrentSectionProperty()
    {
        if (!$this->currentSectionId) return null;
        return Section::find($this->currentSectionId);
    }

    public function dismissInstruction()
    {
        $this->showingSectionInstruction = false;
    }

    public function nextGroup()
    {
        if ($this->currentIndex < count($this->groupIds) - 1) {
            $oldSectionId = $this->sectionMap[$this->currentIndex] ?? null;
            $this->currentIndex++;
            $newSectionId = $this->sectionMap[$this->currentIndex] ?? null;

            if ($newSectionId !== $oldSectionId) {
                $this->currentSectionId = $newSectionId;
                $this->showingSectionInstruction = true;
            }
        }
    }

    public function prevGroup()
    {
        if ($this->currentIndex > 0) {
            $oldSectionId = $this->sectionMap[$this->currentIndex] ?? null;
            $this->currentIndex--;
            $newSectionId = $this->sectionMap[$this->currentIndex] ?? null;

            if ($newSectionId !== $oldSectionId) {
                $this->currentSectionId = $newSectionId;
                $this->showingSectionInstruction = true;
            }
        }
    }

    public function goToGroup($groupIndex)
    {
        $oldSectionId = $this->sectionMap[$this->currentIndex] ?? null;
        $this->currentIndex = $groupIndex;
        $newSectionId = $this->sectionMap[$this->currentIndex] ?? null;

        if ($newSectionId !== $oldSectionId) {
            $this->currentSectionId = $newSectionId;
            $this->showingSectionInstruction = true;
        }
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
        return redirect()->route('test_taker.dashboard');
    }
};
?>

{{-- MINIMAL EXAM LAYOUT - No sidebar, no topbar, distraction-free --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $attempt->exam->title }} — IC-EDU Exam</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root { --blue: #2563eb; --text: #0f172a; --muted: #64748b; --border: #e4eaf6; --surface: #ffffff; --base: #f8faff; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', system-ui, sans-serif; background: var(--base); color: var(--text); min-height: 100vh; }

        /* Exam Shell */
        .exam-shell { display: flex; flex-direction: column; min-height: 100vh; }
        .exam-header { height: 56px; background: var(--surface); border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; padding: 0 24px; position: sticky; top: 0; z-index: 50; }
        .exam-body { display: flex; flex: 1; }
        .exam-content { flex: 1; padding: 32px; max-width: 900px; margin: 0 auto; width: 100%; }
        .exam-sidebar { width: 280px; background: var(--surface); border-left: 1px solid var(--border); padding: 24px; position: sticky; top: 56px; height: calc(100vh - 56px); overflow-y: auto; flex-shrink: 0; }

        /* Timer */
        .timer { display: flex; align-items: center; gap: 8px; font-family: 'Inter', monospace; font-size: 1rem; font-weight: 800; color: var(--text); }
        .timer.danger { color: #dc2626; }
        .timer.danger svg { animation: pulse 1s ease-in-out infinite; }
        @keyframes pulse { 0%,100% { opacity: 1; } 50% { opacity: 0.5; } }

        /* Section Instruction Page */
        .instruction-page { display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: calc(100vh - 56px); padding: 40px 24px; text-align: center; }
        .instruction-card { background: var(--surface); border: 1px solid var(--border); border-radius: 24px; padding: 48px 40px; max-width: 600px; width: 100%; }

        /* Question styles */
        .q-number { width: 32px; height: 32px; border-radius: 50%; background: var(--blue); color: white; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 800; flex-shrink: 0; }
        .option-label { display: flex; align-items: flex-start; padding: 14px 16px; border: 2px solid var(--border); border-radius: 14px; cursor: pointer; transition: all .15s; gap: 12px; }
        .option-label:hover { border-color: #93c5fd; background: #f0f7ff; }
        .option-label.selected { border-color: var(--blue); background: #eff6ff; }
        .option-label input[type="radio"] { width: 18px; height: 18px; margin-top: 2px; accent-color: var(--blue); flex-shrink: 0; }

        /* Nav grid */
        .nav-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 6px; }
        .nav-btn { height: 38px; border-radius: 10px; font-size: 0.72rem; font-weight: 800; border: none; cursor: pointer; transition: all .15s; }
        .nav-btn.current { background: var(--blue); color: white; box-shadow: 0 4px 12px rgba(37,99,235,0.3); }
        .nav-btn.answered { background: #16a34a; color: white; }
        .nav-btn.empty { background: #f1f5f9; color: var(--muted); border: 1px solid var(--border); }
        .nav-btn.empty:hover { background: #e2e8f0; }

        /* Subsection header */
        .subsection-header { background: #fefce8; border: 1px solid #fde68a; border-radius: 14px; padding: 16px 20px; margin-bottom: 24px; }

        /* Media box */
        .media-box { background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 14px; padding: 16px; margin-bottom: 20px; }

        /* Mobile */
        @media (max-width: 768px) {
            .exam-sidebar { display: none; }
            .exam-content { padding: 20px 16px; }
            .exam-header { padding: 0 16px; }
            .instruction-card { padding: 32px 24px; }
        }
    </style>
</head>
<body>
<div class="exam-shell">

    {{-- EXAM HEADER BAR --}}
    <header class="exam-header">
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="width: 32px; height: 32px; border-radius: 10px; background: linear-gradient(135deg, var(--blue), #4f46e5); display: flex; align-items: center; justify-content: center;">
                <svg style="width:14px;height:14px;color:white;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.75 19 7.5 19s3.332.477 4.5 1.253"/></svg>
            </div>
            <div>
                <p style="font-size: 0.6rem; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.06em; line-height: 1;">IC-EDU Exam</p>
                <p style="font-size: 0.85rem; font-weight: 800; color: var(--text); line-height: 1.2;">{{ $attempt->exam->title }}</p>
            </div>
        </div>

        {{-- Timer --}}
        <div class="timer" x-data="{
            timeLeft: {{ $remainingSeconds }},
            get formattedTime() {
                const h = Math.floor(this.timeLeft / 3600).toString().padStart(2, '0');
                const m = Math.floor((this.timeLeft % 3600) / 60).toString().padStart(2, '0');
                const s = (this.timeLeft % 60).toString().padStart(2, '0');
                return `${h}:${m}:${s}`;
            },
            get isDanger() { return this.timeLeft < 300 && this.timeLeft > 0; },
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
        }" :class="isDanger ? 'danger' : ''">
            <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span x-text="formattedTime">--:--:--</span>
        </div>
    </header>

    {{-- SECTION INSTRUCTION PAGE --}}
    @if($showingSectionInstruction && $this->currentSection)
    <div class="instruction-page">
        <div class="instruction-card">
            <div style="width: 56px; height: 56px; border-radius: 50%; background: #eff6ff; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                <svg style="width:24px;height:24px;color:var(--blue);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p style="font-size: 0.65rem; font-weight: 800; color: var(--blue); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 8px;">Section {{ collect($this->sectionMap)->search($this->currentSectionId) !== false ? collect($this->sectionMap)->values()->unique()->search($this->currentSectionId) + 1 : '' }}</p>
            <h2 style="font-size: 1.5rem; font-weight: 900; color: var(--text); margin-bottom: 16px;">{{ $this->currentSection->title }}</h2>
            
            @if($this->currentSection->description)
            <div style="font-size: 0.85rem; color: #475569; line-height: 1.8; margin-bottom: 24px; text-align: left; background: var(--base); padding: 20px; border-radius: 14px;">
                {!! $this->currentSection->description !!}
            </div>
            @endif

            {{-- Instruction Media --}}
            @if($this->currentSection->instruction_audio_path)
            <div class="media-box" style="margin-bottom: 16px;">
                <p style="font-size: 0.7rem; font-weight: 700; color: var(--muted); margin-bottom: 8px;">🎧 Audio Instruction</p>
                <audio controls preload="metadata" controlsList="nodownload" style="width: 100%;">
                    <source src="{{ asset('storage/' . str_replace('public/', '', $this->currentSection->instruction_audio_path)) }}">
                </audio>
            </div>
            @endif

            @if($this->currentSection->instruction_image_path)
            <div class="media-box" style="margin-bottom: 16px;">
                <p style="font-size: 0.7rem; font-weight: 700; color: var(--muted); margin-bottom: 8px;">🖼️ Instruction Image</p>
                <img src="{{ asset('storage/' . str_replace('public/', '', $this->currentSection->instruction_image_path)) }}" alt="Section Instruction" style="max-height: 320px; width: auto; margin: 0 auto; display: block; border-radius: 10px;">
            </div>
            @endif

            @if($this->currentSection->duration)
            <p style="font-size: 0.82rem; color: var(--muted); margin-bottom: 24px;">
                ⏱️ Duration: <strong style="color: var(--text);">{{ $this->currentSection->duration }} Minutes</strong>
            </p>
            @endif

            <button wire:click="dismissInstruction"
                    style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px; border-radius: 14px; font-size: 0.88rem; font-weight: 800; background: var(--blue); color: white; border: none; cursor: pointer; box-shadow: 0 4px 16px rgba(37,99,235,0.3); transition: all .2s;">
                Start Section
                <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </button>
        </div>
    </div>

    @else
    {{-- ACTUAL EXAM CONTENT --}}
    <div class="exam-body">
        <div class="exam-content">

            {{-- Loading Overlay --}}
            <div wire:loading.flex wire:target="nextGroup,prevGroup,goToGroup"
                 style="position:fixed;inset:0;z-index:100;background:rgba(255,255,255,0.7);backdrop-filter:blur(2px);display:flex;flex-direction:column;align-items:center;justify-content:center;">
                <svg style="width:40px;height:40px;color:var(--blue);animation:spin 1s linear infinite;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle style="opacity:0.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path style="opacity:0.75;" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p style="margin-top:12px;font-size:0.82rem;font-weight:700;color:var(--blue);">Loading...</p>
            </div>

            @if ($this->currentGroup)
                {{-- Section & Subsection breadcrumb --}}
                <div style="display: flex; align-items: center; gap: 6px; font-size: 0.72rem; font-weight: 700; color: var(--muted); margin-bottom: 20px;">
                    <span>{{ $this->currentGroup->subsection->section->title }}</span>
                    <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span style="color: var(--blue);">{{ $this->currentGroup->subsection->title }}</span>
                </div>

                {{-- Subsection Instructions (shown once at first group of subsection) --}}
                @php
                    $subsection = $this->currentGroup->subsection;
                    $isFirstGroupOfSubsection = true;
                    if ($currentIndex > 0) {
                        $prevGroup = QuestionGroup::with('subsection')->find($groupIds[$currentIndex - 1]);
                        if ($prevGroup && $prevGroup->subsection_id === $subsection->id) {
                            $isFirstGroupOfSubsection = false;
                        }
                    }
                @endphp

                @if($isFirstGroupOfSubsection && $subsection->instructions)
                <div class="subsection-header">
                    <p style="font-size: 0.65rem; font-weight: 800; color: #92400e; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 6px;">📋 Subsection Instructions</p>
                    <div style="font-size: 0.82rem; color: #78350f; line-height: 1.7;">
                        {!! $subsection->instructions !!}
                    </div>
                </div>
                @endif

                {{-- QuestionGroup Media --}}
                @if ($this->currentGroup->audio_path || $this->currentGroup->image_path)
                <div class="media-box">
                    @if ($this->currentGroup->audio_path)
                    <audio controls preload="metadata" controlsList="nodownload" style="width: 100%;">
                        <source src="{{ asset('storage/' . str_replace('public/', '', $this->currentGroup->audio_path)) }}">
                    </audio>
                    @endif
                    @if ($this->currentGroup->image_path)
                    <img src="{{ asset('storage/' . str_replace('public/', '', $this->currentGroup->image_path)) }}" alt="Group Media" style="margin-top:12px;max-height:320px;width:auto;border-radius:10px;display:block;margin-left:auto;margin-right:auto;">
                    @endif
                </div>
                @endif

                {{-- Passage Text --}}
                @if ($this->currentGroup->passage_text)
                <div style="font-size:0.85rem;color:#1e293b;line-height:1.8;background:#fefce8;padding:20px;border-radius:14px;border:1px solid #fde68a;margin-bottom:24px;">
                    {!! $this->currentGroup->passage_text !!}
                </div>
                @endif

                {{-- QUESTIONS --}}
                <div style="display: flex; flex-direction: column; gap: 32px; padding-bottom: 80px;">
                    @foreach ($this->currentGroup->questions as $index => $question)
                    <div>
                        {{-- Question text --}}
                        <div style="display: flex; gap: 12px; margin-bottom: 14px;">
                            <div class="q-number">
                                @php $qNumber = collect($flatQuestions)->firstWhere('id', $question->id)['number'] ?? '?'; @endphp
                                {{ $qNumber }}
                            </div>
                            <div style="font-size: 0.92rem; color: var(--text); line-height: 1.7; padding-top: 4px;">
                                {!! $question->question_text !!}
                            </div>
                        </div>

                        {{-- Question-level media --}}
                        @if ($question->image_path)
                        <div style="margin-left:44px;margin-bottom:14px;">
                            <img src="{{ asset('storage/' . str_replace('public/', '', $question->image_path)) }}" style="max-height:240px;border-radius:12px;border:1px solid var(--border);">
                        </div>
                        @endif
                        @if ($question->audio_path)
                        <div style="margin-left:44px;margin-bottom:14px;max-width:360px;">
                            <audio controls style="width:100%;height:40px;"><source src="{{ asset('storage/' . str_replace('public/', '', $question->audio_path)) }}"></audio>
                        </div>
                        @endif

                        {{-- Answer Input --}}
                        <div style="margin-left: 44px;">
                            @if ($question->type === 'multiple_choice')
                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                @foreach ($question->options as $option)
                                <label wire:key="option-{{ $option->id }}" class="option-label {{ isset($answers[$question->id]) && $answers[$question->id] == $option->id ? 'selected' : '' }}">
                                    <input type="radio" name="question_{{ $question->id }}" wire:model.live="answers.{{ $question->id }}" value="{{ $option->id }}">
                                    <div style="font-size:0.85rem;color:#374151;line-height:1.6;">{!! $option->option_text !!}</div>
                                </label>
                                @endforeach
                            </div>

                            @elseif($question->type === 'short_answer')
                            <input type="text" wire:key="short-answer-{{ $question->id }}" wire:model.live.debounce.1000ms="answers.{{ $question->id }}" placeholder="Type your answer here..." autocomplete="off"
                                   style="width:100%;padding:12px 16px;border:2px solid var(--border);border-radius:14px;font-size:0.85rem;font-family:inherit;outline:none;transition:border-color .2s;background:var(--surface);"
                                   onfocus="this.style.borderColor='var(--blue)'" onblur="this.style.borderColor='var(--border)'">

                            @elseif($question->type === 'essay')
                            <textarea wire:model.live.debounce.1000ms="answers.{{ $question->id }}" rows="5" placeholder="Type your essay here..."
                                      style="width:100%;padding:14px 16px;border:2px solid var(--border);border-radius:14px;font-size:0.85rem;font-family:inherit;outline:none;resize:vertical;transition:border-color .2s;background:var(--surface);"
                                      onfocus="this.style.borderColor='var(--blue)'" onblur="this.style.borderColor='var(--border)'"></textarea>

                            @elseif($question->type === 'record')
                            <div style="border:2px dashed var(--border);border-radius:14px;padding:20px;background:#fafbfc;">
                                @php
                                    $existingAudio = '';
                                    if (isset($answers[$question->id]) && is_string($answers[$question->id])) {
                                        $existingAudio = asset('storage/' . str_replace('public/', '', $answers[$question->id]));
                                    }
                                @endphp

                                <div x-data="{
                                    recording: false, mediaRecorder: null, audioChunks: [], audioUrl: '{{ $existingAudio }}', uploading: false,
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
                                            .catch(e => alert('Microphone access is required.'));
                                    },
                                    stopRecording() { if (this.mediaRecorder) { this.mediaRecorder.stop(); this.recording = false; } },
                                    uploadAudio(blob) {
                                        this.uploading = true;
                                        let file = new File([blob], 'recording_{{ $question->id }}.webm', { type: 'audio/webm' });
                                        $wire.upload('answers.{{ $question->id }}', file, () => { this.uploading = false; }, () => { this.uploading = false; alert('Upload failed.'); });
                                    }
                                }">
                                    <div x-show="audioUrl" style="margin-bottom:14px;background:white;padding:12px;border-radius:10px;border:1px solid var(--border); {{ $existingAudio ? '' : 'display:none;' }}">
                                        <audio :src="audioUrl" controls style="width:100%;height:40px;" controlsList="nodownload"></audio>
                                    </div>
                                    <div style="display:flex;align-items:center;gap:12px;">
                                        <button x-show="!recording" @click="startRecording()" type="button" style="padding:10px 18px;border-radius:12px;font-size:0.82rem;font-weight:700;background:var(--blue);color:white;border:none;cursor:pointer;display:flex;align-items:center;gap:6px;">
                                            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/></svg>
                                            <span x-text="audioUrl ? 'Re-record' : 'Start Recording'"></span>
                                        </button>
                                        <button x-show="recording" @click="stopRecording()" type="button" style="padding:10px 18px;border-radius:12px;font-size:0.82rem;font-weight:700;background:#dc2626;color:white;border:none;cursor:pointer;animation:pulse 1s ease-in-out infinite;display:none;align-items:center;gap:6px;">
                                            <div style="width:12px;height:12px;background:white;border-radius:3px;"></div> Stop
                                        </button>
                                        <span x-show="uploading" style="font-size:0.78rem;font-weight:700;color:var(--blue);display:none;">Uploading...</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Bottom Nav --}}
                <div style="position:fixed;bottom:0;left:0;right:0;background:var(--surface);border-top:1px solid var(--border);padding:12px 24px;display:flex;justify-content:space-between;align-items:center;z-index:40;">
                    <button wire:click="prevGroup" wire:loading.attr="disabled" @disabled($currentIndex === 0)
                            style="padding:10px 20px;border-radius:12px;font-size:0.82rem;font-weight:700;background:var(--surface);color:var(--text);border:1.5px solid var(--border);cursor:pointer;{{ $currentIndex === 0 ? 'opacity:0.3;pointer-events:none;' : '' }}">
                        ← Back
                    </button>
                    <div wire:loading wire:target="answers" style="font-size:0.72rem;font-weight:700;color:var(--blue);">Saving...</div>
                    <button wire:click="nextGroup" wire:loading.attr="disabled" @disabled($currentIndex === count($groupIds) - 1)
                            style="padding:10px 20px;border-radius:12px;font-size:0.82rem;font-weight:800;background:var(--blue);color:white;border:none;cursor:pointer;{{ $currentIndex === count($groupIds) - 1 ? 'opacity:0.3;pointer-events:none;' : '' }}">
                        Next →
                    </button>
                </div>
            @endif
        </div>

        {{-- RIGHT SIDEBAR - Navigation Grid --}}
        <div class="exam-sidebar">
            <p style="font-size:0.65rem;font-weight:800;color:var(--muted);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:16px;">Question Navigator</p>
            <div class="nav-grid" style="max-height:360px;overflow-y:auto;">
                @foreach ($flatQuestions as $fq)
                <button wire:click="goToGroup({{ $fq['group_index'] }})" wire:loading.attr="disabled"
                        class="nav-btn {{ $currentIndex === $fq['group_index'] ? 'current' : (isset($answers[$fq['id']]) && !empty($answers[$fq['id']]) ? 'answered' : 'empty') }}">
                    {{ $fq['number'] }}
                </button>
                @endforeach
            </div>

            <div style="margin-top:20px;padding-top:16px;border-top:1px solid var(--border);">
                <div style="display:flex;align-items:center;gap:6px;font-size:0.7rem;color:var(--muted);margin-bottom:6px;"><div style="width:10px;height:10px;border-radius:4px;background:#16a34a;"></div> Answered</div>
                <div style="display:flex;align-items:center;gap:6px;font-size:0.7rem;color:var(--muted);margin-bottom:6px;"><div style="width:10px;height:10px;border-radius:4px;background:var(--blue);"></div> Current</div>
                <div style="display:flex;align-items:center;gap:6px;font-size:0.7rem;color:var(--muted);margin-bottom:20px;"><div style="width:10px;height:10px;border-radius:4px;background:#f1f5f9;border:1px solid var(--border);"></div> Not Answered</div>
            </div>

            <button wire:click="finishExam" wire:loading.attr="disabled" type="button"
                    onclick="return confirm('Are you sure you want to submit? You cannot change answers after this.') || event.stopImmediatePropagation()"
                    style="width:100%;padding:12px;border-radius:14px;font-size:0.85rem;font-weight:800;background:#16a34a;color:white;border:none;cursor:pointer;box-shadow:0 4px 12px rgba(22,163,74,0.3);transition:all .2s;"
                    onmouseover="this.style.background='#15803d'" onmouseout="this.style.background='#16a34a'">
                ✓ Finish Exam
            </button>
        </div>
    </div>
    @endif

</div>

<script>
    window.addEventListener('beforeunload', function(e) { e.preventDefault(); e.returnValue = ''; });
</script>
<style>@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }</style>
</body>
</html>
