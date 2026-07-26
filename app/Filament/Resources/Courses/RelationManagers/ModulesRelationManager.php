<?php

namespace App\Filament\Resources\Courses\RelationManagers;

use App\Filament\Resources\CourseModules\CourseModuleResource;
use App\Models\CourseModule;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ModulesRelationManager extends RelationManager
{
    protected static string $relationship = 'modules';

    public function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('title')
                ->label('Module Title')
                ->required()
                ->maxLength(255)
                ->placeholder('e.g., Module 1: Listening Skills'),

            Textarea::make('description')
                ->label('Description')
                ->maxLength(1000)
                ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('order_position')
                    ->label('#')
                    ->sortable()
                    ->width(50),

                TextColumn::make('title')
                    ->label('Module Title')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('lessons_count')
                    ->label('Lessons')
                    ->counts('lessons')
                    ->badge()
                    ->color('info'),
            ])
            ->defaultSort('order_position', 'asc')
            ->reorderable('order_position')
            ->headerActions([
                CreateAction::make()->label('Add Module'),
            ])
            ->recordActions([
                Action::make('manage_lessons')
                    ->label('Manage Lessons')
                    ->icon('heroicon-m-queue-list')
                    ->color('success')
                    ->url(fn (CourseModule $record): string => CourseModuleResource::getUrl('edit', ['record' => $record->id])),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
