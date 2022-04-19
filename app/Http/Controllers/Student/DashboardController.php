<?php

namespace App\Http\Controllers\Student;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Books;
use Illuminate\Http\Request;
use App\Models\borrowedbooks;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function StudentDashboard()
    {
        $StudentProfile = $this->StudentProfile();
        $countBorrowedBooks = $this->countBorrowedBooks();
        $BorrowedBooks = $this->BorrowedBooks();
        $countDueBooks = $this->countDueBooks();
        $DueBooks = $this->DueBooks();

        return view('Student.dashboard',compact('StudentProfile',
                                                'countBorrowedBooks','BorrowedBooks','countDueBooks','DueBooks'));
    }

    public function StudentProfile()
    {
        $StudentProfile = User::where('id','=',Auth::user()->id)->first();

        return $StudentProfile;
    }

    public function countBorrowedBooks()
    {
        $countBorrowedBooks = borrowedbooks::join('books','borrowedbooks.booksId_fk','=','books.booksId')
                                            ->where('userId_fk','=',Auth::user()->id)
                                            ->where('isAccepted','=',1)->orderBy('booksborrowId','DESC')->count();

        return $countBorrowedBooks;
    }

    public function BorrowedBooks()
    {
        $BorrowedBooks = borrowedbooks::join('books','borrowedbooks.booksId_fk','=','books.booksId')
                                            ->where('userId_fk','=',Auth::user()->id)
                                            ->where('isAccepted','=',1)->orderBy('booksborrowId','DESC')->get();

        return $BorrowedBooks;
    }

    public function countDueBooks()
    {
        $Date = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');

        $countDueBooks = borrowedbooks::join('books','borrowedbooks.booksId_fk','=','books.booksId')
                                        ->where('userId_fk','=',Auth::user()->id)
                                        ->where('return_date','<=', $Date)->orderBy('return_date','ASC')->count();

        return $countDueBooks;
    }

    public function DueBooks()
    {
        $Date = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');

        $DueBooks = borrowedbooks::join('books','borrowedbooks.booksId_fk','=','books.booksId')
                                        ->where('userId_fk','=',Auth::user()->id)
                                        ->where('return_date','<=', $Date)->orderBy('return_date','ASC')->get();

        return $DueBooks;
    }
}
