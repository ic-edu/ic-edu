<?php

namespace App\Filament\Resources\Subsections\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SubsectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g., Part A: Photographs'),

                Textarea::make('instructions')
                    ->label('Instructions for Subsection')
                    ->maxLength(65535)
                    ->columnSpanFull(),

                FileUpload::make('instruction_audio_path')
                    ->label('Instruction Audio (Optional)')
                    ->directory('instructions/audio')
                    ->acceptedFileTypes(['audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/mp3', 'audio/m4a']),

                FileUpload::make('instruction_image_path')
                    ->label('Instruction Image (Optional)')
                    ->directory('instructions/images')
                    ->image(),
            ]);
    }
}
