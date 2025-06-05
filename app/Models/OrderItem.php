<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'menu_id',
        'quantity',
        'price',
    ];

    /**
     * Get the order that owns the order item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the menu item that owns the order item.
     */
    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class, 'menu_id');
    }

    /**
     * Alias pour la compatibilité
     */
    public function menu()
    {
        return $this->menuItem();
    }
}
