<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@localhost',
                'password' => 'admin@localhost',
                'role_id' => 1
            ],
            [
                'name' => 'User',
                'email' => 'user@localhost',
                'password' => 'user@localhost',
                'role_id' => 2
            ],
        ];

        foreach($users as $user) {
            User::create($user);
        }
    }
}
