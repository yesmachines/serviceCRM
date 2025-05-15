<?php

namespace App\Http\Controllers\Auth;

use App\Enums\TechnicianLevel;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Technician;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
//use Illuminate\Validation\Rules\Enum;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Role;

class TechnicianController extends Controller {

    public function index(Request $request) {
        return view('auth.technicians.index');
    }

    public function getData(Request $request) {
        // Define the target roles
        $targetRoles = ['servicemanager', 'servicecoordinator', 'servicetechnician'];

        // Query users with these roles
        $query = User::with(['roles', 'employee', 'technician.vehicle'])
                ->whereHas('roles', function ($q) use ($targetRoles) {
                    $q->whereIn('name', $targetRoles);
                })
                ->select('users.*');

        return DataTables::of($query)
                        ->addIndexColumn()
                        ->addColumn('user_name', function ($row) {
                            return $row->name ?? '-';
                        })
                        ->addColumn('role', function ($row) {
                            return $row->roles->count() ? $row->roles->pluck('name')->join(', ') : '-';
                        })
                        ->addColumn('email', function ($row) {
                            return $row->email ?? '-';
                        })
                        ->addColumn('phone', function ($row) {
                            return $row->employee ? $row->employee->phone : '-';
                        })
                        ->addColumn('designation', function ($row) {
                            return $row->employee ? $row->employee->designation : '-';
                        })
                        ->addColumn('actions', function ($row) {
                            return view('auth.technicians.actions', [
                                'user_id' => $row->id
                            ])->render();
                        })
                        ->rawColumns(['actions'])
                        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $roles = DB::table('roles')
                ->where('guard_name', 'web')
                ->whereIn('name', ['servicemanager', 'servicecoordinator', 'servicetechnician', 'dcm'])
                ->pluck('name', 'id');

        $vehicles = Vehicle::pluck('name', 'id')->prepend('---', '');
        $techLevels = ['' => 'Choose'] + TechnicianLevel::keyValueArray();
        return view('auth.technicians.create', compact('vehicles', 'roles', 'techLevels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        // dd($request->all());
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'employee_id' => 'required|string|max:50|unique:employees,emp_num',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|max:20|unique:employees,phone',
            'division' => 'required|string',
            'designation' => 'nullable|string|max:255',
            'acl' => 'nullable|array',
            //'acl.*' => 'exists:roles,id', 
            'status' => 'required|string',
            // 'vehicle_assigned'   => 'nullable|string|max:255',
            'technician_level' => 'required|string',
            'standard_charge' => 'nullable|numeric|min:0',
            'additional_charge' => 'nullable|numeric|min:0',
        ]);


        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('employees', 'public');
        }

        // Insert into users table and get user_id
        $userId = DB::table('users')->insertGetId([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // dd( $userId);
        // Insert into employees table
        DB::table('employees')->insert([
            'user_id' => $userId,
            'emp_num' => $validated['employee_id'] ?? 0, // make sure employee_id is in the form
            'phone' => $validated['phone'],
            'designation' => $validated['designation'],
            'division' => $validated['division'],
            'image_url' => $imagePath,
            'status' => $validated['status'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $aclRoles = $request->input('acl', []); // array of role IDs
        // Sync roles first

        if(!empty( $aclRoles)){
            if (in_array(8, $request['acl'])) {
                // Insert into technicians table using Eloquent
                Technician::create([
                    'user_id' => $userId,
                    'vehicle_assigned' => $request->input('vehicle_assigned') ?? null,
                    'technician_level' => $validated['technician_level'],
                    'standard_charge' => $validated['standard_charge'],
                    'additional_charge' => $validated['additional_charge'],
                ]);
            }
            $user = User::find($userId);

            $roleIds = Role::whereIn('id', $validated['acl'])->pluck('id')->toArray();
    
            $user->roles()->sync($roleIds);
        }



        return redirect()->route('technicians.index')->with('success', 'Technician created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) {
        $data = User::with(['roles', 'employee', 'technician.vehicle'])
                ->findOrFail($id);
         $roles = DB::table('roles')
                ->where('guard_name', 'web')
                ->whereIn('name', ['servicemanager', 'servicecoordinator', 'servicetechnician', 'dcm'])
                ->pluck('name', 'id');

        $vehicles = Vehicle::pluck('name', 'id')->prepend('---', '');
        $techLevels = ['' => 'Choose'] + TechnicianLevel::keyValueArray();
        $data->acl = $data->roles->pluck('id')->toArray();
        return view('auth.technicians.edit', compact('data', 'vehicles', 'roles', 'techLevels'));
    }

    public function update(Request $request, $id) {

        try {
            // $user = User::find($id);
            $user = User::with('technician','employee')->findOrFail($id);
            $emp = Employee::where('user_id', $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return redirect()->route('technicians.index')->with('error', 'User or employee record not found.');
        }
      
       

        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'employee_id' => 'required|string|max:50|unique:employees,emp_num,' . $emp->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'required|string|max:20|unique:employees,phone,' . $emp->id,
            'division' => 'required|string',
            'designation' => 'required|string',
            'acl' => 'nullable|array',
            'status' => 'required|string',
            'technician_level' => 'required|string',
            'standard_charge' => 'nullable|numeric|min:0',
            'additional_charge' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Update User table
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // Update Employee table
        $employee = $user->employee;
        $employee->phone = $request->input('phone');
        $employee->division = $request->input('division');
        $employee->designation = $request->input('designation');
        $employee->status = $request->input('status');
        $employee->emp_num = $request->input('employee_id');

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            if ($employee->image_url && Storage::exists('public/' . $employee->image_url)) {
                Storage::delete('public/' . $employee->image_url);
            }
            $imagePath = $request->file('image')->store('employees', 'public');
            $employee->image_url = $imagePath;
        }


        $aclRoles = $request->input('acl', []); // array of role IDs
        // Sync roles first

        if(!empty( $aclRoles )){
            if (in_array(8,  $aclRoles)) {
                $user->roles()->sync($aclRoles);
           }
        }
      

        
        

        // Check if technician role is among assigned roles
        $technicianRoleId = Role::where('name', 'servicetechnician')->value('id');
        $hasTechnicianRole = in_array($technicianRoleId, $aclRoles);

        if ($hasTechnicianRole) {
            if ($user->technician) {
                $technician = $user->technician;
            } else {
                // Create technician record if missing
                $technician = new Technician();
                $technician->user_id = $user->id;
            }

            $technician->technician_level = $request->input('technician_level');
            $technician->standard_charge = $request->input('standard_charge');
            $technician->additional_charge = $request->input('additional_charge');
            $technician->vehicle_assigned = $request->input('vehicle_assigned');
            $technician->save();
        } else {
            // Optional: if technician role is removed, delete technician record
            if ($user->technician) {
                $user->technician->delete();
            }
        }
        $user->save();
        $employee->save();

        return redirect()->route('technicians.index')->with('success', 'Technician updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Technician $technician) {
        $technician->delete();
        return response()->json(['status' => true, 'message' => 'Technician deleted successfully.']);
    }
}
