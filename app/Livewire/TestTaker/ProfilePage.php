<?php

namespace App\Livewire\TestTaker;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

#[Layout('layouts.test_taker')]
class ProfilePage extends Component
{
    use WithFileUploads;

    // ── Active tab ──────────────────────────
    public string $activeTab = 'profile';

    // ── Profile fields ──────────────────────
    public string   $name             = '';
    public string   $email            = '';
    public string   $phone            = '';
    public string   $profile_bio      = '';
    public string   $target_exam      = '';
    public ?int     $target_score     = null;
    public string   $english_level    = '';
    public string   $learning_purpose = '';

    // ── Photo ───────────────────────────────
    public bool   $showPhotoPicker = false;
    public string $photoPickerTab  = 'upload';
    public $photoUpload            = null;
    public string $selectedPreset  = '';

    // ── Password ────────────────────────────
    public string $current_password          = '';
    public string $new_password              = '';
    public string $new_password_confirmation = '';

    // ── Preset avatar list ──────────────────
    public array $presetAvatars = [
        'presets/1.png',
        'presets/2.png',
        'presets/3.png',
        'presets/4.png',
        'presets/5.png',
        'presets/6.png',
    ];

    public function mount(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $this->name             = $user->name ?? '';
        $this->email            = $user->email ?? '';
        $this->phone            = $user->phone ?? '';
        $this->profile_bio      = $user->profile_bio ?? '';
        $this->target_exam      = $user->target_exam ?? '';
        $this->target_score     = $user->target_score;
        $this->english_level    = $user->english_level ?? '';
        $this->learning_purpose = $user->learning_purpose ?? '';

        if (request()->has('tab')) {
            $this->activeTab = request('tab');
        }
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
        $this->resetValidation();
    }

    // ── Update profile info ─────────────────
    public function updateProfile(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $this->validate([
            'name'             => 'required|string|max:100',
            'email'            => "required|email|unique:users,email,{$user->id}",
            'phone'            => 'nullable|string|max:20',
            'profile_bio'      => 'nullable|string|max:255',
            'target_exam'      => 'nullable|in:TOEIC,IELTS,TOEFL',
            'target_score'     => 'nullable|integer|min:0|max:990',
            'english_level'    => 'nullable|in:beginner,intermediate,advanced',
            'learning_purpose' => 'nullable|in:career,study_abroad,personal,other',
        ]);

        if ($user->email !== $this->email) {
            $validated['email_verified_at'] = null;
        }

        $user->update($validated);

        session()->flash('profile_saved', 'Profile updated successfully.');
    }

    // ── Photo picker ────────────────────────
    public function openPhotoPicker(): void
    {
        $this->showPhotoPicker = true;
        $this->photoPickerTab  = 'upload';
        $this->photoUpload     = null;
        $this->selectedPreset  = '';
    }

    public function closePhotoPicker(): void
    {
        $this->showPhotoPicker = false;
        $this->photoUpload     = null;
        $this->selectedPreset  = '';
    }

    public function selectPreset(string $preset): void
    {
        $this->selectedPreset = $preset;
    }

    public function applyPhoto(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($this->photoPickerTab === 'upload' && $this->photoUpload) {
            $this->validate([
                'photoUpload' => 'image|max:2048',
            ]);

            if ($user->profile_photo &&
                !str_starts_with($user->profile_photo, 'presets/')) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $path = $this->photoUpload->store('avatars', 'public');
            $user->update(['profile_photo' => $path]);

        } elseif ($this->photoPickerTab === 'preset' && $this->selectedPreset) {
            $user->update(['profile_photo' => $this->selectedPreset]);
        }

        $this->closePhotoPicker();
        session()->flash('profile_saved', 'Profile photo updated.');
    }

    public function removePhoto(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->profile_photo &&
            !str_starts_with($user->profile_photo, 'presets/')) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $user->update(['profile_photo' => null]);
        session()->flash('profile_saved', 'Profile photo removed.');
    }

    // ── Delete account ──────────────────────
    public function deleteAccount(): void
    {
        $this->validate([
            'current_password' => [
                'required',
                function ($_attr, $val, $fail) {
                    /** @var \App\Models\User $u */
                    $u = Auth::user();
                    if (!Hash::check($val, $u->password)) {
                        $fail('Password is incorrect.');
                    }
                },
            ],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        Auth::logout();
        $user->delete();

        $this->redirect(route('login'), navigate: false);
    }

    // ── Update password ─────────────────────
    public function updatePassword(): void
    {
        $this->validate([
            'current_password' => [
                'required',
                function ($_attr, $val, $fail) {
                    /** @var \App\Models\User $u */
                    $u = Auth::user();
                    if (!Hash::check($val, $u->password)) {
                        $fail('Current password is incorrect.');
                    }
                },
            ],
            'new_password' => [
                'required',
                Password::min(8)->letters()->numbers(),
                'confirmed',
            ],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

        session()->flash('password_saved', 'Password updated successfully.');
    }

    public function render()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        return view('test_taker.profile.index', [
            'user' => $user,
        ]);
    }
}
