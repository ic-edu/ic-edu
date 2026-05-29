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
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\ExportAction;
use App\Filament\Exports\ExamAttemptExporter;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Table;
use App\Models\User;
use App\Enums\ExamAttemptStatus;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExamNeedsGradingMail;

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
                    ->color(fn(string $state): string => match ($state) {
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
                    ->options(fn() => User::where('role', 'examiner')->pluck('name', 'id'))
                    ->disabled(fn($record) => $record->status === ExamAttemptStatus::GRADED->value)
                    ->afterStateUpdated(function ($record, $state) {
                        $examiner = User::find($state);
                        if (
                            $examiner &&
                            $record->status === ExamAttemptStatus::FINISHED->value
                        ) {
                            Mail::to($examiner->email)->send(
                                new ExamNeedsGradingMail(
                                    $record->fresh(['user', 'exam.examType']),
                                    $examiner
                                )
                            );
                        }
                    })
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
            ->headerActions([
                ExportAction::make()
                    ->exporter(ExamAttemptExporter::class)
                    ->columnMapping(false)
                    ->form([
                        DatePicker::make('started_from')->label('Started From'),
                        DatePicker::make('started_until')->label('Started Until'),
                    ])
                    ->modifyQueryUsing(function (Builder $query, array $data) {
                        if (!empty($data['started_from'])) {
                            $query->whereDate('started_at', '>=', $data['started_from']);
                        }
                        if (!empty($data['started_until'])) {
                            $query->whereDate('started_at', '<=', $data['started_until']);
                        }
                    }),
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
                                ->options(fn() => User::where('role', 'examiner')->pluck('name', 'id'))
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $examiner = User::find($data['examiner_id']);

                            foreach ($records as $record) {
                                if ($record->status === ExamAttemptStatus::FINISHED->value) {
                                    $record->update([
                                        'examiner_id' => $data['examiner_id'],
                                    ]);

                                    if ($examiner) {
                                        Mail::to($examiner->email)->send(
                                            new ExamNeedsGradingMail(
                                                $record->fresh(['user', 'exam.examType']),
                                                $examiner
                                            )
                                        );
                                    }
                                }
                            }
                        })
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
