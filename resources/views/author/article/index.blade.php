@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <!-- Include page breadcrumb -->
    @include('admin.inc.breadcrumb')
    <!-- end page title -->


    {{-- <div class="row">
        <div class="col-12">
            <!-- Add modal button -->
            <a href="{{url('dashboard/author/addarticle')}}"><button type="button" class="btn btn-primary">Add New</button></a>
            <!-- Include Add modal -->


            <a href="{{ URL::route('author.'.$url.'.index') }}" class="btn btn-info">Refresh</a>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <!-- Include Flash Messages -->
                    @include('admin.inc.message')
                </div>

                <div class="card-body">
                  <h4 class="header-title">{{ $title }} List</h4>

                  <!-- Data Table Start -->
                  <div class="table-responsive">
                    <table id="basic-datatable" class="table table-striped table-hover table-white nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Research Area</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach( $rows as $key => $row )
                            <tr>
                                <td><a href="{{url('dashboard/author/article/show/'.$row->id)}}">{{$row->journal_short_form}}-0000{{ $row->id }}</a></td>
                                    <td>{!! str_limit(strip_tags($row->title), 50, ' ...') !!}</td>
                                    <td>{{ $row->category }}</td>

                                    <td><span class="badge badge-pill" style="background-color:{{$row->colourflag}}; color:#ffffff;border:1px solid {{$row->colourflag}}">{{$row->statusname}}</span></td>
                                {{-- <td>
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#showModal-{{ $row->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>


                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal-{{ $row->id }}">
                                        <i class="far fa-edit"></i>
                                    </button>
                                    <!-- Include Edit modal -->
                                    @include('author.'.$url.'.edit')

                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal-{{ $row->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <!-- Include Delete modal -->
                                    @include('admin.inc.delete')
                                </td> --}}
                                <td>
                                    <a href="{{url('dashboard/author/article/indivitual_article_show/'.$row->id)}}"><button type="button" class="btn btn-success btn-sm">
                                        <i class="fas fa-eye"></i> 
                                    </button></a>
                                    <!-- Include Show modal -->
                                    {{-- @include('admin.'.$url.'.show') --}}

                                    @if ($row->freeze_data == 0)
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal-{{ $row->id }}">
                                            <i class="far fa-edit"></i>
                                        </button>
                                        <!-- Include Edit modal -->
                                        @include('author.'.$url.'.edit')

                                        <!-- <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal-{{ $row->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button> -->
                                        <!-- Include Delete modal -->
                                        @include('admin.inc.delete')
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


</div> <!-- container -->
<!-- End Content-->

@endsection
