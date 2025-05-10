<x-app-layout>
    @section('title', 'Vehicles')

    @section('header')
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboards</a></li>
            <li class="breadcrumb-item active">Vehicles</li>
        </ol>
    </div>
    <h4 class="page-title">Vehicles</h4>
    @endsection

    @section('content')
  
                    <div class="row">
                        <div class="col-12">
                            <div class="card">

                            <div class="card-header d-flex justify-content-between align-items-center">
                                    <!-- <h4 class="header-title mb-0">Vehicles</h4> -->
                                      <h4 class="header-title mb-0"></h4>
                                    <a href="{{route('vehicles.create')}}" class="btn btn-mg btn-secondary">
                                        {{ __('Add Vehicle') }}
                                    </a>
                                </div>

                                <!-- <div class="card-header">
                                    <h4 class="header-title">Jobs List</h4>
                                     <a href="" class="btn btn-lg btn-secondary">
                                        {{ __('Add Page') }}
                                    </a>
                                </div> -->
                                <div class="card-body">
                                    <table id="vehicles-datatable" class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Type</th>
                                                 <th>Vehicle Number</th>
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
                    </div> <!-- end row -->
  
   @endsection
     

    @section('pre-css')
    <link href="{{asset('cms/assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('cms/assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    @endsection      
    @section('pre-js')
   <script src="{{asset('cms/assets/vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <!-- Jobs DataTable Initialization -->
    <script>
        $(document).ready(function() {
            $('#vehicles-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('vehicles.data') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'type', name: 'type' },
                    { data: 'vehicle_number', name: 'vehicle_number' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false },
                ],
                responsive: true
            });
        });
    </script>

       @endsection

 
  
</x-app-layout>

        



