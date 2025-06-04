<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderItem;

class OrderItemsSeeder extends Seeder
{
    public function run(): void
    {
        OrderItem::create([
            'order_id' => 1,
            'menu_id' => 2, 
            'quantity' => 2,
            'comment' => 'Bien cuit, sans sauce.'
        ]);
    }
}
