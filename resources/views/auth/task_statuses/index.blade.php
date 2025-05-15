<x-app-layout>
    @section('title', 'Task Statuses')

    @section('header')
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboards</a></li>
            <li class="breadcrumb-item active">Task Statuses</li>
        </ol>
    </div>
    <h4 class="page-title">Task Statuses</h4>
    @endsection

    @section('content')
  
                    <div class="row">
                        <div class="col-12">
                            <div class="card">

                            <div class="card-header d-flex justify-content-between align-items-center">
                                    <!-- <h4 class="header-title mb-0">Vehicles</h4> -->
                                      <h4 class="header-title mb-0"></h4>
                                    <a href="{{route('task-statuses.create')}}" class="btn btn-mg btn-secondary">
                                        {{ __('Add Task Status') }}
                                    </a>
                                </div>

                               
                                <div class="card-body">
                                    <table id="tasktatuses-datatable" class="table table-striped dt-responsive nowrap w-100">
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
     
 
    @section('pre-css')
    <link href="{{asset('cms/assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('cms/assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    @endsection      
    @section('pre-js')
   <script src="{{asset('cms/assets/vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('cms/assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{asset('cms/assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('cms/assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js')}}"></script>
    <!-- Jobs DataTable Initialization -->
    <script>
        $(document).ready(function() {
            $('#tasktatuses-datatable').DataTable({
                processing: true,
                serverSide: true,
                language:{paginate:{previous:"<i class='ri-arrow-left-s-line'>",next:"<i class='ri-arrow-right-s-line'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")},
                ajax: '{{ route('task-statuses.data') }}',
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

        



