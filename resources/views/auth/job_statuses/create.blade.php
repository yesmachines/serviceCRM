<x-app-layout>
    @section('title', 'Job Statuses')

    @section('header')
        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Job Statuses</li>
            </ol>
        </div>
        <h4 class="page-title">Job Statuses</h4>
    @endsection

    @section('content')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title">Create Job Status</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('job-statuses.store') }}">
                            @csrf

                            <div class="row">
                                <!-- Status -->
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <input type="text" id="status " name="status" class="form-control @error('status') is-invalid @enderror" value="{{ old('status') }}">
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Priority -->
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="priority" class="form-label">Priority</label>
                                        <input type="text" id="priority" name="priority" class="form-control @error('priority') is-invalid @enderror" value="{{ old('priority') }}">
                                        @error('priority')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Active Checkbox -->
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="active" id="active" value="1" {{ old('active') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="active">
                                                Active
                                            </label>
                                        </div>
                                        @error('active')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div> <!-- end row -->

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div> <!-- end row -->
    @endsection
</x-app-layout>
