<x-app-layout>
    @section('title', 'Technicians')

    @section('header')
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboards</a></li>
            <li class="breadcrumb-item active">Technicians</li>
        </ol>
    </div>
    <h4 class="page-title">Technicians</h4>
    @endsection

    @section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title mb-0"></h4>
                    <a href="{{route('technicians.create')}}" class="btn btn-mg btn-secondary">
                        {{ __('Add Technician') }}
                    </a>
                </div>

                <div class="card-body">
                    <table id="technicians-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Vehicle</th>
                                <th>Level</th>
                                <th>Standard Charge</th>
                                <th>Additional Charge</th>
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
    <script>
        $(document).ready(function() {
            $('#technicians-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('technicians.data') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'user_name', name: 'user.name' },
                    { data: 'vehicle_name', name: 'vehicle.name' },
                    { data: 'technician_level', name: 'technician_level' },
                    { data: 'standard_charge', name: 'standard_charge' },
                    { data: 'additional_charge', name: 'additional_charge' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false },
                ],
                responsive: true
            });
        });
    </script>
    @endsection
</x-app-layout>
