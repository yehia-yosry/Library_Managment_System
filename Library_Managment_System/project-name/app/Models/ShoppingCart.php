<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    protected $table = 'SHOPPING_CART';
    protected $primaryKey = 'CartID';
    public $timestamps = false;

    protected $fillable = ['CustomerID','Date'];

    public function items()
    {
        return $this->hasMany(CartItem::class, 'CartID', 'CartID');
    }
}
