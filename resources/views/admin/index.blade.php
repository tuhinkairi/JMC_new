@extends('admin.layouts.master')
@section('title', $title)
@section('content')


<style>
td, th {
  text-align: center;
}
.small-td {
    width: 10px; /* Adjust the width value as per your requirement */
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  /* Custom CSS to hide specific table column */
  .hide-column {
            display: none;
        }

/* btn animation */
#newSubmission{
  animation: blinker 1s linear infinite;
}

@keyframes blinker {
  50% {
    opacity: .25;
  }
}
</style>
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <!-- Include page breadcrumb -->
    @include('admin.inc.breadcrumb')
    <!-- end page title -->

    @cannot('isReviewer')

    @cannot('isStaff')

    <div class="row d-none d-lg-flex">
        <div class="col-xl-3 col-lg-6">
            <div class="card widget-flat bg-blue text-white rounded card-border shadow-sm">
                <div class="card-body p-0">
                    <div class="p-3 pb-0">
                        <div class="float-right">
                            <span class="icon widget-icon"><i class="fas fa-newspaper"></i></span>
                        </div>
                        <h5 class="font-weight-normal mt-0">Submitted Articles</h5>
                        <h3 class="mt-2">{{ $approve->count() }}</h3>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-xl-3 col-lg-6">
            <div class="card widget-flat bg-red text-white rounded card-border shadow-sm">
                <div class="card-body p-0">
                    <div class="p-3 pb-0">
                        <div class="float-right">
                            <span class="icon widget-icon"><i class="fas fa-edit"></i></span>
                        </div>
                        <h5 class="font-weight-normal mt-0">Pending Articles</h5>
                        <h3 class="mt-2">{{ $pending->count() }}</h3>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-xl-3 col-lg-6">
            <div class="card widget-flat bg-yellow text-white rounded card-border shadow-sm">
                <div class="card-body p-0">
                    <div class="p-3 pb-0">
                        <div class="float-right">
                            <span class="icon widget-icon"><i class="fas fa-thumbs-up"></i></span>
                        </div>
                        <h5 class="font-weight-normal mt-0">Accepted Articles</h5>
                        <h3 class="mt-2">{{ $accepted->count() }}</h3>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

        @can('isAdmin')

        <div class="col-xl-3 col-lg-6">
            <div class="card widget-flat bg-green text-white rounded card-border shadow-sm">
                <div class="card-body p-0">
                    <div class="p-3 pb-0">
                        <div class="float-right">
                            <span class="icon widget-icon"><i class="fas fa-check-circle"></i></span>
                        </div>
                        <h5 class="font-weight-normal mt-0">Published Articles</h5>
                        <h3 class="mt-2">{{ $published->count() }}</h3>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
        @endcan

        @can('isReviewer')
        <div class="col-xl-3 col-lg-6">
            <div class="card widget-flat bg-red text-white rounded card-border shadow-sm">
                <div class="card-body p-0">
                    <div class="p-3 pb-0">
                        <div class="float-right">
                            <span class="icon widget-icon"><i class="fas fa-user-tie"></i></span>
                        </div>
                        <h5 class="font-weight-normal mt-0">Total Authors</h5>
                        <h3 class="mt-2">{{ $users->count() }}</h3>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
        @endcan

        @can('isAuthor')
        <div class="col-xl-3 col-lg-6">
            <div class="card widget-flat bg-green text-white rounded card-border shadow-sm">
                <div class="card-body p-0">
                    <div class="p-3 pb-0">
                        <div class="float-right">
                            <span class="icon widget-icon"><i class="fas fa-check-circle"></i></span>
                        </div>
                        <h5 class="font-weight-normal mt-0">Published Articles</h5>
                        <h3 class="mt-2">{{ $published->count() }}</h3>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
        @endcan
    </div>
    @endcannot

    @endcannot
    <!-- end row -->


    @can('isAdmin')

    <div class="row">

        <div class="col-md-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Analytics</h5>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover sys_table">
                        <thead>
                            <tr style='background-color:#A9A9A9'>

                                                               
                                <th>DOI</th>
                                    <th>Without DOI</th>
                                    <th>With DOI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
                                @endphp
                                @foreach( $doiDatas1 as $single_doi )
                                @if($single_doi['journal'] == 'IJRTMR' || $single_doi['journal'] == 'IJSREAT')
                                    <tr style='background-color:#fcfbb4;'>
                                @elseif($single_doi['journal'] == 'IJIRE')
                                    <tr style='background-color:#ADD8E6;'>
                                @elseif($single_doi['journal'] == 'INDJCST')
                                    <tr style='background-color:#B2FBA5;'>

                                @elseif($single_doi['journal'] == 'INDJEEE')
                                    <tr style='background-color:#B47EDE;'>
                                @elseif($single_doi['journal'] == 'INDJECE')
                                    <tr style='background-color:#FF7518;'>
                                @endif            
                                 
                                    <td>{{ $single_doi['journal']}}</td>
                                    <td>{{ $single_doi['withoutdoi']}}</td>
                                    <td>{{ $single_doi['withdoi']}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-md-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Analytics</h5>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover sys_table">
                        <thead>
                                <tr style='background-color:#A9A9A9'>

                                                                    
                                <th>Mode</th>
                                    <th>Normal</th>
                                    <th>Fast</th>
                                    <th>Express</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
                                @endphp
                                @foreach( $doiDatas1 as $single_doi )
                                @if($single_doi['journal'] == 'IJRTMR' || $single_doi['journal'] == 'IJSREAT')
                                    <tr style='background-color:#fcfbb4;'>
                                @elseif($single_doi['journal'] == 'IJIRE')
                                    <tr style='background-color:#ADD8E6;'>
                                @elseif($single_doi['journal'] == 'INDJCST')
                                    <tr style='background-color:#B2FBA5;'>

                                @elseif($single_doi['journal'] == 'INDJEEE')
                                    <tr style='background-color:#B47EDE;'>
                                @elseif($single_doi['journal'] == 'INDJECE')
                                    <tr style='background-color:#FF7518;'>
                                @endif 
                              
                                   
                                    <td>{{ $single_doi['journal']}}</td>
                                    <td>{{ $single_doi['normal']}}</td>
                                    <td>{{ $single_doi['fast']}}</td>

                                    <td>{{ $single_doi['express']}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>

    </div>
    <div class="row">
        <div class="col-12">
            <h4>Filter By</h4>
            <div class="row">
                <div class="col-md-4 col-xs-12" style="margin-bottom:20px;">
                    <label>Paper ID</label>
                    <input type="text" class="form-control" id="paper_id">
                </div>
                <div class="col-md-4 col-xs-12" style="margin-bottom:20px;">
                    <label>Author Name</label>
                    <input type="text" class="form-control" id="author_name">
                </div>
                <div class="col-md-4 col-xs-12" style="margin-bottom:20px;">
                    <label>Manuscript Title</label>
                    <input type="text" class="form-control" id="title_name">
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Article List</h4>
                    <div class="" id="table" style="overflow-x:auto;">
                        <table id="basic-datatable" class="table table-striped table-hover table-white nowrap dashboard_fix-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="hide-column">No</th>
                                    <th class="id_box" style="min-width: 125px;">ID</th>
                                    <th class="title_box text-center" style="min-width: 150px;">Title</th><!-- Increased width -->

                                    <th class="text-left text-center" style="min-width: 100px;">Mode</th>
                                    <th class="author_box text-center" style="min-width: 100px;">Author</th> <!-- Adjusted width -->
                                    <th class="satus_box text-center" style="min-width: 50px;">Status</th> <!-- Adjusted width -->
                                    <th class="paymeny_box text-center" style="min-width: 50px;">Payment</th> <!-- Adjusted width -->
                                    <th class="created_box text-center" style="min-width: 100px;">Created On</th> <!-- Adjusted width -->
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
                                @endphp
                                @foreach( $rows as $row )
                                <tr>
                                    <td class="hide-column text-center">{{ $count++ }}</td>
                                    <td class="id_box text-center" style="width: 150px;"><a href="{{url('dashboard/admin/submission/show/'.$row->id)}}">{{$row->journal_short_form}}-0000{{ $row->id }}</a></td>
                                    <td class="small-td text-center title_box">{{ $row->title }}</td> <!-- Increased width -->
                                    <!-- <td class="small-td text-left" style="width: 50px;"><i class="fas fa-walking"></i></td> -->
                                    
                                        @if($row->processing_type == 1)
                                            <td class="small-td text-center" >Normal</td>
                                        @elseif($row->processing_type == 2)
                                            <td class="small-td text-center" >Fast</td>
                                        @elseif($row->processing_type == 3)
                                            <td class="small-td text-center" >Express</td>
                                        @endif
                                    
                                    
                                    
                                    <td class="author_box text-center" >{{ $row->authorname }}</td> <!-- Adjusted width -->
                                    <td class="satus_box text-center" ><span class="badge badge-pill" style="background-color:{{$row->colourflag}}; color:#ffffff;border:1px solid {{$row->colourflag}}">{{$row->statusname}}</span></td>
                                    <td class="paymeny_box text-center" style="width: 50px;">
                                        @php
                                            if(!empty($row->payment_status)){
                                                $data = $row->payment_status;
                                                $paymentstatus = strtok($data, '-');
                                            } else {
                                                $paymentstatus = "null";
                                            }
                                        @endphp

                                        @if ($paymentstatus == "paid")
                                            <span class="badge badge-pill" style="background-color:green; color:#ffffff;border:1px solid green">Paid</span>
                                        @elseif ($paymentstatus == "unpaid")
                                            <span class="badge badge-pill" style="background-color:red; color:#ffffff;border:1px solid red">Un Paid</span>
                                        @else
                                            <span class="badge badge-pill" style="background-color:blue; color:#ffffff;border:1px solid blue">Not Started</span>
                                        @endif
                                    </td>
                                    <td class="created_box text-center" style="width: 100px;">{{ $row->created_at }}</td> <!-- Adjusted width -->
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                  <!-- Data Table End -->

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->

  

    @endcan

    @can('isStaff')

    <div class="row">
        <div class="col-12">
            <h4>Filter By</h4>
            <div class="row">
                <div class="col-md-4 col-xs-12" style="margin-bottom:20px;">
                    <label>Paper ID</label>
                    <input type="text" class="form-control" id="paper_id">
                </div>
                <div class="col-md-4 col-xs-12" style="margin-bottom:20px;">
                    <label>Author Name</label>
                    <input type="text" class="form-control" id="author_name">
                </div>
                <div class="col-md-4 col-xs-12" style="margin-bottom:20px;">
                    <label>Manuscript Title</label>
                    <input type="text" class="form-control" id="title_name">
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Article List</h4>

                    <!-- Data Table Start -->
                    <div class=""  id="table" style="overflow-x:auto;">
                        <table id="basic-datatable" class="table table-striped table-hover table-white nowrap dashboard_fix-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="hide-column">No</th>
                                    <th class="id_box">ID</th>
                                    <th class="text-left title_box">Title</th>
                                    <th class="author_box">Author</th>
                          
                                    <th class="satus_box">Status</th>
                        
                                    <th class="created_box">Created On</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
                                @endphp
                                @foreach( $rows as $row )
                                <tr>
                                    <td class="hide-column">{{$count++}}</td>
                                    <td class="id_box"><a href="{{url('dashboard/staff/show/'.$row->id)}}">{{$row->journal_short_form}}-0000{{ $row->id }}</td>
                                    <td class="small-td text-left title_box">{{ $row->title }}</td>
                                    <td class="author_box">{{ $row->authorname }}</td>
                                   
                         
                                    <td class="satus_box"><span class="badge badge-pill" style="background-color:{{$row->colourflag}}; color:#ffffff;border:1px solid {{$row->colourflag}}">{{$row->statusname}}</span></td>
                                    {{-- <td>{{ $row->statusname }}</td> --}}
                            
                                    <td class="created_box">{{ $row->created_at }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                <!-- Data Table End -->

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

    @endcan

    @can('isReviewer')
    <div class="row">
    <div class="col-md-12">
                <div class="ibox">
                <div class="ibox-title" style="display: flex; justify-content: space-between; align-items: center;">
    <h4 class="">Review List</h4>
    @if(!empty($reviews[0]->reviewerid))
            <h4 style="margin: 0;color:blue">Reviewer Referral ID: {{ $reviews[0]->reviewerid }}</h4>
        @endif
</div>

 
                  <!-- Data Table Start -->
                  <div class="ibox-content">
                    <table class="table table-hover table-vcenter">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Article Title</th>
                                <th>Assigned On</th>
                                <th>Due Date</th>
                                
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <!-- @foreach ($reviews as $review)
                                <tr>
                                    
                                    <td>{{$review->journal_short_form}}-0000{{ $review->articleid }}</td>
                                    <td><a href="{{url('dashboard/reviewer/review/show/'.$review->id)}}">{{$review->articlename}}</a></td>
                                    <td>{{$review->create_at}}</td>
                                    <td>{{$review->due_date}}</td>
                                    @php
                                        $isSubmitted = false;
                                    @endphp

                                    @foreach($review_ev as $ev)
                             
                                        @if($review->id == $ev->review_id)
                                            <td>Submitted</td>
                                            @php
                                                $isSubmitted = true;
                                                
                                                break;
                                            @endphp
                                        @endif
                                    @endforeach

                                    @if(!$isSubmitted)
                                        <td>Not Submitted</td>
                                    @endif

                                    
                                </tr>
                        @endforeach -->


                        @if(isset($reviews) && $reviews->count() > 0)
                            @foreach ($reviews as $review)
                                <tr>
                                    <td>{{ $review->journal_short_form }}-0000{{ $review->articleid }}</td>
                                    <td><a href="{{ url('dashboard/reviewer/review/show/' . $review->id) }}">{{ $review->articlename }}</a></td>
                                    <td>{{ $review->create_at }}</td>
                                    <td>{{ $review->due_date }}</td>

                                    @php $isSubmitted = false; @endphp

                                    @if(isset($review_ev) && count($review_ev) > 0)
                                        @foreach($review_ev as $ev)
                                            @if($review->id == $ev->review_id)
                                                <td>Submitted</td>
                                                @php
                                                    $isSubmitted = true;
                                                    break;
                                                @endphp
                                            @endif
                                        @endforeach
                                    @endif

                                    @if(!$isSubmitted)
                                        <td>Not Submitted</td>
                                    @endif
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">No reviews available.</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                  </div>
                  <!-- Data Table End -->

                </div> <!-- end card body-->
            </div> <!-- end col-->
    </div>
    <!-- end row-->
    @endcan



    @can('isAuthor')


    <div class="row">
        <div class="col-xl-3 col-lg-3">
            <div class="card">
                <div class="col-md-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>{{$users[0]->name}}</h5>
                        <hr>
                        </div>
                        <div class="ibox-content">
                            <address>
                                @foreach ($users as $user)
                                <b>Name: </b><span class="text-nowrap">{{ $user->name }}</span><br><br>
                                <b>Email: </b><span class="text-nowrap">{{ $user->email }}</span><br><br>
                                <b>Phone: </b><span class="text-nowrap">{{ $user->phone }}</span><br><br>

                                @endforeach
                            </address>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- **********************************************************************************************8 --}}
        <div class="col-xl-9 col-lg-9">
            <div class="card">

                <div class="col-md-12">
                    <div class="ibox">
                        <div class="ibox-title d-flex align-content-center justify-content-center justify-content-md-between py-2 flex-wrap position-relative">
                            <!-- tour for dashboard -->
                            <span id="tour_data" class="d-none p-2 border shadow position-absolute tour-container z-40 text-white" style="border-radius: 20px 20px 20px 0px; top: 2rem; height: fit-content; left: 5.5rem; background-color: #007bff;">Click the ID of <strong>Articles</strong> to see detials</span> 
                            <!-- end tour for dashboard -->
                            <h4 class="">Article List</h4>
                            <div class="d-flex gap-2 align-content-center justify-content-sm-end justify-content-center flex-fill flex-wrap">
                                
                                <a class="d-block mb-0 my-1 my-sm-0" style="box-sizing: border-box;" href="{{url('dashboard/author/ faq')}}"><span class="btn btn-blue upload_file waves-effect waves-light mx-1" style="background-color:#8D0672; height: 100%;">Submission Guidelines</span></a>
                                <a class="d-block my-1 my-sm-0" href="{{url('dashboard/author/addarticle')}}"><span class="btn btn-blue upload_file waves-effect waves-light mx-1" style=" border: none; color: white; font-size: 16px; border-radius: 5px; cursor: pointer; transition: background 0.3s ease;" id="newSubmission">New Submission</span></a>
                            </div>
                                {{-- <a href="{{url('dashboard/author/addarticle')}}"><p style="float: right;">New Submission</p> --}}
                            {{-- <hr> --}}

                            <div class="clearfix"></div>
                        </div>
 
                      <!-- Data Table Start -->
                      <div class="pb-2" style="overflow-x:auto;">  
                        <table id="basic-datatable" class="table table-striped table-hover table-white nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center" id="articleId">ID</th>
                                    <th class="lg-title">Title</th>
                                    <th class="">Research Area</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach( $Alldata as $key => $row )
                                <tr>
                                    <td class="text-center " style='width:150px;'><a href="{{url('dashboard/author/article/show/'.$row->id)}}" >{{$row->journal_short_form}}-0000{{$row->id}}</a></td>
                                    <td class="lg-title">{{$row->title}}</td>
                                    <td>{{ $row->category }}</td>
                                    <td class="text-center"><span class="badge badge-pill" style="background-color:{{$row->colourflag}}; color:#ffffff;border:1px solid {{$row->colourflag}}">{{$row->statusname}}</span></td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                      </div>
                      <!-- Data Table End -->

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
    </div>


{{-- ************************************************************************************************************** --}}


{{-- ********************************************************************************************** --}}
    <div class="row">

        <div class="col-md-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Recent Copyright Acceptances</h5>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover sys_table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Subject</th>
                                    <th>Date Created</th>
                                    <th>Date Published</th>
                                    <th>Stage</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($acceptances as $acceptance )
                                <tr>
                                    <td><a href="{{url('dashboard/author/article/show/'.$acceptance->article_id)}}">{{$acceptance->journal_short_form}}-0000{{$acceptance->article_id }}</td>
                                    <td>{{$acceptance->scheduled_to}}</td>
                                    <td>{{$acceptance->accepted_on}}</td>
                                    <td>{{$acceptance->published_on}}</td>
                                    <td>
                                        @if($acceptance->status == 'Draft')
                                        <span class="badge badge-pill" style="background-color:#a3a375; color:#ffffff;border:1px solid #a3a375">Draft</span>
                                        @elseif ($acceptance->status == 'Accepted')
                                        <span class="badge badge-pill" style="background-color:#33cc33; color:#ffffff;border:1px solid #33cc33">Accepted</span>
                                        @else
                                        <span class="badge badge-pill" style="background-color:#ff0000; color:#ffffff;border:1px solid #ff0000">Declined</span>
                                        @endif
                                        </td>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>

    </div>
    
    @endcan


</div> <!-- container -->
<!-- End Content-->


<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

<script>
// window.onload = function() {
//     $.ajax({
//     method: 'POST',
//     url: '{{URL::to('/dashboard/admin/dashboard_table')}}',
//     data:{ _token: "{{csrf_token()}}" },
//     success:function(response){
//         $('#table').html(response);
//     },
//     error:function(){
//         alert("Something went Wrong!!!");
//     }
//     })
// };
$(document).ready(function() {

    var myJsVariable = <?php echo $Alldata ?>;
    
    // Now you can use myJsVariable in your jQuery code
    
    console.log("working",myJsVariable); 
}
)
//Details data change Asynchronous
$('#journal').change(function(){
    let val=$(this).val();
            // alert(list);
            // alert(val);
    $("#table").empty();
    $.ajax({
    method: 'POST',
    url: '{{URL::to('/dashboard/admin/dashboard_ajax')}}',
    data:{ _token: "{{csrf_token()}}", id: val },
    success:function(response){
        $('#table').html(response);
    },
    error:function(){
        alert("Something went Wrong!!!");
    }
    })
});

$('#paper_id').change(function(){
    let val=$(this).val();
            // alert(list);
            // alert(val);
    $("#table").empty();
    $.ajax({
    method: 'POST',
    url: '{{URL::to('/dashboard/admin/table_content_depent_by_id')}}',
    data:{ _token: "{{csrf_token()}}", id: val },
    success:function(response){
        $('#table').html(response);
    },
    error:function(){
        alert("ID Format is Wrong!!!");
    }
    })
});


$('#author_name').change(function(){
    let val=$(this).val();
            // alert(list);
            // alert(val);
    $("#table").empty();
    $.ajax({
    method: 'POST',
    url: '{{URL::to('/dashboard/admin/table_content_depent_by_author_name')}}',
    data:{ _token: "{{csrf_token()}}", name: val },
    success:function(response){
        $('#table').html(response);
    },
    error:function(){
        alert("Something went Wrong!!!");
    }
    })
});


$('#title_name').change(function(){
    let val=$(this).val();
            // alert(list);
            // alert(val);
    $("#table").empty();
    $.ajax({
    method: 'POST',
    url: '{{URL::to('/dashboard/admin/table_content_depent_by_article_title')}}',
    data:{ _token: "{{csrf_token()}}", article_title: val },
    success:function(response){
        $('#table').html(response);
    },
    error:function(){
        alert("Something went Wrong!!!");
    }
    })
});

</script>
<script>
  $(document).ready(function () {
    const TOUR_FLAG = true; // Change to false to disable tour
    const TOUR_KEY = 'tourDataDismissed';

    // Check if dismissed
    const isTourDismissed = localStorage.getItem(TOUR_KEY);

    if (TOUR_FLAG && !isTourDismissed) {
      $('#tour_data').removeClass("d-none"); // Ensure it's visible initially
      addAritcleIdStyle()
    } else {
      $('#tour_data').addClass("d-none");
      resetArticleIdStyle(); // Ensure style is reset even on page reload
    }

    // Bind one-time dismiss handler
    $(document).on('click', function (e) {
      // Exclude clicks inside the tour itself
      if ($(e.target).closest('#tour_data').length === 0) {
        if (!localStorage.getItem(TOUR_KEY)) {
          $('#tour_data').fadeOut(200);
          resetArticleIdStyle();
          localStorage.setItem(TOUR_KEY, 'true');
        }
      }
    });

    function resetArticleIdStyle() {
      const $article = $('#articleId');
      $article.removeAttr('style');
      // Optional: add default styles if needed
      // $article.css({ color: '', backgroundColor: '' });
    }
    function addAritcleIdStyle() {
    const $article = $('#articleId');
    $article.attr('style', 'background-color: #007bff; color: white;');
}

  });
</script>


@endsection
