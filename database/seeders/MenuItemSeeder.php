<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $menuItems = [
            // Entrées
            [
                'name' => 'Salade César',
                'description' => 'Salade romaine, croûtons, parmesan, sauce césar maison',
                'category' => 'starter',
                'price' => 12.50,
                'is_available' => true,
                'is_special' => false,
                'allergens' => ['gluten', 'dairy', 'eggs']
            ],
            [
                'name' => 'Soupe à l\'oignon',
                'description' => 'Soupe traditionnelle française gratinée au fromage',
                'category' => 'starter',
                'price' => 9.00,
                'is_available' => true,
                'is_special' => true,
                'allergens' => ['dairy', 'gluten']
            ],
            [
                'name' => 'Carpaccio de bœuf',
                'description' => 'Fines tranches de bœuf, roquette, parmesan, huile de truffe',
                'category' => 'starter',
                'price' => 16.00,
                'is_available' => true,
                'is_special' => false,
                'allergens' => ['dairy']
            ],

            // Plats principaux
            [
                'name' => 'Steak de bœuf grillé',
                'description' => 'Pièce de bœuf 300g, frites maison, sauce au poivre',
                'category' => 'main',
                'price' => 28.00,
                'is_available' => true,
                'is_special' => false,
                'allergens' => ['dairy']
            ],
            [
                'name' => 'Saumon grillé',
                'description' => 'Filet de saumon, légumes de saison, sauce hollandaise',
                'category' => 'main',
                'price' => 24.00,
                'is_available' => true,
                'is_special' => true,
                'allergens' => ['fish', 'eggs', 'dairy']
            ],
            [
                'name' => 'Risotto aux champignons',
                'description' => 'Risotto crémeux aux champignons de saison et parmesan',
                'category' => 'main',
                'price' => 19.00,
                'is_available' => true,
                'is_special' => false,
                'allergens' => ['dairy']
            ],
            [
                'name' => 'Coq au vin',
                'description' => 'Poulet mijoté au vin rouge, lardons, champignons',
                'category' => 'main',
                'price' => 22.00,
                'is_available' => false,
                'is_special' => false,
                'allergens' => ['sulfites']
            ],

            // Desserts
            [
                'name' => 'Tarte Tatin',
                'description' => 'Tarte aux pommes caramélisées, glace vanille',
                'category' => 'dessert',
                'price' => 8.50,
                'is_available' => true,
                'is_special' => true,
                'allergens' => ['gluten', 'dairy', 'eggs']
            ],
            [
                'name' => 'Mousse au chocolat',
                'description' => 'Mousse au chocolat noir 70%, chantilly',
                'category' => 'dessert',
                'price' => 7.00,
                'is_available' => true,
                'is_special' => false,
                'allergens' => ['dairy', 'eggs']
            ],
            [
                'name' => 'Crème brûlée',
                'description' => 'Crème vanille, sucre caramélisé',
                'category' => 'dessert',
                'price' => 7.50,
                'is_available' => true,
                'is_special' => false,
                'allergens' => ['dairy', 'eggs']
            ],

            // Boissons
            [
                'name' => 'Vin rouge - Bordeaux',
                'description' => 'Bordeaux rouge 2020, bouteille 75cl',
                'category' => 'drink',
                'price' => 35.00,
                'is_available' => true,
                'is_special' => false,
                'allergens' => ['sulfites']
            ],
            [
                'name' => 'Eau minérale',
                'description' => 'Eau minérale naturelle 1L',
                'category' => 'drink',
                'price' => 4.00,
                'is_available' => true,
                'is_special' => false,
                'allergens' => []
            ],
        ];

        foreach ($menuItems as $item) {
            MenuItem::create($item);
        }
    }
}
