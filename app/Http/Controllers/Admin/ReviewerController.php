<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use Carbon\Carbon;
use App\User;
use Session;
use Image;
use File;
use Auth;
use Hash;
use DB;

class ReviewerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Page Data
        $this->title = 'Reviewer';
        $this->url = 'reviewer';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     //
    //     $rows = User::where('user_type', 'R')->orderBy('id', 'desc')->get();

    //     $title = $this->title;
    //     $url = $this->url;

    //     return view('admin.'.$url.'.index', compact('rows', 'title', 'url'));
    // }


    public function index()
    {

        $rows = User::where('user_type', 'R')->orderBy('id', 'desc')->get();

        // $rows = DB::select('select u.*,r.* from users as u join review as r on r.reviewer_id=u.id where u.user_type="R"');

        foreach($rows as $row){
            
            $review = DB::select('select article_id from review where reviewer_id='.$row['id']);
            
            $reviewerid = $row['id'];
           
            foreach($review as $rev){
                
                $review = DB::select('select id,journal_short_form from articles where id='.$rev->article_id);

                $assignedArticle[$reviewerid][$rev->article_id] = $review;
              
            }
        }

        $title = $this->title;
        $url = $this->url;

        return view('admin.'.$url.'.index', compact('rows', 'title', 'url','assignedArticle'));
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
    // public function store(Request $request)
    // {
    //     // Field Validation
    //     $request->validate([
    //         'name' => 'required|max:250',
    //         'email' => 'required|max:250',
    //         'password' => 'required|min:8',
    //         'phone' => 'nullable|max:50',
    //         'address' => 'required',
    //         'image' => 'nullable|image',
    //         'reviewerid' => 'required|max:250|unique:users',
    //     ]);


    //     // image upload, fit and store inside public folder
    //     if($request->hasFile('image')){
    //         //Upload New Image
    //         $filenameWithExt = $request->file('image')->getClientOriginalName();
    //         $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
    //         $extension = $request->file('image')->getClientOriginalExtension();
    //         $fileNameToStore = $filename.'_'.time().'.'.$extension;

    //         //Crete Folder Location
    //         $path = public_path('uploads/profile/');
    //         if (! File::exists($path)) {
    //             File::makeDirectory($path, 0777, true, true);
    //         }


    //         // ->fit(200, 150)
    //         // ->save(public_path('uploads/profile/' . $fileNameToStore));

    //         // Move image inside public/profile/ folder
    //         $img = $request->file('image')->move($path, $fileNameToStore);

    //         //Resize And Crop as Fit image here (200 width, 150 height)
    //         // $thumbnailpath = $path.$fileNameToStore;
    //         // $img = Image::make($request->file('image')->getRealPath())->fit(200, 150, function ($constraint) { $constraint->upsize(); })->save($thumbnailpath);

    //     }
    //     else{
    //         $fileNameToStore = 'noimage.jpg'; // if no image selected this will be the default image
    //     }

    //     $password = $request->password;
    //     // Insert Data
    //     $data = new User;
    //     $data->name = $request->name;
    //     $data->email = $request->email;
    //     $data->password = Hash::make($request->password);
    //     $data->department = $request->department;
    //     $data->phone = $request->phone;
    //     $data->address = $request->address;
    //     $data->dob = $request->dob;
    //     $data->image_path = $fileNameToStore;
    //     $data->reviewerid = $request->reviewerid;
    //     $data->profile = $request->details;
    //     $data->user_type = 'R';
    //     $data->status = 1;
    //     $data->save();

    //     $createdId = $data->id;
        
    //     $result = DB::table('users as u')
    //     ->where('u.id',$createdId)
    //     ->select('u.email','u.name')
    //     ->get();
    //     // $result[0]['password'] = $password;
    //     $email = $result[0]->email;
    //     $name = $result[0]->name;
    //     // $subject = 'Welcome email';
    //     // $body = view('admin.submission.emailbody.reviewer_welcome')->with('name',$result)->render();
    
    //     // $this->email($body,$subject,$email,$name);
    //     Session::flash('success', $this->title.' Created Successfully!');

    //     return redirect()->back();
    // }


    public function store(Request $request)
    {
        // Field Validation
        $request->validate([
            'name' => 'required|max:250',
            'email' => 'required|max:250',
            'password' => 'required|min:8',
            'phone' => 'nullable|max:50',
            
            'reviewerid' => 'required|max:250|unique:users',
        ]);


        // image upload, fit and store inside public folder
        // if($request->hasFile('image')){
        //     //Upload New Image
        //     $filenameWithExt = $request->file('image')->getClientOriginalName();
        //     $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //     $extension = $request->file('image')->getClientOriginalExtension();
        //     $fileNameToStore = $filename.'_'.time().'.'.$extension;

        //     //Crete Folder Location
        //     $path = public_path('uploads/profile/');
        //     if (! File::exists($path)) {
        //         File::makeDirectory($path, 0777, true, true);
        //     }


        //     // ->fit(200, 150)
        //     // ->save(public_path('uploads/profile/' . $fileNameToStore));

        //     // Move image inside public/profile/ folder
        //     $img = $request->file('image')->move($path, $fileNameToStore);

        //     //Resize And Crop as Fit image here (200 width, 150 height)
        //     // $thumbnailpath = $path.$fileNameToStore;
        //     // $img = Image::make($request->file('image')->getRealPath())->fit(200, 150, function ($constraint) { $constraint->upsize(); })->save($thumbnailpath);

        // }
        // else{
        //     $fileNameToStore = 'noimage.jpg'; // if no image selected this will be the default image
        // }

        $password = $request->password;
        // Insert Data
        $data = new User;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->department = $request->department;
        $data->phone = $request->phone;
        // $data->address = $request->address;
        // $data->dob = $request->dob;
        // $data->image_path = $fileNameToStore;
        $data->reviewerid = $request->reviewerid;
        // $data->profile = $request->details;
        $data->user_type = 'R';
        $data->status = 1;
        $data->save();

        $createdId = $data->id;
        
        $result = DB::table('users as u')
        ->where('u.id',$createdId)
        ->select('u.email','u.name')
        ->get();
        // $result[0]['password'] = $password;
        $email = $result[0]->email;
        $name = $result[0]->name;
        // $subject = 'Welcome email';
        // $body = view('admin.submission.emailbody.reviewer_welcome')->with('name',$result)->render();
    
        // $this->email($body,$subject,$email,$name);
        Session::flash('success', $this->title.' Created Successfully!');

        return redirect()->back();
    }
    public function update(Request $request,$id)
    {
        $updateQuery = DB::table('users')
        ->where('id', $request->id)
        ->update([
            'name' => $request->name,
            'email' => $request->email,
            'department' => $request->department,
            'phone' => $request->phone,
            // 'dob' => $request->dob,
            'reviewerid' =>$request->reviewerid,
        ]);

        if ($updateQuery) {
            Session::flash('success', $this->title.' Update Successfully!');
        }else{
            Session::flash('danger',' Something wrong try again!');
        }

        return redirect()->back();

    }

    public function email($body, $subject, $email,$recipient_name)
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
        $mail->setFrom('noreply@fdrpjournals.org', 'Support_');
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
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Delete Data
        $data = User::find($id);
        $data->delete();

        Session::flash('success', $this->title.' Deleted Successfully!');

        return redirect()->back();
    }
}
