<?php

namespace App\Filament\Resources\TokenTransactions;

use App\Filament\Resources\TokenTransactions\Pages\CreateTokenTransaction;
use App\Filament\Resources\TokenTransactions\Pages\EditTokenTransaction;
use App\Filament\Resources\TokenTransactions\Pages\ListTokenTransactions;
use App\Filament\Resources\TokenTransactions\Pages\ViewTokenTransaction;
use App\Filament\Resources\TokenTransactions\Schemas\TokenTransactionForm;
use App\Filament\Resources\TokenTransactions\Schemas\TokenTransactionInfolist;
use App\Filament\Resources\TokenTransactions\Tables\TokenTransactionsTable;
use App\Models\TokenTransaction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TokenTransactionResource extends Resource
{
    protected static ?string $model = TokenTransaction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Banknotes;

    protected static \UnitEnum|string|null $navigationGroup = 'Financial & Revenue';

    public static function canViewAny(): bool
    {
        return auth()->user()->isSuperAdmin();
    }

    public static function form(Schema $schema): Schema
    {
        return TokenTransactionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TokenTransactionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TokenTransactionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTokenTransactions::route('/'),
            'view' => ViewTokenTransaction::route('/{record}'),
        ];
    }
}
