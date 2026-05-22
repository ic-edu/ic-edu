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
                //
            ])
            ->headerActions([
                //
            ])
            ->actions([
                ViewAction::make()->label('Detail'),
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
