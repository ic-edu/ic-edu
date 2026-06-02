<?php

namespace App\Filament\Resources\Vouchers\Pages;

use App\Filament\Resources\Vouchers\VoucherResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateVoucher extends CreateRecord
{
    protected static string $resource = VoucherResource::class;

    public function getMaxContentWidth(): Width | string | null
    {
        return Width::Full;
    }
}
