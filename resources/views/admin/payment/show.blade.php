    <!-- Add modal content -->
    <div id="showModal-{{ $row->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <form class="needs-validation" novalidate action="{{ URL::route($url.'.update', $row->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Edit Payment Rate</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    
                    <input type="hidden" value="{{$row->id}}" name="id">     
                                       
                    <div class="form-group">
                        <label for="author_type">Author Type</label>
                        <select class="form-control" name="author_type" id="author_type" required>
                            <option value="{{$row->author_type}}" selected>{{$row->author_type}}</option>
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
                        <option value="{{$row->journal_type}}" selected>{{$row->short_form}}</option>
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
                        <input type="text" class="form-control" name="withdoi" id="withdoi" placeholder="Enter DOI" value="{{ $row->with_doi }}" required>

                        <div class="invalid-feedback">
                          Please Enter DOI.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="withoutdoi">Without DOI</label>
                        <input type="text" class="form-control" name="withoutdoi" id="withoutdoi" value="{{ $row->without_doi }}" placeholder="Enter without doi for indian authors">

                    </div>

            
                    <div class="form-group">
                        <label for="gst">GST ( Percentage %)</label>
                        <input type="text" class="form-control" name="gst" id="gst" value="{{ $row->gst }}" placeholder="Enter GST percentage">

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
