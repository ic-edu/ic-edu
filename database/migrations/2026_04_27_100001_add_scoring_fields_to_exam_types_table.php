<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * scoring_method:
     *   - 'raw'        → Skor mentah (jumlah benar / total soal × max_score). Untuk ujian biasa.
     *   - 'weighted'   → Tiap section punya bobot/poin berbeda, lalu dijumlah. Untuk TOEFL iBT (0-120).
     *   - 'band'       → Rata-rata section score dibulatkan ke 0.5 terdekat. Untuk IELTS (0.0-9.0).
     *   - 'per_section'→ Tiap section dihitung sendiri lalu dijumlah. Untuk TOEIC (5-495 + 5-495).
     */
    public function up(): void
    {
        Schema::table('exam_types', function (Blueprint $table) {
            $table->string('scoring_method', 50)->default('raw')->after('description');
            // Skor maksimum yang bisa diraih (misal: IELTS=9, TOEFL=120, TOEIC=990, Biasa=100)
            $table->decimal('max_score', 6, 1)->default(100)->after('scoring_method');
            // Skor minimum kelulusan default untuk tipe ujian ini
            $table->decimal('passing_score', 6, 1)->nullable()->after('max_score');
            // Apakah skor tiap section ditampilkan secara terpisah?
            $table->boolean('show_section_scores')->default(false)->after('passing_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_types', function (Blueprint $table) {
            $table->dropColumn(['scoring_method', 'max_score', 'passing_score', 'show_section_scores']);
        });
    }
};
