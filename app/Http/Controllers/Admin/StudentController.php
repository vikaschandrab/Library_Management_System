<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Departments;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function AdminStudent()
    {
        $Adminprofile = $this->Adminprofile();
        $getStudentCount = $this->getStudentCount();
        $getStudentList = $this->getStudentList();
        $getdepartment = $this->getdepartment();
        $getstudentdetails = $this->getstudentdetails();

        return view('Admin.students',compact('Adminprofile','getStudentCount','getStudentList','getdepartment','getstudentdetails'));
    }

    public function Adminprofile()
    {
        $Adminprofile = User::where('id','=',Auth::user()->id)->first();

        return $Adminprofile;
    }

    public function getStudentCount()
    {
        $getStudentCount = User::where('userType','=','STUDENT')->count();

        return $getStudentCount;
    }

    public function getdepartment()
    {
        $getdepartment = Departments::get();

        return $getdepartment;
    }

    public function getStudentList()
    {
        $getStudentList = User::where('userType','=','STUDENT')->orderBy('id','DESC')->get();

        return $getStudentList;
    }

    public function getstudentdetails()
    {
        $getstudentdetails = User::join('students','users.id','=','students.userId_fk')
                                ->where('userType','=','STUDENT')->orderBy('id','DESC')->get();

        return $getstudentdetails;
    }

}
