<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key'         => 'token_price_per_unit',
                'value'       => '99000',
                'label'       => 'Token Price (per unit)',
                'description' => 'Harga dasar per 1 token ujian dalam Rupiah (IDR). Nilai ini digunakan di halaman wallet dan checkout.',
                'type'        => 'number',
                'group'       => 'pricing',
            ],
            [
                'key'         => 'token_package_3_price',
                'value'       => '249000',
                'label'       => 'Token Package 3 — Price',
                'description' => 'Harga paket 3 token. Biarkan 0 untuk menonaktifkan diskon (gunakan harga per unit × 3).',
                'type'        => 'number',
                'group'       => 'pricing',
            ],
            [
                'key'         => 'token_package_5_price',
                'value'       => '399000',
                'label'       => 'Token Package 5 — Price',
                'description' => 'Harga paket 5 token. Biarkan 0 untuk menonaktifkan diskon (gunakan harga per unit × 5).',
                'type'        => 'number',
                'group'       => 'pricing',
            ],
        ];

        foreach ($settings as $data) {
            Setting::updateOrCreate(
                ['key' => $data['key']],
                $data,
            );
        }
    }
}
