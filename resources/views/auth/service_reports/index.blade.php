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
                            <label for="job_id_filter_1" class="form-label">Job No</label>
                            <select id="job_id_filter_1" class="form-control select2" data-toggle="select2">
                                <option value="">All Job IDs</option>
                                @foreach($jobSchedules as $id => $job)
                                    <option value="{{ $id }}">{{ $job }}</option>
                                @endforeach
                            </select>
                        </div>


                      <!-- Second Dropdown -->
                      <div class="col-lg-3">
                            <label for="company_id_filter_2" class="form-label">Company</label>
                            <select id="company_id_filter_2" class="form-control select2">
                                <option value="">All Companies</option>
                                @foreach($companies as $id => $company)
                                    <option value="{{ $id }}">{{ $company }}</option>
                                @endforeach
                            </select>
                        </div>

                          <!-- Start Date -->
                            <div class="col-lg-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" id="start_date" class="form-control" />
                            </div>

                            <!-- End Date -->
                            <div class="col-lg-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" id="end_date" class="form-control" />
                            </div>    
                </div>

                                    <table id="service-report-datatable" class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                            <th>#</th>
                                            <th>Job Id</th>
                                            <th>Company</th>
                                            <th>Job Status</th>
                                            <th>Stard Time</th>
                                            <th>End Time</th>
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
                    d.job_id = $('#job_id_filter_1').val();
                    d.company_id = $('#company_id_filter_2').val();
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'job_id', name: 'job_id' },
                { data: 'company', name: 'company' },
                { data: 'task_status', name: 'task_status' },
                { data: 'job_start_time', name: 'job_start_time' },
                { data: 'job_end_time', name: 'job_end_time' },
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
        $('#job_id_filter_1, #company_id_filter_2, #start_date, #end_date').on('change', function () {
         table.ajax.reload();
       });

        $('.select2').select2();
    });
</script>
 
        @endsection
 
  
   
 </x-app-layout>

