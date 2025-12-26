<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'CART_ITEM';
    public $timestamps = false;
    public $incrementing = false; // composite PK
    protected $fillable = ['CartID','ISBN','Quantity'];
}
