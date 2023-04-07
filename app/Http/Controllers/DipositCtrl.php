<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Myjob;
use App\Task;
use App\Diposit;
use App\User;
use App\DepositBalance;
use App\EarningBalance;
use Auth;
use Session;

class DipositCtrl extends Controller
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

    public function userDeposits($id)
    {
      $diposits = Diposit::leftJoin('users', 'users.id', 'diposits.created_by')->orderBy('diposits.id', 'DESC')->select('diposits.*', 'users.name', 'users.id as user_id')->where('diposits.created_by', $id)->paginate(50);
      return view('layouts.diposits.view_user_diposits', compact('diposits'));
    }

    public function index()
    {
    	$diposits = Diposit::orderBy('id', 'DESC')->where('created_by', Auth::id())->paginate(20);
        if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
        {
           $diposits = Diposit::orderBy('id', 'DESC')->paginate(20);
        }
    	return view('layouts.diposits.view_diposits', compact('diposits'));
    }

    public function earningDeposit()
    {
      return view('layouts.diposits.earning_to_diposit');
    }

    public function create()
    {
    	return view('layouts.diposits.create_diposit');
    }

    public function store(Request $request)
    {
      if($request->account_type == 'Earning-Deposit'){
        $this->validate($request, [
          'account_type'   => 'required',
          'usd' => 'required|numeric|min:0.20',
          'bdt' => 'required|numeric|min:17',
        ]);
      }else{
      	$this->validate($request, [
      		'account_type' 	=> 'required',
          'bdt' => 'required|numeric|min:85',
      		'usd' => 'required|numeric|min:1',
      		'account_no' => 'required',
      		'transaction_id' => 'required',
      		'note' 	=> 'max:1000'
      	]);
      }

      //find depositor/auth user earning balance
      $balance = EarningBalance::where('user_id', Auth::id())->first();
      //check depositor/auth user earning balance
      if($request->account_type == 'Earning-Deposit' && $balance->amount < $request->usd)
      {
        Session::flash('error', 'Insufficient Earning Balance');
        return back();
      }

    	$store = New Diposit;
    	$store->account_type = $request->account_type;
      $store->amount_bdt   = $request->bdt;
    	$store->amount_usd   = $request->usd;
    	$store->account_no   = $request->account_no;
    	$store->transaction_id = $request->transaction_id;
      $store->note         = $request->note;
    	$store->status       = $request->account_type == 'Earning-Deposit'?1:0;
    	$store->created_by   = Auth::id();
    	$store->save();

      //add deposit
      if($request->account_type == 'Earning-Deposit'){
        $this->deposit(Auth::id(), $request->usd, 'add');
        $this->earning(Auth::id(), $request->usd, 'less');
      }

      //create a message to admin for approve request {sender, receiver, receiver type, url, message}
      $msg = ['sender' => Auth::id(), 'receiver' => 0,  'receiver_type' => 'admin', 'url' => '/diposit/', 'message' => '[Deposit]: The deposit is under reviewing. Please wait for approval.'];
      $this->message($msg);

    	Session::flash('success', 'The amount successfully diposited.');
    	return redirect('/diposit');
    }

    public function approve($id)
    {
      $update = Diposit::find($id);
      if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']) && $update->status == 0)
      {
      	$update->status = 1;
        $update->approved_by = Auth::id();
      	$update->save();

        //add deposit
        $this->deposit($update->created_by, $update->amount_usd, 'add');

      	Session::flash('success', 'The diposited amount successfully approved.');
      	return redirect('/diposit');
      }
      Session::flash('error', 'Already approved.');
      return redirect('/diposit');
    }

    public function delete($id)
    {
      $depo = Diposit::find($id);
      $depo->delete();

      //back money to the depositor
      if($depo->account_type == 'Earning-Deposit'){
        $this->earning($depo->created_by, $depo->amount_usd, 'add');
      }

      Session::flash('success', 'The item successfully deleted.');
      return back();
    }

  public function makeDeposit()
  {
    //make user deposit balance
    $users = User::get();
    foreach($users as $user)
    {
      $deposit = Diposit::where('created_by', $user->id)->where('status', 1)->sum('amount_usd');
      $jobpost = Myjob::where('created_by', $user->id)->sum('total_cost', 'charge');
      $balance = DepositBalance::where('user_id', $user->id)->first();
      if(!$balance)
      $create = New DepositBalance;
      $create->amount = $deposit - $jobpost;
      $create->user_id = $user->id;
      $create->save();
    }
    return '<h1>Depo balance created.</h1>';
  }

}