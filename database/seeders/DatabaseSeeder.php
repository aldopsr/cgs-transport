<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@CGS.com'],
            [
                'name'     => 'Admin CGS',
                'password' => Hash::make('password123'),
                'role'     => 'admin',
                'nopol'    => 'B 1 CSG',
                'phone'    => '081234567890',
            ]
        );
    }
}