@extends('admin.layouts.master')
@section('title', $title)
@section('content')
<style>
.staff-profile-image-small {
    height: 32px;
    width: 32px;
    border-radius: 50%;
}
</style>
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <!-- Include page breadcrumb -->
    @include('admin.inc.breadcrumb')
    <!-- end page title -->

    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-title">
                        @foreach ($rows as $row)
                        <h3><span class="text-highlight">Tittle:</span> {{ $row->title }}</h3>
                    <hr>
                    </div>
                  <div class="ibox-content">
                <!-- Details View Start -->

                <div class="row">
                    <div class="col-md-12">

                        <div class="row">

                            <div class="col-md-4 col-xs-12" style="margin-bottom: 20px;">
                                <h4><span class="text-highlight">Author: <img src="https://png.pngtree.com/png-clipart/20210129/ourmid/pngtree-default-male-avatar-png-image_2811083.jpg" class="staff-profile-image-small" alt="Default Profile Picture"></span> {{ $row->name}}</h4>
                            </div>

                            <div class="col-md-4 col-xs-12" style="margin-bottom: 20px;">
                                <h4><span class="text-highlight">Research Area:</span> {{ $row->categoryname}}</h4>
                            </div>

                            <div class="col-md-4 col-xs-12" style="margin-bottom: 20px;">
                                <h4><span class="text-highlight">Status:</span>
                                    <span class="badge badge-success badge-pill">{{$row->statustype}}</span>
                                </h4>
                            </div>

                            <div class="col-md-4 col-xs-12" style="margin-bottom: 20px;">
                                <h4><span class="text-highlight">Publish Date:</span>
                                    <span class="text-highlight"></span> {{ $row->start_date }}
                                </h4>
                            </div>

                            <div class="col-md-4 col-xs-12" style="margin-bottom: 20px;">
                                @if(is_file('uploads/'.$url.'/'.$row->file_path))
                                <a href="{{ asset('uploads/'.$url.'/'.$row->file_path) }}" class="btn btn-success" download><i class="fa fa-download" aria-hidden="true"></i>  Download Documents</a>
                                <br/>
                                @endif
                            </div>


                            <div class="col-md-12 col-xs-12">

                                <h4><span class="text-highlight">Details:</span></h4>
                                <textarea class="form-control summernote" name="notes" id="notes" rows="8">{{ $row->description }}</textarea>

                            </div>

                        </div>
                    </div>
                </div>

                {{-- @if(is_file('uploads/'.$url.'/'.$row->image_path))
                <img src="{{ asset('uploads/'.$url.'/'.$row->image_path) }}" class="img-fluid" alt="Article">
                <br/>
                @endif --}}

                {{-- @if(is_file('uploads/'.$url.'/'.$row->file_path))
                <a href="{{ asset('uploads/'.$url.'/'.$row->file_path) }}" class="btn btn-success" download><i class="fa fa-download" aria-hidden="true"></i>  Download Documents</a>
                <br/>
                @endif --}}

                {{-- @if(!empty($row->video_id))
                <p><span class="text-highlight">Youtube Video:</span></p>
                <div class="embed-responsive embed-responsive-16by9">
                  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $row->video_id }}?rel=0" allowfullscreen></iframe>
                </div>
                <br/>
                @endif --}}
                <!-- Details View End -->
                @endforeach

                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
