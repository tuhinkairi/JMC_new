
@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- start page title -->
    <!-- Include page breadcrumb -->
    @include('admin.inc.breadcrumb')
    <!-- end page title -->

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
                        <h4 class="">Review List</h4>
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
                                <th>Decision</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $review)
                                <tr>
                                    <td>{{$review->id}}</td>
                                    <td><a href="{{url('dashboard/reviewer/review/show/'.$review->id)}}">{{$review->articlename}}</a></td>
                                    <td>{{$review->create_at}}</td>
                                    <td>{{$review->due_date}}</td>
                                    <td>
                                        {{$review->decision}}
                                    </td>
                                    <td>{{$review->status}}</td>
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



@endsection
