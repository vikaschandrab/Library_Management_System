<?php

namespace App\Http\Controllers\Librarian;

use App\Models\User;
use App\Models\Books;
use App\Models\borrowedbooks;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function LibrarianDashboard()
    {
        $getBooksCount = $this->getBooksCount();
        $getborrowedbooksCount = $this->getborrowedbooksCount();
        $getLibrarianProfile = $this->getLibrarianProfile();

        return view('Librarian.dashboard',compact('getBooksCount','getborrowedbooksCount','getLibrarianProfile'));
    }

    public function getLibrarianProfile()
    {
        $getLibrarianProfile = User::where('id','=',Auth::user()->id)->first();

        return $getLibrarianProfile;
    }

    public function getBooksCount()
    {
        $getBooksCount = Books::where('status','=', 1)->count();

        return $getBooksCount;
    }

    public function getborrowedbooksCount()
    {
        $getborrowedbooksCount = borrowedbooks::where('isReturned','=',0)->count();

        return $getborrowedbooksCount;
    }
}
