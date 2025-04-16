<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use App\ArticleCategory;
use Carbon\Carbon;
use App\Article;
use Session;
use Image;
use File;
use Auth;
use DB;

class ReviewController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Page Data
        $this->title = 'Review';
        $this->url = 'review';

    }

    public function index()
    {
        $title = $this->title;
        $url = $this->url;

        $user_type = Auth::user()->user_type;
        $user_id = Auth::user()->id;

        $reviews = DB::table('review as a')
                            ->join('articles as b', 'a.article_id', '=', 'b.id')
                            ->join('users as c', 'a.reviewer_id', '=', 'c.id')
                            ->where('a.reviewer_id', $user_id)
                            ->select('a.*', 'c.name as reviername', 'b.title as articlename')
                            ->get();

        return view('reviewer.task.view', compact('reviews', 'title', 'url'));
    }

    public function show($id)
    {
        $url = $this->url;
        $title = $this->title;

        $reviews = DB::table('review as a')
                            ->where('a.id', $id)
                            ->select('a.*')
                            ->get();
                        
        $article_id = $reviews[0]->article_id;

        $rows = DB::table('articles as a')
                            // ->join('master_article as b', 'a.article_type', '=', 'b.id')
                            // ->join('master_issue as c', 'a.issue_type', '=', 'c.id')
                            ->join('master_status as e', 'a.status_type', '=', 'e.id')
                            ->join('users as b', 'a.writer_id', '=', 'b.id')
                            ->join('article_categories as c', 'a.category_id', '=', 'c.id')
                            ->where('a.id', $article_id)
                            ->select('a.*', 'c.title as categoryname', 'b.name', 'e.name as statustype',)
                            ->get();

        $answers = DB::select('select * from review_evalution where article_id = '.$article_id);

        return view('reviewer.task.show', compact('rows', 'title', 'url', 'answers', 'id'));
    
    }

    public function review_question(Request $request, $id)
    {
        $article = DB::select('select review.article_id,review.reviewer_id,articles.journal_short_form from review join articles on articles.id=review.article_id where review.id = '.$id);

        $email_for_rev_admin = DB::select('select email,reviewerid,name from users where user_type = "A" or id='.$article[0]->reviewer_id);

        $admin_email = $email_for_rev_admin[0]->email;

        $recipient_name = $email_for_rev_admin[0]->name;

        $reviewer_id = $email_for_rev_admin[1]->reviewerid;
        $journalname = $article[0]->journal_short_form . '-0000'. $article[0]->article_id;
              $data = array(
            'article_id' => $article[0]->article_id,
            'review_id' => $id,
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
            'comment_11' => $request->comment_11
        );
        $inser_data = DB::table('review_evalution')->insert($data);


   

        $subject = "Reviewer Form";
        
        $emailData = [
            'journal' => $journalname,
            'reviewer' => $reviewer_id
        ];

        $body = view('admin.submission.emailbody.send_mail_to_admin')->with('name', $emailData)->render();
    
     
        $data = $this->email($body,$subject,$admin_email,$recipient_name);

        Session::flash('success', 'Review Evalution Submitted Successfully!');
        return redirect()->back();

    }


    public function email($body, $subject, $email, $recipient_name)
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
        $mail->setFrom('noreply@fdrpjournals.org', 'Support');
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

}
