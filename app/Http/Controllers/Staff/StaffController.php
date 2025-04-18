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

    // public function show($id)
    // {
    //     $title = $this->title;
    //     $url = $this->url;

    //     $rows = DB::table('articles as a')
    //                         // ->join('master_article as b', 'a.article_type', '=', 'b.id')
    //                         ->join('master_status as e', 'a.status_type', '=', 'e.id')
    //                         ->join('task as d', 'a.id', '=', 'd.article_id')
    //                         ->join('users as b', 'a.writer_id', '=', 'b.id')
    //                         ->join('article_categories as c', 'a.category_id', '=', 'c.id')
    //                         ->where('d.id', $id)
    //                         ->select('a.*', 'e.name as statustype', 'c.title as categoryname', 'b.name', 'd.task_name as taskname', 'd.status as taskstatus', 'd.id as taskid', 'd.due_date')
    //                         ->get();


    //     return view('staff.show', compact('title', 'url', 'rows'));
    // }

    public function show($id)
    {
        
        $title = $this->title;
        $url = $this->url;
        // echo $url;die();

        $rows = DB::table('articles as a')
                            ->join('master_article as b', 'a.article_type', '=', 'b.id')
                            ->join('master_issue as c', 'a.issue_type', '=', 'c.id')
                            ->join('master_processing as d', 'a.processing_type', '=', 'd.id')
                            ->join('master_status as e', 'a.status_type', '=', 'e.id')
                            ->join('master_journal as f', 'a.journal_type', '=', 'f.id')
                            ->where('a.id', $id)
                            ->select('a.*', 'b.name as articlename', 'c.name as issuename','d.name as processingname','e.name as statusname', 'e.colour as colourflag', 'f.name as journalname')
                            ->get();
        // print_r($selected);die();
        $author = DB::table('articles as a')
                            ->join('users as g', 'a.writer_id', '=', 'g.id')
                            ->where('a.id', $id)
                            ->select('g.name as authorname', 'g.image_path', 'g.email', 'g.phone')
                            ->get();

        $tasks = DB::select('select * from task where article_id='. $id);

        $reviews = DB::table('review as a')
                            ->join('articles as b', 'a.article_id', '=', 'b.id')
                            ->join('users as c', 'a.reviewer_id', '=', 'c.id')

                            ->where('a.article_id', $id)
                            ->select('a.*', 'c.name as reviername')
                            ->get();

        
        $review_status = DB::select('select * from review_evalution where article_id ='.$id );

        $files_0 = DB::table('file as a')
        ->join('articles as b', 'a.article_id', '=', 'b.id')
        ->where('a.article_id', $id)
        ->where('a.category',0)
        ->select('a.*', 'b.title as articletitle')
        ->get();

        $files_1 = DB::table('file as a')
                            ->join('articles as b', 'a.article_id', '=', 'b.id')
                            ->where('a.article_id', $id)
                            ->where('a.category',1)
                            ->select('a.*', 'b.title as articletitle')
                            ->get();
        $files_2 = DB::table('file as a')
        ->join('articles as b', 'a.article_id', '=', 'b.id')
        ->where('a.article_id', $id)
        ->where('a.category',2)
        ->select('a.*', 'b.title as articletitle')
        ->get();
        $files_3 = DB::table('file as a')
        ->join('articles as b', 'a.article_id', '=', 'b.id')
        ->where('a.article_id', $id)
        ->where('a.category',3)
        ->select('a.*', 'b.title as articletitle')
        ->get();

        $copy_rigth_files = DB::table('copy_rigth_files as a')
                            ->join('articles as b', 'a.article_id', '=', 'b.id')
                            ->where('a.article_id', $id)
                            ->select('a.*', 'b.title as articletitle')
                            ->get();

        $acceptances = DB::table('acceptance as a')
                            ->join('articles as b', 'a.article_id', '=', 'b.id')
                            ->where('a.article_id', $id)
                            ->select('a.*', 'b.title as articletitle')
                            ->get();

                            $final_manuscripts = DB::table('final_submission as a')
                            ->join('articles as b', 'a.article_id', '=', 'b.id')
                            ->where('a.article_id', $id)
                            ->where('category', 1)
                            ->select('a.*', 'b.freeze_data', 'b.title as articletitle')
                            ->get();

        $final_copy_right_forms = DB::table('final_submission as a')
                            ->join('articles as b', 'a.article_id', '=', 'b.id')
                            ->where('a.article_id', $id)
                            ->where('category', 2)
                            ->select('a.*', 'b.freeze_data', 'b.title as articletitle')
                            ->get();

        $final_payment_scripts = DB::table('final_submission as a')
                            ->join('articles as b', 'a.article_id', '=', 'b.id')
                            ->where('a.article_id', $id)
                            ->where('category', 3)
                            ->select('a.*', 'b.freeze_data','b.title as articletitle')
                            ->get();
// die;

        $staffs =  DB::select('select * from users WHERE user_type = "S"');
        $reviewers =  DB::select('select * from users WHERE user_type = "R"');
        // $rows = DB::select('select * from articles where id='. $id);
        $articles = DB::select('select * from master_article');
        $journals = DB::select('select * from master_journal ORDER BY id ASC');
        $issues = DB::select('select * from master_issue');
        $processings = DB::select('select * from master_processing');
        $statuss = DB::select('select * from master_status');
        // print_r($tasks);
        // die;
        // die('helo1');
        $tab = 'tasks';
        return view('staff.article.view', compact('url', 'final_payment_scripts', 'final_manuscripts', 'final_copy_right_forms', 'acceptances', 'files_0', 'files_1', 'files_2', 'files_3', 'copy_rigth_files', 'reviewers', 'reviews', 'id', 'author', 'tasks', 'staffs', 'journals', 'rows', 'title', 'articles', 'issues', 'processings', 'statuss','review_status'));
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

    public function certificate_details_file_upload(Request $request, $id)
    {
        // file upload, fit and store inside public folder
        if($request->hasFile('file')){
            //Upload New Image
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileNameToStore = str_replace([' ','-','&','#','$','%','^',';',':'],'_',$filename).'_'.time().'.'.$extension;

            //Crete Folder Location
            $path = public_path('uploads/article_file/');
            if (! File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            // Move File inside public/uploads/ folder
            $file = $request->file('file')->move($path, $fileNameToStore);

        }
        else{
            $fileNameToStore = NULL;
        }

        $data = array(
            "doc_title" =>$request->doc_title,
            "file_path" =>$fileNameToStore,
            "category" =>2,
            "article_id" =>$id
        );
        $inser_data = DB::table('file')->insert($data);

        Session::flash('success', 'Cerfificate Details Uploaded Successfully!');

        return redirect()->back()->withInput(['tab' => 'files']);
    }

    public function author_file_upload(Request $request, $id)
    {
        // file upload, fit and store inside public folder
        if($request->hasFile('file')){
            //Upload New Image
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileNameToStore = str_replace([' ','-','&','#','$','%','^',';',':'],'_',$filename).'_'.time().'.'.$extension;

            //Crete Folder Location
            $path = public_path('uploads/article_file/');
            if (! File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            // Move File inside public/uploads/ folder
            $file = $request->file('file')->move($path, $fileNameToStore);

        }
        else{
            $fileNameToStore = NULL;
        }

        $data = array(
            "doc_title" =>$request->doc_title,
            "file_path" =>$fileNameToStore,
            "category" =>0,
            "article_id" =>$id
        );
        $inser_data = DB::table('file')->insert($data);

        Session::flash('success', 'File Uploaded Successfully!');

        return redirect()->back()->withInput(['tab' => 'files']);
    }

    public function published_article_details_file_upload(Request $request, $id)
    {
        // file upload, fit and store inside public folder
        if($request->hasFile('file')){
            //Upload New Image
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileNameToStore = str_replace([' ','-','&','#','$','%','^',';',':'],'_',$filename).'_'.time().'.'.$extension;

            //Crete Folder Location
            $path = public_path('uploads/article_file/');
            if (! File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            // Move File inside public/uploads/ folder
            $file = $request->file('file')->move($path, $fileNameToStore);

        }
        else{
            $fileNameToStore = NULL;
        }

        $data = array(
            "doc_title" =>$request->doc_title,
            "file_path" =>$fileNameToStore,
            "category" =>3,
            "article_id" =>$id
        );
        $inser_data = DB::table('file')->insert($data);

        Session::flash('success', 'Published Article Details Uploaded Successfully!');

        return redirect()->back()->withInput(['tab' => 'files']);
    }

    public function plagiarism_report_file_upload(Request $request, $id)
    {
        // echo $request->doc_title;die();
        // file upload, fit and store inside public folder
        if($request->hasFile('file')){
            
            //Upload New Image
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileNameToStore = str_replace([' ','-','&','#','$','%','^',';',':'],'_',$filename).'_'.time().'.'.$extension;

            //Crete Folder Location
            $path = public_path('uploads/article_file/');
            
            if (! File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            
            // Move File inside public/uploads/ folder
            $file = $request->file('file')->move($path, $fileNameToStore);
            
        }
        else{
            $fileNameToStore = NULL;
        }

    
        $data = array(
            "doc_title" =>$request->doc_title,
            "file_path" =>$fileNameToStore,
            "category" =>1,
            "article_id" =>$id
        );
        try {
            $insertedId = DB::table('file')->insertGetId($data);
        } catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage()); // Display the SQL error message for debugging
        }
        Session::flash('success', 'Plagiarism Report Uploaded Successfully!');

        return redirect()->back()->withInput(['tab' => 'files']);
    }

}
