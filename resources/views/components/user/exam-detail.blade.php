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
    public bool $isEnrolled = false;

    public function mount(Exam $exam)
    {
        $this->exam = $exam->load(['sections' => fn($q) => $q->orderBy('order_position'), 'examType']);
        $this->totalQuestions = $this->exam->total_questions;

        // Check enrollment
        $userId = Auth::id();
        $enrollment = \App\Models\ExamEnrollment::where('user_id', $userId)
            ->where('exam_id', $this->exam->id)
            ->first();

        if ($enrollment) {
            $this->isEnrolled = true;
        }
    }

    public function enroll()
    {
        $userId = Auth::id();

        // Cek lagi untuk mencegah double-enrollment
        $existing = \App\Models\ExamEnrollment::where('user_id', $userId)
            ->where('exam_id', $this->exam->id)
            ->first();

        if (!$existing) {
            \App\Models\ExamEnrollment::create([
                'user_id' => $userId,
                'exam_id' => $this->exam->id,
                'enrolled_at' => now(),
                'status' => 'active'
            ]);
        }

        session()->flash('success', 'Berhasil mendaftar ujian! Silakan klik tombol Start Exam untuk memulai.');
        return redirect()->route('test_taker.exam.detail', $this->exam->id);
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
                <p style="font-size: 0.6rem; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 6px;">Enrollment</p>
                @if($isEnrolled)
                <span style="display:inline-block;padding:4px 10px;border-radius:99px;font-size:0.7rem;font-weight:800;background:#f0fdf4;color:#16a34a;">✓ Enrolled</span>
                @else
                <span style="display:inline-block;padding:4px 10px;border-radius:99px;font-size:0.7rem;font-weight:800;background:#fef2f2;color:#dc2626;">Not Enrolled</span>
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
        @if($isEnrolled)
            {{-- Already Enrolled --}}
            @php
                $latestAttempt = $exam->attempts()->where('user_id', auth()->id())->latest()->first();
            @endphp
            @if($latestAttempt && $latestAttempt->status === 'finished')
                <button disabled style="display: inline-flex; align-items: center; gap: 10px; padding: 14px 32px; border-radius: 14px; font-size: 0.9rem; font-weight: 800; background: #e5e7eb; color: #9ca3af; border: none; cursor: not-allowed;">
                    Exam Completed
                </button>
            @else
                <form action="{{ route('test_taker.exam.start', $exam->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @if($latestAttempt && $latestAttempt->status === 'ongoing')
                        <button type="submit" 
                                style="display: inline-flex; align-items: center; gap: 10px; padding: 14px 32px; border-radius: 14px; font-size: 0.9rem; font-weight: 800; background: linear-gradient(135deg, #f59e0b, #ea580c); color: white; border: none; cursor: pointer; box-shadow: 0 6px 20px rgba(234,88,12,0.3); transition: all .2s;"
                                onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                            <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Resume Exam
                        </button>
                    @else
                        <button type="submit" 
                                style="display: inline-flex; align-items: center; gap: 10px; padding: 14px 32px; border-radius: 14px; font-size: 0.9rem; font-weight: 800; background: linear-gradient(135deg, var(--secondary), #4f969b); color: white; border: none; cursor: pointer; box-shadow: 0 6px 20px rgba(111,175,181,0.3); transition: all .2s;"
                                onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                            <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Start Exam
                        </button>
                    @endif
                </form>
            @endif
        @else
            {{-- Need to Enroll --}}
            <button @click="showConfirm = true"
                    style="display: inline-flex; align-items: center; gap: 10px; padding: 14px 32px; border-radius: 14px; font-size: 0.9rem; font-weight: 800; background: linear-gradient(135deg, var(--primary), #1e5282); color: white; border: none; cursor: pointer; box-shadow: 0 6px 20px rgba(26,69,108,0.3); transition: all .2s;"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 28px rgba(26,69,108,0.4)';"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 6px 20px rgba(26,69,108,0.3)';">
                <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Enroll Now
            </button>
        @endif
    </div>

    {{-- CONFIRMATION MODAL (Alpine client-side = instant, wire:click for server action) --}}
    <template x-teleport="body">
        <div x-show="showConfirm" x-transition.opacity.duration.200ms
             style="position:fixed;top:0;left:0;width:100vw;height:100vh;z-index:99999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.5);backdrop-filter:blur(4px);"
             x-cloak>
            <div @click.outside="showConfirm = false" x-show="showConfirm" x-transition.scale.origin.center.duration.200ms
                 style="background:white;border-radius:24px;padding:40px;max-width:440px;width:90%;text-align:center;box-shadow:0 25px 50px rgba(0,0,0,0.15);">
                <div style="width:64px;height:64px;border-radius:50%;background:#f0f4ff;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
                    <svg style="width:28px;height:28px;color:var(--primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <h3 style="font-size:1.2rem;font-weight:900;color:var(--text);margin-bottom:8px;">Terdaftar di Ujian Ini?</h3>
                <p style="font-size:0.82rem;color:var(--muted);line-height:1.7;margin-bottom:28px;">
                    Anda akan terdaftar ke dalam simulasi ujian ini. Ujian akan ditambahkan ke menu <strong>My Exams</strong> Anda.
                </p>
                <div style="display:flex;gap:12px;justify-content:center;">
                    <button @click="showConfirm = false"
                            style="padding:12px 24px;border-radius:14px;font-size:0.85rem;font-weight:700;background:white;color:var(--muted);border:1.5px solid var(--border);cursor:pointer;transition:all .2s;"
                            onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border)'">
                        Cancel
                    </button>
                    <button wire:click="enroll" wire:loading.attr="disabled"
                            style="padding:12px 24px;border-radius:14px;font-size:0.85rem;font-weight:800;background:linear-gradient(135deg,var(--primary),#1e5282);color:white;border:none;cursor:pointer;box-shadow:0 4px 12px rgba(26,69,108,0.3);display:inline-flex;align-items:center;gap:8px;">
                        <span wire:loading.remove wire:target="enroll">Confirm Enrollment</span>
                        <span wire:loading wire:target="enroll">Processing...</span>
                    </button>
                </div>
            </div>
        </div>
    </template>
    <style>[x-cloak] { display: none !important; }</style>
</div>
