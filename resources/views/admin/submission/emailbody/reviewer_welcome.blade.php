<!-- 
    review_name = {{ $name[0]->name}}
 -->

 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Review for [Journal Name]</title>
</head>
<body style="font-family:Time Arial, sans-serif;">
    <font size="4">
    <h2><center><strong><span style="color:red;">Review request email:</span></strong></center></h2>
    <p>Subject:Invitation to Review for [Journal Name]</p>
    <p>Dear <span style="color:red;">{{ $name[0]->name}},</span></p>
    <p>I hope this email finds you well. I'm writing because I thought you would be interested in serving as a peer reviewer for a new manuscript <span style="color:red;">{journal name}</span>received entitled "{<span style="color:red;">paper ID & manuscript name</span>}" that falls within your realm of expertise. Manuscript Attached for your reference.</p>
    <p>Would you be willing to submit a peer review for this manuscript? I would need to receive your review comments by [within 1-2 weeks]</p>
    <p>If you're willing to review this submission, I'll need you to:[Login to Reviewer Credential]</p>
    <p><span style="color:blue;"><strong>Reviewer Login Details:</span></strong><br>
        <span style="color:blue;">User Name: </span><span style="color:blue;">{{ $name[0]->email}}</span><br>
     

    <p>For more information on<span style="color:red;"> {journal name}</span>'s peer review policies and reviewer guidelines, you can refer to Journal web page.</p>
    <p>If you're unable to take on this review assignment but know of other scholars who may be interested and have the necessary expertise, we would greatly appreciate you sharing suggestions for alternate peer reviewers.</p>
    <p>We appreciate you considering this review assignment and look forward to hearing from you. If you have any questions, please don't hesitate to contact me.</p>
    <p>Sincerely,</p>
    <p><strong>Dr. S. Sivaganesan</strong><br>
    Editor-in-chief<br>
    <span style="color:red;">[journal name]</span>
</p><font>
</body>
</html>
