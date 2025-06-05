<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $table = 'menu_items';

    protected $fillable = [
        'name',
        'description',
        'category',
        'price',
        'is_available',
        'is_special',
        'allergens',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
        'is_special' => 'boolean',
        'allergens' => 'array',
    ];

    /**
     * Get the order items for the menu item.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
