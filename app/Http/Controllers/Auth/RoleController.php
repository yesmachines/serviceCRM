<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RoleController extends Controller {

    public function __construct() {
        $this->middleware('check.admin.permission:web role_read')->only(['index', 'show']);
        $this->middleware('check.admin.permission:web role_create')->only(['create', 'store']);
        $this->middleware('check.admin.permission:web role_update')->only(['edit', 'update']);
        $this->middleware('check.admin.permission:web role_delete')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $roles = Role::whereNotIn('name', ['superadmin'])->where('guard_name', 'web')->get();

        return view('auth.roles.index')->with('roles', $roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $permissions = Permission::where('guard_name', '=', 'web')->orderBy('id', 'asc')->pluck('id', 'name')->toArray();
        $target = [];
        foreach ($permissions as $k => $v) {
            $keys = explode("_", $k);
            if (count($keys) > 1) {
                $target[$keys[0]][$v] = $keys[1];
            } else {
                $target[$k] = $v;
            }
        }
        return view('auth.roles.create', ['permissions' => $target]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
                    'name' => [
                        'required',
                        'max:20',
                        Rule::unique('roles')->where(fn($query) =>
                                        $query->where('name', $request->name)
                                        ->where('guard_name', 'admin')
                        ),
                    ],
                    'permissions' => 'required',
        ]);

        $validator->validate();

        $name = $request['name'];
        $role = new Role();
        $role->name = strtolower($name);
        $role->guard_name = 'web';

        $permissions = $request['permissions'];

        $role->save();
        //Looping thru selected permissions
        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail();
            //Fetch the newly created role and assign permission
            $role = Role::where('name', '=', $name)->first();
            $role->givePermissionTo($p);
        }

        alert()->success($role->name, 'added!');
        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return redirect('roles');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $role = Role::findOrFail($id);

        $permissions = Permission::orderBy('id', 'asc')->where('guard_name', '=', 'web')->pluck('id', 'name')->toArray();
        $target = [];
        foreach ($permissions as $k => $v) {
            $keys = explode("_", $k);
            if (count($keys) > 1) {
                $target[$keys[0]][$v] = $keys[1];
            } else {
                $target[$k] = $v;
            }
        }

        $permissions = $target;
        return view('auth.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        $role = Role::findOrFail($id); //Get role with the given id
        //Validate name and permission fields
        $validator = Validator::make($request->all(), [
                    'name' => [
                        'required',
                        'max:20',
                        Rule::unique('roles')->where(function ($query) use ($request, $id) {

                            return $query
                                    ->whereName($request->name)
                                    ->whereGuardName('web')
                                    ->whereNotIn('id', [$id]);
                        }),
                    ],
                    'permissions' => 'required',
        ]);

        $validator->validate();

        $role->name = strtolower($request->name);
        $role->save();

        $input = $request->except(['permissions']);
        $permissions = $request['permissions'];

        $p_all = Permission::all(); //Get all permissions

        foreach ($p_all as $p) {
            $role->revokePermissionTo($p); //Remove all permissions associated with role
        }

        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail(); //Get corresponding form //permission in db
            $role->givePermissionTo($p);  //Assign permission to role
        }

        alert()->success($role->name, 'updated!');
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $role = Role::whereNotIn('name', ['superadmin'])->where('id', $id)->first();
        //$role->delete();
        return response()->json(["status" => true, "message" => 'Successfully deleted']);
    }
}
