<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PerformanceStat;

class PerformanceStatsSeeder extends Seeder
{
    public function run(): void
    {
        PerformanceStat::create([
            'user_id' => 2,
            'date' => today(),
            'tables_served' => 4,
            'avg_service_time' => '00:20:00'
        ]);
    }
}
