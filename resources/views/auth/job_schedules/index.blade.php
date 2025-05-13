<x-app-layout>
    @section('title', 'Technicians')

    @section('header')
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboards</a></li>
            <li class="breadcrumb-item active">Job Scedules</li>
        </ol>
    </div>
    <h4 class="page-title">Job Scedules</h4>
    @endsection

    @section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title mb-0"></h4>
                    <a href="{{route('job-schedules.create')}}" class="btn btn-mg btn-secondary">
                        {{ __('Job Scedules') }}
                    </a>
                </div>

                <div class="card-body">
                    <table id="jobschedules-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Job No</th>
                                <th>Job Type</th>
                                <th>Customer Name</th>
                                <th>Product</th>
                                <th>Time</th>
                                <!-- <th>Status</th> -->
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
    <!-- Jobs DataTable Initialization -->
     <script>
        $(document).ready(function () {
            $('#jobschedules-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('job-schedules.data') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'job_no', name: 'job_no' },
                    { data: 'job_type', name: 'job_type' },
                    { data: 'customer', name: 'customer.fullname' },

                    { data: 'product', name: 'product' },
                    { data: 'time', name: 'time' },
                   
                    { data: 'actions', name: 'actions', orderable: false, searchable: false },
                ],
                responsive: true
            });
            });
          
      </script>

       @endsection

 
  
</x-app-layout>

  
 