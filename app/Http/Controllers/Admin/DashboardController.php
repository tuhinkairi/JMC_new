<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ArticleCategory;
use App\ArticleIssue;
use App\Article;
use App\Comment;
use App\User;
use Auth;
use DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Page Data
        $this->title = 'Dashboard';
        $this->url = 'dashboard';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     public function index()
     {
 
        
         //
         $title = $this->title;
         $url = $this->url;
 
 
         $user_type = Auth::user()->user_type;
         $user_id = Auth::user()->id;
     
         if( $user_type == 'W' ){
 
             $rows = ArticleIssue::join('articles', 'articles.id', 'article_issues.article_id')
                                 ->join('master_status as e', 'articles.status_type', '=', 'e.id')
                                 ->select('article_issues.*', 'e.name as statusname')
                                 ->where('articles.writer_id', $user_id)
                                 ->where('article_issues.status', 1)
                                 ->orderBy('article_issues.id', 'desc')
                                 ->get();
 
             $approve = Article::join('users', 'users.id', 'articles.writer_id')
                                 ->select('articles.*')
                                 ->where('users.id', $user_id)
                                 ->where('articles.review_status', '2')
                                 ->get();
             $pending = Article::join('users', 'users.id', 'articles.writer_id')
                                 ->select('articles.*')
                                 ->where('users.id', $user_id)
                                 ->where(function ($query) {
                                     $query->where('articles.status_type', '2')
                                           ->orWhere('articles.status_type', '3')
                                           ->orWhere('articles.status_type', '4');
                                 })
                                 ->get();
             $accepted = Article::join('users', 'users.id', 'articles.writer_id')
                                 ->select('articles.*')
                                 ->where('users.id', $user_id)
                                 ->where('articles.status_type', '5')
                                 ->get();
             $published = Article::join('users', 'users.id', 'articles.writer_id')
                                 ->select('articles.*')
                                 ->where('users.id', $user_id)
                                 ->where('articles.status_type', '15')
                                 ->get();
             $issue = ArticleIssue::join('articles', 'articles.id', 'article_issues.article_id')
                                 ->select('article_issues.*')
                                 ->where('articles.writer_id', $user_id)
                                 ->where('article_issues.status', 1)
                                 ->get();
             $comment = Comment::join('articles', 'articles.id', 'comments.article_id')
                                 ->join('users', 'users.id', 'articles.writer_id')
                                 ->select('comments.*')
                                 ->where('users.id', $user_id)
                                 ->where('comments.status', 1)
                                 ->get();
 
             $users = User::where('id', $user_id)->get();
           
             $Alldata = DB::table('articles as a')
                         ->join('article_categories as b', 'a.category_id', '=', 'b.id')
                         ->join('master_status as e', 'a.status_type', '=', 'e.id')
                         ->where('a.writer_id', $user_id)
                         ->select('a.*', 'e.name as statusname', 'b.title as category', 'e.colour as colourflag')
                         ->orderBy('a.id', 'desc')
                         ->get();
 
             $categories = '';
             $journalss = '';
             $tasks = '';

             $user_id = Auth::user()->id;

             $reviews = DB::table('review as a')
                                 ->join('articles as b', 'a.article_id', '=', 'b.id')
                                 ->join('users as c', 'a.reviewer_id', '=', 'c.id')
                                 ->where('a.reviewer_id', $user_id)
                                 ->select('a.*', 'c.name as reviername', 'b.title as articlename','b.journal_short_form as journal_short_form')
                                 ->get();
             $acceptances = DB::table('acceptance as a')
                             ->join('articles as b', 'a.article_id', '=', 'b.id')
                             ->where('b.writer_id', $user_id)
                             ->select('a.*', 'b.title as articletitle', 'b.journal_short_form')
                             ->get();
                             $review_ev = DB::select('select * from review_evalution');
                             $journalss = DB::select('select * from master_journal ORDER BY id ASC');
             $doiDatas1 = [];
             foreach($journalss as $journal){
                 $queryForDoi = DB::select('select count(id) as withdoi from articles where journal_type='.$journal->id.' and payment_status in ("paid-3","paid-2")');
                 $queryForWithoutDoi = DB::select('select count(id) as withoutdoi from articles where journal_type='.$journal->id.' and payment_status in ("paid-1")');
             
                 $queryFornormal = DB::select('select count(id) as normal from articles where journal_type='.$journal->id.' and processing_type=1');
                 $queryForfast = DB::select('select count(id) as fast from articles where journal_type='.$journal->id.' and processing_type=2');
                 $queryForexpress = DB::select('select count(id) as express from articles where journal_type='.$journal->id.' and processing_type=3');
                 $doiDatas['journal'] = $journal->short_form;
                 $doiDatas['withdoi'] = $queryForDoi[0]->withdoi;
                 $doiDatas['withoutdoi'] = $queryForWithoutDoi[0]->withoutdoi;
                 $doiDatas['normal'] = $queryFornormal[0]->normal;
                 $doiDatas['fast'] = $queryForfast[0]->fast;
                 $doiDatas['express'] = $queryForexpress[0]->express;
                 $doiDatas1[] = $doiDatas;
             }
 
         }
         else{
         
             $rows = DB::table('articles as a')
                             ->join('article_categories as b', 'a.category_id', '=', 'b.id')
                             ->join('master_status as c', 'a.status_type', '=', 'c.id')
                             ->join('master_journal as d', 'a.journal_type', '=', 'd.id')
                             // ->join('task as e', 'a.id', '=', 'e.article_id')
                             ->join('users as f', 'a.writer_id', '=', 'f.id')
                             ->select('a.*', 'c.name as statusname', 'c.colour as colourflag', 'b.title as category', 'f.name as authorname', 'd.name as journalname')
                     
                             ->orderBy('a.id', 'desc')
                             ->get();
             
                             $user_id = Auth::user()->id;

            $reviews = DB::table('review as a')
                                ->join('articles as b', 'a.article_id', '=', 'b.id')
                                ->join('users as c', 'a.reviewer_id', '=', 'c.id')
                                
                                ->where('a.reviewer_id', $user_id)
                        
                                ->select('a.*', 'c.name as reviername','c.reviewerid as reviewerid', 'b.title as articlename','b.id as articleid','b.journal_short_form as journal_short_form')
                                ->get();
                                $review_ev = DB::select('select * from review_evalution');
                          
             $tasks = DB::table('task as a')
                             ->join('articles as b', 'a.article_id', '=', 'b.id')
                             ->join('users as c', 'a.to_staff', '=', 'c.id')
                             ->select('a.*', 'c.name as staff')
                             ->orderBy('id', 'asc')
                             ->get();
                     
             $categories = ArticleCategory::where('status', '1')->get();
          
             $approve = Article::where('review_status', '2')->get();
             $pending = Article::where('status_type', '2')
                                 ->orwhere('status_type', '3')
                                 ->orwhere('status_type', '4')
                                 ->get();
                             
             $accepted = Article::where('status_type', '5')->get();
             $published = Article::where('status_type', '15')->get();
             $issue = '';
             $comment = Comment::all();
             $users = User::where('user_type', 'W')->get();
    
             $Alldata = '';
             $journalss = DB::select('select * from master_journal ORDER BY id ASC');
             $doiDatas1 = [];
             foreach($journalss as $journal){
                 $queryForDoi = DB::select('select count(id) as withdoi from articles where journal_type='.$journal->id.' and payment_status in ("paid-3","paid-2")');
                 $queryForWithoutDoi = DB::select('select count(id) as withoutdoi from articles where journal_type='.$journal->id.' and payment_status in ("paid-1")');
             
                 $queryFornormal = DB::select('select count(id) as normal from articles where journal_type='.$journal->id.' and processing_type=1');
                 $queryForfast = DB::select('select count(id) as fast from articles where journal_type='.$journal->id.' and processing_type=2');
                 $queryForexpress = DB::select('select count(id) as express from articles where journal_type='.$journal->id.' and processing_type=3');
                 $doiDatas['journal'] = $journal->short_form;
                 $doiDatas['withdoi'] = $queryForDoi[0]->withdoi;
                 $doiDatas['withoutdoi'] = $queryForWithoutDoi[0]->withoutdoi;
                 $doiDatas['normal'] = $queryFornormal[0]->normal;
                 $doiDatas['fast'] = $queryForfast[0]->fast;
                 $doiDatas['express'] = $queryForexpress[0]->express;
                 $doiDatas1[] = $doiDatas;
             }
             $acceptances = '';
         }
 
         return view('admin.index', compact('review_ev','reviews','doiDatas1','Alldata', 'accepted', 'published', 'acceptances','title', 'tasks', 'journalss', 'categories', 'url', 'rows', 'approve', 'pending', 'issue', 'comment', 'users'));
     }

    public function change_details(Request $request)    
    {
        $id = $request->post('id');

        if($id == 0){

            $rows = DB::table('articles as a')
                            ->join('article_categories as b', 'a.category_id', '=', 'b.id')
                            ->join('master_status as c', 'a.status_type', '=', 'c.id')
                            ->join('master_journal as d', 'a.journal_type', '=', 'd.id')
                            // ->join('task as e', 'a.id', '=', 'e.article_id')
                            ->join('users as f', 'a.writer_id', '=', 'f.id')
                            ->select('a.*', 'c.name as statusname', 'c.colour as colourflag', 'b.title as category', 'f.name as authorname', 'd.name as journalname')
                            ->orderBy('id', 'asc')
                            ->get();
                            // print_r($rows);
                            // die;
                            $check_task = DB::table('task as a')
                                                ->join('articles as b', 'a.article_id', '=', 'b.id')
                                                ->join('users as c', 'a.to_staff', '=', 'c.id')
                                                ->select('a.*', 'c.name as staff')
                                                ->orderBy('id', 'asc')
                                                ->get();

                            if(!empty($check_task)){

                                $tasks = DB::table('task as a')
                                                ->join('articles as b', 'a.article_id', '=', 'b.id')
                                                ->join('users as c', 'a.to_staff', '=', 'c.id')
                                                ->select('a.*', 'c.name as staff')
                                                ->orderBy('id', 'asc')
                                                ->get();
                            }
        }else{
            $rows = DB::table('articles as a')
                            ->join('article_categories as b', 'a.category_id', '=', 'b.id')
                            ->join('master_status as c', 'a.status_type', '=', 'c.id')
                            ->join('master_journal as d', 'a.journal_type', '=', 'd.id')
                            // ->join('task as e', 'a.id', '=', 'e.article_id')
                            ->join('users as f', 'a.writer_id', '=', 'f.id')
                            ->where('d.id', $id)
                            ->select('a.*', 'c.name as statusname', 'c.colour as colourflag', 'b.title as category', 'f.name as authorname', 'd.name as journalname')
                            ->orderBy('id', 'asc')
                            ->get();
                            // print_r($rows);
                            // die;
                $check_task = DB::table('task as a')
                                    ->join('articles as b', 'a.article_id', '=', 'b.id')
                                    ->join('users as c', 'a.to_staff', '=', 'c.id')
                                    ->select('a.*', 'c.name as staff')
                                    ->where('b.journal_type', $id)
                                    ->orderBy('id', 'asc')
                                    ->get();

            if(!empty($check_task)){

                $tasks = DB::table('task as a')
                                ->join('articles as b', 'a.article_id', '=', 'b.id')
                                ->join('users as c', 'a.to_staff', '=', 'c.id')
                                ->select('a.*', 'c.name as staff')
                                ->where('b.journal_type', $id)
                                ->orderBy('id', 'asc')
                                ->get();
            }
        }



// print_r($rows);




        $data = '';
        $data .= '<table id="basic-datatable" class="table table-striped table-hover table-white nowrap dashboard_fix-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="hide-column">No</th>
                                    <th class="id_box">ID</th>
                                    <th class="text-left title_box">Title</th>
                                    <th class="author_box">Author</th>
                                    <th class="assigned_box">Assigned To</th>
                                    <th class="task_box">Task</th>
                                    <th class="satus_box">Status</th>
                                    <th class="paymeny_box">Payment</th>
                                    <th class="created_box">Craeted On</th>
                                </tr>
                            </thead>
                            <tbody>';
                            foreach( $rows as $row ){
        $data .=                '<tr>';
        $data .=                     '<td><a href="dashboard/admin/submission/show/'.$row->id.'">'.$row->journal_short_form."-0000".$row->id.'</td>';
        $data .=                     '<td>'.$row->title.'</td>';
        $data .=                     '<td>'.$row->authorname.'</td>';

                                if(isset($tasks)){
                                    $data .= '<td>
                                             <ol>';
                                            foreach($tasks as $task){
                                                if($task->article_id == $row->id){
                                            $data .=  '<li>'.$task->staff .'</li>';
                                            }
                                        }
                                    $data .= '</ol>
                                            </td>';


                                    $data .= '<td>
                                            <ol>';
                                           foreach($tasks as $task){
                                            if($task->article_id == $row->id){
                                    $data .=  '<li>'.$task->task_name .'</li>';
                                           }
                                        }
                                   $data .= '</ol>
                                           </td>';
                                }else{
                                    $data .= '<td></td>';
                                    $data .= '<td></td>';
                                }

        $data .=                     '<td><span class="badge badge-pill" style="background-color:'.$row->colourflag.'; color:#ffffff;border:1px solid '.$row->colourflag.'">'.$row->statusname.'</span></td>';


        if(!empty($row->payment_status)){
            $data_1 = $row->payment_status;
            $paymentstatus = strtok($data_1, '-');

        }else{
            $paymentstatus = "null";
        }


        $data .=                     '<td>';
                                        if($paymentstatus == "paid")
        $data .=                             '<span class="badge badge-pill" style="background-color:green; color:#ffffff;border:1px solid green">Paid</span>';
                                        elseif ($paymentstatus == "unpaid")
        $data .=                             '<span class="badge badge-pill" style="background-color:red; color:#ffffff;border:1px solid red">Un Paid</span>';
                                        else
        $data .=                            '<span class="badge badge-pill" style="background-color:blue; color:#ffffff;border:1px solid blue">Not Started</span>';
        $data .=                     '</td>';
        $data .=                     '<td>'.$row->created_at.'</td>';
        $data .=                 '</tr>';
                            }
        $data .=                '</tbody>
                                </table>';

        echo $data;


    }

    public function table_content_depent_by_id(Request $request)
    {
        $paperid = $request->post('id');


        $whatIWant = substr($paperid, (strpos($paperid, '-0000') ?: -5) + 5);

        $id = $whatIWant;


        $rows = DB::table('articles as a')
                            ->join('article_categories as b', 'a.category_id', '=', 'b.id')
                            ->join('master_status as c', 'a.status_type', '=', 'c.id')
                            ->join('master_journal as d', 'a.journal_type', '=', 'd.id')
                            // ->join('task as e', 'a.id', '=', 'e.article_id')
                            ->join('users as f', 'a.writer_id', '=', 'f.id')
                            ->where('a.id', $id)
                            ->select('a.*', 'c.name as statusname', 'c.colour as colourflag', 'b.title as category', 'f.name as authorname', 'd.name as journalname')
                            ->orderBy('id', 'asc')
                            ->get();
                            // print_r($rows);
                            // die;
        $check_task = DB::select('select * from task where article_id = '.$id);

        if(!empty($check_task)){
            $tasks = DB::table('task as a')
                            ->join('articles as b', 'a.article_id', '=', 'b.id')
                            ->join('users as c', 'a.to_staff', '=', 'c.id')
                            ->select('a.*', 'c.name as staff')
                            ->where('a.article_id', $id)
                            ->orderBy('id', 'asc')
                            ->get();
        }

        $data = '';
        $data .= '<table id="basic-datatable" class="table table-striped table-hover table-white nowrap dashboard_fix-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="hide-column">No</th>
                                    <th class="id_box">ID</th>
                                    <th class="text-left title_box">Title</th>
                                    <th class="author_box">Author</th>
                                    <th class="assigned_box">Assigned To</th>
                                    <th class="task_box">Task</th>
                                    <th class="satus_box">Status</th>
                                    <th class="paymeny_box">Payment</th>
                                    <th class="created_box">Craeted On</th>
                                </tr>
                            </thead>
                            <tbody>';
                            foreach( $rows as $row ){
        $data .=                '<tr>';
        $data .=                     '<td><a href="dashboard/admin/submission/show/'.$row->id.'">'.$row->journal_short_form."-0000".$row->id.'</td>';
        $data .=                     '<td>'.$row->title.'</td>';
        $data .=                     '<td>'.$row->authorname.'</td>';

                                if(isset($tasks)){
                                    $data .= '<td>
                                             <ol>';
                                            foreach($tasks as $task){
                                                if($task->article_id == $row->id){
                                            $data .=  '<li>'.$task->staff .'</li>';
                                            }
                                        }
                                    $data .= '</ol>
                                            </td>';


                                    $data .= '<td>
                                            <ol>';
                                           foreach($tasks as $task){
                                            if($task->article_id == $row->id){
                                    $data .=  '<li>'.$task->task_name .'</li>';
                                           }
                                        }
                                   $data .= '</ol>
                                           </td>';
                                }else{
                                    $data .= '<td></td>';
                                    $data .= '<td></td>';
                                }

        $data .=                     '<td><span class="badge badge-pill" style="background-color:'.$row->colourflag.'; color:#ffffff;border:1px solid '.$row->colourflag.'">'.$row->statusname.'</span></td>';


        if(!empty($row->payment_status)){
            $data_1 = $row->payment_status;
            $paymentstatus = strtok($data_1, '-');

        }else{
            $paymentstatus = "null";
        }


        $data .=                     '<td>';
                                        if($paymentstatus == "paid")
        $data .=                             '<span class="badge badge-pill" style="background-color:green; color:#ffffff;border:1px solid green">Paid</span>';
                                        elseif ($paymentstatus == "unpaid")
        $data .=                             '<span class="badge badge-pill" style="background-color:red; color:#ffffff;border:1px solid red">Un Paid</span>';
                                        else
        $data .=                            '<span class="badge badge-pill" style="background-color:blue; color:#ffffff;border:1px solid blue">Not Started</span>';
        $data .=                     '</td>';
        $data .=                     '<td>'.$row->created_at.'</td>';
        $data .=                 '</tr>';
                            }
        $data .=                '</tbody>
                                </table>';

        echo $data;


    }


    public function table_content_depent_by_author_name(Request $request)
    {
        $author_name = $request->post('name');


        $rows = DB::table('articles as a')
                            ->join('article_categories as b', 'a.category_id', '=', 'b.id')
                            ->join('master_status as c', 'a.status_type', '=', 'c.id')
                            ->join('master_journal as d', 'a.journal_type', '=', 'd.id')
                            // ->join('task as e', 'a.id', '=', 'e.article_id')
                            ->join('users as f', 'a.writer_id', '=', 'f.id')
                            ->where('f.name', 'like', '%'.$author_name.'%')
                            ->select('a.*', 'c.name as statusname', 'c.colour as colourflag', 'b.title as category', 'f.name as authorname', 'd.name as journalname')
                            ->orderBy('id', 'asc')
                            ->get();
                            // print_r($rows);
                            // die;

        $check_task = DB::table('task as a')
                            ->join('articles as b', 'a.article_id', '=', 'b.id')
                            ->join('users as c', 'a.to_staff', '=', 'c.id')
                            ->join('users as d', 'b.writer_id', '=', 'd.id')
                            ->select('a.*', 'c.name as staff')
                            ->where('d.name', 'like', '%'.$author_name.'%')
                            ->orderBy('id', 'asc')
                            ->get();

        if(!empty($check_task)){

            $tasks = DB::table('task as a')
                            ->join('articles as b', 'a.article_id', '=', 'b.id')
                            ->join('users as c', 'a.to_staff', '=', 'c.id')
                            ->join('users as d', 'b.writer_id', '=', 'd.id')
                            ->select('a.*', 'c.name as staff')
                            ->where('d.name', 'like', '%'.$author_name.'%')
                            ->orderBy('id', 'asc')
                            ->get();
        }


        $data = '';
        $data .= '<table id="basic-datatable" class="table table-striped table-hover table-white nowrap dashboard_fix-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="hide-column">No</th>
                                    <th class="id_box">ID</th>
                                    <th class="text-left title_box">Title</th>
                                    <th class="author_box">Author</th>
                                    <th class="assigned_box">Assigned To</th>
                                    <th class="task_box">Task</th>
                                    <th class="satus_box">Status</th>
                                    <th class="paymeny_box">Payment</th>
                                    <th class="created_box">Craeted On</th>
                                </tr>
                            </thead>
                            <tbody>';
                            foreach( $rows as $row ){
        $data .=                '<tr>';
        $data .=                     '<td><a href="dashboard/admin/submission/show/'.$row->id.'">'.$row->journal_short_form."-0000".$row->id.'</td>';
        $data .=                     '<td>'.$row->title.'</td>';
        $data .=                     '<td>'.$row->authorname.'</td>';

                                if(isset($tasks)){
                                    $data .= '<td>
                                             <ol>';
                                            foreach($tasks as $task){
                                                if($task->article_id == $row->id){
                                            $data .=  '<li>'.$task->staff .'</li>';
                                            }
                                        }
                                    $data .= '</ol>
                                            </td>';


                                    $data .= '<td>
                                            <ol>';
                                           foreach($tasks as $task){
                                            if($task->article_id == $row->id){
                                    $data .=  '<li>'.$task->task_name .'</li>';
                                           }
                                        }
                                   $data .= '</ol>
                                           </td>';
                                }else{
                                    $data .= '<td></td>';
                                    $data .= '<td></td>';
                                }

        $data .=                     '<td><span class="badge badge-pill" style="background-color:'.$row->colourflag.'; color:#ffffff;border:1px solid '.$row->colourflag.'">'.$row->statusname.'</span></td>';


        if(!empty($row->payment_status)){
            $data_1 = $row->payment_status;
            $paymentstatus = strtok($data_1, '-');

        }else{
            $paymentstatus = "null";
        }


        $data .=                     '<td>';
                                        if($paymentstatus == "paid")
        $data .=                             '<span class="badge badge-pill" style="background-color:green; color:#ffffff;border:1px solid green">Paid</span>';
                                        elseif ($paymentstatus == "unpaid")
        $data .=                             '<span class="badge badge-pill" style="background-color:red; color:#ffffff;border:1px solid red">Un Paid</span>';
                                        else
        $data .=                            '<span class="badge badge-pill" style="background-color:blue; color:#ffffff;border:1px solid blue">Not Started</span>';
        $data .=                     '</td>';
        $data .=                     '<td>'.$row->created_at.'</td>';
        $data .=                 '</tr>';
                            }
        $data .=                '</tbody>
                                </table>';

        echo $data;


    }

    public function table_content_depent_by_article_title(Request $request)
    {
        $article_title = $request->post('article_title');


        $rows = DB::table('articles as a')
                            ->join('article_categories as b', 'a.category_id', '=', 'b.id')
                            ->join('master_status as c', 'a.status_type', '=', 'c.id')
                            ->join('master_journal as d', 'a.journal_type', '=', 'd.id')
                            // ->join('task as e', 'a.id', '=', 'e.article_id')
                            ->join('users as f', 'a.writer_id', '=', 'f.id')
                            ->where('a.title', 'like', '%'.$article_title.'%')
                            ->select('a.*', 'c.name as statusname', 'c.colour as colourflag', 'b.title as category', 'f.name as authorname', 'd.name as journalname')
                            ->orderBy('id', 'asc')
                            ->get();
                            // print_r($rows);
                            // die;

        $check_task = DB::table('task as a')
                            ->join('articles as b', 'a.article_id', '=', 'b.id')
                            ->join('users as c', 'a.to_staff', '=', 'c.id')
                            ->select('a.*', 'c.name as staff')
                            ->where('b.title', 'like', '%'.$article_title.'%')
                            ->orderBy('id', 'asc')
                            ->get();

        if(!empty($check_task)){

            $tasks = DB::table('task as a')
                            ->join('articles as b', 'a.article_id', '=', 'b.id')
                            ->join('users as c', 'a.to_staff', '=', 'c.id')
                            ->select('a.*', 'c.name as staff')
                            ->where('b.title', 'like', '%'.$article_title.'%')
                            ->orderBy('id', 'asc')
                            ->get();
        }

        $data = '';
        $data .= '<table id="basic-datatable" class="table table-striped table-hover table-white nowrap dashboard_fix-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="hide-column">No</th>
                                    <th class="id_box">ID</th>
                                    <th class="text-left title_box">Title</th>
                                    <th class="author_box">Author</th>
                                    <th class="assigned_box">Assigned To</th>
                                    <th class="task_box">Task</th>
                                    <th class="satus_box">Status</th>
                                    <th class="paymeny_box">Payment</th>
                                    <th class="created_box">Craeted On</th>
                                </tr>
                            </thead>
                            <tbody>';
                            foreach( $rows as $row ){
        $data .=                '<tr>';
        $data .=                     '<td><a href="dashboard/admin/submission/show/'.$row->id.'">'.$row->journal_short_form."-0000".$row->id.'</td>';
        $data .=                     '<td>'.$row->title.'</td>';
        $data .=                     '<td>'.$row->authorname.'</td>';

                                if(isset($tasks)){
                                    $data .= '<td>
                                             <ol>';
                                            foreach($tasks as $task){
                                                if($task->article_id == $row->id){
                                            $data .=  '<li>'.$task->staff .'</li>';
                                            }
                                        }
                                    $data .= '</ol>
                                            </td>';


                                    $data .= '<td>
                                            <ol>';
                                           foreach($tasks as $task){
                                            if($task->article_id == $row->id){
                                    $data .=  '<li>'.$task->task_name .'</li>';
                                           }
                                        }
                                   $data .= '</ol>
                                           </td>';
                                }else{
                                    $data .= '<td></td>';
                                    $data .= '<td></td>';
                                }

        $data .=                     '<td><span class="badge badge-pill" style="background-color:'.$row->colourflag.'; color:#ffffff;border:1px solid '.$row->colourflag.'">'.$row->statusname.'</span></td>';


        if(!empty($row->payment_status)){
            $data_1 = $row->payment_status;
            $paymentstatus = strtok($data_1, '-');

        }else{
            $paymentstatus = "null";
        }


        $data .=                     '<td>';
                                        if($paymentstatus == "paid")
        $data .=                             '<span class="badge badge-pill" style="background-color:green; color:#ffffff;border:1px solid green">Paid</span>';
                                        elseif ($paymentstatus == "unpaid")
        $data .=                             '<span class="badge badge-pill" style="background-color:red; color:#ffffff;border:1px solid red">Un Paid</span>';
                                        else
        $data .=                            '<span class="badge badge-pill" style="background-color:blue; color:#ffffff;border:1px solid blue">Not Started</span>';
        $data .=                     '</td>';
        $data .=                     '<td>'.$row->created_at.'</td>';
        $data .=                 '</tr>';
                            }
        $data .=                '</tbody>
                                </table>';

        echo $data;



    }
}
