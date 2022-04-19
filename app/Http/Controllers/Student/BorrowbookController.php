<?php

namespace App\Http\Controllers\Student;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Books;
use App\Models\Students;
use Illuminate\Http\Request;
use App\Models\borrowedbooks;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BorrowbookController extends Controller
{
    public function StudentBorrowBook()
    {
        $StudentProfile = $this->StudentProfile();
        $countBooks = $this->countBooks();
        $getBooks = $this->getBooks();
        $countRequestedBooks = $this->countRequestedBooks();
        $requestedBooks = $this->requestedBooks();
        $countReturnRequest = $this->countReturnRequest();
        $ReturnRequest = $this->ReturnRequest();
        $countReturnBooks = $this->countReturnBooks();
        $ReturnBooks = $this->ReturnBooks();

        return view('Student.borrowbook',compact('StudentProfile','countBooks','getBooks','countRequestedBooks',
                                                'requestedBooks','countReturnRequest','ReturnRequest','countReturnBooks','ReturnBooks'));
    }

    public function StudentProfile()
    {
        $StudentProfile = User::where('id','=',Auth::user()->id)->first();

        return $StudentProfile;
    }

    public function countBooks()
    {
        $countBooks = Books::where('status','=',1)->where('remaining_books','>=',1)->count();

        return $countBooks;
    }

    public function getBooks()
    {
        $getBooks = Books::where('status','=',1)->where('remaining_books','>=',1)->get();

        return $getBooks;
    }

    public function countRequestedBooks()
    {
        $countRequestedBooks = borrowedbooks::join('books','borrowedbooks.booksId_fk','=','booksId')
                                            ->where('UserId_fk','=',Auth::user()->id)
                                            ->count();

        return $countRequestedBooks;
    }

    public function requestedBooks()
    {
        $requestedBooks = borrowedbooks::join('books','borrowedbooks.booksId_fk','=','books.booksId')
                                        ->where('UserId_fk','=',Auth::user()->id)->get();

        return $requestedBooks;
    }


    public function countReturnRequest()
    {
        $countReturnRequest= borrowedbooks::where('return_request','=',1)
                                            ->where('reply_return_request','=',null)
                                            ->where('UserId_fk','=',Auth::user()->id)
                                            ->count();

        return $countReturnRequest;
    }

    public function ReturnRequest()
    {
        $ReturnRequest= borrowedbooks::join('books','borrowedbooks.booksId_fk','=','books.booksId')
                                        ->where('return_request','=',1)
                                        ->where('reply_return_request','=',null)
                                        ->where('UserId_fk','=',Auth::user()->id)
                                        ->get();
        return $ReturnRequest;
    }

    public function countReturnBooks()
    {
        $Date = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');

        $countReturnBooks = borrowedbooks::join('books','borrowedbooks.booksId_fk','=','books.booksId')
                                        ->where('userId_fk','=',Auth::user()->id)
                                        ->where('return_date','<=', $Date)
                                        ->where('isReturned','=', null)
                                        ->orwhere('isReturned','=','0')->orderBy('return_date','ASC')->count();

        return $countReturnBooks;
    }

    public function ReturnBooks()
    {
        $Date = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');

        $ReturnBooks = borrowedbooks::join('books','borrowedbooks.booksId_fk','=','books.booksId')
                                        ->where('userId_fk','=',Auth::user()->id)
                                        ->where('return_date','<=', $Date)
                                        ->where('isReturned','=', null)
                                        ->orwhere('isReturned','=','0')->orderBy('return_date','ASC')->get();

        return $ReturnBooks;
    }

    public function bookRequest(Request $request)
    {
        $Date = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');

        if($request->has('requestbook'))
        {
            $bookDetails = Books::where('book_code','=',$request->input('book_code'))->first();
            $studentDetails = Students::where('UserId_fk','=',Auth::user()->id)->first();

            if($bookDetails -> remaining_books >= 1)
            {
                $borrowBooks = new borrowedbooks;
                $borrowBooks->UserId_fk = Auth::user()->id;
                $borrowBooks->booksId_fk = $bookDetails->booksId;
                $borrowBooks->studentId_fk = $studentDetails->studentId;
                $borrowBooks->isRequested = 1;
                $borrowBooks->request_date = $Date;
                $borrowBooks->save();

                return redirect()->back()->with(['status'=>'Borrow Request Sent Successfully']);
            }
            else
            {
                return redirect()->back()->with(['failure'=>'Book Not Available']);
            }
        }
        elseif($request->has('rtnReqRes'))
        {
            DB::table('borrowedbooks')
                ->where('booksborrowId','=',$request->input('id'))
                ->update(array(
                    'borrow_date' => $Date,
                    'reply_return_request' => $request->input('isactive'),
                    'updated_at' => $Date,
                ));

            return redirect()->back()->with(['status'=>'Return Request Responded Successfully']);
        }
        elseif($request->has('updatereturn'))
        {
            if($request->input('isactive') == 1)
            {

                DB::table('borrowedbooks')
                        ->where('booksborrowId','=',$request->input('id'))
                        ->update(array(
                            'isReturned' => 1,
                            'updated_at' => $Date,
                        ));

                $bookDetails = borrowedbooks::join('books','borrowedbooks.booksId_fk','=','books.booksId')
                                            ->where('booksborrowId','=',$request->input('id'))->first();

                DB::table('books')
                        ->where('booksId','=',$bookDetails->booksId_fk)
                        ->update(array(
                            'borrowed_books' => $bookDetails->borrowed_books - 1,
                            'remaining_books' => $bookDetails->remaining_books + 1,
                            'updated_at' => $Date,
                        ));

                return redirect()->back()->with(['status'=>'Book Returned Successfully']);

            }
            else
            {
                DB::table('borrowedbooks')
                ->where('booksborrowId','=',$request->input('id'))
                ->update(array(
                    'isReturned' => 0,
                    'updated_at' => $Date,
                ));

                return redirect()->back()->with(['status'=>'Denied to Return Book Successfully']);
            }
        }
    }

}
