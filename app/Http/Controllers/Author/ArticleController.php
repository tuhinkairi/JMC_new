<?php

namespace App\Http\Controllers\Author;
// use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Http\Request;
use App\ArticleCategory;
use Carbon\Carbon;
use App\Article;
use Session;
use App\User;
use Image;
use File;
use Auth;
use DB;


class ArticleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Page Data
        $this->title = 'Article';
        $this->url = 'article';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $user_id = Auth::user()->id;
        //
        $rows = DB::table('articles as a')
                            ->join('article_categories as b', 'a.category_id', '=', 'b.id')
                            ->join('master_status as e', 'a.status_type', '=', 'e.id')
                            ->where('a.writer_id', $user_id)
                            ->select('a.*', 'e.name as statusname', 'b.title as category', 'e.colour as colourflag',)
                            ->orderBy('id', 'asc')
                            ->get();

        $categories = ArticleCategory::where('status', '1')->get();

        $title = $this->title;
        $url = $this->url;

        return view('author.'.$url.'.index', compact('rows', 'categories', 'title', 'url'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addarticle()
    {

        $title = $this->title;
        $url = $this->url;


        $user_id = Auth::user()->id;

        $categories = ArticleCategory::where('status', '1')->get();
        $journals = DB::select('select * from master_journal ORDER BY id ASC');
        $journal_id = DB::select('select journal_id from users where id='. $user_id);
  
        $journal_id = $journal_id[0]->journal_id;

        // $journal = DB::select('select * from master_journal where id='. $journal_id[0]->journal_id);

        $articles = DB::select('select * from master_article');
        $journals = DB::select('select * from master_journal ORDER BY id ASC');
        $issues = DB::select('select * from master_issue');
        $processings = DB::select('select * from master_processing');
        $statuss = DB::select('select * from master_status');

        return view('author.article.create', compact('journal_id','journals', 'categories', 'title', 'url', 'articles', 'journals', 'issues', 'processings', 'statuss'));
    }

    public function copyright_acceptance()
    {
        $title = "Copyright Acceptances";
        $user_id = Auth::user()->id;

        $acceptances = DB::table('acceptance as a')
                            ->join('articles as b', 'a.article_id', '=', 'b.id')
                            ->where('b.writer_id', $user_id)
                            ->select('a.*', 'b.title as articletitle', 'b.journal_short_form')
                            ->get();



        return view('author.copyright_accpetance.index', compact('acceptances', 'title'));
    }
    public function downloads()
    {
        $title = "Downloads";

        $user_id = Auth::user()->id;

        $files = DB::table('file as a')
                            ->join('articles as b', 'a.article_id', '=', 'b.id')
                            ->where('b.writer_id', $user_id)
                            ->select('a.*', 'b.journal_short_form')
                            ->get();

        $final_copy_right_forms = DB::table('final_submission as a')
                            ->join('articles as b', 'a.article_id', '=', 'b.id')
                            ->where('b.writer_id', $user_id)
                            ->where('category', 2)
                            ->select('a.*', 'b.journal_short_form')
                            ->get();

        $manuscripts = DB::table('articles as a')
                            ->where('a.writer_id', $user_id)
                            ->select('a.*')
                            ->get();



        return view('author.downloads.index', compact('title', 'manuscripts', 'final_copy_right_forms', 'files'));
    }


    public function faq()
    {
        $title = "FAQs";
        $journal = Auth::user()->journal_id;
        return view('author.faq.index', compact('journal', 'title'));
    }


    public function knowledgebase()
    {
        $title = "Knowledge Base";
        $journal = Auth::user()->journal_id;
        return view('author.knowledgebase.index', compact('journal', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
            $path = public_path('uploads/'.$this->url.'/');
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
            $path = public_path('uploads/'.$this->url.'/');
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

        $jurnalId = $request->journal_type;
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
        $data->journal_type = $request->journal_type;
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

            $super_admin_details = DB::table('users as a')
                                ->where('a.user_type', "A")
                                ->select('a.*')
                                ->get();

            $result = DB::table('articles as a')
                            ->join('master_journal as b', 'b.id', '=', 'a.journal_type')
                            ->join('master_status as c', 'c.id', '=', 'a.status_type')
                            ->join('users as d', 'd.id', '=', 'a.writer_id')
                            ->where('a.id', $id)
                            ->select('a.*', 'b.name as journalname', 'b.short_form', 'c.name as statusname', 'd.name as authorname', 'd.email as senderemail', 'd.phone')
                            ->get();

            $email = $result[0]->senderemail;
            $journal = $result[0]->short_form;
            $subject = "Paper Successfully Received - Online Submission: Paper ID- '".$result[0]->journal_short_form.'-0000'.$result[0]->id."'";

            $body = view('admin.submission.emailbody.submission')->with('name', $result)->render();

            // Author Notification
            $this->email($body,$subject,$email,$journal);
            // SMS ALert
            $status = 0;
            $name = $result[0]->authorname;
            $authorid = $result[0]->short_form."-0000".$result[0]->id;
            $phone = $result[0]->phone;
            // die;
            // print_r($journal);
            // print_r($status);
            // print_r($name);
            // print_r($authorid);
            // print_r($phone);die;

            $this->sms($journal, $status, $name, $authorid, $phone);



            // For Super Admin Notification
            $journal = $result[0]->short_form." ID - ".$result[0]->short_form."-0000".$result[0]->id;
            $email = $super_admin_details[0]->email;
            $subject = "New Submission ".$result[0]->short_form;
            $body = 'Name: '.$result[0]->authorname.'<br><br>

                        Title: '. $result[0]->title.'<br>
                        Submited on: '.$result[0]->created_at;

            $this->email($body,$subject,$email,$journal);

        }
        $request->session()->regenerateToken();
        Session::flash('success', $this->title.' Created Successfully!');

        return redirect('/dashboard/author/article/show/'.$id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $profile_id = Auth::user()->id;
        
        $profile_rows = User::where('id', $profile_id)->first();

        $profile_title = 'Profile';
        $profile_url = 'profile';
        //
        // $rows = DB::select('select * from articles where id='. $id);
        $rows = DB::table('articles as a')
                            ->join('master_article as b', 'a.article_type', '=', 'b.id')
                            ->join('master_issue as c', 'a.issue_type', '=', 'c.id')
                            ->join('master_processing as d', 'a.processing_type', '=', 'd.id')
                            ->join('master_status as e', 'a.status_type', '=', 'e.id')
                            ->join('master_journal as f', 'a.journal_type', '=', 'f.id')
                            // ->join('acceptance as g', 'a.id', '=', 'g.article_id')
                            ->where('a.id', $id)
                            ->select('a.*',  'b.name as articlename', 'c.name as issuename','d.name as processingname','e.name as statusname', 'e.colour as colourflag', 'f.name as journalname')
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
        $tasks = DB::select('select * from task where article_id='. $id);

        $reviews = DB::table('review as a')
                            ->join('articles as b', 'a.article_id', '=', 'b.id')
                            ->join('users as c', 'a.reviewer_id', '=', 'c.id')
                            ->where('a.article_id', $id)
                            ->select('a.*', 'c.id as user_id','c.reviewerid as reviewerid')
                            ->get();
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

        $acceptances = DB::table('acceptance as a')
                            ->join('articles as b', 'a.article_id', '=', 'b.id')
                            ->where('a.article_id', $id)
                            ->where('a.status','Accepted')
                            ->select('a.*', 'b.title as articletitle')
                            ->get();

        $copy_rigth_files = DB::table('copy_rigth_files as a')
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

        $selected = DB::table('articles as a')
                            ->join('master_article as b', 'a.article_type', '=', 'b.id')
                            ->join('master_issue as c', 'a.issue_type', '=', 'c.id')
                            ->join('master_processing as d', 'a.processing_type', '=', 'd.id')
                            ->join('master_status as e', 'a.status_type', '=', 'e.id')
                            ->join('master_journal as f', 'a.journal_type', '=', 'f.id')
                            ->where('a.id', $id)
                            ->select('a.*', 'b.name as articlename', 'c.name as issuename','d.name as processingname','e.name as statusname', 'e.colour as colourflag', 'f.name as journalname')
                            ->get();
        // print_r($copy_rigth_files);
        // die;

        $title = $this->title;

        return view('author.article.view', compact('gst','payment_data','profile_url','profile_title','profile_rows','rows', 'title', 'final_payment_scripts', 'final_manuscripts', 'final_copy_right_forms', 'tasks', 'reviews', 'files_0', 'files_1', 'files_2', 'files_3', 'id','acceptances','copy_rigth_files','selected'));
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

    public function author_file_upload(Request $request, $id)
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



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function indivitual_article_show($id)
    {
        $title = 'Show Article';
        $url = $this->url;

        $rows = DB::table('articles as a')
                            // ->join('master_article as b', 'a.article_type', '=', 'b.id')
                            // ->join('master_issue as c', 'a.issue_type', '=', 'c.id')
                            ->join('master_status as d', 'a.status_type', '=', 'd.id')
                            ->join('users as b', 'a.writer_id', '=', 'b.id')
                            ->join('article_categories as c', 'a.category_id', '=', 'c.id')
                            ->where('a.id', $id)
                            ->select('a.*', 'c.title as categoryname', 'b.name', 'd.name as statustype')
                            ->get();

        return view('author.article.show', compact('title', 'url', 'rows'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        // Field Validation
        $request->validate([
            'title' => 'required|max:250',
        
            'details' => 'required',
            
            'file' => 'nullable|file|mimes:jpg,jpeg,png,ppt,pptx,doc,docx,pdf,xls,xlsx|max:51200',
          
        ]);


        $data = Article::find($id);
        if( $data->writer_id == Auth::user()->id ){

            // file upload, fit and store inside public folder
            if($request->hasFile('file')){

                //Delete Old Image
                $old_file = Article::find($id);

                $file_path = public_path('uploads/'.$this->url.'/'.$old_file->file_path);
                if(File::isFile($file_path)){
                    File::delete($file_path);
                }

                //Upload New Image
                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $fileNameToStore = str_replace([' ','-','&','#','$','%','^',';',':'],'_',$filename).'_'.time().'.'.$extension;

                //Crete Folder Location
                $path = public_path('uploads/'.$this->url.'/');
                if (! File::exists($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }

                // Move File inside public/uploads/ folder
                $file = $request->file('file')->move($path, $fileNameToStore);
            }
            else{

                $old_file = Article::find($id);

                $fileNameToStore = $old_file->file_path;
            }



            // image upload, fit and store inside public folder
            // if($request->hasFile('image')){

            //     //Delete Old Image
            //     $old_file = Article::find($id);

            //     $file_path = public_path('uploads/'.$this->url.'/'.$old_file->image_path);
            //     if(File::isFile($file_path)){
            //         File::delete($file_path);
            //     }

            //     //Upload New Image
            //     $filenameWithExt = $request->file('image')->getClientOriginalName();
            //     $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //     $extension = $request->file('image')->getClientOriginalExtension();
            //     $imageNameToStore = $filename.'_'.time().'.'.$extension;

            //     //Crete Folder Location
            //     $path = public_path('uploads/'.$this->url.'/');
            //     if (! File::exists($path)) {
            //         File::makeDirectory($path, 0777, true, true);
            //     }

            //     //Resize And Crop as Fit image here (640 width, 400 height)
            //     $thumbnailpath = $path.$imageNameToStore;
            //     $img = Image::make($request->file('image')->getRealPath())->fit(640, 400, function ($constraint) { $constraint->upsize(); })->save($thumbnailpath);
            // }
            // else{

            //     $old_file = Article::find($id);

            //     $imageNameToStore = $old_file->image_path;
            // }


            // Update Data
            $data = Article::find($id);
            $data->title = $request->title;
           
            $data->description = $request->details;
        
            $data->file_path = $fileNameToStore;
           
            $data->upload_status = 2;
            $data->updated_by = Auth::user()->id;
            $data->save();


            Session::flash('success', $this->title.' Updated Successfully!');

        }
        else{
            Session::flash('error', 'You are not permitted update this!');
        }

        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Delete Data
        $data = Article::find($id);

        if( $data->writer_id == Auth::user()->id ){

            $file_path = public_path('uploads/'.$this->url.'/'.$data->file_path);
            if(File::isFile($file_path)){
                File::delete($file_path);
            }

            $image_path = public_path('uploads/'.$this->url.'/'.$data->image_path);
            if(File::isFile($image_path)){
                File::delete($image_path);
            }

            $data->delete();

            Session::flash('success', $this->title.' Deleted Successfully!');

        }
        else{
            Session::flash('error', 'You are not permitted delete this!');
        }

        return redirect()->back();
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

    public function email($body, $subject, $email, $journal)
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
        $mail->addAddress($email, 'Recipient Name');
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

    public function sms($journal, $status, $name, $id, $phone)
    {
      
        if($journal == 'IJIRE' || $journal == 'IJRTMR' || $journal == 'IJSREAT')
        {
            if($status == 0){
                $message = "Hi ".$name.", your paper id: ".$id." is submitted successfully. Thank you for your interest in our journal.\n\nTrack: use your login Credential to check your article status.\n\n-Editorial Office/".$journal." International Journal\n\n5th Dimension Research Publication";
            }
        }else{
            if($status == 0){
                $message = "Hi ".$name.", your paper id: ".$id." is submitted successfully. Thank you for your interest in our journal.\n\nTrack: use your login Credential to check your article status.\n\n-Editorial Office/".$journal." Journal\n\n5th Dimension Research Publication";
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
        // $decoded = base64_decode('aHhoM0t0NUZFeExxbUNBVkh0cU86emRPMnJzaUpwWGJFT0FHZWdZNGx6ZXdTa1FCOFo0NnBaVUl6WVVyZg==');
        // echo $decoded; // should print "username:password"


        
        if ($response->successful()) {
            $responseData = $response->json();
            // Process the response data
           
        } else {
            $errorMessage = $response->body();
            // Handle the error
            // echo $errorMessage;
            // echo json_encode('error');die;
        }
    }


    public function show_review_question($id)
    {
        $title = "Review Evalution";
        $url = $this->url;

        $answers = DB::select('select * from review_evalution where review_id = '.$id);

        if ($answers[0]->comment_14 == "No" || empty($answers[0]->comment_14)) {
            // Either field1 or field2 is empty, display alert
            // echo '<script>alert("Please Update Your Profile");</script>';
            return redirect()->back()->with('alert_for_review_form', 'Review Form is Under Processing');
        }

        $rows = DB::table('review_evalution as a')
                            ->join('review as b', 'a.review_id', '=', 'b.id')
                            ->where('a.review_id', $id)
                            ->select('a.*')
                            ->get();



        return view('author.article.review_evalution', compact('title', 'rows'));
    }

    public function file_destroy($id)
    {
        die;
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
}
