<?php

namespace App\Filament\Resources\Subsections\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class QuestionGroupsRelationManager extends RelationManager
{
    protected static string $relationship = 'questionGroups';
    protected static ?string $title = 'Question Groups & Questions';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Group Context (Optional)')
                    ->description('Provide context for the group of questions, such as a reading passage or listening transcript.')
                    ->schema([
                        TextInput::make('title')
                            ->label('Group Title (Optional)')
                            ->maxLength(255),
                        TextInput::make('order_position')
                            ->label('Group Order')
                            ->numeric()
                            ->default(1)
                            ->required(),
                        Select::make('group_type')
                            ->label('Layout Type')
                            ->required()
                            ->default('default')
                            ->options([
                                'default' => 'Default — Stacked (media on top, questions below)',
                                'split'   => 'Split — Side by Side (passage/image left, questions right)',
                            ])
                            ->helperText('Use "Split" for long reading passages (TOEIC Part 7, TOEFL Reading). Use "Default" for everything else.')
                            ->columnSpanFull(),
                        Textarea::make('instruction')
                            ->label('Instructions (Optional)')
                            ->placeholder('E.g., "Answer the following questions based on the passage."')
                            ->columnSpanFull(),
                        RichEditor::make('passage_text')
                            ->label('Passage Text')
                            ->helperText('Supports basic formatting: Bold, Italic, paragraphs, and bullet lists.')
                            ->toolbarButtons([
                                'bold', 'italic', 'underline',
                                'bulletList', 'orderedList',
                                'redo', 'undo',
                            ])
                            ->columnSpanFull(),
                        Grid::make(2)->schema([
                            FileUpload::make('audio_path')
                                ->label('Audio File')
                                ->directory('questions/audios')
                                ->visibility('public')
                                ->disk('public')
                                ->acceptedFileTypes(['audio/mpeg', 'audio/wav'])
                                ->maxSize(14048),
                            FileUpload::make('image_path')
                                ->label('Image File')
                                ->directory('questions/images')
                                ->visibility('public')
                                ->disk('public')
                                ->acceptedFileTypes(['image/jpeg', 'image/png'])
                                ->maxSize(10048),
                        ])
                    ])
                    ->collapsible(),

                Section::make('Questions')
                    ->schema([
                        Repeater::make('questions')
                            ->relationship()
                            ->schema([
                                Grid::make(2)->schema([
                                    Select::make('type')
                                        ->options([
                                            'multiple_choice' => 'Multiple Choice',
                                            'essay' => 'Essay',
                                            'short_answer' => 'Short Answer',
                                            'record' => 'Voice Record',
                                        ])->default('multiple_choice')->required()->live(),

                                    TextInput::make('points')->numeric()->default(1)->required(),
                                ]),

                                Grid::make(2)
                                    ->schema([
                                        FileUpload::make('audio_path')
                                            ->label('Audio File')
                                            ->directory('questions/audios')
                                            ->visibility('public')
                                            ->disk('public')
                                            ->acceptedFileTypes(['audio/mpeg', 'audio/wav'])
                                            ->maxSize(14048),

                                        FileUpload::make('image_path')
                                            ->label('Image File')
                                            ->directory('questions/images')
                                            ->visibility('public')
                                            ->disk('public')
                                            ->acceptedFileTypes(['image/jpeg', 'image/png'])
                                            ->maxSize(10048),
                                    ]),

                                RichEditor::make('question_text')->label('Question Text')->required()->columnSpanFull(),

                                Repeater::make('options')
                                    ->relationship()
                                    ->schema([
                                        TextInput::make('option_text')->required()->label('Option Text (A/B/C/D)'),
                                        Toggle::make('is_correct')->label('Correct Answer')->inline(false),
                                    ])
                                    ->columns(2)
                                    ->itemLabel(fn(array $state): ?string => $state['option_text'] ?? null)
                                    ->addActionLabel('Add Option')
                                    ->columnSpanFull()
                                    ->defaultItems(4)
                                    ->visible(fn(Get $get): bool => $get('type') === 'multiple_choice'),
                            ])
                            ->itemLabel(fn(array $state): ?string => 'Question ' . ($state['order_position'] ?? 'New'))
                            ->addActionLabel('Add New Question in Group')
                            ->columnSpanFull()
                            ->orderColumn('order_position')
                            ->collapsed()
                            ->cloneable(),
                    ])
                    ->collapsible()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')->label('Group')->default('Ungrouped'),
                TextColumn::make('questions_count')
                    ->counts('questions')
                    ->label('Total Questions')
                    ->badge(),
            ])
            ->defaultSort('order_position', 'asc')
            ->reorderable('order_position')
            ->headerActions([
                CreateAction::make()
                    ->label('Add New Question')
                    ->modalWidth('7xl'),
            ])
            ->actions([
                EditAction::make('edit_group')
                    ->label('Edit Group & Questions')
                    ->modalWidth('7xl'),
                DeleteAction::make('delete_group')->label('Delete Group & Questions'),
            ]);
    }
}
