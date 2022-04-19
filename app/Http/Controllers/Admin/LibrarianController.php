<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Imports\ImportUser;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class LibrarianController extends Controller
{
    public function AdminLibrarian()
    {
        $Adminprofile = $this->Adminprofile();
        $LibrarianCount = $this->LibrarianCount();
        $LibrarianList = $this->LibrarianList();

        return view('Admin.librarian',compact('Adminprofile','LibrarianCount','LibrarianList'));
    }

    public function Adminprofile()
    {
        $Adminprofile = User::where('id','=',Auth::user()->id)->first();

        return $Adminprofile;
    }

    public function LibrarianCount()
    {
        $LibrarianCount = User::where('userType','=','LIBRARIAN')->count();

        return $LibrarianCount;
    }

    public function LibrarianList()
    {
        $LibrarianList = User::where('userType','=','LIBRARIAN')->orderBy('id','DESC')->get();

        return $LibrarianList;
    }

    public function UpdateLibrarian(Request $request)
    {
        $Date = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');

        if($request->has('update'))
        {
            DB::table('users')
                ->where('id','=',$request->input('id'))
                ->update(array(
                    'isActive' => $request->input('isactive'),
                    'updated_at' => $Date,
                ));

            return redirect()->back()->with(['status'=>'Account Deactivated Successfully']);
        }
        elseif($request->has('addLibrarian'))
        {
            $request->validate([
                'file' => 'required|max:10000|mimes:xlsx,xls',
            ]);

            $data = Excel::import(new ImportUser,$request->file('file'));


            return redirect()->back()->with(['status'=>'Account List Added Successfully']);
        }
    }
}
