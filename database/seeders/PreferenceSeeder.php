<?php

namespace Database\Seeders;

use App\Models\Preference;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PreferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $preferences = [
            [
                'user_id' => 1,
                'key' => 'theme',
                'value' => 'dark'
            ],
        ];

        foreach($preferences as $preference) {
            Preference::create($preference);
        }
    }
}
