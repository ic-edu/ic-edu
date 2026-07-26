<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Super Administrator',
            'email' => 'ic.edu.bdg@gmail.com',
            'password' => bcrypt('superadmin2026'),
            'role' => 'superadmin',
            'tokens' => 999,
        ]);

        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'ic.edu.bdg@gmail.com',
            'password' => bcrypt('admin2026'),
            'role' => 'admin',
            'tokens' => 999,
        ]);
        $this->call(ExamTypesTableSeeder::class);
        $this->call(SubsectionsTableSeeder::class);
        $this->call(ExamTypesContentSeeder::class);
        $this->call(SettingsSeeder::class);
    }
}
