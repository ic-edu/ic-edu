<?php

use App\Models\Exam;
use App\Models\ExamAttempt;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.test_taker')]
class extends Component {
    public Exam $exam;
    public int $totalQuestions = 0;
    public ?string $attemptStatus = null; // null = never attempted, 'ongoing', 'finished'

    public function mount(Exam $exam)
    {
        $this->exam = $exam->load(['sections' => fn($q) => $q->orderBy('order_position'), 'examType']);
        $this->totalQuestions = $this->exam->total_questions;

        // Check existing attempts
        $userId = Auth::id();
        $latestAttempt = ExamAttempt::where('user_id', $userId)
            ->where('exam_id', $this->exam->id)
            ->latest()
            ->first();

        if ($latestAttempt) {
            $this->attemptStatus = $latestAttempt->status;
        }
    }

    public function startExam()
    {
        $userId = Auth::id();

        // If already finished, block
        $finishedAttempt = ExamAttempt::where('user_id', $userId)
            ->where('exam_id', $this->exam->id)
            ->where('status', 'finished')
            ->first();

        if ($finishedAttempt) {
            return;
        }

        // Resume ongoing
        $existingAttempt = ExamAttempt::where('user_id', $userId)
            ->where('exam_id', $this->exam->id)
            ->where('status', 'ongoing')
            ->first();

        if ($existingAttempt) {
            return redirect()->route('test_taker.exam.attempt', ['attempt' => $existingAttempt->id]);
        }

        // Create new
        $newAttempt = ExamAttempt::create([
            'user_id' => $userId,
            'exam_id' => $this->exam->id,
            'started_at' => now(),
            'status' => 'ongoing',
        ]);

        return redirect()->route('test_taker.exam.attempt', ['attempt' => $newAttempt->id]);
    }
};
?>

