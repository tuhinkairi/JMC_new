<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use Session;
use Image;
use File;
use Auth;
use Hash;
use DB;

class StaffController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Page Data
        $this->title = 'Staff';
        $this->url = 'staff';
    }

    public function index()
    {
        // die;
        $title = $this->title;
        $url = $this->url;

        $user_id = Auth::user()->id;

        $tasks = DB::table('task as a')
                    ->join('articles as b', 'a.article_id', '=', 'b.id')
                    ->where('a.to_staff', $user_id)
                    ->select('a.*', 'b.title as articlename', 'a.status as taskstatus')
                    ->get();

        return view('staff.index', compact('title', 'url', 'tasks'));
    }

    public function show($id)
    {
        $title = $this->title;
        $url = $this->url;

        $rows = DB::table('articles as a')
                            // ->join('master_article as b', 'a.article_type', '=', 'b.id')
                            ->join('master_status as e', 'a.status_type', '=', 'e.id')
                            ->join('task as d', 'a.id', '=', 'd.article_id')
                            ->join('users as b', 'a.writer_id', '=', 'b.id')
                            ->join('article_categories as c', 'a.category_id', '=', 'c.id')
                            ->where('d.id', $id)
                            ->select('a.*', 'e.name as statustype', 'c.title as categoryname', 'b.name', 'd.task_name as taskname', 'd.status as taskstatus', 'd.id as taskid', 'd.due_date')
                            ->get();


        return view('staff.show', compact('title', 'url', 'rows'));
    }

    public function update(Request $request, $id)
    {
        $data = array(
            "status" => $request->status,
            // "description" =>$request->description
            // "article_id" =>$id,
            // "status" => "New"
        );

        $update_table = DB::table('task')->where( 'id' , $id)->update($data);

        Session::flash('success', $this->title.' Task Updated Successfully!');

        return redirect()->route('staff.task.index');
    }

}
