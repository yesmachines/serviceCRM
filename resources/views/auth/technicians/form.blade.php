<!-- Image Upload Row -->
<div class="row mb-3">
    <div class="col-md-4">
        <div class="mb-2" id="image-preview-container" style="{{ !empty($data->employee->image_url) ? '' : 'display: none;' }}">
            <img id="image-preview" src="{{ isset($data->employee) ? asset('storage/' . optional($data->employee)->image_url) : asset('cms/assets/images/profile.png') }}" alt="Image Preview" class="img-thumbnail" style="max-height: 200px;">
        </div>
        {{ html()->file('image')->class('form-control'.($errors->has('image') ? ' is-invalid' : ''))->accept("image/*") }}
        {!! $errors->first('image','<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="mb-3">
            {{ html()->label('Full Name', 'full_name')->class('form-label') }}
            {{ html()->text('name')->class('form-control'.($errors->has('name') ? ' is-invalid' : '')) }}
            {!! $errors->first('name','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            {{ html()->label('Employee ID', 'employee_id')->class('form-label') }}
            {{ html()->text('employee_id')->class('form-control'.($errors->has('employee_id') ? ' is-invalid' : ''))->value(old('employee_id',$data->employee->emp_num ?? null)) }}
            {!! $errors->first('employee_id','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            {{ html()->label('Email', 'email')->class('form-label') }}
            {{ html()->email('email')->class('form-control'.($errors->has('email') ? ' is-invalid' : '')) }}
            {!! $errors->first('email','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="mb-3">
            {{ html()->label('Password', 'password')->class('form-label') }}
            {{ html()->password('password')->class('form-control'.($errors->has('password') ? ' is-invalid' : '')) }}
            {!! $errors->first('password','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            {{ html()->label('Confirm Password', 'password_confirmation')->class('form-label') }}
            {{ html()->password('password_confirmation')->class('form-control'.($errors->has('password_confirmation') ? ' is-invalid' : '')) }}
            {!! $errors->first('password_confirmation','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            {{ html()->label('Phone', 'phone')->class('form-label') }}
            {{ html()->text('phone')->class('form-control'.($errors->has('phone') ? ' is-invalid' : ''))->value(old('phone',$data->employee->phone ?? null)) }}
            {!! $errors->first('phone','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="mb-3">
            {{ html()->label('Division', 'division')->class('form-label') }}
            {{ 
                html()->Select('division')->class('form-control'.($errors->has('division') ? ' is-invalid' : ''))
                        ->options([
                    ''=>'---',
                    'sd'=>'Steel Machinery',
                    'is'=>'Industrial Solutions',
                    'ct'=>'Cleaning Technology',
                    'serv'=>'Maintenance and Service',
                    'ops'=>'Operations and Logistics'
                ]) ->value(old('division',$data->employee->division ?? null)) 
            }}
            {!! $errors->first('division','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            {{ html()->label('Designation', 'designation')->class('form-label') }}
            {{ html()->text('designation')->class('form-control'.($errors->has('designation') ? ' is-invalid' : ''))->value(old('designation',$data->employee->designation ?? null))  }}
            {!! $errors->first('designation','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            {{ html()->label('ACL', 'acl')->class('form-label') }}
            {{ 
                html()->Select('acl[]')->class('select2 form-control select2-multiple'.($errors->has('acl') ? ' is-invalid' : ''))
                        ->multiple() 
                        ->attributes(['data-placeholder'=>'Choose...','data-toggle'=>'select2']) 
                        ->options($roles) 
                         ->value(old('acl',$data->acl ?? null))
            }}
            {!! $errors->first('acl','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="mb-3">
            {{ html()->label('Status', 'status')->class('form-label') }}
            {{  html()->Select('status')->class('form-control'.($errors->has('status') ? ' is-invalid' : ''))
                        ->attributes(['id'=>'status1']) 
                        ->options(['1'=>'Active', '0'=>'Inactive' ]) ->value(old('status',$data->employee->status ?? null)) 
            }}
            {!! $errors->first('status','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            {{ html()->label('Vehicle Assigned', 'vehicle_assigned')->class('form-label') }}
            {{ 
                html()->Select('vehicle_assigned')->class('form-control'.($errors->has('vehicle_assigned') ? ' is-invalid' : ''))
                        ->options($vehicles) 
                        ->value(old('vehicle_assigned',$data->technician->vehicle->id ?? null)) 
            }}
            {!! $errors->first('vehicle_assigned','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            {{ html()->label('Select Level', 'technician_level')->class('form-label') }}
            {{ 
                html()->Select('technician_level')->class('form-control'.($errors->has('technician_level') ? ' is-invalid' : ''))
                        ->options($techLevels) 
                         ->value(old('technician_level',$data->technician->technician_level ?? null)) 
            }}
            {!! $errors->first('technician_level','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="mb-3">
            {{ html()->label('Standard Charge', 'standard_charge')->class('form-label') }}
            {{ 
                html()->number('standard_charge')->class('form-control'.($errors->has('standard_charge') ? ' is-invalid' : ''))
                        ->attributes(['step'=>'0.01'])  
                         ->value(old('standard_charge',$data->technician->standard_charge ?? null)) 
            }}
            {!! $errors->first('standard_charge','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            {{ html()->label('Additional Charge', 'standard_charge')->class('form-label') }}
            {{ 
                html()->number('additional_charge')->class('form-control'.($errors->has('additional_charge') ? ' is-invalid' : ''))
                        ->attributes(['step'=>'0.01'])  
                        ->value(old('additional_charge',$data->technician->additional_charge ?? null)) 
            }}
            {!! $errors->first('additional_charge','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>