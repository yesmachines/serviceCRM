<x-app-layout>
    @section('title', 'Vehicles')

    @section('header')
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Vehicles</li>
        </ol>
    </div>
    <h4 class="page-title">Vehicles</h4>
    @endsection

    @section('content')
 <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Create Vehicle</h4>
                                    <p class="text-muted mb-0">
                                      
                                    </p>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">

                                         <form method="POST" action="{{ route('vehicles.store') }}">
                                            @csrf

                                            <div class="mb-3">
                                                <label for="name" class="form-label">Vehicle Name <span class="text-danger">*</span></label>
                                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter vehicle name" value="{{ old('name') }}">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="type" class="form-label">Vehicle Type</label>
                                                <input type="text" id="type" name="type" class="form-control @error('type') is-invalid @enderror" placeholder="Enter vehicle type" value="{{ old('type') }}">
                                                @error('type')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="vehicle_number" class="form-label">Vehicle Number</label>
                                                <input type="text" id="vehicle_number" name="vehicle_number" class="form-control @error('vehicle_number') is-invalid @enderror" placeholder="Enter vehicle number" value="{{ old('vehicle_number') }}">
                                                @error('vehicle_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
                                           
                                        </div> <!-- end col -->

                                    </div>
                                    <!-- end row-->
                                </div> <!-- end card-body -->
                            </div> <!-- end card -->
                        </div><!-- end col -->
                    </div><!-- end row -->

    @endsection
</x-app-layout>



                   
