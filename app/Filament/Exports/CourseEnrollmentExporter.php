<?php

namespace App\Filament\Exports;

use App\Models\CourseEnrollment;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class CourseEnrollmentExporter extends Exporter
{
    protected static ?string $model = CourseEnrollment::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('user.name')->label('Participant Name'),
            ExportColumn::make('course.title')->label('Course Name'),
            ExportColumn::make('status')->label('Status'),
            ExportColumn::make('enrolled_at')->label('Enrolled At'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your course enrollment export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
