<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class UserGrowthChart extends ChartWidget
{
    protected ?string $heading = 'Student Registrations (Last 6 Months)';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $months = collect(range(5, 0))->map(fn ($i) => now()->subMonths($i));

        $labels = $months->map(fn ($m) => $m->format('M Y'))->toArray();

        $data = $months->map(fn ($m) => User::where('role', 'test_taker')
            ->whereYear('created_at', $m->year)
            ->whereMonth('created_at', $m->month)
            ->count()
        )->toArray();

        return [
            'datasets' => [
                [
                    'label'           => 'New Students',
                    'data'            => $data,
                    'fill'            => true,
                    'backgroundColor' => 'rgba(59,130,246,0.1)',
                    'borderColor'     => '#3b82f6',
                    'tension'         => 0.4,
                    'pointRadius'     => 5,
                    'pointBackgroundColor' => '#3b82f6',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
