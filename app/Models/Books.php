<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;

    protected $fillable = [
        'booksId',
        'title',
        'publication',
        'author',
        'total_books',
        'remaining_books',
        'borrowed_books',
        'book_code',
        'status',
        'created_at',
        'updated_at',
    ];
}
