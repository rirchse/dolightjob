<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Myjob;
use App\Task;
use App\User;
use Session;
use Cookie;
use DB;

class HomeController extends Controller
{
  /* cron job methods */
  public function backAutoPause()
  {
    // $cur_time = strtotime(date('Y-m-d H:i:s'));
    //   $pause_time = strtotime('2021-10-16 9:00');
    //   dd(number_format(($cur_time - $pause_time)/60,0));
    //   dd(date('Y-m-d H:i:s'));
    $time = '';

    $counter = 0;
    //find jobs thats active, completed, paused, autopaused
    $jobs = Myjob::where('status', 5)->get(); /* 5 = auto paused */
    foreach ($jobs as $job) {
      //time calc
      $cur_time = strtotime(date('Y-m-d H:i:s'));
      $paused_time = strtotime($job->paused_time);
      if(($cur_time - $paused_time)/60 > 30){
        $udpate = Myjob::find($job->id);
        $udpate->status = 1;
        $udpate->save();
      }

      
        // $time .= number_format(($cur_time - $paused_time)/60,0).'/';
    }
    // dd(($cur_time - $paused_time)/60 < 30);
  }
  public function completeTask()
  {
    $counter = 0;
    //find jobs thats active, completed, paused, autopaused
    $jobs = Myjob::whereIn('status', [1,3,4,5])->get(); /* 2 = job completed */
    foreach ($jobs as $job) {
      //date calculation
      $db_date = strtotime(date('Y-m-d', strtotime($job->created_at)));
      $cur_date = strtotime(date('Y-m-d'));
      $delivery_at = ($cur_date-$db_date)/60/60/24;
      if($job->estimated_day <= $delivery_at){
        $tasks = Task::where('job_id', $job->id)->where('status', 1)->get();
        foreach($tasks as $task){
          $update = Task::find($task->id);
          $update->earning = $job->worker_earn;
          $update->status = 2; /* 2 = task done */
          $update->save();

          //add balance
          $this->earning($task->created_by, $task->earning, 'add');
        }
      }
    }
    Session::flash('success', 'Total '.$counter.' jobs satisfied.');
    return back();
  }

  //delete time over task
  public function deleteTimeOverTask()
  {
    $counter = 0;
    $jobs = Myjob::whereIn('status', [1,3,4,5])->get(); /* 2 = job completed */
    foreach ($jobs as $job) {
      $tasks = Task::where('job_id', $job->id)->where('status', 0)->get();
        foreach($tasks as $task){
          $hour = (strtotime(date('Y-m-d H:i'))-strtotime($task->created_at))/60/60;
          if($hour > 6){
            $task->delete();
            $counter++;
          }
        }
      }
      Session::flash('success', 'Total '.$counter.' Time Over Tasks deleted.');
      return back();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        Auth::user()->authorizeRoles(['employee', 'manager']);
        return view('layouts.index');
    }

    public function affiliation($id)
    {
      $user = User::find($id);
      if($user){
        Session::put('_aff', $id);
      }
      return redirect('/signup');
      // return Session::get('_aff', $id);
    }

    // public function someAdminStuff(Request $request)
    // {
    //     $request->user()->authorizeRoles('manager');
    //     return view('manager');
    // }

    public function sendTestMail()
    {
      //send email verification mail.
      $data = [
      'from' => 'do_not_reply@dolightjob.com',
      'name' => 'Test CronJOb',
      'email' => 'rirchse@gmail.com',
      'url' => url('/').'/home/',
      'subject' =>  'We are checking cron job | Dolightjob.com'
      ];

      //send email to registerd user
      $this->sendmail('auth.email_reset_password', $data);
    }

    public function cronjobtest()
    {
      DB::table('cronjobs')->insert(['job_id' => 1, 'created_at' => date('Y-m-d H:i:s')]);
    }

    public function setCookie()
    {
      // $minutes = 60;
      // $response = new Response('Set Cookie');
      // $response->withCookie(cookie('name', 'MyValue', $minutes));
      $response = Cookie::queue('name', 'user_ditection_cookies', 60);
      return $response;
    }

    public function getCookie()
    {
     $cookie = Cookie::get('name');
     dd($cookie);
    }
}
