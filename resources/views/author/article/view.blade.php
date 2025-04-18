@extends('admin.layouts.master')
@section('title', $title)
@section('content')
<style>
    .custom-select {
  /* Add your custom styles here */
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
  width: 150px;
}

.custom-select option {
  /* Add your custom styles for options here */
  background-color: #f2f2f2;
  color: #333;
  padding: 5px;
}

.custom-select option:selected {
  /* Add your custom styles for the selected option here */
  background-color: #007bff;
  color: #fff;
}
</style>
<div class="row">
    @if (session('alert'))
        <script>
            alert('Please Update Your Profile');
        </script>
@endif
@if (session('alert_for_review_form'))
        <script>
            alert('Review Form is Under Processing');
        </script>
@endif
    <div class="col-xl-12 col-lg-12">
        <div class="card-body p-0">
            <div class="px-3 pt-3">
                <div class="card">
                    <div class="card-header">
                        <!-- Include Flash Messages -->
                        @include('admin.inc.message')
                    </div>

                    <div class="card-header">
                        <!-- Include Flash Messages -->
                        @if($rows[0]->journal_short_form == 'IJIRE')
                            <h3>International Journal of Innovative Research in Engineering</h3>
                            <p>ISSN-2582-8746 An International Open Access, Peer-reviewed, Refereed Journal, DOI: 10.59256/ijire</p>
                        @elseif($rows[0]->journal_short_form == 'IJSREAT')
                        <h3>International Journal of Scientific Research in Engineering & Technology</h3>
                        <p>ISSN:2583-1240 An International Open Access, Peer-reviewed, Refereed Journal, DOI: 10.59256/ijsreat</p>
                        @elseif($rows[0]->journal_short_form == 'IJRTMR')
                        <h3>International Journal of Recent Trends in Multidisciplinary Research</h3>
                        <p>ISSN:2583-0368 An International Open Access, Peer-reviewed, Refereed Journal, DOI: 10.59256/ijrtmr</p>
                        @elseif($rows[0]->journal_short_form == 'INDJEEE')
                        <h3>Indian Journal of Electrical and Electronics Engineering</h3>
                        <p>An Open Access, Peer-reviewed, Refereed Journal, DOI: 10.59256/indjeee</p>
                        @elseif($rows[0]->journal_short_form == 'INDJECE')
                        <h3>ISSN:3048-6408 Indian Journal of Electronics and Communication Engineering</h3>
                        <p>An Open Access, Peer-reviewed, Refereed Journal, DOI: 10.59256/indjece</p>

                        @else
                        <h3>Indian Journal of Computer Science and Technology</h3>
                        <p>ISSN:2583-5300 An Open Access, Peer-reviewed, Refereed Journal, DOI: 10.59256/indjcst</p>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <div class="ibox">
                            <div class="ibox-content">
                                <p class="col-12"><strong>ID: </strong>{{$rows[0]->journal_short_form}}-0000{{ $rows[0]->id }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Title: </strong>{{$rows[0]->title}}</p>
                                <hr>
                                <div class="card-header pb-0 px-2 bg-light border-bottom-0">
                                    <ul class="nav nav-tabs col-20" id="nav-tab">
                                        <li class="nav-item">
                                            <a data-toggle="tab" class="nav-link active" href="#details"><i class="fa fa-th"></i> Details</a>
                                        </li>
                                        <li class="nav-item">
                                            <a data-toggle="tab" class="nav-link" href="#tasks"><i class="fa fa-tasks"></i> Tasks</a>
                                        </li>
                                        <li class="nav-item">
                                            <a data-toggle="tab" class="nav-link" href="#files"><i class="fa fa-upload"></i> Files</a>
                                        </li>
                                        <li class="nav-item">
                                            <a data-toggle="tab" class="nav-link" href="#review"><i class="fa fa-check" aria-hidden="true"></i> Review</a>
                                        </li>

                                        {{-- @isset($acceptances)


                                        @if ($acceptances[0]->status == 'Accepted') --}}
                                        @if(isset($acceptances[0]->status))
                                        @if($acceptances[0]->status == 'Accepted')
                                        <li class="nav-item">
                                            <a data-toggle="tab" class="nav-link" href="#acceptance"><i class="fa fa-check-circle"></i> Acceptance</a>
                                        </li>

                                        <li class="nav-item">
                                            <a data-toggle="tab" class="nav-link" href="#copyrights"><i class="fa fa-copyright"></i> Copy Rights</a>
                                        </li>

                                        <li class="nav-item">   
                                            <a data-toggle="tab" class="nav-link" href="#profile"><i class="fa fa-copyright"></i> Profile</a>
                                        </li>

                                        <li class="nav-item">
                                            <a data-toggle="tab" class="nav-link" href="#payments"><i class="fa fa-credit-card"></i> Payment</a>
                                        </li>
                                        <li class="nav-item">
                                            <a data-toggle="tab" class="nav-link" href="#final_submission"><i class="fa fa-object-group" aria-hidden="true"></i> Final Submission</a>
                                        </li>
                         
                                        @endif
                                        @endif
                                        {{-- @endif
                                        @endisset --}}
                                        {{-- <li class="nav-item">
                                            <a data-toggle="tab" class="nav-link" href="#comments"><i class="fa fa-comments"></i> Communication</a>
                                        </li>
                                        <li class="nav-item">
                                            <a data-toggle="tab" class="nav-link" href="#history"><i class="fa fa-comments"></i> History</a>
                                        </li>
                                        <li class="nav-item">
                                            <a data-toggle="tab" class="nav-link" href="#others"><i class="fa fa-envelope-square" aria-hidden="true"></i> Other Submission</a>
                                        </li> --}}
                                    </ul>
                                </div>
                                <div class="card-body p-2">
                                    <div class="tab-content">
                                        <div id="details" class="tab-pane ib-tab-box active">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-8 my-2">
                                                            <p class="mb-0">
                                                                <strong>Journal</strong>:
                                                                <span class="label label-primary" style="color:#2196f3;">{{$rows[0]->journalname}}</span>
                                                            </p>
                                                        </div>

                                                        <div class="col-md-4 col-xs-12" style="margin-bottom: 10px;">
                                                            <p class="mb-0">
                                                                <strong>Reviewer Referral ID</strong>:
                                                                <span class="label label-primary" id='scheduled_on' style="">{{$rows[0]->ref_id}}</span>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4 col-xs-12" style="margin-bottom: 10px;">
                                                            <p class="mb-0">
                                                                <strong>Status</strong> :
                                                                <span class="badge badge-pill" style="background-color:{{$rows[0]->colourflag}}; color:#ffffff;border:1px solid {{$rows[0]->colourflag}}">{{$rows[0]->statusname}}</span>
                                                                {{-- <span class="label label-success" id="inline_status" style="color:#2196f3">{{$rows[0]->statusname}}</span> --}}
                                                            </p>
                                                        </div>


                                                        <div class="col-md-4 col-xs-12" style="margin-bottom: 10px;">
                                                            <p class="mb-0">
                                                                <strong>Mode of Processing</strong>:
                                                                <span class="label label-primary" id='priority_status' style="color:#2196f3;">{{$rows[0]->processingname}}</span>
                                                            </p>
                                                        </div>

                                                        <div class="col-md-4 col-xs-12" style="margin-bottom: 10px;">
                                                            <p class="mb-0">
                                                                <strong>Activation Status</strong>:
                                                                @if( $rows[0]->status == 2 )
                                                                <span class="badge badge-danger badge-pill">Inactive</span>
                                                                @elseif( $rows[0]->status == 1 )
                                                                <span class="badge badge-success badge-pill">Active</span>
                                                                @endif
                                                            </p>
                                                        </div>


                                                        <div class="col-md-4 col-xs-12" style="margin-bottom: 10px;">
                                                            <p class="mb-0">
                                                                <strong>Type of Article</strong>:
                                                                <span class="label label-primary" id='ttype' style="color:#2196f3;">{{$rows[0]->articlename}}</span>
                                                            </p>
                                                        </div>

                                                        <div class="col-md-4 col-xs-12" style="margin-bottom: 10px;">
                                                            <p class="mb-0">
                                                                <strong>Type of Issue</strong>:
                                                                <span class="label label-primary" id='issue_type' style="color:#2196f3;">{{$rows[0]->issuename}}</span>
                                                            </p>
                                                        </div>

                                                        <div class="col-md-4 col-xs-12" style="margin-bottom: 10px;">
                                                            <p class="mb-0">
                                                                <strong>Scheduled on</strong>:
                                                                <span class="label label-primary" id='scheduled_on' style="">{{$rows[0]->scheduled_on}}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <hr>

                                                    <div class="mt-3">
                                                        <p class="mb-2"><strong>Received on: </strong>{{$rows[0]->created_at}}</p>
                                                        <p class="mb-2"><strong>Updated on: </strong>{{$rows[0]->updated_at}}</p>
                                                        {{-- <p class="mb-2"><strong>Revised on:</strong> </p> --}}
                                                        <p class="mb-2"><strong>Accepted on:</strong>
                                                        @if(isset($acceptances[0]->status))
                                                        @if($acceptances[0]->status == 'Accepted')
                                                            {{$acceptances[0]->accepted_on}}
                                                        @endif
                                                        @endif
                                                        </p>
                                                        <p class="mb-2"><strong>Published on: </strong>{{$rows[0]->scheduled_on}}</p>

                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12 col-xs-12">
                                                            <label for="notes"><b>Notes:</b></label>
                                                            <div class="ml-4">
                                                                {!! $rows[0]->notes !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="tasks" class="tab-pane fade ib-tab-box">
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8">
                                                    <h4>All Tasks</h4>
                                                    <hr>
                                                    <div class="col-xl-8 col-lg-6">
                                                        <table class="table table-bordered table-hover sys_table">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">#</th>
                                                                    <th>Task Name</th>
                                                                    <th class="text-center">Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($tasks as $key => $task)
                                                                <tr>
                                                                    <td class="text-center">{{$key + 1}}</td>
                                                                    <td>{{$task->task_name}}</td>
                                                                    <td class="text-center">
                                                                    @if ($task->status == 'Not Started')
                                                                                <span class="badge badge-pill" style="background-color:#ff3300; color:#ffffff;border:1px solid #ff704d">{{$task->status}}</span>
                                                                            @elseif ($task->status == 'In progress')
                                                                                <span class="badge badge-pill" style="background-color:#4da6ff; color:#ffffff;border:1px solid #99ccff">{{$task->status}}</span>
                                                                            @elseif ($task->status == 'Completed')
                                                                                <span class="badge badge-pill" style="background-color:#008000; color:#ffffff;border:1px solid #99ff33">{{$task->status}}</span>
                                                                            @elseif ($task->status == 'Deferred')
                                                                                <span class="badge badge-pill" style="background-color:#264d73; color:#ffffff;border:1px solid #336699">{{$task->status}}</span>
                                                                            @else
                                                                                <span class="badge badge-pill" style="background-color:#7a7a52; color:#ffffff;border:1px solid #a3a375">{{$task->status}}</span>
                                                                            @endif
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-4">
                                                <div style="float:right; margin-right:30px">
                                                            <h4>Task Overview</h4>
                                                            <p>1. Editorial check</p>
                                                            <p>2. Plagiarism Check</p>
                                                            <p>3. Peer-Review</p>
                                                            <p>4. Proofreading</p>
                                                            <p>5. Layout Editing</p>
                                                            <p>6. Galley Correction</p>
                                                            <p>7. Publishing</p>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="files" class="tab-pane fade ib-tab-box">
                                                
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="panel panel-default">
                                                                <div class="panel-body">
                                                                    <a data-toggle="modal" href="#modal_upload_file" class="btn btn-blue upload_file waves-effect waves-light" id="upload_file"><i class="fa fa-plus"></i> New File Upload</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
    
    
                                                    <div id="modal_upload_file" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form class="needs-validation" novalidate action="{{url('dashboard/author/submission/author_file/'.$rows[0]->id)}}" method="post" enctype="multipart/form-data">
                                                                    @csrf
    
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title"><i class="fa fa-upload"></i> New File Upload</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label for="doc_title">Title</label>
                                                                                    <input type="text" class="form-control" id="doc_title" name="doc_title" required>
                                                                                </div>
                                                                            <hr>
                                                                            <label>Drop File Here</label>
                                                                            <input class="form-control" type="file" name="file" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
                                                                    <button type="submit" id="btn_add_file" class="btn btn-blue upload_file waves-effect waves-light">Submit</button>
                                                                </div>
                                                              </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12">
                                                            <hr>
                                                            <div class="">
                                                                <table class="table table-bordered table-hover sys_table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-center">#</th>
                                                                            <th width="60%">Title</th>
                                                                            <th>Created At</th>
                                                                            <th class="text-center">Manage</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                        <td class="text-center">1</td>
                                                                        <td width="60%">{{$rows[0]->title}}</td>
                                                                        <td>{{$rows[0]->created_at}}</td>
                                                                        <td class="text-center">{{-- download article --}}
                                                                            @if(is_file('uploads/article/'.$rows[0]->file_path))
                                                                            <a href="{{ asset('uploads/article/'.$rows[0]->file_path) }}" download><button type="button" class="btn btn-sm btn-success"><i class="fa fa-download"></i>
                                                                            </button></a>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                        @php
                                                                            $i = 2;
                                                                        @endphp
                                                                        @foreach ($files_0 as $key => $file)
                                                                        <tr>

                                                                            <td class="text-center">{{$i}}</td>
                                                                            <td width="60%">{{$file->doc_title}}</td>
                                                                            <td>{{$file->create_at}}</td>
                                                                            <td class="text-center">{{-- download article --}}
                                                                                @if(is_file('uploads/article_file/'.$file->file_path))
                                                                                <a href="{{ asset('uploads/article_file/'.$file->file_path) }}" download><button type="button" class="btn btn-sm btn-success"><i class="fa fa-download"></i></button></a>
                                                                                {{-- <a href="{{ asset('uploads/article_file/'.$file->file_path) }}"><button type="button" class="btn btn-sm btn-danger"></i></button></a> --}}
                                                                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal-{{ $file->id }}">
                                                                                    <i class="fas fa-trash-alt"></i>
                                                                                </button>
                                                                                @include('admin.file.delete')
                                                                                @endif
                                                                            </td>
                                                                            @php
                                                                            $i += 1;
                                                                            @endphp
                                                                        </tr>

                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-default">
                                                            <div class="panel-body">
                                                            <h4>Plagiarism report :</h4>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                  
                                                <div id="plagiarism_report" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                        <hr>
                                                        <div class="">
                                                            <table class="table table-bordered table-hover sys_table">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">#</th>
                                                                        <th width="60%">Title</th>
                                                                        <th>Created At</th>
                                                                        <th class="text-center">Manage</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php
                                                                        $i = 1;
                                                                    @endphp

                                                                    @foreach ($files_1 as $key => $file)
                                                                    <tr>
                                                                        <td class="text-center">{{$i}}</td>
                                                                        <td width="60%">{{$file->doc_title}}</td>
                                                                        <td>{{$file->create_at}}</td>
                                                                        <td class="text-center">{{-- download article --}}
                                                                            @if(is_file('uploads/article_file/'.$file->file_path))
                                                                            <a href="{{ asset('uploads/article_file/'.$file->file_path) }}" download><button type="button" class="btn btn-sm btn-success"><i class="fa fa-download"></i></button></a>
                                                                            {{-- <a href="{{ asset('uploads/article_file/'.$file->file_path) }}"><button type="button" class="btn btn-sm btn-danger"></i></button></a> --}}
                                                                            
                                                                            @endif
                                                                        </td>
                                                                        @php
                                                                        $i += 1;
                                                                    @endphp
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- 2 report -->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-default">
                                                            <div class="panel-body">
                                                            <h4>Certificate Details :</h4>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                        <hr>
                                                        <div class="">
                                                            <table class="table table-bordered table-hover sys_table">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">#</th>
                                                                        <th width="60%">Title</th>
                                                                        <th>Created At</th>
                                                                        <th class="text-center">Manage</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php
                                                                        $i = 1;
                                                                    @endphp

                                                                    @foreach ($files_2 as $key => $file)
                                                                    <tr>
                                                                        <td class="text-center">{{$i}}</td>
                                                                        <td width="60%">{{$file->doc_title}}</td>
                                                                        <td>{{$file->create_at}}</td>
                                                                        <td class="text-center">{{-- download article --}}
                                                                            @if(is_file('uploads/article_file/'.$file->file_path))
                                                                            <a href="{{ asset('uploads/article_file/'.$file->file_path) }}" download><button type="button" class="btn btn-sm btn-success"><i class="fa fa-download"></i></button></a>
                                                                            {{-- <a href="{{ asset('uploads/article_file/'.$file->file_path) }}"><button type="button" class="btn btn-sm btn-danger"></i></button></a> --}}
                                                                            
                                                                            @endif
                                                                        </td>
                                                                        @php
                                                                        $i += 1;
                                                                    @endphp
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!-- 3rd  -->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-default">
                                                            <div class="panel-body">
                                                            <h4>Published article details :</h4>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                        <hr>
                                                        <div class="">
                                                            <table class="table table-bordered table-hover sys_table">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">#</th>
                                                                        <th width="60%">Title</th>
                                                                        <th>Created At</th>
                                                                        <th class="text-center">Manage</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php
                                                                        $i = 1;
                                                                    @endphp

                                                                    @foreach ($files_3 as $key => $file)
                                                                    <tr>
                                                                        <td class="text-center">{{$i}}</td>
                                                                        <td width="60%">{{$file->doc_title}}</td>
                                                                        <td>{{$file->create_at}}</td>
                                                                        <td class="text-center">{{-- download article --}}
                                                                            @if(is_file('uploads/article_file/'.$file->file_path))
                                                                            <a href="{{ asset('uploads/article_file/'.$file->file_path) }}" download><button type="button" class="btn btn-sm btn-success"><i class="fa fa-download"></i></button></a>
                                                                            {{-- <a href="{{ asset('uploads/article_file/'.$file->file_path) }}"><button type="button" class="btn btn-sm btn-danger"></i></button></a> --}}
                                                                           
                                                                            @endif
                                                                        </td>
                                                                        @php
                                                                        $i += 1;
                                                                    @endphp
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
    
                                            <div id="review" class="tab-pane fade ib-tab-box">
                                                <div class="col-md-12 col-sm-12">
                                                    <h4>Review Table</h4>
    
                                                    <div class="">
                                                        <table class="table table-bordered table-hover sys_table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Assigned To</th>
                                                                    <th>Assigned On</th>
                                                                    <th>Due To</th>
                                                                    <th>Status</th>
                                                                    <th>Decision</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($reviews as $review)
                                                                <tr>
                                                                    @if(isset($review->reviewerid))
                                                                    
                                                                    <td>{{$review->reviewerid}}</td>
                                                                    @else 
                                                                    <td></td>
                                                                    @endif
                                                                    
                                                                    <td>{{$review->create_at}}</td>
                                                                    <td>{{$review->due_date}}</td>
                                                                    <td>
                                                                        @if ($review->status == 'Not Started')
                                                                                <span class="badge badge-pill" style="background-color:#ff3300; color:#ffffff;border:1px solid #ff704d">{{$review->status}}</span>
                                                                            @elseif ($review->status == 'In progress')
                                                                                <span class="badge badge-pill" style="background-color:#4da6ff; color:#ffffff;border:1px solid #99ccff">{{$review->status}}</span>
                                                                            @elseif ($review->status == 'Completed')
                                                                                <span class="badge badge-pill" style="background-color:#008000; color:#ffffff;border:1px solid #99ff33">{{$review->status}}</span>
                                                                            @elseif ($review->status == 'Deferred')
                                                                                <span class="badge badge-pill" style="background-color:#264d73; color:#ffffff;border:1px solid #336699">{{$review->status}}</span>
                                                                            @else
                                                                                <span class="badge badge-pill" style="background-color:#7a7a52; color:#ffffff;border:1px solid #a3a375">{{$review->status}}</span>
                                                                            @endif
                                                                    </td>
                                                                   <td>
                                                                        @if($review->decision == 'view')
                                                                            <a href="{{url('dashboard/author/article/show-review-evalution/'.$review->id)}}"><i class="fa fa-eye"></i></a>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        <div id="acceptance" class="tab-pane fade ib-tab-box">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <h4>Acceptance</h4><br>
                                                    <div class="">
                                                        <table class="table table-bordered table-hover sys_table">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">Id</th>
                                                                    <th>Accepted On</th>
                                                                    <th>Scheduled To</th>
                                                                    <th>Published On</th>
                                                                    <th class="text-center">Stage</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                               @foreach ($acceptances as $acceptance )
                                                                <tr>
                                                                    <td class="text-center">{{$rows[0]->journal_short_form}}-0000{{ $acceptance->article_id }}</td>
                                                                    <td>{{$acceptance->accepted_on}}</td>
                                                                    <td>{{$acceptance->scheduled_to}}</td>
                                                                    <td>{{$acceptance->published_on}}</td>
                                                                    <td class="text-center">
                                                                        @if($acceptance->status == "Draft")
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
                                            </div><br>
                                            @if(!empty($acceptances) && count($acceptances) > 0)
    @if($acceptances[0]->action_for_author == 'View')
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h4>Generate the Acceptance Letter</h4><br>
                <div class="">
                    <table class="table table-bordered table-hover sys_table">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th width="65%">Manuscript Title</th>
                                <th class="text-center">Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($rows) && count($rows) > 0)
                                <tr>
                                    <td class="text-center">{{$rows[0]->journal_short_form}}-0000{{ $rows[0]->id }}</td>
                                    <td width="65%">{{$rows[0]->title}}</td>
                                    <td class="text-center"><a href="{{url('dashboard/admin/submission/acceptance_letter/'.$rows[0]->id)}}" class="btn btn-blue upload_file waves-effect waves-light" id="accept_save"><i class="fa fa-download"></i> Download</a></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endif


                                        </div>

                                        <div id="copyrights" class="tab-pane fade ib-tab-box">
                                            <h4>Generate the Copyright Form</h4>
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="">
                                                        <table class="table table-bordered table-hover sys_table">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">ID</th>
                                                                    <th width="65%">Manuscript Title</th>
                                                                    <th class="text-center">Manage</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <td class="text-center">{{$rows[0]->journal_short_form}}-0000{{ $rows[0]->id }}</td>
                                                                <td width="65%">{{$rows[0]->title}}</td>
                                                                <td class="text-center"><a href="{{url('dashboard/admin/submission/copyright_form/'.$rows[0]->id)}}" class="btn btn-blue upload_file waves-effect waves-light" id="accept_save"><i class="fa fa-download"></i> Download</a></td>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div id="profile" class="tab-pane fade ib-tab-box">


    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <!-- Include Flash Messages -->
                    @include('admin.inc.message')
                </div>

                <div class="card-body">
                  <h4 class="header-title">{{ $profile_title }} Setting</h4>
                  <br/>

                  <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                        <a href="#profile-tab" data-toggle="tab" aria-expanded="false" class="nav-link active">
                            Profile Info
                        </a>
                    </li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane show active" id="profile-tab">

                      @foreach( $rows as $row )
                      <!-- Form Start -->
                      <form class="needs-validation" novalidate action="{{ URL::route('author.'.$profile_url.'.update', $profile_rows->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                          <div class="form-group col-md-6">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $profile_rows->name }}" placeholder="Profile Name" required>

                            <div class="invalid-feedback">
                              Please Provide Profile Name.
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ $profile_rows->email }}" placeholder="Email" disabled>

                            <div class="invalid-feedback">
                              Please Provide Email Address.
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="form-group col-md-6">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" name="phone" id="phone" value="{{ $profile_rows->phone }}" placeholder="Phone">

                            <div class="invalid-feedback">
                              Please Provide Phone Number.
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" name="address" id="address" value="{{ $profile_rows->address }}" placeholder="Address" required>

                            <div class="invalid-feedback">
                              Please Provide Address.
                            </div>
                          </div>
                        </div>

                        {{-- <div class="row">
                          <div class="form-group col-md-6">
                            <label for="dob">Date Of Birth</label>
                            <input type="date" class="form-control" name="dob" id="dob" value="{{ $profile_rows->dob }}" placeholder="Date Of Birth" required>

                            <div class="invalid-feedback">
                              Please Provide Date Of Birth.
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="image">Photo</label>
                            <input type="file" class="form-control" name="image" id="image" placeholder="Photo">

                            <div class="invalid-feedback">
                              Please Provide Profile Photo.
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                            <label for="details">Profile Details</label>
                            <textarea class="form-control summernote" name="details" id="details" rows="8">{!! $row->profile !!}</textarea>
                        </div> --}}

                        <div class="form-group">
                            <button type="submit" class="btn btn-blue upload_file waves-effect waves-light">Save Changes</button>
                        </div>

                      </form>
                      <!-- Form End -->
                      @endforeach

                    </div>
                  </div>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->


                                        </div>

                                        <div id="payments" class="tab-pane fade ib-tab-box">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <h4>Payment</h4>
                                                    <div class="">

                                                        @php
                                                            if(!empty($rows[0]->payment_status)){
                                                                $data = $rows[0]->payment_status;
                                                                $method = substr($data, strpos($data, "-") + 1);
                                                                $paymentstatus = strtok($data, '-');

                                                            }
                                                        @endphp
                                                        @if ($rows[0]->journal_short_form == "IJIRE")
                                                        <table class="table table-bordered table-hover sys_table">

                                                            <thead>
                                                                <tr>
                                                                    <th>Journal</th>
                                                                    <th width="36%">Author</th>
                                                                    <th>Amount</th>
                                                                    <th>Payment Method</th>
                                                                    <th <?php if(empty($rows[0]->payment_status)){echo 'hidden';} ?> class="text-center">Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr <?php if(!empty($rows[0]->payment_status)){if($method == 1){}else{echo 'hidden';}} ?>>
                                                                    <td class="text-center">{{$rows[0]->journal_short_form}}</td>
                                                                    <td width="36%">For Indian Author</td>
                                                                    <td>
                                                                    <b>INR {{$payment_data['Indian']['IJIRE']['withoutdoi']}}</b>
                                                                            <ul>
                                                                            <li>APC + {{$gst}}% GST</li>
                                                                            <li>Without DOI</li>
                                                                            <li>Online Publication</li>
                                                                            <li>Max. 10 to 20 pages</li>
                                                                            <li>E-Certificate(All Authors)</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td><form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_IipnD9qYVU6uIJ" async> </script> </form></td>
                                                                    <td <?php if(empty($rows[0]->payment_status)){echo 'hidden';} ?> class="text-center">
                                                                        @php
                                                                        if(!empty($rows[0]->payment_status)){
                                                                            if($paymentstatus == 'paid'){
                                                                                echo '<span class="badge badge-pill" style="background-color:green; color:#ffffff;border:1px solid green">Paid</span>';
                                                                            }else{
                                                                                echo '<span class="badge badge-pill" style="background-color:red; color:#ffffff;border:1px solid red">Un Paid</span>';
                                                                            }
                                                                        }
                                                                        @endphp
                                                                    </td>
                                                                </tr>
                                                                <tr <?php if(!empty($rows[0]->payment_status)){if($method == 2){}else{echo 'hidden';}} ?>>
                                                                    <td class="text-center">{{$rows[0]->journal_short_form}}</td>
                                                                    <td width="36%">For Indian Author</td>
                                                                    <td>
                                                                    <b>INR {{$payment_data['Indian']['IJIRE']['withdoi']}}</b>
                                                                            <ul>
                                                                            <li>APC + {{$gst}}% GST</li>
                                                                            <li>With DOI(10.59256)</li>
                                                                            <li>Online Publication</li>
                                                                            <li>Max. 10 to 20 pages</li>
                                                                            <li>E-Certificate(All Authors)</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td><form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_LX1iJCBW4Sof5t" async> </script> </form></td>
                                                                    <td <?php if(empty($rows[0]->payment_status)){echo 'hidden';} ?> class="text-center">
                                                                        @php
                                                                        if(!empty($rows[0]->payment_status)){
                                                                            if($paymentstatus == 'paid'){
                                                                                echo '<span class="badge badge-pill" style="background-color:green; color:#ffffff;border:1px solid green">Paid</span>';
                                                                            }else{
                                                                                echo '<span class="badge badge-pill" style="background-color:red; color:#ffffff;border:1px solid red">Un Paid</span>';
                                                                            }
                                                                        }
                                                                        @endphp
                                                                    </td>
                                                                </tr>
                                                                <tr <?php if(!empty($rows[0]->payment_status)){if($method == 3){}else{echo 'hidden';}} ?>>
                                                                    <td class="text-center">{{$rows[0]->journal_short_form}}</td>
                                                                    <td width="36%">For Foreign Author </td>
                                                                    <td>
                                                                    <b>USD {{$payment_data['Others']['IJIRE']['withdoi']}}</b>
                                                                            <ul>
                                                                            <li>With DOI(10.59256)</li>
                                                                            <li>Online Publication</li>
                                                                            <li>Max. 10 to 20 pages</li>
                                                                            <li>E-Certificate(All Authors)</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td><form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_IipweXrOIDJtu1" async> </script> </form></td>
                                                                    <td <?php if(empty($rows[0]->payment_status)){echo 'hidden';} ?> class="text-center">
                                                                        @php
                                                                        if(!empty($rows[0]->payment_status)){
                                                                            if($paymentstatus == 'paid'){
                                                                                echo '<span class="badge badge-pill" style="background-color:green; color:#ffffff;border:1px solid green">Paid</span>';
                                                                            }else{
                                                                                echo '<span class="badge badge-pill" style="background-color:red; color:#ffffff;border:1px solid red">Un Paid</span>';
                                                                            }
                                                                        }
                                                                        @endphp
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                        <div class="row">
                                                            <div class="col-md-12 col-sm-12">
                                                                <h4>Payment through Bank:</h4><br>
                                                                <p><strong>A/C Name (payable to): </strong>Fifth Dimension Research Publication Private Limited</p>
                                                                <p><strong>Account no: </strong>807620110000250</p>
                                                                <p><strong>Name of the Bank: </strong> Bank of India</p>
                                                                <p><strong>BRANCH: </strong> Ariyalur</p>
                                                                <p><strong>BR.CODE: </strong> 008076</p>
                                                                <p><strong>MICR code: </strong> 621013002</p>
                                                                <p><strong>IFSC No: </strong> BKID0008076</p>
                                                            </div>
                                                        </div>

                                                        @elseif($rows[0]->journal_short_form == "IJSREAT")
                                                        <table class="table table-bordered table-hover sys_table">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">Journal</th>
                                                                    <th width="36%">Author</th>
                                                                    <th>Amount</th>
                                                                    <th>Payment Method</th>
                                                                    <th <?php if(empty($rows[0]->payment_status)){echo 'hidden';} ?> class="text-center">Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr <?php if(!empty($rows[0]->payment_status)){if($method == 1){}else{echo 'hidden';}} ?>>
                                                                    <td class="text-center">{{$rows[0]->journal_short_form}}</td>
                                                                    <td width="36%">For Indian Author</td>
                                                                    <td>
                                                                    <b>INR {{$payment_data['Indian']['IJSREAT']['withoutdoi']}}</b>
                                                                            <ul>
                                                                            <li>APC + {{$gst}}% GST</li>
                                                                            <li>Without DOI</li>
                                                                            <li>Online Publication</li>
                                                                            <li>Max. 10 to 20 pages</li>
                                                                            <li>E-Certificate(All Authors)</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td><form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_M5F2CxmT6aHnMg" async> </script> </form></td>
                                                                    <td <?php if(empty($rows[0]->payment_status)){echo 'hidden';} ?> class="text-center">
                                                                        @php
                                                                        if(!empty($rows[0]->payment_status)){
                                                                            if($paymentstatus == 'paid'){
                                                                                echo '<span class="badge badge-pill" style="background-color:green; color:#ffffff;border:1px solid green">Paid</span>';
                                                                            }else{
                                                                                echo '<span class="badge badge-pill" style="background-color:red; color:#ffffff;border:1px solid red">Un Paid</span>';
                                                                            }
                                                                        }
                                                                        @endphp
                                                                    </td>
                                                                </tr>

                                                                <tr <?php if(!empty($rows[0]->payment_status)){if($method == 2){}else{echo 'hidden';}} ?>>
                                                                    <td class="text-center">{{$rows[0]->journal_short_form}}</td>
                                                                    <td width="36%">For Indian Author</td>
                                                                    <td>
                                                                    <b>INR {{$payment_data['Indian']['IJSREAT']['withdoi']}}</b>
                                                                            <ul>
                                                                            <li>APC + {{$gst}}% GST</li>
                                                                            <li>With DOI(10.59256)</li>
                                                                            <li>Online Publication</li>
                                                                            <li>Max. 10 to 20 pages</li>
                                                                            <li>E-Certificate(All Authors)</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td><form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_M5F4CjwVqlcI0D" async> </script> </form></td>
                                                                    <td <?php if(empty($rows[0]->payment_status)){echo 'hidden';} ?> class="text-center">
                                                                        @php
                                                                        if(!empty($rows[0]->payment_status)){
                                                                            if($paymentstatus == 'paid'){
                                                                                echo '<span class="badge badge-pill" style="background-color:green; color:#ffffff;border:1px solid green">Paid</span>';
                                                                            }else{
                                                                                echo '<span class="badge badge-pill" style="background-color:red; color:#ffffff;border:1px solid red">Un Paid</span>';
                                                                            }
                                                                        }
                                                                        @endphp
                                                                    </td>
                                                                </tr>
                                                                <tr <?php if(!empty($rows[0]->payment_status)){if($method == 3){}else{echo 'hidden';}} ?>>
                                                                    <td class="text-center">{{$rows[0]->journal_short_form}}</td>
                                                                    <td width="36%">For Foreign Author </td>
                                                                    <td>
                                                                    <b>USD {{$payment_data['Others']['IJSREAT']['withdoi']}}</b>
                                                                            <ul>
                                                                            <li>With DOI(10.59256)</li>
                                                                            <li>Online Publication</li>
                                                                            <li>Max. 10 to 20 pages</li>
                                                                            <li>E-Certificate(All Authors)</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td><form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_M5F5sakrcOOelN" async> </script> </form></td>
                                                                    <td <?php if(empty($rows[0]->payment_status)){echo 'hidden';} ?> class="text-center">
                                                                        @php
                                                                        if(!empty($rows[0]->payment_status)){
                                                                            if($paymentstatus == 'paid'){
                                                                                echo '<span class="badge badge-pill" style="background-color:green; color:#ffffff;border:1px solid green">Paid</span>';
                                                                            }else{
                                                                                echo '<span class="badge badge-pill" style="background-color:red; color:#ffffff;border:1px solid red">Un Paid</span>';
                                                                            }
                                                                        }
                                                                        @endphp
                                                                    </td>
                                                                </tr>

                                                            </tbody>

                                                        </table>
                                                        <div class="row">
                                                            <div class="col-md-12 col-sm-12">
                                                                <h4>Payment through Bank:</h4><br>
                                                                <p><strong>A/C Name (payable to): </strong>Fifth Dimension Research Publication Private Limited</p>
                                                                <p><strong>Account no: </strong>807620110000250</p>
                                                                <p><strong>Name of the Bank: </strong> Bank of India</p>
                                                                <p><strong>BRANCH: </strong> Ariyalur</p>
                                                                <p><strong>BR.CODE: </strong> 008076</p>
                                                                <p><strong>MICR code: </strong> 621013002</p>
                                                                <p><strong>IFSC No: </strong> BKID0008076</p>
                                                            </div>
                                                        </div>
                                                        @elseif($rows[0]->journal_short_form == "IJRTMR")
                                                        <table class="table table-bordered table-hover sys_table">

                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">Journal</th>
                                                                    <th width="36%">Author</th>
                                                                    <th>Amount</th>
                                                                    <th>Payment Method</th>
                                                                    <th <?php if(empty($rows[0]->payment_status)){echo 'hidden';} ?> class="text-center">Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr <?php if(!empty($rows[0]->payment_status)){if($method == 1){}else{echo 'hidden';}} ?>>
                                                                    <td class="text-center">{{$rows[0]->journal_short_form}}</td>
                                                                    <td width="36%">For Indian Author</td>
                                                                    <td>
                                                                    <b>INR {{$payment_data['Indian']['IJRTMR']['withoutdoi']}}</b>
                                                                            <ul>
                                                                            <li>APC + {{$gst}}% GST</li>
                                                                            <li>Without DOI</li>
                                                                            <li>Online Publication</li>
                                                                            <li>Max. 10 to 20 pages</li>
                                                                            <li>E-Certificate(All Authors)</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td><form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_JpkQFEvwU2gNfk" async> </script> </form></td>
                                                                    <td <?php if(empty($rows[0]->payment_status)){echo 'hidden';} ?> class="text-center">
                                                                        @php
                                                                        if(!empty($rows[0]->payment_status)){
                                                                            if($paymentstatus == 'paid'){
                                                                                echo '<span class="badge badge-pill" style="background-color:green; color:#ffffff;border:1px solid green">Paid</span>';
                                                                            }else{
                                                                                echo '<span class="badge badge-pill" style="background-color:red; color:#ffffff;border:1px solid red">Un Paid</span>';
                                                                            }
                                                                        }
                                                                        @endphp
                                                                    </td>
                                                                </tr>
                                                                <tr <?php if(!empty($rows[0]->payment_status)){if($method == 2){}else{echo 'hidden';}} ?>>
                                                                    <td class="text-center">{{$rows[0]->journal_short_form}}</td>
                                                                    <td width="36%">For Indian Author</td>
                                                                    <td>
                                                                    <b>INR {{$payment_data['Indian']['IJRTMR']['withdoi']}}</b>
                                                                            <ul>
                                                                            <li>APC + {{$gst}}% GST</li>
                                                                            <li>With DOI(10.59256)</li>
                                                                            <li>Online Publication</li>
                                                                            <li>Max. 10 to 20 pages</li>
                                                                            <li>E-Certificate(All Authors)</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td><form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_M5Ez1eyaihQTLe" async> </script> </form></td>
                                                                    <td <?php if(empty($rows[0]->payment_status)){echo 'hidden';} ?> class="text-center">
                                                                        @php
                                                                        if(!empty($rows[0]->payment_status)){
                                                                            if($paymentstatus == 'paid'){
                                                                                echo '<span class="badge badge-pill" style="background-color:green; color:#ffffff;border:1px solid green">Paid</span>';
                                                                            }else{
                                                                                echo '<span class="badge badge-pill" style="background-color:red; color:#ffffff;border:1px solid red">Un Paid</span>';
                                                                            }
                                                                        }
                                                                        @endphp
                                                                    </td>
                                                                </tr>
                                                                <tr <?php if(!empty($rows[0]->payment_status)){if($method == 3){}else{echo 'hidden';}} ?>>
                                                                    <td class="text-center">{{$rows[0]->journal_short_form}}</td>
                                                                    <td width="36%">For Foreign Author </td>
                                                                    <td>
                                                                    <b>USD {{$payment_data['Others']['IJRTMR']['withdoi']}}</b>
                                                                            <ul>
                                                                            <li>With DOI(10.59256)</li>
                                                                            <li>Online Publication</li>
                                                                            <li>Max. 10 to 20 pages</li>
                                                                            <li>E-Certificate(All Authors)</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td><form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_Jpkf3lSqoVoUyG" async> </script> </form></td>
                                                                    <td <?php if(empty($rows[0]->payment_status)){echo 'hidden';} ?> class="text-center">
                                                                        @php
                                                                        if(!empty($rows[0]->payment_status)){
                                                                            if($paymentstatus == 'paid'){
                                                                                echo '<span class="badge badge-pill" style="background-color:green; color:#ffffff;border:1px solid green">Paid</span>';
                                                                            }else{
                                                                                echo '<span class="badge badge-pill" style="background-color:red; color:#ffffff;border:1px solid red">Un Paid</span>';
                                                                            }
                                                                        }
                                                                        @endphp
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                        <div class="row">
                                                            <div class="col-md-12 col-sm-12">
                                                                <h4>Payment through Bank:</h4><br>
                                                                <p><strong>A/C Name (payable to): </strong>Fifth Dimension Research Publication Private Limited</p>
                                                                <p><strong>Account no: </strong>807620110000250</p>
                                                                <p><strong>Name of the Bank: </strong> Bank of India</p>
                                                                <p><strong>BRANCH: </strong> Ariyalur</p>
                                                                <p><strong>BR.CODE: </strong> 008076</p>
                                                                <p><strong>MICR code: </strong> 621013002</p>
                                                                <p><strong>IFSC No: </strong> BKID0008076</p>
                                                            </div>
                                                        </div>
                                                        @elseif($rows[0]->journal_short_form == "INDJCST")
                                                        <table class="table table-bordered table-hover sys_table">

                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">Journal</th>
                                                                    <th width="36%">Author</th>
                                                                    <th>Amount</th>
                                                                    <th>Payment Method</th>
                                                                    <th <?php if(empty($rows[0]->payment_status)){echo 'hidden';} ?> class="text-center">Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr <?php if(!empty($rows[0]->payment_status)){if($method == 1){}else{echo 'hidden';}} ?>>
                                                                    <td class="text-center">{{$rows[0]->journal_short_form}}</td>
                                                                    <td width="36%">For Indian Author</td>
                                                                    <td>
                                                                    <b>INR {{$payment_data['Indian']['INDJCST']['withoutdoi']}}</b>
                                                                            <ul>
                                                                            <li>APC + {{$gst}}% GST</li>
                                                                            <li>Without DOI</li>
                                                                            <li>Online Publication</li>
                                                                            <li>Max. 10 to 20 pages</li>
                                                                            <li>E-Certificate(All Authors)</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td><form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_M5F85UY7YjjGuv" async> </script> </form></td>
                                                                    <td <?php if(empty($rows[0]->payment_status)){echo 'hidden';} ?> class="text-center">
                                                                        @php
                                                                        if(!empty($rows[0]->payment_status)){
                                                                            if($paymentstatus == 'paid'){
                                                                                echo '<span class="badge badge-pill" style="background-color:green; color:#ffffff;border:1px solid green">Paid</span>';
                                                                            }else{
                                                                                echo '<span class="badge badge-pill" style="background-color:red; color:#ffffff;border:1px solid red">Un Paid</span>';
                                                                            }
                                                                        }
                                                                        @endphp
                                                                    </td>
                                                                </tr>
                                                                <tr <?php if(!empty($rows[0]->payment_status)){if($method == 2){}else{echo 'hidden';}} ?>>
                                                                    <td class="text-center">{{$rows[0]->journal_short_form}}</td>
                                                                    <td width="36%">For Indian Author</td>
                                                                    <td>
                                                                    <b>INR {{$payment_data['Indian']['INDJCST']['withdoi']}}</b>
                                                                            <ul>
                                                                                <li>APC + {{$gst}}% GST</li>
                                                                            <li>With DOI(10.59256)</li>
                                                                            <li>Online Publication</li>
                                                                            <li>Max. 10 to 20 pages</li>
                                                                            <li>E-Certificate(All Authors)</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td><form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_M5FAsn5wP7RItB" async> </script> </form></td>
                                                                    <td <?php if(empty($rows[0]->payment_status)){echo 'hidden';} ?> class="text-center">
                                                                        @php
                                                                        if(!empty($rows[0]->payment_status)){
                                                                            if($paymentstatus == 'paid'){
                                                                                echo '<span class="badge badge-pill" style="background-color:green; color:#ffffff;border:1px solid green">Paid</span>';
                                                                            }else{
                                                                                echo '<span class="badge badge-pill" style="background-color:red; color:#ffffff;border:1px solid red">Un Paid</span>';
                                                                            }
                                                                        }
                                                                        @endphp
                                                                    </td>
                                                                </tr>
                                                                <tr <?php if(!empty($rows[0]->payment_status)){if($method == 3){}else{echo 'hidden';}} ?>>
                                                                    <td class="text-center">{{$rows[0]->journal_short_form}}</td>
                                                                    <td width="36%">For Foreign Author </td>
                                                                    <td>
                                                                    <b>USD {{$payment_data['Others']['INDJCST']['withdoi']}}</b>
                                                                            <ul>
                                                                            <li>With DOI(10.59256)</li>
                                                                            <li>Online Publication</li>
                                                                            <li>Max. 10 to 20 pages</li>
                                                                            <li>E-Certificate(All Authors)</li>
                                                                        </ul>
                                                                    </td>
                                                                    <td><form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_M5FCQIre57PUpW" async> </script> </form></td>
                                                                    <td <?php if(empty($rows[0]->payment_status)){echo 'hidden';} ?> class="text-center">
                                                                        @php
                                                                        if(!empty($rows[0]->payment_status)){
                                                                            if($paymentstatus == 'paid'){
                                                                                echo '<span class="badge badge-pill" style="background-color:green; color:#ffffff;border:1px solid green">Paid</span>';
                                                                            }else{
                                                                                echo '<span class="badge badge-pill" style="background-color:red; color:#ffffff;border:1px solid red">Un Paid</span>';
                                                                            }
                                                                        }
                                                                        @endphp
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                        <div class="row">
                                                            <div class="col-md-12 col-sm-12">
                                                                <h4>Payment through Bank:</h4><br>
                                                                <p><strong>A/C Name (payable to): </strong>Fifth Dimension Research Publication Private Limited</p>
                                                                <p><strong>Account no: </strong>807620110000250</p>
                                                                <p><strong>Name of the Bank: </strong> Bank of India</p>
                                                                <p><strong>BRANCH: </strong> Ariyalur</p>
                                                                <p><strong>BR.CODE: </strong> 008076</p>
                                                                <p><strong>MICR code: </strong> 621013002</p>
                                                                <p><strong>IFSC No: </strong> BKID0008076</p>
                                                            </div>
                                                        </div>
                                                        @elseif($rows[0]->journal_short_form == "INDJEEE" or $rows[0]->journal_short_form == "INDJECE")
                                                        <p>
                                                        There Are No Submission Fees, Publication Fees Or Page Charges For This Journal. Colour Figures Will Be Reproduced In Colour In Your Online Article Free Of Charge.
                                                        </p>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            

                                        </div>

                                        <div id="final_submission" class="tab-pane fade ib-tab-box">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body">
                                                            <p><span style="color:#ff0000;"><strong>Note:</strong></span></p>
                                                            <hr>
                                                            <p>Once you&#8217;re Article Accepted for Publication, Author have to submit below mentioned Documents within a Week.
