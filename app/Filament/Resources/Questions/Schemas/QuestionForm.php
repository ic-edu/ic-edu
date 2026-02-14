<?php

namespace App\Filament\Resources\Questions\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section as FormSection;

class QuestionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            FormSection::make('Question Details')
                ->columnSpanFull()
                ->schema([
                    Select::make('section_id')
                        ->relationship('section', 'title')
                        ->required()
                        ->searchable()
                        ->preload(),

                    Select::make('type')
                        ->options([
                            'multiple_choice' => 'Multiple Choice',
                            'essay' => 'Essay',
                            'audio_record' => 'Audio Recording',
                            'short_answer' => 'Short Answer',
                        ])
                        ->default('multiple_choice')
                        ->required()
                        ->reactive(),
                ])->columns(2),

            FormSection::make('Question Content')
                ->columnSpanFull()
                ->schema([
                    FileUpload::make('media_path')
                        ->label('Media (Audio/Picture)')
                        ->image()
                        ->directory('questions-media')
                        ->visibility('public')
                        ->disk('public')
                        ->acceptedFileTypes(['audio/mpeg', 'audio/wav', 'image/jpeg', 'image/png'])
                        ->maxSize(14048),

                    RichEditor::make('question_text')
                        ->label('Question Text')
                        ->hint('You can include text formatting here'),
                ]),

            FormSection::make('Answer Options')
                ->columnSpanFull()
                ->description('Define the answer options for multiple choice questions.')
                ->schema([
                    Repeater::make('options')
                        ->relationship('options')
                        ->schema([
                            TextInput::make('option_text')
                                ->label('Option Text')
                                ->required(),
                            Toggle::make('is_correct')
                                ->label('Is Correct Answer')
                                ->onColor('success'),
                        ])
                        ->columns(2)
                        ->defaultItems(4)
                        ->addActionLabel('Add Option')
                ])
                ->visible(fn($get) => $get('type') === 'multiple_choice'),
        ]);
    }
}
