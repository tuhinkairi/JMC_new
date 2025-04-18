<?php

namespace App\Http\Controllers\Admin;

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

class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Page Data
        $this->title = 'Payment Rate';
        $this->url = 'payment';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $rows = DB::select('select p.*,j.short_form from master_payment as p join master_journal as j on j.id=p.journal_type');

        $journal_type = DB::select('select id,short_form from master_journal where short_form not in ("INDJEEE","INDJECE")');

        $title = $this->title;
        $url = $this->url;

        return view('admin.'.$url.'.index', compact('rows', 'title', 'url','journal_type'));
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

    
        $insertQuery = DB::table('master_payment')->insert([
            'author_type' => $request->author_type,
            'journal_type' => $request->journal,
            'with_doi' => $request->withdoi,
            'without_doi' => $request->withoutdoi,
            'gst' => $request->gst,
            'created_at' => date('Y-m-d H:i:s'),
            'update_at' => date('Y-m-d H:i:s'),
        ]);

        if ($insertQuery) {
            Session::flash('success', $this->title.' Created Successfully!');
        }else{
            Session::flash('danger',' Something wrong try again!');
        }


        return redirect()->back();
    }

    public function email($body, $subject, $email, $journal = '',$recipient_name)
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
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rows = DB::select('select * from master_payment');

        

    
        $title = $this->title;
        $url = $this->url;

        return view('admin.'.$url.'.index', compact('rows', 'title', 'url'));
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
    public function update(Request $request,$id)
    {
        $updateQuery = DB::table('master_payment')
        ->where('id', $request->id)
        ->update([
            'author_type' => $request->author_type,
            'journal_type' => $request->journal,
            'with_doi' => $request->withdoi,
            'without_doi' => $request->withoutdoi,
            'gst' => $request->gst,
            'update_at' => date('Y-m-d H:i:s'),
        ]);

        if ($updateQuery) {
            Session::flash('success', $this->title.' Update Successfully!');
        }else{
            Session::flash('danger',' Something wrong try again!');
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
        $deleted = DB::table('master_payment')->where('id', $id)->delete();

        if ($deleted) {
            Session::flash('success', $this->title.' Deleted Successfully!');
        }else{
            Session::flash('danger',' Something wrong try again!');
        }

        return redirect()->back();
    }
}
