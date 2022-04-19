<?php

namespace App\Http\Controllers\Librarian;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Books;
use App\Models\Departments;
use Illuminate\Http\Request;
use App\Models\borrowedbooks;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BooksController extends Controller
{
    public function LibrarianBooks()
    {
        $getLibrarianProfile = $this->getLibrarianProfile();
        $getBooksList = $this->getBooksList();
        $getBooksCount = $this->getBooksCount();
        $getborrowlist = $this->getborrowlist();
        $getdepartment = $this->getdepartment();

        return view('Librarian.books',compact('getLibrarianProfile','getBooksList','getBooksCount',
                                                'getborrowlist','getdepartment'));
    }

    public function getLibrarianProfile()
    {
        $getLibrarianProfile = User::where('id','=',Auth::user()->id)->first();

        return $getLibrarianProfile;
    }

    public function getBooksCount()
    {
        $getBooksCount = Books::count();

        return $getBooksCount;
    }

    public function getBooksList()
    {
        $getBooksList = Books::orderBy('booksId','DESC')->get();

        return $getBooksList;
    }

    public function getborrowlist()
    {
        $getborrowlist = borrowedbooks::join('books','borrowedbooks.booksborrowId','=','books.booksId')
                                        ->join('students','borrowedbooks.studentId_fk','=','students.studentId')
                                        ->join('users','borrowedbooks.UserId_fk','=','users.Id')
                                        ->where('isAccepted','=',1)
                                        ->orderBy('booksborrowId','DESC')->get();

        return $getborrowlist;
    }

    public function getdepartment()
    {
        $getdepartment = Departments::get();

        return $getdepartment;
    }

    public function booksUpdate(Request $request)
    {
        $Date = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');

        DB::table('books')
                ->where('booksId','=',$request->input('bookId'))
                ->update(array(
                    'status' => $request->input('isactive'),
                    'updated_at' => $Date,
                ));

            return redirect()->back()->with(['status'=>'Book Deactivated Successfully']);
    }
}
