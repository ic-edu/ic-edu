<?php

use App\Models\ExamAttempt;
use App\Models\QuestionGroup;
use App\Models\Question;
use App\Models\AttemptAnswer;
use App\Models\Section;
use App\Enums\ExamAttemptStatus;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

new #[Layout('layouts.bare')] class extends Component {
    use WithFileUploads;

    public ExamAttempt $attempt;
    public array $groupIds = [];
    public int $currentIndex = 0;
    public array $answers = [];

    public int $remainingSeconds = 0;
    public array $flatQuestions = [];

    // Strict mode per-section timer
    public bool $isStrictMode = false;
    public array $sectionDurations = []; // section_id => seconds remaining
    public array $sectionOrder = [];     // ordered list of unique section_ids
    public int $currentSectionRemainingSeconds = 0;

    // Instruction state
    public bool $showingInstruction = true;
    public ?int $currentSectionId = null;
    public ?int $currentSubsectionId = null;
    public array $sectionMap = []; // groupIndex => section_id
    public array $subsectionMap = []; // groupIndex => subsection_id

    public ?int $course_id = null;
    public ?int $lesson_id = null;

    public function mount(ExamAttempt $attempt)
    {
        $this->attempt = $attempt;
        $this->course_id = request()->query('course_id');
        $this->lesson_id = request()->query('lesson_id');

        if ($this->attempt->status === ExamAttemptStatus::FINISHED->value) {
            session()->flash('error', 'Peringatan: Ujian ini sudah selesai dan tidak dapat dikerjakan ulang.');
            if ($this->course_id && $this->lesson_id) {
                $this->redirectRoute('test_taker.course.lesson', ['course' => $this->course_id, 'lesson' => $this->lesson_id]);
            } else {
                $this->redirectRoute('test_taker.dashboard');
            }
            return;
        }

        $this->isStrictMode = ($this->attempt->exam->mode === 'strict');

        // --- Global timer (untuk mode non-strict) ---
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
            ->select('question_groups.id', 'sections.id as section_id', 'subsections.id as subsection_id')
            ->get();

        $this->groupIds = $groupData->pluck('id')->toArray();
        foreach ($groupData as $i => $row) {
            $this->sectionMap[$i] = $row->section_id;
            $this->subsectionMap[$i] = $row->subsection_id;
        }

        // Restore progress from DB using current_question_id
        $savedIndex = 0;
        if ($this->attempt->current_question_id) {
            $q = DB::table('questions')->where('id', $this->attempt->current_question_id)->first();
            if ($q) {
                $idx = array_search($q->question_group_id, $this->groupIds);
                if ($idx !== false) {
                    $savedIndex = $idx;
                }
            }
        }
        $this->currentIndex = min(max(0, $savedIndex), max(0, count($this->groupIds) - 1));

        // --- Per-section timer setup (untuk strict mode) ---
        if ($this->isStrictMode) {
            // Ambil semua section unik, urut
            $uniqueSectionIds = collect($this->sectionMap)->unique()->values()->toArray();
            $this->sectionOrder = $uniqueSectionIds;

            $sections = Section::whereIn('id', $uniqueSectionIds)->get()->keyBy('id');
            $sectionCount = max(1, count($uniqueSectionIds));

            // Fallback: bagi total_duration rata ke tiap section jika section.duration null
            $fallbackSeconds = (int) round($durationInSeconds / $sectionCount);

            foreach ($uniqueSectionIds as $sId) {
                $sec = $sections->get($sId);
                $this->sectionDurations[$sId] = $sec && $sec->duration
                    ? ($sec->duration * 60)
                    : $fallbackSeconds;
            }

            // Sisa waktu section saat ini = durasi section - (waktu refresh - waktu mulai section)
            $sectionStartedAt = session()->get('exam_section_started_at_' . $this->attempt->id, $this->attempt->started_at);
            $sectionElapsedSeconds = Carbon::parse($sectionStartedAt)->diffInSeconds(now());
            
            $currentSectionId = $this->sectionMap[$this->currentIndex] ?? ($uniqueSectionIds[0] ?? null);
            if ($currentSectionId) {
                $this->currentSectionRemainingSeconds = max(0, $this->sectionDurations[$currentSectionId] - $sectionElapsedSeconds);
            }
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
            $this->currentSectionId = $this->sectionMap[$this->currentIndex] ?? null;
            $this->currentSubsectionId = $this->subsectionMap[$this->currentIndex] ?? null;
            // Only show instruction if starting from the beginning of a section
            $this->showingInstruction = true; 
        }
    }

    private function persistCurrentIndex()
    {
        $currentGroupId = $this->groupIds[$this->currentIndex] ?? null;
        if ($currentGroupId) {
            $firstQuestion = DB::table('questions')
                ->where('question_group_id', $currentGroupId)
                ->orderBy('order_position')
                ->first();
                
            if ($firstQuestion) {
                $this->attempt->update(['current_question_id' => $firstQuestion->id]);
            }
        }
    }

    /**
     * Dipanggil dari Alpine.js saat timer section habis (strict mode).
     * Lanjut ke section berikutnya, atau submit jika sudah section terakhir.
     */
    public function advanceToNextSection()
    {
        // Cari group index pertama dari section BERIKUTNYA
        $currentSectionIdx = array_search($this->currentSectionId, $this->sectionOrder);
        $nextSectionIdx    = $currentSectionIdx + 1;

        if ($nextSectionIdx >= count($this->sectionOrder)) {
            // Sudah section terakhir → submit
            $this->finishExam();
            return;
        }

        $nextSectionId = $this->sectionOrder[$nextSectionIdx];

        // Cari group index pertama yang termasuk nextSectionId
        $nextGroupIndex = null;
        foreach ($this->sectionMap as $gIdx => $sId) {
            if ($sId === $nextSectionId) {
                $nextGroupIndex = $gIdx;
                break;
            }
        }

        if ($nextGroupIndex === null) {
            $this->finishExam();
            return;
        }

        // Pindah ke section berikutnya
        $this->currentIndex            = $nextGroupIndex;
        $this->currentSectionId        = $nextSectionId;
        $this->currentSubsectionId     = $this->subsectionMap[$nextGroupIndex] ?? null;
        $this->showingInstruction      = true;
        $this->currentSectionRemainingSeconds = $this->sectionDurations[$nextSectionId] ?? 0;

        $this->persistCurrentIndex();
        session()->put('exam_section_started_at_' . $this->attempt->id, now());

        $this->dispatch('section-timer-reset', seconds: $this->currentSectionRemainingSeconds);
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
        $this->showingInstruction = false;
    }

    public function nextGroup()
    {
        if ($this->currentIndex < count($this->groupIds) - 1) {
            $oldSubsectionId = $this->subsectionMap[$this->currentIndex] ?? null;
            $this->currentIndex++;
            $newSectionId = $this->sectionMap[$this->currentIndex] ?? null;
            $newSubsectionId = $this->subsectionMap[$this->currentIndex] ?? null;

            if ($newSubsectionId !== $oldSubsectionId) {
                $this->currentSectionId = $newSectionId;
                $this->currentSubsectionId = $newSubsectionId;
                $this->showingInstruction = true;
            }
            $this->persistCurrentIndex();
        }
    }

    public function prevGroup()
    {
        if ($this->currentIndex > 0) {
            $oldSubsectionId = $this->subsectionMap[$this->currentIndex] ?? null;
            $this->currentIndex--;
            $newSectionId = $this->sectionMap[$this->currentIndex] ?? null;
            $newSubsectionId = $this->subsectionMap[$this->currentIndex] ?? null;

            if ($newSubsectionId !== $oldSubsectionId) {
                $this->currentSectionId = $newSectionId;
                $this->currentSubsectionId = $newSubsectionId;
                $this->showingInstruction = true;
            }
            $this->persistCurrentIndex();
        }
    }

    public function goToGroup($groupIndex)
    {
        $oldSubsectionId = $this->subsectionMap[$this->currentIndex] ?? null;
        $this->currentIndex = $groupIndex;
        $newSectionId = $this->sectionMap[$this->currentIndex] ?? null;
        $newSubsectionId = $this->subsectionMap[$this->currentIndex] ?? null;

        if ($newSubsectionId !== $oldSubsectionId) {
            $this->currentSectionId = $newSectionId;
            $this->currentSubsectionId = $newSubsectionId;
            $this->showingInstruction = true;
        }
        $this->persistCurrentIndex();
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
        $allAnswers = AttemptAnswer::with([
            'question.options',
            'question.questionGroup.subsection.section',
        ])->where('exam_attempt_id', $this->attempt->id)->get();

        foreach ($allAnswers as $ans) {
            $question = $ans->question;
            if (!$question) continue;

            $jenisSoal = strtolower(trim(str_replace(' ', '_', $question->type)));

            if ($jenisSoal === 'multiple_choice') {
                $selectedOption = $question->options->where('id', $ans->selected_option_id)->first();
                $points = ($selectedOption && $selectedOption->is_correct) ? ($question->points ?? 1) : 0;
                $ans->update(['score' => $points]);
            }
        }

        $allAnswers = $allAnswers->fresh();

        $rawScore      = (int) $allAnswers->sum('score');
        $totalQuestions = count($this->flatQuestions); // Total aktual soal
        $sectionRaws   = [];
        $sectionTotals = [];

        foreach ($allAnswers as $ans) {
            $sectionName = $ans->question->questionGroup->subsection->section->title ?? 'Unknown';
            $sectionRaws[$sectionName]   = ($sectionRaws[$sectionName]   ?? 0) + ($ans->score ?? 0);
            $sectionTotals[$sectionName] = ($sectionTotals[$sectionName] ?? 0) + ($ans->question->points ?? 1);
        }

        $examType = $this->attempt->exam->examType;
        $result   = $examType->calculateScore(
            rawScore: $rawScore,
            totalQuestions: $totalQuestions,
            sectionRaws: $sectionRaws,
            sectionTotals: $sectionTotals,
        );

        $hasSubjective = false;
        $examQuestionTypes = Question::whereIn('id', array_column($this->flatQuestions, 'id'))->pluck('type');
        foreach ($examQuestionTypes as $type) {
            $jenisSoal = strtolower(trim(str_replace(' ', '_', $type)));
            if ($jenisSoal !== 'multiple_choice') {
                $hasSubjective = true;
                break;
            }
        }

        $finalStatus = $hasSubjective ? ExamAttemptStatus::FINISHED->value : ExamAttemptStatus::GRADED->value;

        $this->attempt->update([
            'status'          => $finalStatus,
            'submitted_at'    => now(),
            'raw_score'       => $rawScore,
            'converted_score' => $result['converted_score'],
            'section_scores'  => $result['section_scores'],
            'is_passed'       => $result['is_passed'],
        ]);

        if (!$hasSubjective) {
            if (!$this->course_id) {
                try {
                    \Illuminate\Support\Facades\Mail::to($this->attempt->user->email)->send(new \App\Mail\ExamGradedMail($this->attempt));
                } catch (\Exception $e) {
                    // Ignore email error to not break submission
                }
            }
            session()->flash('success', 'Quiz/Exam completed! Since it was 100% Multiple Choice, it has been auto-graded.');
        } else {
            session()->flash('success', 'Quiz/Exam successfully submitted! Multiple choice questions are auto-graded, subjective questions are pending review.');
        }

        if ($this->course_id && $this->lesson_id) {
            return redirect()->route('test_taker.course.lesson', ['course' => $this->course_id, 'lesson' => $this->lesson_id]);
        }

        return redirect()->route('test_taker.dashboard');
    }
};
?>

