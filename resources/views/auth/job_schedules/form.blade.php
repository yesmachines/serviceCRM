<div class="row">

    <div class="col-md-4">
    <div class="mb-3">
    {{ html()->label('Job Type', 'job_type_id')->class('form-label') }}

    @if (!empty($data->job_type)) {{-- If job type is set, show read-only --}}
        @php
            $selectedJobType = \App\Models\ServiceType::find($data->job_type);
        @endphp
        <input type="hidden" name="job_type_id" value="{{ $selectedJobType->id }}">
        <input type="text" class="form-control" value="{{ $selectedJobType->title }}" readonly>
    @else {{-- If job type not set, show dropdown --}}
        <select name="job_type_id" class="form-control{{ $errors->has('job_type_id') ? ' is-invalid' : '' }}" id="job_type_id">
            <option value="">Select Job Type</option>

            @foreach ($serviceTypesGrouped[null] ?? [] as $parent)
                @php
                    $hasChildren = isset($serviceTypesGrouped[$parent->id]);
                    $selectedId = old('job_type_id');
                @endphp

                @if ($hasChildren)
                    <optgroup label="{{ $parent->title }}">
                        @foreach ($serviceTypesGrouped[$parent->id] as $child)
                            <option value="{{ $child->id }}" {{ $selectedId == $child->id ? 'selected' : '' }}>
                                {{ $child->title }}
                            </option>
                        @endforeach
                    </optgroup>
                @else
                    <option value="{{ $parent->id }}" {{ $selectedId == $parent->id ? 'selected' : '' }}>
                        {{ $parent->title }}
                    </option>
                @endif
            @endforeach
        </select>

        {!! $errors->first('job_type_id', '<div class="invalid-feedback">:message</div>') !!}
    @endif
