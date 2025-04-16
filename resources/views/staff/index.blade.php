@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- start page title -->
    <!-- Include page breadcrumb -->
    @include('admin.inc.breadcrumb')
    <!-- end page title -->

<!-- Start Content-->
<div class="container-fluid">

    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <!-- Include Flash Messages -->
                @include('admin.inc.message')
            </div>

            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h4 class="">Task List</h4>
                    </div>

                  <!-- Data Table Start -->
                  <div class="ibox-content">
                    <table class="table table-hover table-vcenter">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Article Title</th>
                                <th>Task Name</th>
                                <th>Due Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        @php
                            $count = 1;
                        @endphp
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>{{$count++}}</td>
                                    <td><a href="{{url('dashboard/staff/task/show/'.$task->id)}}">{{$task->articlename}}</a></td>
                                    <td>{{$task->task_name}}</td>
                                    <td>{{$task->due_date}}</td>
                                    <td>{{$task->taskstatus}}</td>
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


</div> <!-- container -->
<!-- End Content-->

@endsection
