@extends('admin.layouts.master')
@section('title', $title)
@section('content')
@php

    $projectUrl = url('/');

@endphp
<!-- start page title -->
    <!-- Include page breadcrumb -->
    @include('admin.inc.breadcrumb')
    <!-- end page title -->
<!-- Start Content-->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p><strong>1. How to submit article?</strong></p>
                    <p><span>Create <strong>Account</strong> by using Author <strong>Name, email ID, Mobile No</strong>. Once Account created, author can enter directly Login Credential. After that, By Using New Submission, author can submit Article.</span></p>
                    <p><strong>Note:</strong> <span>Make sure are you entered correct email ID, Mobile No. because we will send Notification registered Email, Mobile No.</span></p>
                    <p><span>While Submitting Article, author can choose below Details:</span></p>
                    <ul>
                    <li><span>Research Area</span></li>
                    <li><span>Mode of Process</span></li>
                    <li><span>Type of article</span></li>
                    <li><span>Type of Issues</span></li>
                </ul>
                    @if ($journal == 1)
                        <img src="<?php echo $projectUrl; ?>/backend/images/faq/author_faq_ijire_1.png" class="staff-profile-image-small" alt="Default Profile Picture" style="max-width:80%; width:80%; margin: 0 auto;">
                    @elseif ($journal == 2)
                        <img src="<?php echo $projectUrl; ?>/backend/images/faq/author_faq_ijsreat_1.png" class="staff-profile-image-small" alt="Default Profile Picture" style="max-width:80%; width:80%; margin: 0 auto;">
                    @elseif ($journal == 3)
                        <img src="<?php echo $projectUrl; ?>/backend/images/faq/author_faq_ijrtmr_1.png" class="staff-profile-image-small" alt="Default Profile Picture" style="max-width:80%; width:80%; margin: 0 auto;">
                    @elseif ($journal == 4)
                        <img src="<?php echo $projectUrl; ?>/backend/images/faq/author_faq_indjeee_1.png" class="staff-profile-image-small" alt="Default Profile Picture" style="max-width:80%; width:80%; margin: 0 auto;">
                    @elseif ($journal == 5)
                        <img src="<?php echo $projectUrl; ?>/backend/images/faq/author_faq_indjece_1.png" class="staff-profile-image-small" alt="Default Profile Picture" style="max-width:80%; width:80%; margin: 0 auto;">
                    @elseif ($journal == 6)
                        <img src="<?php echo $projectUrl; ?>/backend/images/faq/author_faq_indjcst_1.png" class="staff-profile-image-small" alt="Default Profile Picture" style="max-width:80%; width:80%; margin: 0 auto;">
                    @endif

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p></strong><strong>2. Author can know task Process?</strong></p>
                    <p><span>Yes. Absolutely. </span></p>
                    <p><span>After submitted article. Your article under Editorial Check. It can be represented, in terms of Plagiarism Check, Peer-Review etc. Once your article accepted after Review process, Author can view the <strong>Task</strong> with Status.</span></p>
                    <img src="<?php echo $projectUrl; ?>/backend/images/faq/author_faq_2.png" class="staff-profile-image-small" alt="Default Profile Picture" style="max-width:80%; width:80%; margin: 0 auto;">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p><strong> </strong><strong>3. Author can know Review Process?</strong></p>
                    <p><span>Yes. Absolutely. </span></p>
                    <p><span>After plagiarism Check, Article will assign to reviewer with respective Research area. Once Editorinchief, received response from reviewers.&#160; Final Note will be Displayed, Like -<strong>Accept/Accept with minor correction/ Reject </strong>notification will send to author.</span></p>
                    <img src="<?php echo $projectUrl; ?>/backend/images/faq/author_faq_3.png" class="staff-profile-image-small" alt="Default Profile Picture" style="max-width:80%; width:80%; margin: 0 auto;">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p><strong> </strong><strong>4. How Author can Know submitted Article Accepted or Not? </strong></p>
                    <p><span>Once Reviewer&#8217;s Command Satisfactory, Editorinchief will release Acceptance letter along with Tentative Article Publication Scheduled Date through Editorial Office. Author can view in <strong>Acceptance </strong>Tap.&#160; </span></p>
                    <img src="<?php echo $projectUrl; ?>/backend/images/faq/author_faq_4.png" class="staff-profile-image-small" alt="Default Profile Picture" style="max-width:80%; width:80%; margin: 0 auto;">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p><strong> </strong><strong>5. What is the Procedure for Accepted Article to be publish?</strong></p>
                    <p><span>Once you&#8217;re Article Accepted for Publication, Author have to follow 3 steps.</span></p>
                    <ol>
                    <li><strong><span>Copyright form</span></strong><span> (before generating copyright form-Author have to update profile. Like, Address, Date of Birth etc. then only copyright form will generate. Take print out manually corresponding author have to signature)</span></li>
                    <li><strong><span>Final Manuscript</span></strong><span> (As per our journal format)</span></li>
                    <li><strong><span>Article Processing fee receipt</span></strong><span> (with DOI, With out DOI) </span></li>
                    </ol>
                    <p><span>Above three document should be submit in <strong>Final submission</strong> tab. Once we received all necessary Documents. We will process your article. Article will publish with in <strong>24hrs to 48hrs</strong>.</span></p>
                    <ol>
                    <li style="list-style:none;"><img src="<?php echo $projectUrl; ?>/backend/images/faq/author_faq_5_1.png" class="staff-profile-image-small" alt="Default Profile Picture" style="max-width:80%; width:80%; margin: 0 auto;"></li>
                    <li style="list-style:none;"><img src="<?php echo $projectUrl; ?>/backend/images/faq/author_faq_5_2.png" class="staff-profile-image-small" alt="Default Profile Picture" style="max-width:80%; width:80%; margin: 0 auto;"></li>
                    <li style="list-style:none;"><img src="<?php echo $projectUrl; ?>/backend/images/faq/author_faq_5_3.png" class="staff-profile-image-small" alt="Default Profile Picture" style="max-width:80%; width:80%; margin: 0 auto;"></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p><strong> </strong><strong>6.Author will get certificates including corresponding authors? </strong></p>
                    <p><span>Yes. All author will get certificates. Author can download<strong> file</strong> folder. Also Published Article Copy and Journal Archive link also.</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
