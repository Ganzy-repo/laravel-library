<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'category_name',
    ];

    public function withBooks()
    {
        return $this->join('books', function ($join) {
            return $join->on('categories.id', '=', 'books.category_id');
        })
        ->select(
            'categories.id',
            'categories.category_name',
            'categories.description',
            'books.id as book_id',
            'books.title',
            'books.author',
            'books.qty',
            'books.year'
        )
        ->get();
    }
}
