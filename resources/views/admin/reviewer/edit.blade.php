    <!-- Add modal content -->
    <div id="editModal-{{ $row->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
              <form class="needs-validation" novalidate action="{{ URL::route($url.'.update', $row->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" value="{{$row->id}}" name="id">    
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Edit {{ $title }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <!-- Form Start -->
                    <div class="form-group">
                        <label for="name">Reviewer Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Reviewer Name"  value="{{ $row->name }}" required>

                        <div class="invalid-feedback">
                          Please Provide Reviewer Name.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="reviewerid">Reviewer Id</label>
                        <input type="reviewerid" class="form-control" name="reviewerid" id="reviewer_id" value="{{ $row->reviewerid }}" placeholder="Review ID">

      
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email"  value="{{ $row->email }}" required>

                        <div class="invalid-feedback">
                          Please Provide Email Address.
                        </div>
                    </div>

        


  

                    <div class="form-group">
                        <label for="department">Department</label>
                        <select class="form-control" name="department" id="department" required>
                        <option value="{{ $row->id }}">{{ $row->department }}</option>

                            <option>EEE</option>
                            <option>ECE</option>
                            <option>MECH</option>
                            <option>CIVIL</option>
                            <option>CSE</option>
                            <option>S&H</option>
                            <option>Others</option>
                        </select>

                        <div class="invalid-feedback">
                          Please Provide A Department.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone" value="{{ $row->phone }}" placeholder="Phone">

                        <div class="invalid-feedback">
                          Please Provide Phone Number.
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" name="address" id="address" value="{{ $row->address }}" placeholder="Address" required>

                        <div class="invalid-feedback">
                          Please Provide Address.
                        </div>
                    </div> -->

                    <!-- <div class="form-group">
                        <label for="dob">Date Of Birth</label>
                        <input type="date" class="form-control" name="dob" id="dob" value="{{ $row->dob }}" placeholder="Date Of Birth" required>

                        <div class="invalid-feedback">
                          Please Provide Date Of Birth.
                        </div>
                    </div> -->

                    <!-- Form End -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
