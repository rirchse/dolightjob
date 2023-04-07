<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Ad;
use Auth;
use Image;
use File;
use Session;


class AdController extends Controller
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
        $ads = Ad::orderBy('id', 'DESC')->paginate(25);
        return view('layouts.ads.view_ads', compact('ads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.ads.create_ad');
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
            'title'    => 'required|max:255',
            'details'  => 'required|max:255',
            'position' => 'required|max:255',
            'size' => 'required|max:255',
            'url'      => 'max:255',
            'status'   => 'max:10'
        ]);

        $ad = new Ad;
        $ad->title      = $request->title;
        $ad->position   = $request->position;
        $ad->size   = $request->size;
        $ad->url        = $request->url;
        $ad->details    = $request->details;
        $ad->status     = $request->status ?? 0;
        $ad->created_by = Auth::id();
        
        if($request->image >0){
            $image = $request->file('image');
            $img = time() .'.'. $image->getClientOriginalExtension();
            $location = public_path('uploads/ad/'.$img);
            Image::make($image)->save($location);
            $ad->image = '/uploads/ad/'.$img;
        }
        $ad->save(); 

        $ad_id = Ad::orderBy('id', 'DESC')->first()->id;

        Session::flash('success', 'Ad Successfully Submitted.');
        return redirect()->route('ad.show', $ad_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ad = Ad::find($id);
        return view('layouts.ads.read_ad', compact('ad'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ad = Ad::find($id);
        return view('layouts.ads.edit_ad', compact('ad'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'    => 'required|max:255',
            'details'  => 'required|max:255',
            'position' => 'required|max:255',
            'size'     => 'required|max:255',
            'url'      => 'max:255',
            'status'   => 'max:10'
        ]);
        
        $ad =Ad::find($id);
        $ad->title      = $request->input('title');
        $ad->position   = $request->input('position');
        $ad->size       = $request->input('size');
        $ad->url        = $request->input('url');
        $ad->details    = $request->input('details');
        $ad->status     = $request->input('status') ?? 0;
        $ad->updated_by = Auth::id();
        
        if($request->image >0){
            if (File::exists($ad->image)) {
                File::delete($ad->image);
            }

            $image = $request->file('image');
            $img = time() .'.'. $image->getClientOriginalExtension();
            $location = public_path('uploads/ad/'.$img);
            Image::make($image)->save($location);
            $ad->image = '/uploads/ad/'.$img;
        }
        $ad->save();

        Session::flash('success', 'The ad Successfully Updated.');
        return redirect('/ad');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ad = Ad::find($id);
             if (File::exists($ad->image)) {
                File::delete($ad->image);
            }
            $ad->delete();
        Session::flash('success', 'ad Successfully Deleted.');
        return redirect('/ad');
    }
    
}