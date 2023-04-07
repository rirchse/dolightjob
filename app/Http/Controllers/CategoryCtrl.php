<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use File;
use Auth;
use Session;

// use App\Category;
class CategoryCtrl extends Controller
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
        $categories = Category::latest()->get();
        return view('layouts.categories.view_category', compact('categories'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.categories.create_new_category');
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
            'name'    => 'required',
            'budget'  => '',
            'details' => '',
            'status'  => '',
        ]);

        $store = new Category;
        $store->name        = $request->name;
        $store->details     = $request->details;
        $store->status      = $request->status? 1 : 0;
        $store->created_by  = Auth::id();
        $store->save();

        $last_cat_id = Category::orderBy('id', 'DESC')->first()->id;
        Session::flash('success', 'Category Successfully Saved.');

        return redirect('/category/'.$last_cat_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
     $category = Category::find($id);
     return view('layouts.categories.read_category', compact('category'));
 }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category =Category::find($id);
        return view('layouts.categories.edit_category', compact('category'));
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
            'name'    => 'required',
            'budget'  => '',
            'details' => '',
            'status'  => '',
        ]);
        $update = Category::find($id);
        $update->name        = $request->input('name');
        $update->budget      = $request->input('budget');
        $update->details     = $request->input('details');
        $update->status      = $request->input('status') ?? 0;
        $update->updated_by  = Auth::id();

        //delete before uploaded image
        if($request->image > 0){

            if (File::exists($category->image)) {
                File::delete($category->image);
            }

            $image      = $request->file('image');
            $img        = time() .'.'. $image->getClientOriginalExtension();
            $location   = public_path('uploads/category/'.$img);
            Image::make($image)->save($location);
            $update->image = '/uploads/category/'.$img;
        }
        $update->save();

        Session::flash('success', 'Category Successfully Updated.');
        return redirect('/category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
            // if (!is_null($category)) {

            //       //delete all the districts for the category
            //     $posts = Post::where('category_id', $category->id)->get();
            //     foreach ($posts as $post) {
            //         $post->delete();
            //     }
            //     $category->delete();
            // }
        if (File::exists($category->image)) {
            File::delete($category->image);
        }
        $category->delete();
        Session::flash('success', 'Category Successfully Deleted.');
        return redirect('/category');
    }
}
