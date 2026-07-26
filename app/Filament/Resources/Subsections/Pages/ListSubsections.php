<?php

namespace App\Filament\Resources\Subsections\Pages;

use App\Filament\Resources\Subsections\SubsectionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSubsections extends ListRecords
{
    protected static string $resource = SubsectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
