<?php

namespace App\Http\Controllers;

use App\Sale;
use Illuminate\Http\Request;
use App\Customer;
use App\Myjob;
use App\Payment;
use App\User;
use App\Role;
use Auth;
use Image;
use App\OrderItem;
use File;
use Session;

class SaleCtrl extends Controller
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
        $sales = Sale::orderBy('id','desc')->get();
        return view('layouts.sales.view_sale', compact('sales'));
    }

    // public function payment($id)
    // {
    //     $sale = Sale::find($id);
    //     return view('layouts.sales.create_payment',compact('sale'));
    // }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $items = Myjob::where('status', 1)->get();
        return view('layouts.sales.create-sale', compact('items'));
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
            'customer_id'       => 'required',
            'sales_date'        => 'required',
            'referral_name'     => '',
            'referral_contact'  => '',
            'referral_address'  => '',
            'sales_type'        => 'required',
            'total_price'       => 'required',
            'paid'              => '',
            'due'               => '',
            'sold_by'           => '',
            'details'           => ''
        ]);

        $sale = new Sale;
        $sale->customer_id       = $request->customer_id;
        $sale->total             = $request->total_price;
        $sale->paid              = $request->paid;
        $sale->due               = $request->due;
        $sale->sales_date        = date('Y-m-d H:i:s', strtotime($request->sales_date));
        $sale->sales_type        = $request->sales_type;
        $sale->referral_name     = $request->referral_name;
        $sale->referral_contact  = $request->referral_contact;
        $sale->referral_address  = $request->referral_address;
        $sale->details           = $request->details;
        $sale->sold_by           = $request->sold_by;
        $sale->status            = $request->status ?? 0;
        $sale->created_by        = Auth::id();
        $sale->save(); 

        $sale_id = Sale::orderBy('id','DESC')->first()->id;

        foreach($request->itemid as $key => $value){
            $item = new OrderItem;
            $item->sales_id   = $sale_id;
            $item->myjob_id = $request->itemid[$key];
            $item->name       = $request->itemname[$key];
            $item->price      = $request->price[$key];
            $item->qty        = $request->qty[$key];
            $item->total      = $request->total[$key];
            $item->save();
        }
        
        // $payment = new Payment;
        // $payment->sales_id     = $sale_id;
        // $payment->paid_amount  = $request->pay_amount;
        // $payment->payment_date = date('Y-m-d H:i:s');
        // $payment->received_by  = Auth::id();
        // $payment->details      = 'On sale';
        // $payment->status       = 1;
        // $payment->created_by   = Auth::id();
        // $payment->save();

        Session::flash('success', 'Sale Successfully Saved.');
        return redirect('/sale/'.$sale_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sale = Sale::find($id);
        return view('layouts.sales.read_sale', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $myjobs = Myjob::all();
        $customers= Customer::all();
        $users= User::all();
        $sale= Sale::find($id);
        return view('layouts.sales.edit_sale', compact('customers', 'myjobs', 'users', 'sale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $this->validate($request, [
            'myjob_id'        => 'required|max:255',
            'customer_id'       => 'required|max:255',
            'sales_date'        => 'required',            
            'sales_type'        => 'required',            
            'referral_contact'  => 'required',         
            'referral_name'     => 'required',            
            'referral_address'  => 'required',            
        ]);

        $sale = Sale::find($id);
        $sale->myjob_id        = $request->myjob_id;
        $sale->customer_id       = $request->customer_id;
        $sale->sold_amount       = $request->sold_amount;
        $sale->sales_date        = $request->sales_date;
        $sale->sales_type        = $request->sales_type;
        $sale->referral_name     = $request->referral_name;
        $sale->referral_contact  = $request->referral_contact;
        $sale->referral_address  = $request->referral_address;
        $sale->details           = $request->details;
        $sale->sold_by           = $request->sold_by;
        $sale->status            = $request->status ?? 0;
        $sale->updated_by        = Auth::id();
        
        if($request->image >0){
            if (File::exists('img/sale/' .$sale->image)) {
                File::delete('img/sale/' .$sale->image);
            }
            $image = $request->file('image');
            $img = time() .'.'. $image->getClientOriginalExtension();
            $location = public_path('img/sale/'.$img);
            Image::make($image)->save($location);
            $sale->image = $img;

        }
        $sale->save(); 

        
        $sale_id = Sale::OrderBy('id','DESC')->first()->id;
        
        $payment = new Payment;
        $payment->sales_id = $sale_id;
        $payment->paid_amount = $request->pay_amount;
        $payment->payment_date = date('Y-m-d H:i:s');
        $payment->received_by = Auth::id();
        $payment->details = 'On sale';
        $payment->status = 1;
        $payment->created_by =Auth::id();
        $payment->save();

        Session::flash('success', 'Sale Successfully Updated.');
        return redirect('/sale/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sale = Sale::find($id);
           
             if (File::exists('img/sale/' .$sale->image)) {
                    File::delete('img/sale/' .$sale->image);
                }
                $sale->delete();
            Session::flash('success', 'This Sub Category Successfully deleted.');
            return redirect('/sale');
    }

    public function print($id)
    {
        $sale = Sale::find($id);
        return view('layouts.sales.print_sale', compact('sale'));
    }
}
