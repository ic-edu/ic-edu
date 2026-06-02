<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use BackedEnum;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.manage-settings';

    protected static ?string $navigationLabel = 'App Settings';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog8Tooth;
    protected static string|\UnitEnum|null $navigationGroup = 'Configuration';
    protected static ?int $navigationSort = 99;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'token_price_per_unit'  => Setting::get('token_price_per_unit', '99000'),
            'token_package_3_price' => Setting::get('token_package_3_price', '249000'),
            'token_package_5_price' => Setting::get('token_package_5_price', '399000'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('💰 Token Pricing')
                    ->description('Set the pricing for exam tokens displayed to users on the Wallet and Pricing pages.')
                    ->components([
                        Grid::make(3)
                            ->components([
                                TextInput::make('token_price_per_unit')
                                    ->label('Price per 1 Token (IDR)')
                                    ->helperText('Base price for a single token.')
                                    ->prefix('Rp')
                                    ->numeric()
                                    ->minValue(0)
                                    ->required(),

                                TextInput::make('token_package_3_price')
                                    ->label('Price for 3 Tokens (IDR)')
                                    ->helperText('Leave empty / 0 = base price × 3.')
                                    ->prefix('Rp')
                                    ->numeric()
                                    ->minValue(0)
                                    ->required(),

                                TextInput::make('token_package_5_price')
                                    ->label('Price for 5 Tokens (IDR)')
                                    ->helperText('Leave empty / 0 = base price × 5.')
                                    ->prefix('Rp')
                                    ->numeric()
                                    ->minValue(0)
                                    ->required(),
                            ]),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        Setting::set('token_price_per_unit',  $state['token_price_per_unit']);
        Setting::set('token_package_3_price', $state['token_package_3_price']);
        Setting::set('token_package_5_price', $state['token_package_5_price']);

        Notification::make()
            ->title('Settings saved!')
            ->body('Token prices have been updated successfully.')
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Settings')
                ->action('save')
                ->color('primary')
                ->icon('heroicon-o-check-circle'),
        ];
    }
}