</div>

        

        {{-- Hidden fields shown conditionally --}}
        <div id="job-type-fields" class="row d-none">
            <div class="col-md-6 mb-4">
                {{ html()->label('Machine Type', 'machine_type')->class('form-label') }}
                {{ html()->select('machine_type', $machineTypes, old('machine_type'))
                    ->class('form-control' . ($errors->has('machine_type') ? ' is-invalid' : '')) }}
                {!! $errors->first('machine_type', '<div class="invalid-feedback">:message</div>') !!}
            </div>

            <div class="col-md-6 mb-4">
                {{ html()->label('Is Warranty', 'is_warranty')->class('form-label') }}
                {{ html()->select('is_warranty', $warrantyStatuses, old('is_warranty'))
                    ->class('form-control' . ($errors->has('is_warranty') ? ' is-invalid' : '')) }}
                {!! $errors->first('is_warranty', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            {{ html()->label('Job Status', 'job_status_id')->class('form-label') }}

            {{ html()->select('job_status_id', $jobStatuses, old('job_status_id', $data->job_status_id ?? null))
                ->class('form-control' . ($errors->has('job_status_id') ? ' is-invalid' : ''))
                ->attributes(['id' => 'job_status_id']) }}

            {!! $errors->first('job_status_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>


    {{-- Chargeable Order No --}}
        <div class="col-md-4" id="chargeable-order-field">
            <div class="mb-3">
                {{ html()->label('Chargeble', 'chargeble')->class('form-label') }}

                {{ html()->select('order_id', $orders, old('order_id', $data->order_id ?? null))
                    ->class('form-control select2-order' . ($errors->has('order_id') ? ' is-invalid' : ''))
                    ->attributes([
                        'id' => 'order_id',
                        'data-placeholder' => 'Select an order no',
                        'data-url' => route('find-order.ajax')
                    ]) }}

                {!! $errors->first('order_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>

      

        {{-- DRF Reference --}}
        <div class="col-md-4" id="drf-reference-field" style="display: none;">
            <div class="mb-3">
                {{ html()->label('Drf Reference', 'drf_refference')->class('form-label') }}

                {{ html()->select('demo_request_id', $drfRefferences, old('demo_request_id', $data->demo_request_id ?? null))
                    ->class('form-control select2-demo' . ($errors->has('demo_request_id') ? ' is-invalid' : ''))
                    ->attributes([
                        'id' => 'demo_request_id',
                        'data-placeholder' => 'Select reference',
                        'data-url' => route('find-demo.ajax')
                    ]) }}

                {!! $errors->first('demo_request_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>

</div>



    <div class="row">
            <div class="col-md-4">
            <div class="mb-3">
                {{ html()->label('Company', 'company_id')->class('form-label') }}
                {{ html()->select('company_id', $companies,  old('company_id', $data->company_id ?? null) )
                    ->class('form-control select2' . ($errors->has('company_id') ? ' is-invalid' : ''))
                    ->attributes(['id' => 'company_id']) }}
                {!! $errors->first('company_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>

        {{-- Customer Dropdown --}}
        <div class="col-md-4">
            <div class="mb-3">
                {{ html()->label('Customer', 'customer_id')->class('form-label') }}
                <select id="customer_id" name="customer_id"
                        class="form-control select2{{ $errors->has('customer_id') ? ' is-invalid' : '' }}">
                    <option value="">Select customer</option>
                
                    @if (!empty($data->customer_id) && isset($customers[$data->customer_id]))
                        <option value="{{ $data->customer_id }}" selected>
                            {{ $customers[$data->customer_id] }}
                        </option>
                    @endif
                </select>
                {!! $errors->first('customer_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>

        

    
        {{-- Supplier Dropdown --}}
        <div class="col-md-4">
            <div class="mb-3">
                {{ html()->label('Supplier', 'supplier_id')->class('form-label') }}
                {{ html()->select('supplier_id', $suppliers, old('supplier_id', $data->brand_id ?? null))
                    ->class('form-control select2' . ($errors->has('supplier_id') ? ' is-invalid' : ''))
                    ->attributes(['id' => 'supplier_id']) }}
                {!! $errors->first('supplier_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>

        

    </div>



 
    
    <div class="row">

        {{-- Product Dropdown --}}
        <div class="col-md-4">
                <div class="mb-3">
                    {{ html()->label('Product', 'product_id')->class('form-label') }}
                    <select id="product_id" name="product_id"
                            class="form-control select2{{ $errors->has('product_id') ? ' is-invalid' : '' }}">
                        <option value="">Select Product</option>

                        {{-- Pre-fill if editing --}}
                        @if (!empty($data->product_id) && isset($products[$data->product_id]))
                            <option value="{{ $data->product_id }}" selected>{{ $products[$data->product_id] }}</option>
                        @endif
                    </select>
                    {!! $errors->first('product_id', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
        <div class="col-md-4">
                <div class="mb-3">
                    {{ html()->label('Technician', 'technician_id')->class('form-label') }}

                    {{ html()->select('technician_id', $technicians, old('technician_id', $data->technician_id ?? null))
                        ->class('form-control select2' . ($errors->has('technician_id') ? ' is-invalid' : ''))
                        ->attributes(['id' => 'technician_id', 'data-toggle' => 'select2']) }}

                    {!! $errors->first('technician_id', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    {{ html()->label('Contact No', 'contact_no')->class('form-label') }}
                    {{ html()->text('contact_no')->class('form-control'.($errors->has('contact_no') ? ' is-invalid' : ''))->value(old('contact_no',$data->contact_no ?? null))  }}
                    {!! $errors->first('contact_no','<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>


</div>


<div class="row">


    <div class="col-md-4">
        <div class="mb-3">
            {{ html()->label('Location', 'location')->class('form-label') }}
            {{ html()->text('location')->class('form-control'.($errors->has('location') ? ' is-invalid' : ''))->value(old('location',$data->location ?? null))  }}
            {!! $errors->first('location','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>

  

    <div class="col-md-4">
        <div class="mb-3">
            {{ html()->label('Start Date', 'start_date')->class('form-label') }}
            {{ html()->text('start_date')
                ->class('form-control date' . ($errors->has('start_date') ? ' is-invalid' : ''))
                ->attributes([
                    'id' => 'startdatepicker',
                    'data-toggle' => 'date-picker',
                    'data-single-date-picker' => 'true'
                ])
                ->value(old('start_date', $data->start_date ?? null)) }}
            {!! $errors->first('start_date', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>


    <div class="col-md-4">
        <div class="mb-3">
            {{ html()->label('End Date', 'end_date')->class('form-label') }}

            {{ html()->text('end_date')
                ->class('form-control date' . ($errors->has('end_date') ? ' is-invalid' : ''))
                ->attributes([
                    'id' => 'startdatepicker',
                    'data-toggle' => 'date-picker',
                    'data-single-date-picker' => 'true'
                ])
                ->value(old('end_date', $data->end_date ?? null)) }}

            {!! $errors->first('end_date', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>

   
</div>



<div class="row">
    
  

       


 <div class="col-md-4">
 <div class="mb-3">
    {{ html()->label('Start Time', 'start_time')->class('form-label') }}

    <div class="input-group">
        {{ html()->text('start_time')
            ->class('form-control' . ($errors->has('start_time') ? ' is-invalid' : ''))
            ->attributes([
                'id' => 'basic-timepicker',
                'name' => 'start_time', {{-- ADD THIS if not added --}}
                'placeholder' => 'Select time'
            ])
            ->value(old('start_time', $data->start_time ?? null)) }}

        <span class="input-group-text"><i class="ri-time-line"></i></span>
    </div>

 

    @if($errors->has('start_time'))
                <div class="invalid-feedback d-block"> {{-- d-block ensures it's visible --}}
                    {{ $errors->first('start_time') }}
                </div>
            @endif
</div>

    </div>

  

     <div class="col-md-4">
     <div class="mb-3">
              {{ html()->label('End Time', 'end_time')->class('form-label') }}

            <div class="input-group">
                {{ html()->text('end_time')
                    ->class('form-control' . ($errors->has('end_time') ? ' is-invalid' : ''))
                    ->attributes([
                        'id' => 'end_timepicker',
                        'name' => 'end_time', {{-- Ensure this is included --}}
                        'placeholder' => 'Select time'
                    ])
                    ->value(old('end_time', $data->end_time ?? null)) }}

                <span class="input-group-text"><i class="ri-time-line"></i></span>
            </div>

            {{-- This must be placed OUTSIDE .input-group but inside .mb-3 --}}
            @if($errors->has('end_time'))
                <div class="invalid-feedback d-block"> {{-- d-block ensures it's visible --}}
                    {{ $errors->first('end_time') }}
                </div>
            @endif
        </div>
  
    </div>

   
 
</div>

<div class="row">

 <div class="col-md-6">
        <div class="mb-3">
            {{ html()->label('Job Details', 'job_details')->class('form-label') }}

            {{ html()->textarea('job_details')
            ->class('form-control' . ($errors->has('job_details') ? ' is-invalid' : ''))
            ->attributes(['id' => 'example-textarea', 'rows' => 5])
            ->value(old('job_details', $data->job_details ?? null)) }}

            {!! $errors->first('job_details', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>




    <div class="col-md-6">
        <div class="mb-3">
            {{ html()->label('Remarks', 'remarks')->class('form-label') }}

            {{ html()->textarea('remarks')
            ->class('form-control' . ($errors->has('remarks') ? ' is-invalid' : ''))
            ->attributes(['id' => 'example-textarea', 'rows' => 5])
            ->value(old('remarks', $data->remarks ?? null)) }}

            {!! $errors->first('remarks', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>


    



</div>