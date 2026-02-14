<?php

namespace App\Filament\Resources\Sections\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class SectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('exam_id')
                    ->relationship('exam', 'title') 
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('title')
                    ->label('Title Section')
                    ->placeholder('Example: Section Photography Basics')
                    ->required(),

                Textarea::make('instructions')
                    ->label('Instructions Section')
                    ->rows(3),
            ]);
    }
}
