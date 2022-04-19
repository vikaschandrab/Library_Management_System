<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Books;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportBook implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $Date = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');
        return new Books([
            'title' => $row['title'],
            'publication' => $row['publication'],
            'author' =>$row['author'],
            'total_books' =>$row['total_books'],
            'remaining_books' => $row['remaining_books'],
            'borrowed_books' => $row['borrowed_books'],
            'book_code' => $row['book_code'],
            'status' => 1,
            'created_at' => $Date,
            'updated_at' => $Date,
        ]);
    }
}
