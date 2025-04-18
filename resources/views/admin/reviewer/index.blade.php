@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <!-- Include page breadcrumb -->
    @include('admin.inc.breadcrumb')
    <!-- end page title -->


    <div class="row">
        <div class="col-12">
            <!-- Add modal button -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add New</button>
            <!-- Include Add modal -->
            @include('admin.'.$url.'.create')

            <a href="{{ URL::route($url.'.index') }}" class="btn btn-info">Refresh</a>
        </div>
    </div>

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
            <th>S.No</th>
            <th>Reviewer Referral ID</th>
            <th>Name</th>
            <th>Dept</th>
            <th>Email ID</th>
            <th>Phone No</th>
         
            <th colspan="3">Review Article Details</th>
           
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $key => $row)
            <tr>
                <td rowspan="4">{{ $key + 1 }}</td>
                <td rowspan="4">{{ $row->reviewerid }}</td>
                <td rowspan="4">{{ $row->name }}</td>
                <td rowspan="4">{{ $row->department }}</td>
                <td rowspan="4">{{ $row->email }}</td>
                <td rowspan="4">{{ $row->phone }}</td>
        
                @php
                    $articles = array_values($assignedArticle[$row->id] ?? []);
                @endphp
                @for($i = 0; $i < 3; $i++)
                    <td>
                        @if(isset($articles[$i]))
                            @foreach ($articles[$i] as $sform)
                                <a href="{{ url('dashboard/admin/submission/show/'.$sform->id) }}">
                                    {{ $sform->journal_short_form }}-0000{{ $sform->id }}
                                </a><br>
                            @endforeach
                        @endif
                    </td>
                @endfor
                <td rowspan="4">
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#showModal-{{ $row->id }}">
                        <i class="fas fa-eye"></i>
                    </button>
                    <!-- Include Show modal -->
                    @include('admin.'.$url.'.show')

                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#editModal-{{ $row->id }}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <!-- Include Show modal -->
                    @include('admin.'.$url.'.edit')

                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal-{{ $row->id }}">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    <!-- Include Delete modal -->
                    @include('admin.inc.delete_reviewer')
                </td>
            </tr>
            <tr></tr>
            <tr></tr>
            <tr></tr>
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
