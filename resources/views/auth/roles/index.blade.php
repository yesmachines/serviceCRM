<x-app-layout>
    @section('title', 'Roles')
    @section('header')
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboards</a></li>
            <li class="breadcrumb-item active">Roles</li>
        </ol>
    </div>
    <h4 class="page-title">Roles</h4>
    @stop
    @section('content')

    <div class="row">
        <div class="col-12">
            <!-- Card-->
            <div class="card">
                <div class="card-body">

                    <div class="clearfix">
                        <div class="float-end">
                            <a class="btn btn-primary rounded-pill" href="{{ route('roles.create') }}">Add New</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-nowrap table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ ucfirst($role->name) }}</td>
                                        <td style="width: 10%;">
                                            @if(auth()->user()->can('role_update'))
                                            <a href="{{ url('roles/'.$role->id.'/edit') }}" class="text-reset fs-16 px-1"> <i class=" ri-edit-2-fill"></i></a>
                                            @endif
                                            @if(auth()->user()->can('role_delete'))
                                            <a href="{{ route('roles.destroy', $role->id) }}" class="text-danger fs-16 px-1 destroy"> <i class="ri-delete-bin-2-line"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>        
                    </div>

                </div>                           
            </div> <!-- end card-->
            
        </div> <!-- end col-->
    </div>
    @stop
</x-app-layout>