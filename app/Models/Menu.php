<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'price',
        'is_special',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_special' => 'boolean',
    ];

    /**
     * Get the order items for the menu.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'menu_id');
    }
}
