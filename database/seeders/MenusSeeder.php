<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenusSeeder extends Seeder
{
    public function run(): void
    {
        Menu::insert([
            ['name' => 'Salade César', 'description' => 'Salade avec poulet grillé', 'type' => 'entrée', 'price' => 7.50, 'is_special' => false],
            ['name' => 'Steak Frites', 'description' => 'Boeuf grillé avec frites', 'type' => 'plat', 'price' => 15.00, 'is_special' => true],
            ['name' => 'Tiramisu', 'description' => 'Dessert italien classique', 'type' => 'dessert', 'price' => 6.00, 'is_special' => false],
            ['name' => 'Coca-Cola', 'description' => 'Boisson gazeuse', 'type' => 'boisson', 'price' => 2.50, 'is_special' => false],
        ]);
    }
}
