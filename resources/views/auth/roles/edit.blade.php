<x-app-layout>
    @section('title', 'Roles')
    @section('header')
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('roles.index')}}">Roles</a></li>
            <li class="breadcrumb-item active">Edit</li>
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
                    {{ html()->modelForm($role, 'PUT')->route('roles.update',$role->id)->open() }}
                    <div class="row g-2">
                        <div class="mb-3 col-md-6">
                            {{ html()->label('Name', 'name')->class('form-label') }}
                            {{ html()->text('name')->class('form-control'.($errors->has('name') ? ' is-invalid' : '')) }}
                            {!! $errors->first('name','<div class="invalid-feedback">:message</div>') !!}
                            {!! $errors->first('permissions','<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card card-border">
                            <div class="card-header"><h6 class="card-title">Assign Permissions</h6></div>
                            <div class="card-body p-1">
                                <table class="table table-bordered table-hover" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Allow user to</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissions as $k => $v)
                                        <tr>
                                            <td>{{ucfirst($k)}}</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        @if(is_array($v))
                                                        @php($v1 = array_chunk($v, 2, true))
                                                        @foreach ($v1 as $v2)
                                                        @foreach ($v2 as $k1 => $v3)
                                                        <div class="form-check form-check-inline">
                                                            {{  html()->checkbox('permissions[]')->value($k1)->id($k1)
                                   ->checked(in_array($k1, old('permissions', $role->permissions->pluck('id')->toArray())))->class('form-check-input')  }}
                                                            {{ html()->label(ucfirst($v3), $k1)->class('form-check-label') }}
                                                        </div>
                                                        @endforeach
                                                        @endforeach
                                                        @else
                                                        <div class="form-check form-check-inline">
                                                            {{  html()->checkbox('permissions[]')->value($v)->id($v)
                                   ->checked(in_array($v, old('permissions', $role->permissions->pluck('id')->toArray())))->class('form-check-input') }}
                                                            {{ html()->label('All',$v)->class('form-check-label')  }}
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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