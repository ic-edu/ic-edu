<?php

namespace App\Filament\Widgets;

use App\Models\CourseEnrollment;
use App\Models\ExamAttempt;
use App\Models\User;
use App\Enums\ExamAttemptStatus;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentActivityWidget extends BaseWidget
{
    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::with(['courseEnrollments.course'])
                    ->where('role', 'test_taker')
                    ->latest()
                    ->limit(8)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Student')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->color('gray'),

                Tables\Columns\TextColumn::make('city')
                    ->label('Location')
                    ->default('—')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('course_enrollments_count')
                    ->label('Courses Enrolled')
                    ->counts('courseEnrollments')
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Joined')
                    ->since()
                    ->color('gray'),
            ])
            ->paginated(false);
    }
}
