<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        User::create([
            'name' => 'ADMIN DEALER',
            'email' => 'admin@mitsubishi.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

    }
}