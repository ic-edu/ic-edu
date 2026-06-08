<?php

namespace App\Filament\Resources\TokenTransactions\Pages;

use App\Filament\Resources\TokenTransactions\TokenTransactionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTokenTransactions extends ListRecords
{
    protected static string $resource = TokenTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('manage_pricing')
                ->label('App Setting Token')
                ->icon('heroicon-o-cog-8-tooth')
                ->color('primary')
                ->fillForm([
                    'token_price_per_unit'  => \App\Models\Setting::get('token_price_per_unit', '99000'),
                    'token_package_3_price' => \App\Models\Setting::get('token_package_3_price', '249000'),
                    'token_package_5_price' => \App\Models\Setting::get('token_package_5_price', '399000'),
                ])
                ->form([
                    \Filament\Schemas\Components\Grid::make(3)
                        ->components([
                            \Filament\Forms\Components\TextInput::make('token_price_per_unit')
                                ->label('Price per 1 Token (IDR)')
                                ->helperText('Base price for a single token.')
                                ->prefix('Rp')
                                ->numeric()
                                ->minValue(0)
                                ->required(),

                            \Filament\Forms\Components\TextInput::make('token_package_3_price')
                                ->label('Price for 3 Tokens (IDR)')
                                ->helperText('Leave empty / 0 = base price × 3.')
                                ->prefix('Rp')
                                ->numeric()
                                ->minValue(0)
                                ->required(),

                            \Filament\Forms\Components\TextInput::make('token_package_5_price')
                                ->label('Price for 5 Tokens (IDR)')
                                ->helperText('Leave empty / 0 = base price × 5.')
                                ->prefix('Rp')
                                ->numeric()
                                ->minValue(0)
                                ->required(),
                        ]),
                ])
                ->action(function (array $data): void {
                    \App\Models\Setting::set('token_price_per_unit',  $data['token_price_per_unit']);
                    \App\Models\Setting::set('token_package_3_price', $data['token_package_3_price']);
                    \App\Models\Setting::set('token_package_5_price', $data['token_package_5_price']);
                })
                ->successNotificationTitle('Token settings saved successfully!'),
        ];
    }
}
