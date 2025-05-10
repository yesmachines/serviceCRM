<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
//Importing laravel-permission models
use Spatie\Permission\Models\Role;
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
        $roles = Role::all();

        return view('auth.roles.index')->with('roles', $roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('auth.roles.create');
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
        ]);

        $validator->validate();

        $name = $request['name'];
        $role = new Role();
        $role->name = strtolower($name);
        $role->guard_name = 'web';
        $role->save();

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
        return view('auth.roles.edit', compact('role'));
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
        ]);

        $validator->validate();

        $role->name = strtolower($request->name);
        $role->save();

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
