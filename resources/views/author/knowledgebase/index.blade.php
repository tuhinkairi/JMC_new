@extends('admin.layouts.master')
@section('title', $title)
@section('content')
<!-- start page title -->
    <!-- Include page breadcrumb -->
    @include('admin.inc.breadcrumb')
    <!-- end page title -->
<!-- Start Content-->
<div class="container-fluid">

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if ($journal == 1)
                <div class="container">
                    <div class="question-container">
                        <h4>1. Article Submission Process:</h4>
                    </div>
                    <div class="answer-container">
                        <!-- Embed the YouTube video for Question 1 using the iframe -->
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/RUtHKw7v4II" frameborder="0" allowfullscreen></iframe>
                    </div><br><br>

                    <div class="question-container">
                        <h4>2. Article Review & Acceptance Process:</h4>
                    </div>
                    <div class="answer-container">
                        <!-- Embed the YouTube video for Question 2 using the iframe -->
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/WiJSjpbj2Ns" frameborder="0" allowfullscreen></iframe>
                    </div><br><br>

                    <div class="question-container">
                        <h4>3. Article Final submission Process & Publishing Process:</h4>
                    </div>
                    <div class="answer-container">
                        <!-- Embed the YouTube video for Question 3 using the iframe -->
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/okLj9H5dZbI" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>

                @elseif ($journal == 2)
                <div class="container">
                    <div class="question-container">
                        <h4>1. Article Submission Process:</h4>
                    </div>
                    <div class="answer-container">
                        <!-- Embed the YouTube video for Question 1 using the iframe -->
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/LqCgSWHjVrY" frameborder="0" allowfullscreen></iframe>
                    </div><br><br>

                    <div class="question-container">
                        <h4>2. Article Review & Acceptance Process:</h4>
                    </div>
                    <div class="answer-container">
                        <!-- Embed the YouTube video for Question 2 using the iframe -->
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/pg2HI9QzTWo" frameborder="0" allowfullscreen></iframe>
                    </div><br><br>

                    <div class="question-container">
                        <h4>3. Article Final submission Process & Publishing Process:</h4>
                    </div>
                    <div class="answer-container">
                        <!-- Embed the YouTube video for Question 3 using the iframe -->
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/BPmcgfeZV1A" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>

                @elseif ($journal == 3)
                <div class="container">
                    <div class="question-container">
                        <h4>1. Article Submission Process:</h4>
                    </div>
                    <div class="answer-container">
                        <!-- Embed the YouTube video for Question 1 using the iframe -->
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/WKLEAbMwkdg" frameborder="0" allowfullscreen></iframe>
                    </div><br><br>

                    <div class="question-container">
                        <h4>2. Article Review & Acceptance Process:</h4>
                    </div>
                    <div class="answer-container">
                        <!-- Embed the YouTube video for Question 2 using the iframe -->
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/ZIyJ7cgJ4qw" frameborder="0" allowfullscreen></iframe>
                    </div><br><br>

                    <div class="question-container">
                        <h4>3. Article Final submission Process & Publishing Process:</h4>
                    </div>
                    <div class="answer-container">
                        <!-- Embed the YouTube video for Question 3 using the iframe -->
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/FtLSCMLBpyw" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>

                @elseif ($journal == 4)
                <div class="container">
                    <div class="question-container">
                        <h4>1. Article Submission Process:</h4>
                    </div>
                    <div class="answer-container">
                        <!-- Embed the YouTube video for Question 1 using the iframe -->
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/6lVYYE0NF3s" frameborder="0" allowfullscreen></iframe>
                    </div><br><br>

                    <div class="question-container">
                        <h4>2. Article Review & Acceptance Process:</h4>
                    </div>
                    <div class="answer-container">
                        <!-- Embed the YouTube video for Question 2 using the iframe -->
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/mrABQSzqvbU" frameborder="0" allowfullscreen></iframe>
                    </div><br><br>

                    <div class="question-container">
                        <h4>3. Article Final submission Process & Publishing Process:</h4>
                    </div>
                    <div class="answer-container">
                        <!-- Embed the YouTube video for Question 3 using the iframe -->
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/gzYb7YbFRUQ" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>

                @elseif ($journal == 5)
                <div class="container">
                    <div class="question-container">
                        <h4>1. Article Submission Process:</h4>
                    </div>
                    <div class="answer-container">
                        <!-- Embed the YouTube video for Question 1 using the iframe -->
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/lCSxMPk6UzM" frameborder="0" allowfullscreen></iframe>
                    </div><br><br>

                    <div class="question-container">
                        <h4>2. Article Review & Acceptance Process:</h4>
                    </div>
                    <div class="answer-container">
                        <!-- Embed the YouTube video for Question 2 using the iframe -->
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/ftj9onzB30g" frameborder="0" allowfullscreen></iframe>
                    </div><br><br>

                    <div class="question-container">
                        <h4>3. Article Final submission Process & Publishing Process:</h4>
                    </div>
                    <div class="answer-container">
                        <!-- Embed the YouTube video for Question 3 using the iframe -->
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/maq97Txc52w" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>

                @elseif ($journal == 6)
                <div class="container">
                    <div class="question-container">
                        <h4>1. Article Submission Process:</h4>
                    </div>
                    <div class="answer-container">
                        <!-- Embed the YouTube video for Question 1 using the iframe -->
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/lN5tAmokZts" frameborder="0" allowfullscreen></iframe>
                    </div><br><br>

                    <div class="question-container">
                        <h4>2. Article Review & Acceptance Process:</h4>
                    </div>
                    <div class="answer-container">
                        <!-- Embed the YouTube video for Question 2 using the iframe -->
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/g_IjL01xPGs" frameborder="0" allowfullscreen></iframe>
                    </div><br><br>

                    <div class="question-container">
                        <h4>3. Article Final submission Process & Publishing Process:</h4>
                    </div>
                    <div class="answer-container">
                        <!-- Embed the YouTube video for Question 3 using the iframe -->
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/bTXMBGzhTS0" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
@endsection
