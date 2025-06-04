<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Log;
use App\Models\User;

class LogSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

       
        $actions = ['login', 'logout', 'create_reservation', 'update_order', 'cancel_reservation'];

        foreach ($users as $user) {
            foreach ($actions as $action) {
                Log::create([
                    'user_id' => $user->id,
                    'action_type' => $action,
                    'details' => "Action $action effectuée par l'utilisateur ID {$user->id}",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