<div style="max-width: 900px; margin: 0 auto; width: 100%;" x-data="{ showConfirm: false }">

    {{-- BACK LINK --}}
    <a href="{{ route('test_taker.exam.index') }}" style="display: inline-flex; align-items: center; gap: 6px; font-size: 0.82rem; font-weight: 700; color: var(--muted); text-decoration: none; margin-bottom: 24px; transition: color .2s;"
       onmouseover="this.style.color='var(--blue)'" onmouseout="this.style.color='var(--muted)'">
        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
        Back to Browse Exams
    </a>

    {{-- EXAM HEADER CARD --}}
    <div class="card anim-in d1" style="overflow: hidden; margin-bottom: 24px;">
        @php
            $gradients = [
                'linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #4f46e5 100%)',
                'linear-gradient(135deg, #064e3b 0%, #059669 50%, #0d9488 100%)',
                'linear-gradient(135deg, #7c2d12 0%, #ea580c 50%, #f59e0b 100%)',
            ];
            $grad = $gradients[$exam->id % count($gradients)];
        @endphp
        <div style="background: {{ $grad }}; padding: 40px 32px; position: relative; overflow: hidden;">
            <div style="position:absolute;inset:0;opacity:0.06;background-image:radial-gradient(circle,white 1px,transparent 1px);background-size:20px 20px;pointer-events:none;"></div>
            <div style="position:absolute;width:200px;height:200px;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,0.12),transparent 65%);top:-50px;right:-30px;pointer-events:none;"></div>
            
            <div style="position: relative; z-index: 2;">
                <span style="display:inline-block;background:rgba(255,255,255,0.15);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.2);color:rgba(255,255,255,0.9);font-size:0.65rem;font-weight:800;letter-spacing:.08em;text-transform:uppercase;padding:4px 12px;border-radius:99px;margin-bottom:14px;">
                    {{ $exam->examType->name ?? 'Exam' }}
                </span>
                <h1 style="font-size: 1.8rem; font-weight: 900; color: white; line-height: 1.2; margin-bottom: 10px;">
                    {{ $exam->title }}
                </h1>
                <p style="font-size: 0.85rem; color: rgba(255,255,255,0.7); max-width: 500px; line-height: 1.7;">
                    Computer Based Test (CBT) Simulation
                </p>
            </div>
        </div>

        {{-- STATS ROW --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); border-top: 1px solid var(--border);">
            <div style="padding: 20px 24px; text-align: center; border-right: 1px solid var(--border);">
                <p style="font-size: 0.6rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 6px;">Duration</p>
                <p style="font-size: 1.3rem; font-weight: 900; color: var(--text);">{{ $exam->total_duration ?? 120 }} <span style="font-size: 0.7rem; font-weight: 700; color: var(--muted);">Min</span></p>
            </div>
            <div style="padding: 20px 24px; text-align: center; border-right: 1px solid var(--border);">
                <p style="font-size: 0.6rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 6px;">Questions</p>
                <p style="font-size: 1.3rem; font-weight: 900; color: var(--text);">{{ $totalQuestions }}</p>
            </div>
            <div style="padding: 20px 24px; text-align: center; border-right: 1px solid var(--border);">
                <p style="font-size: 0.6rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 6px;">Sections</p>
                <p style="font-size: 1.3rem; font-weight: 900; color: var(--text);">{{ $exam->sections->count() }}</p>
            </div>
            <div style="padding: 20px 24px; text-align: center;">
                <p style="font-size: 0.6rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 6px;">Status</p>
                @if($attemptStatus === 'finished')
                <span style="display:inline-block;padding:4px 10px;border-radius:99px;font-size:0.7rem;font-weight:800;background:#fef2f2;color:#dc2626;">✓ Completed</span>
                @elseif($attemptStatus === 'ongoing')
                <span style="display:inline-block;padding:4px 10px;border-radius:99px;font-size:0.7rem;font-weight:800;background:#fefce8;color:#ca8a04;">● In Progress</span>
                @else
                <span style="display:inline-block;padding:4px 10px;border-radius:99px;font-size:0.7rem;font-weight:800;background:#ecfdf5;color:#16a34a;">● Available</span>
                @endif
            </div>
        </div>
    </div>

    {{-- SECTIONS OVERVIEW --}}
    <div class="card card-pad anim-in d2" style="margin-bottom: 24px;">
        <h2 style="font-size: 0.75rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 20px;">
            Exam Sections
        </h2>
        <div style="display: flex; flex-direction: column; gap: 12px;">
            @foreach($exam->sections as $idx => $section)
            <div style="display: flex; align-items: center; gap: 16px; padding: 16px; background: var(--base); border-radius: 14px; border: 1px solid var(--border);">
                <div style="width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, var(--blue), var(--indigo)); color: white; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 900; flex-shrink: 0;">
                    {{ $idx + 1 }}
                </div>
                <div style="flex: 1; min-width: 0;">
                    <p style="font-size: 0.9rem; font-weight: 800; color: var(--text);">{{ $section->title }}</p>
                    @if($section->description)
                    <p style="font-size: 0.78rem; color: var(--muted); margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ Str::limit(strip_tags($section->description), 80) }}</p>
                    @endif
                </div>
                @if($section->duration)
                <span style="font-size: 0.72rem; font-weight: 800; color: var(--blue); background: white; padding: 4px 10px; border-radius: 8px; border: 1px solid var(--border); flex-shrink: 0;">
                    {{ $section->duration }} Min
                </span>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    {{-- RULES & INSTRUCTIONS --}}
    <div class="card card-pad anim-in d3" style="margin-bottom: 24px;">
        <h2 style="font-size: 0.75rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 16px;">
            Rules & Instructions
        </h2>
        
        @if($exam->description)
        <div style="font-size: 0.85rem; color: #374151; line-height: 1.8; margin-bottom: 20px;">
            {!! $exam->description !!}
        </div>
        @endif

        <div style="display: flex; flex-direction: column; gap: 10px;">
            @php
            $rules = [
                ['icon' => '🌐', 'text' => 'Ensure you have a stable internet connection before starting.'],
                ['icon' => '⏱️', 'text' => 'The timer continues running even if you close the browser.'],
                ['icon' => '🚫', 'text' => 'Do not press Refresh (F5) or the Back button.'],
                ['icon' => '🔇', 'text' => 'Choose a quiet place so audio can be heard clearly.'],
                ['icon' => '✅', 'text' => 'Review your answers before submitting the exam.'],
            ];
            @endphp
            @foreach($rules as $rule)
            <div style="display: flex; align-items: flex-start; gap: 12px; padding: 12px 16px; background: var(--base); border-radius: 12px;">
                <span style="font-size: 1rem; flex-shrink: 0;">{{ $rule['icon'] }}</span>
                <p style="font-size: 0.82rem; color: #374151; line-height: 1.5;">{{ $rule['text'] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- CTA BUTTON --}}
    <div class="anim-in d4" style="text-align: right;">
        @if($attemptStatus === 'finished')
            {{-- Already completed --}}
            <div class="card card-pad" style="text-align: center; border: 2px solid #e5e7eb;">
                <div style="width:48px;height:48px;border-radius:50%;background:#f0fdf4;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                    <svg style="width:22px;height:22px;color:#16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </div>
                <p style="font-size:0.95rem;font-weight:800;color:var(--text);margin-bottom:4px;">Exam Completed</p>
                <p style="font-size:0.8rem;color:var(--muted);">You have already taken this exam. Results are available in My Exams.</p>
            </div>
        @elseif($attemptStatus === 'ongoing')
            {{-- Resume ongoing --}}
            <button @click="showConfirm = true"
                    style="display: inline-flex; align-items: center; gap: 10px; padding: 14px 32px; border-radius: 14px; font-size: 0.9rem; font-weight: 800; background: linear-gradient(135deg, #f59e0b, #ea580c); color: white; border: none; cursor: pointer; box-shadow: 0 6px 20px rgba(245,158,11,0.3); transition: all .2s;"
                    onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/></svg>
                Resume Exam
            </button>
        @else
            {{-- Start new --}}
            <button @click="showConfirm = true"
                    style="display: inline-flex; align-items: center; gap: 10px; padding: 14px 32px; border-radius: 14px; font-size: 0.9rem; font-weight: 800; background: linear-gradient(135deg, var(--blue), var(--indigo)); color: white; border: none; cursor: pointer; box-shadow: 0 6px 20px rgba(37,99,235,0.3); transition: all .2s;"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 28px rgba(37,99,235,0.4)';"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 6px 20px rgba(37,99,235,0.3)';">
                <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Start Exam
            </button>
        @endif
    </div>

    {{-- CONFIRMATION MODAL (Alpine client-side = instant, wire:click for server action) --}}
    <div x-show="showConfirm" x-transition.opacity.duration.200ms
         style="position:fixed;top:0;left:0;width:100vw;height:100vh;z-index:99999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.5);backdrop-filter:blur(4px);"
         x-cloak>
        <div @click.outside="showConfirm = false" x-show="showConfirm" x-transition.scale.origin.center.duration.200ms
             style="background:white;border-radius:24px;padding:40px;max-width:440px;width:90%;text-align:center;box-shadow:0 25px 50px rgba(0,0,0,0.15);">
            <div style="width:64px;height:64px;border-radius:50%;background:#eff6ff;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
                <svg style="width:28px;height:28px;color:var(--blue);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            </div>
            <h3 style="font-size:1.2rem;font-weight:900;color:var(--text);margin-bottom:8px;">Ready to Begin?</h3>
            <p style="font-size:0.82rem;color:var(--muted);line-height:1.7;margin-bottom:28px;">
                Once started, the timer will begin and <strong style="color:var(--text);">cannot be paused</strong>.
                Make sure you're in a quiet place with stable internet.
            </p>
            <div style="display:flex;gap:12px;justify-content:center;">
                <button @click="showConfirm = false"
                        style="padding:12px 24px;border-radius:14px;font-size:0.85rem;font-weight:700;background:white;color:var(--muted);border:1.5px solid var(--border);cursor:pointer;transition:all .2s;"
                        onmouseover="this.style.borderColor='var(--blue)'" onmouseout="this.style.borderColor='var(--border)'">
                    Cancel
                </button>
                <button wire:click="startExam" wire:loading.attr="disabled"
                        style="padding:12px 24px;border-radius:14px;font-size:0.85rem;font-weight:800;background:linear-gradient(135deg,var(--blue),var(--indigo));color:white;border:none;cursor:pointer;box-shadow:0 4px 12px rgba(37,99,235,0.3);display:inline-flex;align-items:center;gap:8px;">
                    <span wire:loading.remove wire:target="startExam">Confirm & Start</span>
                    <span wire:loading wire:target="startExam">Preparing...</span>
                </button>
            </div>
        </div>
    </div>

    <style>[x-cloak] { display: none !important; }</style>
</div>
