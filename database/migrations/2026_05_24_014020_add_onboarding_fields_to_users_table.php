<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('onboarding_completed_at')
                  ->nullable()
                  ->after('email_verified_at');

            $table->string('phone', 20)
                  ->nullable()
                  ->after('onboarding_completed_at');

            $table->string('target_exam', 50)
                  ->nullable()
                  ->comment('TOEIC, IELTS, TOEFL, etc')
                  ->after('phone');

            $table->integer('target_score')
                  ->nullable()
                  ->after('target_exam');

            $table->string('english_level', 20)
                  ->nullable()
                  ->comment('beginner, intermediate, advanced')
                  ->after('target_score');

            $table->string('learning_purpose', 100)
                  ->nullable()
                  ->comment('career, study_abroad, personal, etc')
                  ->after('english_level');

            $table->string('profile_bio', 255)
                  ->nullable()
                  ->after('learning_purpose');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'onboarding_completed_at',
                'phone',
                'target_exam',
                'target_score',
                'english_level',
                'learning_purpose',
                'profile_bio',
            ]);
        });
    }
};
