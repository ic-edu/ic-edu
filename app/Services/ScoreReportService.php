<?php

namespace App\Services;

use App\Models\ExamAttempt;
use App\Models\AttemptAnswer;

class ScoreReportService
{
    /**
     * Menghasilkan data laporan lengkap untuk sebuah ExamAttempt
     */
    public function generateData(ExamAttempt $attempt): array
    {
        $attempt->load(['user', 'exam.sections.subsections.questionGroups.questions']);

        $exam = $attempt->exam;
        
        $sectionsData = [];
        $totalEarnedPoints = 0;
        $totalMaxPoints = 0;

        // 1. Build Base Structure from Exam (True Max Points)
        foreach ($exam->sections as $section) {
            $sectionName = $section->title;
            $sectionsData[$sectionName] = [
                'earned_points' => 0,
                'max_points'    => 0,
                'subsections'   => []
            ];

            foreach ($section->subsections as $subsection) {
                $subsectionName = $subsection->title;
                $sectionsData[$sectionName]['subsections'][$subsectionName] = [
                    'earned_points' => 0,
                    'max_points'    => 0,
                ];

                foreach ($subsection->questionGroups as $group) {
                    foreach ($group->questions as $q) {
                        $points = $q->points ?? 1;
                        $sectionsData[$sectionName]['max_points'] += $points;
                        $sectionsData[$sectionName]['subsections'][$subsectionName]['max_points'] += $points;
                        $totalMaxPoints += $points;
                    }
                }
            }
        }

        // 2. Map Earned Points from AttemptAnswers
        $allAnswers = AttemptAnswer::with(['question.questionGroup.subsection.section'])
            ->where('exam_attempt_id', $attempt->id)
            ->get();

        foreach ($allAnswers as $ans) {
            $q = $ans->question;
            if (!$q) continue;

            $group = $q->questionGroup;
            $subsection = $group ? $group->subsection : null;
            $section = $subsection ? $subsection->section : null;

            if (!$section || !$subsection) continue; // safety check

            $sectionName = $section->title;
            $subsectionName = $subsection->title;

            $score = $ans->score ?? 0;

            if (isset($sectionsData[$sectionName])) {
                $sectionsData[$sectionName]['earned_points'] += $score;
                $sectionsData[$sectionName]['subsections'][$subsectionName]['earned_points'] += $score;
                $totalEarnedPoints += $score;
            }
        }

        // Calculate Global Percentage
        $percentage = $totalMaxPoints > 0 ? ($totalEarnedPoints / $totalMaxPoints) * 100 : 0;
        $cefrLevel = $this->getCefrLevel($percentage);

        return [
            'user'            => $attempt->user,
            'exam'            => $attempt->exam,
            'attempt'         => $attempt,
            'sections_data'   => $sectionsData,
            'total_earned'    => $totalEarnedPoints,
            'total_max'       => $totalMaxPoints,
            'percentage'      => round($percentage, 2),
            'cefr_level'      => $cefrLevel,
            'cefr_description'=> $this->getCefrDescription($cefrLevel),
            'generated_at'    => now()->format('d F Y, H:i'),
        ];
    }

    /**
     * Memetakan persentase ke level CEFR (Common European Framework of Reference)
     */
    private function getCefrLevel(float $percentage): string
    {
        if ($percentage >= 90) return 'C2';
        if ($percentage >= 80) return 'C1';
        if ($percentage >= 65) return 'B2';
        if ($percentage >= 50) return 'B1';
        if ($percentage >= 35) return 'A2';
        return 'A1';
    }

    private function getCefrDescription(string $level): string
    {
        return match($level) {
            'C2' => 'Mastery / Proficient',
            'C1' => 'Advanced / Operational Proficiency',
            'B2' => 'Upper Intermediate',
            'B1' => 'Intermediate',
            'A2' => 'Elementary / Waystage',
            'A1' => 'Beginner / Breakthrough',
            default => 'Unknown'
        };
    }
}
