<?php

namespace App\Filament\Resources\ExamTypes\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class ExamTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required() 
                    ->maxLength(255),

                Textarea::make('description')
                    ->maxLength(65535),
            ]);
    }
}
