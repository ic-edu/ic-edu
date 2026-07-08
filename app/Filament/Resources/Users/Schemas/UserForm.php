<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->required(),
                Select::make('role')
                    ->options(['examiner' => 'Examiner', 'test_taker' => 'Test taker', 'admin' => 'Admin', 'superadmin' => 'Super Admin'])
                    ->default('test_taker')
                    ->disabled(fn () => !auth()->user()->isSuperAdmin())
                    ->required(),
                TextInput::make('tokens')
                    ->label('Universal Tokens')
                    ->numeric()
                    ->default(0)
                    ->disabled(fn () => !auth()->user()->isSuperAdmin())
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),
            ]);
    }
}
