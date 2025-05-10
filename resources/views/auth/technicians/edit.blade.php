<x-app-layout>
    @section('title', 'Edit Technician')

    @section('header')
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('technicians.index') }}">Employees</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </div>
    <h4 class="page-title">Edit Employee</h4>
    @endsection

    @section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{ html()->modelForm($data, 'PUT')->route('technicians.update',$data->id)->acceptsFiles()->open() }}
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
    <script src="{{ asset('cms/assets/vendor/select2/js/select2.min.js')}}"></script>
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
        previewContainer.style.display = 'block';  // Show the preview container
        previewImage.src = URL.createObjectURL(file); // Set the preview image source to the uploaded file
    } else {
        previewContainer.style.display = 'none';  // Hide the preview container if no file selected
        previewImage.src = '';  // Reset the preview image source
    }
});
    </script>
    @endsection
</x-app-layout>

