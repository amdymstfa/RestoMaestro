<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_id',
        'user_id',
        'status',
        'total_amount',
        'notes',
        'preparation_started_at',
        'preparation_completed_at',
    ];

    protected $casts = [
        'preparation_started_at' => 'datetime',
        'preparation_completed_at' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the table that owns the order.
     */
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    /**
     * Get the user that owns the order (waiter).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the waiter that owns the order.
     */
    public function waiter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the order items for the order.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the order items for the order (alias).
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the total price of the order.
     */
    public function getTotalAttribute()
    {
        return $this->orderItems->sum(function ($item) {
            return $item->quantity * $item->unit_price;
        });
    }
}