</p>
                                                            <ol>
                                                            <li><strong>Copyright form</strong>&#160;(before generating copyright form-Author have to update profile. Like, Address, Date of Birth etc. then only copyright form will generate. Take print out, manually corresponding author have to signature)</li>
                                                            <li><strong>Final Manuscript</strong>&#160;(As per our journal format)
    <a href="{{ asset('uploads/final_submission/finalsubmission.docx') }}" download>Click here to Download</a>
</li>                                                            <li><strong>Article Processing fee receipt</strong>&#160;(with DOI, Without DOI)</li>
                                                            </ol>
                                                            <p>Once we received all necessary Documents. We will process your article. Article will publish with in&#160;<strong>24hrs </strong>to <strong>48hrs</strong>.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body">
                                                            <h4>Final Manuscript: </h4>
                                                            <a data-toggle="modal" href="#final_manuscript" class="btn btn-blue upload_file waves-effect waves-light" id="upload_file"><i class="fa fa-plus"></i> New File Upload</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="final_manuscript" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form class="needs-validation" novalidate action="{{url('dashboard/admin/submission/final_submission_manuscript/'.$rows[0]->id)}}" method="post" enctype="multipart/form-data">
                                                            @csrf

                                                        <div class="modal-header">
                                                            <h4 class="modal-title"><i class="fa fa-upload"></i> Manuscript Upload</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label>Drop File Here</label>
                                                                    <input class="form-control" type="file" name="file" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
                                                            <button type="submit" id="btn_add_file" class="btn btn-blue upload_file waves-effect waves-light">Submit</button>
                                                        </div>
                                                      </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <hr>
                                                    <div class="">
                                                        <table class="table table-bordered table-hover sys_table">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">#</th>
                                                                    <th width="65%">Title</th>
                                                                    <th>Created At</th>
                                                                    <th class="text-center" style="width:125px;">Manage</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($final_manuscripts as $key => $row)
                                                                <tr>
                                                                    <td class="text-center">{{$key + 1}}</td>
                                                                    <td width="65%">{{$row->doc_title}}</td>
                                                                    <td>{{$row->create_at}}</td>
                                                                    <td class="text-center" style="width:125px;">
                                                                        {{-- download copyrigth form --}}
                                                                        @if(is_file('uploads/final_submission/'.$row->file_path))
                                                                        <a href="{{ asset('uploads/final_submission/'.$row->file_path) }}" download><button type="button" class="btn btn-sm btn-success"><i class="fa fa-download"></i>
                                                                        </button></a>
                                                                        @endif
                                                                        @if ($row->freeze_data == 0)
                                                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal-{{ $row->id }}">
                                                                            <i class="far fa-edit"></i>
                                                                        </button>
                                                                        @include('author.files_edit.final_submission_manuscript')
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body">
                                                            <h4>Copyrights Form: </h4>
                                                            <a data-toggle="modal" href="#final_copy_rights" class="btn btn-blue upload_file waves-effect waves-light" id="upload_file"><i class="fa fa-plus"></i> New File Upload</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div id="final_copy_rights" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form class="needs-validation" novalidate action="{{url('dashboard/admin/submission/final_submission_copyright_form/'.$rows[0]->id)}}" method="post" enctype="multipart/form-data">
                                                            @csrf

                                                        <div class="modal-header">
                                                            <h4 class="modal-title"><i class="fa fa-upload"></i> Copy Right Forms Upload</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label>Drop File Here</label>
                                                                    <input class="form-control" type="file" name="file" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
                                                            <button type="submit" id="btn_add_file" class="btn btn-blue upload_file waves-effect waves-light">Submit</button>
                                                        </div>
                                                      </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="">
                                                        <table class="table table-bordered table-hover sys_table">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">#</th>
                                                                    <th width="65%">Title</th>
                                                                    <th>Created At</th>
                                                                    <th class="text-center" style="width:125px;">Manage</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($final_copy_right_forms as $key => $row)
                                                                <tr>
                                                                    <td class="text-center">{{$key + 1}}</td>
                                                                    <td width="65%">{{$row->doc_title}}</td>
                                                                    <td>{{$row->create_at}}</td>
                                                                    <td class="text-center" style="width:125px;">
                                                                        {{-- download copyrigth form --}}
                                                                        @if(is_file('uploads/final_submission/'.$row->file_path))
                                                                        <a href="{{ asset('uploads/final_submission/'.$row->file_path) }}" download><button type="button" class="btn btn-sm btn-success"><i class="fa fa-download"></i>
                                                                        </button></a>
                                                                        @endif
                                                                        @if ($row->freeze_data == 0)
                                                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal-{{ $row->id }}">
                                                                                <i class="far fa-edit"></i>
                                                                        </button>
                                                                        @include('author.files_edit.final_submission_manuscript')
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body">
                                                            <h4>Payment Receipt: </h4>
                                                            <a data-toggle="modal" href="#payment_script" class="btn btn-blue upload_file waves-effect waves-light" id="upload_file"><i class="fa fa-plus"></i> New File Upload</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div id="payment_script" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form class="needs-validation" novalidate action="{{url('dashboard/admin/submission/final_submission_payment_manuscript/'.$rows[0]->id)}}" method="post" enctype="multipart/form-data">
                                                            @csrf

                                                        <div class="modal-header">
                                                            <h4 class="modal-title"><i class="fa fa-upload"></i> Payment Manuscript Upload</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label>Drop File Here</label>
                                                                    <input class="form-control" type="file" name="file" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
                                                            <button type="submit" id="btn_add_file" class="btn btn-blue upload_file waves-effect waves-light">Submit</button>
                                                        </div>
                                                      </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="">
                                                        <table class="table table-bordered table-hover sys_table" style="width:100%">

                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">#</th>
                                                                    <th width="65%">Title</th>
                                                                    <th>Created At</th>
                                                                    <th class="text-center" style="width:125px;">Manage</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($final_payment_scripts as $key => $row)
                                                                <tr>
                                                                    <td class="text-center">{{$key + 1}}</td>
                                                                    <td width="65%">{{$row->doc_title}}</td>
                                                                    <td>{{$row->create_at}}</td>
                                                                    <td class="text-center" style="width:125px;">
                                                                        {{-- download copyrigth form --}}
                                                                        @if(is_file('uploads/final_submission/'.$row->file_path))
                                                                        <a href="{{ asset('uploads/final_submission/'.$row->file_path) }}" download><button type="button" class="btn btn-sm btn-success"><i class="fa fa-download"></i>
                                                                        </button></a>
                                                                        @endif
                                                                        @if ($row->freeze_data == 0)
                                                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal-{{ $row->id }}">
                                                                            <i class="far fa-edit"></i>
                                                                        </button>
                                                                        @include('author.files_edit.final_submission_manuscript')
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12" align="center">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body">
                                                            {{-- <h4>After </h4> --}}
                                                            <a href="{{ URL::route('final_submission.freeze', $rows[0]->id) }}" class="btn btn-blue upload_file waves-effect waves-light"> Final Submit</a>
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
</div>

 {{-- <script type="text/javascript" src="https://editorial.paperscript.io/ui/lib/modal.js"></script> --}}
 <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>
    $(document).ready(function () {
  $('#nav-tab a[href="#{{ old('tab') }}"]').tab('show')
});
</script>
@endsection
