<?php

namespace App\Filament\Resources\ExamTypes\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ExamTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

            // ─── Basic Information ─────────────────────────────────────────
            Section::make('Basic Information')
                ->schema([
                    TextInput::make('name')
                        ->label('Exam Type Name')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->placeholder('e.g. TOEIC, IELTS, TOEFL iBT'),

                    Textarea::make('description')
                        ->label('Description')
                        ->maxLength(65535)
                        ->rows(3)
                        ->columnSpanFull(),
                ])->columns(2),

            // ─── Scoring Configuration ─────────────────────────────────────
            Section::make('Scoring Configuration')
                ->description('The system uses a proportional formula: (points earned ÷ total points) × Max Score, then rounded to the nearest Rounding Step.')
                ->schema([
                    TextInput::make('max_score')
                        ->label('Maximum Score')
                        ->required()
                        ->numeric()
                        ->default(100)
                        ->minValue(1)
                        ->helperText('TOEIC = 990 | IELTS = 9 | TOEFL iBT = 120 | General = 100'),

                    TextInput::make('passing_score')
                        ->label('Passing Score')
                        ->numeric()
                        ->nullable()
                        ->helperText('Leave blank if there is no passing threshold.'),

                    TextInput::make('rounding_step')
                        ->label('Rounding Step')
                        ->required()
                        ->numeric()
                        ->default(1)
                        ->minValue(0.01)
                        ->step(0.01)
                        ->helperText('TOEIC = 5 (→745, 750…) | IELTS = 0.5 (→7.0, 7.5…) | General = 1'),

                    TextInput::make('min_score')
                        ->label('Minimum Total Score')
                        ->numeric()
                        ->default(0)
                        ->minValue(0)
                        ->helperText('Floor score even if no answers are correct. TOEIC = 10, others = 0.'),

                    TextInput::make('section_min_score')
                        ->label('Minimum Score Per Section')
                        ->numeric()
                        ->default(0)
                        ->minValue(0)
                        ->helperText('Floor score per section. TOEIC = 5, others = 0.'),

                    Toggle::make('show_section_scores')
                        ->label('Show Per-Section Scores')
                        ->helperText('Enable for TOEIC/TOEFL to display Listening, Reading, etc. scores separately on results.')
                        ->default(false),
                ])->columns(2),

        ])->columns(1);
    }
}
