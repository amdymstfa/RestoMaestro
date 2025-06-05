<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Table;

class TablesSeeder extends Seeder
{
    public function run(): void
    {
        $tables = [
            ['number' => 1, 'seats' => 2, 'status' => 'available'],
            ['number' => 2, 'seats' => 4, 'status' => 'available'],
            ['number' => 3, 'seats' => 6, 'status' => 'occupied'],
            ['number' => 4, 'seats' => 2, 'status' => 'available'],
            ['number' => 5, 'seats' => 4, 'status' => 'reserved'],
            ['number' => 6, 'seats' => 8, 'status' => 'available'],
            ['number' => 7, 'seats' => 2, 'status' => 'available'],
            ['number' => 8, 'seats' => 4, 'status' => 'occupied'],
            ['number' => 9, 'seats' => 6, 'status' => 'available'],
            ['number' => 10, 'seats' => 4, 'status' => 'available'],
        ];

        foreach ($tables as $table) {
            Table::create($table);
        }
    }
}
