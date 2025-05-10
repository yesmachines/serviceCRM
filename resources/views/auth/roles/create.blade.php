<x-app-layout>
    @section('title', 'Roles')
    @section('header')
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('roles.index')}}">Roles</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>
    <h4 class="page-title">Roles</h4>
    @stop
    @section('content')
    <!-- Form row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{ html()->form('POST')->route('roles.store')->open() }}
                    <div class="row g-2">
                        <div class="mb-3 col-md-6">
                            {{ html()->label('Name', 'name')->class('form-label') }}
                            {{ html()->text('name')->class('form-control'.($errors->has('name') ? ' is-invalid' : '')) }}
                            {!! $errors->first('name','<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>

                    {{ html()->submit('submit')->class('btn btn-primary') }}
                    {{ html()->form()->close() }}

                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->
    @stop
</x-app-layout>