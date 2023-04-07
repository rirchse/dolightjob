<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Withdrawal;
use App\EarningBalance;
use App\User;
use Auth;
use Session;

class WithdrawCtrl extends Controller
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

    public function userWithdraw($id){
      $user = User::find($id);
      $withdrawals = Withdrawal::orderBy('id', 'DESC')->where('created_by', $id)->paginate(50);
      return view('layouts.withdraw.view_user_withdraw', compact('withdrawals', 'user'));
    }

    public function index()
    {
    	$withdrawals = Withdrawal::orderBy('id', 'DESC')->where('created_by', Auth::id())->paginate(2);
        if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
        {
           $withdrawals = Withdrawal::orderBy('id', 'DESC')->paginate(2);
        }
        
    	return view('layouts.withdraw.view_withdraw', compact('withdrawals'));
    }

    public function create()
    {
    	return view('layouts.withdraw.create_withdraw');
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'account_type' => 'required',
    		'amount'       => 'required',
    		'account_no'   => 'required',
    		'note'         => 'max:1000'
    		]);

      //cost calc
      $charge    = $request->amount*20/100;      
      $bdt       = ($request->amount-$charge)*85;
      $total_usd = $request->amount;

      $balance = EarningBalance::where('user_id', Auth::id())->first();
      // return $request;

      if($balance->amount < $request->amount || $request->amount < 0.70)
      {
        Session::flash('error', 'Please check your earning balance and amount of withdraw.');
        return redirect('/withdraw');
      }

    	$store = New Withdrawal;
    	$store->account_type = $request->account_type;
      $store->usd        = $request->amount;
      $store->bdt        = $bdt;
      $store->charge     = $charge;
    	$store->percent    = $request->parcent;
    	$store->account_no = $request->account_no;
    	$store->note       = $request->note;
    	$store->created_by = Auth::id();
    	$store->save();

      //less balance
      $this->earning(Auth::id(), $total_usd, 'less');
      //create a message to admin for approve request {sender, receiver, receiver type, url, message}
      $msg = ['sender' => Auth::id(), 'receiver' => 0,  'receiver_type' => 'admin', 'url' => '/withdraw/', 'message' => '[Withdraw]: Your request is under reviewing. Please wait for approval.'];
      $this->message($msg);

    	Session::flash('success', 'The transaction successfully completed. Please wait for while the system will approve your transaction. Thank you for transaction.');
    	return redirect('/withdraw');
    }

    public function approve($id)
    {
      if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
      {
      	$withdraw = Withdrawal::find($id);
      	$withdraw->status = 1;
        $withdraw->approved_by = Auth::id();
      	$withdraw->save();

        //referal bonus 
        $refer = User::find($withdraw->created_by);
        $wdras = Withdrawal::where('created_by', $refer->id)->where('status', 1)->get();
        if($refer->aff_id && count($wdras) == 1){
          $refer->aff_bonus = 0.05;
          $refer->save();

          //add deposit
          $this->earning($refer->aff_id, 0.05, 'add');
        }

      	Session::flash('success', 'The transaction successfully approved.');
      	return redirect('/withdraw');
      }
    }

    public function rechargeRequest()
    {
      return view('layouts.withdraw.create_recharge_request');
    }

    public function mobileRecharge(Request $request)
    {
      $this->validate($request, [
        'account_type'  => 'required',
        'amount'        => 'required',
        'account_no'    => 'required',
        'note'  => 'max:1000'
        ]);

      //cost calc
      $usd = $request->amount/85;
      $charge = $usd*20/100;
      $total_usd = $usd+$charge;

      $balance = EarningBalance::where('user_id', Auth::id())->first();

      if($balance->amount < $total_usd || $request->amount < 0.235)
      {
        Session::flash('error', 'Your balance not applicable for Mobile Recharge request. Please check your earning balance.');
        return redirect('/withdraw/mobile/recharge');
      }

      $store = New Withdrawal;
      $store->account_type = $request->account_type;
      $store->usd        = $usd+$charge;
      $store->bdt        = $request->amount;
      $store->charge     = $charge;
      $store->percent    = $request->parcent;
      $store->account_no = $request->account_no;
      $store->note       = $request->note;
      $store->request_type = 'Mobile Recharge';
      $store->created_by = Auth::id();
      $store->save();

      //less balance
      $this->earning(Auth::id(), $total_usd, 'less');
      //create a message to admin for approve request {sender, receiver, receiver type, url, message}
      $msg = ['sender' => Auth::id(), 'receiver' => 0,  'receiver_type' => 'admin', 'url' => '/withdraw/', 'message' => '[Mobile Recharge]: Your request is under reviewing. Please wait for approval.'];
      $this->message($msg);

      Session::flash('success', 'Mobile Recharge successfully completed. Please wait for while the system will approve your recharge request. Thank you.');
      return redirect('/withdraw');
    }

    public function delete($id)
    {
      $withdraw = Withdrawal::find($id);
      $this->earning($withdraw->created_by, $withdraw->usd+$withdraw->charge, 'add');
      $withdraw->delete();

      return redirect('/withdraw/');
    }
}