<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;

    protected $fillable=[
        'studentId','userId_fk','reg_num','departmentId_fk','year','semester','created_at','updated_at'
    ];
}
