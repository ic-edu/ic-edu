<?php

namespace App\Filament\Widgets;

use App\Models\ExamAttempt;
use App\Enums\ExamAttemptStatus;
use Filament\Widgets\ChartWidget;

class ExamResultsDonut extends ChartWidget
{
    protected ?string $heading = 'Exam Attempt Status';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $graded   = ExamAttempt::where('status', ExamAttemptStatus::GRADED->value)->count();
        $finished = ExamAttempt::where('status', ExamAttemptStatus::FINISHED->value)->count();
        $ongoing  = ExamAttempt::where('status', ExamAttemptStatus::ONGOING->value)->count();

        return [
            'datasets' => [
                [
                    'data'            => [$graded, $finished, $ongoing],
                    'backgroundColor' => ['#10b981', '#f59e0b', '#3b82f6'],
                    'borderWidth'     => 0,
                ],
            ],
            'labels' => ['Graded', 'Pending Review', 'Ongoing'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
