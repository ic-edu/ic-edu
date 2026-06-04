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
            'name' => 'Test Taker',
            'email' => 'testaker@example.com',
            'password' => bcrypt('password'),
            'tokens' => 5,
        ]);

        User::factory()->create([
            'name' => 'Examiner User',
            'email' => 'examiner@example.com',
            'password' => bcrypt('password'),
            'tokens' => 5,
        ]);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'tokens' => 5,
        ]);
        $this->call(ExamTypesTableSeeder::class);
        $this->call(ExamsTableSeeder::class);
        $this->call(SectionsTableSeeder::class);
        $this->call(SubsectionsTableSeeder::class);
        $this->call(QuestionGroupsTableSeeder::class);
        $this->call(QuestionsTableSeeder::class);
        $this->call(QuestionOptionsTableSeeder::class);
        $this->call(ExamTypesContentSeeder::class);
        $this->call(SettingsTableSeeder::class);
    }
}
