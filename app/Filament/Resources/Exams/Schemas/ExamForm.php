<?php

namespace App\Filament\Resources\Exams\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class ExamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Information')
                    ->description('Detail about the exam.')
                    ->schema([
                        Select::make('exam_type_id')
                            ->label('Exam Type')
                            ->relationship('exam_type', 'name')
                            ->required()
                            ->preload()
                            ->searchable(),

                        TextInput::make('title')
                            ->label('Title')
                            ->placeholder('Contoh: TOEIC Simulation Vol. 1')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('duration_minutes')
                            ->label('Duration (Minutes)')
                            ->numeric()
                            ->required()
                            ->default(120)
                            ->suffix('Minutes'),

                        Toggle::make('is_active')
                            ->label('Active')
                            ->helperText('If enabled, students can see and take this exam.')
                            ->default(true),
                    ])->columns(1),
            ]);
    }
}
