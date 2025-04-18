@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <!-- Include page breadcrumb -->
    @include('admin.inc.breadcrumb')
    <!-- end page title -->

              <form class="needs-validation" novalidate action="{{ URL::route('submission.article.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                    <!-- Form Start -->

                    <div class="form-group">
                        @php
                            $count = 0;
                            $journalissn = array('- ISSN: 2582-8746', '- ISSN: 2583-1240', '- ISSN: 2583-0368', '- ISSN: Applied', '- ISSN: Applied', '- ISSN: 2583-5300')
                        @endphp
                        <label for="category">Select Journal Name</label>
                        <select class="form-control" name="journal" id="category" required>
                            <option value="">Select Journal</option>
                            @foreach( $journals as $journal )
                            <option value="{{ $journal->id }}">{{ $journal->name }} {{$journalissn[$count++]}}</option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback">
                          Please Select Article Category.
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="title">Article Title</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Article Title" required>

                        <div class="invalid-feedback">
                          Please Provide Article Title.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="category">Research Area</label>
                        <select class="form-control" name="category" id="category" required>
                            <option value="">Select Research Area</option>
                            @foreach( $categories as $category )
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback">
                          Please Select Article Research Area.
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-4 col-xs-12" style="margin-bottom: 20px;">
                            <div class="form-group">
                                <label for="article_type">Type of Article</label>
                                <select class="form-control" name="article_type" id="article_type" required>
                                    <option value=''>Select Article Type</option>
                                    @foreach( $articles as $article )
                                    <option value="{{ $article->id }}">{{ $article->name }}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                  Please Select Article Type.
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-xs-12" style="margin-bottom: 20px;">
                            <div class="form-group">
                                <label for="issue_type">Type of issue</label>
                                <select class="form-control" name="issue_type" id="issue_type" required>
                                    <option value=''>Select Issue Type</option>
                                    @foreach( $issues as $issue )
                                    <option value="{{ $issue->id }}">{{ $issue->name }}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                  Please Select issue Type.
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-xs-12" style="margin-bottom: 20px;">
                            <div class="form-group">
                                <label for="processing_type">Mode of Processing</label>
                                <select class="form-control" name="processing_type" id="processing_type" required>
                                    <option value=''>Select Processing Type</option>
                                    @foreach( $processings as $processing )
                                    <option value="{{ $processing->id }}">{{ $processing->name }}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                  Please Select Processing Mode.
                                </div>
                            </div>
                        </div>

                    </div>



                    <div class="form-group">
                        <label for="details">Abstract</label>
                        <textarea class="form-control summernote" name="details" id="details" rows="8" required></textarea>

                        <div class="invalid-feedback">
                          Please Provide Abstract.
                        </div>
                    </div>

                    {{-- <div class="form-group">
                        <label for="image">Thumbnail Image</label>
                        <input type="file" class="form-control" name="image" id="image" placeholder="Thumbnail Image">

                        <div class="invalid-feedback">
                          Please Provide Thumbnail Image.
                        </div>
                    </div> --}}

                    <div class="row">
                        <div class="col-md-8 col-xs-12" style="margin-bottom: 20px;">
                            <div class="form-group">
                                <label for="file">Upload Document</label>
                                <input type="file" class="form-control" name="file" id="file" placeholder="Upload Document">
                                <p></P>
                                <p style="color:red">    (Only doc or docx word document format allowed; File size should be less than 5MB)</p>
                                <div class="invalid-feedback">
                                    Please Provide Artilce Document.
                                </div>
                            </div>
                        </div>
                    
                       
                        <div class="col-md-4 col-xs-12" style="margin-bottom: 20px;">
                            <div class="form-group">
                            <label for="title">Reviewer Referral ID</label>
                            <input type="text" class="form-control" name="ref_id" id="ref_id" placeholder="Reference Id">

             
                            </div>
                        </div>
                    </div><br>

                    <div class="row">
            </div>
            <div class="center" align="left">
                <button type="submit" class="btn btn-blue upload_file waves-effect waves-light">Submit</button>
            </div>
        </form>
        </div>
            @endsection


