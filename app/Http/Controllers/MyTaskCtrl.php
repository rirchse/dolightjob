<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Myjob;
use App\Task;
use App\User;
use App\EarningBalance;
use App\Withdrawal;
use Auth;
use Session;
use Image;

class MyTaskCtrl extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
      // Auth::user()->authorizeRoles(['employee', 'manager']);
      $tasks = Myjob::leftJoin('tasks', 'myjobs.id', 'tasks.job_id')->orderBy('tasks.id','DESC')->where('tasks.created_by', Auth::id())->paginate(25);
      return view('layouts.my_tasks.view_my_task', compact('tasks'));
    }
    /* view user task by admin */
    public function userTasks($id)
    {
      $user = User::find($id);
      $tasks = Task::leftJoin('myjobs', 'myjobs.id', 'tasks.job_id')->where('tasks.created_by', $id)->paginate(50);
      return view('layouts.my_tasks.view_user_tasks', compact('tasks', 'user'));
    }

    public function apply($id)
    {
      $job = Myjob::find($id);
      $tasks = Task::where('job_id', $id)->whereIn('status', [0,1,2])->get();
      $task = Task::where('job_id', $id)->where('created_by', Auth::id())->first();
      if(count($tasks) >= $job->worker){
        Session::flash('error', 'The job already completed.');
        return redirect('/jobs');
      }else if($task){
        Session::flash('error', 'You already applied to the job.');
        return redirect('/jobs');
      }else{
        $store = New Task;
        $store->job_id = $job->id;
        $store->client_id = $job->created_by;
        $store->agreement = 'Yes';
        $store->earning = $job->worker_earn;
        $store->status = 0;
        $store->created_by = Auth::id();
        $store->save();
      }

      $task_count = count($tasks)+1;

      if($job->auto_pause == 1 && $task_count == $job->apply_counter && $task_count < $job->worker)
      {
        $job->status = 5; //5 = auto_pause
        $job->apply_counter = $task_count+$job->apply_limit; //5 = auto_pause
        $job->paused_time = date('Y-m-d H:i:s');
        $job->save();
      }

      //pause the job when workers fillup
      if($task_count >= $job->worker){
        $job->status = 3; //job status: 0 = pending, 1 = approved, 2 = cancelled, 3 = completed, 4 = pause, 5 = auto_pause
        $job->save();
      }

      Session::flash('success', 'You have applied to the job successfully. Now you need to do work and submit.');
      return redirect('/jobs/'.$id);
    }

    public function cancel($id)
    {
        $task = Task::find($id);
        $task->delete();
        Session::flash('success', 'The task cancelled.');
        return redirect('/mytask');
    }

    public function task_submit(Request $request, $id)
    {
      $this->validate($request, [
        'job_id' => 'required',
        'required_proof' => 'required',
        'screenshot' => 'image|max:5000',
        'screenshot_2' => 'image|max:5000'
        // 'screenshot' => 'image|mimes:jpeg,jpg,png,gif|max:1500'
        ]);
      $task = Task::find($id);
      // $myjob = Myjob::find($request->job_id);
      if($task->status == 1)
      {
        Session::flash('error', 'The task already submitted.');
        return redirect('/mytask');
      }
      
      $update = Task::find($id);
      $update->status = 1;
      $update->proof = $request->required_proof;

      //screenshot one
      if($request->screenshot > 0){
        $image = $request->file('screenshot');
        $img = $request->name.'_'.time() .'.'. $image->getClientOriginalExtension();
        $location =  public_path('uploads/task/'.$img);
        Image::make($image)->save($location);
        $update->screenshot = '/uploads/task/'.$img;
      }
      //screenshot two
      if($request->screenshot_2 > 0){
        $image = $request->file('screenshot_2');
        $img2 = $request->name.'2_'.time() .'.'. $image->getClientOriginalExtension();
        $location =  public_path('uploads/task/'.$img2);
        Image::make($image)->save($location);
        $update->screenshot_2 = '/uploads/task/'.$img2;
      }

      $update->save();
      Session::flash('success', 'The task submitted successfully.');
      return redirect('/mytask');
    }

    public function task_approve(Request $request, $id)
    {
      $this->validate($request, [
        'approval' => 'required',
        'note' => ''
      ]);

      $task = Task::find($id);
      $job = Myjob::find($task->job_id);
      $approval = $request->input('approval');

      $update = $task;
      $update->approval = $approval;
      $update->earning = $approval == 'Satisfy'?$job->worker_earn:NULL;
      $update->comment = $request->input('note');
      $update->feedback = $approval == 'Satisfy'?$request->input('feedback'):NULL;
      $update->status = $approval == 'Satisfy'?2:3;
      $update->save();

      $task = Task::find($id);
      //add balance
      if($approval == 'Satisfy' && $task->status == 2){
        //balance function created in main controller
        $this->earning($task->created_by, $task->earning, 'add');
      }

      //if job completed and work not complete
      if($approval == "Unsatisfied" && $job->status == 3 && count(App\Task::whereIn('status', [0,1,2])->get()) < $job->worker){
        $job->status = 1;
        $job->save();
      }

      return response()->json(['status' => $task->status, 'msg' => 'Approval successful', 'id' => $id]);
    }

    public function makeBal()
    {
      if(Auth::user()->authorizeRoles(['SuperAdmin'])){
        $users = User::get();
        foreach($users as $user){
          //task status: 0 = applied, 1= pending, 2= satisfied, 3 = unsatisfied.
          $earning = Task::where('created_by', $user->id)->where('status', 2)->sum('earning');
          //withdraw status: 0 = pending, 1 = approved, 3 = disapproved.
          $withdraw = Withdrawal::where('created_by', $user->id)->where('status', 1)->sum('usd', 'charge');

          $balance = EarningBalance::where('user_id', $user->id)->first();
          if(!$balance){
            $create_balance = New EarningBalance;
            $create_balance->amount = $earning-$withdraw;
            $create_balance->user_id = $user->id;
            $create_balance->save();
          }
        }
        return '<h1>User balance creation successful</h1>';
      }
      return redirect('/home');
    }

    //ajax call
    public function getTask($id)
    {
      $task = Task::find($id);
      return response()->json($task);
    }

    //delete task
    public function delete($id)
    {
      $task = Task::find($id);
      $task->delete();
      Session::flash('success', 'The task successfully deleted.');
      return redirect('/myjob/'.$task->job_id.'/prove');
    }

    /*
      public function someAdminStuff(Request $request)
      {
        $request->user()->authorizeRoles('manager');
        return view(‘some.view’);
      }
      */
}
