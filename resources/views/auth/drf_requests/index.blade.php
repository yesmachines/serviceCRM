<x-app-layout>
    @section('title', 'Demo Request Forms')

    @section('header')
        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboards</a></li>
                <li class="breadcrumb-item active">Demo Request Forms</li>
            </ol>
        </div>
        <h4 class="page-title">Demo Request Forms</h4>
    @endsection

    @section('content')
        <div class="col-12">
            <div class="card">

            <!-- @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif -->


                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title mb-0">Demo Request Forms</h4>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <!-- Company Filter -->
                        <div class="col-lg-3">
                            <label for="company_id_filter" class="form-label">Company</label>
                            <select id="company_id_filter" class="form-control select2">
                                <option value="">All Companies</option>
                                @foreach($companies as $id => $company)
                                    <option value="{{ $id }}">{{ $company }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <table id="drf-request-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Brand</th>
                                <th>Company</th>
                                <th>Customer</th>
                                <th>Demo Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>
        </div>
    @endsection

    @section('pre-css')
        <link href="{{ asset('cms/assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('cms/assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('cms/assets/vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    @endsection

    @section('pre-js')
        <script src="{{ asset('cms/assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('cms/assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('cms/assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('cms/assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('cms/assets/vendor/select2/js/select2.min.js') }}"></script>

        <script>
            $(document).ready(function () {
                const table = $('#drf-request-datatable').DataTable({
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
                        url: '{{ route("drf-requests.data") }}',
                        data: function (d) {
                            d.company_id = $('#company_id_filter').val();
                        }
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'brand', name: 'brand' },
                        { data: 'company', name: 'company' },
                        { data: 'customer', name: 'customer' },
                        { data: 'demo_date', name: 'demo_date' },
                        { data: 'status', name: 'status' },
                        { data: 'actions', name: 'actions', orderable: false, searchable: false }
                    ]
                });

                $('#company_id_filter').on('change', function () {
                    table.ajax.reload();
                });

                $('.select2').select2();
            });
        </script>
    @endsection
</x-app-layout>
