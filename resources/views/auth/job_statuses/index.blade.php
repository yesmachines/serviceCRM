<x-app-layout>
    @section('title', 'Job Statuses')

    @section('header')
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboards</a></li>
            <li class="breadcrumb-item active">Job Statuses</li>
        </ol>
    </div>
    <h4 class="page-title">Job Statuses</h4>
    @endsection

    @section('content')
  
                    <div class="row">
                        <div class="col-12">
                            <div class="card">

                            <div class="card-header d-flex justify-content-between align-items-center">
                                    <!-- <h4 class="header-title mb-0">Vehicles</h4> -->
                                      <h4 class="header-title mb-0"></h4>
                                    <a href="{{route('job-statuses.create')}}" class="btn btn-mg btn-secondary">
                                        {{ __('Add Job Status') }}
                                    </a>
                                </div>

                               
                                <div class="card-body">
                                    <table id="jobstatuses-datatable" class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Status</th>
                                                <th>Priority</th>
                                                 <th>Active</th>
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
     
   @section('js')
    <!-- Jobs DataTable Initialization -->
    <script>
        $(document).ready(function() {
           $('#jobstatuses-datatable').DataTable({
              processing: true,
              serverSide: true,
              ajax: '{{ route('job-statuses.data') }}',
              columns: [
                  { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                  { data: 'status', name: 'status' },
                  { data: 'priority', name: 'priority' },
                  { data: 'active', name: 'active' },
                  { data: 'actions', name: 'actions', orderable: false, searchable: false },
              ],
              responsive: true
          });
        });
    </script>

       @endsection

 
  
</x-app-layout>

        



