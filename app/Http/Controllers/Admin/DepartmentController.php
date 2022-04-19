<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Departments;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function AdminDepartment()
    {
        $Adminprofile = $this->Adminprofile();
        $getDepartments = $this->getDepartments();
        $getDepartmentsCount = $this->getDepartmentsCount();

        return view('Admin.department',compact('Adminprofile','getDepartments','getDepartmentsCount'));
    }

    public function Adminprofile()
    {
        $Adminprofile = User::where('id','=',Auth::user()->id)->first();

        return $Adminprofile;
    }

    public function getDepartmentsCount()
    {
        $getDepartmentsCount = Departments::count();

        return $getDepartmentsCount;
    }

    public function getDepartments()
    {
        $getDepartments = Departments::get();

        return $getDepartments;
    }

    public function addDepartment(Request $request)
    {
        $Date = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');

        $request->validate([
            'addmore.*.departmentName' => ['required'],
        ]);

        foreach($request->addmore as $key => $value)
        {
            $department = new Departments;

            $department->department_name = $value['departmentName'];
            $department->created_at = $Date;
            $department->updated_at = $Date;
            $department->save();
        }

        return redirect()->back()->with('status','Department Added Successfully');
    }
}
