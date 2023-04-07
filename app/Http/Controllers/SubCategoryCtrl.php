<?php

namespace App\Http\Controllers;

use App\Subcategory;
use Illuminate\Http\Request;
use App\Category;
use App\User;
use Auth;
use Image;
use File;
use DB;
use Session;

class SubCategoryCtrl extends Controller
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
        $sub_categoris = Subcategory::orderBy('id', 'DESC')->get();
        return view('layouts.sub_categories.view_sub_category', compact('sub_categoris'));
    }

    /* ajax call: sub categories by cat id*/
    public function subCats($catid)
    {
        $subcats = Subcategory::where('parent_id', $catid)->select('id', 'name', 'budget')->get();
        return response()->json([
          'success' => $subcats,
          'subcats' => $subcats
          ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoris = Category::where('status', 1)->get();
        return view('layouts.sub_categories.create_sub_category', compact('categoris'));
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
        'name'       => 'required|max:255',
        'parent_id'  => 'required',
        'budget'     => '',
        'details'    => ''
    ]);


       $update = new Subcategory;
       $update->name       = $request->name;
       $update->budget     = $request->budget;
       $update->parent_id  = $request->parent_id;
       $update->details    = $request->details;
       $update->status     = $request->status ?? 0;
       $update->created_by = Auth::id();
       
       if($request->image > 0){
        $image = $request->file('image');
        $img = time() .'.'. $image->getClientOriginalExtension();
        $location = public_path('uploads/sub_category/'.$img);
        Image::make($image)->save($location);
        $update->image = '/uploads/sub_category/'.$img;

    }
    $update->save();
    //get last entry
    $subcatid = Subcategory::orderBy('id', 'DESC')->first();

    Session::flash('success', 'Sub-Category Successfully Saved.');
    return redirect('sub_category/'.$subcatid->id);
}

    /**
     * Display the specified resource.
     *
     * @param  \App\sub_category  $sub_category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoris = Category::orderBy('name','asc')->get();
        $sub_category = Subcategory::find($id);
        return view('layouts.sub_categories.read_sub_category', compact('sub_category', 'categoris'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\sub_category  $sub_category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoris = Category::all();
        $sub_category =Subcategory::find($id);
        return view('layouts.sub_categories.edit_sub_category', compact('sub_category', 'categoris'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\sub_category  $sub_category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'       => 'required|max:255',
            'parent_id'  => 'required',
            'budget'     => '',
            'details'    => ''
        ]);

        $update = Subcategory::find($id);
        $update->name        = $request->input('name');
        $update->budget      = $request->input('budget');
        $update->parent_id   = $request->input('parent_id');
        $update->details     = $request->input('details');
        $update->status      = $request->input('status') ?? 0;
        $update->updated_by  = Auth::id();
        
        if($request->image >0){
           if (File::exists($categorys->image)) {
            File::delete($categorys->image);
        }

        $image = $request->file('image');
        $img = time() .'.'. $image->getClientOriginalExtension();
        $location = public_path('uploads/sub_category/'.$img);
        Image::make($image)->save($location);
        $update->image = '/uploads/sub_category/'.$img;

    }
    $update->save();

    Session::flash('success', 'Sub-Category Successfully Updated.');
    return redirect('/sub_category');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\sub_category  $sub_category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $sub_category = Subcategory::find($id);
        
        if (File::exists($sub_category->image)) {
            File::delete($sub_category->image);
        }
        $sub_category->delete();
        Session::flash('success', 'Sub-Category Successfully Deleted.');
        return redirect('/sub_category');
    }
    
}
