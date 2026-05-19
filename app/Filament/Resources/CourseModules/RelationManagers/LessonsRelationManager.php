<?php

namespace App\Filament\Resources\CourseModules\RelationManagers;

use App\Models\CourseLesson;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LessonsRelationManager extends RelationManager
{
    protected static string $relationship = 'lessons';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(2)->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(1),

                Select::make('type')
                    ->options(CourseLesson::types())
                    ->required()
                    ->reactive()
                    ->columnSpan(1),
            ]),

            Grid::make(1)->schema([
                TextInput::make('content_url')
                    ->label('Source URL (Video/Link)')
                    ->url()
                    ->visible(fn (Get $get) => in_array($get('type'), ['video', 'link', 'audio']))
                    ->placeholder('e.g., https://youtube.com/...'),

                FileUpload::make('file_path')
                    ->label('Upload File (PDF/Audio/Video)')
                    ->disk('public')
                    ->directory('courses/lessons')
                    ->visible(fn (Get $get) => in_array($get('type'), ['pdf', 'audio', 'video']))
                    ->helperText('Upload local files here.'),

                RichEditor::make('text_content')
                    ->label('Lesson Content (Text/Article)')
                    ->visible(fn (Get $get) => $get('type') === 'text')
                    ->columnSpanFull(),

                Select::make('exam_id')
                    ->label('Select Quiz/Exam')
                    ->relationship('exam', 'title')
                    ->searchable()
                    ->preload()
                    ->visible(fn (Get $get) => $get('type') === 'quiz')
                    ->required(fn (Get $get) => $get('type') === 'quiz')
                    ->helperText('Select an Exam to use as a quiz for this lesson.')
                    ->columnSpan(1),

                TextInput::make('passing_score')
                    ->label('Passing Grade')
                    ->numeric()
                    ->visible(fn (Get $get) => $get('type') === 'quiz')
                    ->required(fn (Get $get) => $get('type') === 'quiz')
                    ->helperText('Minimum score to proceed to the next lesson (0-100).')
                    ->columnSpan(1),
            ]),

            Grid::make(3)->schema([
                TextInput::make('duration_minutes')
                    ->label('Est. Duration (Min)')
                    ->numeric()
                    ->placeholder('15'),

                Toggle::make('is_previewable')
                    ->label('Previewable')
                    ->helperText('Can be viewed without enrollment (Free Lesson).')
                    ->default(false),
            ]),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('order_position')
                    ->label('#')
                    ->sortable(),
                
                TextColumn::make('title')
                    ->label('Lesson Title')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'video' => 'danger',
                        'pdf'   => 'warning',
                        'text'  => 'success',
                        'audio' => 'info',
                        'quiz'  => 'primary',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => CourseLesson::types()[$state] ?? $state),

                TextColumn::make('duration_minutes')
                    ->label('Duration')
                    ->suffix(' min'),

                IconColumn::make('is_previewable')
                    ->label('Free')
                    ->boolean(),
            ])
            ->defaultSort('order_position', 'asc')
            ->reorderable('order_position')
            ->headerActions([
                CreateAction::make()->label('Add Lesson'),
            ])
            ->recordActions([
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
