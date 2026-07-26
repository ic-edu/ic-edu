<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('exam_attempts', function (Blueprint $table) {
            $table->index(['user_id', 'status']);
        });

        Schema::table('lesson_progress', function (Blueprint $table) {
            $table->index(['user_id', 'course_lesson_id']);
        });

        Schema::table('token_transactions', function (Blueprint $table) {
            $table->index('user_id');
        });

        Schema::table('voucher_redemptions', function (Blueprint $table) {
            $table->index(['user_id', 'voucher_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_attempts', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'status']);
        });

        Schema::table('lesson_progress', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'course_lesson_id']);
        });

        Schema::table('token_transactions', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
        });

        Schema::table('voucher_redemptions', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'voucher_id']);
        });
    }
};
