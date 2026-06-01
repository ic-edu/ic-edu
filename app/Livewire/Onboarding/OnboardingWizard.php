<?php

namespace App\Livewire\Onboarding;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.onboarding')]
class OnboardingWizard extends Component
{
    use WithFileUploads;

    public int $currentStep = 1;
    public int $totalSteps  = 4;

    // Step 1 — Profil dasar
    public string $name          = '';
    public string $phone         = '';
    public string $profile_bio   = '';
    public string $profile_photo = '';
    public string $photo_source  = ''; // 'preset' | 'upload' | ''
    public $uploaded_photo = null;

    // Step 2 — Target ujian
    public string $target_exam   = '';
    public ?int   $target_score  = null;

    // Step 3 — Preferensi belajar
    public string $english_level    = '';
    public string $learning_purpose = '';

    protected function rulesForStep(): array
    {
        return match ($this->currentStep) {
            1 => [
                'uploaded_photo' => 'nullable|image|max:2048',
            ],
            2 => [
                'target_exam'  => 'required|in:TOEIC,IELTS,TOEFL',
                'target_score' => 'nullable|integer|min:0|max:990',
            ],
            3 => [
                'english_level'    => 'required|in:beginner,intermediate,advanced',
                'learning_purpose' => 'required|in:career,study_abroad,personal,other',
            ],
            default => [],
        };
    }

    public function mount(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $this->name             = $user->name ?? '';
        $this->phone            = $user->phone ?? '';
        $this->profile_bio      = $user->profile_bio ?? '';
        $this->profile_photo    = $user->profile_photo ?? '';
        $this->photo_source     = str_starts_with($this->profile_photo, 'presets/') ? 'preset'
                                : ($this->profile_photo ? 'upload' : '');
        $this->target_exam      = $user->target_exam ?? '';
        $this->target_score     = $user->target_score;
        $this->english_level    = $user->english_level ?? '';
        $this->learning_purpose = $user->learning_purpose ?? '';
    }

    public function selectPreset(string $filename): void
    {
        $this->profile_photo = 'presets/' . $filename;
        $this->photo_source  = 'preset';
        // uploaded_photo dibiarkan — gambar yang sudah diupload tetap tampil
    }

    public function updatedUploadedPhoto(): void
    {
        $this->validateOnly('uploaded_photo', ['uploaded_photo' => 'image|max:2048']);
        $this->photo_source = 'upload';
        // profile_photo dibiarkan — preset tetap tersimpan tapi tidak aktif
    }

    public function nextStep(): void
    {
        $rules = $this->rulesForStep();
        if (!empty($rules)) {
            $this->validate($rules);
        }
        $this->saveCurrentStep();

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function saveCurrentStep(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($this->currentStep === 1) {
            $data = [];

            if ($this->photo_source === 'upload' && $this->uploaded_photo) {
                $path = $this->uploaded_photo->store('avatars/' . $user->id, 'public');
                $data['profile_photo'] = $path;
                $this->profile_photo   = $path;
            } elseif ($this->photo_source === 'preset' && $this->profile_photo) {
                $data['profile_photo'] = $this->profile_photo;
            }

            $user->update($data);
        } elseif ($this->currentStep === 2) {
            $user->update([
                'target_exam'  => $this->target_exam,
                'target_score' => $this->target_score,
            ]);
        } elseif ($this->currentStep === 3) {
            $user->update([
                'english_level'    => $this->english_level,
                'learning_purpose' => $this->learning_purpose,
            ]);
        }
    }

    public function completeOnboarding(): void
    {
        $rules = $this->rulesForStep();
        if (!empty($rules)) {
            $this->validate($rules);
        }
        $this->saveCurrentStep();

        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();
        $currentUser->update([
            'onboarding_completed_at' => now(),
        ]);

        session()->flash('onboarding_complete', 'Welcome to IC.EDU! Your profile is ready.');

        $this->redirect(route('test_taker.dashboard'), navigate: true);
    }

    public function render()
    {
        return view('livewire.onboarding.onboarding-wizard');
    }
}
