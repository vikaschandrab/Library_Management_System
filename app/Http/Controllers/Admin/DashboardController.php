<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Books;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function AdminDashboard()
    {
        $Adminprofile = $this->Adminprofile();
        $booksCount = $this->booksCount();
        $booksList = $this->booksList();

        return view('Admin.dashboard',compact('Adminprofile','booksCount','booksList'));
    }

    public function Adminprofile()
    {
        $Adminprofile = User::where('id','=',Auth::user()->id)->first();

        return $Adminprofile;
    }

    public function booksCount()
    {
        $booksCount = Books::where('status','=',1)->count();

        return $booksCount;
    }

    public function booksList()
    {
        $booksList = Books::where('status','=',1)->orderBy('booksId','DESC')->get();

        return $booksList;
    }
}
