<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'name', 'writer', 'description', 'bookImage'
    ];
    public function categories()
    {
        return $this->belongsToMany('App\Category', 'books_categories', 'books_id', 'category_id');
    }
    public function reviews()
    {
        return $this->hasMany('App\Review');
    }
}
