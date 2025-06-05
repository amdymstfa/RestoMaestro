<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Entrées
        Menu::create([
            'name' => 'Salade César',
            'description' => 'Laitue romaine, croûtons, parmesan, sauce César',
            'price' => 8.50,
            'type' => 'entrée',
            'is_special' => false,
        ]);

        Menu::create([
            'name' => 'Soupe à l\'oignon',
            'description' => 'Soupe à l\'oignon gratinée au fromage',
            'price' => 7.00,
            'type' => 'entrée',
            'is_special' => false,
        ]);

        // Plats principaux
        Menu::create([
            'name' => 'Steak Frites',
            'description' => 'Entrecôte grillée, frites maison, sauce au poivre',
            'price' => 22.50,
            'type' => 'plat',
            'is_special' => true,
        ]);

        Menu::create([
            'name' => 'Saumon grillé',
            'description' => 'Filet de saumon, légumes de saison, sauce citronnée',
            'price' => 19.00,
            'type' => 'plat',
            'is_special' => false,
        ]);

        Menu::create([
            'name' => 'Risotto aux champignons',
            'description' => 'Risotto crémeux aux champignons et parmesan',
            'price' => 16.50,
            'type' => 'plat',
            'is_special' => false,
        ]);

        // Desserts
        Menu::create([
            'name' => 'Crème brûlée',
            'description' => 'Crème brûlée à la vanille',
            'price' => 7.50,
            'type' => 'dessert',
            'is_special' => false,
        ]);

        Menu::create([
            'name' => 'Tarte au citron meringuée',
            'description' => 'Tarte au citron avec meringue italienne',
            'price' => 8.00,
            'type' => 'dessert',
            'is_special' => true,
        ]);

        // Boissons
        Menu::create([
            'name' => 'Vin rouge (verre)',
            'description' => 'Verre de vin rouge de la maison',
            'price' => 6.00,
            'type' => 'boisson',
            'is_special' => false,
        ]);

        Menu::create([
            'name' => 'Eau minérale',
            'description' => 'Bouteille d\'eau minérale 50cl',
            'price' => 3.50,
            'type' => 'boisson',
            'is_special' => false,
        ]);

        Menu::create([
            'name' => 'Cocktail maison',
            'description' => 'Cocktail signature du chef',
            'price' => 9.50,
            'type' => 'boisson',
            'is_special' => true,
        ]);
    }
}
