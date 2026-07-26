<?php

namespace App\Filament\Resources\Vouchers\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class VoucherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Voucher Details')
                    ->components([
                        TextInput::make('code')
                            ->label('Voucher Code')
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->maxLength(255)
                            ->helperText('Unique alphanumeric code (e.g. PROMO-TOEFL).'),
                        
                        TextInput::make('token_amount')
                            ->label('Token Amount')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->helperText('Number of tokens awarded.'),
                        
                        TextInput::make('max_uses')
                            ->label('Max Uses')
                            ->numeric()
                            ->minValue(1)
                            ->helperText('Leave empty for unlimited uses.'),
                        
                        DateTimePicker::make('expires_at')
                            ->label('Expiry Date')
                            ->helperText('When this voucher becomes invalid.'),
                        
                        Toggle::make('is_active')
                            ->label('Active Status')
                            ->default(true)
                            ->required(),
                    ])->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
