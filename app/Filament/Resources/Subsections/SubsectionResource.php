<?php

namespace App\Filament\Resources\Subsections;

use App\Filament\Resources\SubsectionResource\RelationManagers\QuestionGroupsRelationManager;
use App\Filament\Resources\Subsections\Pages\CreateSubsection;
use App\Filament\Resources\Subsections\Pages\EditSubsection;
use App\Filament\Resources\Subsections\Pages\ListSubsections;
use App\Filament\Resources\Subsections\Schemas\SubsectionForm;
use App\Filament\Resources\Subsections\Tables\SubsectionsTable;
use App\Models\Subsection;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubsectionResource extends Resource
{
    protected static ?string $model = Subsection::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $recordTitleAttribute = 'no';

    public static function form(Schema $schema): Schema
    {
        return SubsectionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubsectionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            QuestionGroupsRelationManager::class, 
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSubsections::route('/'),
            'create' => CreateSubsection::route('/create'),
            'edit' => EditSubsection::route('/{record}/edit'),
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
