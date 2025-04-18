<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Http\Request;
use App\ArticleCategory;
use App\ArticleIssue;
use Dompdf\Dompdf;
use App\Article;
use App\Comment;
use App\User;
use Session;
use File;
use Auth;
use DB;
use View;


use GuzzleHttp\Client;



use Illuminate\Http\Client\Response;

// use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Http;

class SubmissionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Page Data
        $this->title = 'Submission';
        $this->url = 'submission';
    }

    public function index()
    {

//         $response = Http::withHeaders([
//             'Authorization' => 'Basic aHhoM0t0NUZFeExxbUNBVkh0cU86emRPMnJzaUpwWGJFT0FHZWdZNGx6ZXdTa1FCOFo0NnBaVUl6WVVyZg==',
//             'Content-Type' => 'application/json',
//         ])->post('https://restapi.smscountry.com/v0.1/Accounts/hxh3Kt5FExLqmCAVHtqO/SMSes/', [
//             'Text' => "Hi Durai , your paper id: 5678 is submitted successfully. Thank you for your interest in our journal.\n\nTrack: use your login Credential to check your article status.\n\n-Editorial Office/IJIRE International Journal \n\n5th Dimension Research Publication",
//             'Number' => '919843926632',
//             'SenderId' => 'FDRPJL',
//             'DRNotifyUrl' => 'https://www.domainname.com/notifyurl',
//             'DRNotifyHttpMethod' => 'POST',
//             'Tool' => 'API',
//         ]);

//         if ($response->successful()) {
//             $responseData = $response->json();
//             // Process the response data
//             echo json_encode($responseData);
//         } else {
//             $errorMessage = $response->body();
//             // Handle the error
//             echo $errorMessage;
//         }

//         // return response()->json(['message' => 'SMS Country request processed']);
// die;


        $title = $this->title;
        $url = $this->url;


        $user_type = Auth::user()->user_type;
        $user_id = Auth::user()->id;

        // $rows = Article::where('review_status', 2)
        //                     ->orderBy('id', 'asc')
        //                     ->get();

        $rows = DB::table('articles as a')
                            ->join('article_categories as b', 'a.category_id', '=', 'b.id')
                            ->join('master_status as e', 'a.status_type', '=', 'e.id')
                            ->select('a.*', 'e.name as statusname', 'b.title as category', 'e.colour as colourflag',)
                            ->orderBy('a.id', 'desc')
                            ->get();
        $categories = ArticleCategory::where('status', '1')->get();
        $approve = Article::where('review_status', '2')->get();
        $pending = Article::where('status_type', '2')
                                ->orwhere('status_type', '3')
                                ->orwhere('status_type', '4')
                                ->get();
                                // print_r($pending);
                                // die;
        $accepted = Article::where('status_type', '5')->get();
        $published = Article::where('status_type', '15')->get();
        $issue = '';
        $comment = Comment::all();
        $users = User::where('user_type', 'W')->get();
        $journalss = DB::select('select * from master_journal ORDER BY id ASC');

        return view('admin.submission.index', compact('title', 'accepted', 'published', 'journalss', 'categories', 'url', 'rows', 'approve', 'pending', 'issue', 'comment', 'users'));
    }

    public function submission_ajax(Request $request)
    {

        $id = $request->post('id');

        // $host = $request->getHost();
        $host = $request->getHost();
        $domain = explode('.', $host);
        $domainName = implode('.', array_slice($domain, -2));

        $rows = DB::table('articles as a')
                            ->join('article_categories as b', 'a.category_id', '=', 'b.id')
                            ->join('master_status as e', 'a.status_type', '=', 'e.id')
                            ->where('a.journal_type', $id)
                            ->select('a.*', 'e.name as statusname', 'b.title as category', 'e.colour as colourflag',)
                            ->orderBy('id', 'desc')
                            ->get();

                    $data = '';
                    $data .= '<table id="basic-datatable" class="table table-striped table-hover table-white nowrap dashboard_fix-table" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="hide-column">No</th>
                                                        <th>ID</th>
                                                        <th class="text-center title_box">Title</th>
                                                        <th>Research Area</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                            foreach( $rows as $key => $row )
                            {
                    $data .=         "<tr>";
                    $data .=                     '<td><a href="submission/show/'.$row->id.'">'.$row->journal_short_form."-0000".$row->id.'</td>';
                    $data .=            "<td>".$row->title."</td>";
                    $data .=            "<td>". $row->category."</td>";

                    $data .=            "<td><span class='badge badge-pill' style='background-color:".$row->colourflag."; color:#ffffff;border:1px solid ".$row->colourflag."'>".$row->statusname."</span></td>";
                    $data .=             "<td>
                                    <a href='article/show/".$row->id."'><button type='button' class='btn-success' style='height:30px;width:30px'>
                                        <i class='fas fa-eye'></i>
                                    </button></a>
                                    <button type='button' class='btn-primary' style='height:30px;width:30px' data-toggle='modal' data-target='#editModal-". $row->id."'>
                                        <i class='far fa-edit'></i>
                                    </button>

                                    <button type='button' class='btn-danger' style='height:30px;width:30px' data-toggle='modal' data-target='#deleteModal-". $row->id."'>
                                        <i class='fas fa-trash-alt'></i>
                                    </button>";


                                    if(is_file('uploads/article/'.$row->file_path))
                                    {
                                        // $data .= "<a href='uploads/article/".$row->file_path."' download><button type='button' class='btn-warning'><i class='fa fa-download'></i>
                                        // </button></a>";
                                    }





                $data .=                "</td>
                            </tr>";
                            }
                $data .= "</tbody>
                        </table>";


echo $data;








    }



    public function show($id)
    {
        $title = $this->title;
        $url = $this->url;
    

        $selected = DB::table('articles as a')
                            ->join('master_article as b', 'a.article_type', '=', 'b.id')
                            ->join('master_issue as c', 'a.issue_type', '=', 'c.id')
                            ->join('master_processing as d', 'a.processing_type', '=', 'd.id')
                            ->join('master_status as e', 'a.status_type', '=', 'e.id')
                            ->join('master_journal as f', 'a.journal_type', '=', 'f.id')
                            ->where('a.id', $id)
                            ->select('a.*', 'b.name as articlename', 'c.name as issuename','d.name as processingname','e.name as statusname', 'e.colour as colourflag', 'f.name as journalname')
                            ->get();
        
        $payment = DB::select('select p.*,j.short_form from master_payment as p join master_journal as j on j.id=p.journal_type');

        foreach($payment as $singlePay){
            if($singlePay->author_type == 'Indian'){
                $gst = $singlePay->gst;
                $with_doi_amount = round($singlePay->with_doi + (($singlePay->gst /100) * $singlePay->with_doi));
                $without_doi_amount = round($singlePay->without_doi + (($singlePay->gst /100) * $singlePay->without_doi));
            }else{
                $with_doi_amount = $singlePay->with_doi;
                $without_doi_amount = 0;
            }

            $payment_data[$singlePay->author_type][$singlePay->short_form]['withdoi'] = $with_doi_amount;
            $payment_data[$singlePay->author_type][$singlePay->short_form]['withoutdoi'] = $without_doi_amount;
            
        }


        $author = DB::table('articles as a')
                            ->join('users as g', 'a.writer_id', '=', 'g.id')
                            ->where('a.id', $id)
                            ->select('g.name as authorname', 'g.image_path', 'g.email', 'g.phone')
                            ->get();

        $tasks = DB::table('task as a')
                            ->join('articles as b', 'a.article_id', '=', 'b.id')
                            ->join('users as c', 'a.to_staff', '=', 'c.id')
                            ->where('a.article_id', $id)
                            ->select('a.*', 'c.name as staffname', 'c.image_path')
                            ->get();

        $reviews = DB::table('review as a')
                            ->join('articles as b', 'a.article_id', '=', 'b.id')
                            ->join('users as c', 'a.reviewer_id', '=', 'c.id')

                            ->where('a.article_id', $id)
                            ->select('a.*', 'c.name as reviername','c.reviewerid as reviewerid','c.id as user_id','c.department as user_department')
                            ->get();

        
        $review_status = DB::select('select * from review_evalution where article_id ='.$id );

        $previous_id = DB::select('select id from articles where id < ? order by id desc limit 1', [$id]);

        $next_id = DB::select('select id from articles where id > ? order by id asc limit 1', [$id]);

        $previous_id_object = $previous_id ?$previous_id[0] : null ; // Access the first element of the array




        if($previous_id_object){
            $previous_id = $previous_id_object->id;
        }else{
            $previous_id = null;
        }
     
        $next_id_obj = $next_id ? $next_id[0] : null;

        if($next_id_obj){
            $next_id = $next_id_obj->id;
        }else{
            $next_id = null;
        }
        

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

        $files_0 = DB::table('file as a')
        ->join('articles as b', 'a.article_id', '=', 'b.id')
        ->where('a.article_id', $id)
        ->where('a.category',0)
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
                            ->where('a.status','Accepted')
                            ->select('a.*', 'b.title as articletitle')
                            ->get();

        $final_manuscripts = DB::table('final_submission as a')
                            ->join('articles as b', 'a.article_id', '=', 'b.id')
                            ->where('a.article_id', $id)
                            ->where('category', 1)
                            ->select('a.*', 'b.title as articletitle')
                            ->get();

        $final_copy_right_forms = DB::table('final_submission as a')
                            ->join('articles as b', 'a.article_id', '=', 'b.id')
                            ->where('a.article_id', $id)
                            ->where('category', 2)
                            ->select('a.*', 'b.title as articletitle')
                            ->get();

        $final_payment_scripts = DB::table('final_submission as a')
                            ->join('articles as b', 'a.article_id', '=', 'b.id')
                            ->where('a.article_id', $id)
                            ->where('category', 3)
                            ->select('a.*', 'b.title as articletitle')
                            ->get();


        $staffs =  DB::select('select * from users WHERE user_type = "S"');
        $reviewers =  DB::select('select * from users WHERE user_type = "R"');
        $rows = DB::select('select * from articles where id='. $id);
        $articles = DB::select('select * from master_article');
        $journals = DB::select('select * from master_journal ORDER BY id ASC');
        $issues = DB::select('select * from master_issue');
        $processings = DB::select('select * from master_processing');
        $statuss = DB::select('select * from master_status');

        $tab = 'tasks';
        return view('admin.submission.view', compact('gst','payment_data','previous_id','next_id','url', 'final_payment_scripts', 'final_manuscripts', 'final_copy_right_forms', 'acceptances', 'files_0' ,'files_1', 'files_2', 'files_3', 'copy_rigth_files', 'reviewers', 'reviews', 'id', 'author', 'tasks', 'staffs', 'journals', 'rows', 'selected', 'title', 'articles', 'issues', 'processings', 'statuss','review_status'));
    }

    public function author_file_upload(Request $request, $id)
    {

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
        try {
            $insertedId = DB::table('file')->insertGetId($data);
        } catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage()); // Display the SQL error message for debugging
        }
        Session::flash('success', 'File Uploaded Successfully!');

        return redirect()->back()->withInput(['tab' => 'files']);
    }

    public function show_review_question($id)
    {

        $title = "Review Evalution";
        $url = $this->url;

        // $answers = DB::select('select * from review_evalution where review_id = '.$id);

        $rows = DB::table('review_evalution as a')
                            ->join('review as b', 'a.review_id', '=', 'b.id')
                            ->where('a.review_id', $id)
                            ->select('a.*')
                            ->get();



        return view('admin.article.review_evalution', compact('title', 'rows'));
    }

    public function update(Request $request, $id)
    {
        $title = $this->title;
        $url = $this->url;

        // Update Data
        $data = Article::find($id);
        $data->notes = $request->notes;
        $data->updated_by = Auth::user()->id;
        $data->save();


        Session::flash('success', $this->title.' Updated Successfully!');

        // return redirect()->route('new.submission');
        return redirect()->back()->withInput(['tab' => 'details']);
    }



    public function create()
    {
        $title = $this->title;
        $url = $this->url;


        $user_id = Auth::user()->id;

        $categories = ArticleCategory::where('status', '1')->get();

        $articles = DB::select('select * from master_article');
        $journals = DB::select('select * from master_journal ORDER BY id ASC');
        $issues = DB::select('select * from master_issue');
        $processings = DB::select('select * from master_processing');
        $statuss = DB::select('select * from master_status');

        // print_r($journal);
        // die;
        return view('admin.submission.create', compact( 'categories', 'title', 'url', 'articles', 'journals', 'issues', 'processings', 'statuss'));
    }

    public function store(Request $request)
    {
        // Field Validation
        $request->validate([
            'title' => 'required|max:250',
            'category' => 'required',
            'details' => 'required',
            'image' => 'nullable|image',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,ppt,pptx,doc,docx,pdf,xls,xlsx|max:51200',
            // 'video_id' => 'nullable|max:100',
        ]);


        // file upload, fit and store inside public folder
        if($request->hasFile('file')){
            //Upload New Image
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileNameToStore = str_replace([' ','-','&','#','$','%','^',';',':'],'_',$filename).'_'.time().'.'.$extension;

            //Crete Folder Location
            $path = public_path('uploads/article/');
            if (! File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            // Move File inside public/uploads/ folder
            $file = $request->file('file')->move($path, $fileNameToStore);

        }
        else{
            $fileNameToStore = NULL;
        }

        // image upload, fit and store inside public folder
        if($request->hasFile('image')){
            //Upload New Image
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $imageNameToStore = $filename.'_'.time().'.'.$extension;

            //Crete Folder Location
            $path = public_path('uploads/article/');
            if (! File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $img = $request->file('image')->move($path, $imageNameToStore);
            //Resize And Crop as Fit image here (640 width, 400 height)
            // $thumbnailpath = $path.$imageNameToStore;
            // $img = Image::make($request->file('image')->getRealPath())->fit(640, 400, function ($constraint) { $constraint->upsize(); })->save($thumbnailpath);
            // print_r($file);
            // die;
        }
        else{
            $imageNameToStore = 'no_image.jpg';
        }

        $jurnalId = $request->journal;
        $shortForm = DB::select('select * from master_journal where id ='. $jurnalId);
        // print_r($shortForm[0]->short_form);
        // die;


        // Insert Data
        $data = new Article;
        $data->title = $request->title;
        $data->category_id = $request->category;
        $data->writer_id = Auth::user()->id;
        $data->description = $request->details;
        $data->image_path = $imageNameToStore;
        $data->file_path = $fileNameToStore;
        $data->journal_short_form = $shortForm[0]->short_form;
        $data->upload_status = 1;
        $data->review_status = 2;
        $data->status = 1;
        $data->journal_type = $request->journal;
        $data->article_type = $request->article_type;
        $data->issue_type = $request->issue_type;
        $data->processing_type = $request->processing_type;
        $data->status_type = 1;
        $data->ref_id = $request->ref_id;
        // $data->scheduled_on = $request->scheduled_on;
        $data->created_by = Auth::user()->id;
        $insert = $data->save();
        $id = $data->id;


        if($insert){

            // $result = DB::table('articles as a')
            //                 ->join('master_journal as b', 'b.id', '=', 'a.journal_type')
            //                 ->join('master_status as c', 'c.id', '=', 'a.status_type')
            //                 ->join('users as d', 'd.id', '=', 'a.writer_id')
            //                 ->where('a.id', $id)
            //                 ->select('a.*', 'b.name as journalname', 'c.name as statusname', 'd.name as authorname', 'd.email as senderemail')
            //                 ->get();

            // $email = $result[0]->senderemail;

            // $subject = "Paper Successfully Received - Online Submission: Paper ID- '".$result[0]->journal_short_form.'-0000'.$result[0]->id."'";

            // $body = view('admin.submission.emailbody.submission')->with('name', $result)->render();

            // $this->email($body,$subject,$email);

        }

        Session::flash('success', 'Article Created Successfully!');

        return redirect('/dashboard/admin/submission');
    }


    public function task(Request $request, $id)
    {
        // $task_name = $request->task_name;
        // $reviewer = $request->assigned_to;
        // // print_r($task_name);
        // print_r($id);
        // die;

        // Insert Data

        $data = array(
            "task_name" =>$request->task_name,
            "to_staff" =>$request->assigned_to,
            "article_id" =>$id,
            "status" => "Not Started",
            "due_date" => $request->due_date
        );
        $inser_data = DB::table('task')->insert($data);

        Session::flash('success', 'Task Inserted Successfully!');

        // return redirect()->back('#task');
        // return redirect('dashboard/admin/submission/show/'.$id);
        // return redirect()->route('submission.show', $id)->withInput(['tab'=>'tasks']);->with('added', 'Questions has been added');
        return redirect()->back()->withInput(['tab' => 'tasks']);
    }

    public function review(Request $request, $id)
    {
        // $task_name = $request->task_name;
        // $reviewer = $request->assigned_to;
        // // print_r($task_name);
        // print_r($id);
        // die;

        // Insert Data

        $data = array(
            "reviewer_id" =>$request->reviewer_id,
            "article_id" =>$id,
            "status" => "Not Starded",
            "due_date" => $request->due_date,
            "decision" => '-------'
        );
        // print_r($data);
        // die;
        $inser_data = DB::table('review')->insert($data);

        Session::flash('success', 'Review Inserted Successfully!');

        return redirect()->back()->withInput(['tab' => 'review']);
    }


    public function change_details(Request $request)
    {
        if($request->post('journaldata'))
        {
            $shortForm = DB::select('select * from master_journal where id ='. $request->post('journaldata'));
            $data = array
            (
            "journal_type" => $request->post('journaldata'),
            "journal_short_form" => $shortForm[0]->short_form
            );
            $id=$request->post('id');
            $update_table = DB::table('articles')->where( 'id' , $id)->update($data);
            if($update_table)
            {
                echo "Journal Name Changed Successfully";
            }else{

            }
        }

        if($request->post('articledata'))
        {
            $data = array
            (
            "article_type" => $request->post('articledata')
            );
            $id=$request->post('id');
            $update_table = DB::table('articles')->where( 'id' , $id)->update($data);
            if($update_table)
            {
                echo "Article Name Changed Successfully";
            }else{

            }
        }

        if($request->post('issuedata'))
        {
            $data = array
            (
            "issue_type" => $request->post('issuedata')
            );
            $id=$request->post('id');
            $update_table = DB::table('articles')->where( 'id' , $id)->update($data);
            if($update_table)
            {
                echo "Issue Name Changed Successfully";
            }else{

            }
        }

        if($request->post('processingdata'))
        {
            $data = array
            (
            "processing_type" => $request->post('processingdata')
            );
            $id=$request->post('id');
            $update_table = DB::table('articles')->where( 'id' , $id)->update($data);
            if($update_table)
            {
                echo "Mode Processing Set Successfully";
            }else{

            }
        }

        if($request->post('statusdata'))
        {
            $data = array
            (
            "status_type" => $request->post('statusdata')
            );
            $id=$request->post('id');
            $update_table = DB::table('articles')->where( 'id' , $id)->update($data);
            if($update_table)
            {
                echo "Status Name Changed Succesfully";
            }else{

            }

            $data = DB::table('articles as a')
                            ->join('master_journal as b', 'b.id', '=', 'a.journal_type')
                            ->join('master_status as c', 'c.id', '=', 'a.status_type')
                            ->join('users as d', 'd.id', '=', 'a.writer_id')
                            ->where('a.id', $id)
                            ->select('a.*', 'b.name as journalname', 'c.name as statusname', 'd.name as authorname', 'd.email as senderemail', 'd.phone')
                            ->get();

            $recipient_name = $data[0]->authorname;
            $journal = $data[0]->journal_short_form;
            $email = $data[0]->senderemail;
            $status = $request->post('statusdata');

            $phone = $data[0]->phone;
            $name = $data[0]->authorname;
            $id = $data[0]->journal_short_form.'-0000'.$data[0]->id;
            switch($journal){
                case "IJIRE" : $split_url = "editorial.fdrpjournals.org/login?journal=1"; break;
                    case "INDJCST" : $split_url = "editorial.fdrpjournals.org/login?journal=6"; break;
                        case "IJSREAT" : $split_url = "editorial.fdrpjournals.org/login?journal=2"; break;
                            case "IJRTMR" : $split_url = "editorial.fdrpjournals.org/login?journal=3"; break;
                                case "INDJEEE" : $split_url = "editorial.fdrpjournals.org/login?journal=4"; break;
                                    case "INDJECE" : $split_url = "editorial.fdrpjournals.org/login?journal=5"; break;
            }

            $splitUrl = $this->splitUrl($split_url);

            $firstUrl = $splitUrl['first_part'];
            $secUrl = $splitUrl['second_part'];
            if($status == 2){

                $subject = "Article under Plagiarism Check process: Paper ID: '".$data[0]->journal_short_form.'-0000'.$data[0]->id."'";

                $body = view('admin.submission.emailbody.plagarism_check')->with('name', $data)->render();

                $this->email($body,$subject,$email,$journal,$recipient_name);

                $this->sms($journal, $status, $name, $id, $phone);

            }elseif($status == 4){

                $subject = "Article Under peer-reviewed process:  Paper ID: '".$data[0]->journal_short_form.'-0000'.$data[0]->id."'";

                $body = view('admin.submission.emailbody.peer_review')->with('name', $data)->render();

                $this->email($body,$subject,$email,$journal,$recipient_name);

            }elseif($status == 5){

                // $firstUrl = "https://editorial.fdrpjournals.org/login?";
                // $secUrl = "journal=1";
                $temp = "Hi ".$recipient_name.",Paper ID:".$id." Your paper has been Accepted. login your Author Credential and complete the formalities. Note: Submit Final documents: Article,Copyright, APC, in Final submission Tab-within a week. Author Login Link :".$firstUrl.$secUrl.", -Editorial Office/".$journal."-Journal, 5th Dimension Research Publication";

                $subject = "Acceptance Mail from ".$data[0]->journal_short_form." Journals - International Peer Reviewed Journal Paper ID: '".$data[0]->journal_short_form.'-0000'.$data[0]->id."'";

                $body = view('admin.submission.emailbody.acceptance')->with('name', $data)->render();

                $this->email($body,$subject,$email,$journal,$recipient_name);

                $this->sms($journal, $status, $name, $id, $phone,$temp);

            }elseif( $status == 6 ){

                $subject = $data[0]->journal_short_form."_Status update: Paper ID: '".$data[0]->journal_short_form.'-0000'.$data[0]->id."'";

                $body = view('admin.submission.emailbody.under_proof_reading')->with('name', $data)->render();

                $this->email($body,$subject,$email,$journal,$recipient_name);

                $this->sms($journal, $status, $name, $id, $phone);

            }elseif($status == 7){

                $subject = $data[0]->journal_short_form."_Status update: Paper ID: '".$data[0]->journal_short_form.'-0000'.$data[0]->id."'";

                $body = view('admin.submission.emailbody.under_layout_editing')->with('name', $data)->render();

                $this->email($body,$subject,$email,$journal,$recipient_name);

            }elseif($status == 8){

                $subject = $data[0]->journal_short_form."_Status update: Paper ID: '".$data[0]->journal_short_form.'-0000'.$data[0]->id."'";

                $body = view('admin.submission.emailbody.under_galley_correction')->with('name', $data)->render();

                $this->email($body,$subject,$email,$journal,$recipient_name);

            }elseif($status == 15){
                $temp = "Hi ".$recipient_name.", Paper ID:".$id." is published successfully, For details- check your email and journal. Note: For Certificates-download, Published Article Details, DOI Link-Kindly check your Author Account. Author Login Link :".$firstUrl.$secUrl.", -Editorial Office/".$journal."-Journal, 5th Dimension Research Publication";

                $subject = "Article Published in ".$data[0]->journal_short_form." International Peer Reviewed Journal Paper ID: '".$data[0]->journal_short_form.'-0000'.$data[0]->id."'";

                $body = view('admin.submission.emailbody.published')->with('name', $data)->render();

                $this->email($body,$subject,$email,$journal,$recipient_name);

                $this->sms($journal, $status, $name, $id, $phone,$temp);

            }elseif($status == 17){

                $subject = "Review status: Paper ID: '".$data[0]->journal_short_form.'-0000'.$data[0]->id."'";

                $body = view('admin.submission.emailbody.reject')->with('name', $data)->render();

                $this->email($body,$subject,$email,$journal,$recipient_name);

            }

        }

        if($request->post('activation_statusdata'))
        {
            $data = array
            (
            "status" => $request->post('activation_statusdata')
            );
            $id=$request->post('id');
            $update_table = DB::table('articles')->where( 'id' , $id)->update($data);
            if($update_table)
            {
                echo "Activation Status Changed Successfully";
            }else{

            }
        }

        if($request->post('sheduled_ondata'))
        {
            $data = array
            (
            "scheduled_on" => $request->post('sheduled_ondata')
            );
            $id=$request->post('id');
            $update_table = DB::table('articles')->where( 'id' , $id)->update($data);
            if($update_table)
            {
                echo "Scheduled Date Changed Successfully";
            }else{

            }
        }

    }

    public function splitUrl($url, $length = 27)
    {
        // Split the URL into two parts based on the specified length
        $firstPart = substr($url, 0, $length);
        $secondPart = substr($url, $length);

        return [
            'first_part' => $firstPart,
            'second_part' => $secondPart
        ];
    }

    public function change_kan_ban_task(Request $request)
    {
        $id = $request->post('id');
        $status = $request->post('status');
        // print_r($id);
        // print_r($status);
        $data = array
            (
            "status" => $request->post('status')
            );
        $update_table = DB::table('task')->where( 'id' , $id)->update($data);

        if($update_table)
        {
            echo "Task Status Changed Successfully";
        }

    }

    public function change_kan_ban_review(Request $request)
    {
        $id = $request->post('id');
        
        $status = $request->post('status');
        $data = array
            (
            "status" => $request->post('status')
            );
        $update_table = DB::table('review')->where( 'id' , $id)->update($data);

        if($status == 'In progress'){

            $result = DB::table('review as r')
            ->join('articles as a', 'a.id', '=', 'r.article_id')
            ->join('users as u', 'u.id', '=' , 'r.reviewer_id')
            ->join('master_journal as mj', 'mj.id', '=' , 'a.journal_type')
            ->where('r.id',$id)
            ->select('r.id as reviewer_id', 'a.id as article_id', 'r.due_date','mj.name as journal_name','mj.short_form as journal_short_form','a.title','u.email','u.name','u.phone','u.reviewerid')
            ->get();
            
       
            $journal = $result[0]->journal_name;
            $email = $result[0]->email;
            $recipient = $result[0]->name;
    
            $subject = "Task";
    
            $body = view('admin.submission.emailbody.reviewer')->with('name', $result)->render();
         
            $data = $this->email($body,$subject,$email,$journal,$recipient);
            if($data){
                echo "Review Status Changed Successfully";
            }
        }else{
            echo "Review Status Changed Successfully";
        }
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

    public function file_upload(Request $request, $id)
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
            "article_id" =>$id
        );
        $inser_data = DB::table('file')->insert($data);

        Session::flash('success', 'File Uploaded Successfully!');

        return redirect()->back()->withInput(['tab' => 'files']);
    }


    public function acceptance(Request $request, $id)
    {
        $data = array(
            "article_id" =>$id,
            "scheduled_to" =>$request->scheduled_to,
            "published_on" =>$request->published_on,
            "status" => $request->status,
            "action_for_author" => 'Hide'
        );
        $inser_data = DB::table('acceptance')->insert($data);

        Session::flash('success', 'Acceptance Inserted Successfully!');

        // return redirect()->back('#task');
        // return redirect('dashboard/admin/submission/show/'.$id);
        // return redirect()->route('submission.show', $id)->withInput(['tab'=>'tasks']);->with('added', 'Questions has been added');
        return redirect()->back()->withInput(['tab' => 'acceptance']);
    }



    public function copy_right_file(Request $request, $id)
    {
        // file upload, fit and store inside public folder
        if($request->hasFile('file')){
            //Upload New Image
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileNameToStore = str_replace([' ','-','&','#','$','%','^',';',':'],'_',$filename).'_'.time().'.'.$extension;

            //Crete Folder Location
            $path = public_path('uploads/copyrigt_form/');
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
            "doc_title" =>$filename,
            "file_path" =>$fileNameToStore,
            "article_id" =>$id
        );
        $inser_data = DB::table('copy_rigth_files')->insert($data);

        Session::flash('success', 'Copy Right Form Uploaded Successfully!');

        return redirect()->back()->withInput(['tab' => 'copyrights']);
    }


    public function final_submission_manuscript(Request $request, $id)
    {

        // file upload, fit and store inside public folder
        if($request->hasFile('file')){
            //Upload New Image
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileNameToStore = str_replace([' ','-','&','#','$','%','^',';',':'],'_',$filename).'_'.time().'.'.$extension;

            //Crete Folder Location
            $path = public_path('uploads/final_submission/');
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
            "doc_title" =>$filename,
            "file_path" =>$fileNameToStore,
            "category" =>1,
            "article_id" =>$id
        );
        $inser_data = DB::table('final_submission')->insert($data);

        Session::flash('success', 'Final Manuscript Uploaded Successfully!');

        return redirect()->back()->withInput(['tab' => 'final_submission']);
    }

    public function final_submission_payment_manuscript(Request $request, $id)
    {

        // file upload, fit and store inside public folder
        if($request->hasFile('file')){
            //Upload New Image
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileNameToStore = str_replace([' ','-','&','#','$','%','^',';',':'],'_',$filename).'_'.time().'.'.$extension;

            //Crete Folder Location
            $path = public_path('uploads/final_submission/');
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
            "doc_title" =>$filename,
            "file_path" =>$fileNameToStore,
            "category" =>3,
            "article_id" =>$id
        );
        $inser_data = DB::table('final_submission')->insert($data);

        Session::flash('success', 'Payment Manuscript Uploaded Successfully!');

        return redirect()->back()->withInput(['tab' => 'final_submission']);
    }

    public function final_submission_copyright_form(Request $request, $id)
    {

        // file upload, fit and store inside public folder
        if($request->hasFile('file')){
            //Upload New Image
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileNameToStore = str_replace([' ','-','&','#','$','%','^',';',':'],'_',$filename).'_'.time().'.'.$extension;

            //Crete Folder Location
            $path = public_path('uploads/final_submission/');
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
            "doc_title" =>$filename,
            "file_path" =>$fileNameToStore,
            "category" =>2,
            "article_id" =>$id
        );
        $inser_data = DB::table('final_submission')->insert($data);

        Session::flash('success', 'Final Copy Right Form Successfully!');

        return redirect()->back()->withInput(['tab' => 'final_submission']);
    }


    public function email($body, $subject, $email, $journal, $recipient_name)
    {
        //Welcome Mail Generator
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.zoho.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'noreply@fdrpjournals.org';
        $mail->Password = 'Fdrp_jms2023';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        // Enable sending HTML content
        $mail->isHTML(true);
        $mail->setFrom('noreply@fdrpjournals.org', 'Support_'.$journal);
        $mail->addAddress($email, $recipient_name);
        $mail->Subject = $subject;
        $mail->Body = $body;

        try {
            $mail->send();
            // echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent. Error: ', $mail->ErrorInfo;
            die;
        }
    }

    public function copyright_form($id)
    {
        $data = DB::table('articles as a')
                            ->join('master_journal as b', 'b.id', '=', 'a.journal_type')
                            ->join('users as d', 'd.id', '=', 'a.writer_id')
                            ->where('a.id', $id)
                            ->select('a.*', 'd.name as authorname', 'd.email as authoremail', 'd.phone as mobile', 'd.address as authoraddress', 'b.name as journalname')
                            ->get();


        $yourArray = [
            'mobile' => $data[0]->mobile,
            'authoraddress' => $data[0]->authoraddress
        ];

        if (empty($yourArray['mobile']) || empty($yourArray['authoraddress'])) {
            // Either field1 or field2 is empty, display alert
            // echo '<script>alert("Please Update Your Profile");</script>';
            return redirect()->back()->with('alert', 'Please Update Your Profile.');

        }else{

            $html = view('admin.submission.copy_right_form.copyrigthform')->with('name', $data)->render();
            $pdf = new Dompdf();
            $pdf->loadHtml($html);
            $pdf->setPaper('A4', 'portrait');
            $pdf->render();

            $currentYear = date('Y');


            return $pdf->stream($data[0]->journal_short_form.'_Copyright Transfer Agreement '.$currentYear.'.pdf');
        }

    }

    public function review_question($id)
    {
        $title = "Review Evalution";
        $url = $this->url;

        $answers = DB::select('select * from review_evalution where review_id = '.$id);

        return view('admin.submission.review_question', compact('title', 'answers', 'id'));
    }

    public function add_review_question(Request $request, $review_id)
    {

        $article = DB::select('select article_id from review where id = '.$review_id);

        $data = array(
            'article_id' => $article[0]->article_id,
            'review_id' => $review_id,
            'comment_1' => $request->comment_1,
            'comment_2' => $request->comment_2,
            'comment_3' => $request->comment_3,
            'comment_4' => $request->comment_4,
            'comment_5' => $request->comment_5,
            'comment_6' => $request->comment_6,
            'comment_7' => $request->comment_7,
            'comment_8' => $request->comment_8,
            'comment_9' => $request->comment_9,
            'comment_10' => $request->comment_10,
            'comment_11' => $request->comment_11,
            'comment_12' => $request->comment_12,
            'comment_13' => $request->comment_13,
            'comment_14' => $request->comment_14
        );
        $inser_data = DB::table('review_evalution')->insert($data);

        Session::flash('success', 'Review Evalution Submitted Successfully!');

        return redirect('/dashboard/admin/submission/show/'.$article[0]->article_id)->withInput(['tab' => 'review']);
    }


    public function edit_review_question(Request $request, $review_id)
    {

        $article = DB::select('select article_id from review where id = '.$review_id);

        $data = array(
            'article_id' => $article[0]->article_id,
            'review_id' => $review_id,
            'comment_1' => $request->comment_1,
            'comment_2' => $request->comment_2,
            'comment_3' => $request->comment_3,
            'comment_4' => $request->comment_4,
            'comment_5' => $request->comment_5,
            'comment_6' => $request->comment_6,
            'comment_7' => $request->comment_7,
            'comment_8' => $request->comment_8,
            'comment_9' => $request->comment_9,
            'comment_10' => $request->comment_10,
            'comment_11' => $request->comment_11,
            'comment_12' => $request->comment_12,
            'comment_13' => $request->comment_13,
            'comment_14' => $request->comment_14
        );

        $update_table = DB::table('review_evalution')->where( 'article_id' , $article[0]->article_id)->update($data);

        Session::flash('success', 'Review Evalution edited Successfully!');

        return redirect('/dashboard/admin/submission/show/'.$article[0]->article_id)->withInput(['tab' => 'review']);
    }

    public function review_decision(Request $request)
    {
        $status = $request->post('status');
        $id=$request->post('id');

        $data = array
            (
            "decision" => $status,
            );


            $update_table = DB::table('review')->where( 'article_id' , $id)->update($data);

            if($update_table)
            {
                echo "Decision status Changed Successfully";
            }else{

            }
    }


    public function acceptance_status(Request $request)
    {
        $status = $request->post('status');
        $id=$request->post('id');

        $data = array
            (
            "status" => $status,
            );


            $update_table = DB::table('acceptance')->where( 'article_id' , $id)->update($data);

            if($update_table)
            {
                echo "Acceptance status Changed Successfully";
            }else{

            }
    }

    public function acceptance_action(Request $request)
    {
    
    
        $status = $request->post('status');
        
        $id=$request->post('id');

        $data = array
            (
            "action_for_author" => $status,
            );


            $update_table = DB::table('acceptance')->where( 'article_id' , $id)->update($data);

            if($update_table)
            {
                echo "Acceptance action changed successfully";
            }else{
                echo "Something went wrong";
            }
    }

    public function download_final_submission_format()
    {


            $html = view('admin.submission.copy_right_form.final_submission_format')->render();
            $pdf = new Dompdf();
            $pdf->loadHtml($html);
            $pdf->setPaper('A4', 'portrait');
            $pdf->render();

            $currentYear = date('Y');


            return $pdf->stream('Final_Submission_format.pdf');
        

    }


    public function acceptance_letter($id)
    {

        $data = DB::table('articles as a')
                            ->join('master_journal as b', 'b.id', '=', 'a.journal_type')
                            ->join('master_article as c', 'c.id', '=', 'a.article_type')
                            ->join('users as d', 'd.id', '=', 'a.writer_id')
                            ->join('acceptance as e', 'a.id', '=', 'e.article_id')
                            ->where('a.id', $id)
                            ->select('a.*', 'e.accepted_on as date', 'e.scheduled_to', 'c.name as articletype', 'd.name as authorname', 'd.email as authoremail', 'd.phone as mobile', 'd.address as authoraddress', 'b.name as journalname')
                            ->get();

        $acceptance_date = substr($data[0]->date, 0, 10);


        $yourArray = [
            'mobile' => $data[0]->mobile,
            'authoraddress' => $data[0]->authoraddress
        ];

        if (empty($yourArray['mobile']) || empty($yourArray['authoraddress'])) {
            // Either field1 or field2 is empty, display alert
            // echo '<script>alert("Please Update Your Profile");</script>';
            return redirect()->back()->with('alert', 'Please Update Your Profile.');

        }else{

            $html = view('admin.submission.copy_right_form.acceptance_letter')->with('name', $data)->render();
            $pdf = new Dompdf(array('enable_remote' => true));
            $pdf->loadHtml($html);

            $pdf->setPaper('A4', 'portrait');

            $pdf->render();

            $currentYear = date('Y');


            return $pdf->stream('Acceptance_Letter.pdf');
        }

    }

    public function payment_status(Request $request)
    {

        $status = $request->post('status');
        $id=$request->post('id');

        if(empty($status))
        {
            exit;
        }
        $data = array
            (
            "payment_status" => $status,
            );


            $update_table = DB::table('articles')->where( 'id' , $id)->update($data);

            if($update_table)
            {
                echo "Payment status Changed Successfully";
            }else{

            }
    }

    public function final_submission_update(Request $request, $id)
    {

        // Field Validation
        $request->validate([
            'file' => 'nullable|file|mimes:jpg,jpeg,png,ppt,pptx,doc,docx,pdf,xls,xlsx|max:51200',
        ]);


        // file upload, fit and store inside public folder
        if($request->hasFile('file')){

            //Delete Old Image
            $old_file = DB::select('select * from final_submission where id = '.$id);


            $file_path = public_path('uploads/final_submission/'.$old_file[0]->file_path);
            if(File::isFile($file_path)){
                File::delete($file_path);
            }

            //Upload New Image
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileNameToStore = str_replace([' ','-','&','#','$','%','^',';',':'],'_',$filename).'_'.time().'.'.$extension;

            //Crete Folder Location
            $path = public_path('uploads/final_submission/');
            if (! File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            // Move File inside public/uploads/ folder
            $file = $request->file('file')->move($path, $fileNameToStore);
        }
        else{

            $old_file = DB::select('select * from final_submission where id = '.$id);

            $fileNameToStore = $old_file[0]->file_path;
        }

        $data = array
            (
            "file_path" => $fileNameToStore,
            "doc_title" => $fileNameToStore,
            );


            $update_table = DB::table('final_submission')->where( 'id' , $id)->update($data);


        Session::flash('success', 'Final submission Manuscript Updated Successfully!');

        return redirect()->back();
    }

    public function final_submission_freeze(Request $request, $id)
    {
        $data = array
            (
            "freeze_data" => 1
            );


        $update_table = DB::table('articles')->where( 'id' , $id)->update($data);

            if($update_table)
            {
            $super_admin_details = DB::table('users as a')
                                ->where('a.user_type', "A")
                                ->select('a.*')
                                ->get();

            $result = DB::table('articles as a')
                            ->join('master_journal as b', 'b.id', '=', 'a.journal_type')
                            ->join('master_status as c', 'c.id', '=', 'a.status_type')
                            ->join('users as d', 'd.id', '=', 'a.writer_id')
                            ->where('a.id', $id)
                            ->select('a.*', 'b.name as journalname', 'b.short_form', 'c.name as statusname', 'd.name as authorname', 'd.email as senderemail')
                            ->get();

           // For Super Admin Notification
           $journal = $result[0]->short_form." ID - ".$result[0]->short_form."-0000".$result[0]->id;
           $email = $super_admin_details[0]->email;
           $subject = "Final Submission ".$result[0]->short_form;
           $recipient_name = "Super Admin";
           // Get the current date and time

           $body = 'Name: '.$result[0]->authorname.'<br><br>

                       Title: '. $result[0]->title.'<br>
                       Submited on: '.$result[0]->updated_at;

           $this->email($body,$subject,$email,$journal, $recipient_name);
        }


        Session::flash('success', 'Final submitted Successfully!');

        return redirect()->back();
    }


    public function final_submission_unfreeze(Request $request, $id)
    {

        $data = array
            (
            "freeze_data" => 0
            );


        $update_table = DB::table('articles')->where( 'id' , $id)->update($data);

            if($update_table)
            {
                Session::flash('success', 'Manuscript Un Freeze Successfully!');

                return redirect()->back();
            }
    }

    public function file_destroy(Request $request, $id)
    {
        $data = DB::table('file as a')
                    ->where('a.id', $id)
                    ->select('a.*')
                     ->get();

        $file_path = public_path('uploads/article_file/'.$data[0]->file_path);
            if(File::isFile($file_path)){
                File::delete($file_path);
            }

        DB::table('file')->where('id', '=', $id)->delete();

        Session::flash('success', 'File Deleted Successfully!');

        return redirect()->back()->withInput(['tab' => 'files']);
    }

    public function sms($journal, $status, $name, $id, $phone,$temp)
    {
        if($journal == 'IJIRE' || $journal == 'IJRTMR' || $journal == 'IJSREAT')
        {

            if($status == 2){  
         
                $message = "Hi ".$name.", your paper id: ".$id." Plagiarism Check & Peer-Review initiated successfully.\n\nTrack: use your login Credential to check your article status.\n\n-Editorial Office/".$journal." International Journal\n\n5th Dimension Research Publication";
            }elseif($status == 5){
                $message = $temp;
                //$message = "Hi ".$name.",Paper ID:".$id." Your paper has been Accepted.login your Author Credential and complete the formalities. Note: Submit Final documents: Article,Copyright,APC, in Final submission Tab-within a week.
                //Author Login Link :".$link.", -Editorial Office/".$journal."-Journal, 5th Dimension Research Publication";

            }elseif($status == 6){
                $message = "Hi ".$name.", your paper id: ".$id." copyright and processing formalities completed successfully, your article will be publish within 24hrs.\n\nTrack: use your login Credential to check your article status.\n\n-Editorial Office/".$journal." International Journal\n\n5th Dimension Research Publication";
            }elseif($status == 15){
                $message = $temp;
                // $message = "Hi ".$name.",Paper ID:".$id." is Published successfully, For details- check your email and journal.
                // Note: For Certificates-download,Published Article Details,DOI Link-Kindly check your Author Account.
                // Login Link: ".$link." -Editorial Office/".$journal."-Journal,
                // 5th Dimension Research Publication";
                // $message = "Hi ".$name.", Paper ID:".$id." is Published successfully, For details- check your email and journal.";
               
                
            }
        }else{

            if($status == 2){
               
                $message = "Hi ".$name.", your paper id: ".$id." Plagiarism Check & Peer-Review initiated successfully.\n\nTrack: use your login Credential to check your article status.\n\n-Editorial Office/".$journal." Journal\n\n5th Dimension Research Publication";
            }elseif($status == 5){
                $message = $temp;
                //$message = "Hi ".$name.",Paper ID:".$id." Your paper has been Accepted.login your Author Credential and complete the formalities. Note: Submit Final documents: Article,Copyright,APC, in Final submission Tab-within a week.
                //Author Login Link :".$link.", -Editorial Office/".$journal."-Journal, 5th Dimension Research Publication";
            }elseif($status == 6){
                $message = "Hi ".$name.", your paper id: ".$id." copyright and processing formalities completed successfully, your article will be publish within 24hrs.\n\nTrack: use your login Credential to check your article status.\n\n-Editorial Office/".$journal." Journal\n\n5th Dimension Research Publication";
            }elseif($status == 15){
                $message = $temp;
                // $message = "Hi ".$name.",Paper ID:".$id." is Published successfully, For details- check your email and journal.
                // Note: For Certificates-download,Published Article Details,DOI Link-Kindly check your Author Account.
                // Login Link: ".$link." -Editorial Office/".$journal."-Journal,
                // 5th Dimension Research Publication";
            }
        }   
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode('zHz1Fj23TwN570ITYDgs:KCEzkUVPDDdXlZz3hIqn1coD3rnRkzdzEuzoY4S5'),
            'Content-Type' => 'application/json',
        ])->post('https://restapi.smscountry.com/v0.1/Accounts/zHz1Fj23TwN570ITYDgs/SMSes/', [
            'Text' => $message,
            'Number' => $phone,
            'SenderId' => 'FDRPJL',
            'DRNotifyUrl' => 'https://www.domainname.com/notifyurl',
            'DRNotifyHttpMethod' => 'POST',
            'Tool' => 'API',
        ]);
        
        

        if ($response->successful()) {
            print_r($response->json());die;
            $responseData = $response->json();
            // Process the response data
      
           
        } else {
            print_r($response->body());die;
            $errorMessage = $response->body();
            // Handle the error
          
            // echo json_encode('error');
        }
    }

}


