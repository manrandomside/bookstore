<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin Bookstore',
            'email' => 'admin@bookstore.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => 1,
        ]);

        User::create([
            'name' => 'Firman Fadilah',
            'email' => 'firmanfdlh1@gmail.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'is_active' => 1,
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'is_active' => 1,
        ]);

        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@gmail.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'is_active' => 1,
        ]);

        User::create([
            'name' => 'Roni Wijaya',
            'email' => 'roni@gmail.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'is_active' => 1,
        ]);
    }
}