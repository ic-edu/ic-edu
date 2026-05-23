<?php

namespace App\Filament\Resources\Exams\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Actions\BulkAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\ExportAction;
use App\Filament\Exports\ExamAttemptExporter;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use App\Models\User;
use App\Enums\ExamAttemptStatus;

class AttemptsRelationManager extends RelationManager
{
    protected static string $relationship = 'attempts';
    protected static ?string $title = 'Exam Attempts (Test Takers)';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('converted_score')
                    ->label('Final Score')
                    ->numeric(),
                TextInput::make('status'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Test Taker')
                    ->searchable(),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        ExamAttemptStatus::FINISHED->value => 'warning',
                        ExamAttemptStatus::GRADED->value => 'success',
                        default => 'gray',
                    }),
                SelectColumn::make('examiner_id')
                    ->label('Assign Examiner')
                    ->options(fn () => User::where('role', 'examiner')->pluck('name', 'id'))
                    ->disabled(fn ($record) => $record->status === ExamAttemptStatus::GRADED->value)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('converted_score')
                    ->label('Final Score')
                    ->sortable(),
                TextColumn::make('started_at')
                    ->label('Started At')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                TextColumn::make('submitted_at')
                    ->label('Submitted At')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        ExamAttemptStatus::FINISHED->value => 'Waiting for Grading',
                        ExamAttemptStatus::GRADED->value => 'Graded',
                    ]),
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
            ->actions([
                ViewAction::make()->label('View Details'),
                DeleteAction::make()->label('Delete Attempt'),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
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
                                if ($record->status === ExamAttemptStatus::FINISHED->value) {
                                    $record->update(['examiner_id' => $data['examiner_id']]);
                                }
                            }
                        })
                        ->deselectRecordsAfterCompletion(),
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
