<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'seats',
        'status',
    ];

    /**
     * Get the reservations for the table.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Get the orders for the table.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the current active order for the table.
     */
    public function currentOrder()
    {
        return $this->hasOne(Order::class)
            ->whereIn('status', ['pending', 'preparing', 'served'])
            ->latest();
    }
}
