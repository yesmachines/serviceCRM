<x-app-layout>
    @section('title', 'Job Schedules')

    @section('header')
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboards</a></li>
            <li class="breadcrumb-item active">Job Schedules</li>
        </ol>
    </div>
    <h4 class="page-title">Job Schedules</h4>
    @endsection

    @section('content')
   

                
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title mb-0"></h4>
                    <a href="{{route('job-schedules.create')}}" class="btn btn-mg btn-secondary">
                    {{ __('Create Job Schedule') }}
                    </a>
                    
                </div>

                <div class="card-body">

                    <!-- Filters -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="company_filter">Company</label>
                            <select id="company_filter" class="form-control select2">
                                <option value="">All</option>
                                @foreach($companies as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="job_filter">Job No</label>
                            <select id="job_filter" class="form-control select2">
                                <option value="">All</option>
                                @foreach($jobSchedules as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="type_filter">Service Type</label>
                            <select id="type_filter" class="form-control select2">
                                <option value="">All</option>
                                @foreach($types as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status_filter">Job Status</label>
                            <select id="status_filter" class="form-control select2">
                                <option value="">All</option>
                                @foreach($statuses as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Table -->
                    <table id="jobschedules-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Job No</th>
                                <th>Job Type</th>
                                <th>Customer</th>
                                <th>Company</th>
                                <th>Product</th>
                                <th>Status</th>
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
        <link href="{{ asset('cms/assets/vendor/select2/css/select2.min.css') }}" rel="stylesheet" />
    @endsection

    @section('pre-js')
        <script src="{{ asset('cms/assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('cms/assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('cms/assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('cms/assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('cms/assets/vendor/select2/js/select2.min.js') }}"></script>

        <script>
            $(document).ready(function () {
                $('.select2').select2();

                const table = $('#jobschedules-datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('job-schedules.data') }}',
                        data: function (d) {
                            d.company_id = $('#company_filter').val();
                            d.job_id = $('#job_filter').val();
                            d.type_id = $('#type_filter').val();
                            d.status_id = $('#status_filter').val();
                        }
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'job_no', name: 'job_no' },
                        { data: 'job_type', name: 'job_type' },
                        { data: 'customer', name: 'customer' },
                        { data: 'company', name: 'company' },
                        { data: 'product', name: 'product' },
                        { data: 'jobstatus', name: 'jobstatus' },
                        { data: 'actions', name: 'actions', orderable: false, searchable: false }
                    ],
                    language: {
                        paginate: {
                            previous: "<i class='ri-arrow-left-s-line'></i>",
                            next: "<i class='ri-arrow-right-s-line'></i>"
                        }
                    },
                    drawCallback: function () {
                        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                    }
                });

                $('#company_filter, #job_filter, #type_filter, #status_filter').on('change', function () {
                    table.ajax.reload();
                });
            });
        </script>
    @endsection
</x-app-layout>
