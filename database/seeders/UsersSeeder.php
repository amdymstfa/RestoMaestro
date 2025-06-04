<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Admin Manager',
                'email' => 'admin@resto.com',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Waiter John',
                'email' => 'waiter@resto.com',
                'password' => Hash::make('password'),
                'role' => 'waiter',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Client Alice',
                'email' => 'client@resto.com',
                'password' => Hash::make('password'),
                'role' => 'client',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
