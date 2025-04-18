@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <!-- Include page breadcrumb -->
    @include('admin.inc.breadcrumb')

    @if (!empty($answers))

    <form id="myForm" class="needs-validation" novalidate action="{{url('dashboard/admin/submission/edit-review-question/'.$id)}}" method="post" enctype="multipart/form-data">
        @csrf
            <div class="checkboxes1">
                <h4>1.  In your opinion, does the article manuscript adequately follow the journal's goals and scope?</h4><br>
                <ol>
                    @foreach ($answers as $answer)
                        @if ($answer->comment_1 == 'Hide from Author')
                            @php
                                $checked1 = 'checked';
                            @endphp
                        @elseif($answer->comment_1 == 'Not Applicable')
                            @php
                                $checked2 = 'checked';
                            @endphp
                        @elseif($answer->comment_1 == 'yes')
                            @php
                                $checked3 = 'checked';
                            @endphp
                        @else
                            @php
                                $checked4 = $answer->comment_1;
                             @endphp
                        @endif
                    @endforeach
                  
                    <li><input type="checkbox" id="comment_1" name="comment_1" value="yes" <?php if(isset($checked3)){ echo $checked3;} ?>>   yes</li>
                    <li><input type="checkbox" id="comment_1" value="No" id="no_1" <?php if(isset($checked4)){ echo 'checked';} ?>>    No</li>
                </ol>
                <p>If No, how could this be improved?</p>
                <div id="textarea1">
                    @if (isset($checked4))
                        <textarea class='form-control' name='comment_1' cols='100' required><?php if(isset($checked4)){ echo $checked4;} ?></textarea>
                    @endif
                </div>
            </div>

            <div class="checkboxes2">
                <h4>2.  Do you believe this topic is current?</h4><br>
                <ol>

                    @foreach ($answers as $answer)
                        @if ($answer->comment_2 == 'Hide from Author')
                            @php
                                $checked11 = 'checked';
                            @endphp
                        @elseif($answer->comment_2 == 'Not Applicable')
                            @php
                                $checked12 = 'checked';
                            @endphp
                        @elseif($answer->comment_2 == 'yes')
                            @php
                                $checked13 = 'checked';
                            @endphp
                        @else
                            @php
                                $checked14 = $answer->comment_2;
                             @endphp
                        @endif
                    @endforeach

                 
                    <li><input type="checkbox" name="comment_2" value="yes"  <?php if(isset($checked13)){ echo $checked13;} ?>>   yes</li>
                    <li><input type="checkbox" value="No" id="no_2"  <?php if(isset($checked14)){ echo 'checked';} ?>>    No</li>
                </ol>
                <p>If No, how could this be improved?</p>
                <div id="textarea2">
                    @if (isset($checked14))
                        <textarea class='form-control' name='comment_2' cols='100' required><?php if(isset($checked14)){ echo $checked14;} ?></textarea>
                    @endif
                </div>
            </div>

            <div class="checkboxes3">
                <h4>3.  Do you feel that the information that was presented and examined is sufficient?</h4><br>
                <ol>

                    @foreach ($answers as $answer)
                        @if ($answer->comment_3 == 'Hide from Author')
                            @php
                                $checked21 = 'checked';
                            @endphp
                        @elseif($answer->comment_3 == 'Not Applicable')
                            @php
                                $checked22 = 'checked';
                            @endphp
                        @elseif($answer->comment_3 == 'yes')
                            @php
                                $checked23 = 'checked';
                            @endphp
                        @else
                            @php
                                $checked24 = $answer->comment_3;
                             @endphp
                        @endif
                    @endforeach


                 
                    <li><input type="checkbox" name="comment_3" value="yes"  <?php if(isset($checked23)){ echo $checked23;} ?>>   yes</li>
                    <li><input type="checkbox" value="No" id="no_3" <?php if(isset($checked24)){ echo 'checked';} ?>>    No</li>
                </ol>
                <p>If No, how could this be improved?</p>
                <div id="textarea3">
                    @if (isset($checked24))
                        <textarea class='form-control' name='comment_3' cols='100' required><?php if(isset($checked24)){ echo $checked24;} ?></textarea>
                    @endif
                </div>
            </div>

            <div class="checkboxes4">
                <h4>4.  On a scale of 1 to 5,How do you consider to be the research design's quality?</h4><br>
                    <div id="textarea4">
                        <textarea class='form-control' name='comment_4' cols='100' required><?php if(isset($answers[0]->comment_4)){ echo $answers[0]->comment_4;} ?></textarea>
                    </div>
            </div>

            <div class="checkboxes5">
                <h4>5.  On a scale of 1 to 5, How realistic do you think the conclusions made in the article's manuscript are?</h4><br>
                <div id="textarea5">
                    <textarea class='form-control' name='comment_5' cols='100' required><?php if(isset($answers[0]->comment_5)){ echo $answers[0]->comment_5;} ?></textarea>
                </div>
            </div>

            <div class="checkboxes6">
                <h4>6.  On a scale of 1 to 5, How would you rank the work's managerial and practical significance?</h4><br>
                <div id="textarea6">
                    <textarea class='form-control' name='comment_6' cols='100' required><?php if(isset($answers[0]->comment_6)){ echo $answers[0]->comment_6;} ?></textarea>
                </div>
            </div>

            <div class="checkboxes7">
                <h4>7.  On a scale of 1 to 5, How would you rank the information's level of clarity?</h4><br>
                <div id="textarea7">
                    <textarea class='form-control' name='comment_7' cols='100' required><?php if(isset($answers[0]->comment_7)){ echo $answers[0]->comment_7;} ?></textarea>
                </div>
            </div>

            <div class="checkboxes8">
                <h4>8.  On a scale of 1 to 5, how do you rank the reference used? Specifically, can you tell me if they are plenty, suitable, and current?</h4><br>
                <div id="textarea8">
                    <textarea class='form-control' name='comment_8' cols='100' required><?php if(isset($answers[0]->comment_8)){ echo $answers[0]->comment_8;} ?></textarea>
                </div>
            </div>

            <div class="checkboxes9">
                <h4>9.  What, in your opinion, are the article's general weaknesses? List any specific recommendations for enhancement or improvement. (Mandatory):</h4><br>
                <ol>

                    @foreach ($answers as $answer)
                        @if ($answer->comment_9 == 'Hide from Author')
                            @php
                                $checked81 = 'checked';
                            @endphp
                        @elseif($answer->comment_9 == 'Not Applicable')
                            @php
                                $checked82 = 'checked';
                            @endphp
                        @elseif($answer->comment_9 == 'yes')
                            @php
                                $checked83 = 'checked';
                            @endphp
                        @else
                            @php
                                $checked84 = $answer->comment_9;
                             @endphp
                        @endif
                    @endforeach


                    <li><input type="checkbox" name="comment_9" value="Hide from Author"  <?php if(isset($checked81)){ echo $checked81;} ?>>  Hide from Author</li>
                    <li><input type="checkbox" name="comment_9" value="Not Applicable"  <?php if(isset($checked82)){ echo $checked82;} ?>>    Not Applicable</li>
                    <li><input type="checkbox" name="comment_9" value="yes"  <?php if(isset($checked83)){ echo $checked83;} ?>>   yes</li>
                    <li><input type="checkbox" value="No" id="no_9" <?php if(isset($checked84)){ echo 'checked';} ?>>    No</li>
                </ol>
                <p>If No, how could this be improved?</p>
                <div id="textarea9">
                    @if (isset($checked84))
                        <textarea class='form-control' name='comment_9' cols='100' required><?php if(isset($checked84)){ echo $checked84;} ?></textarea>
                    @endif
                </div>
            </div>

            <div class="checkboxes10">
                <h4>10. What, in your opinion, are the article's main points of strength? (Mandatory):</h4><br>
                <ol>

                    @foreach ($answers as $answer)
                        @if ($answer->comment_10 == 'Hide from Author')
                            @php
                                $checked91 = 'checked';
                            @endphp
                        @elseif($answer->comment_10 == 'Not Applicable')
                            @php
                                $checked92 = 'checked';
                            @endphp
                        @elseif($answer->comment_10 == 'yes')
                            @php
                                $checked93 = 'checked';
                            @endphp
                        @else
                            @php
                                $checked94 = $answer->comment_10;
                             @endphp
                        @endif
                    @endforeach


                    <li><input type="checkbox" name="comment_10" value="Hide from Author"  <?php if(isset($checked91)){ echo $checked91;} ?>>  Hide from Author</li>
                    <li><input type="checkbox" name="comment_10" value="Not Applicable"  <?php if(isset($checked92)){ echo $checked92;} ?>>    Not Applicable</li>
                    <li><input type="checkbox" name="comment_10" value="yes"  <?php if(isset($checked93)){ echo $checked93;} ?>>   yes</li>
                    <li><input type="checkbox" value="No" id="no_10" <?php if(isset($checked94)){ echo 'checked';} ?>>    No</li>
                </ol>
                <p>If No, how could this be improved?</p>
                <div id="textarea10">
                    @if (isset($checked94))
                        <textarea class='form-control' name='comment_10' cols='100' required><?php if(isset($checked94)){ echo $checked94;} ?></textarea>
                    @endif
                </div>
            </div>

            <div class="checkboxes11">
                <h4>11. Please offer the authors any more helpful criticism so they can improve and revise their work.</h4><br>
                <ol>

                    @foreach ($answers as $answer)
                        @if ($answer->comment_11 == 'Hide from Author')
                            @php
                                $checked101 = 'checked';
                            @endphp
                        @elseif($answer->comment_11 == 'Not Applicable')
                            @php
                                $checked102 = 'checked';
                            @endphp
                        @elseif($answer->comment_11 == 'yes')
                            @php
                                $checked103 = 'checked';
                            @endphp
                        @else
                            @php
                                $checked104 = $answer->comment_11;
                             @endphp
                        @endif
                    @endforeach


                    <li><input type="checkbox" name="comment_11" value="Hide from Author"  <?php if(isset($checked101)){ echo $checked101;} ?>>  Hide from Author</li>
                    <li><input type="checkbox" name="comment_11" value="Not Applicable"  <?php if(isset($checked102)){ echo $checked102;} ?>>    Not Applicable</li>
                    <li><input type="checkbox" name="comment_11" value="yes"  <?php if(isset($checked103)){ echo $checked103;} ?>>   yes</li>
                    <li><input type="checkbox" value="No" id="no_11" <?php if(isset($checked104)){ echo 'checked';} ?>>    No</li>
                </ol>
                <p>If No, how could this be improved?</p>
                <div id="textarea11">
                    @if (isset($checked104))
                        <textarea class='form-control' name='comment_11' cols='100' required><?php if(isset($checked104)){ echo $checked104;} ?></textarea>
                    @endif
                </div>
            </div>

            <div class="checkboxes12">
                <h4>12. Your Editorial Decision:</h4><br>
                <ol>

                    @foreach ($answers as $answer)
                        @if ($answer->comment_12 == 'Accept')
                            @php
                                $checked111 = 'checked';
                            @endphp
                        @elseif($answer->comment_12 == 'Accept after Specified Revisions')
                            @php
                                $checked112 = 'checked';
                            @endphp
                        @elseif($answer->comment_12 == 'Reject')
                            @php
                                $checked113 = $answer->comment_12;
                            @endphp
                        @endif
                    @endforeach


                    <li><input type="checkbox" name="comment_12" value="Accept"  <?php if(isset($checked111)){ echo $checked111;} ?>>  Accept</li>
                    <li><input type="checkbox" name="comment_12" value="Accept after Specified Revisions"  <?php if(isset($checked112)){ echo $checked112;} ?>>    Accept after Specified Revisions</li>
                    <li><input type="checkbox" name="comment_12" value="Reject"  <?php if(isset($checked113)){ echo $checked113;} ?>>   Reject</li>
                </ol>
            </div>

            <div class="">
                <h4>13. Overall comments to the Editor(s)-in-Chief:</h4><br>
                @php
                    if(!empty($answers[0]->comment_13))
                    $comment_13 = $answers[0]->comment_13
                @endphp
                <textarea class='form-control' name='comment_13' cols='100' required><?php if(isset($comment_13)){ echo $comment_13;} ?></textarea>
            </div>

            <div class="">
                <h4>14. Comment Documents (Accessible to the Author)</h4><br>
                @foreach ($answers as $answer)
                        @if ($answer->comment_14 == 'Yes')
                            @php
                                $checked121 = 'checked';
                            @endphp
                        @elseif($answer->comment_14 == 'No')
                            @php
                                $checked122 = 'checked';
                            @endphp
                        @endif
                    @endforeach
                <ol>
                    <li><input type="checkbox" id="comment_14" name="comment_14" value="Yes" <?php if(isset($checked121)){ echo $checked121;} ?>>  Yes</li>
                    <li><input type="checkbox" id="comment_14" name="comment_14" value="No" <?php if(isset($checked122)){ echo $checked122;} ?>>    No</li>
                </ol>
            </div><br><br>
            <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    @else

    <form id="myForm" class="needs-validation" novalidate action="{{url('dashboard/admin/submission/add-review-question/'.$id)}}" method="post" enctype="multipart/form-data">
        @csrf
            <div class="checkboxes1">
                <h4>1.  In your opinion, does the article manuscript adequately follow the journal's goals and scope?</h4><br>
                <ol>
                    <li><input type="checkbox" name="comment_1" value="Hide from Author" required>  Hide from Author</li>
                    <li><input type="checkbox" name="comment_1" value="Not Applicable" required>    Not Applicable</li>
                    <li><input type="checkbox" name="comment_1" value="yes" required>   yes</li>
                    <li><input type="checkbox" value="No" id="no_1" required>    No</li>
                </ol>
                <p>If No, how could this be improved?</p>
                <div id="textarea1">

                </div>
            </div>

            <div class="checkboxes2">
                <h4>2.  Do you believe this topic is current?</h4><br>
                <ol>
                    <li><input type="checkbox" name="comment_2" value="Hide from Author" required>  Hide from Author</li>
                    <li><input type="checkbox" name="comment_2" value="Not Applicable" required>    Not Applicable</li>
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
                    <li><input type="checkbox" name="comment_3" value="Hide from Author" required>  Hide from Author</li>
                    <li><input type="checkbox" name="comment_3" value="Not Applicable" required>    Not Applicable</li>
                    <li><input type="checkbox" name="comment_3" value="yes" required>   yes</li>
                    <li><input type="checkbox" value="No" id="no_3" required>    No</li>
                </ol>
                <p>If No, how could this be improved?</p>
                <div id="textarea3">

                </div>
            </div>

            <div class="checkboxes4">
                <h4>4.  On a scale of 1 to 5,How do you consider to be the research design's quality?</h4><br>
                <div id="textarea4">
                    <textarea class='form-control' name='comment_4' cols='100' required></textarea>
                </div>
            </div>

            <div class="checkboxes5">
                <h4>5.  On a scale of 1 to 5, How realistic do you think the conclusions made in the article's manuscript are?</h4><br>
                <div id="textarea5">
                    <textarea class='form-control' name='comment_5' cols='100' required></textarea>
                </div>
            </div>

            <div class="checkboxes6">
                <h4>6.  On a scale of 1 to 5, How would you rank the work's managerial and practical significance?</h4><br>
                <div id="textarea6">
                    <textarea class='form-control' name='comment_6' cols='100' required></textarea>
                </div>
            </div>

            <div class="checkboxes7">
                <h4>7.  On a scale of 1 to 5, How would you rank the information's level of clarity?</h4><br>
                <div id="textarea7">
                    <textarea class='form-control' name='comment_7' cols='100' required></textarea>
                </div>
            </div>

            <div class="checkboxes8">
                <h4>8.  On a scale of 1 to 5, how do you rank the reference used? Specifically, can you tell me if they are plenty, suitable, and current?</h4><br>
                <div id="textarea8">
                    <textarea class='form-control' name='comment_8' cols='100' required></textarea>
                </div>
            </div>

            <div class="checkboxes9">
                <h4>9.  What, in your opinion, are the article's general weaknesses? List any specific recommendations for enhancement or improvement. (Mandatory):</h4><br>
                <ol>
                    <li><input type="checkbox" name="comment_9" value="Hide from Author" required>  Hide from Author</li>
                    <li><input type="checkbox" name="comment_9" value="Not Applicable" required>    Not Applicable</li>
                    <li><input type="checkbox" name="comment_9" value="yes" required>   yes</li>
                    <li><input type="checkbox" value="No" id="no_9">    No</li>
                </ol>
                <p>If No, how could this be improved?</p>
                <div id="textarea9">

                </div>
            </div>

            <div class="checkboxes10">
                <h4>10. What, in your opinion, are the article's main points of strength? (Mandatory):</h4><br>
                <ol>
                    <li><input type="checkbox" name="comment_10" value="Hide from Author" required>  Hide from Author</li>
                    <li><input type="checkbox" name="comment_10" value="Not Applicable" required>    Not Applicable</li>
                    <li><input type="checkbox" name="comment_10" value="yes" required>   yes</li>
                    <li><input type="checkbox" value="No" id="no_10" required>    No</li>
                </ol>
                <p>If No, how could this be improved?</p>
                <div id="textarea10">

                </div>
            </div>

            <div class="checkboxes11">
                <h4>11. Please offer the authors any more helpful criticism so they can improve and revise their work.</h4><br>
                <ol>
                    <li><input type="checkbox" name="comment_11" value="Hide from Author" required>  Hide from Author</li>
                    <li><input type="checkbox" name="comment_11" value="Not Applicable" required>    Not Applicable</li>
                    <li><input type="checkbox" name="comment_11" value="yes" required>   yes</li>
                    <li><input type="checkbox" value="No" id="no_11" required>    No</li>
                </ol>
                <p>If No, how could this be improved?</p>
                <div id="textarea11">

                </div>
            </div>

            <div class="checkboxes12">
                <h4>12. Your Editorial Decision:</h4><br>
                <ol>
                    <li><input type="checkbox" name="comment_12" value="Accept" required>  Accept</li>
                    <li><input type="checkbox" name="comment_12" value="Accept after Specified Revisions" required>    Accept after Specified Revisions</li>
                    <li><input type="checkbox" name="comment_12" value="Reject" required>   Reject</li>
                </ol>
            </div>

            <div class="">
                <h4>13. Overall comments to the Editor(s)-in-Chief:</h4><br>
                <textarea class='form-control' name='comment_13' cols='100' required></textarea>
            </div>

            <div class="checkboxes14">
                <h4>14. Comment Documents (Accessible to the Author)</h4><br>
                <ol>
                    <li><input type="checkbox" id="comment_14" name="comment_14" value="Yes" required>  Yes</li>
                    <li><input type="checkbox" id="comment_14" name="comment_14" value="No" required>    No</li>
                </ol>

            </div><br><br>
            <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    @endif

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

    $('.checkboxes14 input[type="checkbox"]').on('click', function() {
        if ($(this).prop('checked')) {
            // Disable all other checkboxes
            $('.checkboxes14 input[type="checkbox"]').not(this).prop('disabled', true);
        } else {
            // Enable all checkboxes
            $('.checkboxes14 input[type="checkbox"]').prop('disabled', false);
        }
    });





</script>
@endsection
