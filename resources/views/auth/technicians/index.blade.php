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

    @section('js')
      <script src="{{asset('cms/assets/vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#technicians-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('technicians.data') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'user_name', name: 'user.name' },
                    { data: 'role', name: 'role.name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'designation', name: 'designation' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false },
                ],
                responsive: true
            });
        });
    </script>
    @endsection
</x-app-layout>


