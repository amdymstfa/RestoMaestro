<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrdersSeeder extends Seeder
{
    public function run(): void
    {
        Order::create([
            'table_id' => 1,
            'user_id' => 2, 
            'status' => 'pending',
        ]);
    }
}
