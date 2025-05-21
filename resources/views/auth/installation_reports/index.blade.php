<x-app-layout>
    @section('title', 'Installation Reports')

    @section('header')
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboards</a></li>
            <li class="breadcrumb-item active">Installation Reports</li>
        </ol>
    </div>
    <h4 class="page-title">Installation Reports</h4>
    @endsection

    @section('content')
  
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="header-title mb-0">Installation Reports</h4>
            </div>

            <div class="card-body">
        

            <div class="row mb-3">
                        <!-- First Dropdown -->
                        <div class="col-lg-3">
                            <label for="job_id_filter_1" class="form-label">Filter by Job ID</label>
                            <select id="job_id_filter_1" class="form-control select2" data-toggle="select2">
                                <option value="">All Job IDs</option>
                                @foreach($jobSchedules as $job)
                                    <option value="{{ $job->id }}">{{ $job->job_no }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Second Dropdown -->
                        <div class="col-lg-3">
                            <label for="job_id_filter_2" class="form-label">Filter by Job Status</label>
                            <select id="job_id_filter_2" class="form-control">
                                <option value="">All Job IDs</option>
                                @foreach($jobStatus as $job)
                                    <option value="{{ $job->id }}">{{ $job->status }}</option>
                                @endforeach
                            </select>
                        </div>

                       
                    </div>


                <div class="card-body">
                    <table id="installation-report-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                            <tr>
                              <th>#</th>
                              <th>Job Id</th>
                              <th>Job Status</th>
                              <th>Company</th>
                              <th>Client Feedback</th>
                              <th>Technician Feedback</th>
                              <th>Actions</th>
                            </tr>
                           
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('pre-css')
    <link href="{{ asset('cms/assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('cms/assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('cms/assets/vendor/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    @endsection

    @section('pre-js')
    <script src="{{ asset('cms/assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('cms/assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('cms/assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('cms/assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('cms/assets/vendor/select2/js/select2.min.js')}}"></script>

    <script>


    $(document).ready(function () {
        const table = $('#installation-report-datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            language: {
                paginate: {
                    previous: "<i class='ri-arrow-left-s-line'></i>",
                    next: "<i class='ri-arrow-right-s-line'></i>"
                }
            },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
            ajax: {
                url: '{{ route("installation-reports.data") }}',
                data: function (d) {
                    d.job_id = $('#job_id_filter_1').val();
                    d.job_status = $('#job_id_filter_2').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'job_id', name: 'job_id' },
                { data: 'job_status', name: 'job_status' },
                { data: 'company', name: 'company' },
                { data: 'client_feedback', name: 'client_feedback' },
                { data: 'technician_feedback', name: 'technician_feedback' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false },
            ]
        });

        $('#job_id_filter_1, #job_id_filter_2').on('change', function () {
            table.ajax.reload();
        });

        $('.select2').select2();
    });
</script>




    @endsection
</x-app-layout>

