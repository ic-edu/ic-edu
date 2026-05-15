<?php

namespace App\Filament\Resources\Exams\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Schemas\Schema;

class AttemptsRelationManager extends RelationManager
{
    protected static string $relationship = 'attempts';
    protected static ?string $title = 'Exam Reports (Peserta)';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('total_score')
                    ->label('Total Nilai')
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
                    ->label('Nama Peserta')
                    ->searchable(),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'finished' => 'success',
                        'in_progress' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('total_score')
                    ->label('Total Nilai')
                    ->sortable(),
                TextColumn::make('started_at')
                    ->label('Waktu Mulai')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                TextColumn::make('finished_at')
                    ->label('Waktu Selesai')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                // Anda dapat menambahkan filter rentang nilai atau status di sini
            ])
            ->headerActions([
                // Sengaja dikosongkan karena Admin tidak bisa membuat riwayat ujian palsu
            ])
            ->actions([
                ViewAction::make()->label('Detail'),
                DeleteAction::make()->label('Hapus Riwayat'),
            ]);
    }
}
