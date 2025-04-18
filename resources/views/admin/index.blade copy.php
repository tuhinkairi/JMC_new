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
</style>
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <!-- Include page breadcrumb -->
    @include('admin.inc.breadcrumb')
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-3 col-lg-6">
            <div class="card widget-flat bg-blue text-white rounded card-border shadow-sm">
                <div class="card-body p-0">
                    <div class="p-3 pb-0">
                        <div class="float-right">
                            <span class="icon widget-icon"><i class="fas fa-newspaper"></i></span>
                        </div>
                        <h5 class="font-weight-normal mt-0">Approve Articles</h5>
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
    <!-- end row -->


    @can('isAdmin')

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
                    <div class="" id="table">
                        <table id="basic-datatable" class="table table-striped table-hover table-white nowrap dashboard_fix-table" style="width:100%">
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
                            <tbody>
                                @php
                                    $count = 1;
                                @endphp
                                @foreach( $rows as $row )
                                <tr>
                                    <td class="hide-column">{{$count ++}}</td>
                                    <td class="id_box"><a href="{{url('dashboard/admin/submission/show/'.$row->id)}}">{{$row->journal_short_form}}-0000{{ $row->id }}</td>
                                    <td class="small-td text-left title_box">{{ $row->title }}</td>
                                    <td class="author_box">{{ $row->authorname }}</td>
                                    <td class="assigned_box">
                                        <ol>
                                            @foreach ($tasks as $task)
                                            @if ($task->article_id == $row->id)
                                                <li>{{ $task->staff }}</li>
                                            @endif
                                            @endforeach
                                        </ol>
                                    </td>
                                    <td class="task_box">
                                        <ol>
                                            @foreach ($tasks as $task)
                                            @if ($task->article_id == $row->id)
                                                <li>{{ $task->task_name }}</li>
                                            @endif
                                            @endforeach
                                        </ol>
                                    </td>
                                    <td class="satus_box"><span class="badge badge-pill" style="background-color:{{$row->colourflag}}; color:#ffffff;border:1px solid {{$row->colourflag}}">{{$row->statusname}}</span></td>
                                    {{-- <td>{{ $row->statusname }}</td> --}}
                                    <td class="paymeny_box">
                                        @php
                                                    if(!empty($row->payment_status)){
                                                        $data = $row->payment_status;
                                                        $paymentstatus = strtok($data, '-');

                                                    }else{
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
    <!-- end row-->

    @endcan


    @can('isReviewer')
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">
                  <h4 class="header-title">Approve Article List</h4>

                  <!-- Data Table Start -->
                  <div class="">
                    <table id="basic-datatable" class="table table-striped table-hover table-white nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Research Area</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach( $rows as $key => $row )
                            <tr>
                                <td>{{$row->journal_short_form}}-0000{{ $row->id }}</td>
                                <td>{!! str_limit(strip_tags($row->title), 50, ' ...') !!}</td>
                                <td>{{ $row->category }}</td>
                                <td><span class="badge badge-pill" style="background-color:{{$row->colourflag}}; color:#ffffff;border:1px solid {{$row->colourflag}}">{{$row->statusname}}</span></td>
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
                                <b>Name: </b>{{ $user->name }}<br><br>
                                <b>Email:</b>{{ $user->email }}<br><br>
                                <b>Phone: </b>{{ $user->phone }}<br><br>

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
                        <div class="ibox-title">
                            <h4 style="float: left;">Article List</h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="{{url('dashboard/author/addarticle')}}"><span class="btn btn-blue upload_file waves-effect waves-light" style="background-color:#8D0672;">New Submission</span></a>
                            {{-- <a href="{{url('dashboard/author/addarticle')}}"><p style="float: right;">New Submission</p> --}}
                            {{-- <hr> --}}
                            <div class="clearfix"></div>
                        </div>

                      <!-- Data Table Start -->
                      <div class="pb-2">
                        <table id="basic-datatable" class="table table-striped table-hover table-white nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="lg-title">Title</th>
                                    <th class="">Research Area</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach( $Alldata as $key => $row )
                                <tr>
                                    <td class="text-center"><a href="{{url('dashboard/author/article/show/'.$row->id)}}">{{$row->journal_short_form}}-0000{{$row->id}}</a></td>
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
    <div class="row">

        <div class="col-md-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Recent Invoices</h5>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover sys_table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Account</th>
                                <th>Amount</th>
                                <th>Invoice Date</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th class="text-right">Manage</th>
                            </tr>
                            </thead>
                            <tbody>


                            </tbody>

                        </table>

                    </div>

                </div>
            </div>
        </div>

    </div>

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
@endsection
