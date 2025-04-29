@extends('admin.layouts.master')
@section('title', $title)
@section('content')

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <!-- Include page breadcrumb -->
        @include('admin.inc.breadcrumb')
        <!-- end page title -->


        <div class="row">
            <div class="col-12">
                <!-- Add modal button -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add New</button>
                <!-- Include Add modal -->
                @include('admin.' . $url . '.create')

                <a href="{{ URL::route($url . '.index') }}" class="btn btn-info">Refresh</a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h4>Filter By</h4>
                <div class="row">
                    <div class="col-md-4 col-xs-12" style="margin-bottom:20px;">
                        <label>Name</label>
                        <input type="text" class="form-control" id="nameUser">
                    </div>
                    <div class="col-md-4 col-xs-12" style="margin-bottom:20px;">
                        <label>Email</label>
                        <input type="email" class="form-control" id="author_email">
                    </div>
                    <div class="col-md-4 col-xs-12" style="margin-bottom:20px;">
                        <label>Phone Number</label>
                        <input type="number" class="form-control" id="author_phone">
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <!-- Include Flash Messages -->
                        @include('admin.inc.message')
                    </div>

                    <div class="card-body">
                        <h4 class="header-title">{{ $title }} List</h4>

                        <!-- Data Table Start -->
                        <div class="table-responsive">
                            <table id="basic-datatable"
                                class="table table-striped table-hover table-white nowrap text-center" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Reviewer Referral ID</th>
                                        <th>Name</th>
                                        <th>Dept</th>
                                        <th>Email ID</th>
                                        <th>Phone No</th>

                                        <th>Review Article Details</th>

                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $key => $row)
                                                                    <tr>
                                                                        <td>{{ $key + 1 }}</td>
                                                                        <td>{{ $row->reviewerid }}</td>
                                                                        <td class="userNameTable">{{ $row->name }}</td>
                                                                        <td>{{ $row->department }}</td>
                                                                        <td class="reviewerEmail">{{ $row->email }}</td>
                                                                        <td class="reviewerPhone">{{ $row->phone }}</td>

                                                                        @php
                                                                            $articles = array_values($assignedArticle[$row->id] ?? []);
                                                                        @endphp
                                                                        <td class="d-flex text-nowrap flex-column">
                                                                            @for($i = 0; $i < 3; $i++)
                                                                                @if(isset($articles[$i]))
                                                                                    @foreach ($articles[$i] as $sform)
                                                                                        <a href="{{ url('dashboard/admin/submission/show/' . $sform->id) }}">
                                                                                            {{ $sform->journal_short_form }}-0000{{ $sform->id }}
                                                                                        </a><br>
                                                                                    @endforeach
                                                                                @endif
                                                                            @endfor
                                                                        </td>
                                                                        <td class="">
                                                                            <div class="d-flex justify-content-around">

                                                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                                                    data-target="#showModal-{{ $row->id }}">
                                                                                    <i class="fas fa-eye"></i>
                                                                                </button>
                                                                                <!-- Include Show modal -->
                                                                                @include('admin.' . $url . '.show')

                                                                                <button type="button" class="btn btn-success btn-sm mx-1"
                                                                                    data-toggle="modal" data-target="#editModal-{{ $row->id }}">
                                                                                    <i class="fas fa-edit"></i>
                                                                                </button>
                                                                                <!-- Include Show modal -->
                                                                                @include('admin.' . $url . '.edit')

                                                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                                                    data-target="#deleteModal-{{ $row->id }}">
                                                                                    <i class="fas fa-trash-alt"></i>
                                                                                </button>
                                                                            </div>
                                                                            <!-- Include Delete modal -->
                                                                            @include('admin.inc.delete_reviewer')
                                                                        </td>
                                                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Data Table End -->

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->


    </div> <!-- container -->
    <!-- End Content-->
<script>

    document.addEventListener('DOMContentLoaded', function () {
    const nameInput = document.getElementById('nameUser');
    const emailInput = document.getElementById('author_email');
    const phoneInput = document.getElementById('author_phone');
    
    const tableRows = document.querySelectorAll('#basic-datatable tbody tr');
    
    function filterTable() {
        const nameValue = nameInput.value.toLowerCase();
        const emailValue = emailInput.value.toLowerCase();
        const phoneValue = phoneInput.value.toLowerCase();
        
        tableRows.forEach(row => {
            const userName = row.querySelector('.userNameTable')?.textContent.toLowerCase() || '';
            const email = row.querySelector('.reviewerEmail')?.textContent.toLowerCase() || '';
            const phone = row.querySelector('.reviewerPhone')?.textContent.toLowerCase() || '';

            const nameMatch = nameValue === '' || userName.includes(nameValue);
            const emailMatch = emailValue === '' || email.includes(emailValue);
            const phoneMatch = phoneValue === '' || phone.includes(phoneValue);
            
            if (nameMatch && emailMatch && phoneMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    // Event listeners outside the filterTable function
    nameInput.addEventListener('input', filterTable);
    emailInput.addEventListener('input', filterTable);
    phoneInput.addEventListener('input', filterTable);
});
</script>


@endsection