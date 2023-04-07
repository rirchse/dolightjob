<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Notice;
use Auth;
use Image;
use File;
use Session;


class NoticeCtrl extends Controller
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
        $notices = Notice::orderBy('id', 'DESC')->paginate(25);
        return view('layouts.notices.view_notices', compact('notices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.notices.create_notice');
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
        'details'  => 'required|max:999',
        'position' => 'required|max:255'
        ]);

        $store = new Notice;
        $store->title    = $request->title;
        $store->details  = $request->details;
        $store->position = $request->position;
        $store->status   = $request->status ?? 0;
        $store->created_by = Auth::id();
        $store->save(); 

        $notice_id = Notice::orderBy('id', 'DESC')->first()->id;

        Session::flash('success', 'Notice Successfully Saved.');
        return redirect()->route('notice.show', $notice_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ad  $notice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notice = Notice::find($id);
        return view('layouts.notices.read_notice', compact('notice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ad  $notice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $notice = Notice::find($id);
        return view('layouts.notices.edit_notice', compact('notice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ad  $notice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
        'title'    => 'required|max:255',
        'details'  => 'required|max:999',
        'position' => 'required|max:255'
        ]);
        
        $store = Notice::find($id);
        $store->title    = $request->input('title');
        $store->details  = $request->input('details');
        $store->position = $request->input('position');
        $store->status   = $request->input('status') ?? 0;
        $store->updated_by = Auth::id();
        $store->save();
        
        Session::flash('success', 'Notice Successfully Updated.');
        return redirect('/notice');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ad  $notice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notice = Notice::find($id);
        if (File::exists($notice->image)) {
            File::delete($notice->image);
        }
        $notice->delete();
        
        Session::flash('success', 'Notice Successfully Deleted.');
        return redirect('/notice');
    }    
}