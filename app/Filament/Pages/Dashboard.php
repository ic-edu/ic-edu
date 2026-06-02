<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DashboardStatsWidget;
use App\Filament\Widgets\FinancialOverviewWidget;
use App\Filament\Widgets\ExamResultsDonut;
use App\Filament\Widgets\RecentActivityWidget;
use App\Filament\Widgets\UserDemographicsMap;
use App\Filament\Widgets\UserGrowthChart;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            DashboardStatsWidget::class,
            FinancialOverviewWidget::class,
            UserGrowthChart::class,
            ExamResultsDonut::class,
            UserDemographicsMap::class,
            RecentActivityWidget::class,
        ];
    }

    public function getColumns(): int | array
    {
        return 2;
    }
}
