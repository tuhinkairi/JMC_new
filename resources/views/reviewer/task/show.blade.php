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

    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card-body p-0">
                <div class="p-3 pb-0">
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
                                        <a data-toggle="tab" class="nav-link active" href="#details"><i class="fa fa-th"></i> Details</a>
                                    </li>
                                    @if (empty($answers))
                                    <li class="nav-item">
                                        <a data-toggle="tab" class="nav-link" href="#questions"><i class="fa fa-tasks"></i> Review Questions</a>
                                    </li>
                                    @endif
                                </ul>
                                </div>

                                <div class="card-body">
                                <div class="tab-content">
                                    <div id="details" class="tab-pane ib-tab-box active">
                                        <div class="">
                                            <div class="">
                                                <div class="">
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
                                                                <h4><span class="text-highlight">Status:</span>
                                                                    <span class="badge badge-success badge-pill">{{$row->statustype}}</span>
                                                                </h4>
                                                            </div>

                                       

                                                            <div class="col-md-4 col-xs-12" style="margin-bottom: 20px;">
                                                                @if(is_file('uploads/article/'.$row->file_path))
                                                                <a href="{{ asset('uploads/article/'.$row->file_path) }}" class="btn btn-success" download><i class="fa fa-download" aria-hidden="true"></i>  Download Documents</a>
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

                                    <div id="questions" class="tab-pane ib-tab-box">
                                        <form id="myForm" class="needs-validation" novalidate action="{{url('dashboard/reviewer/review/add-review-question/'.$id)}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="checkboxes1">
                                                <h4>1.  In your opinion, does the article manuscript adequately follow the journal's goals and scope?</h4><br>
                                                <ol>

                                                    <li ><input type="checkbox"  id="comment_1" name="comment_1" value="yes" required>   yes</li>
                                                    <li ><input type="checkbox" value="No" id="no_1" required>    No</li>
                                                </ol>
                                                <p>If No, how could this be improved?</p>
                                                <div id="textarea1">

                                                </div>
                                            </div>

                                            <div class="checkboxes2">
                                                <h4>2.  Do you believe this topic is current?</h4><br>
                                                <ol>
                                                 
                                                    <li><input type="checkbox" name="comment_2" value="yes" required>   yes</li>
                                                    <li><input type="checkbox" value="No" id="no_2" required>    No</li>
                                                </ol>
                                                <p>If No, how could this be improved?</p>
                                                <div id="textarea2">

                                                </div>
                                            </div>

                                            <div class="checkboxes3">
                                                <h4>3.  Do you feel that the information that was presented and examined is sufficient?</h4><br>
                                                <ol>
                                                
                                                    <li><input type="checkbox" name="comment_3" value="yes" required>   yes</li>
                                                    <li><input type="checkbox" value="No" id="no_3" required>    No</li>
                                                </ol>
                                                <p>If No, how could this be improved?</p>
                                                <div id="textarea3">

                                                </div>
                                            </div>

                                            <div class="checkboxes4">
                                                <h4>4.  On a scale of 1 to 5,How do you consider to be the research design's quality?</h4><br>
                                                <ul>
                                                    <li><input type="checkbox" name="comment_4" value="1" required> 1</li>
                                                    <li><input type="checkbox" name="comment_4" value="2" required> 2</li>
                                                    <li><input type="checkbox" name="comment_4" value="3" required> 3</li>
                                                    <li><input type="checkbox" name="comment_4" value="4" required> 4</li>
                                                </ul>
                                                <p>If No, how could this be improved?</p>
                                                <div id="textarea4">

                                                </div>
                                            </div>

                                            <div class="checkboxes5">
                                                <h4>5.  On a scale of 1 to 5, How realistic do you think the conclusions made in the article's manuscript are?</h4><br>
                                                <ul>
                                                <li><input type="checkbox" name="comment_5" value="1" required> 1</li>
                                                    <li><input type="checkbox" name="comment_5" value="2" required> 2</li>
                                                    <li><input type="checkbox" name="comment_5" value="3" required> 3</li>
                                                    <li><input type="checkbox" name="comment_5" value="4" required> 4</li>
                                                </ul>
                                                <p>If No, how could this be improved?</p>
                                                <div id="textarea5">

                                                </div>
                                            </div>

                                            <div class="checkboxes6">
                                                <h4>6.  On a scale of 1 to 5, How would you rank the work's managerial and practical significance?</h4><br>
                                                <ul>
                                                <li><input type="checkbox" name="comment_6" value="1" required> 1</li>
                                                    <li><input type="checkbox" name="comment_6" value="2" required> 2</li>
                                                    <li><input type="checkbox" name="comment_6" value="3" required> 3</li>
                                                    <li><input type="checkbox" name="comment_6" value="4" required> 4</li>
                                                </ul>
                                                <p>If No, how could this be improved?</p>
                                                <div id="textarea6">

                                                </div>
                                            </div>

                                            <div class="checkboxes7">
                                                <h4>7.  On a scale of 1 to 5, How would you rank the information's level of clarity?</h4><br>
                                                <ul>
                                                <li><input type="checkbox" name="comment_7" value="1" required> 1</li>
                                                    <li><input type="checkbox" name="comment_7" value="2" required> 2</li>
                                                    <li><input type="checkbox" name="comment_7" value="3" required> 3</li>
                                                    <li><input type="checkbox" name="comment_7" value="4" required> 4</li>
                                                </ul>
                                                <p>If No, how could this be improved?</p>
                                                <div id="textarea7">

                                                </div>
                                            </div>

                                            <div class="checkboxes8">
                                                <h4>8.  On a scale of 1 to 5, how do you rank the reference used? Specifically, can you tell me if they are plenty, suitable, and current?</h4><br>
                                                <ul>
                                                <li><input type="checkbox" name="comment_8" value="1" required> 1</li>
                                                    <li><input type="checkbox" name="comment_8" value="2" required> 2</li>
                                                    <li><input type="checkbox" name="comment_8" value="3" required> 3</li>
                                                    <li><input type="checkbox" name="comment_8" value="4" required> 4</li>
                                                </ul>
                                                <p>If No, how could this be improved?</p>
                                                <div id="textarea8">

                                                </div>
                                            </div>

                                            <div class="checkboxes9">
                                                <h4>9.  What, in your opinion, are the article's general weaknesses? List any specific recommendations for enhancement or improvement. (Mandatory):</h4><br>
                                                
                                                    <input type='text' class="form-control" name="comment_9" placeholder="Type your opinion" required>
                                                

                                            </div>

                                            <div class="checkboxes10">
                                                <h4>10. What, in your opinion, are the article's main points of strength? (Mandatory):</h4><br>
                                                <input type='text'class="form-control" name="comment_10" placeholder="Type your opinion" required>
                                            </div>

                                            <div class="checkboxes11">
                                                <h4>11. Please offer the authors any more helpful criticism so they can improve and revise their work.</h4><br>
                                                <input type='text'class="form-control" name="comment_11" placeholder="Type your opinion" required>
                                            </div>

                                            <br><br>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
                                    </div>
                                </div>
                                </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>



    // Add a click event listener to the checkboxes
    $('.checkboxes1 input[type="checkbox"]').on('click', function() {
        if ($(this).prop('checked')) {
            // Disable all other checkboxes
            $('.checkboxes1 input[type="checkbox"]').not(this).prop('disabled', true);
        } else {
            // Enable all checkboxes
            $('.checkboxes1 input[type="checkbox"]').prop('disabled', false);
        }
    });

    $('#no_1').on('click', function() {
        if ($(this).prop('checked')) {
            $("#textarea1").append("<textarea class='form-control' name='comment_1' cols='100' required></textarea>");
        } else {
            $("#textarea1").empty();
        }
    });

    // Add a click event listener to the checkboxes
    $('.checkboxes2 input[type="checkbox"]').on('click', function() {
        if ($(this).prop('checked')) {
            // Disable all other checkboxes
            $('.checkboxes2 input[type="checkbox"]').not(this).prop('disabled', true);
        } else {
            // Enable all checkboxes
            $('.checkboxes2 input[type="checkbox"]').prop('disabled', false);
        }
    });

    $('#no_2').on('click', function() {
        if ($(this).prop('checked')) {
            $("#textarea2").append("<textarea class='form-control' name='comment_2' cols='100' required></textarea>");
        } else {
            $("#textarea2").empty();
        }
    });


    // Add a click event listener to the checkboxes
    $('.checkboxes3 input[type="checkbox"]').on('click', function() {
        if ($(this).prop('checked')) {
            // Disable all other checkboxes
            $('.checkboxes3 input[type="checkbox"]').not(this).prop('disabled', true);
        } else {
            // Enable all checkboxes
            $('.checkboxes3 input[type="checkbox"]').prop('disabled', false);
        }
    });

    $('#no_3').on('click', function() {
        if ($(this).prop('checked')) {
            $("#textarea3").append("<textarea class='form-control' name='comment_3' cols='100' required></textarea>");
        } else {
            $("#textarea3").empty();
        }
    });

    // Add a click event listener to the checkboxes
    $('.checkboxes4 input[type="checkbox"]').on('click', function() {
        if ($(this).prop('checked')) {
            // Disable all other checkboxes
            $('.checkboxes4 input[type="checkbox"]').not(this).prop('disabled', true);
        } else {
            // Enable all checkboxes
            $('.checkboxes4 input[type="checkbox"]').prop('disabled', false);
        }
    });


    $('#no_4').on('click', function() {
        if ($(this).prop('checked')) {
            $("#textarea4").append("<textarea class='form-control' name='comment_4' cols='100' required></textarea>");
        } else {
            $("#textarea4").empty();
        }
    });

    // Add a click event listener to the checkboxes
    $('.checkboxes5 input[type="checkbox"]').on('click', function() {
        if ($(this).prop('checked')) {
            // Disable all other checkboxes
            $('.checkboxes5 input[type="checkbox"]').not(this).prop('disabled', true);
        } else {
            // Enable all checkboxes
            $('.checkboxes5 input[type="checkbox"]').prop('disabled', false);
        }
    });

    $('#no_5').on('click', function() {
        if ($(this).prop('checked')) {
            $("#textarea5").append("<textarea class='form-control' name='comment_5' cols='100' required></textarea>");
        } else {
            $("#textarea5").empty();
        }
    });

    // Add a click event listener to the checkboxes
    $('.checkboxes6 input[type="checkbox"]').on('click', function() {
        if ($(this).prop('checked')) {
            // Disable all other checkboxes
            $('.checkboxes6 input[type="checkbox"]').not(this).prop('disabled', true);
        } else {
            // Enable all checkboxes
            $('.checkboxes6 input[type="checkbox"]').prop('disabled', false);
        }
    });

    $('#no_6').on('click', function() {
        if ($(this).prop('checked')) {
            $("#textarea6").append("<textarea class='form-control' name='comment_6' cols='100' required></textarea>");
        } else {
            $("#textarea6").empty();
        }
    });

    // Add a click event listener to the checkboxes
    $('.checkboxes7 input[type="checkbox"]').on('click', function() {
        if ($(this).prop('checked')) {
            // Disable all other checkboxes
            $('.checkboxes7 input[type="checkbox"]').not(this).prop('disabled', true);
        } else {
            // Enable all checkboxes
            $('.checkboxes7 input[type="checkbox"]').prop('disabled', false);
        }
    });


    $('#no_7').on('click', function() {
        if ($(this).prop('checked')) {
            $("#textarea7").append("<textarea class='form-control' name='comment_7' cols='100' required></textarea>");
        } else {
            $("#textarea7").empty();
        }
    });

    // Add a click event listener to the checkboxes
    $('.checkboxes8 input[type="checkbox"]').on('click', function() {
        if ($(this).prop('checked')) {
            // Disable all other checkboxes
            $('.checkboxes8 input[type="checkbox"]').not(this).prop('disabled', true);
        } else {
            // Enable all checkboxes
            $('.checkboxes8 input[type="checkbox"]').prop('disabled', false);
        }
    });


    $('#no_8').on('click', function() {
        if ($(this).prop('checked')) {
            $("#textarea8").append("<textarea class='form-control' name='comment_8' cols='100' required></textarea>");
        } else {
            $("#textarea8").empty();
        }
    });

    // Add a click event listener to the checkboxes
    $('.checkboxes9 input[type="checkbox"]').on('click', function() {
        if ($(this).prop('checked')) {
            // Disable all other checkboxes
            $('.checkboxes9 input[type="checkbox"]').not(this).prop('disabled', true);
        } else {
            // Enable all checkboxes
            $('.checkboxes9 input[type="checkbox"]').prop('disabled', false);
        }
    });


    $('#no_9').on('click', function() {
        if ($(this).prop('checked')) {
            $("#textarea9").append("<textarea class='form-control' name='comment_9' cols='100' required></textarea>");
        } else {
            $("#textarea9").empty();
        }
    });

    // Add a click event listener to the checkboxes
    $('.checkboxes10 input[type="checkbox"]').on('click', function() {
        if ($(this).prop('checked')) {
            // Disable all other checkboxes
            $('.checkboxes10 input[type="checkbox"]').not(this).prop('disabled', true);
        } else {
            // Enable all checkboxes
            $('.checkboxes10 input[type="checkbox"]').prop('disabled', false);
        }
    });

    $('#no_10').on('click', function() {
        if ($(this).prop('checked')) {
            $("#textarea10").append("<textarea class='form-control' name='comment_10' cols='100' required></textarea>");
        } else {
            $("#textarea10").empty();
        }
    });

    // Add a click event listener to the checkboxes
    $('.checkboxes11 input[type="checkbox"]').on('click', function() {
        if ($(this).prop('checked')) {
            // Disable all other checkboxes
            $('.checkboxes11 input[type="checkbox"]').not(this).prop('disabled', true);
        } else {
            // Enable all checkboxes
            $('.checkboxes11 input[type="checkbox"]').prop('disabled', false);
        }
    });

    $('#no_11').on('click', function() {
        if ($(this).prop('checked')) {
            $("#textarea11").append("<textarea class='form-control' name='comment_11' cols='100' required></textarea>");
        } else {
            $("#textarea11").empty();
        }
    });

    // Add a click event listener to the checkboxes
    $('.checkboxes12 input[type="checkbox"]').on('click', function() {
        if ($(this).prop('checked')) {
            // Disable all other checkboxes
            $('.checkboxes12 input[type="checkbox"]').not(this).prop('disabled', true);
        } else {
            // Enable all checkboxes
            $('.checkboxes12 input[type="checkbox"]').prop('disabled', false);
        }
    });







</script>
@endsection
