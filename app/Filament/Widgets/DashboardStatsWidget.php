<?php

namespace App\Filament\Widgets;

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Question;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsWidget extends BaseWidget
{
    // Properti ini mengatur urutan kemunculan widget. Angka kecil -> muncul paling atas.
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Peserta', User::where('role', 'test_taker')->count())
                ->description('Jumlah seluruh test taker yang terdaftar')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),
            Stat::make('Total Ujian', Exam::count())
                ->description('Jumlah ujian yang telah dibuat')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),
            Stat::make('Total Soal Ujian', Question::count())
                ->description('Total soal yang ada di bank soal')
                ->descriptionIcon('heroicon-m-question-mark-circle')
                ->color('info'),
            Stat::make('Total Pengerjaan Ujian', ExamAttempt::count())
                ->description('Riwayat partisipasi dari semua ujian')
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color('warning'),
        ];
    }
}
