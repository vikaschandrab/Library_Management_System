<?php

namespace App\Http\Controllers\Librarian;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function LibrarianProfile()
    {
        $getProfile = $this->getProfile();

        return view('Librarian.profile',compact('getProfile'));
    }

    public function getProfile()
    {
        $getProfile = User::where('id','=',Auth::user()->id)->first();

        return $getProfile;
    }

    public function LibrarianProfileUpdate(Request $request)
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
        $file->move('images/librarian/',$filename);

        $AddUsers = User::where('id','=', Auth::user()->id)->first();
        $AddUsers->name = $request->name;
        $AddUsers->email = $request->email;
        $AddUsers->phone = $request->phone;
        $AddUsers->updated_at = $Date;
        $AddUsers->profilePicture=$filename;
        $AddUsers->save();

        return redirect()->back()->with(['status'=>'Profile Picture Updated Successfully']);
    }
}
