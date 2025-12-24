<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerOrder extends Model
{
    protected $table = 'CUSTOMER_ORDER';
    protected $primaryKey = 'OrderID';
    public $timestamps = false;

    protected $fillable = ['CustomerID','OrderDate','TotalPrice','CreditCardNumber','ExpiryDate'];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'OrderID', 'OrderID');
    }
}
