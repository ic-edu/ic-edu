<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exam_types', function (Blueprint $table) {
            // Pembulatan skor: 1 (default), 5 (TOEIC), 0.5 (IELTS)
            $table->decimal('rounding_step', 5, 2)->default(1)->after('show_section_scores');

            // Skor minimum total (TOEIC = 10, kebanyakan = 0)
            $table->decimal('min_score', 8, 1)->default(0)->after('rounding_step');

            // Skor minimum per section (TOEIC = 5, kebanyakan = 0)
            $table->decimal('section_min_score', 8, 1)->default(0)->after('min_score');
        });
    }

    public function down(): void
    {
        Schema::table('exam_types', function (Blueprint $table) {
            $table->dropColumn(['rounding_step', 'min_score', 'section_min_score']);
        });
    }
};
