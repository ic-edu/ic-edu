<?php

namespace App\Filament\Resources\ExamAttempts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ExamAttemptForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('exam_id')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('started_at'),
                DateTimePicker::make('submitted_at'),
                TextInput::make('status')
                    ->required()
                    ->default('in_progress'),
                TextInput::make('raw_score')
                    ->numeric(),
                TextInput::make('converted_score')
                    ->numeric(),
                TextInput::make('section_scores'),
                Toggle::make('is_passed'),
                TextInput::make('current_question_id')
                    ->numeric(),
                TextInput::make('examiner_id')
                    ->numeric(),
            ]);
    }
}
