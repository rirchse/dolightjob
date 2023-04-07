<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;
use App\Sale;
use App\Customer;
use App\Myjob;
use App\User;
use App\Role;
use Auth;
use Image;
use File;

class PaymentCtrl extends Controller
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
        
    public function index($id)
        {
            $sale = Sale::leftJoin('myjobs', 'myjobs.id', 'sales.myjob_id')
            ->leftJoin('customers', 'customers.id', 'sales.customer_id')
            ->select('sales.*', 'myjobs.name', 'customers.first_name', 'customers.last_name')
            ->find($id);
            $payments = Payment::all();
            return view('layouts.sales.view_payment', compact('sale', 'payments'));
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Table join (table name--->products  )and get id(products.id)
    //select item for select function (sales.* == sales all data get) and product.name == products table product name select
    public function getPayment($id)
    {   
        $sale = Sale::leftJoin('myjobs', 'myjobs.id', 'sales.myjob_id')
        ->leftJoin('customers', 'customers.id', 'sales.customer_id')
        ->select('sales.*', 'myjobs.name', 'customers.first_name', 'customers.last_name')
        ->find($id);
        return view('layouts.sales.create_payment', compact('sale'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payment = new Payment;
        $payment->sales_id      = $request->sales_id;
        $payment->paid_amount   = $request->pay_amount;
        $payment->payment_date  = date('Y-m-d H:i:s');
        $payment->received_by   = Auth::id();
        $payment->details       = 'On sale';
        $payment->status        = 1;
        $payment->created_by    =Auth::id();
        $payment->save();
        Toastr::success('Payment Successfully Saved' , 'Success');
        return redirect()->route('sale.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $sale = Sale::leftJoin('myjobs', 'myjobs.id', 'sales.myjob_id')
        ->leftJoin('customers', 'customers.id', 'sales.customer_id')
        ->select('sales.*', 'myjobs.name', 'customers.first_name', 'customers.last_name')
        ->find($id);
        $payment = Payment::find($id);
        return view('layouts.sales.read_payment', compact('sale', 'payment'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $payment = Payment::find($id);
        return view('layouts.sales.edit_payment', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $payment = Payment::find($id);
        $payment->paid_amount   = $request->paid_amount;
        $payment->payment_date  = date('Y-m-d H:i:s');
        $payment->received_by   = Auth::id();
        $payment->details       = 'On sale';
        $payment->status        = 1;
        $payment->updated_by    = Auth::id();
        $payment->save();
        Session::flash('success', 'Payment Successfully Saved.');
        return redirect('/payment/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Payment::find($id);
        $payment->delete();
        Session::flash('success', 'This Payment Successfully deleted.');
        return redirect('/payment');
    }
}
