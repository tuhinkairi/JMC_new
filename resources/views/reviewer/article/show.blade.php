@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <!-- Include page breadcrumb -->
    @include('admin.inc.breadcrumb')
    <!-- end page title -->

    <div class="col-xl-8 col-lg-8">
        <div class="card">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h4 class="">Abstract</h4>
                    <hr>
                    </div>
                  <div class="ibox-content">
                @foreach ($rows as $row)
                <!-- Details View Start -->
                <h4><span class="text-highlight">Title:</span> {{ $row->title }}</h4>
                <h6><span class="text-highlight">Author:</span> {{ $row->name}}</h6>

                @if(is_file('uploads/'.$url.'/'.$row->image_path))
                <img src="{{ asset('uploads/'.$url.'/'.$row->image_path) }}" class="img-fluid" alt="Article">
                <br/>
                @endif

                @if(is_file('uploads/'.$url.'/'.$row->file_path))
                <a href="{{ asset('uploads/'.$url.'/'.$row->file_path) }}" class="btn btn-success" download>Download Documents</a>
                <br/>
                @endif

                @if(!empty($row->video_id))
                <p><span class="text-highlight">Youtube Video:</span></p>
                <div class="embed-responsive embed-responsive-16by9">
                  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $row->video_id }}?rel=0" allowfullscreen></iframe>
                </div>
                <br/>
                @endif

                <hr/>
                <p><span class="text-highlight">Research Area:</span> {{ $row->categoryname}}</p>
                <p><span class="text-highlight">Details:</span> {!! $row->description !!}</p>
                <p><span class="text-highlight">Publish Date:</span> {{ $row->start_date }}</p>

                <hr/>
                <p><span class="text-highlight">Review Status:</span>
                @if( $row->review_status == 2 )
                <span class="badge badge-success badge-pill">Approve</span>
                @elseif( $row->review_status == 1 )
                <span class="badge badge-primary badge-pill">Pending</span>
                @else
                <span class="badge badge-danger badge-pill">Reject</span>
                @endif
                </p>
                <p><span class="text-highlight">Status:</span>
                @if( $row->status == 1 )
                <span class="badge badge-success badge-pill">Active</span>
                @else
                <span class="badge badge-danger badge-pill">Inactive</span>
                @endif
                </p>
                <!-- Details View End -->
                @endforeach

                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
