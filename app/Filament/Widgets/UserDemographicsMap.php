<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\Widget;

class UserDemographicsMap extends Widget
{
    protected string $view = 'filament.widgets.user-demographics-map';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function getLocations(): array
    {
        return User::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->select('name', 'city', 'latitude', 'longitude')
            ->get()
            ->toArray();
    }
}
