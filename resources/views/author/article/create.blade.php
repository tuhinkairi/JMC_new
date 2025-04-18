@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <!-- Include page breadcrumb -->
    @include('admin.inc.breadcrumb')
    <!-- end page title -->
    <!-- loading screen start -->
            <style>
        #loadingScreen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: #f8f9fa;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
         }
    </style>
            <div id="loadingScreen" style="display:none">
    
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3 fw-medium">Please wait while we prepare your experience...</p>
            </div>
            <!-- loading screen end -->
              <form class="needs-validation" novalidate action="{{ URL::route('author.'.$url.'.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                    <!-- Form Start -->
                    <input type="hidden" name="token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        @php
                            $count = 0;
                            $journalissn = array('- ISSN: 2582-8746', '- ISSN: 2583-1240', '- ISSN: 2583-0368', '- ISSN: Applied', '- ISSN: 3048-6408', '- ISSN: 2583-5300')
                        @endphp
                        {{-- <label for="title">Journal Name</label>
                        <input type="text" class="form-control" value="{{$journal[0]->name}}" disabled> --}}
                        <label for="category">Select Journal Name</label>
                        <select class="form-control" name="journal_type" id="journal" required>
                            <option value="">Select Journal</option>
                            @php $count = 0; @endphp
                            @foreach($journals as $journal)
                                <option value="{{ $journal->id }}" {{ $journal_id == $journal->id ? 'selected' : '' }}>
                                    {{ $journal->name }} {{ isset($journalissn[$count]) ? $journalissn[$count++] : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="title"><b>Submission Requirements</b></label>
                        <p>You must read and acknowledge that you've completed the requirements below before proceeding</p>
                    </div>

                    <div class="row">
                        <div class="col-xl-8 col-lg-8" style="display: none;" id='terms'>
                            <div class="form-group">
                            
                                    <ul>
                                        <li>Submission Requirements You must read and acknowledge that you've completed the requirements below before proceeding</li><br>
                                        <li>The submission has not been previously published, nor is it before another journal for consideration (or an explanation has been provided in Comments to the Editor).</li><br>
                                        <li>The submission file is in Microsoft Word document file format. (PDF not accepted).</li><br>
                                        <li>All references were prepared as per the journal guidelines. Where available, DOI or URLs for the references have been provided and cross cited in manuscript body text. The text adheres to the stylistic and bibliographic requirements outlined in the Author Guidelines of the respective journal.</li><br>
                                        <li>I/We agreed to pay Article Processing Charges (APC) if paper accepted. Also agreed that the total number of pages will not exceed more than 15 pages in our paper. (If exceeded additional charges shall be applied). India: APC as per the journal- with DOI, Without DOI excluding 18% GST; | Other than India: $50; Extra Pages-$3 per page. No refund is possible for any reasons if the article is published online.</li><br>
                                        <li>Any changes are not possible after the publication of your paper. Please send the paper in Journal template (or) Journal format to avoid any mistakes. Please make sure similarities should be less than 30%. All the copyright of your article will be transferred & reserved to publish in a respective journal.</li><br>
                                        <li>Journal is responsible only for publication of papers on the Journal website which is mentioned on acceptance letter. Since, indexing of the journals is unstable, it is the responsibility of the author to check their requirements on a timely basis.</li>
                                    </ul>
                            
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3" style="display: none;" id='termsimage'>
                            <div id="show_image">
                            </div>
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

                        {{-- <div class="col-md-12 col-xs-12 hidden" style="margin-bottom: 20px;">
                                    @foreach( $journal as $journals )
                                    <input type="hidden" class="form-control" name="journal_type" value={{$journals->id}}>
                                    @endforeach
                        </div> --}}

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
                                <input type="file" class="form-control" name="file" id="file" placeholder="Upload Document" required>
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
                    </div>
                    
                    <br>

                    <div class="center" style="text-align: left;">
                        <button type="submit" class="btn btn-blue upload_file waves-effect waves-light">Submit</button>
                    </div>

                    <!-- <div id="loading" style="display: none;">
    <img src="{{ asset('frontend/img/loading.gif') }}" width="40px" height="40px" alt="Loading...">
</div> -->
                    
                </div>

              </form>
            </div>
            <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

            <script>
$(document).ready(function () {

    // check the size of the file
    const maxFileSize = 5 * 1024 * 1024; // 5MB in bytes

$('#file').on('change', function () {
    const file = this.files[0];
    console.log(file)
    if (file && file.size > maxFileSize) {
        alert("File size exceeds 5MB. Please upload a smaller file.");
        this.value = ''; // Clear the input
    }
});
    $('form').submit(function (event) {
        const form = this;

        if (!form.checkValidity()) {
            // Let the browser handle validation UI
            return;
        }

        // Prevent default only after validation passes
        event.preventDefault();

        // Show loading screen
        document.getElementById('loadingScreen').style.display = 'flex';

        // Disable submit to prevent duplicate submissions
        $('button[type="submit"]').prop('disabled', true);

        // Submit the form manually (if not using AJAX)
        form.submit();
    });

    function updateImage() {
        let val = $('#journal').val();
        $("#show_image").empty();
        const terms = document.getElementById('terms');
        const termsimage = document.getElementById('termsimage');
        terms.style.display = 'block';
        termsimage.style.display = 'block';

        let images = {
            1: "{{ asset('/backend/images/ijire_image.png') }}",
            2: "{{ asset('/backend/images/Ijsreat_image.png') }}",
            3: "{{ asset('/backend/images/ijrtmr_image.png') }}",
            4: "{{ asset('/backend/images/Indjeee_image.png') }}",
            5: "{{ asset('/backend/images/indjece_image.png') }}",
            6: "{{ asset('/backend/images/Indjcst_image.png') }}"
        };

        if (images[val]) {
            $("#show_image").append(`<img src="${images[val]}" id="journal_cover_img" width="300px" height="400px">`);
        }
    }

    // Bind dropdown and init on load
    $('#journal').change(updateImage);
    updateImage();
});
</script>

            @endsection
            {{-- <img src="{{ asset('/backend/images/ijire_image.png') }}" id="journal_cover_img" width="300px;" height="400px;"> --}}
