<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;

class ReservationsSeeder extends Seeder
{
    public function run(): void
    {
        Reservation::create([
            'client_name' => 'Alice',
            'phone' => '0600000000',
            'reservation_time' => now()->addHours(2),
            'table_id' => 1,
            'created_by' => 3, 
        ]);
    }
}
