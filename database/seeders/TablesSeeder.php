<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Table;

class TablesSeeder extends Seeder
{
    public function run(): void
    {
        foreach (range(1, 5) as $i) {
            Table::create([
                'number' => $i,
                'seats' => rand(2, 6),
                'status' => 'free',
            ]);
        }
    }
}
