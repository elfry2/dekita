<?php

namespace Database\Seeders;

use App\Models\Folder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $folders = [
            [
                'name' => 'College',
                'description' => 'Assignments go here.',
                'user_id' => 1,
            ],
            [
                'name' => 'Job',
                'description' => 'Web-development-related schedules.',
                'user_id' => 1,
            ],
        ];

        foreach($folders as $folder) Folder::create($folder);
    }
}