<div class="exam-container">
    <style>
        :root { --blue: #2563eb; --text: #0f172a; --muted: #64748b; --border: #e4eaf6; --surface: #ffffff; --base: #f8faff; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', system-ui, sans-serif; background: var(--base); color: var(--text); min-height: 100vh; }

        /* Exam Shell */
        .exam-shell { display: flex; flex-direction: column; min-height: 100vh; }
        .exam-header { height: 56px; background: var(--surface); border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; padding: 0 24px; position: sticky; top: 0; z-index: 50; }
        .exam-body { display: flex; flex: 1; }
        .exam-content { flex: 1; padding: 32px 32px 100px 32px; max-width: 900px; margin: 0 auto; width: 100%; transition: max-width 0.3s ease; }
        .exam-content.is-split { max-width: 1400px; }
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

        /* Passage rich-text formatting */
        .passage-content { font-size: 0.87rem; color: #1e293b; line-height: 1.9; }
        .passage-content p { margin-bottom: 1em; }
        .passage-content p:last-child { margin-bottom: 0; }
        .passage-content strong, .passage-content b { font-weight: 700; color: #0f172a; }
        .passage-content em, .passage-content i { font-style: italic; }
        .passage-content u { text-decoration: underline; }
        .passage-content ul { list-style: disc; padding-left: 1.4em; margin-bottom: 1em; }
        .passage-content ol { list-style: decimal; padding-left: 1.4em; margin-bottom: 1em; }
        .passage-content li { margin-bottom: 0.3em; }

        /* Image lightbox pan & zoom (inline) */
        .zoom-container { overflow: hidden; position: relative; background: #f8fafc; display: flex; align-items: center; justify-content: center; }
        .zoom-container img { cursor: grab; transform-origin: center; transition: transform 0.05s linear; user-select: none; }
        .zoom-container img:active { cursor: grabbing; }
        .zoom-container.is-fullscreen { position: fixed; inset: 0; z-index: 99999; background: rgba(0,0,0,0.95); border-radius: 0 !important; margin: 0 !important; }
        .zoom-container.is-fullscreen img { max-height: 90vh !important; max-width: 90vw !important; object-fit: contain; }
        .fullscreen-btn { position: absolute; top: 16px; right: 16px; z-index: 100000; background: rgba(255,255,255,0.95); border: 1px solid #cbd5e1; padding: 8px; border-radius: 8px; cursor: pointer; color: var(--text); box-shadow: 0 4px 12px rgba(0,0,0,0.2); transition: all 0.2s; }
        .fullscreen-btn:hover { background: white; transform: scale(1.05); }
        
        body.is-fullscreen-mode .exam-header,
        body.is-fullscreen-mode .exam-footer { opacity: 0 !important; visibility: hidden !important; pointer-events: none !important; }

        /* Mobile */
        @media (max-width: 768px) {
            .exam-sidebar { display: none; }
            .exam-content { padding: 20px 16px; }
            .exam-header { padding: 0 16px; }
            .instruction-card { padding: 32px 24px; }
            
            /* Responsive split screen */
            .split-grid { grid-template-columns: 1fr !important; }
            .split-left-panel { border-right: none !important; border-bottom: 2px solid var(--border); max-height: 40vh !important; position: static !important; }
        }
    </style>

    {{-- INTERFACE START --}}
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

        {{-- Time-up overlay (non-blocking) --}}
        <div id="timeup-overlay" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.7);backdrop-filter:blur(4px);align-items:center;justify-content:center;">
            <div style="background:white;border-radius:24px;padding:48px 40px;text-align:center;max-width:400px;width:90%;box-shadow:0 25px 60px rgba(0,0,0,0.3);">
                <div style="width:64px;height:64px;background:#fef2f2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
                    <svg style="width:32px;height:32px;color:#dc2626;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h2 style="font-size:1.4rem;font-weight:900;color:#0f172a;margin-bottom:8px;">Waktu Habis!</h2>
                <p style="font-size:0.875rem;color:#64748b;margin-bottom:24px;">Ujian Anda sedang dikumpulkan secara otomatis...</p>
                <div style="display:flex;align-items:center;justify-content:center;gap:10px;">
                    <div style="width:10px;height:10px;border-radius:50%;background:#2563eb;animation:timeup-dot 1.2s ease-in-out infinite;"></div>
                    <div style="width:10px;height:10px;border-radius:50%;background:#2563eb;animation:timeup-dot 1.2s ease-in-out 0.4s infinite;"></div>
                    <div style="width:10px;height:10px;border-radius:50%;background:#2563eb;animation:timeup-dot 1.2s ease-in-out 0.8s infinite;"></div>
                </div>
            </div>
        </div>

        {{-- Section time-up toast (strict mode) --}}
        <div id="section-timeup-toast" style="display:none;position:fixed;top:72px;left:50%;transform:translateX(-50%);z-index:9990;background:#f97316;color:white;border-radius:14px;padding:14px 28px;font-size:0.88rem;font-weight:800;box-shadow:0 8px 24px rgba(249,115,22,0.4);">
            ⏰ Waktu section habis! Pindah ke section berikutnya...
        </div>

        <style>@keyframes timeup-dot { 0%,100%{opacity:0.3;transform:scale(0.8)} 50%{opacity:1;transform:scale(1.2)} }</style>

        @if($isStrictMode)
        {{-- STRICT MODE: Per-section timer --}}
        <div class="timer" x-data="{
            timeLeft: {{ $currentSectionRemainingSeconds }},
            get formattedTime() {
                const m = Math.floor(this.timeLeft / 60).toString().padStart(2, '0');
                const s = (this.timeLeft % 60).toString().padStart(2, '0');
                return `${m}:${s}`;
            },
            get isDanger() { return this.timeLeft <= 60 && this.timeLeft > 0; },
            startTimer() {
                clearInterval(this._timer);
                this._timer = setInterval(() => {
                    if (this.timeLeft > 0) {
                        this.timeLeft--;
                    } else {
                        clearInterval(this._timer);
                        if (this.timeLeft > -1) {
                            this.timeLeft = -1;
                            const toast = document.getElementById('section-timeup-toast');
                            if (toast) { toast.style.display = 'block'; setTimeout(() => toast.style.display = 'none', 3000); }
                            $wire.advanceToNextSection();
                        }
                    }
                }, 1000);
            },
            init() {
                this.startTimer();
                $wire.on('section-timer-reset', ({ seconds }) => {
                    this.timeLeft = seconds;
                    this.startTimer();
                });
            }
        }" :class="isDanger ? 'danger' : ''">
            <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div style="display:flex;flex-direction:column;line-height:1.2;">
                <span style="font-size:0.55rem;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:0.06em;">Section Timer</span>
                <span x-text="formattedTime">--:--</span>
            </div>
        </div>
        @else
        {{-- NON-STRICT MODE: Global timer --}}
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
                            this.timeLeft = -1;
                            const overlay = document.getElementById('timeup-overlay');
                            if (overlay) overlay.style.display = 'flex';
                            $wire.finishExam();
                        }
                    }
                }, 1000);
            }
        }" :class="isDanger ? 'danger' : ''">
            <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span x-text="formattedTime">--:--:--</span>
        </div>
        @endif
    </header>

    {{-- UNIFIED INSTRUCTION PAGE --}}
    @if($showingInstruction && $this->currentGroup)
    <div class="instruction-page">
        <div class="instruction-card">
            @php
                $subsection = $this->currentGroup->subsection;
                $section = $subsection->section;
                // Hanya tampilkan deskripsi section jika ini adalah subsection pertama agar tidak berulang
                $isFirstSubsection = ($subsection->order_position == 1);
            @endphp
            <div style="width: 56px; height: 56px; border-radius: 50%; background: #eff6ff; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                <svg style="width:24px;height:24px;color:var(--blue);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p style="font-size: 0.65rem; font-weight: 800; color: var(--blue); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 8px;">Section: {{ $section->title }}</p>
            <h2 style="font-size: 1.5rem; font-weight: 900; color: var(--text); margin-bottom: 16px;">{{ $subsection->title }}</h2>
            
            @if($isFirstSubsection && $section->description)
            <div style="font-size: 0.85rem; color: #475569; line-height: 1.8; margin-bottom: 16px; text-align: left; background: var(--base); padding: 20px; border-radius: 14px; border-left: 4px solid var(--blue);">
                <strong style="display:block;margin-bottom:8px;color:var(--text);font-size:0.75rem;text-transform:uppercase;">ℹ️ Informasi Section</strong>
                {!! $section->description !!}
            </div>
            @endif

            @if($subsection->instructions)
            <div style="font-size: 0.85rem; color: #78350f; line-height: 1.8; margin-bottom: 24px; text-align: left; background: #fffbeb; padding: 20px; border-radius: 14px; border-left: 4px solid #f59e0b;">
                <strong style="display:block;margin-bottom:8px;color:#b45309;font-size:0.75rem;text-transform:uppercase;">📋 Instruksi Soal (Subsection)</strong>
                {!! $subsection->instructions !!}
            </div>
            @endif

            {{-- Instruction Media (Subsection Level) --}}
            @if($subsection->instruction_audio_path)
            <div class="media-box" style="margin-bottom: 16px;">
                <p style="font-size: 0.7rem; font-weight: 700; color: var(--muted); margin-bottom: 8px;">🎧 Audio Instruction (Subsection)</p>
                <audio controls preload="metadata" controlsList="nodownload" style="width: 100%;">
                    <source src="{{ asset('storage/' . str_replace('public/', '', $subsection->instruction_audio_path)) }}">
                </audio>
            </div>
            @endif

            @if($subsection->instruction_image_path)
            <div class="media-box" style="margin-bottom: 16px;">
                <p style="font-size: 0.7rem; font-weight: 700; color: var(--muted); margin-bottom: 8px;">🖼️ Instruction Image (Subsection)</p>
                <img src="{{ asset('storage/' . str_replace('public/', '', $subsection->instruction_image_path)) }}" alt="Subsection Instruction" style="max-height: 320px; width: auto; margin: 0 auto; display: block; border-radius: 10px;">
            </div>
            @endif

            @if($isFirstSubsection && $section->duration)
            <p style="font-size: 0.82rem; color: var(--muted); margin-bottom: 24px;">
                ⏱️ Duration: <strong style="color: var(--text);">{{ $section->duration }} Minutes</strong>
            </p>
            @endif

            <button wire:click="dismissInstruction"
                    style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px; border-radius: 14px; font-size: 0.88rem; font-weight: 800; background: var(--blue); color: white; border: none; cursor: pointer; box-shadow: 0 4px 16px rgba(37,99,235,0.3); transition: all .2s;">
                Mulai Kerjakan
                <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </button>
        </div>
    </div>

    @else
    {{-- ACTUAL EXAM CONTENT --}}
    @php $globalGroupType = $this->currentGroup->group_type ?? 'default'; @endphp
    <div class="exam-body">
        <div class="exam-content {{ $globalGroupType === 'split' ? 'is-split' : '' }}">

            {{-- Loading Overlay --}}
            <div wire:loading.flex wire:target="nextGroup,prevGroup,goToGroup"
                 style="position:fixed;inset:0;z-index:100;background:rgba(255,255,255,0.7);backdrop-filter:blur(2px);flex-direction:column;align-items:center;justify-content:center;">
                <svg style="width:40px;height:40px;color:var(--blue);animation:spin 1s linear infinite;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle style="opacity:0.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path style="opacity:0.75;" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p style="margin-top:12px;font-size:0.82rem;font-weight:700;color:var(--blue);">Loading...</p>
            </div>

            @if ($this->currentGroup)
                @php $groupType = $this->currentGroup->group_type ?? 'default'; @endphp


                {{-- ══════════════════════════════════════════════════════
                     SPLIT LAYOUT: passage left | questions right
                     ══════════════════════════════════════════════════════ --}}
                @if($groupType === 'split')
                <div class="split-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:0;min-height:calc(100vh - 160px);border:1px solid var(--border);border-radius:16px;overflow:hidden;">

                    {{-- LEFT PANEL: passage / image --}}
                    <div class="split-left-panel" style="border-right:1px solid var(--border);overflow-y:auto;max-height:calc(100vh - 160px);position:sticky;top:76px;">
                        <div style="padding:24px;padding-bottom:100px;">
                            @if($this->currentGroup->title)
                            <p style="font-size:0.65rem;font-weight:800;color:var(--blue);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:12px;">{{ $this->currentGroup->title }}</p>
                            @endif
                            @if($this->currentGroup->instruction)
                            <div style="font-size:0.78rem;color:var(--muted);margin-bottom:16px;padding:10px 14px;background:var(--base);border-radius:10px;border-left:3px solid var(--blue);">
                                {!! $this->currentGroup->instruction !!}
                            </div>
                            @endif
                            @if($this->currentGroup->image_path)
                            <div style="margin-bottom:16px;border-radius:10px;" class="zoom-container" :class="{ 'is-fullscreen': isFullscreen }"
                                 x-data="panzoomImage()" @wheel.prevent="handleWheel" 
                                 @mousedown="startDrag" @mousemove="doDrag" @mouseup="endDrag" @mouseleave="endDrag"
                                 @touchstart="startDrag" @touchmove.prevent="doDrag" @touchend="endDrag">
                                
                                <button type="button" class="fullscreen-btn" @click.prevent.stop="toggleFullscreen" title="Toggle Fullscreen">
                                    <svg x-show="!isFullscreen" style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                                    <svg x-show="isFullscreen" x-cloak style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 14h4v4M4 14l5 5m11-5h-4v4m4-4l-5 5M4 10h4V6M4 10l5-5m11 5h-4V6m4 4l-5-5"/></svg>
                                </button>

                                <img src="{{ asset('storage/' . str_replace('public/', '', $this->currentGroup->image_path)) }}" alt="Passage Image"
                                     style="width:100%;border-radius:10px;"
                                     :style="`transform: translate(${panX}px, ${panY}px) scale(${scale});`" 
                                     draggable="false">
                            </div>
                            @endif
                            @if($this->currentGroup->audio_path)
                            <div style="margin-bottom:16px;">
                                @if($attempt->exam->mode === 'strict')
                                <div x-data="{played:false,playing:false,audioObj:null,togglePlay(){if(this.played)return;if(!this.audioObj){this.audioObj=new Audio('{{ asset('storage/'.str_replace('public/','',$this->currentGroup->audio_path)) }}');this.audioObj.onended=()=>{this.playing=false;this.played=true};}if(!this.playing){this.audioObj.play();this.playing=true;}}}">
                                    <button type="button" @click="togglePlay" :disabled="played||playing" :style="(played||playing)?'opacity:0.6;cursor:not-allowed;background:#94a3b8;':'background:var(--blue);'" style="display:inline-flex;align-items:center;gap:8px;padding:10px 18px;border-radius:10px;color:white;font-weight:700;border:none;cursor:pointer;font-size:0.8rem;">
                                        <svg x-show="!playing&&!played" style="width:16px;height:16px;" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6V4z"/></svg>
                                        <svg x-show="playing" style="width:16px;height:16px;animation:pulse 1s infinite;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M18.364 5.636a9 9 0 010 12.728"/></svg>
                                        <svg x-show="played" style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        <span x-text="played?'Done':(playing?'Playing...':'▶ Play Audio (1x only)')"></span>
                                    </button>
                                </div>
                                @else
                                <audio controls preload="metadata" controlsList="nodownload" style="width:100%;"><source src="{{ asset('storage/'.str_replace('public/','',$this->currentGroup->audio_path)) }}"></audio>
                                @endif
                            </div>
                            @endif
                            @if($this->currentGroup->passage_text)
                            <div class="passage-content">
                                {!! $this->currentGroup->passage_text !!}
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- RIGHT PANEL: questions --}}
                    <div style="overflow-y:auto;max-height:calc(100vh - 160px);background:var(--base);">
                        <div style="padding:24px;display:flex;flex-direction:column;gap:28px;padding-bottom:100px;">
                            @foreach($this->currentGroup->questions as $question)
                            <div wire:key="q-wrap-{{ $question->id }}" style="background:var(--surface);border:1px solid var(--border);border-radius:14px;padding:20px;">
                                <div style="display:flex;gap:10px;margin-bottom:14px;">
                                    <div class="q-number">@php echo collect($flatQuestions)->firstWhere('id',$question->id)['number'] ?? '?'; @endphp</div>
                                    <div style="font-size:0.9rem;color:var(--text);line-height:1.7;padding-top:3px;">{!! $question->question_text !!}</div>
                                </div>
                                <div style="margin-left:44px;">
                                    @if($question->type === 'multiple_choice')
                                    <div style="display:flex;flex-direction:column;gap:10px;">
                                        @foreach($question->options as $option)
                                        <label wire:key="option-{{ $option->id }}" class="option-label {{ isset($answers[$question->id]) && $answers[$question->id] == $option->id ? 'selected' : '' }}">
                                            <input type="radio" name="question_{{ $question->id }}" wire:model.live="answers.{{ $question->id }}" value="{{ $option->id }}">
                                            <div style="font-size:0.85rem;color:#374151;line-height:1.6;">{!! $option->option_text !!}</div>
                                        </label>
                                        @endforeach
                                    </div>
                                    @elseif($question->type === 'short_answer')
                                    <input type="text" wire:model.live.debounce.1000ms="answers.{{ $question->id }}" placeholder="Type your answer here..." autocomplete="off"
                                           style="width:100%;padding:12px 16px;border:2px solid var(--border);border-radius:14px;font-size:0.85rem;font-family:inherit;outline:none;transition:border-color .2s;background:var(--surface);"
                                           onfocus="this.style.borderColor='var(--blue)'" onblur="this.style.borderColor='var(--border)'">
                                    @elseif($question->type === 'essay')
                                    <textarea wire:model.live.debounce.1000ms="answers.{{ $question->id }}" rows="4" placeholder="Type your answer here..."
                                              style="width:100%;padding:12px 16px;border:2px solid var(--border);border-radius:14px;font-size:0.85rem;font-family:inherit;outline:none;resize:vertical;transition:border-color .2s;background:var(--surface);"
                                              onfocus="this.style.borderColor='var(--blue)'" onblur="this.style.borderColor='var(--border)'"></textarea>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════════════════
                     DEFAULT LAYOUT: everything stacked vertically
                     ══════════════════════════════════════════════════════ --}}
                @else
                {{-- Group Media --}}
                @if($this->currentGroup->audio_path || $this->currentGroup->image_path)
                <div class="media-box">
                    @if($this->currentGroup->audio_path)
                        @if($attempt->exam->mode === 'strict')
                        <div x-data="{played:false,playing:false,audioObj:null,togglePlay(){if(this.played)return;if(!this.audioObj){this.audioObj=new Audio('{{ asset('storage/'.str_replace('public/','',$this->currentGroup->audio_path)) }}');this.audioObj.onended=()=>{this.playing=false;this.played=true};}if(!this.playing){this.audioObj.play();this.playing=true;}}}" style="margin-bottom:16px;">
                            <button type="button" @click="togglePlay" :disabled="played||playing" :style="(played||playing)?'opacity:0.6;cursor:not-allowed;background:#94a3b8;':'background:var(--blue);'" style="display:inline-flex;align-items:center;gap:8px;padding:12px 24px;border-radius:12px;color:white;font-weight:700;border:none;cursor:pointer;transition:all .2s;box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                                <svg x-show="!playing&&!played" style="width:20px;height:20px;" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6V4z"/></svg>
                                <svg x-show="playing" style="width:20px;height:20px;animation:pulse 1s infinite;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M18.364 5.636a9 9 0 010 12.728M8 12L5 9m0 0l-3 3m3-3v6M5 9v3"/></svg>
                                <svg x-show="played" style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span x-text="played?'Audio Selesai Diputar':(playing?'Playing Audio...':'▶ Putar Audio (Hanya 1x)')"></span>
                            </button>
                        </div>
                        @else
                        <audio controls preload="metadata" controlsList="nodownload" style="width:100%;"><source src="{{ asset('storage/'.str_replace('public/','',$this->currentGroup->audio_path)) }}"></audio>
                        @endif
                    @endif
                    @if($this->currentGroup->image_path)
                    <div style="margin-top:12px;margin-bottom:12px;border-radius:10px;" class="zoom-container" :class="{ 'is-fullscreen': isFullscreen }"
                         x-data="panzoomImage()" @wheel.prevent="handleWheel"
                         @mousedown="startDrag" @mousemove="doDrag" @mouseup="endDrag" @mouseleave="endDrag"
                         @touchstart="startDrag" @touchmove.prevent="doDrag" @touchend="endDrag">
                        
                        <button type="button" class="fullscreen-btn" @click.prevent.stop="toggleFullscreen" title="Toggle Fullscreen">
                            <svg x-show="!isFullscreen" style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                            <svg x-show="isFullscreen" x-cloak style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 14h4v4M4 14l5 5m11-5h-4v4m4-4l-5 5M4 10h4V6M4 10l5-5m11 5h-4V6m4 4l-5-5"/></svg>
                        </button>

                        <img src="{{ asset('storage/'.str_replace('public/','',$this->currentGroup->image_path)) }}" alt="Group Media"
                             style="max-height:320px;width:auto;border-radius:10px;display:block;margin-left:auto;margin-right:auto;"
                             :style="`transform: translate(${panX}px, ${panY}px) scale(${scale});`" 
                             draggable="false">
                    </div>
                    @endif
                </div>
                @endif

                {{-- Passage Text --}}
                @if($this->currentGroup->passage_text)
                <div style="background:#fefce8;padding:20px;border-radius:14px;border:1px solid #fde68a;margin-bottom:24px;">
                    <div class="passage-content">{!! $this->currentGroup->passage_text !!}</div>
                </div>
                @endif

                {{-- QUESTIONS --}}
                <div style="display:flex;flex-direction:column;gap:32px;padding-bottom:80px;">
                    @foreach($this->currentGroup->questions as $index => $question)
                    <div wire:key="q-wrap-{{ $question->id }}">
                        <div style="display:flex;gap:12px;margin-bottom:14px;">
                            <div class="q-number">
                                @php $qNumber = collect($flatQuestions)->firstWhere('id', $question->id)['number'] ?? '?'; @endphp
                                {{ $qNumber }}
                            </div>
                            <div style="font-size:0.92rem;color:var(--text);line-height:1.7;padding-top:4px;">
                                {!! $question->question_text !!}
                            </div>
                        </div>
                        @if($question->image_path)
                        <div style="margin-left:44px;margin-bottom:14px;border-radius:12px;border:1px solid var(--border);" class="zoom-container" :class="{ 'is-fullscreen': isFullscreen }"
                             x-data="panzoomImage()" @wheel.prevent="handleWheel"
                             @mousedown="startDrag" @mousemove="doDrag" @mouseup="endDrag" @mouseleave="endDrag"
                             @touchstart="startDrag" @touchmove.prevent="doDrag" @touchend="endDrag">
                            
                            <button type="button" class="fullscreen-btn" @click.prevent.stop="toggleFullscreen" title="Toggle Fullscreen">
                                <svg x-show="!isFullscreen" style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                                <svg x-show="isFullscreen" x-cloak style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 14h4v4M4 14l5 5m11-5h-4v4m4-4l-5 5M4 10h4V6M4 10l5-5m11 5h-4V6m4 4l-5-5"/></svg>
                            </button>

                            <img src="{{ asset('storage/'.str_replace('public/','',$question->image_path)) }}"
                                 style="max-height:240px;border-radius:12px;display:block;"
                                 :style="`transform: translate(${panX}px, ${panY}px) scale(${scale});`" 
                                 draggable="false">
                        </div>
                        @endif
                        @if($question->audio_path)
                        <div style="margin-left:44px;margin-bottom:14px;max-width:360px;">
                            @if($attempt->exam->mode === 'strict')
                            <div x-data="{played:false,playing:false,audioObj:null,togglePlay(){if(this.played)return;if(!this.audioObj){this.audioObj=new Audio('{{ asset('storage/'.str_replace('public/','',$question->audio_path)) }}');this.audioObj.onended=()=>{this.playing=false;this.played=true};}if(!this.playing){this.audioObj.play();this.playing=true;}}}">
                                <button type="button" @click="togglePlay" :disabled="played||playing" :style="(played||playing)?'opacity:0.6;cursor:not-allowed;background:#94a3b8;':'background:var(--blue);'" style="display:flex;align-items:center;gap:8px;padding:10px 18px;border-radius:10px;color:white;font-weight:700;border:none;cursor:pointer;transition:all .2s;font-size:0.8rem;">
                                    <svg x-show="!playing&&!played" style="width:16px;height:16px;" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6V4z"/></svg>
                                    <svg x-show="playing" style="width:16px;height:16px;animation:pulse 1s infinite;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M18.364 5.636a9 9 0 010 12.728M8 12L5 9m0 0l-3 3m3-3v6M5 9v3"/></svg>
                                    <svg x-show="played" style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span x-text="played?'Audio Selesai Diputar':(playing?'Playing Audio...':'▶ Putar Audio (Hanya 1x)')"></span>
                                </button>
                            </div>
                            @else
                            <audio controls style="width:100%;height:40px;"><source src="{{ asset('storage/'.str_replace('public/','',$question->audio_path)) }}"></audio>
                            @endif
                        </div>
                        @endif
                        <div style="margin-left:44px;">
                            @if($question->type === 'multiple_choice')
                            <div style="display:flex;flex-direction:column;gap:10px;">
                                @foreach($question->options as $option)
                                <label wire:key="option-{{ $option->id }}" class="option-label {{ isset($answers[$question->id]) && $answers[$question->id] == $option->id ? 'selected' : '' }}">
                                    <input type="radio" name="question_{{ $question->id }}" wire:model.live="answers.{{ $question->id }}" value="{{ $option->id }}">
                                    <div style="font-size:0.85rem;color:#374151;line-height:1.6;">{!! $option->option_text !!}</div>
                                </label>
                                @endforeach
                            </div>
                            @elseif($question->type === 'short_answer')
                            <input type="text" wire:model.live.debounce.1000ms="answers.{{ $question->id }}" placeholder="Type your answer here..." autocomplete="off"
                                   style="width:100%;padding:12px 16px;border:2px solid var(--border);border-radius:14px;font-size:0.85rem;font-family:inherit;outline:none;transition:border-color .2s;background:var(--surface);"
                                   onfocus="this.style.borderColor='var(--blue)'" onblur="this.style.borderColor='var(--border)'">
                            @elseif($question->type === 'essay')
                            <textarea wire:model.live.debounce.1000ms="answers.{{ $question->id }}" rows="5" placeholder="Type your essay here..."
                                      style="width:100%;padding:14px 16px;border:2px solid var(--border);border-radius:14px;font-size:0.85rem;font-family:inherit;outline:none;resize:vertical;transition:border-color .2s;background:var(--surface);"
                                      onfocus="this.style.borderColor='var(--blue)'" onblur="this.style.borderColor='var(--border)'"></textarea>
                            @elseif($question->type === 'record' || $question->type === 'audio_record')
                            <div style="border:2px dashed var(--border);border-radius:14px;padding:20px;background:#fafbfc;">
                                @php $existingAudio = isset($answers[$question->id]) && is_string($answers[$question->id]) ? asset('storage/'.str_replace('public/','',$answers[$question->id])) : ''; @endphp
                                <div x-data="{recording:false,mediaRecorder:null,audioChunks:[],audioUrl:'{{ $existingAudio }}',uploading:false,startRecording(){navigator.mediaDevices.getUserMedia({audio:true}).then(stream=>{this.mediaRecorder=new MediaRecorder(stream);this.audioChunks=[];this.mediaRecorder.ondataavailable=e=>this.audioChunks.push(e.data);this.mediaRecorder.onstop=()=>{let blob=new Blob(this.audioChunks,{type:'audio/webm'});this.audioUrl=URL.createObjectURL(blob);this.uploadAudio(blob);stream.getTracks().forEach(t=>t.stop());};this.mediaRecorder.start();this.recording=true;}).catch(e=>alert('Microphone access is required.'));},stopRecording(){if(this.mediaRecorder){this.mediaRecorder.stop();this.recording=false;}},uploadAudio(blob){this.uploading=true;let file=new File([blob],'recording_{{ $question->id }}.webm',{type:'audio/webm'});$wire.upload('answers.{{ $question->id }}',file,()=>{this.uploading=false;},()=>{this.uploading=false;alert('Upload failed.');});}}">
                                    <div x-show="audioUrl" style="margin-bottom:14px;background:white;padding:12px;border-radius:10px;border:1px solid var(--border);{{ $existingAudio ? '' : 'display:none;' }}">
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
                @endif {{-- end default layout --}}

                {{-- Bottom Nav --}}
                <div class="exam-footer" style="position:fixed;bottom:0;left:0;right:0;background:var(--surface);border-top:1px solid var(--border);padding:12px 24px;display:flex;justify-content:space-between;align-items:center;z-index:40;">
                    @if($this->attempt->exam->mode !== 'strict')
                    <button wire:click="prevGroup" wire:loading.attr="disabled" @disabled($currentIndex === 0)
                            style="padding:10px 20px;border-radius:12px;font-size:0.82rem;font-weight:700;background:var(--surface);color:var(--text);border:1.5px solid var(--border);cursor:pointer;{{ $currentIndex === 0 ? 'opacity:0.3;pointer-events:none;' : '' }}">
                        ← Back
                    </button>
                    @else
                    <div></div> {{-- Spacer to keep Next button on the right --}}
                    @endif

                    <div wire:loading wire:target="answers" style="font-size:0.72rem;font-weight:700;color:var(--blue);">Saving...</div>
                    
                    @if ($currentIndex === count($groupIds) - 1)
                    <button wire:click="finishExam" wire:loading.attr="disabled"
                            style="padding:10px 20px;border-radius:12px;font-size:0.82rem;font-weight:800;background:#16a34a;color:white;border:none;cursor:pointer;box-shadow:0 4px 12px rgba(22,163,74,0.3);">
                        ✓ Submit Exam
                    </button>
                    @else
                    <button wire:click="nextGroup" wire:loading.attr="disabled"
                            style="padding:10px 20px;border-radius:12px;font-size:0.82rem;font-weight:800;background:var(--blue);color:white;border:none;cursor:pointer;">
                        Next →
                    </button>
                    @endif
                </div>
            @endif
        </div>

        {{-- RIGHT SIDEBAR - Navigation Grid --}}
        @if($this->attempt->exam->mode !== 'strict')
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
                    style="width:100%;padding:12px;border-radius:14px;font-size:0.85rem;font-weight:800;background:#16a34a;color:white;border:none;cursor:pointer;box-shadow:0 4px 12px rgba(22,163,74,0.3);transition:all .2s;"
                    onmouseover="this.style.background='#15803d'" onmouseout="this.style.background='#16a34a'">
                ✓ Finish Exam
            </button>
        </div>
        @endif
    </div>
    @endif
    </div>

    <script>
        window.addEventListener('beforeunload', function(e) { e.preventDefault(); e.returnValue = ''; });

        document.addEventListener('alpine:init', () => {
            Alpine.data('panzoomImage', () => ({
                scale: 1,
                panX: 0,
                panY: 0,
                isDragging: false,
                startX: 0,
                startY: 0,
                isFullscreen: false,
                toggleFullscreen() {
                    this.isFullscreen = !this.isFullscreen;
                    // Reset zoom & pan when toggling
                    this.scale = 1;
                    this.panX = 0;
                    this.panY = 0;
                    
                    if (this.isFullscreen) {
                        document.body.style.overflow = 'hidden';
                        document.body.classList.add('is-fullscreen-mode');
                    } else {
                        document.body.style.overflow = '';
                        document.body.classList.remove('is-fullscreen-mode');
                    }
                },
                handleWheel(e) {
                    e.preventDefault();
                    const zoomSensitivity = 0.002;
                    this.scale += e.deltaY * -zoomSensitivity;
                    this.scale = Math.min(Math.max(1, this.scale), 5); // Limit zoom between 1x (original) and 5x
                    
                    // Reset pan position if scaled back to 1
                    if (this.scale === 1) {
                        this.panX = 0;
                        this.panY = 0;
                    }
                },
                startDrag(e) {
                    if (this.scale > 1 || this.isFullscreen) {
                        // Avoid preventing default on touchstart if possible, but we need it for mouse
                        if (e.type === 'mousedown') e.preventDefault();
                        this.isDragging = true;
                        
                        const clientX = e.type.includes('touch') ? e.touches[0].clientX : e.clientX;
                        const clientY = e.type.includes('touch') ? e.touches[0].clientY : e.clientY;
                        
                        this.startX = clientX - this.panX;
                        this.startY = clientY - this.panY;
                    }
                },
                doDrag(e) {
                    if (!this.isDragging) return;
                    e.preventDefault(); // Prevent page scroll when dragging image
                    
                    const clientX = e.type.includes('touch') ? e.touches[0].clientX : e.clientX;
                    const clientY = e.type.includes('touch') ? e.touches[0].clientY : e.clientY;
                    
                    this.panX = clientX - this.startX;
                    this.panY = clientY - this.startY;
                },
                endDrag() {
                    this.isDragging = false;
                }
            }));
        });
    </script>
    <style>@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }</style>
</div>
