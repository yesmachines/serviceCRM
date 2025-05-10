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
                    <h4 class="header-title">Create Service Types</h4>
                </div>
                <div class="card-body">
                  <form method="POST" action="{{ route('service-types.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Title -->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="title" class="form-label">Title</label>
                                                    <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                                                    @error('title')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Parent Service -->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="parent_id" class="form-label">Parent Service</label>
                                                    <select name="parent_id" id="parent_id" class="form-control select2 @error('parent_id') is-invalid @enderror" data-toggle="select2">
                                                        <option value="">Select Service</option>
                                                        @foreach($services as $parent)
                                                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                                                {{ $parent->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('parent_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Daily Report Checkbox -->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Daily Report</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="daily_report" id="daily_report" value="1" {{ old('daily_report') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="daily_report">
                                                            Enable Daily Report
                                                        </label>
                                                    </div>
                                                    @error('daily_report')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div> <!-- end row -->
                                    </div> <!-- end card-body -->
                                </div> <!-- end card -->
                            </div> <!-- end col -->
                        </div> <!-- end row -->

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
    @endsection

</x-app-layout>





              
              
             