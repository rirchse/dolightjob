<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Auth;
use Image;
use File;
use Session;


class CustomerCtrl extends Controller
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
        $customers = Customer::latest()->get();
        return view('layouts.customers.view_customer', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.customers.create_customer');
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
        'full_name'         => 'required|max:255',
        'contact'           => 'required|regex:/(01)[0-9]{9}/|max:11',
        'email'             => 'email|max:32|nullable',
        'gender'            => 'required|max:50',
        'care_of'           => 'max:255',
        'phone'             => 'max:11|nullable|regex:/(01)[0-9]{9}/|max:11',
        'date_of_birth'     => 'max:20',
        'present_address'   => 'max:255',
        'permanent_address' => 'required|max:255',
        'profession'        => 'max:255',
        'organization'      => 'max:255',
        'referral'          => 'required|max:255',
        'referral_contact'  => 'required|max:11|regex:/(01)[0-9]{9}/|max:11',
        'referral_address'  => 'required|max:255',
        'status'            => 'max:10',
        'details'           => 'max:99999',
    ]);


     $customer = new Customer;
     $customer->full_name            = $request->full_name;
     $customer->email                = $request->email;
     $customer->contact              = $request->contact;
     $customer->care_of              = $request->care_of;
     $customer->phone                = $request->phone;
     $customer->dob                  = $request->date_of_birth;
     $customer->gender               = $request->gender;
     $customer->job                  = $request->profession;
     $customer->organization         = $request->organization;
     $customer->present_address      = $request->present_address;
     $customer->permanent_address    = $request->permanent_address;
     $customer->referral             = $request->referral;
     $customer->referral_contact     = $request->referral_contact;
     $customer->referral_address     = $request->referral_address;
     $customer->details              = $request->details;
     $customer->status               = $request->status ?? 0;
     $customer->created_by           = Auth::id();

     if($request->image >0){
        $image = $request->file('image');
        $img = time() .'.'. $image->getClientOriginalExtension();
        $location = public_path('uploads/customer/'.$img);
        Image::make($image)->save($location);
        $customer->image = '/uploads/customer/'.$img;
    }

    $customer->save(); 

    $customer_id = Customer::orderBy('id', 'DESC')->first()->id;

    Session::flash('success', 'Customer Successfully Saved.');
    return redirect('/customer/'.$customer_id);
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);
        return view('layouts.customers.read_customer', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('layouts.customers.edit_customer', compact('customer'));
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
            'full_name'         => 'required|max:255',
            'contact'           => 'required|regex:/(01)[0-9]{9}/|max:11',
            'email'             => 'email|max:32|nullable',
            'gender'            => 'required|max:50',
            'care_of'           => 'max:255',
            'phone'             => 'max:11|nullable|regex:/(01)[0-9]{9}/|max:11',
            'date_of_birth'     => 'max:20',
            'present_address'   => 'max:255',
            'permanent_address' => 'required|max:255',
            'profession'        => 'max:255',
            'organization'      => 'max:255',
            'referral'          => 'required|max:255',
            'referral_contact'  => 'required|max:11|regex:/(01)[0-9]{9}/|max:11',
            'referral_address'  => 'required|max:255',
            'status'            => 'max:10',
            'details'           => 'max:99999',
        ]);

        $customer = Customer::find($id);
        $customer->full_name            = $request->full_name;
        $customer->email                = $request->email;
        $customer->contact              = $request->contact;
        $customer->care_of              = $request->care_of;
        $customer->phone                = $request->phone;
        $customer->dob                  = date('Y-m-d', strtotime($request->date_of_birth));
        $customer->gender               = $request->gender;
        $customer->job                  = $request->profession;
        $customer->organization         = $request->organization;
        $customer->present_address      = $request->present_address;
        $customer->permanent_address    = $request->permanent_address;
        $customer->referral             = $request->referral;
        $customer->referral_contact     = $request->referral_contact;
        $customer->referral_address     = $request->referral_address;
        $customer->details              = $request->details;
        $customer->status               = $request->status ?? 0;
        $customer->updated_by           = Auth::id();
        
        if($request->image >0){
            if (File::exists($customer->image)) {
                File::delete($customer->image);
            }
            $image = $request->file('image');
            $img = time() .'.'. $image->getClientOriginalExtension();
            $location = public_path('uploads/customer/'.$img);
            Image::make($image)->save($location);
            $customer->image = '/uploads/customer/'.$img;

        }
        $customer->save();

        Session::flash('success', 'Customer Information Successfully Updated.');
        return redirect('/customer/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);           
        if (File::exists($customer->image)) {
            File::delete($customer->image);
        }
        $customer->delete();
        Session::flash('success', 'Customer Successfully Deleted.');
        return redirect('/customer');
    }

    public function searchCustomer(Request $request)
    {
        $this->validate($request, [
            'customer' => 'required|max:50'
            ]);

        $customers = Customer::where('full_name', 'LIKE', '%'.$request->customer.'%')
        ->orWhere('contact', 'LIKE', '%'.$request->customer.'%')->get();
        return view('layouts.sales.search-customer', compact('customers'));
    }
}
