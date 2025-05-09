



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
                                    <h4 class="header-title">Update Vehicle</h4>
                                    <p class="text-muted mb-0">
                                      
                                    </p>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">

                                            <form method="POST" action="{{ route('vehicles.update', $vehicle->id) }}">
                                                      @csrf
                                                      @method('PUT')

                                                      <div class="mb-3">
                                                          <label for="name" class="form-label">Vehicle Name <span class="text-danger">*</span></label>
                                                          <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $vehicle->name) }}">
                                                          @error('name')
                                                              <div class="invalid-feedback">{{ $message }}</div>
                                                          @enderror
                                                      </div>

                                                      

                                                      <div class="mb-3">
                                                          <label for="type" class="form-label">Vehicle Type</label>
                                                          <input type="text" id="type" name="type" class="form-control @error('type') is-invalid @enderror" value="{{ old('type', $vehicle->type) }}">
                                                          @error('type')
                                                              <div class="invalid-feedback">{{ $message }}</div>
                                                          @enderror
                                                      </div>

                                                      <div class="mb-3">
                                                          <label for="vehicle_number" class="form-label">Vehicle Number</label>
                                                          <input type="text" id="vehicle_number" name="vehicle_number" class="form-control @error('vehicle_number') is-invalid @enderror" value="{{ old('vehicle_number', $vehicle->vehicle_number) }}">
                                                          @error('vehicle_number')
                                                              <div class="invalid-feedback">{{ $message }}</div>
                                                          @enderror
                                                      </div>

                                                      <button type="submit" class="btn btn-primary">Update</button>
                                                    <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">Cancel</a>
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



                   

