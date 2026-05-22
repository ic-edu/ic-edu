<?php

namespace App\Filament\Resources\ExamAttempts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\BulkAction;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Table;
use App\Models\User;
use App\Enums\ExamAttemptStatus;

class ExamAttemptsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Test Taker')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('exam.title')
                    ->label('Exam')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('started_at')
                    ->label('Started At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('submitted_at')
                    ->label('Submitted At')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        ExamAttemptStatus::FINISHED->value => 'warning',
                        ExamAttemptStatus::GRADED->value => 'success',
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('converted_score')
                    ->label('Final Score')
                    ->numeric()
                    ->sortable(),
                SelectColumn::make('examiner_id')
                    ->label('Assign Examiner')
                    ->options(fn () => User::where('role', 'examiner')->pluck('name', 'id'))
                    ->disabled(fn ($record) => $record->status === ExamAttemptStatus::GRADED->value)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        ExamAttemptStatus::FINISHED->value => 'Waiting for Grading (FINISHED)',
                        ExamAttemptStatus::GRADED->value => 'Graded',
                    ])
                    ->default(ExamAttemptStatus::FINISHED->value),
                TrashedFilter::make(),
            ])
            ->recordActions([
                // Removed EditAction
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('assign_examiner')
                        ->label('Assign Examiner (Bulk)')
                        ->icon('heroicon-o-user-plus')
                        ->color('success')
                        ->form([
                            Select::make('examiner_id')
                                ->label('Select Examiner')
                                ->options(fn () => User::where('role', 'examiner')->pluck('name', 'id'))
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            foreach ($records as $record) {
                                // Only assign if it's FINISHED (Waiting for Grading)
                                if ($record->status === ExamAttemptStatus::FINISHED->value) {
                                    $record->update(['examiner_id' => $data['examiner_id']]);
                                }
                            }
                        })
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
