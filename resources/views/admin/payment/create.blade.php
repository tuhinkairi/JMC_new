    <!-- Add modal content -->
    <div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
              <form class="needs-validation" novalidate action="{{ URL::route($url.'.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Add {{ $title }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <!-- Form Start -->
                    <div class="form-group">
                        <label for="author_type">Author Type</label>
                        <select class="form-control" name="author_type" id="author_type" required>
                            <option value="">Select Author Type</option>
                            <option value="Indian">Indian Author</option>
                            <option value="Others">Others</option>
                        </select>
                        <div class="invalid-feedback">
                          Please Select Author Type.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="journal">Journal</label>
                    
                        <select class="form-control" name="journal" id="journal" required>
                            <option value="">Select Journal</option>
                            @foreach( $journal_type as $type )
                                <option value="{{ $type->id }}">{{ $type->short_form }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                          Please Select Journal Type.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="withdoi">With DOI</label>
                        <input type="text" class="form-control" name="withdoi" id="withdoi" placeholder="Enter DOI"  required>

                        <div class="invalid-feedback">
                          Please Enter DOI.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="withoutdoi">Without DOI</label>
                        <input type="text" class="form-control" name="withoutdoi" id="withoutdoi" placeholder="Enter without doi for indian authors">

                    </div>

            
                    <div class="form-group">
                        <label for="gst">GST ( Percentage %)</label>
                        <input type="text" class="form-control" name="gst" id="gst" placeholder="Enter GST percentage">

                        <div class="invalid-feedback">
                          Please Provide GST Percentage.
                        </div>
                    </div>

                    <!-- Form End -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
