<?php

namespace App\Livewire;

use App\Models\Answer;
use App\Models\ExamAttempt;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]

class ExamSimulator extends Component
{
    use WithFileUploads;

    public $attempt;
    public $questions;
    public $remainingSeconds;
    public $currentQuestionIndex = 0;
    public $selectedAnswers = [];

    public function mount($attemptId)
    {
        $attempt = ExamAttempt::with(['exam.sections.questions.options'])
            ->findOrFail($attemptId);

        // Validation User Access
        if ($attempt->user_id !== Auth::id()) {
            abort(403, 'Access denied');
        }

        // Validation Exam Status
        if ($attempt->status === 'completed') {
            return redirect()->route('exams.result', $attempt->id);
        }

        $this->attempt = $attempt;
        $this->questions = $this->attempt->exam->sections->flatMap->questions->values();
        $this->currentQuestionIndex = $this->attempt->current_question_index ?? 0;
        if ($this->attempt->answers) {
            $this->selectedAnswers = $this->attempt->answers;
        }

        // Calculate Remaining Time
        $startTime = $this->attempt->start_time;
        $duration = $this->attempt->exam->duration_minutes;
        $endTime = $startTime->copy()->addMinutes($duration);
        $secondsLeft = now()->diffInSeconds($endTime, false);

        if ($secondsLeft <= 0) {
            $this->finishExam();
            return;
        }

        $this->remainingSeconds = $secondsLeft;
    }

    public function updatedSelectedAnswers($value, $key)
    {
        if (is_object($value) && method_exists($value, 'store')) {
            $path = $value->store('exam-answers', 'public');
            $this->selectedAnswers[$key] = $path;
        }

        $this->attempt->update([
            'answers' => $this->selectedAnswers
        ]);
    }

    public function updatedCurrentQuestionIndex()
    {
        $this->attempt->update([
            'current_question_index' => $this->currentQuestionIndex
        ]);
    }

    private function savePosition()
    {
        $this->attempt->update([
            'current_question_index' => $this->currentQuestionIndex
        ]);
    }

    #[Computed]
    public function currentQuestion()
    {
        return $this->questions[$this->currentQuestionIndex] ?? null;
    }

    public function goToQuestion($index)
    {
        $this->currentQuestionIndex = $index;
        $this->savePosition();
    }

    public function nextQuestion()
    {
        if ($this->currentQuestionIndex < $this->questions->count() - 1) {
            $this->currentQuestionIndex++;
            $this->savePosition();
        }
    }

    public function previousQuestion()
    {
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
            $this->savePosition();
        }
    }

    public function finishExam()
    {
        if ($this->attempt->status === 'completed') {
            return redirect()->route('exams.result', $this->attempt->id);
        }

        $initialScore = 0;

        foreach ($this->questions as $question) {
            $userAnswerValue = $this->selectedAnswers[$question->id] ?? null;
            if (empty($userAnswerValue)) continue;
            $scorePerSoal = 0;
            if ($question->type === 'multiple_choice') {
                $correctOption = $question->options->where('is_correct', true)->first();
                if ($correctOption && $userAnswerValue == $correctOption->id) {
                    $scorePerSoal = 1;
                }
            }
            $initialScore += $scorePerSoal;

            Answer::updateOrCreate(
                [
                    'exam_attempt_id' => $this->attempt->id,
                    'question_id'     => $question->id,
                ],
                [
                    'answer_text' => ($question->type === 'multiple_choice' || $question->type === 'short_answer')
                        ? $userAnswerValue
                        : null,

                    'audio_answer_path' => ($question->type === 'audio_record')
                        ? $userAnswerValue
                        : null,

                    'essay_content' => ($question->type === 'essay')
                        ? $userAnswerValue
                        : null,
                    'score'             => $scorePerSoal,
                    'feedback'          => null
                ]
            );
        }

        $this->attempt->update([
            'status' => 'completed',
            'end_time' => now(),
            'total_score' => $initialScore,
        ]);

        return redirect()->route('exams.result', $this->attempt->id);
    }

    public function render()
    {
        return view('livewire.exam-simulator');
    }
}
