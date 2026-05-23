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
        Schema::table('exams', function (Blueprint $table) {
            $table->boolean('is_public')->default(true)->after('is_active');
        });

        Schema::table('course_lessons', function (Blueprint $table) {
            $table->foreignId('exam_id')->nullable()->after('module_id')->constrained('exams')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_lessons', function (Blueprint $table) {
            $table->dropForeign(['exam_id']);
            $table->dropColumn('exam_id');
        });

        Schema::table('exams', function (Blueprint $table) {
            $table->dropColumn('is_public');
        });
    }
};
