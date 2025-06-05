<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Table;
use App\Models\Menu;
use Carbon\Carbon;

class OrdersSeeder extends Seeder
{
    public function run(): void
    {
        $waiters = User::where('role', 'waiter')->get();
        if ($waiters->isEmpty()) {
            $this->command->info('Skipping OrderSeeder: No waiters found');
            return;
        }

        $tables = Table::all();
        if ($tables->isEmpty()) {
            $this->command->info('Skipping OrderSeeder: No tables found');
            return;
        }

        $menus = Menu::all();
        if ($menus->isEmpty()) {
            $this->command->info('Skipping OrderSeeder: No menus found');
            return;
        }

        // Commande 1 - En cours de préparation
        $order1 = Order::create([
            'table_id' => $tables->random()->id,
            'user_id' => $waiters->random()->id,
            'status' => 'preparing',
            'created_at' => Carbon::now()->subMinutes(30),
        ]);

        // Articles pour la commande 1
        OrderItem::create([
            'order_id' => $order1->id,
            'menu_id' => $menus->random()->id,
            'quantity' => 2,
            'comment' => 'Sans épices',
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'menu_id' => $menus->random()->id,
            'quantity' => 1,
            'comment' => null,
        ]);

        // Commande 2 - Terminée
        $order2 = Order::create([
            'table_id' => $tables->random()->id,
            'user_id' => $waiters->random()->id,
            'status' => 'completed',
            'created_at' => Carbon::now()->subHours(2),
        ]);

        // Articles pour la commande 2
        OrderItem::create([
            'order_id' => $order2->id,
            'menu_id' => $menus->random()->id,
            'quantity' => 1,
            'comment' => 'Cuisson bien cuite',
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'menu_id' => $menus->random()->id,
            'quantity' => 2,
            'comment' => null,
        ]);

        // Commande 3 - En attente
        $order3 = Order::create([
            'table_id' => $tables->random()->id,
            'user_id' => $waiters->random()->id,
            'status' => 'pending',
            'created_at' => Carbon::now()->subMinutes(5),
        ]);

        // Articles pour la commande 3
        OrderItem::create([
            'order_id' => $order3->id,
            'menu_id' => $menus->random()->id,
            'quantity' => 1,
            'comment' => 'Allergique aux fruits de mer',
        ]);
    }
}
