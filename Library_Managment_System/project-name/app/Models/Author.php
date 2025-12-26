<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $table = 'AUTHOR';
    protected $primaryKey = 'AuthorID';
    public $timestamps = false;

    protected $fillable = ['AuthorName'];

    public function books()
    {
        return $this->belongsToMany(Book::class, 'BOOK_AUTHOR', 'AuthorID', 'ISBN');
    }
}
