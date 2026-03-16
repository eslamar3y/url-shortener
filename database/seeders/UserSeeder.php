<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'role'     => 'admin',
        ]);

        // User عادي
        User::create([
            'name'     => 'Eslam',
            'email'    => 'eslam@test.com',
            'password' => Hash::make('12345678'),
            'role'     => 'user',
        ]);
    }
}