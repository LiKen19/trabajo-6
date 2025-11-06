<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Admin Principal',
                'email' => 'admin@biblioteca.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'María García',
                'email' => 'maria@biblioteca.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Carlos Rodríguez',
                'email' => 'carlos@biblioteca.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Ana López',
                'email' => 'ana@biblioteca.com',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}