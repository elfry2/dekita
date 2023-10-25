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
                'username' => 'admin',
                'email' => 'admin@localhost',
                'password' => 'admin@localhost',
                'role_id' => 1
            ],
            [
                'name' => 'User',
                'username' => 'user',
                'email' => 'user@localhost',
                'password' => 'user@localhost',
                'role_id' => 2
            ],
        ];

        foreach($users as $user) {
            User::create($user);
        }

        User::factory(62)->create();
    }
}
