<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\RoleUser;
use App\Task;
use App\Myjob;
use App\Diposit;
use App\Withdrawal;
use App\EarningBalance;
use App\DepositBalance;
use Auth;
use Image;
use File;
use Session;
use DB;

class UserCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin'])){
        $users = User::orderBy('id','DESC')->paginate(25);
        return view('layouts.users.view_users', compact('users'));
      }
      return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('layouts.users.create_new_user', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $this->validate($request, [
            'user_role' => 'required',
            'name'      => 'required|max:255',
            'contact'   => 'required',            
        ]);


       $user = new User;
       $user->name       = $request->name;
       $user->contact    = $request->contact;
       $user->email      = $request->email;
       $user->password   = bcrypt($request->password);
       $user->created_by = Auth::id();
       
       if($request->image > 0){
            $image       = $request->file('image');
            $img         = time() .'.'. $image->getClientOriginalExtension();
            $location    = public_path('uploads/user/'.$img);
            Image::make($image)->save($location);
            $user->image = '/uploads/user/'.$img;
        }
        $user->save();

        //create permission
        // $role_user_tbl = DB::table('role_user');
        $last_user_id = User::orderBy('id', 'DESC')->first()->id;
        $role_user = DB::table('role_user');
        $role_user->role_id = $request->user_role;
        $role_user->user_id = $last_user_id;
        $role_user->save();

    Session::flash('success', 'User Successfully Saved.');
    return redirect('/user');

}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //user activitis
        $task = [];
        $working = $task_pending = $task_satisfied = $unsatisfied = $earning = 0;
        $tasks = Task::where('created_by', $id)->get();
        foreach($tasks as $task){
            if($task->status == 0){
                $working++;
            }elseif($task->status == 1){
                $task_pending++;
            }elseif($task->status == 2){
                $task_satisfied++;
                $earning += $task->earning;
            }elseif($task->status == 3){
                $unsatisfied++;
            }
        }
        $task = [
        'working' => $working,
        'pending' => $task_pending,
        'satisfied' => $task_satisfied,
        'unsatisfied' => $unsatisfied,
        'earning' => $earning,
        ];

        //user job posts
        $job = [];
        $job_pending = $job_active = $cancel = $completed = $pause = $autopause = $job_cost = 0;
        $jobs = Myjob::where('created_by', $id)->get();
        if(count($jobs) > 0){
          foreach($jobs as $job){
            $job_cost += $job->total_cost+$job->charge;
            if($job->status == 0){
              $job_pending ++;
            }elseif($job->status == 1){
              $job_active ++;
            }elseif($job->status == 2){
              $cancel ++;
            }elseif($job->status == 3){
              $completed ++;
            }elseif($job->status == 4){
              $pause ++;
            }elseif($job->status == 9){
              $autopause ++;
            }
          }
        }

        $job = [
        'pending' => $job_pending,
        'active' => $job_active,
        'cancelled' => $cancel,
        'completed' => $completed,
        'pause' => $pause,
        'autopause' => $autopause,
        'job_cost' => $job_cost
        ];

        //user diposit
        $deposit = [];        
        $depsit_pending = $deposit_active = $deposit_cancelled = $deposited = 0;
        $deposits = Diposit::where('created_by', $id)->get();
        foreach($deposits as $deposit){
            if($deposit->status == 0){
                $depsit_pending++;
            }elseif($deposit->status == 1){
                $deposit_active++;
                $deposited += $deposit->amount_usd;
            }elseif($deposit->status == 2){
                $deposit_cancelled++;
            }
        }
        $deposit = [
        'pending' => $depsit_pending,
        'active' => $deposit_active,
        'cancelled' => $deposit_cancelled,
        'deposited' => $deposited
        ];

        // user withdrawal
        $withdraw = [];
        $withdraw_pending = $approved = $withdraw_cancelled = $withdrawan = 0;
        $withdrawals = Withdrawal::where('created_by', $id)->get();
        foreach($withdrawals as $withdraw){
            if($withdraw->status == 0){
                $withdraw_pending++;
            }elseif($withdraw->status == 1){
                $approved++;
                $withdrawan += $withdraw->usd;
            }elseif($withdraw->status == 2){
                $withdraw_cancelled++;
            }
        }

        $withdraw = [
        'pending' => $withdraw_pending,
        'approved' => $approved,
        'cancelled' => $withdraw_cancelled,
        'withdrawan' => $withdrawan
        ];

        $user = User::find($id);
        $user_role = DB::table('role_user')->leftJoin('roles', 'roles.id', 'role_user.role_id')->where('role_user.user_id', $id)->first();
        return view('layouts.users.read_user', compact('user', 'user_role', 'task', 'job', 'deposit', 'withdraw'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        $user_role = DB::table('role_user')
        ->leftJoin('roles', 'roles.id', 'role_user.role_id')
        ->where('role_user.user_id', $user->id)->first();
        return view('layouts.users.edit_user_account', compact('user', 'roles', 'user_role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'user_role' => 'max:9999',
            'name'      => 'required|max:255',
            'contact'   => 'required',
            'email'     => 'required',
            'status'    => '',
        ]);

        $users = User::find($id);
        $users->name       = $request->input('name');
        $users->contact    = $request->input('contact');
        $users->email      = $request->input('email');
        $users->status     = $request->input('status');
        $users->updated_by = Auth::id();

        if($request->image > 0){
          if (File::exists($users->image)) {
            File::delete($users->image);
          }

          $image = $request->file('image');
          $img = $request->name.'_'.time() .'.'. $image->getClientOriginalExtension();
          $location =  public_path('uploads/user/'.$img);
          Image::make($image)->save($location);
          $users->image = '/uploads/user/'.$img;
        }
        $users->save();

        //update permission
        if($request->input('user_role')){
          $update = DB::table('role_user')->where('user_id', $id)->update(['role_id' => $request->input('user_role')]);
        }

        Session::flash('success', 'User Successfully Updated');
        return redirect('/user/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $user = User::find($id);
       if (File::exists($user->image)) {
        File::delete($user->image);
    }
    $user->delete();
    
    Session::flash('success', 'User Successfully Deleted.');
    return redirect()->route('users.index');
}

  public function userSearch(Request $request)
  {
    $this->validate($request, [
      'user' => 'required|max:50'
      ]);
    $user = $request->user;
    $users = User::where('id', $user)->orWhere('name', 'like', '%'.$user.'%')->orWhere('email', $user)->orWhere('contact', $user)->paginate(50);
    return view('layouts.users.view_users', compact('users'));
  }

  //update user balance
  public function updateUserEarning($id)
  {
    $user = User::find($id);
    $earning = Task::where('created_by', $id)->where('status', 2)->sum('earning');
    $withdraw = Withdrawal::where('created_by', $id)->where('status', 1)->sum('usd', 'charge');
    $update = EarningBalance::where('user_id', $id)->first();
    $update->amount = $earning - $withdraw;
    $update->save();

    Session::flash('success', 'Balance Successfully Updated.');
    return redirect('/user/'.$id);
  }

  //update user deposit balance
  public function updateUserDeposit($id)
  {
    $user = User::find($id);
    $deposit = Diposit::where('created_by', $id)->where('status', 1)->sum('amount_usd');
    //job status: 0 = pending, 1 = approved, 2 = cancelled, 3 = completed, 4 = pause, 5 = auto_pause
    $job_post = Myjob::where('created_by', $id)->whereIn('status', [0, 1, 3, 4,5])->sum('total_cost');
    $update = DepositBalance::where('user_id', $id)->first();
    $update->amount = $deposit - $job_post;
    $update->save();

    Session::flash('success', 'Deposit Balance Successfully Updated.');
    return redirect('/user/'.$id);
  }

  //user review for public
  public function userReview($id)
  {
    $user = User::find($id);
    if($user){
      return view('layouts.users.read_user_review', compact('user'));
    }
    return;
  }
}
