<?php

namespace App\Http\Controllers\Librarian;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Departments;
use Illuminate\Http\Request;
use App\Models\borrowedbooks;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BooksDueController extends Controller
{
    public function LibrarianBooksDue()
    {
        $getDueBooksCount = $this->getDueBooksCount();
        $getRequestCount = $this->getRequestCount();
        $getDueBooksList = $this->getDueBooksList();
        $getdepartment = $this->getdepartment();
        $getLibrarianProfile = $this->getLibrarianProfile();
        $getRequestList = $this->getRequestList();
        $booksListofStudent = $this->booksListofStudent();

        return view('Librarian.booksDue',compact('getDueBooksCount','getRequestCount','getDueBooksList','getdepartment',
                                                'getLibrarianProfile','getRequestList','booksListofStudent'));
    }

    public function getLibrarianProfile()
    {
        $getLibrarianProfile = User::where('id','=',Auth::user()->id)->first();

        return $getLibrarianProfile;
    }

    public function getdepartment()
    {
        $getdepartment = Departments::get();

        return $getdepartment;
    }

    public function getDueBooksCount()
    {
        $Date = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');
        $getDueBooksCount = borrowedbooks::where('return_date','<=', $Date)->count();

        return $getDueBooksCount;
    }

    public function getDueBooksList()
    {
        $Date = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');
        $getDueBooksList = borrowedbooks::join('books','borrowedbooks.booksborrowId','=','books.booksId')
                                        ->join('students','borrowedbooks.studentId_fk','=','students.studentId')
                                        ->join('users','borrowedbooks.UserId_fk','=','users.Id')
                                        ->where('return_date','<=', $Date)->orderBy('return_date','ASC')->get();

        return  $getDueBooksList;
    }

    public function getRequestCount()
    {
        $getRequestCount = borrowedbooks::join('books','borrowedbooks.booksId_fk','=','booksId')
                                        ->where('isRequested','=',1)
                                        ->orderBy('booksborrowId','ASC')->count();

        return $getRequestCount;
    }

    public function getRequestList()
    {
        $getRequestList = borrowedbooks::join('books','borrowedbooks.booksId_fk','=','booksId')
                                        ->join('users','borrowedbooks.UserId_fk','=','id')
                                        ->join('students','borrowedbooks.studentId_fk','=','studentId')
                                        ->where('isRequested','=',1)
                                        ->orderBy('booksborrowId','ASC')->get();

        return $getRequestList;
    }

    public function booksListofStudent()
    {
        $booksListofStudent = borrowedbooks::join('books','borrowedbooks.booksId_fk','=','booksId')
                                            ->where('isRequested','=',0)->where('isAccepted','=',1)
                                            ->orderBy('booksborrowId','DESC')->get();

        return $booksListofStudent;
    }

    public function LibrarianReply(Request $request)
    {
        $Date = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');
        if($request->has('replyrequest'))
        {
            if($request->input('isactive') == 1)
            {
                DB::table('borrowedbooks')
                ->where('booksborrowId','=',$request->input('booksborrowId'))
                ->update(array(
                    'borrow_date' => $Date,
                    'return_date' => $request->input('returnDate'),
                    'isRequested' => 0,
                    'isAccepted' => 1,
                    'updated_at' => $Date,
                ));

                $bookDetails = borrowedbooks::join('books','borrowedbooks.booksId_fk','=','books.booksId')
                                            ->where('booksborrowId','=',$request->input('booksborrowId'))->first();

                DB::table('books')
                ->where('booksId','=',$bookDetails->booksId_fk)
                ->update(array(
                    'borrowed_books' => $bookDetails->borrowed_books + 1,
                    'remaining_books' => $bookDetails->remaining_books - 1,
                    'updated_at' => $Date,
                ));

                return redirect()->back()->with(['status'=>'Requested Accepted Successfully']);

            }
            else
            {
                DB::table('borrowedbooks')
                ->where('booksborrowId','=',$request->input('booksborrowId'))
                ->update(array(
                    'isRequested' => 0,
                    'isAccepted' => 0,
                    'updated_at' => $Date,
                ));

                return redirect()->back()->with(['status'=>'Requested Rejected Successfully']);

            }
        }
        elseif($request->has('requestreturn'))
        {
            DB::table('borrowedbooks')
                ->where('booksborrowId','=',$request->input('booksborrowId'))
                ->update(array(
                    'return_request' => 1,
                    'updated_at' => $Date,
                ));

            return redirect()->back()->with(['status'=>'Book Return Requested Successfully']);
        }
    }
}
