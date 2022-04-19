<?php

namespace App\Http\Controllers\Authentication;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    public function viewRegister()
    {

        return view('Register_Login.register');
    }

    protected function adduser(Request $request)
    {
        $Date = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s');

        $request->validate([
            'phone' => ['required', 'digits:10', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $emailUser = User::where('email','=',$request->email)->first();
        if($emailUser)
        {
            $user=['name' => $emailUser->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $request->password,
            'userType' => $emailUser->userType];

            $user['to'] = $request->email;

            $Mail = Mail::send('Email.newUser',$user,function($messages) use ($user){
                    $messages->to($user['to'])
                        ->subject('Thank You For Activating Account in Library Management System');
                        });

            $Mail = Mail::send('Email.adminMail', $user,function($messages) use ($user){
                    $messages->to('projectlibrarymanagementsystem@gmail.com')
                        ->subject('New Users Account Activated');
                        });

                    $emailUser->password = Hash::make($request->password);
                    $emailUser->phone = $request->phone;
                    $emailUser->status = 1;
                    $emailUser->created_at = $Date;
                    $emailUser->updated_at = $Date;
                    $emailUser->save();

            return redirect()->back()->with('status','Account Created Successfully');
        }
        else
        {
            return redirect()->back()->with('failure','Email Does not Exists');
        }

    }
}
