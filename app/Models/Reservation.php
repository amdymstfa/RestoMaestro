<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'phone',
        'reservation_time',
        'table_id',
        'created_by',
    ];

    protected $casts = [
        'reservation_time' => 'datetime',
    ];

    /**
     * Get the table that owns the reservation.
     */
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    /**
     * Get the user who created the reservation.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
