<?php

namespace App\Filament\Widgets;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Question;
use App\Models\User;
use App\Enums\ExamAttemptStatus;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalStudents   = User::where('role', 'test_taker')->count();
        $newThisMonth    = User::where('role', 'test_taker')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $activeCourses   = Course::where('is_published', true)->count();
        $totalEnrollments = CourseEnrollment::count();

        $gradedAttempts  = ExamAttempt::where('status', ExamAttemptStatus::GRADED->value)->count();
        $totalAttempts   = ExamAttempt::count();

        $certificatesIssued = Certificate::count();

        return [
            Stat::make('Total Students', number_format($totalStudents))
                ->description('+' . $newThisMonth . ' new this month')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary')
                ->chart([max(0,$totalStudents-10), max(0,$totalStudents-7), max(0,$totalStudents-4), $totalStudents]),

            Stat::make('Active Courses', $activeCourses)
                ->description($totalEnrollments . ' total enrollments')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success')
                ->chart([$activeCourses, $activeCourses, $activeCourses, $activeCourses]),

            Stat::make('Exams Completed', $gradedAttempts)
                ->description('Out of ' . $totalAttempts . ' total attempts')
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color('warning')
                ->chart([max(0,$gradedAttempts-8), max(0,$gradedAttempts-5), max(0,$gradedAttempts-2), $gradedAttempts]),

            Stat::make('Certificates Issued', $certificatesIssued)
                ->description('Course completion certificates')
                ->descriptionIcon('heroicon-m-trophy')
                ->color('info')
                ->chart([max(0,$certificatesIssued-3), max(0,$certificatesIssued-2), max(0,$certificatesIssued-1), $certificatesIssued]),
        ];
    }
}
