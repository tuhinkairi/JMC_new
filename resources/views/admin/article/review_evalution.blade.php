@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <!-- Include page breadcrumb -->
    @include('admin.inc.breadcrumb')


    @foreach ($rows as $row)


        <div class="question_box checkboxes1">
            <div class="checkboxes1">
              <h4>In your opinion, does the article manuscript adequately follow the journal's goals and scope?</h4><br>
                    <ul>
                    <li><h5>{{$row->comment_1}}</h5></li>
                    </ul>

            </div>
        </div>
        <br>




     
        <div class="question_box checkboxes2">
            <div class="checkboxes2">
                <h4>Do you believe this topic is current?</h4><br>
                <ul>
                    <li><h5>{{$row->comment_2}}</h5></li>
                    </ul>
            </div>
        </div><br>
       



       
        <div class="question_box checkboxes3">
            <div class="checkboxes3">
                <h4>Do you feel that the information that was presented and examined is sufficient?</h4><br>
                <ul>
                    <li><h5>{{$row->comment_3}}</h5></li>
                    </ul>
            </div>
        </div>
            <br>
     



        <div class="question_box checkboxes4">
            <div class="checkboxes4">
                <h4>On a scale of 1 to 5,How do you consider to be the research design's quality?</h4><br>
                <ul>
                    <li><h5>{{$row->comment_4}}</h5></li>
                    </ul>
            </div>
        </div><br>
        




        <div class="question_box checkboxes5">
            <div class="checkboxes5">
                <h4>On a scale of 1 to 5, How realistic do you think the conclusions made in the article's manuscript are?</h4><br>
                <ul>
                    <li><h5>{{$row->comment_5}}</h5></li>
                    </ul>
            </div>
        </div><br>
       


       
        <div class="question_box checkboxes6">
            <div class="checkboxes6">
                <h4>On a scale of 1 to 5, How would you rank the work's managerial and practical significance?</h4><br>
                <ul>
                    <li><h5>{{$row->comment_6}}</h5></li>
                    </ul>
            </div>
        </div><br>
      



    
        <div class="question_box checkboxes7">
            <div class="checkboxes7">
                <h4>On a scale of 1 to 5, How would you rank the information's level of clarity?</h4><br>
                <ul>
                    <li><h5>{{$row->comment_7}}</h5></li>
                    </ul>
            </div>
        </div><br>
        


        <div class="question_box checkboxes8">
            <div class="checkboxes8">
                <h4>On a scale of 1 to 5, how do you rank the reference used? Specifically, can you tell me if they are plenty, suitable, and current?</h4><br>
                <ul>
                    <li><h5>{{$row->comment_8}}</h5></li>
                    </ul>
            </div>
        </div><br>
 



        <div class="question_box checkboxes9">
            <div class="checkboxes9">
                <h4>What, in your opinion, are the article's general weaknesses? List any specific recommendations for enhancement or improvement. (Mandatory):</h4><br>
                <ul>
                    <li><h5>{{$row->comment_9}}</h5></li>
                    </ul>
            </div>
        </div><br>





        <div class="question_box checkboxes10">
            <div class="checkboxes10">
                <h4>What, in your opinion, are the article's main points of strength? (Mandatory):</h4><br>
                <ul>
                    <li><h5>{{$row->comment_10}}</h5></li>
                    </ul>
            </div>
        </div><br>
 



        
        <div class="question_box checkboxes11">
            <div class="checkboxes11">
                <h4>Please offer the authors any more helpful criticism so they can improve and revise their work.</h4><br>
                <ul>
                    <li><h5>{{$row->comment_11}}</h5></li>
                    </ul>
            </div>
        </div><br>
    




        <div class="question_box checkboxes12">
            <div class="checkboxes12">
                <h4>Your Editorial Decision:</h4><br>
                <ul>
                    <li><h5>{{$row->comment_12}}</h5></li>
                </ul>
            </div>
        </div><br>
    




        <div class="question_box">
            <div class="">
                <h4>Overall comments to the Editor(s)-in-Chief:</h4><br>
                <ul>
                    <li><h5>{{$row->comment_13}}</h5></li>
                    </ul>
            </div>
        </div><br>
       





        <div class="question_box">
                <h4>Comment Documents (Accessible to the Author)</h4><br>
                <ul>
                    <li><h5>{{$row->comment_14}}</h5></li>
                    </ul>
            </div><br>
    @endforeach


</div>

@endsection

