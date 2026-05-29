<?php

namespace App\Filament\Resources\ExamAttempts;

use App\Filament\Resources\ExamAttempts\Pages\CreateExamAttempt;
use App\Filament\Resources\ExamAttempts\Pages\EditExamAttempt;
use App\Filament\Resources\ExamAttempts\Pages\ListExamAttempts;
use App\Filament\Resources\ExamAttempts\Schemas\ExamAttemptForm;
use App\Filament\Resources\ExamAttempts\Tables\ExamAttemptsTable;
use App\Models\ExamAttempt;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExamAttemptResource extends Resource
{
    protected static ?string $model = ExamAttempt::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationLabel = 'Exam Assignments';
    protected static ?string $modelLabel = 'Exam Assignment';
    protected static ?string $pluralModelLabel = 'Exam Assignments';
    protected static string|\UnitEnum|null $navigationGroup = 'Management';
    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return ExamAttemptForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExamAttemptsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListExamAttempts::route('/'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
