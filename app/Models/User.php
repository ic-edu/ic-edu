<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $appends = ['profile_photo_url'];

    protected $fillable = [
        'name',
        'profile_photo',
        'email',
        'password',
        'role',
        'city',
        'region',
        'country',
        'latitude',
        'longitude',
        'last_login_ip',
        'onboarding_completed_at',
        'phone',
        'target_exam',
        'target_score',
        'english_level',
        'learning_purpose',
        'profile_bio',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'onboarding_completed_at' => 'datetime',
            'target_score' => 'integer',
        ];
    }

    public function hasCompletedOnboarding(): bool
    {
        return !is_null($this->onboarding_completed_at);
    }

    public function getProfilePhotoUrlAttribute(): string
    {
        if (!$this->profile_photo) {
            $name = urlencode($this->name ?? 'User');
            return "https://ui-avatars.com/api/"
                 . "?name={$name}"
                 . "&background=1A456C"
                 . "&color=fff&size=200";
        }

        if (str_starts_with($this->profile_photo, 'maskot/')) {
            $filename = substr($this->profile_photo, strlen('maskot/'));
            return asset('assets/maskot/' . rawurlencode($filename));
        }

        if (str_starts_with($this->profile_photo, 'presets/')) {
            return asset('assets/avatars/' . $this->profile_photo);
        }

        return Storage::url($this->profile_photo);
    }

    public function examAttempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }

    public function enrollments()
    {
        return $this->hasMany(ExamEnrollment::class);
    }

    public function courseEnrollments()
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }

    public function isExaminer()
    {
        return $this->role === 'examiner';
    }

    public function isTestTaker()
    {
        return $this->role === 'test_taker';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
