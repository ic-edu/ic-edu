<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            TextInput::make('title')
                ->label('Course Title')
                ->required()
                ->maxLength(255)
                ->placeholder('e.g., TOEFL Preparation Course'),

            Select::make('target_level')
                ->label('Target Level')
                ->options([
                    'Beginner'     => '🟢 Beginner',
                    'Intermediate' => '🟡 Intermediate',
                    'Advanced'     => '🔴 Advanced',
                ])
                ->searchable()
                ->nullable(),

            Toggle::make('is_published')
                ->label('Published')
                ->default(false)
                ->helperText('Only published courses are visible to students.'),

            FileUpload::make('thumbnail_path')
                ->label('Thumbnail Image')
                ->image()
                ->disk('public')
                ->directory('courses/thumbnails')
                ->imagePreviewHeight('200')
                ->panelAspectRatio('16:9')
                ->panelLayout('integrated')
                ->nullable()
                ->columnSpanFull(),

            RichEditor::make('description')
                ->label('Course Description')
                ->toolbarButtons([
                    'bold', 'italic', 'underline', 'strike',
                    'bulletList', 'orderedList', 'link',
                    'h2', 'h3', 'blockquote',
                ])
                ->nullable()
                ->columnSpanFull(),
        ]);
    }
}
