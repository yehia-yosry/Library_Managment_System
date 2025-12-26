<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'BOOK';
    protected $primaryKey = 'ISBN';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'ISBN', 'Title', 'PublicationYear', 'Price', 'Quantity', 'Threshold', 'CategoryID', 'PublisherID'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'CategoryID', 'CategoryID');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'PublisherID', 'PublisherID');
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'BOOK_AUTHOR', 'ISBN', 'AuthorID');
    }
}
