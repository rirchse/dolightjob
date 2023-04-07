<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email', 'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->select('status')->first();

        if($user->status == 2)
        {
            Session::flash('error', 'Your account suspended. Please contact with system administrator.');
            return redirect('/login');
        }
        elseif(Auth::attempt($credentials, $request->has('remember')))
        { 
            //this if validate if the user is on the database line 1
            return redirect()->intended($this->redirectPath());
            //this redirect if user is the db line 2
        }
        else
        {
            Session::flash('error', 'Your credentials do not match.');
            return redirect('/login');
        }
    }
}
