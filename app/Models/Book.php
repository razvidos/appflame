<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $primaryKey = 'book_id';
    protected $fillable = ['name'];

    public function author() {
        return $this->belongsToMany(
            Author::class,
            'book_authors',
            'book_id',
            'author_id'
        );
    }
}
