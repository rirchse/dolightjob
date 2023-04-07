<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Session;
use Mail;
use App\EarningBalance;
use App\DepositBalance;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->roles()->attach(Role::where('name', 'employee')->first());
        return $user;
    }

    public function signup_store(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required|max:100',
            'email'    => 'required|min:8|max:32',
            'contact'  => 'required|min:11|max:11',
            'password' => 'required|min:8|max:32|confirmed'
        ]);

        $exists = User::where('email', $request->email)->orWhere('contact', $request->contact)->first();
        if($exists){
            Session::flash('error', 'You have already sign up. Please login to the system.');
            return redirect('/login');
        }

        $store = New User;
        $store->name       = $request->name;
        $store->contact    = $request->contact;
        $store->email      = $request->email;
        $store->password   = bcrypt($request->password);
        $store->remember_token = md5($request->contact);
        $store->aff_id = Session::get('_aff')?Session::get('_aff'):0;
        $store->created_by = 0;
        $store->save();

        $store->roles()->attach(Role::where('name', 'User')->first());

        $last_user = User::orderBy('id', 'DESC')->first();

        //entry earnig balance
        $earn_bal = New EarningBalance;
        $earn_bal->amount = 0;
        $earn_bal->user_id = $last_user->id;
        $earn_bal->save();

        //entry deposit balance
        $depo_bal = New DepositBalance;
        $depo_bal->amount = 0.30;
        $depo_bal->user_id = $last_user->id;
        $depo_bal->save();

        //send email verification mail.
        $data = [
        'from' => 'do_not_reply@dolightjob.com',
        'name' => $last_user->name,
        'email' => $last_user->email,
        'url' => url('/').'/email-verify/'.$last_user->id.'/'.$last_user->remember_token,
        'subject' =>  'Verify Your Email | Dolightjob.com'
        ];

        //session remove
        if(Session::get('_aff')){
            Session::forget('_aff');
        }

        //send email to registerd user
        $this->sendmail('auth.email_verification', $data);

        Session::flash('success', 'Your sign up succssfully completed. Please check your email for complete the verification. Thank you for join with us.');

        return redirect('/login');
    }

    public function emailVerify($id, $token)
    {
        $user = User::where('remember_token', $token)->where('id', $id)->first();
        
        if(!$user)
        {
            Session::flash('error', 'Verification session expire. Please contact with support team.');
            return redirect('/login');
        }
        elseif($user->status == 1)
        {
            Session::flash('error', 'You already verified. Please login to the system. Otherwise contact with support team.');
            return redirect('/login');
        }
        else 
        {
            $update = $user;
            $update->status = 1;
            $update->remember_token = '';
            $update->save();

            Session::flash('success', 'Email verification successfull. Now you are able to login to the system.');
            return redirect('/login');
        }
    }

}