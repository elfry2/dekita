<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Preference;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $seeders = [
            RoleSeeder::class,
            UserSeeder::class,
            PreferenceSeeder::class,
            FolderSeeder::class,
            TaskSeeder::class,
        ];

        foreach($seeders as $seeder) {
            (new $seeder())->run();
        }
    }
}
