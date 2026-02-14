<?php

namespace App\Filament\Resources\Questions\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class QuestionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('section.title')
                    ->label('Section/Part')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->badge(),

                TextColumn::make('question_text')
                    ->limit(50)
                    ->html(), 

                TextColumn::make('options_count')
                    ->counts('options')
                    ->label('Options'),
            ])
            ->filters([
                SelectFilter::make('section_id')
                    ->relationship('section', 'title'),
            ]);
    }
}
