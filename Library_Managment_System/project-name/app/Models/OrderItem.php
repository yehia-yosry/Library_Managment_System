<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'ORDER_ITEM';
    public $timestamps = false;
    public $incrementing = false; // composite PK
    protected $fillable = ['OrderID','ISBN','Quantity'];
}
