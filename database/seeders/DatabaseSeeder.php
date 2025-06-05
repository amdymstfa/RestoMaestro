<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ordre important : d'abord les données de base, puis les relations
        $this->call([
              UsersSeeder::class,
            TablesSeeder::class,
            MenuSeeder::class,
            MenuItemSeeder::class,
            ReservationsSeeder::class,
            OrdersSeeder::class,
        ]);
    }
}
