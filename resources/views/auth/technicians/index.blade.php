<x-app-layout>
    @section('title', 'Technicians')

    @section('header')
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboards</a></li>
            <li class="breadcrumb-item active">Employees</li>
        </ol>
    </div>
    <h4 class="page-title">Employees</h4>
    @endsection

    @section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title mb-0"></h4>
                    <a href="{{route('technicians.create')}}" class="btn btn-mg btn-secondary">
                        {{ __('Add Employees') }}
                    </a>
                    
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <!-- Role Filter -->
                        <div class="col-lg-3">
                            <label for="role_filter" class="form-label">Role</label>
                            <select id="role_filter" class="form-control">
                                <option value="">All Roles</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Designation Filter -->
                        <div class="col-lg-3">
                            <label for="designation_filter" class="form-label">Designation</label>
                            <input type="text" id="designation_filter" class="form-control" placeholder="Designation">
                        </div>

                          <!-- Email Filter -->
                            <div class="col-lg-3">
                                <label for="email_filter" class="form-label">Email</label>
                                <input type="text" id="email_filter" class="form-control" placeholder="Email">
                            </div>

                            <!-- Phone Filter -->
                            <div class="col-lg-3">
                                <label for="phone_filter" class="form-label">Phone</label>
                                <input type="text" id="phone_filter" class="form-control" placeholder="Phone">
                            </div>
                 </div>

                <div class="card-body">
                    <table id="technicians-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Designation</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data loaded via DataTables AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @endsection

    @section('pre-css')
    <link href="{{asset('cms/assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('cms/assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    @endsection      
    @section('pre-js')
    <script src="{{asset('cms/assets/vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('cms/assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{asset('cms/assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('cms/assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js')}}"></script>
    <script>
    $(document).ready(function () {
        let table = $('#technicians-datatable').DataTable({
            processing: true,
            serverSide: true,
            language: {
                paginate: {
                    previous: "<i class='ri-arrow-left-s-line'>",
                    next: "<i class='ri-arrow-right-s-line'>"
                }
            },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
            ajax: {
                url: '{{ route('technicians.data') }}',
                data: function (d) {
                    d.role = $('#role_filter').val();
                    d.designation = $('#designation_filter').val();
                    d.email = $('#email_filter').val();
                    d.phone = $('#phone_filter').val();
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'user_name', name: 'name'},
                {data: 'role', name: 'roles.name'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'employee.phone'},
                {data: 'designation', name: 'employee.designation'},
                {data: 'actions', name: 'actions', orderable: false, searchable: false},
            ],
            responsive: true
        });

        // Trigger table redraw on filter change
        $('#role_filter, #designation_filter, #email_filter, #phone_filter').on('change keyup', function () {
        table.draw();
    });
    });
</script>

    @endsection
</x-app-layout>


