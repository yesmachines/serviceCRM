<x-app-layout>
    @section('title', 'Service Types')

    @section('header')
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboards</a></li>
            <li class="breadcrumb-item active">Service Types</li>
        </ol>
    </div>
    <h4 class="page-title">Service Types</h4>
    @endsection

    @section('content')
  
                    <div class="row">
                        <div class="col-12">
                            <div class="card">

                            <div class="card-header d-flex justify-content-between align-items-center">
                                    <!-- <h4 class="header-title mb-0">Vehicles</h4> -->
                                      <h4 class="header-title mb-0"></h4>
                                    <a href="{{route('service-types.create')}}" class="btn btn-mg btn-secondary">
                                        {{ __('Add Service Types') }}
                                    </a>
                                </div>

                                <div class="card-body">
                                    <table id="service-types-datatable" class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Parant Service</th>
                                                 <th>Daily Report</th>
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
              $('#service-types-datatable').DataTable({
                  processing: true,
                  serverSide: true,
                  ajax: '{{ route('service-types.data') }}',
                  columns: [
                      { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                      { data: 'title', name: 'title' },
                      { data: 'parent_title', name: 'parent.title' },
                      { data: 'daily_report_label', name: 'daily_report' },
                      { data: 'actions', name: 'actions', orderable: false, searchable: false },
                  ],
                  responsive: true
              });
          });
          
      </script>

       @endsection

 
  
</x-app-layout>

        



