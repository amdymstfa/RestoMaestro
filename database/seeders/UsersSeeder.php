<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // Manager
        User::create([
            'name' => 'Manager Principal',
            'email' => 'manager@restomaestro.com',
            'phone' => '0123456789',
            'role' => 'manager',
            'password' => Hash::make('password123'),
        ]);

        // Serveurs
        User::create([
            'name' => 'Marie Dupont',
            'email' => 'marie@restomaestro.com',
            'phone' => '0123456790',
            'role' => 'waiter',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Pierre Martin',
            'email' => 'pierre@restomaestro.com',
            'phone' => '0123456791',
            'role' => 'waiter',
            'password' => Hash::make('password123'),
        ]);

        // Cuisiniers
        User::create([
            'name' => 'Chef Antoine',
            'email' => 'antoine@restomaestro.com',
            'phone' => '0123456792',
            'role' => 'cook',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Sophie Cuisine',
            'email' => 'sophie@restomaestro.com',
            'phone' => '0123456793',
            'role' => 'cook',
            'password' => Hash::make('password123'),
        ]);

        // Clients
        User::create([
            'name' => 'Jean Client',
            'email' => 'jean@example.com',
            'phone' => '0123456794',
            'role' => 'client',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Alice Visiteur',
            'email' => 'alice@example.com',
            'phone' => '0123456795',
            'role' => 'client',
            'password' => Hash::make('password123'),
        ]);
    }
}
