
<x-app-layout>
    @section('title', 'Job Schedule')

    @section('header')
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('job-schedules.index') }}">Job Schedule</a></li>
            <li class="breadcrumb-item active">Edit</li>
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
                    {{ html()->modelForm($data, 'PUT')->route('job-schedules.update',$data->id)->acceptsFiles()->open() }}
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

        // Date pickers

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

            </script>

        
<script>
   $(document).ready(function () {

    $('.select2').select2({ width: '100%' });

    function loadProducts(supplierId, selectedProductId = null) {
      
        const $product = $('#product_id');

        // console.log("Supplierid",supplierId);
        $product.empty().append('<option value="">Select Product</option>');

        if (supplierId) {
            $.ajax({
                url: '/ajax/supplier/' + supplierId,
                type: 'GET',
                success: function (data) {
                    console.log("Loaded Products:", data); // Debug line

                    $.each(data, function (id, title) {
                        let selected = (id == selectedProductId) ? 'selected' : '';
                        $product.append(`<option value="${id}" ${selected}>${title}</option>`);
                    });

                    $product.select2({ width: '100%' }); // Important!
                },
                error: function (xhr) {
                    console.error("Product load failed:", xhr.responseText);
                }
            });
        }
    }

    $('#supplier_id').on('change', function () {
        const supplierId = $(this).val();
        loadProducts(supplierId);
    });



    @if(old('supplier_id', $data->brand_id ?? false))
    loadProducts(
        '{{ old('supplier_id', $data->brand_id ?? null) }}',
        '{{ old('product_id', $data->product_id ?? null) }}'
    );
    @endif

});



</script>




<script>
    $(document).ready(function () {
        // Initialize Select2 on all relevant dropdowns
        $('.select2').select2({ width: '100%' });

        function loadCustomers(companyId, selectedCustomerId = null) {
            let $customer = $('#customer_id');

            $customer.empty().append('<option value="">Select customer</option>');

            if (companyId) {
                $.ajax({
                    url: '/ajax/company-customers/' + companyId,
                    type: 'GET',
                    success: function (data) {
                        $.each(data, function (id, name) {
                            let selected = (id == selectedCustomerId) ? 'selected' : '';
                            $customer.append(`<option value="${id}" ${selected}>${name}</option>`);
                        });

                        // Reinitialize Select2
                        $customer.trigger('change');
                    }
                });
            }
        }

        // On change of company dropdown
        $('#company_id').on('change', function () {
            let companyId = $(this).val();
            loadCustomers(companyId);
        });

        // Auto-trigger on edit or validation error (to retain old value)
        @if(old('company_id', $data->company_id ?? false))
            loadCustomers('{{ old('company_id', $data->company_id ?? null) }}', '{{ old('customer_id', $data->customer_id ?? null) }}');
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
</script>



    @endsection
</x-app-layout>