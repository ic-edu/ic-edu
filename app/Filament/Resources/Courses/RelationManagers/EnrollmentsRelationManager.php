<?php

namespace App\Filament\Resources\Courses\RelationManagers;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EnrollmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'enrollments';

    public function form(Schema $schema): Schema
    {
        return $schema->schema([
            Select::make('user_id')
                ->label('Student')
                ->options(fn () => User::where('role', 'test_taker')->pluck('name', 'id'))
                ->searchable()
                ->required(),

            Select::make('status')
                ->options([
                    'active'    => '🟢 Active',
                    'graduated' => '🎓 Graduated',
                    'dropped'   => '🔴 Dropped',
                ])
                ->default('active')
                ->required(),

            DateTimePicker::make('enrolled_at')
                ->label('Enrolled At')
                ->default(now())
                ->nullable(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Student Name')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->color('gray'),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active'    => 'success',
                        'graduated' => 'info',
                        'dropped'   => 'danger',
                        default     => 'gray',
                    }),

                TextColumn::make('enrolled_at')
                    ->label('Enrolled At')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'active'    => 'Active',
                        'graduated' => 'Graduated',
                        'dropped'   => 'Dropped',
                    ]),
            ])
            ->headerActions([
                CreateAction::make()->label('Enroll Student'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()->label('Remove'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Remove Selected'),
                ]),
            ])
            ->defaultSort('enrolled_at', 'desc');
    }
}
