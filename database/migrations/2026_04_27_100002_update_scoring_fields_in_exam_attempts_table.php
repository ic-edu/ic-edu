<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * raw_score       → Jumlah jawaban benar mentah (integer)
     * converted_score → Skor final setelah konversi ke skala ujian (decimal, misal: 8.5 atau 850)
     * section_scores  → JSON skor per section (misal: {"listening": 495, "reading": 450})
     * is_passed       → Apakah peserta lulus berdasarkan passing_score ujian ini
     */
    public function up(): void
    {
        Schema::table('exam_attempts', function (Blueprint $table) {
            // Hapus kolom lama total_score (integer biasa)
            $table->dropColumn('total_score');

            // Tambah kolom scoring baru
            $table->integer('raw_score')->nullable()->after('status');
            $table->decimal('converted_score', 6, 1)->nullable()->after('raw_score');
            $table->json('section_scores')->nullable()->after('converted_score');
            $table->boolean('is_passed')->nullable()->after('section_scores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_attempts', function (Blueprint $table) {
            $table->dropColumn(['raw_score', 'converted_score', 'section_scores', 'is_passed']);
            $table->integer('total_score')->nullable();
        });
    }
};
