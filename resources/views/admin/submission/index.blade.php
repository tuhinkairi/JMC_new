@extends('admin.layouts.master')
@section('title', $title)
@section('content')
<style>
    td, th {
      text-align: center;
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
            <div class="card widget-flat bg-red text-white rounded card-border shadow-sm">
                <div class="card-body p-0">
                    <div class="p-3 pb-0">
                        <div class="float-right">
                            <span class="icon widget-icon"><i class="fas fa-question-circle"></i></span>
                        </div>
                        <h5 class="font-weight-normal mt-0">Active Issues</h5>
                        <h3 class="mt-2">{{ $issue->count() }}</h3>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
        @endcan
    </div>
    <!-- end row -->

    @can('isAdmin')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <!-- Include Flash Messages -->
                    @include('admin.inc.message')
                </div>
                <div class="col-md-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h4 class="">Article List</h4>
                        </div>

                      <!-- Data Table Start -->
                      <div class="table-responsive">
                        <table id="basic-datatable" class="table table-striped table-hover table-white nowrap dashboard_fix-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="hide-column">No</th>
                                    <th>ID</th>
                                    <th class="text-center title_box">Title</th>
                                    <th>Research Area</th>
                                    <th>Status</th>
                                    {{-- <th class="text-center" style="width:140px">Issue</th> --}}
                                    <th>Action</th>
                                    {{-- <th>Submit Status</th> --}}
                                </tr>

                            </thead>
                            <tbody id="table">
                                @php
                                    $count = 1;
                                @endphp
                              @foreach( $rows as $key => $row )
                                <tr>
                                    <td class="hide-column">{{$count ++}}</td>
                                    <td><a href="{{url('dashboard/admin/submission/show/'.$row->id)}}">{{$row->journal_short_form}}-0000{{ $row->id }}</a></td>
                                    <td>{!! str_limit(strip_tags($row->title), 50, ' ...') !!}</td>
                                    <td>{{ $row->category }}</td>

                                    <td><span class="badge badge-pill" style="background-color:{{$row->colourflag}}; color:#ffffff;border:1px solid {{$row->colourflag}}">{{$row->statusname}}</span></td>
                                    <td>
                                        <a href="{{url('dashboard/admin/article/show/'.$row->id)}}"><button type="button" class="btn-success" style="height:30px;width:30px">
                                            <i class="fas fa-eye"></i>
                                        </button></a>
                                        <button type="button" class="btn-primary" style="height:30px;width:30px" data-toggle="modal" data-target="#editModal-{{ $row->id }}">
                                            <i class="far fa-edit"></i>
                                        </button>
                                        @include('admin.article.edit')

                                        <button type="button" class="btn-danger" style="height:30px;width:30px" data-toggle="modal" data-target="#deleteModal-{{ $row->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <!-- Include Delete modal -->
                                        @include('admin.inc.delete')

                                        {{-- download article --}}
                                        @if(is_file('uploads/article/'.$row->file_path))
                                        <a href="{{ asset('uploads/article/'.$row->file_path) }}" download><button type="button" class="btn-warning"><i class="fa fa-download"></i>
                                        </button></a>
                                        @endif

                                    </td>
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
</div> <!-- container -->
<!-- End Content-->


<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script>
    //Details data change Asynchronous
$('#journal').change(function(){
    let val=$(this).val();
            // alert(list);
            // alert(val);
    $("#table").empty();
    $.ajax({
    method: 'POST',
    url: '{{URL::to('/dashboard/admin/submission_ajax')}}',
    data:{ _token: "{{csrf_token()}}", id: val },
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
