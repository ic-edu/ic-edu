<?php

namespace App\Filament\Resources\Exams\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ExamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([ 
            Select::make('exam_type_id')
                ->label('Exam Type')
                ->relationship('examType', 'name')
                ->required()
                ->searchable()
                ->preload(),

            TextInput::make('title')
                ->required()
                ->maxLength(255),

            TextInput::make('total_duration')
                ->label('Total Duration (Minutes)')
                ->numeric()
                ->required(),

            TextInput::make('tokens_required')
                ->label('Tokens Required to Unlock')
                ->numeric()
                ->default(1)
                ->minValue(0)
                ->required(),

            Select::make('mode')
                ->label('Exam Mode')
                ->options([
                    'practice' => 'Practice (Full Navigation)',
                    'strict' => 'Strict (No Navigation, One-Time Audio)',
                ])
                ->default('practice')
                ->required(),

            Toggle::make('is_active')
                ->required()
                ->default(true),

            Toggle::make('is_public')
                ->label('Show in Main Menu (Standalone)')
                ->helperText('Disable if this exam is intended only for Quizzes within an LMS Course.')
                ->default(true),
        ]);
    }
}
