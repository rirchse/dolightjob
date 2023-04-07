<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Myjob;
use App\Task;
use App\Category;
use App\SubCategory;
use App\User;
use App\Message;
use App\Report;
use Auth;
use Session;
use File;
use Image;
use Hash;

class HomeCtrl extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /* ---------- Report --------- */
    public function report(Request $request)
    {
      $this->validate($request, [
        'report' => 'required',
        'job_id' => 'required'
        ]);

      $store = new Report;
      $store->note = $request->report;
      $store->job_id = $request->job_id;
      $store->created_by = Auth::id();
      $store->save();

      Session::flash('success', 'Successfully reported.');
      return redirect('/jobs');
    }
    public function reportDelete($id)
    {
      $report = Report::find($id);
      $report->delete();
      return redirect('/myjob/'.$report->id);
    }
    /* ---------------- Auth user profile informatino update -----------*/
    public function profile_edit()
    {
      $profile = User::find(Auth::id());
      return view('layouts.profile.edit_profile', compact('profile'));
    }
    public function profile_update(Request $request)
    {
      $this->validate($request, [
        'name'     => 'required|max:255',
        'contact'  => 'required',
        'skill'    => '',
        'facebook'  => 'url',
        'address'  => '',
        'city'     => '',
        'state'    => '',
        'zip_code' => '',
        'country'  => '',
        ]);

        $update = User::find(Auth::id());
        $update->name       = $request->input('name');
        $update->contact    = $request->input('contact');
        $update->skill    = $request->input('skill');
        $update->facebook    = $request->input('facebook');
        $update->address    = $request->input('address');
        $update->city       = $request->input('city');
        $update->state      = $request->input('state');
        $update->zip_code   = $request->input('zip_code');
        $update->country    = $request->input('country');

        if($request->image > 0){
          if (File::exists($update->image)) {
            File::delete($update->image);
          }

          $image = $request->file('image');
          $img = $request->name.'_'.time() .'.'. $image->getClientOriginalExtension();
          $location =  public_path('uploads/profile/'.$img);
          Image::make($image)->save($location);
          $update->image = '/uploads/profile/'.$img;
        }
        $update->save();

        Session::flash('success', 'Information Successfully Updated');
        return redirect('/profile_edit/');
    }
    public function password_change()
    {
      $profile = User::find(Auth::id());
      return view('layouts.profile.password_change', compact('profile'));
    }
    public function password_update(Request $request, $id)
    {
      $this->validate($request, [
        'current_password' => 'required|min:8|max:32',
        'password'   => 'required|min:8|max:32|confirmed',
        'password_confirmation'   => 'required|min:8|max:32'
        ]);
      //get user information
      $user = User::find(Auth::id());
      //check current password
      if(!Hash::check($request->current_password, $user->password))
      {
        Session::flash('error', 'Your current password does not match!');
        return redirect('/password_change');
      }
      //check current password and new password do not match
      if($request->current_password == $request->password)
      {
        Session::flash('error', 'Please Choose another password.');
        return redirect('/password_change');
      }

      //update user new password
      $update = User::find(Auth::id());
      $update->password = bcrypt($request->input('password'));
      $update->save();

      Session::flash('success', 'Password Successfully Changed.');
      return redirect('/password_change');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Auth::user()->authorizeRoles(['employee', 'manager']);
        return view('layouts.index');
    }

    public function findJob()
    {
        $categories = Category::get();
        $myjobs = Myjob::orderBy('updated_at','DESC')->where('status', 1)->paginate(25);
        return view('layouts.available_jobs.view_available_jobs', compact('categories', 'myjobs'));
    }

    public function searchJob(Request $request) 
    {
        $this->validate($request, [
            'category' => 'required',
            'job_title' => 'required|max:500'
        ]);
        $categories = Category::get();

        $jobs = Myjob::where('cat_id', $request->category)->where('job_title', 'like', '%'.$request->job_title.'%')->where('status', 1)->paginate(25);
        return view('layouts.available_jobs.view_available_jobs', compact('jobs', 'categories'));
    }

    public function read($id)
    {
      $job = Myjob::find($id);
      $task = Task::where('job_id', $id)->where('created_by', Auth::id())->first();
      return view('layouts.available_jobs.read_available_job', compact('job', 'task'));
    }

    public function signup()
    {
        return view('layouts.auth.register');
    }

    public function loginToUserPanel($id){
      $user = User::find($id);
       //check if the current user is superadmin
    // $userRoles = Auth::user()->authorizeRoles(['SuperAdmin', 'Admin'])->toArray();
        if (Auth::user()->authorizeRoles(['SuperAdmin', 'Admin'])) {
             //login the user
             // Auth::login($user);          
             Auth::loginUsingId($id);          
        }
        // dd(Auth::id());
        return redirect('/jobs');
    }

    //send verification email for already registerd user
    public function sendVerifyEmail($id)
    {
      // $this->
      $user = User::find($id);
      //send email verification mail.
      $data = [
      'from' => 'do_not_reply@dolightjob.com',
      'name' => $user->name,
      'email' => $user->email,
      'url' => url('/').'/email-verify/'.$user->id.'/'.$user->remember_token,
      'subject' =>  'Verify Your Email | Dolightjob.com'
      ];

      $this->sendmail('auth.email_verification', $data);

      Session::flash('success', 'Email send successfull');
      return redirect('/user/'.$id);
    }

    public function messageRead($id)
    {
      $message = Message::find($id);
      $message->status = 1;
      $message->save();

      return response()->json(['status' => 'ok']);
    }

    public function referral()
    {
      $referrals = User::where('aff_id', Auth::id())->get();
      return view('layouts.referrals.view_referrals', compact('referrals'));
    }


    /*
      public function someAdminStuff(Request $request)
      {
        $request->user()->authorizeRoles('manager');
        return view(‘some.view’);
      }
      */
}

