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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title mb-0"></h4>
                </div>

                <div class="card-body">
                    <table id="demo-client-report-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                            <tr>
                              <th>#</th>
                              <th>Job Id</th>
                              <th>Demo Objective</th>
                              <th>Designation</th>
                              <th>Rating</th>
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
    @endsection

    @section('pre-js')
    <script src="{{ asset('cms/assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('cms/assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('cms/assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('cms/assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>

    <script>
        $('#demo-client-report-datatable').DataTable({
            processing: true,
            serverSide: true,
            language: {
                paginate: {
                    previous: "<i class='ri-arrow-left-s-line'>",
                    next: "<i class='ri-arrow-right-s-line'>"
                }
            },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
            ajax: '{{ route('demo-client-reports.data') }}',
            columns: [
              { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
           
        { data: 'job_id', name: 'job_id' },
        { data: 'demo_objective', name: 'demo_objective' },
        { data: 'designation', name: 'designation' },
        { data: 'rating', name: 'rating' },
        { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            responsive: true
        });
    </script>


    @endsection
</x-app-layout>

