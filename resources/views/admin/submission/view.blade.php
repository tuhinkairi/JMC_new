@extends('admin.layouts.master')
@section('title', $title)
@section('content')

    <style>
        /* Optional: Add some styling to visually hide the option */
        option[style*="display:none"] {
            display: none;
        }

        #due_date {
            width: 150px;
            /* Adjust the width as needed */
            height: 30px;
            /* Adjust the height as needed */
        }

        .alert-modal {
            display: none;
            position: fixed;
            top: 10px;
            right: 10px;
            width: 300px;
            padding: 13px;
            background-color: #25b343 !important;
            color: #fff;
            z-index: 9999;
            text-align: center;
            box-shadow: 1px 0px 10px rgba(1, 0, 0, 0.5);
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .show {
            display: block;
        }

        .kanban-board {
            display: flex;
        }

        .kanban-column {
            flex: 1;
            margin: 10px;
            background-color: #f7f7f7;
            border-radius: 3px;
            box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            min-width: 140px;
            text-align: center;
        }

        .kanban-column-header-not-started {
            background-color: #ff3300;
            color: #ffffff;
            padding: 10px;
            font-weight: bold;
        }

        .kanban-column-header-in-progress {
            background-color: #4da6ff;
            color: #ffffff;
            padding: 10px;
            font-weight: bold;
        }

        .kanban-column-header-completed {
            background-color: #008000;
            color: #ffffff;
            padding: 10px;
            font-weight: bold;
        }

        .kanban-column-header-deferred {
            background-color: #264d73;
            color: #ffffff;
            padding: 10px;
            font-weight: bold;
        }


        .kanban-column-header-editor-approval {
            background-color: #7a7a52;
            color: #ffffff;
            padding: 10px;
            font-weight: bold;
        }

        .kanban-column-cards {
            min-height: 100px;
            padding: 10px;
        }

        .kanban-card {
            background-color: #fff;
            border-radius: 3px;
            box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
            padding: 10px;
        }

        .kanban-card-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .kanban-card-description {
            color: #999;
            font-size: 14px;
        }

        .staff-profile-image-small {
            height: 32px;
            width: 32px;
            border-radius: 50%;
        }

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

        .payment-btn {
            color: #fff !important;
            background: #007bff;
            border: none;
            border-radius: 20px;
            cursor: pointer;
        }

        .payment-btn:hover {
            background: #009ff0;
        }
    </style>

    <div class="row ">
        <div class="col-xl-12 col-lg-12 position-relative">
            <div class="card-body p-0">
                <div class="px-3 pt-3">
                    <div class="card">
                        <div class="card-header">
                            <!-- Include Flash Messages -->
                            @include('admin.inc.message')
                        </div>
                        <div class="col-md-12">
                            <div class="ibox">
                                <div class="alert-modal" id="alert-modal">
                                    <span class="close-btn" onclick="closeAlertModal()">&times;</span>
                                    <p id="alert-message"></p>
                                </div>
                                <form onsubmit="handelSubmit(event)"
                                    action="{{ URL::route($url . '.update', $rows[0]->id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="ibox-content">
                                        <p class="col-12 mb-0 pt-2"><strong>ID:
                                            </strong>{{$rows[0]->journal_short_form}}-0000{{ $rows[0]->id }}&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Title:
                                            </strong>{{$rows[0]->title}}&nbsp;&nbsp;&nbsp;&nbsp;

                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;




                                        </p>
                                        <hr>
                                        <div class="card-header pb-0 px-2 bg-light border-bottom-0">
                                            <ul class="nav nav-tabs col-20" id="nav-tab">
                                                <li class="nav-item">
                                                    <a data-toggle="tab" class="nav-link active" href="#details"><i
                                                            class="fa fa-th"></i> Details</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a data-toggle="tab" class="nav-link" href="#tasks"><i
                                                            class="fa fa-tasks"></i> Tasks</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a data-toggle="tab" class="nav-link" href="#files"><i
                                                            class="fa fa-upload"></i> Files</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a data-toggle="tab" class="nav-link" href="#review"><i
                                                            class="fa fa-check" aria-hidden="true"></i> Review</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a data-toggle="tab" class="nav-link" href="#acceptance"><i
                                                            class="fa fa-check-circle"></i> Acceptance</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a data-toggle="tab" class="nav-link" href="#copyrights"><i
                                                            class="fa fa-copyright"></i> Copy Rights</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a data-toggle="tab" class="nav-link" href="#payments"><i
                                                            class="fa fa-credit-card"></i> Payment</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a data-toggle="tab" class="nav-link" href="#final_submission"><i
                                                            class="fa fa-object-group" aria-hidden="true"></i> Final
                                                        Submission</a>
                                                </li>




                                                @if($previous_id !== null)
                                                    <li class="nav-item" onclick="godefault()">
                                                        <a class="nav-link"
                                                            href="{{ url('dashboard/admin/submission/show/' . $previous_id) }}"><i
                                                                class="fas fa-chevron-left"></i> Previous</a>
                                                    </li>
                                                @endif



                                                @if($next_id !== null)
                                                    <li class="nav-item " onclick="godefault()">
                                                        <a class="nav-link"
                                                            href="{{ url('dashboard/admin/submission/show/' . $next_id) }}"><i
                                                                class="fas fa-chevron-right"></i> Next</a>
                                                    </li>
                                                @endif




                                                {{-- <li class="nav-item">
                                                    <a data-toggle="tab" class="nav-link" href="#comments"><i
                                                            class="fa fa-comments"></i> Communication</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a data-toggle="tab" class="nav-link" href="#history"><i
                                                            class="fa fa-history"></i> History</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a data-toggle="tab" class="nav-link" href="#others"><i
                                                            class="fa fa-envelope-square" aria-hidden="true"></i> Other
                                                        Submission</a>
                                                </li> --}}
                                            </ul>
                                        </div>
                                        <div class="card-body p-2">

                                            <div class="tab-content">
                                                <div id="details" class="tab-pane ib-tab-box active">
                                                    <div class="row">
                                                        <div class="col-md-12">

                                                            <div class="row">
                                                                <div class="col-md-4 col-xs-12"
                                                                    style="margin-bottom: 10px;">
                                                                    <p class="mb-0">
                                                                        <strong>Status</strong>:

                                                                        {{-- <span class="badge badge-pill"
                                                                            style="color:red;border:1px solid red">hiasdjhajshdkjh</span>
                                                                        --}}
                                                                        @if(isset($selected[0]->statusname))
                                                                            <span class="badge badge-pill"
                                                                                style="background-color:{{$selected[0]->colourflag}}; color:#ffffff;border:1px solid {{$selected[0]->colourflag}}">{{$selected[0]->statusname}}</span>
                                                                        @else
                                                                            <span class="label label-primary"
                                                                                id='priority_status'
                                                                                style="color:red;border:1px solid red">-</span>
                                                                        @endif
                                                                    </p>
                                                                </div>

                                                                <div class="col-md-4 col-xs-12"
                                                                    style="margin-bottom: 10px;">
                                                                    <p class="mb-0">
                                                                        <strong>Mode of Processing</strong>:
                                                                        @if(isset($selected[0]->processingname))
                                                                            <span class="label label-primary"
                                                                                id='priority_status'
                                                                                style="color:#2196f3;">{{$selected[0]->processingname}}</span>
                                                                        @else
                                                                            <span class="label label-primary"
                                                                                id='priority_status'
                                                                                style="color:#2196f3;">-</span>
                                                                        @endif
                                                                        {{-- <span class="label label-primary"
                                                                            id='priority_status'
                                                                            style="color:#2196f3;">-</span> --}}
                                                                    </p>
                                                                </div>

                                                                <div class="col-md-4 col-xs-12"
                                                                    style="margin-bottom: 10px;">
                                                                    <p class="mb-0">
                                                                        <strong>Activation Status</strong>:
                                                                        @if($rows[0]->status == 2)
                                                                            <span
                                                                                class="badge badge-danger badge-pill">Inactive</span>
                                                                        @elseif($rows[0]->status == 1)
                                                                            <span
                                                                                class="badge badge-success badge-pill">Active</span>
                                                                        @endif
                                                                    </p>
                                                                </div>

                                                                <div class="col-md-4 col-xs-12"
                                                                    style="margin-bottom: 10px;">
                                                                    <p class="mb-0">
                                                                        <strong>Reviewer Referral ID</strong>:
                                                                        <span class="label label-primary" id='scheduled_on1'
                                                                            style="">{{$rows[0]->ref_id}}</span>
                                                                    </p>
                                                                </div>

                                                                <div class="col-md-12 col-xs-12"
                                                                    style="margin-bottom: 10px;">
                                                                    <label for="journal">Journal</label>:
                                                                    <input value="{{$selected[0]->journalname}}"
                                                                        class="form-control" id="journal_type" disabled>
                                                                    {{-- @if(isset($selected[0]->journalname))
                                                                    <option value="{{$selected[0]->journal_type}}" selected>
                                                                        {{$selected[0]->journalname}}</option>
                                                                    @else
                                                                    <option value="">Select Journal</option>
                                                                    @endif --}}
                                                                </div>

                                                                <div class="col-md-4 col-xs-12"
                                                                    style="margin-bottom: 10px;">
                                                                    <div class="form-group mb-0">
                                                                        <label for="article_type">Type of Article</label>
                                                                        <select class="form-control" name="article_type"
                                                                            id="article_type">
                                                                            @if(isset($selected[0]->articlename))
                                                                                <option value="{{$selected[0]->article_type}}"
                                                                                    selected>{{$selected[0]->articlename}}
                                                                                </option>
                                                                            @else
                                                                                <option value="">Select article Type</option>
                                                                            @endif
                                                                            @foreach($articles as $article)
                                                                                <option value="{{ $article->id }}">
                                                                                    {{ $article->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>

                                                                        <div class="invalid-feedback">
                                                                            Please Select Article Type.
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4 col-xs-12"
                                                                    style="margin-bottom: 10px;">
                                                                    <div class="form-group mb-0">
                                                                        <label for="issue_type">Type of issue</label>
                                                                        <select class="form-control" name="issue_type"
                                                                            id="issue_type">
                                                                            @if(isset($selected[0]->issuename))
                                                                                <option value="{{$selected[0]->issue_type}}"
                                                                                    selected>{{$selected[0]->issuename}}
                                                                                </option>
                                                                            @else
                                                                                <option value="">Select article Type</option>
                                                                            @endif
                                                                            @foreach($issues as $issue)
                                                                                <option value="{{ $issue->id }}">
                                                                                    {{ $issue->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>

                                                                        <div class="invalid-feedback">
                                                                            Please Select issue Type.
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4 col-xs-12"
                                                                    style="margin-bottom: 10px;">
                                                                    <div class="form-group mb-0">
                                                                        <label for="processing_type">Mode of
                                                                            Processing</label>
                                                                        <select class="form-control" name="processing_type"
                                                                            id="processing_type">
                                                                            @if(isset($selected[0]->processingname))
                                                                                <option
                                                                                    value="{{$selected[0]->processing_type}}"
                                                                                    selected>{{$selected[0]->processingname}}
                                                                                </option>
                                                                            @else
                                                                                <option value="">Select article Type</option>
                                                                            @endif
                                                                            @foreach($processings as $processing)
                                                                                <option value="{{ $processing->id }}">
                                                                                    {{ $processing->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>

                                                                        <div class="invalid-feedback">
                                                                            Please Select Processing Mode.
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-4 col-xs-12"
                                                                    style="margin-bottom: 10px;">
                                                                    <div class="form-group mb-0">
                                                                        <label for="status_type">Status</label>
                                                                        <select class="form-control" name="status_type"
                                                                            id="status_type">
                                                                            @if(isset($selected[0]->statusname))
                                                                                <option value="{{$selected[0]->status_type}}"
                                                                                    selected>{{$selected[0]->statusname}}
                                                                                </option>
                                                                            @else
                                                                                <option value="">Select article Type</option>
                                                                            @endif
                                                                            @foreach($statuss as $status)
                                                                                                                                                @if ($status->id == 2 || $status->id == 4 || $status->id == 5 || $status->id == 6 || $status->id == 7 || $status->id == 8 || $status->id == 15 || $status->id == 17)
                                                                                                                                                                                                                    <option value="{{ $status->id }}">
                                                                                                                                                                                                                        {{ $status->name }}&nbsp;&nbsp;&nbsp;[M]<?php        if ($status->id == 2 || $status->id == 5 || $status->id == 6 || $status->id == 15) {
                                                                                                                                                        echo ' [S]';
                                                                                                                                                    } ?>
                                                                                                                                                                                                                    </option>
                                                                                                                                                @else
                                                                                                                                                    <option value="{{ $status->id }}">
                                                                                                                                                        {{ $status->name }}
                                                                                                                                                    </option>
                                                                                                                                                @endif

                                                                            @endforeach
                                                                        </select>

                                                                        <div class="invalid-feedback">
                                                                            Please Select Status.
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4 col-xs-12"
                                                                    style="margin-bottom: 10px;">
                                                                    <div class="form-group mb-0">
                                                                        <label for="status">Activation Status</label>
                                                                        <select class="form-control" name="status"
                                                                            id="activation_status">
                                                                            @isset($selected[0]->status)
                                                                                @if ($selected[0]->status == 1)
                                                                                    <option selected value=1>Active</option>
                                                                                @else
                                                                                    <option selected value=2>Inactive</option>
                                                                                @endif
                                                                            @endisset
                                                                            <option value=1>Active</option>
                                                                            <option value=2>Inactive</option>
                                                                            {{-- <option>abcdfghijk</option>
                                                                            <option>abcdfghijk</option>
                                                                            <option>abcdfghijk</option> --}}
                                                                        </select>

                                                                        <div class="invalid-feedback">
                                                                            Please Select Article Research Area.
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4 col-xs-12" style="">
                                                                    <div class="form-group">
                                                                        <label for="scheduled_on">Scheduled on</label>
                                                                        @if(isset($selected[0]->scheduled_on))
                                                                            <input value="{{$selected[0]->scheduled_on}}"
                                                                                type="date" class="form-control"
                                                                                name="scheduled_on" id="scheduled_on"
                                                                                placeholder="Scheduled Date">
                                                                        @else
                                                                            <input type="date" class="form-control"
                                                                                name="scheduled_on" id="scheduled_on"
                                                                                placeholder="Scheduled Date">
                                                                        @endif
                                                                        <div class="invalid-feedback">
                                                                            Please Select Article Research Area.
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4 col-xs-12" style="">
                                                                    <div class="form-group">
                                                                        <p class="mb-2"><strong>Author:
                                                                            </strong>{{$author[0]->authorname}}</p>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4 col-xs-12" style="">
                                                                    <div class="form-group">
                                                                        <p class="mb-2"><strong>Email:
                                                                            </strong>{{$author[0]->email}}</p>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4 col-xs-12" style="">
                                                                    <div class="form-group">
                                                                        <p class="mb-2"><strong>Phone:
                                                                            </strong>{{$author[0]->phone}}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="">
                                                                <p class="mb-2"><strong>Received on:
                                                                    </strong>{{$rows[0]->created_at}}</p>

                                                                <p class="mb-2"><strong>Updated on:
                                                                    </strong>{{$rows[0]->updated_at}}</p>
                                                                {{-- <<p class="mb-2"><strong>Revised on:</strong> </p> --}}

                                                                    <p class="mb-2"><strong>Accepted on:</strong>
                                                                        @if(isset($acceptances[0]->status))
                                                                            @if($acceptances[0]->status == 'Accepted')
                                                                                {{$acceptances[0]->accepted_on}}
                                                                            @endif
                                                                        @endif
                                                                    </p>

                                                                    <p class="mb-2"><strong>Published on:
                                                                        </strong>{{$rows[0]->scheduled_on}}</p>

                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-12 col-xs-12">
                                                                    <label for="notes"><b>Notes:</b></label>
                                                                    @if(isset($selected[0]->notes))
                                                                        <textarea class="form-control summernote" name="notes"
                                                                            id="notes" rows="8"
                                                                            required>{{$selected[0]->notes}}</textarea>
                                                                    @else
                                                                        <textarea class="form-control summernote" name="notes"
                                                                            id="notes" rows="8" required></textarea>
                                                                    @endif

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 text-left mt-3">
                                                            <button type="submit"
                                                                class="btn btn-blue upload_file waves-effect waves-light">Save</button>
                                                        </div>
                                </form>
                            </div>
                        </div>
                        <div id="tasks" class="tab-pane fade ib-tab-box">
                            <div class="row col-12">
                                <div class="col-xl-4 col-lg-4 col-12">
                                    <form onsubmit="handelSubmit(event)"
                                        action="{{ URL::route($url . '.task', $rows[0]->id) }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <!-- <div class="form-group">
                                                                        <label for="task">Task:</label>
                                                                        <input type="text" class="form-control" name="task_name" id="task_name" placeholder="Task Name" required>
                                                                    </div> -->

                                        <div class="form-group">
                                            <label for="task">Task:</label>
                                            <select class="form-control" name="task_name" id="task_name" required>
                                                <option value="">-- Select Task --</option>
                                                <option value="Editorial check">1. Editorial check</option>
                                                <option value="Plagiarism Check">2. Plagiarism Check</option>
                                                <option value="Peer-Review">3. Peer-Review</option>
                                                <option value="Proofreading">4. Proofreading</option>
                                                <option value="Layout Editing">5. Layout Editing</option>
                                                <option value="Galley Correction">6. Galley Correction</option>
                                                <option value="Publishing">7. Publishing</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="assigned_to">Assigned to:</label>
                                            <select class="form-control" name="assigned_to" id="status_type" required>
                                                <option value="">Select Staff</option>
                                                @foreach ($staffs as $staff)
                                                    <option value={{$staff->id}}>{{$staff->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>



                                        <div class="form-group">
                                            <label for="due_date">Due Date:</label>
                                            <input type="date" class="form-control" name="due_date" id="due_date" required>
                                        </div>
                                        <button type="submit"
                                            class="btn btn-blue upload_file waves-effect waves-light">Save</button><br><br>
                                    </form>
                                </div>

                                <div class="col-lg-5 col-sm-8">
                                    <h4>All Tasks</h4>
                                    <hr>
                                    <div class="" style="overflow-x: auto;">
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
                                                                <span class="badge badge-pill"
                                                                    style="background-color:#ff3300; color:#ffffff;border:1px solid #ff704d">{{$task->status}}</span>
                                                            @elseif ($task->status == 'In progress')
                                                                <span class="badge badge-pill"
                                                                    style="background-color:#4da6ff; color:#ffffff;border:1px solid #99ccff">{{$task->status}}</span>
                                                            @elseif ($task->status == 'Completed')
                                                                <span class="badge badge-pill"
                                                                    style="background-color:#008000; color:#ffffff;border:1px solid #99ff33">{{$task->status}}</span>
                                                            @elseif ($task->status == 'Deferred')
                                                                <span class="badge badge-pill"
                                                                    style="background-color:#264d73; color:#ffffff;border:1px solid #336699">{{$task->status}}</span>
                                                            @else
                                                                <span class="badge badge-pill"
                                                                    style="background-color:#7a7a52; color:#ffffff;border:1px solid #a3a375">{{$task->status}}</span>
                                                            @endif
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-4">
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
                            <div class="kanban-board" style="overflow-x: auto;">
                                <div class="kanban-column" style="width:20%" data-column-name="Not Started">
                                    <div class="kanban-column-header-not-started">Not Started</div>
                                    <div class="kanban-column-cards">
                                        @foreach($tasks as $task)
                                            @if($task->status === 'Not Started')
                                                <div class="kanban-card" draggable="true" data-card-id="{{ $task->id }}">
                                                    <div class="kanban-card-title">{{ $task->task_name }}</div>
                                                    <hr>
                                                    <div class="kanban-card-description"> Author : {{ $author[0]->authorname }}
                                                    </div>
                                                    <div class="kanban-card-description">ID :
                                                        {{$rows[0]->journal_short_form}}-0000{{ $rows[0]->id }}
                                                    </div>
                                                    @if (isset($task->image_path))
                                                        <div class="kanban-card-description">Staff : <img
                                                                src="{{ asset('/uploads/profile/' . $task->image_path) }}"
                                                                class="staff-profile-image-small"
                                                                alt="Default Profile Picture">{{ $task->staffname }}</div>
                                                    @else
                                                        <div class="kanban-card-description">Staff : <img
                                                                src="https://png.pngtree.com/png-clipart/20210129/ourmid/pngtree-default-male-avatar-png-image_2811083.jpg"
                                                                class="staff-profile-image-small"
                                                                alt="Default Profile Picture">{{ $task->staffname }}</div>
                                                    @endif
                                                    <div class="kanban-card-description">Due Date : {{ $task->due_date }}</div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="kanban-column" style="width:20%" data-column-name="In progress">
                                    <div class="kanban-column-header-in-progress">In progress</div>
                                    <div class="kanban-column-cards">
                                        @foreach($tasks as $task)
                                            @if($task->status === 'In progress')
                                                <div class="kanban-card" draggable="true" data-card-id="{{ $task->id }}">
                                                    <div class="kanban-card-title">{{ $task->task_name }}</div>
                                                    <hr>
                                                    <div class="kanban-card-description"> Author : {{ $author[0]->authorname }}
                                                    </div>
                                                    <div class="kanban-card-description">ID :
                                                        {{$rows[0]->journal_short_form}}-0000{{ $rows[0]->id }}
                                                    </div>
                                                    @if (isset($task->image_path))
                                                        <div class="kanban-card-description">Staff : <img
                                                                src="{{ asset('/uploads/profile/' . $task->image_path) }}"
                                                                class="staff-profile-image-small"
                                                                alt="Default Profile Picture">{{ $task->staffname }}</div>
                                                    @else
                                                        <div class="kanban-card-description">Staff : <img
                                                                src="https://png.pngtree.com/png-clipart/20210129/ourmid/pngtree-default-male-avatar-png-image_2811083.jpg"
                                                                class="staff-profile-image-small"
                                                                alt="Default Profile Picture">{{ $task->staffname }}</div>
                                                    @endif
                                                    <div class="kanban-card-description">Due Date : {{ $task->due_date }}</div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="kanban-column" style="width:20%" data-column-name="Completed">
                                    <div class="kanban-column-header-completed">Completed</div>
                                    <div class="kanban-column-cards">
                                        @foreach($tasks as $task)
                                            @if($task->status === 'Completed')
                                                <div class="kanban-card" draggable="true" data-card-id="{{ $task->id }}">
                                                    <div class="kanban-card-title">{{ $task->task_name }}</div>
                                                    <hr>
                                                    <div class="kanban-card-description"> Author : {{ $author[0]->authorname }}
                                                    </div>
                                                    <div class="kanban-card-description">ID :
                                                        {{$rows[0]->journal_short_form}}-0000{{ $rows[0]->id }}
                                                    </div>
                                                    @if (isset($task->image_path))
                                                        <div class="kanban-card-description">Staff : <img
                                                                src="{{ asset('/uploads/profile/' . $task->image_path) }}"
                                                                class="staff-profile-image-small"
                                                                alt="Default Profile Picture">{{ $task->staffname }}</div>
                                                    @else
                                                        <div class="kanban-card-description">Staff : <img
                                                                src="https://png.pngtree.com/png-clipart/20210129/ourmid/pngtree-default-male-avatar-png-image_2811083.jpg"
                                                                class="staff-profile-image-small"
                                                                alt="Default Profile Picture">{{ $task->staffname }}</div>
                                                    @endif
                                                    <div class="kanban-card-description">Due Date : {{ $task->due_date }}</div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="kanban-column" style="width:20%" data-column-name="Deferred">
                                    <div class="kanban-column-header-deferred">Deferred</div>
                                    <div class="kanban-column-cards">
                                        @foreach($tasks as $task)
                                            @if($task->status === 'Deferred')
                                                <div class="kanban-card" draggable="true" data-card-id="{{ $task->id }}">
                                                    <div class="kanban-card-title">{{ $task->task_name }}</div>
                                                    <hr>
                                                    <div class="kanban-card-description"> Author : {{ $author[0]->authorname }}
                                                    </div>
                                                    <div class="kanban-card-description">ID :
                                                        {{$rows[0]->journal_short_form}}-0000{{ $rows[0]->id }}
                                                    </div>
                                                    @if (isset($task->image_path))
                                                        <div class="kanban-card-description">Staff : <img
                                                                src="{{ asset('/uploads/profile/' . $task->image_path) }}"
                                                                class="staff-profile-image-small"
                                                                alt="Default Profile Picture">{{ $task->staffname }}</div>
                                                    @else
                                                        <div class="kanban-card-description">Staff : <img
                                                                src="https://png.pngtree.com/png-clipart/20210129/ourmid/pngtree-default-male-avatar-png-image_2811083.jpg"
                                                                class="staff-profile-image-small"
                                                                alt="Default Profile Picture">{{ $task->staffname }}</div>
                                                    @endif
                                                    <div class="kanban-card-description">Due Date : {{ $task->due_date }}</div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="kanban-column" style="width:20%" data-column-name="Editor approval">
                                    <div class="kanban-column-header-editor-approval">Editor approval</div>
                                    <div class="kanban-column-cards">
                                        @foreach($tasks as $task)
                                            @if($task->status === 'Editor approval')
                                                <div class="kanban-card" draggable="true" data-card-id="{{ $task->id }}">
                                                    <div class="kanban-card-title">{{ $task->task_name }}</div>
                                                    <hr>
                                                    <div class="kanban-card-description"> Author : {{ $author[0]->authorname }}
                                                    </div>
                                                    <div class="kanban-card-description">ID :
                                                        {{$rows[0]->journal_short_form}}-0000{{ $rows[0]->id }}
                                                    </div>
                                                    @if (isset($task->image_path))
                                                        <div class="kanban-card-description">Staff : <img
                                                                src="{{ asset('/uploads/profile/' . $task->image_path) }}"
                                                                class="staff-profile-image-small"
                                                                alt="Default Profile Picture">{{ $task->staffname }}</div>
                                                    @else
                                                        <div class="kanban-card-description">Staff : <img
                                                                src="https://png.pngtree.com/png-clipart/20210129/ourmid/pngtree-default-male-avatar-png-image_2811083.jpg"
                                                                class="staff-profile-image-small"
                                                                alt="Default Profile Picture">{{ $task->staffname }}</div>
                                                    @endif
                                                    <div class="kanban-card-description">Due Date : {{ $task->due_date }}</div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div id="files" class="tab-pane fade ib-tab-box">


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <a data-toggle="modal" href="#modal_upload_file"
                                                class="btn btn-blue upload_file waves-effect waves-light"
                                                id="upload_file"><i class="fa fa-plus"></i> New File Upload</a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div id="modal_upload_file" class="modal fade" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form onsubmit="handelSubmit(event)" class="needs-validation" novalidate
                                            action="{{url('dashboard/admin/submission/author_file/' . $rows[0]->id)}}"
                                            method="post" enctype="multipart/form-data">
                                            @csrf

                                            <div class="modal-header">
                                                <h4 class="modal-title"><i class="fa fa-upload"></i> New File Upload</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="doc_title">Title</label>
                                                            <input type="text" class="form-control" id="doc_title"
                                                                name="doc_title" required>
                                                        </div>
                                                        <hr>
                                                        <label>Drop File Here</label>
                                                        <input class="form-control" type="file" name="file" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" data-dismiss="modal"
                                                    class="btn btn-danger">Close</button>
                                                <button type="submit" id="btn_add_file"
                                                    class="btn btn-blue upload_file waves-effect waves-light">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <hr>
                                    <div class="" style="overflow-x: auto;">
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
                                                    <td width="60%">{{$selected[0]->title}}</td>
                                                    <td>{{$selected[0]->created_at}}</td>
                                                    <td class="text-center">{{-- download article --}}
                                                        @if(is_file('uploads/article/' . $selected[0]->file_path))
                                                            <a href="{{ asset('uploads/article/' . $selected[0]->file_path) }}"
                                                                download><button type="button" class="btn btn-sm btn-success"><i
                                                                        class="fa fa-download"></i>
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
                                                                                                    @if(is_file('uploads/article_file/' . $file->file_path))
                                                                                                        <a href="{{ asset('uploads/article_file/' . $file->file_path) }}"
                                                                                                            download><button type="button" class="btn btn-sm btn-success"><i
                                                                                                                    class="fa fa-download"></i></button></a>
                                                                                                        {{-- <a
                                                                                                            href="{{ asset('uploads/article_file/'.$file->file_path) }}"><button
                                                                                                                type="button"
                                                                                                                class="btn btn-sm btn-danger"></i></button></a> --}}
                                                                                                        <button type="button" class="btn btn-sm btn-danger"
                                                                                                            data-toggle="modal" data-target="#deleteModal-{{ $file->id }}">
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
                                            <a data-toggle="modal" href="#plagiarism_report"
                                                class="btn btn-blue upload_file waves-effect waves-light"
                                                id="upload_file"><i class="fa fa-plus"></i> New File Upload</a>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div id="plagiarism_report" class="modal fade" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form onsubmit="handelSubmit(event)" class="needs-validation" novalidate
                                            action="{{url('dashboard/admin/submission/plagiarism_report/' . $rows[0]->id)}}"
                                            method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-header">
                                                <h4 class="modal-title"><i class="fa fa-upload"></i> Plagiarism Report
                                                    Upload</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="doc_title">Title</label>
                                                            <input type="text" class="form-control" id="doc_title"
                                                                name="doc_title" required>
                                                        </div>
                                                        <hr>
                                                        <label>Drop File Here</label>
                                                        <input class="form-control" type="file" name="file" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" data-dismiss="modal"
                                                    class="btn btn-danger">Close</button>
                                                <button type="submit" id="btn_add_file"
                                                    class="btn btn-blue upload_file waves-effect waves-light">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <hr>
                                    <div class="" style="overflow-x: auto;">
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
                                                                                                    @if(is_file('uploads/article_file/' . $file->file_path))
                                                                                                        <a href="{{ asset('uploads/article_file/' . $file->file_path) }}"
                                                                                                            download><button type="button" class="btn btn-sm btn-success"><i
                                                                                                                    class="fa fa-download"></i></button></a>
                                                                                                        {{-- <a
                                                                                                            href="{{ asset('uploads/article_file/'.$file->file_path) }}"><button
                                                                                                                type="button"
                                                                                                                class="btn btn-sm btn-danger"></i></button></a> --}}
                                                                                                        <button type="button" class="btn btn-sm btn-danger"
                                                                                                            data-toggle="modal" data-target="#deleteModal-{{ $file->id }}">
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

                            <!-- 2 report -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <h4>Certificate Details :</h4>
                                            <a data-toggle="modal" href="#certificate_details"
                                                class="btn btn-blue upload_file waves-effect waves-light"
                                                id="upload_file"><i class="fa fa-plus"></i> New File Upload</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="certificate_details" class="modal fade" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form onsubmit="handelSubmit(event)" class="needs-validation" novalidate
                                            action="{{url('dashboard/admin/submission/certificate_details/' . $rows[0]->id)}}"
                                            method="post" enctype="multipart/form-data">
                                            @csrf

                                            <div class="modal-header">
                                                <h4 class="modal-title"><i class="fa fa-upload"></i> Certificate Details
                                                    Upload</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="doc_title">Title</label>
                                                            <input type="text" class="form-control" id="doc_title"
                                                                name="doc_title" required>
                                                        </div>
                                                        <hr>
                                                        <label>Drop File Here</label>
                                                        <input class="form-control" type="file" name="file" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" data-dismiss="modal"
                                                    class="btn btn-danger">Close</button>
                                                <button type="submit" id="btn_add_file"
                                                    class="btn btn-blue upload_file waves-effect waves-light">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <hr>
                                    <div class="" style="overflow-x: auto;">
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
                                                                                                    @if(is_file('uploads/article_file/' . $file->file_path))
                                                                                                        <a href="{{ asset('uploads/article_file/' . $file->file_path) }}"
                                                                                                            download><button type="button" class="btn btn-sm btn-success"><i
                                                                                                                    class="fa fa-download"></i></button></a>
                                                                                                        {{-- <a
                                                                                                            href="{{ asset('uploads/article_file/'.$file->file_path) }}"><button
                                                                                                                type="button"
                                                                                                                class="btn btn-sm btn-danger"></i></button></a> --}}
                                                                                                        <button type="button" class="btn btn-sm btn-danger"
                                                                                                            data-toggle="modal" data-target="#deleteModal-{{ $file->id }}">
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


                            <!-- 3rd  -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <h4>Published article details :</h4>
                                            <a data-toggle="modal" href="#published_article_details"
                                                class="btn btn-blue upload_file waves-effect waves-light"
                                                id="upload_file"><i class="fa fa-plus"></i> New File Upload</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="published_article_details" class="modal fade" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form onsubmit="handelSubmit(event)" class="needs-validation" novalidate
                                            action="{{url('dashboard/admin/submission/published_article_details/' . $rows[0]->id)}}"
                                            method="post" enctype="multipart/form-data">
                                            @csrf

                                            <div class="modal-header">
                                                <h4 class="modal-title"><i class="fa fa-upload"></i> Certificate Details
                                                    Upload</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="doc_title">Title</label>
                                                            <input type="text" class="form-control" id="doc_title"
                                                                name="doc_title" required>
                                                        </div>
                                                        <hr>
                                                        <label>Drop File Here</label>
                                                        <input class="form-control" type="file" name="file" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" data-dismiss="modal"
                                                    class="btn btn-danger">Close</button>
                                                <button type="submit" id="btn_add_file"
                                                    class="btn btn-blue upload_file waves-effect waves-light">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <hr>
                                    <div class="" style="overflow-x: auto;">
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
                                                                                                    @if(is_file('uploads/article_file/' . $file->file_path))
                                                                                                        <a href="{{ asset('uploads/article_file/' . $file->file_path) }}"
                                                                                                            download><button type="button" class="btn btn-sm btn-success"><i
                                                                                                                    class="fa fa-download"></i></button></a>
                                                                                                        {{-- <a
                                                                                                            href="{{ asset('uploads/article_file/'.$file->file_path) }}"><button
                                                                                                                type="button"
                                                                                                                class="btn btn-sm btn-danger"></i></button></a> --}}
                                                                                                        <button type="button" class="btn btn-sm btn-danger"
                                                                                                            data-toggle="modal" data-target="#deleteModal-{{ $file->id }}">
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


                        </div>

                        <div id="review" class="tab-pane fade ib-tab-box">
                            <div class="row">
                                <div class="col-md-6">
                                    <form onsubmit="handelSubmit(event)"
                                        action="{{ URL::route($url . '.review', $rows[0]->id) }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="reviewer_id">Reviewer:</label>
                                            <select class="form-control" name="reviewer_id" id="status_type" required>
                                                <option value="">Select Reviewer</option>
                                                @foreach ($reviewers as $reviewer)
                                                    <option value={{$reviewer->id}}>{{ $reviewer->reviewerid}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="task">Due Date:</label>
                                            <input type="date" class="form-control" name="due_date" id="due_date" required>
                                        </div>

                                        <button type="submit"
                                            class="btn btn-blue upload_file waves-effect waves-light">Save</button>
                                    </form>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <h4>Review Table</h4>
                                    <div style="overflow-x:auto">
                                        <table class="table table-bordered table-hover sys_table">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ID</th>
                                                    <th>Assigned To</th>
                                                    <th>Assigned On</th>
                                                    <th>Due To</th>
                                                    <th>Status</th>
                                                    <th>Review</th>
                                                    <th class="text-center">Decision</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($reviews as $review)
                                                                                        <tr>
                                                                                            <td class="text-center"><a
                                                                                                    href="{{url('dashboard/admin/submission/review-question/' . $review->id)}}">#{{$review->id}}</a>
                                                                                            </td>
                                                                                            <td>{{$review->reviewerid}}_{{$review->user_department}}</td>
                                                                                            <td>{{$review->create_at}}</td>
                                                                                            <td>{{$review->due_date}}</td>
                                                                                            <td>
                                                                                                @if ($review->status == 'Not Started')
                                                                                                    <span class="badge badge-pill"
                                                                                                        style="background-color:#ff3300; color:#ffffff;border:1px solid #ff704d">{{$review->status}}</span>
                                                                                                @elseif ($review->status == 'In progress')
                                                                                                    <span class="badge badge-pill"
                                                                                                        style="background-color:#4da6ff; color:#ffffff;border:1px solid #99ccff">{{$review->status}}</span>
                                                                                                @elseif ($review->status == 'Completed')
                                                                                                    <span class="badge badge-pill"
                                                                                                        style="background-color:#008000; color:#ffffff;border:1px solid #99ff33">{{$review->status}}</span>
                                                                                                @elseif ($review->status == 'Deferred')
                                                                                                    <span class="badge badge-pill"
                                                                                                        style="background-color:#264d73; color:#ffffff;border:1px solid #336699">{{$review->status}}</span>
                                                                                                @else
                                                                                                    <span class="badge badge-pill"
                                                                                                        style="background-color:#7a7a52; color:#ffffff;border:1px solid #a3a375">{{$review->status}}</span>
                                                                                                @endif
                                                                                            </td>
                                                                                            @if (!empty($review_status))
                                                                                                                                        @php
                                                                                                                                            $isComplete = false;
                                                                                                                                        @endphp
                                                                                                                                        @foreach ($review_status as $singleData)
                                                                                                                                                                            @if ($singleData->article_id == $review->article_id && $singleData->review_id == $review->id)
                                                                                                                                                                                                                @php
                                                                                                                                                                                                                    $isComplete = true;
                                                                                                                                                                                                                @endphp
                                                                                                                                                                                                                <td><span class="badge badge-pill"
                                                                                                                                                                                                                        style="background-color:#008000; color:#ffffff;border:1px solid #99ff33">Submitted</span>
                                                                                                                                                                                                                    <a
                                                                                                                                                                                                                        href="{{url('dashboard/admin/article/show_review_evalution/' . $review->id)}}"><i
                                                                                                                                                                                                                            class="fa fa-eye"></i></a>
                                                                                                                                                                                                                </td>
                                                                                                                                                                                                                <td class="text-center">
                                                                                                                                                                                                                    <select class="custom-select review_decision"
                                                                                                                                                                                                                        id="review_decision_{{ $review->id }}">
                                                                                                                                                                                                                        <option value="{{ $review->decision }}" selected>
                                                                                                                                                                                                                            {{ $review->decision }}
                                                                                                                                                                                                                        </option>
                                                                                                                                                                                                                        <option value="Not Complete">Not Complete</option>
                                                                                                                                                                                                                        <option value="view">View</option>
                                                                                                                                                                                                                    </select>
                                                                                                                                                                                                                </td>
                                                                                                                                                                                                                @break
                                                                                                                                                                            @endif
                                                                                                                                        @endforeach
                                                                                                                                        @if (!$isComplete)
                                                                                                                                            <td><span class="badge badge-pill"
                                                                                                                                                    style="background-color:#ff3300; color:#ffffff;border:1px solid #ff704d">Not
                                                                                                                                                    Submitted</span></td>
                                                                                                                                            <td class="text-center">
                                                                                                                                                <select class="custom-select review_decision"
                                                                                                                                                    id="review_decision_{{ $review->id }}">
                                                                                                                                                    <option value="{{ $review->decision }}" selected>
                                                                                                                                                        {{ $review->decision }}
                                                                                                                                                    </option>
                                                                                                                                                    <option value="Not Complete">Not Complete</option>
                                                                                                                                                    <option value="view">View</option>
                                                                                                                                                </select>
                                                                                                                                            </td>
                                                                                                                                        @endif
                                                                                            @else
                                                                                                <td><span class="badge badge-pill"
                                                                                                        style="background-color:#ff3300; color:#ffffff;border:1px solid #ff704d">Not
                                                                                                        Submitted</span></td>
                                                                                                <td class="text-center">
                                                                                                    <select class="custom-select review_decision"
                                                                                                        id="review_decision_{{ $review->id }}">
                                                                                                        <option value="{{ $review->decision }}" selected>
                                                                                                            {{ $review->decision }}
                                                                                                        </option>
                                                                                                        <option value="Not Complete">Not Complete</option>
                                                                                                        <option value="view">View</option>
                                                                                                    </select>
                                                                                                </td>
                                                                                            @endif
                                                                                        </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>

                            <div class="kanban-board" style="overflow-x: auto;">
                                <div class="kanban-column" id="kanban" status-name="Not Starded">
                                    <div class="kanban-column-header-not-started">Not Started</div>
                                    <div class="kanban-column-cards">
                                        @foreach($reviews as $review)
                                            @if($review->status === 'Not Starded')
                                                <div class="kanban-card" draggable="true" data-id="{{ $review->id }}">
                                                    {{-- <div class="kanban-card-title">{{ $task->task_name }}</div> --}}
                                                    <hr>
                                                    <div class="kanban-card-description">Author: {{ $author[0]->authorname }}</div>
                                                    <div class="kanban-card-description">ID: L#kjhfjhk23</div>
                                                    <div class="kanban-card-description">Reviewer: <img
                                                            src="https://png.pngtree.com/png-clipart/20210129/ourmid/pngtree-default-male-avatar-png-image_2811083.jpg"
                                                            class="staff-profile-image-small"
                                                            alt="Default Profile Picture">{{ $review->reviername }}</div>
                                                    <div class="kanban-card-description">Due Date : {{$review->due_date}}</div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="kanban-column" id="kanban" status-name="In progress">
                                    <div class="kanban-column-header-in-progress">In progress</div>
                                    <div class="kanban-column-cards">
                                        @foreach($reviews as $review)
                                            @if($review->status === 'In progress')
                                                <div class="kanban-card" draggable="true" data-id="{{ $review->id }}">
                                                    {{-- <div class="kanban-card-title">{{ $task->task_name }}</div> --}}
                                                    <hr>
                                                    <div class="kanban-card-description">Author: {{ $author[0]->authorname }}</div>
                                                    <div class="kanban-card-description">ID: L#kjhfjhk23</div>
                                                    <div class="kanban-card-description">Reviewer: <img
                                                            src="https://png.pngtree.com/png-clipart/20210129/ourmid/pngtree-default-male-avatar-png-image_2811083.jpg"
                                                            class="staff-profile-image-small"
                                                            alt="Default Profile Picture">{{ $review->reviername }}</div>
                                                    <div class="kanban-card-description">Due Date : {{$review->due_date}}</div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="kanban-column" id="kanban" status-name="Completed">
                                    <div class="kanban-column-header-completed">Completed</div>
                                    <div class="kanban-column-cards">
                                        @foreach($reviews as $review)
                                            @if($review->status === 'Completed')
                                                <div class="kanban-card" draggable="true" data-id="{{ $review->id }}">
                                                    {{-- <div class="kanban-card-title">{{ $task->task_name }}</div> --}}
                                                    <hr>
                                                    <div class="kanban-card-description">Author: {{ $author[0]->authorname }}</div>
                                                    <div class="kanban-card-description">ID: L#kjhfjhk23</div>
                                                    <div class="kanban-card-description">Reviewer: <img
                                                            src="https://png.pngtree.com/png-clipart/20210129/ourmid/pngtree-default-male-avatar-png-image_2811083.jpg"
                                                            class="staff-profile-image-small"
                                                            alt="Default Profile Picture">{{ $review->reviername }}</div>
                                                    <div class="kanban-card-description">Due Date : {{$review->due_date}}</div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="kanban-column" id="kanban" status-name="Deferred">
                                    <div class="kanban-column-header-deferred">Deferred</div>
                                    <div class="kanban-column-cards">
                                        @foreach($reviews as $review)
                                            @if($review->status === 'Deferred')
                                                <div class="kanban-card" draggable="true" data-id="{{ $review->id }}">
                                                    {{-- <div class="kanban-card-title">{{ $task->task_name }}</div> --}}
                                                    <hr>
                                                    <div class="kanban-card-description">Author: {{ $author[0]->authorname }}</div>
                                                    <div class="kanban-card-description">ID: L#kjhfjhk23</div>
                                                    <div class="kanban-card-description">Reviewer: <img
                                                            src="https://png.pngtree.com/png-clipart/20210129/ourmid/pngtree-default-male-avatar-png-image_2811083.jpg"
                                                            class="staff-profile-image-small"
                                                            alt="Default Profile Picture">{{ $review->reviername }}</div>
                                                    <div class="kanban-card-description">Due Date : {{$review->due_date}}</div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="kanban-column" id="kanban" status-name="Editor approval">
                                    <div class="kanban-column-header-editor-approval">Editor approval</div>
                                    <div class="kanban-column-cards">
                                        @foreach($reviews as $review)
                                            @if($review->status === 'Editor approval')
                                                <div class="kanban-card" draggable="true" data-id="{{ $review->id }}">
                                                    {{-- <div class="kanban-card-title">{{ $task->task_name }}</div> --}}
                                                    <hr>
                                                    <div class="kanban-card-description">Author: {{ $author[0]->authorname }}</div>
                                                    <div class="kanban-card-description">ID: L#kjhfjhk23</div>
                                                    <div class="kanban-card-description">Reviewer: <img
                                                            src="https://png.pngtree.com/png-clipart/20210129/ourmid/pngtree-default-male-avatar-png-image_2811083.jpg"
                                                            class="staff-profile-image-small"
                                                            alt="Default Profile Picture">{{ $review->reviername }}</div>
                                                    <div class="kanban-card-description">Due Date : {{$review->due_date}}</div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="acceptance" class="tab-pane fade ib-tab-box">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <a data-toggle="modal" href="#acceptance_details"
                                                class="btn btn-blue upload_file waves-effect waves-light"
                                                id="upload_file"><i class="fa fa-plus"></i> New Acceptance</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div id="acceptance_details" class="modal fade" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form onsubmit="handelSubmit(event)" class="needs-validation" novalidate
                                            action="{{url('dashboard/admin/submission/acceptance/' . $rows[0]->id)}}"
                                            method="post" enctype="multipart/form-data">
                                            @csrf

                                            <div class="modal-header">
                                                <h4 class="modal-title">Create Acceptance</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>Scheduled To</label>
                                                        <input class="form-control" type="text" name="scheduled_to"
                                                            required>
                                                    </div>

                                                    <div class="col-md-12"><br>
                                                        <label>Published On</label>
                                                        <input class="form-control" type="month" name="published_on"
                                                            required>
                                                    </div>

                                                    <div class="col-md-12"><br>
                                                        <label>Status</label>
                                                        <select class="form-control" name="status" id="status" required>
                                                            <option>Draft</option>
                                                            <option>Accepted</option>
                                                            <option>Declined</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" data-dismiss="modal"
                                                    class="btn btn-danger">Close</button>
                                                <button type="submit" id="btn_add_file"
                                                    class="btn btn-blue upload_file waves-effect waves-light">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover sys_table">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Accepted On</th>
                                                    <th>Scheduled To</th>
                                                    <th>Published On</th>
                                                    <th>Stage</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($acceptances as $acceptance)
                                                    <tr>
                                                        <td>{{$rows[0]->journal_short_form}}-0000{{ $acceptance->article_id }}
                                                        </td>
                                                        <td>{{$acceptance->accepted_on}}</td>
                                                        <td>{{$acceptance->scheduled_to}}</td>
                                                        <td>{{$acceptance->published_on}}</td>
                                                        <td>
                                                            <select class="custom-select" id="acceptance_status">
                                                                <option value="{{$acceptance->status}}" selected>
                                                                    {{$acceptance->status}}
                                                                </option>
                                                                <option value="Draft">Draft</option>
                                                                <option value="Accepted">Accepted</option>
                                                                <option value="Declined">Declined</option>
                                                            </select>
                                                            {{-- @if($acceptance->status == 1)
                                                            <span class="badge badge-pill"
                                                                style="background-color:#a3a375; color:#ffffff;border:1px solid #a3a375">Draft</span>
                                                            @elseif ($acceptance->status == 2)
                                                            <span class="badge badge-pill"
                                                                style="background-color:#33cc33; color:#ffffff;border:1px solid #33cc33">Accepted</span>
                                                            @else
                                                            <span class="badge badge-pill"
                                                                style="background-color:#ff0000; color:#ffffff;border:1px solid #ff0000">Declined</span>
                                                            @endif --}}
                                                        </td>
                                                        <td>
                                                            <select class="custom-select" id="acceptance_action">
                                                                @if($acceptance->action_for_author)
                                                                    <option value="{{$acceptance->action_for_author }}" selected>
                                                                        {{$acceptance->action_for_author }}
                                                                    </option>

                                                                @else
                                                                    <option value="">Select </option>
                                                                @endif
                                                                <option value="View">View</option>
                                                                <option value="Hide">Hide</option>

                                                            </select>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="copyrights" class="tab-pane fade ib-tab-box">
                            {{-- <div class="row"> --}}
                                {{-- <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <h4>Generate the Copyright Form</h4>
                                            <a href="{{url('dashboard/admin/submission/copyright_form/'.$rows[0]->id)}}"
                                                class="btn btn-blue upload_file waves-effect waves-light"
                                                id="accept_save"><i class="fa fa-download"></i> Download</a>
                                        </div>
                                    </div>
                                </div> --}}
                                <h4>Generate the Copyright Form</h4>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12" style="overflow-x: auto;">
                                        <table class="table table-bordered table-hover sys_table">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ID</th>
                                                    <th width="65%">Manuscript Title</th>
                                                    <th class="text-center">Manage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <td class="text-center">
                                                    {{$rows[0]->journal_short_form}}-0000{{ $rows[0]->id }}
                                                </td>
                                                <td width="65%">{{$rows[0]->title}}</td>
                                                <td class="text-center"><a
                                                        href="{{url('dashboard/admin/submission/copyright_form/' . $rows[0]->id)}}"
                                                        class="btn btn-blue upload_file waves-effect waves-light"
                                                        id="accept_save"><i class="fa fa-download"></i> Download</a></td>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                {{--
                            </div> --}}
                        </div>


                        <div id="payments" class="tab-pane fade ib-tab-box">
                            <div class="row">
                                @php
                                    if (!empty($rows[0]->payment_status)) {
                                        $data = $rows[0]->payment_status;
                                        $method = substr($data, strpos($data, "-") + 1);
                                        $paymentstatus = strtok($data, '-');

                                    }
                                @endphp
                                <div class="col-md-12 col-sm-12">
                                    <div class="">
                                        @if ($rows[0]->journal_short_form == "IJIRE")
                                                                            <div style="overflow-x: auto;">

                                                                                <table class="table table-bordered table-hover sys_table">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th class="text-center">Journal</th>
                                                                                            <th width="36%">Author</th>
                                                                                            <th>Amount</th>
                                                                                            <th>Payment Method</th>
                                                                                            <th class="text-center">Status</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td class="text-center" rowspan="3">{{$rows[0]->journal_short_form}}
                                                                                            </td>
                                                                                            <td width="50%">For Indian Author</td>
                                                                                            <td width="50%">
                                                                                                <b>INR {{$payment_data['Indian']['IJIRE']['withoutdoi']}}</b>
                                                                                                <ul>
                                                                                                    <li>APC {{$gst}}% GST</li>
                                                                                                    <li>Without DOI</li>
                                                                                                    <li>Online Publication</li>
                                                                                                    <li>Max. 10 to 20 pages</li>
                                                                                                    <li>E-Certificate(All Authors)</li>
                                                                                                </ul>
                                                                                            </td>
                                                                                            <td>
                                                                                                <form onsubmit="handelSubmit(event)">
                                                                                                    <script
                                                                                                        src="https://checkout.razorpay.com/v1/payment-button.js"
                                                                                                        data-payment_button_id="pl_IipnD9qYVU6uIJ"
                                                                                                        async> </script>
                                                                                                </form>
                                                                                            </td>
                                                                                            <td>
                                                                                                <select class="custom-select" id="payment_status_1">
                                                                                                    @php
                                                                                                        if (!empty($rows[0]->payment_status)) {
                                                                                                            if ($method == 1) {
                                                                                                                if ($paymentstatus == 'paid') {
                                                                                                                    echo '<option value="paid-1">Paid</option>';
                                                                                                                } else {
                                                                                                                    echo '<option value="unpaid-1">Un Paid</option>';
                                                                                                                }
                                                                                                            }
                                                                                                        }
                                                                                                    @endphp
                                                                                                    <option value=" "></option>
                                                                                                    <option value="paid-1">Paid</option>
                                                                                                    <option value="unpaid-1">Un paid</option>
                                                                                                </select>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="50%">For Indian Author</td>
                                                                                            <td>
                                                                                                <b>INR {{$payment_data['Indian']['IJIRE']['withdoi']}}</b>
                                                                                                <ul>
                                                                                                    <li>APC {{$gst}}% GST</li>
                                                                                                    <li>With DOI(10.59256)</li>
                                                                                                    <li>Online Publication</li>
                                                                                                    <li>Max. 10 to 20 pages</li>
                                                                                                    <li>E-Certificate(All Authors)</li>
                                                                                                </ul>
                                                                                            </td>
                                                                                            <td>
                                                                                                <form onsubmit="handelSubmit(event)">
                                                                                                    <script
                                                                                                        src="https://checkout.razorpay.com/v1/payment-button.js"
                                                                                                        data-payment_button_id="pl_LX1iJCBW4Sof5t"
                                                                                                        async> </script>
                                                                                                </form>
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                <select class="custom-select" id="payment_status_2">
                                                                                                    @php
                                                                                                        if (!empty($rows[0]->payment_status)) {
                                                                                                            if ($method == 2) {
                                                                                                                if ($paymentstatus == 'paid') {
                                                                                                                    echo '<option value="paid-1">Paid</option>';
                                                                                                                } else {
                                                                                                                    echo '<option value="unpaid-1">Un Paid</option>';
                                                                                                                }
                                                                                                            }
                                                                                                        }
                                                                                                    @endphp
                                                                                                    <option value=" "></option>
                                                                                                    <option value="paid-2">Paid</option>
                                                                                                    <option value="unpaid-2">Un paid</option>
                                                                                                </select>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="50%">For Foreign Author </td>
                                                                                            <td>
                                                                                                <b>USD {{$payment_data['Others']['IJIRE']['withdoi']}}</b>
                                                                                                <ul>
                                                                                                    <li>With DOI(10.59256)</li>
                                                                                                    <li>Online Publication</li>
                                                                                                    <li>Max. 10 to 20 pages</li>
                                                                                                    <li>E-Certificate(All Authors)</li>
                                                                                                </ul>
                                                                                            </td>
                                                                                            <td>
                                                                                                <form onsubmit="handelSubmit(event)">
                                                                                                    <script
                                                                                                        src="https://checkout.razorpay.com/v1/payment-button.js"
                                                                                                        data-payment_button_id="pl_IipweXrOIDJtu1"
                                                                                                        async> </script>
                                                                                                </form>
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                <select class="custom-select" id="payment_status_3">
                                                                                                    @php
                                                                                                        if (!empty($rows[0]->payment_status)) {
                                                                                                            if ($method == 3) {
                                                                                                                if ($paymentstatus == 'paid') {
                                                                                                                    echo '<option value="paid-1">Paid</option>';
                                                                                                                } else {
                                                                                                                    echo '<option value="unpaid-1">Un Paid</option>';
                                                                                                                }
                                                                                                            }
                                                                                                        }
                                                                                                    @endphp
                                                                                                    <option value=" "></option>
                                                                                                    <option value="paid-3">Paid</option>
                                                                                                    <option value="unpaid-3">Un paid</option>
                                                                                                </select>
                                                                                            </td>
                                                                                        </tr>

                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-12 col-sm-12">
                                                                                    <h4>Payment through Bank:</h4><br>
                                                                                    <p><strong>A/C Name (payable to): </strong>Fifth Dimension Research
                                                                                        Publication Private Limited</p>
                                                                                    <p><strong>Account no: </strong>807620110000250</p>
                                                                                    <p><strong>Name of the Bank: </strong> Bank of India</p>
                                                                                    <p><strong>BRANCH: </strong> Ariyalur</p>
                                                                                    <p><strong>BR.CODE: </strong> 008076</p>
                                                                                    <p><strong>MICR code: </strong> 621013002</p>
                                                                                    <p><strong>IFSC No: </strong> BKID0008076</p>
                                                                                </div>
                                                                            </div>
                                        @elseif($rows[0]->journal_short_form == "IJSREAT")
                                                                            <div style="overflow-x: auto;">
                                                                                <table class="table table-bordered table-hover sys_table">

                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th class="text-center">Journal</th>
                                                                                            <th width="36%">Author</th>
                                                                                            <th>Amount</th>
                                                                                            <th>Payment Method</th>
                                                                                            <th class="text-center">Status</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td rowspan="3" style="text-align: center;text-align: center;">
                                                                                                {{$rows[0]->journal_short_form}}
                                                                                            </td>
                                                                                            <td width="50%">For Indian Author</td>
                                                                                            <td width="50%">
                                                                                                <b>INR {{$payment_data['Indian']['IJSREAT']['withoutdoi']}}</b>
                                                                                                <ul>
                                                                                                    <li>APC {{$gst}}% GST</li>
                                                                                                    <li>Without DOI</li>
                                                                                                    <li>Online Publication</li>
                                                                                                    <li>Max. 10 to 20 pages</li>
                                                                                                    <li>E-Certificate(All Authors)</li>
                                                                                                </ul>
                                                                                            </td>
                                                                                            <td>
                                                                                                <form onsubmit="handelSubmit(event)">
                                                                                                    <script
                                                                                                        src="https://checkout.razorpay.com/v1/payment-button.js"
                                                                                                        data-payment_button_id="pl_M5F2CxmT6aHnMg"
                                                                                                        async> </script>
                                                                                                </form>
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                <select class="custom-select" id="payment_status_1">
                                                                                                    @php
                                                                                                        if (!empty($rows[0]->payment_status)) {
                                                                                                            if ($method == 1) {
                                                                                                                if ($paymentstatus == 'paid') {
                                                                                                                    echo '<option value="paid-1">Paid</option>';
                                                                                                                } else {
                                                                                                                    echo '<option value="unpaid-1">Un Paid</option>';
                                                                                                                }
                                                                                                            }
                                                                                                        }
                                                                                                    @endphp
                                                                                                    <option value=" "></option>
                                                                                                    <option value="paid-1">Paid</option>
                                                                                                    <option value="unpaid-1">Un paid</option>
                                                                                                </select>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="50%">For Indian Author</td>
                                                                                            <td>
                                                                                                <b>INR {{$payment_data['Indian']['IJSREAT']['withdoi']}}</b>
                                                                                                <ul>
                                                                                                    <li>APC {{$gst}}% GST</li>
                                                                                                    <li>With DOI(10.59256)</li>
                                                                                                    <li>Online Publication</li>
                                                                                                    <li>Max. 10 to 20 pages</li>
                                                                                                    <li>E-Certificate(All Authors)</li>
                                                                                                </ul>
                                                                                            </td>
                                                                                            <td>
                                                                                                <form onsubmit="handelSubmit(event)">
                                                                                                    <script
                                                                                                        src="https://checkout.razorpay.com/v1/payment-button.js"
                                                                                                        data-payment_button_id="pl_M5F4CjwVqlcI0D"
                                                                                                        async> </script>
                                                                                                </form>
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                <select class="custom-select" id="payment_status_2">
                                                                                                    @php
                                                                                                        if (!empty($rows[0]->payment_status)) {
                                                                                                            if ($method == 2) {
                                                                                                                if ($paymentstatus == 'paid') {
                                                                                                                    echo '<option value="paid-1">Paid</option>';
                                                                                                                } else {
                                                                                                                    echo '<option value="unpaid-1">Un Paid</option>';
                                                                                                                }
                                                                                                            }
                                                                                                        }
                                                                                                    @endphp
                                                                                                    <option value=" "></option>
                                                                                                    <option value="paid-2">Paid</option>
                                                                                                    <option value="unpaid-2">Un paid</option>
                                                                                                </select>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="50%">For Foreign Author </td>
                                                                                            <td>
                                                                                                <b>USD {{$payment_data['Others']['IJSREAT']['withdoi']}}</b>
                                                                                                <ul>
                                                                                                    <li>With DOI(10.59256)</li>
                                                                                                    <li>Online Publication</li>
                                                                                                    <li>Max. 10 to 20 pages</li>
                                                                                                    <li>E-Certificate(All Authors)</li>
                                                                                                </ul>
                                                                                            </td>
                                                                                            <td>
                                                                                                <form onsubmit="handelSubmit(event)">
                                                                                                    <script
                                                                                                        src="https://checkout.razorpay.com/v1/payment-button.js"
                                                                                                        data-payment_button_id="pl_M5F5sakrcOOelN"
                                                                                                        async> </script>
                                                                                                </form>
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                <select class="custom-select" id="payment_status_3">
                                                                                                    @php
                                                                                                        if (!empty($rows[0]->payment_status)) {
                                                                                                            if ($method == 3) {
                                                                                                                if ($paymentstatus == 'paid') {
                                                                                                                    echo '<option value="paid-1">Paid</option>';
                                                                                                                } else {
                                                                                                                    echo '<option value="unpaid-1">Un Paid</option>';
                                                                                                                }
                                                                                                            }
                                                                                                        }
                                                                                                    @endphp
                                                                                                    <option value=" "></option>
                                                                                                    <option value="paid-3">Paid</option>
                                                                                                    <option value="unpaid-3">Un paid</option>
                                                                                                </select>
                                                                                            </td>
                                                                                        </tr>

                                                                                    </tbody>
                                                                                </table>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-12 col-sm-12">
                                                                                    <h4>Payment through Bank:</h4><br>
                                                                                    <p><strong>A/C Name (payable to): </strong>Fifth Dimension Research
                                                                                        Publication Private Limited</p>
                                                                                    <p><strong>Account no: </strong>807620110000250</p>
                                                                                    <p><strong>Name of the Bank: </strong> Bank of India</p>
                                                                                    <p><strong>BRANCH: </strong> Ariyalur</p>
                                                                                    <p><strong>BR.CODE: </strong> 008076</p>
                                                                                    <p><strong>MICR code: </strong> 621013002</p>
                                                                                    <p><strong>IFSC No: </strong> BKID0008076</p>
                                                                                </div>
                                                                            </div>
                                        @elseif($rows[0]->journal_short_form == "IJRTMR")
                                                                            <div style="overflow-x: auto;">

                                                                                <table class="table table-bordered table-hover sys_table">

                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th class="text-center">Journal</th>
                                                                                            <th>Author</th>
                                                                                            <th>Amount</th>
                                                                                            <th>Payment Method</th>
                                                                                            <th class="text-center">Status</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td rowspan="3" class="text-center">{{$rows[0]->journal_short_form}}
                                                                                            </td>
                                                                                            <td width="50%">For Indian Author</td>
                                                                                            <td width="50%">
                                                                                                <b>INR {{$payment_data['Indian']['IJRTMR']['withoutdoi']}}</b>
                                                                                                <ul>
                                                                                                    <li>APC {{$gst}}% GST</li>
                                                                                                    <li>Without DOI</li>
                                                                                                    <li>Online Publication</li>
                                                                                                    <li>Max. 10 to 20 pages</li>
                                                                                                    <li>E-Certificate(All Authors)</li>
                                                                                                </ul>
                                                                                            </td>
                                                                                            <td>
                                                                                                <form onsubmit="handelSubmit(event)">
                                                                                                    <script
                                                                                                        src="https://checkout.razorpay.com/v1/payment-button.js"
                                                                                                        data-payment_button_id="pl_JpkQFEvwU2gNfk"
                                                                                                        async> </script>
                                                                                                </form>
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                <select class="custom-select" id="payment_status_1">
                                                                                                    @php
                                                                                                        if (!empty($rows[0]->payment_status)) {
                                                                                                            if ($method == 1) {
                                                                                                                if ($paymentstatus == 'paid') {
                                                                                                                    echo '<option value="paid-1">Paid</option>';
                                                                                                                } else {
                                                                                                                    echo '<option value="unpaid-1">Un Paid</option>';
                                                                                                                }
                                                                                                            }
                                                                                                        }
                                                                                                    @endphp
                                                                                                    <option value=" "></option>
                                                                                                    <option value="paid-1">Paid</option>
                                                                                                    <option value="unpaid-1">Un paid</option>
                                                                                                </select>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="50%">For Indian Author</td>
                                                                                            <td>
                                                                                                <b>INR {{$payment_data['Indian']['IJRTMR']['withdoi']}}</b>
                                                                                                <ul>
                                                                                                    <li>APC {{$gst}}% GST</li>
                                                                                                    <li>With DOI(10.59256)</li>
                                                                                                    <li>Online Publication</li>
                                                                                                    <li>Max. 10 to 20 pages</li>
                                                                                                    <li>E-Certificate(All Authors)</li>
                                                                                                </ul>
                                                                                            </td>
                                                                                            <td>
                                                                                                <form onsubmit="handelSubmit(event)">
                                                                                                    <script
                                                                                                        src="https://checkout.razorpay.com/v1/payment-button.js"
                                                                                                        data-payment_button_id="pl_M5Ez1eyaihQTLe"
                                                                                                        async> </script>
                                                                                                </form>
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                <select class="custom-select" id="payment_status_2">
                                                                                                    @php
                                                                                                        if (!empty($rows[0]->payment_status)) {
                                                                                                            if ($method == 2) {
                                                                                                                if ($paymentstatus == 'paid') {
                                                                                                                    echo '<option value="paid-1">Paid</option>';
                                                                                                                } else {
                                                                                                                    echo '<option value="unpaid-1">Un Paid</option>';
                                                                                                                }
                                                                                                            }
                                                                                                        }
                                                                                                    @endphp
                                                                                                    <option value=" "></option>
                                                                                                    <option value="paid-2">Paid</option>
                                                                                                    <option value="unpaid-2">Un paid</option>
                                                                                                </select>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="50%">For Foreign Author </td>
                                                                                            <td>
                                                                                                <b>USD {{$payment_data['Others']['IJRTMR']['withdoi']}}</b>
                                                                                                <ul>
                                                                                                    <li>With DOI(10.59256)</li>
                                                                                                    <li>Online Publication</li>
                                                                                                    <li>Max. 10 to 20 pages</li>
                                                                                                    <li>E-Certificate(All Authors)</li>
                                                                                                </ul>
                                                                                            </td>
                                                                                            <td>
                                                                                                <form onsubmit="handelSubmit(event)">
                                                                                                    <script
                                                                                                        src="https://checkout.razorpay.com/v1/payment-button.js"
                                                                                                        data-payment_button_id="pl_Jpkf3lSqoVoUyG"
                                                                                                        async> </script>
                                                                                                </form>
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                <select class="custom-select" id="payment_status_3">
                                                                                                    @php
                                                                                                        if (!empty($rows[0]->payment_status)) {
                                                                                                            if ($method == 3) {
                                                                                                                if ($paymentstatus == 'paid') {
                                                                                                                    echo '<option value="paid-1">Paid</option>';
                                                                                                                } else {
                                                                                                                    echo '<option value="unpaid-1">Un Paid</option>';
                                                                                                                }
                                                                                                            }
                                                                                                        }
                                                                                                    @endphp
                                                                                                    <option value=" "></option>
                                                                                                    <option value="paid-3">Paid</option>
                                                                                                    <option value="unpaid-3">Un paid</option>
                                                                                                </select>
                                                                                            </td>
                                                                                        </tr>

                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-12 col-sm-12">
                                                                                    <h4>Payment through Bank:</h4><br>
                                                                                    <p><strong>A/C Name (payable to): </strong>Fifth Dimension Research
                                                                                        Publication Private Limited</p>
                                                                                    <p><strong>Account no: </strong>807620110000250</p>
                                                                                    <p><strong>Name of the Bank: </strong> Bank of India</p>
                                                                                    <p><strong>BRANCH: </strong> Ariyalur</p>
                                                                                    <p><strong>BR.CODE: </strong> 008076</p>
                                                                                    <p><strong>MICR code: </strong> 621013002</p>
                                                                                    <p><strong>IFSC No: </strong> BKID0008076</p>
                                                                                </div>
                                                                            </div>
                                        @elseif($rows[0]->journal_short_form == "INDJCST")
                                                                            <div style="overflow-x: auto;">

                                                                                <table class="table table-bordered table-hover sys_table">

                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th class="text-center">Journal</th>
                                                                                            <th>Author</th>
                                                                                            <th>Amount</th>
                                                                                            <th>Payment Method</th>
                                                                                            <th class="text-center">Status</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td rowspan="3" class="text-center">{{$rows[0]->journal_short_form}}
                                                                                            </td>
                                                                                            <td width="50%">For Indian Author</td>
                                                                                            <td width="50%">
                                                                                                <b>INR {{$payment_data['Indian']['INDJCST']['withoutdoi']}}</b>
                                                                                                <ul>
                                                                                                    <li>APC {{$gst}}% GST</li>
                                                                                                    <li>Without DOI</li>
                                                                                                    <li>Online Publication</li>
                                                                                                    <li>Max. 10 to 20 pages</li>
                                                                                                    <li>E-Certificate(All Authors)</li>
                                                                                                </ul>
                                                                                            </td>
                                                                                            <td>
                                                                                                <form onsubmit="handelSubmit(event)">
                                                                                                    <script
                                                                                                        src="https://checkout.razorpay.com/v1/payment-button.js"
                                                                                                        data-payment_button_id="pl_M5F85UY7YjjGuv"
                                                                                                        async> </script>
                                                                                                </form>
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                <select class="custom-select" id="payment_status_1">
                                                                                                    @php
                                                                                                        if (!empty($rows[0]->payment_status)) {
                                                                                                            if ($method == 1) {
                                                                                                                if ($paymentstatus == 'paid') {
                                                                                                                    echo '<option value="paid-1">Paid</option>';
                                                                                                                } else {
                                                                                                                    echo '<option value="unpaid-1">Un Paid</option>';
                                                                                                                }
                                                                                                            }
                                                                                                        }
                                                                                                    @endphp
                                                                                                    <option value=" "></option>
                                                                                                    <option value="paid-1">Paid</option>
                                                                                                    <option value="unpaid-1">Un paid</option>
                                                                                                </select>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="50%">For Indian Author</td>
                                                                                            <td>
                                                                                                <b>INR {{$payment_data['Indian']['INDJCST']['withdoi']}}</b>
                                                                                                <ul>
                                                                                                    <li>APC {{$gst}}% GST</li>
                                                                                                    <li>With DOI(10.59256)</li>
                                                                                                    <li>Online Publication</li>
                                                                                                    <li>Max. 10 to 20 pages</li>
                                                                                                    <li>E-Certificate(All Authors)</li>
                                                                                                </ul>
                                                                                            </td>
                                                                                            <td>
                                                                                                <form onsubmit="handelSubmit(event)">
                                                                                                    <script
                                                                                                        src="https://checkout.razorpay.com/v1/payment-button.js"
                                                                                                        data-payment_button_id="pl_M5FAsn5wP7RItB"
                                                                                                        async> </script>
                                                                                                </form>
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                <select class="custom-select" id="payment_status_2">
                                                                                                    @php
                                                                                                        if (!empty($rows[0]->payment_status)) {
                                                                                                            if ($method == 2) {
                                                                                                                if ($paymentstatus == 'paid') {
                                                                                                                    echo '<option value="paid-1">Paid</option>';
                                                                                                                } else {
                                                                                                                    echo '<option value="unpaid-1">Un Paid</option>';
                                                                                                                }
                                                                                                            }
                                                                                                        }
                                                                                                    @endphp
                                                                                                    <option value=" "></option>
                                                                                                    <option value="paid-2">Paid</option>
                                                                                                    <option value="unpaid-2">Un paid</option>
                                                                                                </select>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width="50%">For Foreign Author </td>
                                                                                            <td>
                                                                                                <b>USD {{$payment_data['Others']['INDJCST']['withdoi']}}</b>
                                                                                                <ul>
                                                                                                    <li>With DOI(10.59256)</li>
                                                                                                    <li>Online Publication</li>
                                                                                                    <li>Max. 10 to 20 pages</li>
                                                                                                    <li>E-Certificate(All Authors)</li>
                                                                                                </ul>
                                                                                            </td>
                                                                                            <td>
                                                                                                <form onsubmit="handelSubmit(event)">
                                                                                                    <script
                                                                                                        src="https://checkout.razorpay.com/v1/payment-button.js"
                                                                                                        data-payment_button_id="pl_M5FCQIre57PUpW"
                                                                                                        async> </script>
                                                                                                </form>
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                <select class="custom-select" id="payment_status_3">
                                                                                                    @php
                                                                                                        if (!empty($rows[0]->payment_status)) {
                                                                                                            if ($method == 3) {
                                                                                                                if ($paymentstatus == 'paid') {
                                                                                                                    echo '<option value="paid-1">Paid</option>';
                                                                                                                } else {
                                                                                                                    echo '<option value="unpaid-1">Un Paid</option>';
                                                                                                                }
                                                                                                            }
                                                                                                        }
                                                                                                    @endphp
                                                                                                    <option value=" "></option>
                                                                                                    <option value="paid-3">Paid</option>
                                                                                                    <option value="unpaid-3">Un paid</option>
                                                                                                </select>
                                                                                            </td>
                                                                                        </tr>

                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-12 col-sm-12">
                                                                                    <h4>Payment through Bank:</h4><br>
                                                                                    <p><strong>A/C Name (payable to): </strong>Fifth Dimension Research
                                                                                        Publication Private Limited</p>
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
                                                There Are No Submission Fees, Publication Fees Or Page Charges For This Journal.
                                                Colour Figures Will Be Reproduced In Colour In Your Online
                                                Article Free Of Charge.
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
                                            <h4>Final Manuscript: </h4>
                                            <a data-toggle="modal" href="#final_manuscript"
                                                class="btn btn-blue upload_file waves-effect waves-light mb-2"
                                                id="upload_file"><i class="fa fa-plus"></i> New File Upload</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="final_manuscript" class="modal fade" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form onsubmit="handelSubmit(event)" class="needs-validation" novalidate
                                            action="{{url('dashboard/admin/submission/final_submission_manuscript/' . $rows[0]->id)}}"
                                            method="post" enctype="multipart/form-data">
                                            @csrf

                                            <div class="modal-header">
                                                <h4 class="modal-title"><i class="fa fa-upload"></i> File Manuscript Upload
                                                </h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">×</button>
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
                                                <button type="button" data-dismiss="modal"
                                                    class="btn btn-danger">Close</button>
                                                <button type="submit" id="btn_add_file"
                                                    class="btn btn-blue upload_file waves-effect waves-light">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="" style="overflow-x: auto;">
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
                                                @foreach ($final_manuscripts as $key => $final_manuscript)
                                                    <tr>
                                                        <td class="text-center">{{$key + 1}}</td>
                                                        <td width="65%">{{$final_manuscript->doc_title}}</td>
                                                        <td>{{$final_manuscript->create_at}}</td>
                                                        <td class="text-center" style="width:125px;">
                                                            {{-- download copyrigth form --}}
                                                            @if(is_file('uploads/final_submission/' . $final_manuscript->file_path))
                                                                <a href="{{ asset('uploads/final_submission/' . $final_manuscript->file_path) }}"
                                                                    download><button type="button" class="btn btn-sm btn-success"><i
                                                                            class="fa fa-download"></i>
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
                            <hr>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <h4>Copyrights Form: </h4>
                                            <a data-toggle="modal" href="#final_copy_rights"
                                                class="btn btn-blue upload_file waves-effect waves-light mb-2"
                                                id="upload_file"><i class="fa fa-plus"></i> New File Upload</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="final_copy_rights" class="modal fade" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form onsubmit="handelSubmit(event)" class="needs-validation" novalidate
                                            action="{{url('dashboard/admin/submission/final_submission_copyright_form/' . $rows[0]->id)}}"
                                            method="post" enctype="multipart/form-data">
                                            @csrf

                                            <div class="modal-header">
                                                <h4 class="modal-title"><i class="fa fa-upload"></i> Copy Right Forms Upload
                                                </h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">×</button>
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
                                                <button type="button" data-dismiss="modal"
                                                    class="btn btn-danger">Close</button>
                                                <button type="submit" id="btn_add_file"
                                                    class="btn btn-blue upload_file waves-effect waves-light">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="" style="overflow-x: auto;">
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
                                                @foreach ($final_copy_right_forms as $key => $final_copy_right_form)
                                                    <tr>
                                                        <td class="text-center">{{$key + 1}}</td>
                                                        <td width="65%">{{$final_copy_right_form->doc_title}}</td>
                                                        <td>{{$final_copy_right_form->create_at}}</td>
                                                        <td class="text-center" style="width:125px;">
                                                            {{-- download copyrigth form --}}
                                                            @if(is_file('uploads/final_submission/' . $final_copy_right_form->file_path))
                                                                <a href="{{ asset('uploads/final_submission/' . $final_copy_right_form->file_path) }}"
                                                                    download><button type="button" class="btn btn-sm btn-success"><i
                                                                            class="fa fa-download"></i>
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
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <h4>Payment Receipt: </h4>
                                            <a data-toggle="modal" href="#payment_script"
                                                class="btn btn-blue upload_file waves-effect waves-light mb-2"
                                                id="upload_file"><i class="fa fa-plus"></i> New File Upload</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="payment_script" class="modal fade" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form onsubmit="handelSubmit(event)" class="needs-validation" novalidate
                                            action="{{url('dashboard/admin/submission/final_submission_payment_manuscript/' . $rows[0]->id)}}"
                                            method="post" enctype="multipart/form-data">
                                            @csrf

                                            <div class="modal-header">
                                                <h4 class="modal-title"><i class="fa fa-upload"></i> Payment Manuscript
                                                    Upload</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">×</button>
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
                                                <button type="button" data-dismiss="modal"
                                                    class="btn btn-danger">Close</button>
                                                <button type="submit" id="btn_add_file"
                                                    class="btn btn-blue upload_file waves-effect waves-light">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="" style="overflow-x: auto;">
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
                                                @foreach ($final_payment_scripts as $key => $final_payment_script)
                                                    <tr>
                                                        <td class="text-center">{{$key + 1}}</td>
                                                        <td width="65%">{{$final_payment_script->doc_title}}</td>
                                                        <td>{{$final_payment_script->create_at}}</td>
                                                        <td class="text-center" style="width:125px;">
                                                            {{-- download copyrigth form --}}
                                                            @if(is_file('uploads/final_submission/' . $final_payment_script->file_path))
                                                                <a href="{{ asset('uploads/final_submission/' . $final_payment_script->file_path) }}"
                                                                    download><button type="button" class="btn btn-sm btn-success"><i
                                                                            class="fa fa-download"></i>
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

                            <div class="row">
                                <div class="col-md-12" align="center">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            {{-- <h3>After </h3><br> --}}
                                            <a href="{{ URL::route('final_submission.unfreeze', $rows[0]->id) }}"
                                                class="btn btn-blue upload_file waves-effect waves-light"> Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div id="comments" class="tab-pane fade ib-tab-box">
                            <div class="row">
                                <h3>comment</h3>
                            </div>

                        </div>

                        <div id="history" class="tab-pane fade ib-tab-box">
                            <div class="row">
                                <h3>history</h3>
                            </div>

                        </div>

                        <div id="others" class="tab-pane fade ib-tab-box">
                            <div class="row">
                                <h3>others</h3>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- loading screen -->
    <div id="loading-screen" style="display: flex;">
        <img src="https://media.tenor.com/guhB4PpjrmUAAAAC/loading-loading-gif.gif" alt="">
        <!-- <div class="loading-spinner"></div> -->
        <p>Loading...</p>
    </div>
</div>
</div>
    </div>
    </div>
    <style>
        #loading-screen {
            position: fixed;
            z-index: 100;
            backdrop-filter: blur(5px);
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: white;
        }

        .loading-spinner {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3498db;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>


    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script>
        function handelSubmit(event) {
            // Show the loading screen
            document.getElementById('loading-screen').style.display = 'flex';
            window.addEventListener('DOMContentLoaded', function (event) {
                document.getElementById('loading-screen').style.display = 'none';
            });
            // Let the form submit normally
            return true;
        }

        window.addEventListener('DOMContentLoaded', function (event) {
            document.getElementById('loading-screen').style.display = 'none';
        });
        window.addEventListener('beforeunload', function (event) {
            document.getElementById('loading-screen').style.display = 'flex';
        });

    </script> -->
    <script>
    // Initial Setup
    function hideLoading() {
        document.getElementById('loading-screen').style.display = 'none';
    }

    function showLoading() {
        document.getElementById('loading-screen').style.display = 'flex';
    }

    // Enhance pushState/replaceState to detect route changes
    (function(history) {
        const pushState = history.pushState;
        const replaceState = history.replaceState;

        history.pushState = function(state) {
            const result = pushState.apply(history, arguments);
            window.dispatchEvent(new Event('locationchange'));
            return result;
        };

        history.replaceState = function(state) {
            const result = replaceState.apply(history, arguments);
            window.dispatchEvent(new Event('locationchange'));
            return result;
        };
    })(window.history);

    // Catch browser navigation events
    window.addEventListener('popstate', () => {
        window.dispatchEvent(new Event('locationchange'));
    });

    // On load, ensure loading is hidden
    window.addEventListener('DOMContentLoaded', () => {
        hideLoading();
    });

    // Handle form submit (show loading)
    function handelSubmit(event) {
        showLoading();
        return true; // let form submit
    }

    // Show loading on unload
    window.addEventListener('beforeunload', () => {
        showLoading();
    });

    // Hide loading after URL change (endpoint change)
    window.addEventListener('locationchange', () => {
        hideLoading(); // Triggered after push/replace/pop
    });
</script>

    <script>

        var kanbanBoards = document.querySelectorAll('.kanban-column-cards');
        kanbanBoards.forEach(function (kanbanBoard) {
            new Sortable(kanbanBoard, {
                group: 'kanban-column',
                animation: 150,
                onEnd: (event) => {
                    const cardElement = event.item;
                    const cardId = cardElement.getAttribute('data-card-id');
                    const fromColumnId = cardElement.parentNode.parentNode.getAttribute('data-column-name');
                    // const toColumnId = cardElement.parentNode.parentNode.getAttribute('data-column-id');
                    // const position = [...cardElement.parentNode.children].indexOf(cardElement);
                    // alert(cardId)
                    // alert(fromColumnId);


                    if (cardId == null) {
                        const cardId_1 = cardElement.getAttribute('data-id');
                        const fromColumnId_1 = cardElement.parentNode.parentNode.getAttribute('status-name');
                        // alert(cardId_1);
                        // alert(fromColumnId_1);

                        $.ajax({
                            method: 'POST',
                            url: '{{URL::to('/dashboard/admin/submission/kan-ban-review')}}',
                            data: { _token: "{{csrf_token()}}", id: cardId_1, status: fromColumnId_1 },
                            success: function (data) {
                                showAlertModal('Review Status Changed Successfully');
                                afterRefreshthenpassthepostdata('review');

                            },
                            error: function () {
                                alert("Something went Wrong!!!");
                            }
                        })


                    } else {
                        // alert(cardId)
                        // alert(fromColumnId);
                        $.ajax({
                            method: 'POST',
                            url: '{{URL::to('/dashboard/admin/submission/kan-ban-task')}}',
                            data: { _token: "{{csrf_token()}}", id: cardId, status: fromColumnId },
                            success: function (data) {
                                showAlertModal(data);
                                afterRefreshthenpassthepostdata('tasks');
                            },
                            error: function () {
                                alert("Something went Wrong!!!");
                            }
                        })
                    }
                },
            });
        });

        // Function to simulate a successful AJAX request
        function afterRefreshthenpassthepostdata(tabshow) {
            // Simulate a successful AJAX request and get the data
            const postData = tabshow; // Replace with the actual data received from the server

            // Store the POST data in localStorage
            localStorage.setItem('postData', postData);

            // Refresh the page after the data is saved
            window.location.reload();
        }

        function afterrefreshshowthetab() {
            const tabToShow = localStorage.getItem('postData');

            if (tabToShow == 'tasks') {
                $('#nav-tab a[href="#tasks"]').tab('show');
            } else if (tabToShow == 'review') {
                $('#nav-tab a[href="#review"]').tab('show');
            } else if (tabToShow == 'payments') {
                $('#nav-tab a[href="#payments"]').tab('show');
            }
            localStorage.removeItem('postData');

        }

        window.onload = function () {
            afterrefreshshowthetab();
        };


        //Details data change Asynchronous
        $('#journal_type').change(function () {
            let val = $(this).val();
            var id_value = <?php echo $id ?>;
            // alert(list);
            // alert(val);
            $.ajax({
                method: 'POST',
                url: '{{URL::to('/dashboard/admin/submission/journal_ajax')}}',
                data: { _token: "{{csrf_token()}}", journaldata: val, id: id_value },
                success: function (data) {
                    refreshPage()
                    // setInterval(5000);
                    showAlertModal(data);
                    // sweet_alert(data, "success");
                    // $("#message").empty();
                    // $("#message").append('<div class="alert alert-info">'+data+'</div>');
                },
                error: function () {
                    sweet_alert("Something went Wrong!!!", "error");
                }
            })
        });

        $('#article_type').change(function () {
            let val = $(this).val();
            var id_value = <?php echo $id ?>;
            $.ajax({
                method: 'POST',
                url: '{{URL::to('/dashboard/admin/submission/journal_ajax')}}',
                data: { _token: "{{csrf_token()}}", articledata: val, id: id_value },
                success: function (data) {
                    refreshPage()
                    showAlertModal(data);
                },
                error: function () {
                    sweet_alert("Something went Wrong!!!", "error");
                }
            })
        });

        $('#issue_type').change(function () {
            let val = $(this).val();
            var id_value = <?php echo $id ?>;
            $.ajax({
                method: 'POST',
                url: '{{URL::to('/dashboard/admin/submission/journal_ajax')}}',
                data: { _token: "{{csrf_token()}}", issuedata: val, id: id_value },
                success: function (data) {
                    // sweet_alert(data, "success");
                    refreshPage()
                    showAlertModal(data);
                },
                error: function () {
                    sweet_alert("Something went Wrong!!!", "error");
                }
            })
        });


        $('#processing_type').change(function () {
            let val = $(this).val();
            var id_value = <?php echo $id ?>;
            $.ajax({
                method: 'POST',
                url: '{{URL::to('/dashboard/admin/submission/journal_ajax')}}',
                data: { _token: "{{csrf_token()}}", processingdata: val, id: id_value },
                success: function (data) {
                    // sweet_alert(data, "success");
                    refreshPage()
                    showAlertModal(data);
                },
                error: function () {
                    sweet_alert("Something went Wrong!!!", "error");
                }
            })
        });

        $('#status_type').change(function () {
            let val = $(this).val();
            var id_value = <?php echo $id ?>;
            $.ajax({
                method: 'POST',
                url: '{{URL::to('/dashboard/admin/submission/journal_ajax')}}',
                data: { _token: "{{csrf_token()}}", statusdata: val, id: id_value },
                success: function (data) {
                    alert(data);
                    // sweet_alert(data, "success");
                    refreshPage()
                    showAlertModal(data);
                },
                error: function () {

                    sweet_alert("Something went Wrong!!!", "error");
                }
            })
        });

        $('#activation_status').change(function () {
            let val = $(this).val();
            var id_value = <?php echo $id ?>;
            $.ajax({
                method: 'POST',
                url: '{{URL::to('/dashboard/admin/submission/journal_ajax')}}',
                data: { _token: "{{csrf_token()}}", activation_statusdata: val, id: id_value },
                success: function (data) {
                    //
                    // sweet_alert(data, "success");
                    refreshPage()
                    showAlertModal(data);
                },
                error: function () {
                    sweet_alert("Something went Wrong!!!", "error");
                }
            })
        });

        $('#scheduled_on').change(function () {
            let val = $(this).val();
            var id_value = <?php echo $id ?>;
            console.log("running")
            $.ajax({
                method: 'POST',
                url: '{{URL::to('/dashboard/admin/submission/journal_ajax')}}',
                data: { _token: "{{csrf_token()}}", sheduled_ondata: val, id: id_value },
                success: function (data) {
                    //
                    // sweet_alert(data, "success");
                    refreshPage()
                    showAlertModal(data);
                },
                error: function () {
                    sweet_alert("Something went Wrong!!!", "error");
                }
            })
        });
// $('#scheduled_on').on('change', function () {
//     let val = $(this).val();
//     var id_value = {!! json_encode($id) !!};

//     $.ajax({
//         method: 'POST',
//         url: '{{ URL::to('/dashboard/admin/submission/journal_ajax') }}',
//         data: {
//             _token: "{{ csrf_token() }}",
//             scheduled_on: val,
//             id: id_value
//         },
//         success: function (data) {
//             refreshPage();
//             showAlertModal(data);
//         },
//         error: function () {
//             sweet_alert("Something went Wrong!!!", "error");
//         }
//     });
//     $('p strong:contains("Published on:")').parent().html(`<strong>Published on:</strong> ${val}`);

// });


        // $('#accept_save').on('click', function(){
        //     var id_value=<?php echo $id ?>;
        //     $.ajax({
        //     method: 'POST',
        //     url: '{{URL::to('/dashboard/admin/submission/copyright_form')}}',
        //     data:{ _token: "{{csrf_token()}}", id: id_value },
        //     success: function(response) {
        //         // Create a download link for the PDF
        //         var link = document.createElement('a');
        //         link.href = URL.createObjectURL(new Blob([response]));
        //         link.download = 'file.pdf';
        //         link.click();
        //     },
        //     error: function(xhr, status, error) {
        //         console.log(error);
        //     }
        //     })
        // });


        function sweet_alert(data, message) {
            Swal.fire({
                position: 'top-end',
                icon: message,
                title: data,
                showConfirmButton: false,
                timer: 2000
            })
        }

        // $(".form-control option").each(function() {
        //   $(this).siblings('[value="'+ this.value +'"]').remove();
        // })

        function showAlertModal(message) {
            // Set the alert message text
            document.getElementById("alert-message").innerHTML = message;

            // Show the alert modal
            var modal = document.getElementById("alert-modal");
            modal.classList.add("show");

            // Hide the alert modal after 3 seconds
            setTimeout(function () {
                modal.classList.remove("show");
            }, 3000);
        }

        function closeAlertModal() {
            // Hide the alert modal
            var modal = document.getElementById("alert-modal");
            modal.classList.remove("show");
        }

        function refreshPage() {
            location.reload(true);
        }

        function hideselectoptiontag() {

            // Get the select element
            // const selectElement = document.getElementById("journal_type");

            const selectElement = document.getElementById("status_type");

            // const selectElement = document.getElementById("status_type");

            // const selectElement = document.getElementById("status_type");

            // const selectElement = document.getElementById("status_type");

            // const selectElement = document.getElementById("status_type");

            // const selectElement = document.getElementById("status_type");

            // Get the selected option
            const selectedOption = selectElement.options[selectElement.selectedIndex];

            // Hide the selected option
            selectedOption.style.display = "none";

        }

        hideselectoptiontag();
        $(document).ready(function () {
            $('#nav-tab a[href="#{{ old('tab') }}"]').tab('show')
        });


        $('.review_decision').change(function () {
            let val = $(this).val();
            // alert(val);
            var id_value = <?php echo $id ?>;
            $.ajax({
                method: 'POST',
                url: '{{URL::to('/dashboard/admin/submission/review_decision')}}',
                data: { _token: "{{csrf_token()}}", status: val, id: id_value },
                success: function (data) {
                    //
                    // sweet_alert(data, "success");
                    // refreshPage()
                    showAlertModal(data);
                },
                error: function () {
                    sweet_alert("Something went Wrong!!!", "error");
                }
            })
        });


        $('#acceptance_status').change(function () {
            let val = $(this).val();
            // alert(val);
            var id_value = <?php echo $id ?>;
            $.ajax({
                method: 'POST',
                url: '{{URL::to('/dashboard/admin/submission/acceptance_status')}}',
                data: { _token: "{{csrf_token()}}", status: val, id: id_value },
                success: function (data) {
                    //
                    // sweet_alert(data, "success");
                    // refreshPage()
                    showAlertModal(data);
                    refreshPage()
                },
                error: function () {
                    sweet_alert("Something went Wrong!!!", "error");
                }
            })
        });


        $('#acceptance_action').change(function () {
            let val = $(this).val();

            var id_value = <?php echo $id ?>;
            $.ajax({
                method: 'POST',
                url: '{{URL::to('/dashboard/admin/submission/acceptance_action')}}',
                data: { _token: "{{csrf_token()}}", status: val, id: id_value },
                success: function (data) {
                    // alert(data);
                    //
                    // sweet_alert(data, "success");
                    // refreshPage()
                    showAlertModal(data);
                    afterRefreshthenpassthepostdata('acceptance');
                },
                error: function () {
                    sweet_alert("Something went Wrong!!!", "error");
                }
            })
        });
        $('#payment_status_1').change(function () {
            let val = $(this).val();
            // alert(val);
            var id_value = <?php echo $id ?>;
            $.ajax({
                method: 'POST',
                url: '{{URL::to('/dashboard/admin/submission/payment_status')}}',
                data: { _token: "{{csrf_token()}}", status: val, id: id_value },
                success: function (data) {
                    if (data === '') {
                        alert('Please Valid option');
                        return; // Stop execution
                    }
                    showAlertModal(data);
                    afterRefreshthenpassthepostdata('payments');
                },
                error: function () {
                    sweet_alert("Something went Wrong!!!", "error");
                }
            })
        });

        $('#payment_status_2').change(function () {
            let val = $(this).val();
            // alert(val);
            var id_value = <?php echo $id ?>;
            $.ajax({
                method: 'POST',
                url: '{{URL::to('/dashboard/admin/submission/payment_status')}}',
                data: { _token: "{{csrf_token()}}", status: val, id: id_value },
                success: function (data) {
                    if (data === '') {
                        alert('Please Valid option');
                        return; // Stop execution
                    }
                    showAlertModal(data);
                    afterRefreshthenpassthepostdata('payments');
                },
                error: function () {
                    // sweet_alert("Something went Wrong!!!", "error");
                }
            })
        });

        $('#payment_status_3').change(function () {
            let val = $(this).val();
            // alert(val);
            var id_value = <?php echo $id ?>;
            $.ajax({
                method: 'POST',
                url: '{{URL::to('/dashboard/admin/submission/payment_status')}}',
                data: { _token: "{{csrf_token()}}", status: val, id: id_value },
                success: function (data) {
                    if (data === '') {
                        alert('Please Enter Valid option');
                        return; // Stop execution
                    }
                    showAlertModal(data);
                    afterRefreshthenpassthepostdata('payments');
                },
                error: function () {
                    // sweet_alert("Something went Wrong!!!", "error");
                }
            })
        });
    </script>
    <script>
        $(document).ready(function () {
            const tabStorageKey = "activeNavTab";

            // On click, store the href of the active tab
            $('.nav-link[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                const activeTab = $(e.target).attr('href'); // e.g., "#tasks"
                localStorage.setItem(tabStorageKey, activeTab);
            });

            // On page load, check localStorage and activate the stored tab
            const lastTab = localStorage.getItem(tabStorageKey);
            if (lastTab) {
                const targetTab = $(`.nav-link[href="${lastTab}"]`);
                if (targetTab.length) {
                    targetTab.tab('show');
                }
            }
        });
            function godefault(){
                localStorage.setItem("activeNavTab", "#default");
            }
    </script>

@endsection