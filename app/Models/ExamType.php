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
        'rounding_step',
        'min_score',
        'section_min_score',
        'page_content',
    ];

    protected $casts = [
        'max_score'           => 'decimal:1',
        'passing_score'       => 'decimal:1',
        'show_section_scores' => 'boolean',
        'rounding_step'       => 'decimal:2',
        'min_score'           => 'decimal:1',
        'section_min_score'   => 'decimal:1',
        'page_content'        => 'array',
    ];

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function calculateScore(int $rawScore, int $totalQuestions, array $sectionRaws = [], array $sectionTotals = []): array
    {
        $maxScore        = (float) ($this->max_score        ?? 100);
        $passingScore    = (float) ($this->passing_score    ?? 0);
        $roundingStep    = (float) ($this->rounding_step    ?? 1);
        $minScore        = (float) ($this->min_score        ?? 0);
        $sectionMinScore = (float) ($this->section_min_score ?? 0);

        $sectionScores = [];
        $converted     = 0.0;

        if (!empty($sectionRaws) && !empty($sectionTotals)) {
            // Mode Per-Section: hitung tiap section secara terpisah
            $sectionCount  = count($sectionRaws);
            $maxPerSection = $sectionCount > 0 ? $maxScore / $sectionCount : $maxScore;

            foreach ($sectionRaws as $sectionName => $earnedPoints) {
                $totalPoints = $sectionTotals[$sectionName] ?? 1;

                $raw = $totalPoints > 0
                    ? ($earnedPoints / $totalPoints) * $maxPerSection
                    : 0;

                $scaled = $this->roundToStep($raw, $roundingStep);

                $sectionScores[$sectionName] = max($sectionMinScore, $scaled);
            }

            $converted = array_sum($sectionScores);
        } else {
            // Mode Global: tidak ada breakdown per section
            $raw = $totalQuestions > 0
                ? ($rawScore / $totalQuestions) * $maxScore
                : 0;

            $converted = $this->roundToStep($raw, $roundingStep);
        }

        // Terapkan minimum total score
        $converted = max($minScore, $converted);

        return [
            'converted_score' => $converted,
            'section_scores'  => $sectionScores,
            'is_passed'       => $passingScore > 0 ? $converted >= $passingScore : null,
        ];
    }

    /**
     * Bulatkan ke kelipatan step terdekat.
     * roundToStep(742.5, 5)  → 745
     * roundToStep(6.75, 0.5) → 7.0
     * roundToStep(85.3, 1)   → 85
     */
    private function roundToStep(float $value, float $step): float
    {
        if ($step <= 0) {
            return round($value, 1);
        }
        return round($value / $step) * $step;
    }
}
