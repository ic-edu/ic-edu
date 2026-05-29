<?php

namespace App\Filament\Resources\Courses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CoursesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail_path')
                    ->label('Thumbnail')
                    ->disk('public')
                    ->height(48)
                    ->width(80)
                    ->defaultImageUrl(fn () => 'https://placehold.co/80x48/e2e8f0/64748b?text=No+Image'),

                TextColumn::make('title')
                    ->label('Course Title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('target_level')
                    ->label('Level')
                    ->badge()
                    ->color(fn (array|string|null $state): string => match(is_array($state) ? ($state[0] ?? '') : $state) {
                        'Beginner'     => 'success',
                        'Intermediate' => 'warning',
                        'Advanced'     => 'danger',
                        default        => 'gray',
                    }),

                TextColumn::make('modules_count')
                    ->label('Modules')
                    ->counts('modules')
                    ->sortable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('enrollments_count')
                    ->label('Students')
                    ->counts('enrollments')
                    ->sortable()
                    ->badge()
                    ->color('success'),

                TextColumn::make('price')
                    ->label('Price')
                    ->money('idr')
                    ->sortable(),

                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('target_level')
                    ->options([
                        'Beginner'     => 'Beginner',
                        'Intermediate' => 'Intermediate',
                        'Advanced'     => 'Advanced',
                    ]),
                SelectFilter::make('is_published')
                    ->label('Status')
                    ->options([
                        '1' => 'Published',
                        '0' => 'Draft',
                    ]),
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
