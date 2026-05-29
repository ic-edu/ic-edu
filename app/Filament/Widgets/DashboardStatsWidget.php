<?php

namespace App\Filament\Widgets;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Question;
use App\Models\User;
use App\Models\TokenTransaction;
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

        // Calculate Grand Total Revenue
        $courseRevenue = CourseEnrollment::join('courses', 'course_enrollments.course_id', '=', 'courses.id')
            ->sum('courses.price');

        $tokenTx = TokenTransaction::where('type', 'purchase')->where('status', 'completed')->get();
        $tokenRevenue = 0;
        
        $price1 = (int) \App\Models\Setting::get('token_price_per_unit', 99000);
        $price3 = (int) \App\Models\Setting::get('token_package_3_price', 249000);
        $price5 = (int) \App\Models\Setting::get('token_package_5_price', 399000);

        foreach ($tokenTx as $t) {
            $amount = abs($t->amount);
            if ($amount === 1) {
                $tokenRevenue += $price1;
            } elseif ($amount === 3) {
                $tokenRevenue += $price3;
            } elseif ($amount === 5) {
                $tokenRevenue += $price5;
            } else {
                $tokenRevenue += $amount * $price1;
            }
        }
        $grandTotalRevenue = $courseRevenue + $tokenRevenue;

        // Calculate last 4 days revenue trend for sparkline
        $revenueTrend = [];
        for ($i = 3; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dayCourse = CourseEnrollment::join('courses', 'course_enrollments.course_id', '=', 'courses.id')
                ->whereDate('course_enrollments.created_at', $date)
                ->sum('courses.price');
            $dayTx = TokenTransaction::where('type', 'purchase')
                ->where('status', 'completed')
                ->whereDate('created_at', $date)
                ->get();
            $dayToken = 0;
            foreach ($dayTx as $t) {
                $amount = abs($t->amount);
                if ($amount === 1) {
                    $dayToken += $price1;
                } elseif ($amount === 3) {
                    $dayToken += $price3;
                } elseif ($amount === 5) {
                    $dayToken += $price5;
                } else {
                    $dayToken += $amount * $price1;
                }
            }
            $revenueTrend[] = $dayCourse + $dayToken;
        }

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

            Stat::make('Grand Total Revenue', 'Rp ' . number_format($grandTotalRevenue, 0, ',', '.'))
                ->description('Combined course & token sales')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('info')
                ->chart($revenueTrend),
        ];
    }
}
