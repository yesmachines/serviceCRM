<x-app-layout>
    @section('title', 'Technicians')

    @section('header')
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('technicians.index') }}">Employees</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>
    <h4 class="page-title">Create Employee</h4>
    <!-- Technicians -->
    @endsection

    @section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{ html()->form('POST')->route('technicians.store')->acceptsFiles()->open() }}
                    @include('auth.technicians.form')
                    {{ html()->submit('submit')->class('btn btn-primary') }}
                    {{ html()->form()->close() }}
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
$(document).ready(function () {
    // Initialize Select2
    $('.select2').select2();
});
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
    @endsection
</x-app-layout>

