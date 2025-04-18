@php
    $date = substr($name[0]->date, 0, 10);

    $projectUrl = url('/');

@endphp
<ul style="padding:0; margin:0;">
    <li  style="text-align: right; list-style:none; margin:0;"><img src="<?php echo $projectUrl; ?>/uploads/acceptance_letter/top.jpg" class="staff-profile-image-small" alt="Default Profile Picture" style="margin: 0 auto;"></li>

    <li style="list-style:none;">
        <p><span style="font-family:'times new roman', times, serif;font-size:12pt;">Date:</span> {{$date}}</p>
        <p><span style="font-family:'times new roman', times, serif;font-size:12pt;">Address: {{$name[0]->authoraddress}}</span></p>
        <p><span style="font-family:'times new roman', times, serif;font-size:12pt;">&#160;</span></p>
        <p style="text-align:center;"><span style="color:#3366ff;font-family:'times new roman', times, serif;font-size:12pt;"><strong><u>ARTICLE ACCEPTANCE LETTER</u></strong></span></p>
        <p></p>
        <p><span style="font-family:'times new roman', times, serif;font-size:12pt;"><strong>Title of the journal: </strong>{{$name[0]->journalname}}</span></p>
        <p><span style="font-family:'times new roman', times, serif;font-size:12pt;"><strong>Article</strong> <strong>Title</strong><strong>:</strong> {{$name[0]->title}}</span></p>
        <p><span style="font-family:'times new roman', times, serif;font-size:12pt;"><strong>Article Reference Number: &#160;</strong> {{$name[0]->journal_short_form}}-0000{{$name[0]->id}}</span></p>
        <p><span style="font-family:'times new roman', times, serif;font-size:12pt;"><strong>Corresponding Authors: </strong> {{$name[0]->authorname}}</span></p>
        <p><span style="font-family:'times new roman', times, serif;font-size:12pt;"><strong>Article</strong> <strong>Type</strong><strong>:</strong> {{$name[0]->articletype}}</span></p>
        <p><span style="font-family:'times new roman', times, serif;font-size:12pt;"><strong>Scheduled on:</strong> {{$name[0]->scheduled_to}}</span></p>
        <p><span style="font-family:'times new roman', times, serif;font-size:12pt;">Dear Author/Research Scholar. Greetings of the day</span></p>
        <p><span style="font-family:'times new roman', times, serif;font-size:12pt;">Thank you very much for your submission to our journal. We are pleased to inform you that your paper has been reviewed, and accepted for publication in Current Issues. Please submit your final manuscript, copyright form. In case you have not submitted copyright form; please send scanned copy shortly through e-mail.</span></p>
        <p><span style="font-family:'times new roman', times, serif;font-size:12pt;">Thank you for interest in our International Journals<br><br></span></p>
        <p><span style="font-family:'times new roman', times, serif;font-size:12pt;">Best wishes,</span></p>
        <p><span style="font-family:'times new roman', times, serif;font-size:12pt;">Editor-in-Chief</span></p>
        <img src="<?php echo $projectUrl; ?>/uploads/acceptance_letter/signature.jpg" class="" alt="Signature" style="width: 120px;">
        <p><span style="font-family:'times new roman', times, serif;font-size:12pt;"></span></p>
        <p><span style="font-family:'times new roman', times, serif;font-size:12pt;">(<span style="color:#3366ff;">{{$name[0]->journalname}}</span>)</span></p>
        <li style="text-align: center; list-style:none;"><img src="<?php echo $projectUrl; ?>/uploads/acceptance_letter/seal.jpg"  alt="Seal" style="width: 120px;"></li>
        <p><span style="font-family:'times new roman', times, serif;font-size:12pt;"></span></p>
        {{-- <p><span style="font-family:'times new roman', times, serif;font-size:12pt;">System generated letter, hence no signature required.</span></p> --}}
    </li>

    <li style="text-align: center; list-style:none;"><img src="<?php echo $projectUrl; ?>/uploads/acceptance_letter/acceptance_bottom_pic.jpg" class="staff-profile-image-small" alt="Default Profile Picture" style="max-width:100%; width:100%; margin: 0 auto;"></li>

</ul>
