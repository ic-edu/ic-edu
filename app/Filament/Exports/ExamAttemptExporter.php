<?php

namespace App\Filament\Exports;

use App\Models\ExamAttempt;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class ExamAttemptExporter extends Exporter
{
    protected static ?string $model = ExamAttempt::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('user.name')->label('Test Taker'),
            ExportColumn::make('exam.title')->label('Exam Name'),
            ExportColumn::make('started_at')->label('Started At'),
            ExportColumn::make('submitted_at')->label('Submitted At'),
            ExportColumn::make('status')->label('Status'),
            ExportColumn::make('converted_score')->label('Final Score'),
            ExportColumn::make('is_passed')->label('Passed'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your exam attempt export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
