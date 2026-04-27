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
        User::create([
            'name' => 'Admin CGS',
            'email' => 'admin@CGS.com',
            'password' => Hash::make('password'), 
            'role' => 'admin',
            'phone' => '081234567890',
        ]);

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