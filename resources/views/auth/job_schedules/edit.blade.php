
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
            $('#product_id').select2({
                placeholder: $('#product_id').data('placeholder'),
                ajax: {
                    url: $('#product_id').data('url'),
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term // search term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    id: item.id,
                                    text: item.title
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

        $('#company_id').on('change', function () {
            let companyId = $(this).val();
            let $customer = $('#customer_id');

            $customer.empty().trigger('change'); // clear old data

            if (companyId) {
                $.ajax({
                    url: '/ajax/company-customers/' + companyId,
                    type: 'GET',
                    success: function (data) {
                        let options = '<option value="">Select customer</option>';
                        $.each(data, function (id, name) {
                            options += `<option value="${id}">${name}</option>`;
                        });
                        $customer.html(options);
                        $customer.trigger('change');
                    }
                });
            }
        });

        </script>

        <script>
    $(document).ready(function () {
        $('#order_id').select2({
            placeholder: $('#order_id').data('placeholder'),
            allowClear: true,
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