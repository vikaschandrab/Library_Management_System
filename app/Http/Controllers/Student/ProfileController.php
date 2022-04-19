<?php

namespace App\Http\Controllers\Student;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Students;
use App\Models\Departments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function StudentProfile()
    {
        $StudentProfile = User::where('id','=',Auth::user()->id)->first();
        $StudentAcademicDetails = Students::where('UserId_fk','=',Auth::user()->id)->first();
        $departments = Departments::get();

        return view('Student.profile',compact('StudentProfile','StudentAcademicDetails','departments'));
    }

    public function UpdateProfile(Request $request)
    {
        $Date = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');

        $AddUsers = User::where('id','=', Auth::user()->id)->first();

        $request->validate([
            'img' => ['required','image','max:5000'],
            'phone' => ['required','min:10', 'max:10']
        ]);

        $file = $request->file('img');
        $fileExtension = $file->getClientOriginalExtension();
        $fileName = $request->phone;
        $filename = $fileName.'.'.$fileExtension;
        $file->move('images/student/',$filename);

        $AddUsers = User::where('id','=', Auth::user()->id)->first();
        $AddUsers->name = $request->name;
        $AddUsers->email = $request->email;
        $AddUsers->phone = $request->phone;
        $AddUsers->updated_at = $Date;
        $AddUsers->profilePicture=$filename;
        $AddUsers->updated_at = $Date;
        $AddUsers->save();

        $students = students::where('userId_fk','=',Auth::user()->id)->first();

        if($students == null)
        {
            $studentDetails = new Students;
            $studentDetails->userId_fk =  Auth::user()->id;
            $studentDetails->reg_num = $request->input('reg_num');
            $studentDetails->departmentId_fk = $request->input('department');
            $studentDetails->year = $request->input('year');
            $studentDetails->semester = $request->input('sem');
            $studentDetails->created_at = $Date;
            $studentDetails->updated_at = $Date;
            $studentDetails->save();
        }
        else
        {
            DB::table('students')
                ->where('userId_fk','=',Auth::user()->id)
                ->update(array(
                    'reg_num' => $request->input('reg_num'),
                    'departmentId_fk' => $request->input('department'),
                    'year' => $request->input('year'),
                    'semester' => $request->input('sem'),
                    'updated_at' => $Date,
                ));
        }

        return redirect()->back()->with(['status'=>'Profile Picture Updated Successfully']);
    }

}
