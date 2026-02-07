<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Bikin Akun Admin
        User::create([
            'name' => 'Admin CGS',
            'email' => 'admin@cgs.com',
            'password' => Hash::make('password'), // Password-nya 'password'
            'role' => 'admin',
            'phone' => '081234567890',
        ]);

        // 2. Bikin 1 Contoh Driver (Biar gak capek register manual)
        User::create([
            'name' => 'Budi Driver',
            'email' => 'budi@driver.com',
            'password' => Hash::make('password'),
            'role' => 'driver',
            'nopol' => 'B 1234 CD',
            'phone' => '08987654321',
        ]);
    }
}