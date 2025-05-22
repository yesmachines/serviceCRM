<x-app-layout>
    @section('title', 'Technicians')

    @section('header')
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('job-schedules.index') }}">Job Schedule</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>
    <h4 class="page-title">Job Schedule</h4>
    <!-- Technicians -->
    @endsection

    @section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{ html()->form('POST')->route('job-schedules.store')->acceptsFiles()->open() }}
                    @include('auth.job_schedules.form')
                    {{ html()->submit('submit')->class('btn btn-primary') }}
                    {{ html()->form()->close() }}
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('pre-css')
        <link href="{{ asset('cms/assets/vendor/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('cms/assets/vendor/daterangepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('cms/assets/vendor/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('cms/assets/vendor/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
    @endsection
    @section('pre-js')
        <script src="{{asset('cms/assets/vendor/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
        <script src="{{ asset('cms/assets/vendor/select2/js/select2.min.js')}}"></script>
        <script src="{{asset('cms/assets/vendor/daterangepicker/moment.min.js')}}"></script> 
        <script src="{{asset('cms/assets/vendor/daterangepicker/daterangepicker.js')}}"></script>
        <script src="{{asset('cms/assets/vendor/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
        <script src="{{asset('cms/assets/vendor/flatpickr/flatpickr.min.js')}}"></script>
        <script src="{{asset('cms/assets/js/pages/timepicker.init.js')}}"></script>

      

        <script>

              $("#end-timepicker").flatpickr({ 
            enableTime: true, 
            noCalendar: true, 
            dateFormat: "H:i" 
            });
             $("#close-timepicker").flatpickr({ 
            enableTime: true, 
            noCalendar: true, 
            dateFormat: "H:i" 
            });

            $("#basic-timepicker").flatpickr({ 
            enableTime: true, 
            noCalendar: true, 
            dateFormat: "H:i" 
            });
             $("#end_timepicker").flatpickr({ 
            enableTime: true, 
            noCalendar: true, 
            dateFormat: "H:i" 
            });

            </script>




        
        <script>
    $(document).ready(function () {
        // Initialize select2
        $('.select2').select2({
            width: '100%'
        });

        $('#supplier_id').on('change', function () {
            let supplierId = $(this).val();
            let $product = $('#product_id');

            // Reset product list
            $product.empty().append('<option value="">Select Product</option>');

            if (supplierId) {
                $.ajax({
                    url: '/ajax/supplier/' + supplierId,
                    type: 'GET',
                    success: function (data) {
                        $.each(data, function (id, title) {
                            $product.append(`<option value="${id}">${title}</option>`);
                        });

                        // Refresh Select2
                        $product.trigger('change');
                    }
                });
            }
        });

        // Optional: trigger change if supplier_id has a value on page load (edit page)
        @if(old('supplier_id', $data->supplier_id ?? false))
            $('#supplier_id').trigger('change');
        @endif
    });
</script>


<script>
    $(document).ready(function () {
        $('.select2').select2({ width: '100%' });

        // Company to Customer Change
        $('#company_id').on('change', function () {
            let companyId = $(this).val();
            let $customer = $('#customer_id');

            // Reset customer list
            $customer.empty().append('<option value="">Select customer</option>');

            if (companyId) {
                $.ajax({
                    url: '/ajax/company-customers/' + companyId,
                    type: 'GET',
                    success: function (data) {
                        $.each(data, function (id, name) {
                            $customer.append(`<option value="${id}">${name}</option>`);
                        });

                        // Refresh Select2
                        $customer.trigger('change');
                    }
                });
            }
        });

        
        @if(old('company_id', $data->company_id ?? false))
            $('#company_id').trigger('change');
        @endif
    });
</script>



        <script>
    $(document).ready(function () {
        $('#order_id').select2({
            placeholder: $('#order_id').data('placeholder'),
            allowClear: false,
            ajax: {
                url: $('#order_id').data('url'),
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.id,
                                text: item.os_number
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('.select2-demo').select2({
            placeholder: function () {
                return $(this).data('placeholder');
            },
            allowClear: false,
            ajax: {
                url: function () {
                    return $(this).data('url');
                },
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.id,
                                text: item.reference_no
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1
        });
    });
</script>


<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const jobTypeSelect = document.getElementById('job_type_id');
        const jobTypeFields = document.getElementById('job-type-fields');

        function toggleJobFields() {
            const selectedValue = jobTypeSelect.options[jobTypeSelect.selectedIndex].text.toLowerCase();
            console.log('Selected:', selectedValue);

            if (selectedValue === 'inside' || selectedValue === 'outside' || selectedValue === 'amc') {
                jobTypeFields.classList.remove('d-none');
            } else {
                jobTypeFields.classList.add('d-none');
            }
        }

        toggleJobFields(); // On page load
        jobTypeSelect.addEventListener('change', toggleJobFields); // On dropdown change
    });
</script> -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const jobTypeSelect = document.getElementById('job_type_id');
        const jobTypeFields = document.getElementById('job-type-fields');
        const drfField = document.getElementById('drf-reference-field');
        const chargeableField = document.getElementById('chargeable-order-field');

        function toggleJobFields() {
            const selectedValue = jobTypeSelect.options[jobTypeSelect.selectedIndex].text.toLowerCase();
            console.log('Selected Job Type:', selectedValue);

            // Show extra fields for these job types
            if (['inside', 'outside', 'amc'].includes(selectedValue)) {
                jobTypeFields.classList.remove('d-none');
            } else {
                jobTypeFields.classList.add('d-none');
            }

            // Show DRF when demo is selected, otherwise show chargeable order
            if (selectedValue === 'demo') {
                drfField?.classList.remove('d-none');
                drfField?.style.setProperty('display', 'block');
                chargeableField?.style.setProperty('display', 'none');
            } else {
                drfField?.style.setProperty('display', 'none');
                chargeableField?.style.setProperty('display', 'block');
            }
        }

        toggleJobFields(); // Initial run
        jobTypeSelect.addEventListener('change', toggleJobFields); // On dropdown change
    });
</script>




    @endsection
</x-app-layout>



