<?php

namespace App\Models;

use App\Models\User;
use App\Models\Books;
use App\Models\Students;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class borrowedbooks extends Model
{
    use HasFactory;

    protected $fillable = [
        'booksborrowId','UserId_fk','booksId_fk','studentId_fk','borrow_date','return_date','isReturned','return_request','reply_return_request',
        'isRequested','request_date','isAccepted','created_at','updated_at'
    ];

    public function booksModel()
    {
        return $this->belongsTo(Books::class);
    }

    public function studentsModel()
    {
        return $this->belongsTo(Students::class);
    }

    public function userModel()
    {
        return $this->belongsTo(User::class);
    }
}
