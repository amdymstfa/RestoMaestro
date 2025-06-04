<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Database\Seeders\UsersSeeder;
use Database\Seeders\TablesSeeder;
use Database\Seeders\MenusSeeder;
use Database\Seeders\ReservationsSeeder;
use Database\Seeders\OrdersSeeder;
use Database\Seeders\OrderItemsSeeder;
use Database\Seeders\LogSeeder;
use Database\Seeders\PerformanceStatsSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            TablesSeeder::class,
            MenusSeeder::class,
            ReservationsSeeder::class,
            OrdersSeeder::class,
            OrderItemsSeeder::class,
            LogSeeder::class,
            PerformanceStatsSeeder::class,
        ]);
    }

}
