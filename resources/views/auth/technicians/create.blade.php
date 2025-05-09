<x-app-layout>
    @section('title', 'Technicians')

    @section('header')
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Employees</li>
        </ol>
    </div>
    <h4 class="page-title"> Employees</h4>
    <!-- Technicians -->
    @endsection

    @section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Create Employee</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('technicians.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Image Upload Row -->
                        <div class="row mb-3">
                            <div class="col-md-4 text-center">
                                <div class="mb-2" id="image-preview-container" style="display: none;">
                                    <img id="image-preview" alt="Image Preview" class="img-thumbnail" style="max-height: 200px;">
                                </div>
                                <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Full Name -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="full_name" class="form-label">Full Name</label>
                                    <input type="text" id="full_name" name="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name') }}">
                                    @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Employee ID -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="employee_id" class="form-label">Employee ID</label>
                                    <input type="text" id="employee_id" name="employee_id" class="form-control @error('employee_id') is-invalid @enderror" value="{{ old('employee_id') }}">
                                    @error('employee_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Password -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
                                    @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Division -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="division" class="form-label">Division <span class="text-danger">*</span></label>
                                    <select id="division" name="division" class="form-control @error('division') is-invalid @enderror">
                                        <option value="sd">Steel Machinery</option>
                                        <option value="is">Industrial Solutions</option>
                                        <option value="ct">Cleaning Technology</option>
                                        <option value="serv">Maintenance and Service</option>
                                        <option value="ops">Operations and Logistics</option>
                                    </select>
                                    @error('division')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Designation -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="designation" class="form-label">Designation</label>
                                    <input type="text" id="designation" name="designation" class="form-control @error('designation') is-invalid @enderror" value="{{ old('designation') }}">
                                    @error('designation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>



                            <!-- <div class="col-md-4">
                               <div class="mb-3">
                                   <label for="acl" class="form-label">ACL (Access Control List)</label>
                                   <select class="select2 form-control select2-multiple @error('acl') is-invalid @enderror" 
                                           id="acl" 
                                           name="acl[]" 
                                           multiple 
                                           data-toggle="select2" 
                                           data-placeholder="Choose ACL roles...">
                                       <optgroup label="Servicemanager Role">
                                           <option value="servicemanager" {{ (collect(old('acl'))->contains('servicemanager')) ? 'selected' : '' }}>Servicemanager</option>
                                       </optgroup>
                                       <optgroup label="Servicecoordinator Role">
                                           <option value="servicecoordinator" {{ (collect(old('acl'))->contains('servicecoordinator')) ? 'selected' : '' }}>Servicecoordinator</option>
                                       </optgroup>
                                       <optgroup label="Servicetechnician Role">
                                           <option value="servicetechnician" {{ (collect(old('acl'))->contains('servicetechnician')) ? 'selected' : '' }}>Servicetechnician</option>
                                       </optgroup>
                                   </select>
                                   @error('acl')
                                       <div class="invalid-feedback">{{ $message }}</div>
                                   @enderror
                               </div>
                           </div> -->


                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="acl" class="form-label">ACL (Access Control List)</label>
                                    <select class="select2 form-control select2-multiple @error('acl') is-invalid @enderror" 
                                            id="acl" 
                                            name="acl[]" 
                                            multiple 
                                            data-toggle="select2" 
                                            data-placeholder="Choose ACL roles...">
                                        @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" 
                                                {{ (collect(old('acl'))->contains($role->name)) ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('acl')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>



                        </div>

                        <!-- <div class="mb-3">
                                <label for="acl" class="form-label">ACL (Access Control List)</label>
                                <select class="select2 form-control select2-multiple @error('acl') is-invalid @enderror"
                                        id="acl"
                                        name="acl[]"
                                        multiple
                                        data-toggle="select2"
                                        data-placeholder="Choose ACL roles...">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" 
                                            {{ (collect(old('acl'))->contains($role->id)) ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('acl')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> -->



                        <!--  -->





                        <!-- end
                      


                       

                       

                        <div class="row">
                        <!-- Status -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select id="technician_level" name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="vehicle_assigned" class="form-label">Vehicle Assigned</label>
                                    <select id="vehicle_assigned" name="vehicle_assigned" class="form-control @error('vehicle_assigned') is-invalid @enderror">
                                        <option value="">Select vehicle</option>
                                        @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}" {{ old('vehicle_assigned') == $vehicle->id ? 'selected' : '' }}>
                                            {{ $vehicle->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('vehicle_assigned')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>




                            <!-- Technician Level -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="technician_level" class="form-label">Technician Level</label>
                                    <select id="technician_level" name="technician_level" class="form-control @error('technician_level') is-invalid @enderror">
                                        <option value="">Select Level</option>
                                        @foreach(\App\Enum\TechnicianLevel::options() as $key => $label)
                                        <option value="{{ $key }}" {{ old('technician_level') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('technician_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Standard Charge -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="standard_charge" class="form-label">Standard Charge</label>
                                    <input type="number" step="0.01" id="standard_charge" name="standard_charge" class="form-control @error('standard_charge') is-invalid @enderror" value="{{ old('standard_charge') }}">
                                    @error('standard_charge')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Additional Charge -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="additional_charge" class="form-label">Additional Charge</label>
                                    <input type="number" step="0.01" id="additional_charge" name="additional_charge" class="form-control @error('additional_charge') is-invalid @enderror" value="{{ old('additional_charge') }}">
                                    @error('additional_charge')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('pre-css')
    <link href="{{ asset('cms/assets/vendor/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    @endsection
    @section('pre-js')
    <script src="{{ asset('cmsassets/vendor/select2/js/select2.min.js')}}"></script>
    <script>
document.getElementById('image').addEventListener('change', function (event) {
    const [file] = event.target.files;
    const previewContainer = document.getElementById('image-preview-container');
    const previewImage = document.getElementById('image-preview');

    if (file) {
        previewContainer.style.display = 'block';
        previewImage.src = URL.createObjectURL(file);
    } else {
        previewContainer.style.display = 'none';
        previewImage.src = '';
    }
});


    </script>

    <script>
        // $(document).ready(function() {
        //     $('#acl').select2({
        //         placeholder: "Choose ACL roles",
        //         allowClear: true
        //     });
        // });

        $(document).ready(function () {
            // Initialize Select2
            $('#acl').select2();
        });

    </script>

    @endsection
</x-app-layout>

