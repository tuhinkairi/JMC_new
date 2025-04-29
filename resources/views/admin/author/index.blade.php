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
                <a href="{{ URL::route($url . '.index') }}" class="btn btn-info">Refresh</a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h4>Filter By</h4>
                <div class="row">
                    <div class="col-md-4 col-xs-12" style="margin-bottom:20px;">
                        <label>Name</label>
                        <input type="text" class="form-control" id="name">
                    </div>
                    <div class="col-md-4 col-xs-12" style="margin-bottom:20px;">
                        <label>Email</label>
                        <input type="email" class="form-control" id="email">
                    </div>
                    <div class="col-md-4 col-xs-12" style="margin-bottom:20px;">
                        <label>Phone Number</label>
                        <input type="number" class="form-control" id="phone_number">
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
                                class="table table-striped table-hover text-center align-middle nowrap" style="width:100%;">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $key => $row)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td class="userName">{{ $row->name ?? '-' }}</td>
                                            <td class="emailId">{{ $row->email ?? '-' }}</td>
                                            <td class="phoneNumber">{{ $row->phone ?? '-' }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#showModal-{{ $row->id }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    @include('admin.' . $url . '.show')

                                                    <button type="button" class="btn btn-danger btn-sm mx-1"
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $row->id }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                    @include('admin.inc.delete')
                                                </div>
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


        <!-- End Content-->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const nameInput = document.getElementById('name');
                const emailInput = document.getElementById('email');
                const phoneInput = document.getElementById('phone_number');

                const tableRows = document.querySelectorAll('#basic-datatable tbody tr');

                function filterTable() {
                    const nameValue = nameInput.value.toLowerCase();
                    const emailValue = emailInput.value.toLowerCase();
                    const phoneValue = phoneInput.value.toLowerCase();

                    tableRows.forEach(row => {
                        const userName = row.querySelector('.userName')?.textContent.toLowerCase() || '';
                        const email = row.querySelector('.emailId')?.textContent.toLowerCase() || '';
                        const phone = row.querySelector('.phoneNumber')?.textContent.toLowerCase() || '';

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

                nameInput.addEventListener('input', filterTable);
                emailInput.addEventListener('input', filterTable);
                phoneInput.addEventListener('input', filterTable);
            });
        </script>

    </div> <!-- container -->

@endsection