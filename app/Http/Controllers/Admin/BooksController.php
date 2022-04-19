<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Books;
use App\Imports\ImportBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class BooksController extends Controller
{
    public function AdminBooks()
    {
        $Adminprofile = $this->Adminprofile();
        $booksCount = $this->booksCount();
        $booksList = $this->booksList();

        return view('Admin.books',compact('Adminprofile','booksCount','booksList'));
    }

    public function Adminprofile()
    {
        $Adminprofile = User::where('id','=',Auth::user()->id)->first();

        return $Adminprofile;
    }

    public function booksCount()
    {
        $booksCount = Books::count();

        return $booksCount;
    }

    public function booksList()
    {
        $booksList = Books::orderBy('booksId','DESC')->get();

        return $booksList;
    }

    public function addBooks(Request $request)
    {
        $Date = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');

        if($request->has('addBooks'))
        {
            $request->validate([
                'file' => 'required|max:10000|mimes:xlsx,xls',
            ]);

            $data = Excel::import(new ImportBook,$request->file('file'));


            return redirect()->back()->with(['status'=>'Books Added Successfully']);
        }
        elseif($request->has('update'))
        {
            DB::table('books')
                ->where('booksId','=',$request->input('id'))
                ->update(array(
                    'status' => $request->input('isactive'),
                    'updated_at' => $Date,
                ));

            return redirect()->back()->with(['status'=>'Book Removed Successfully']);
        }
    }
}
