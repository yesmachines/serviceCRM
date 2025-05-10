<x-app-layout>
    @section('title', 'Technicians')

    @section('header')
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Service Types</li>
        </ol>
    </div>
    <h4 class="page-title"> Service Types</h4>
    <!-- Technicians -->
    @endsection

    @section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Update Service Types</h4>
                </div>
                <div class="card-body">
                  <form method="POST" action="{{ route('service-types.update', $serviceType->id) }}">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-6">
                <!-- Title -->
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text"
                           id="title"
                           name="title"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $serviceType->title) }}">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6">
                <!-- Parent Service -->
                <div class="mb-3">
                    <label for="parent_id" class="form-label">Parent Service</label>
                    <select id="parent_id"
                            name="parent_id"
                            class="form-control select2 @error('parent_id') is-invalid @enderror">
                        <option value="">Select Parent</option>
                        @foreach($services as $parent)
                            <option value="{{ $parent->id }}"
                                {{ old('parent_id', $serviceType->parent_id) == $parent->id ? 'selected' : '' }}>
                                {{ $parent->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Daily Report Checkbox -->
            <div class="col-lg-6">
                <div class="form-check mb-3">
                    <input type="checkbox"
                           class="form-check-input"
                           id="daily_report"
                           name="daily_report"
                           value="1"
                           {{ old('daily_report', $serviceType->daily_report) ? 'checked' : '' }}>
                    <label class="form-check-label" for="daily_report">Daily Report</label>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('service-types.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
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
    @endsection

</x-app-layout>





              
              
             