<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Session;
use App\User;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function create()
    {
        return view('auth.forgot_password');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
        'email' => 'required|max:255|email'
        ]);
        $token = md5($request->email);
        User::where('email', $request->email)->update(['remember_token' => $token]);
        $user = User::where('email', $request->email)->first();
        
        if($user){
            //send email verification mail.
            $data = [
            'from' => 'do_not_reply@dolightjob.com',
            'name' => $user->name,
            'email' => $user->email,
            'url' => url('/').'/password/'.$token,
            'subject' =>  'Password Reset Confirmation | Dolightjob.com'
            ];

            //send email to registerd user
            $this->sendmail('auth.email_reset_password', $data);
            Session::flash('success', 'The password recovery mail has been sent to your email '.$user->email);
            return redirect('/login');
        }
        Session::flash('error', 'The email account does not exists. Please back to <a href="/signup">Signup</a>');
        return back();
    }

    public function edit($token)
    {
        $user = User::where('remember_token', $token)->first();
        if($user){
            Session::put('_user_id', $user->id);
            return view('auth.reset_password', compact('user'));
        }
        return back();
    }

    public function update(Request $request, $id)
    {        
        $this->validate($request, [
        'password' => 'required|min:8|max:32|confirmed'
        ]);

        if(Session::get('_user_id') == $id){
            $user = User::find($id);
            $user->password = bcrypt($request->input('password'));
            $user->save();

            Session::flush('_user_id');

            Session::flash('success', 'The password successfully updated.');
            return redirect('/login');
        }

        
    }
}
