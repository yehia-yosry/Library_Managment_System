<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $table = 'PUBLISHER';
    protected $primaryKey = 'PublisherID';
    public $timestamps = false;

    protected $fillable = ['Name', 'Address', 'PhoneNumber'];

    public function books()
    {
        return $this->hasMany(Book::class, 'PublisherID', 'PublisherID');
    }
}
