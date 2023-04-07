<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\EarningBalance;
use App\DepositBalance;
use App\Task;
use App\Message;
use Session;
use Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //alert and return
    // public function action($type, $msg, $to)
    // {
    // 	Session::flash($type, $msg);
    // 	return redirect($to);
    // }

  public function earning($user_id, $amount, $type)
  {
    //add balance to user
    $balance = EarningBalance::where('user_id', $user_id)->first();
    if($balance){
      $update_balance = EarningBalance::find($balance->id);
      $update_balance->pre_amount = $balance->amount;
      $update_balance->amount = $type == 'add'?$balance->amount + $amount : $balance->amount - $amount;
      $update_balance->save();
    }else{
      $create_balance = New EarningBalance;
      $create_balance->amount = $amount;
      $create_balance->user_id = $user_id;
      $create_balance->save();
    }
  }

  public function deposit($user_id, $amount, $type)
  {
  	//add deoposit
    $balance = DepositBalance::where('user_id', $user_id)->first();
    if($balance){
      $balance->pre_amount = $balance->amount;
      $balance->amount = $type == 'add'?$balance->amount + $amount : $balance->amount - $amount;
      $balance->save();
    }else{
      $create = New DepositBalance;
      $create->amount = $amount;
      $create->user_id = $user_id;
      $create->save();
    }
  }


  //create notifications
  //$sender, $receiver, $receiver_type, $url, $msg
  public function message($msg)
  {
    $create = New Message;
    $create->sender = $msg['sender'];
    $create->receiver = $msg['receiver'];
    $create->receiver_type = $msg['receiver_type'];
    $create->url = $msg['url'];
    $create->message = $msg['message'];
    $create->save();
  }

  public function sendmail($template, $data)
  {
    // Mail::send('auth.email_verification', $data, function($message) use ($data){
    Mail::send($template, $data, function($message) use ($data){
      $message->from($data['from']);
      $message->to($data['email']);
      $message->subject($data['subject']);
    });
  }

}
