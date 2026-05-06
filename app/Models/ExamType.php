<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamType extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'scoring_method',
        'max_score',
        'passing_score',
        'show_section_scores',
    ];

    protected $casts = [
        'max_score'           => 'decimal:1',
        'passing_score'       => 'decimal:1',
        'show_section_scores' => 'boolean',
    ];

    // Daftar scoring method yang tersedia
    const SCORING_METHODS = [
        'raw'         => 'Raw Score (Biasa, 0-100)',
        'weighted'    => 'Weighted (TOEFL iBT, 0-120)',
        'band'        => 'Band Score (IELTS, 0.0-9.0)',
        'per_section' => 'Per Section (TOEIC, 10-990)',
    ];

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    /**
     * Hitung skor final berdasarkan scoring_method yang dikonfigurasi.
     *
     * @param  int    $rawScore     Jumlah jawaban benar
     * @param  int    $totalQuestions Total soal
     * @param  array  $sectionRaws  ['listening' => 45, 'reading' => 50, ...]
     * @param  array  $sectionTotals ['listening' => 50, 'reading' => 50, ...]
     * @return array  ['converted_score' => float, 'section_scores' => array, 'is_passed' => bool]
     */
    public function calculateScore(int $rawScore, int $totalQuestions, array $sectionRaws = [], array $sectionTotals = []): array
    {
        $method       = $this->scoring_method ?? 'raw';
        $maxScore     = (float) ($this->max_score ?? 100);
        $passingScore = (float) ($this->passing_score ?? 0);
        $converted    = 0.0;
        $sectionScores = [];

        switch ($method) {

            // ─── RAW: (benar / total) × max_score ──────────────────────────
            case 'raw':
            default:
                $converted = $totalQuestions > 0
                    ? round(($rawScore / $totalQuestions) * $maxScore, 1)
                    : 0;
                break;

            // ─── WEIGHTED: TOEFL iBT style (tiap section 0-30, maks 120) ───
            // Setiap section berkontribusi sama rata ke total max_score
            case 'weighted':
                if (! empty($sectionRaws) && ! empty($sectionTotals)) {
                    $sectionCount = count($sectionRaws);
                    $scorePerSection = $maxScore / $sectionCount;
                    $total = 0;
                    foreach ($sectionRaws as $section => $benar) {
                        $totalSoal  = $sectionTotals[$section] ?? 1;
                        $sectionScore = round(($benar / $totalSoal) * $scorePerSection);
                        $sectionScores[$section] = $sectionScore;
                        $total += $sectionScore;
                    }
                    $converted = $total;
                }
                break;

            // ─── BAND: IELTS style (rata-rata, bulatkan ke 0.5 terdekat) ───
            case 'band':
                if (! empty($sectionRaws) && ! empty($sectionTotals)) {
                    $bands = [];
                    foreach ($sectionRaws as $section => $benar) {
                        $totalSoal  = $sectionTotals[$section] ?? 1;
                        // Skala linear ke max_score (9.0)
                        $raw = ($benar / $totalSoal) * $maxScore;
                        // Bulatkan ke 0.5 terdekat
                        $band = round($raw * 2) / 2;
                        $sectionScores[$section] = $band;
                        $bands[] = $band;
                    }
                    // Rata-rata, bulatkan ke 0.5 terdekat
                    $avg = array_sum($bands) / count($bands);
                    $converted = round($avg * 2) / 2;
                }
                break;

            // ─── PER_SECTION: TOEIC style (tiap section skala sendiri) ─────
            // Tiap section skornya 5–495, total 10–990
            case 'per_section':
                if (! empty($sectionRaws) && ! empty($sectionTotals)) {
                    $sectionCount = count($sectionRaws);
                    // Skor min per section = max_score / sectionCount / 99 * 1 (floor 5)
                    $maxPerSection = $maxScore / $sectionCount;
                    $minPerSection = 5; // floor minimum TOEIC per section
                    $total = 0;
                    foreach ($sectionRaws as $section => $benar) {
                        $totalSoal  = $sectionTotals[$section] ?? 1;
                        $scaled = round($minPerSection + (($benar / $totalSoal) * ($maxPerSection - $minPerSection)));
                        // Bulatkan ke kelipatan 5
                        $scaled = round($scaled / 5) * 5;
                        $sectionScores[$section] = $scaled;
                        $total += $scaled;
                    }
                    $converted = $total;
                }
                break;
        }

        return [
            'converted_score' => $converted,
            'section_scores'  => $sectionScores,
            'is_passed'       => $passingScore > 0 ? $converted >= $passingScore : null,
        ];
    }
}
