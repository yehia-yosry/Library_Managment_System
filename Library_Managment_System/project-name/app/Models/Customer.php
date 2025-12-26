<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'CUSTOMER';
    protected $primaryKey = 'CustomerID';
    public $timestamps = false;

    protected $fillable = ['Username','Password','FirstName','LastName','Email','PhoneNumber','ShippingAddress'];
}
