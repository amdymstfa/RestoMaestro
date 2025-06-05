<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Table;
use Carbon\Carbon;

class ReservationsSeeder extends Seeder
{
    public function run(): void
    {
        $manager = User::where('role', 'manager')->first();
        $clients = User::where('role', 'client')->get();
        $tables = Table::all();

        $reservations = [
            [
                'client_name' => 'Famille Dubois',
                'phone' => '0123456800',
                'table_id' => $tables->random()->id,
                'reservation_time' => Carbon::tomorrow()->setTime(19, 30),
                'created_by' => $manager->id,
            ],
            [
                'client_name' => 'M. et Mme Martin',
                'phone' => '0123456801',
                'table_id' => $tables->random()->id,
                'reservation_time' => Carbon::today()->setTime(20, 0),
                'created_by' => $manager->id,
            ],
            [
                'client_name' => 'Entreprise ABC',
                'phone' => '0123456802',
                'table_id' => $tables->where('seats', '>=', 6)->first()->id,
                'reservation_time' => Carbon::today()->addDays(3)->setTime(12, 30),
                'created_by' => $manager->id,
            ],
            [
                'client_name' => 'Restaurant Le Gourmet',
                'phone' => '0123456803',
                'table_id' => $tables->random()->id,
                'reservation_time' => Carbon::today()->addDays(2)->setTime(18, 0),
                'created_by' => $manager->id,
            ],
            [
                'client_name' => 'Célébration Anniversaire',
                'phone' => '0123456804',
                'table_id' => $tables->where('seats', '>=', 4)->first()->id,
                'reservation_time' => Carbon::today()->addDays(5)->setTime(19, 0),
                'created_by' => $manager->id,
            ],
        ];

        foreach ($reservations as $reservation) {
            Reservation::create($reservation);
        }
    }
}
