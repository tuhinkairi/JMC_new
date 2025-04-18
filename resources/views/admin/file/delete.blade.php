<!-- Delete modal -->
<div class="modal fade" id="deleteModal-{{ $file->id }}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
    {{-- <form id="myForm" class="needs-validation" novalidate action="{{url('dashboard/admin/submission/add-review-question/'.$id)}}" method="post" enctype="multipart/form-data"> --}}
    <form id="myForm" class="needs-validation" novalidate action="{{url('dashboard/admin/submission/file/destroy/'.$file->id)}}" method="post" enctype="multipart/form-data">
      {{-- <form action="{{ URL::route('file.destroy', [$file->id]) }}" method="post" class="delete-form"> --}}
      @csrf
        <div class="modal-content">
            <div class="modal-body text-center">
                <h3>Are You Sure?</h3>
                <p>You will not be able to recover this!</p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Confirm</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
      </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
