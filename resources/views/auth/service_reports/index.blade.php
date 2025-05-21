<x-app-layout>
    @section('title', 'Service Reports')

    @section('header')
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboards</a></li>
            <li class="breadcrumb-item active">Service Reports</li>
        </ol>
    </div>
    <h4 class="page-title">Service Reports</h4>
    @endsection

    @section('content')
  
    <div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="header-title mb-0">Service Reports</h4>
            </div>

            <div class="card-body">
        

            <div class="row mb-3">
                    <!-- Filter by Job ID -->
                    <div class="col-lg-3">
                        <label for="job_id_filter" class="form-label">Job No</label>
                        <select id="job_id_filter" class="form-control select2" data-toggle="select2">
                            <option value="">All Job IDs</option>
                            @foreach($jobSchedules as $job)
                                <option value="{{ $job->id }}">{{ $job->job_no }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter by Task Status -->
                    <div class="col-lg-3">
                        <label for="task_status_filter" class="form-label">Task Status</label>
                        <select id="task_status_filter" class="form-control select2">
                            <option value="">All Task Status</option>
                            @foreach($taskStatus as $task)
                                <option value="{{ $task->id }}">{{ $task->status }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter by Company -->
                    <div class="col-lg-3">
                        <label for="company_filter" class="form-label">Company</label>
                        <select id="company_filter" class="form-control select2" data-toggle="select2">
                            <option value="">All Companies</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->company }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                                    <table id="service-report-datatable" class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Job Id</th>
                                                <th>Company</th>
                                                <th>Task Status</th>
                                                <th>Task Details</th>
                                                 <th>Job attended technician </th>
                                                 <th> Remark from client</th>
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
     <link href="{{ asset('cms/assets/vendor/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
     @endsection      
     @section('pre-js')
    <script src="{{asset('cms/assets/vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('cms/assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
     <script src="{{asset('cms/assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
     <script src="{{asset('cms/assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js')}}"></script>
     <!-- Jobs DataTable Initialization -->

     <script src="{{ asset('cms/assets/vendor/select2/js/select2.min.js')}}"></script>

     <script>
    $(document).ready(function () {
        const table = $('#service-report-datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: '{{ route("service-reports.data") }}',
                data: function (d) {
                    d.job_id = $('#job_id_filter').val();
                    d.task_status = $('#task_status_filter').val();
                    d.company_id = $('#company_filter').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'job_id', name: 'job_id' },
                { data: 'company', name: 'company' },
                { data: 'task_status', name: 'task_status' },
                { data: 'task_details', name: 'task_details' },
                { data: 'technician_name', name: 'technician_name' },
                { data: 'client_remark', name: 'client_remark' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false },
            ],
            language: {
                paginate: {
                    previous: "<i class='ri-arrow-left-s-line'>",
                    next: "<i class='ri-arrow-right-s-line'>"
                }
            },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            }
        });

        // Filter reload
        $('#job_id_filter, #task_status_filter, #company_filter').on('change', function () {
            table.ajax.reload();
        });

        $('.select2').select2();
    });
</script>
 
        @endsection
 
  
   
 </x-app-layout>

