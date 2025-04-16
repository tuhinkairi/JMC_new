@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <!-- Include page breadcrumb -->
    @include('admin.inc.breadcrumb')
    <div class="row">
        <div class="col-xl-17 col-lg-12">
            <div class="card-body p-0">
                <div class="p-0 pb-0">
                    <div class="card">
                        <div class="card-header">
                            <!-- Include Flash Messages -->
                            @include('admin.inc.message')
                        </div>
                        <div class="col-md-12">
                            <div class="ibox">
                            <div class="card-header pb-0 px-2 bg-light border-bottom-0">
                                <ul class="nav nav-tabs col-20" id="nav-tab">
                                    <li class="nav-item">
                                        <a data-toggle="tab" class="nav-link active" href="#article"><i class="fa fa-object-group" aria-hidden="true"></i> Article</a>
                                    </li>

                                    <li class="nav-item">
                                        <a data-toggle="tab" class="nav-link" href="#manuscript"><i class="fa fa-th"></i> Manuscript Files</a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a data-toggle="tab" class="nav-link" href="#files"><i class="fa fa-tasks"></i> Files</a>
                                    </li> --}}
                                    <li class="nav-item">
                                        <a data-toggle="tab" class="nav-link" href="#copyright_form"><i class="fa fa-upload"></i> Copy Right Form</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">


                                            <div class="tab-content">

                                                <div id="article" class="tab-pane ib-tab-box active">
                                                    <div class="row">
                                                        <div class="col-md-12">

                                                            <div class="table-responsive">
                                                                <table id="basic-datatable" class="table table-striped table-hover table-white nowrap" style="width:100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Title</th>
                                                                            <th>Manage</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Article Template</td>
                                                                            <td>
                                                                                <a href="{{ asset('uploads/article/Article-Template.docx') }}" download><button type="button" class="btn-warning"><i class="fa fa-download"></i>
                                                                                </button></a>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div id="manuscript" class="tab-pane ib-tab-box">
                                                    <div class="row">
                                                        <div class="col-md-12">

                                                            <div class="table-responsive">
                                                                <table id="basic-datatable" class="table table-striped table-hover table-white nowrap" style="width:100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Title</th>
                                                                            <th>Manage</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($manuscripts as $manuscript)
                                                                        <tr>
                                                                            <td>{{$manuscript->title}}</td>
                                                                            <td>
                                                                                @if(is_file('uploads/article/'.$manuscript->file_path))
                                                                                <a href="{{ asset('uploads/article/'.$manuscript->file_path) }}" download><button type="button" class="btn-warning"><i class="fa fa-download"></i>
                                                                                </button></a>
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

                                                <div id="copyright_form" class="tab-pane ib-tab-box">
                                                    <div class="row">
                                                        <div class="col-md-12">

                                                            <div class="table-responsive">
                                                                <table id="basic-datatable" class="table table-striped table-hover table-white nowrap" style="width:100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Name</th>
                                                                            <th>Manage</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($final_copy_right_forms as $final_copy_right_form)
                                                                            <tr>
                                                                                <td>{{$final_copy_right_form->doc_title}}</td>
                                                                                <td>
                                                                                    {{-- download copyrigth form --}}
                                                                                    @if(is_file('uploads/final_submission/'.$final_copy_right_form->file_path))
                                                                                    <a href="{{ asset('uploads/final_submission/'.$final_copy_right_form->file_path) }}" download><button type="button" class="btn-warning"><i class="fa fa-download"></i>
                                                                                    </button></a>
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
                            </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

