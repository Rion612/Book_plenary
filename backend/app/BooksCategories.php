<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BooksCategories extends Model
{
    //
    protected $fillable = [
        'books_id', 'category_id',
    ];
}
