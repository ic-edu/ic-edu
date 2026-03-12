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

            Toggle::make('is_active')
                ->required()
                ->default(true),
        ]);
    }
}
