<?php

namespace App\Http\Controllers;

use App\Myjob;
use Illuminate\Http\Request;
use App\Role;
use App\Vendor;
use App\Category;
use App\Subcategory;
use App\Diposit;
use App\Task;
use App\DepositBalance;
use Auth;
use Image;
use File;
use Session;
use DB;

class MyjobCtrl extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    //customized function
    function balance_check($worker, $worker_earn)
    {
        $auth_id = Auth::id();
        //get user diposited balance
        $balance = DB::table('diposits')->where('created_by', $auth_id)->where('status', 1)->sum('amount_usd');
        //Project cost calcuation
        $total_cost = $worker * $worker_earn;
        $total_cost = $total_cost + ($total_cost*10/100);
        return $balance - $total_cost;
    }

    public function userJobs($id)
    {
      $myjobs = Myjob::orderBy('id','DESC')->where('created_by', $id)->paginate(50);
        return view('layouts.myjobs.view_user_jobs', compact('myjobs'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myjobs = [];
        if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin'])){
          $myjobs = Myjob::orderBy('id','DESC')->paginate(25);
        }else{
          $myjobs = Myjob::orderBy('id','DESC')->where('created_by', Auth::id())->paginate(25);
        }
        return view('layouts.myjobs.view_myjob', compact('myjobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendors           = Vendor::all();
        $subcategories     = Subcategory::all();
        $categories        = Category::all();
        return view('layouts.myjobs.create_myjob', compact('vendors', 'categories', 'subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auth_id = Auth::id();

        $this->validate($request, [
          'job_title'      => 'required|max:255',
          'category'       => 'required',
          'sub_category'   => 'required',
          'description'    => 'required',
          'worker'         => 'required',
          'screenshot'     => 'required',
          'worker_earn'    => 'required',
          'country'        => '',
          'state'          => '',
          'total_cost'     => 'required',
          'estimated_day'  => 'required',
          'status'         => '',
          'note'           => ''
        ]);

        $cost = $request->worker * $request->worker_earn;
        $charge = $cost * 20/100;
        $total_cost = $cost + $charge;

        //balance check before post a job
        if( DepositBalance::where('user_id', Auth::id())->first()->amount < $total_cost ){
          Session::flash('error', 'We are sorry! you have no available balance to post this job. Please diposit your amount.');
          return redirect('/myjob/create');
        }

        $myjob = new myjob;
        $myjob->job_title     = $request->job_title;
        $myjob->cat_id        = $request->category;
        $myjob->sub_cat_id    = $request->sub_category;
        $myjob->description   = $request->description;
        $myjob->country       = $request->country;
        $myjob->state         = $request->state;
        $myjob->screenshot    = $request->screenshot;
        $myjob->worker_earn   = $request->worker_earn;
        $myjob->worker        = $request->worker;
        $myjob->total_cost    = $request->total_cost;
        $myjob->charge        = $charge;
        $myjob->estimated_day = $request->estimated_day;
        $myjob->delivery_date = date('Y-m-d', strtotime("+".$request->estimated_day.' day'));
        $myjob->note          = $request->note;
        //job status: 0 = pending, 1 = approved, 2 = cancelled, 3 = completed, 4 = pause, 5 = auto_pause
        $myjob->status        = $request->status ?? 0;
        $myjob->created_by    = $auth_id;

        if($request->auto_pause == 1 && $request->apply_limit > 0){
          $myjob->auto_pause = 1;
          $myjob->apply_limit = $request->apply_limit;
          $myjob->apply_counter = $request->apply_limit;
        }
        
        if($request->image > 0){
          $image = $request->file('image');
          $img = time() .'.'. $image->getClientOriginalExtension();
          $location = public_path('uploads/myjob/'.$img);
          Image::make($image)->save($location);
          $myjob->image = '/uploads/myjob/'.$img;
        }

        $myjob->save();
        //less deposit
        $this->deposit(Auth::id(), $total_cost, 'less');
        //find last entry id
        $myjob_id = Myjob::orderBy('id', 'DESC')->first()->id;

        //create a message to admin for approve request
        //{sender, receiver, receiver type, url, message}
        $msg = ['sender' => Auth::id(), 'receiver' => 0,  'receiver_type' => 'admin', 'url' => '/myjob/'.$myjob_id, 'message' => '[Myjob]: This job is under reviewing. Waiting for approval.'];
        $this->message($msg);

        // Session::flash('success', 'This job is under reviewing.');
        // return redirect('/myjob/'.$myjob_id);
        return response()->json(['status' => 'ok', 'msg' => 'This job is under reviewing.', 'id' => $myjob_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\myjob  $myjob
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $myjob = Myjob::find($id);
        if($myjob && $myjob->created_by == Auth::id() || $myjob && Auth::user()->authorizeRoles(['SuperAdmin', 'Admin'])){
          return view('layouts.myjobs.read_myjob', compact('myjob'));
        }
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\myjob  $myjob
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin'])){
        $vendors         = Vendor::all();
        $subcategories   = Subcategory::all();
        $categories      = Category::all();
        $myjob           = Myjob::find($id);
        return view('layouts.myjobs.edit_myjob', compact('vendors', 'categories', 'subcategories', 'myjob'));
      }
      return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\myjob  $myjob
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $myjob = Myjob::find($id);
      $auth_id = Auth::id();

      if($myjob->status == 0 || Auth::user()->authorizeRoles(['SuperAdmin', 'Admin'])){        
          $this->validate($request, [
            'job_title'      => 'required|max:255',
            // 'category'       => 'required',
            // 'sub_category'   => 'required',
            'description'    => 'required',
            'screenshot'     => 'required',
            'estimated_day'  => 'required',
            'status'         => '',
            'note'           => ''
            ]);
          
        // $this->validate($request, [
        //   // 'worker'         => 'required',
        //   // 'worker_earn'    => 'required',
        //   // 'country'        => '',
        //   // 'state'          => '',
        //   // 'total_cost'     => 'required',
        // ]);

        // $tasks = Task::where('job_id', $id)->get();
        // $charge = ($request->input('worker') * $request->input('worker_earn')) * 10/100;
        //update database
          $myjob->job_title     = $request->input('job_title');
          // $myjob->cat_id        = $request->input('category');
          // $myjob->sub_cat_id    = $request->input('sub_category');
          $myjob->description   = $request->input('description');
          $myjob->country       = $request->input('country');
          $myjob->state         = $request->input('state');
          $myjob->screenshot    = $request->input('screenshot');
          $myjob->estimated_day = $request->input('estimated_day');
          $myjob->note          = $request->input('note');
          // $myjob->worker_earn   = $request->input('worker_earn');
          // $myjob->worker        = $request->input('worker');
          // $myjob->total_cost    = $request->input('total_cost');
          // $myjob->charge        = $charge;
          // $myjob->delivery_date = date('Y-m-d', strtotime("+".$request->input('estimated_day').' day'));
          //job status: 0 = pending, 1 = approved, 2 = cancelled, 3 = completed, 4 = pause, 5 = auto_pause
          $myjob->status        = $request->input('status') ?? 0;
          $myjob->updated_by    = $auth_id;
          
          if($request->image > 0){
            if (File::exists($myjob->image)) {
                File::delete($myjob->image);
            }

          $image = $request->file('image');
          $img = time() .'.'. $image->getClientOriginalExtension();
          $location = public_path('uploads/myjob/'.$img);
          Image::make($image)->save($location);
          $myjob->image = '/uploads/myjob/'.$img;
        }
        $myjob->save();

        Session::flash('success', 'The Job successfully Updated.');
        return redirect('/myjob');
      }
        return redirect('/myjob');
    }

    public function autoPause(Request $request, $id)
    {
      $this->validate($request, [
        'auto_pause'  => 'numeric',
        'apply_limit' => 'numeric',
        ]);
      $tasks = Task::where('job_id', $id)->whereIn('status', [0,1,2])->get();
      $pause = Myjob::find($id);
      $pause->auto_pause = $request->auto_pause;
      $pause->apply_limit = $request->input('apply_limit');
      $pause->apply_counter = count($tasks)+$request->input('apply_limit');
      $pause->save();

      Session::flash('success', 'Auto Pause Enabled for this job.');
      return redirect('/myjob/'.$id);
    }

    //edit job by user
    public function editJob($id)
    {
      $job = Myjob::find($id);
      return view('layouts.myjobs.edit_job_by_user', compact('job'));
    }

    //update job by user
    public function updateJob(Request $request, $id)
    {
      $this->validate($request, [
        'worker' => 'required',
        'estimated_day' => 'required'
        ]);

      $job = Myjob::find($id);
      $depobalance = DepositBalance::where('user_id', $job->created_by)->first();
      
      //cost calculation
      $cost = $job->worker_earn * $request->input('worker');
      $charge = $cost*20/100;
      $total_cost = $cost+$charge;
      if($total_cost > $depobalance->amount){
        Session::flash('error', 'Please check your deposit balance.');
        return redirect('/myjob/'.$id);
      }else{
        //update
        $update = $job;
        $update->worker = $job->worker+$request->input('worker');
        $update->estimated_day = $request->input('estimated_day');
        $update->charge = $job->charge+$charge;
        $update->total_cost = $job->total_cost+$total_cost;
        $update->estimated_day = $request->input('estimated_day');
        $update->status = 1;
        $update->save();

        //less deposit
        $this->deposit($job->created_by, $total_cost, 'less');
        Session::flash('success', 'The successfully updated.');
      }
      return redirect('/myjob/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\myjob  $myjob
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $myjob = Myjob::find($id);
      if($myjob->status == 0 || $myjob->status == 4){
        if (File::exists($myjob->image)) {
          File::delete($myjob->image);
        }
        $myjob->delete();

        $amount = 0;

        if($myjob->status == 0){
          $amount = $myjob->total_cost;
        }elseif($myjob->status == 4){
          $tasks = Task::where('job_id', $id)->whereIn('status', [1,2])->get();
          $amount = ($myjob->worker - count($tasks)) * $myjob->worker_earn;
        }
        //update balance and reback the money
        $this->deposit($myjob->created_by, $amount, 'add');

        Session::flash('success', 'This myjob Successfully deleted.');
        return redirect('/myjob');
      }
      return back();
    }

    //my job proves
    public function myjob_prove($id)
    {
      $proves = Task::leftJoin('users', 'users.id', 'tasks.created_by')
      ->leftJoin('myjobs', 'myjobs.id', 'tasks.job_id')
      ->where('job_id', $id)->orderBy('tasks.id', 'DESC')
      ->select('tasks.*', 'myjobs.job_title','myjobs.worker', 'myjobs.total_cost', 'myjobs.estimated_day', 'users.name')->paginate(25);
      return view('layouts.myjobs.view_myjob_prove', compact('proves'));
    }

    public function prove_allow($id)
    {
      $task = Task::leftJoin('myjobs', 'myjobs.id', 'tasks.job_id')
      ->leftJoin('users', 'users.id', 'tasks.created_by')
      ->select('tasks.*', 'users.name', 'myjobs.job_title', 'myjobs.note')->find($id);
      return view('layouts.myjobs.read_prove', compact('task'));
    }

    //job pause by user
    public function jobPause($id)
    {
      $job = Myjob::find($id);
      if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']) || $job->created_by == Auth::id()){
        if($job->status == 1 || $job->status == 4 || $job->status == 5){
          $update = $job;
          $update->status = $job->status == 4 || $job->status == 5?1:4;
          $update->save();
        }

        if($job->status == 4 || $job->status == 5){
          Session::flash('success', 'The job paused successfully.');
        }elseif($job->status == 1){
          Session::flash('success', 'The job resumed successfully.');
        }

        return redirect('/myjob/'.$id);
      }
    }

    //job approve by admin
    public function approve($id)
    {
      $job = Myjob::find($id);
      if( Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']) && $job->status == 0) {
        $job->status = 1;
        $job->save();

        //create a message to admin for approve request
        //{sender, receiver, receiver type, url, message}
        $msg = ['sender' => Auth::id(), 'receiver' => $job->created_by,  'receiver_type' => 'user', 'url' => '/myjob/'.$id, 'message' => '[Job]: Your job is approved.'];
        $this->message($msg);

        Session::flash('success', 'The job successfully approved.');
      }
      return redirect('/myjob/'.$id);
    }


    //search myjob by admin
    public function myjobSearch(Request $request)
    {
      if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin'])){
        $this->validate($request, ['myjob_name' => 'required']);
        $myjobs = Myjob::where('id', $request->myjob_name)->orWhere('job_title', 'like', '%'.$request->myjob_name.'%')->paginate(25);
        // dd($myjobs);
        return view('layouts.myjobs.view_myjob', compact('myjobs'));
      }
      return back();
    }
    
}