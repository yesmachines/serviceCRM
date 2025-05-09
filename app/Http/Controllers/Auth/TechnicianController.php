<?php

namespace App\Http\Controllers\Auth;

use App\Enum\TechnicianLevel;
use App\Http\Controllers\Controller;
use App\Models\Technician;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Enum;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Role;

class TechnicianController extends Controller
{
    
    public function index(Request $request)
    {
        return view('auth.technicians.index');
    }

    public function getData(Request $request)
    {
        $query = Technician::with(['user', 'vehicle'])->select('technicians.*');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '-';
            })
            ->addColumn('vehicle_name', function ($row) {
                return $row->vehicle ? $row->vehicle->name : '-';
            })
            ->addColumn('actions', function ($row) {
                return view('auth.technicians.actions', ['technician' => $row])->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $roles = DB::table('roles')
        ->where('guard_name', 'web')
        ->whereIn('name', ['servicemanager', 'servicecoordinator', 'servicetechnician'])
        ->select('id','name')
        ->get();

        $users = User::all();
        $vehicles = Vehicle::all();
        return view('auth.technicians.create', compact('users', 'vehicles','roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
           $validated = $request->validate([
                'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'full_name'          => 'required|string|max:255',
                'employee_id' => 'required|string|max:50|unique:employees,emp_num',
                'email'              => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
                'phone'              => 'nullable|string|max:20',
                'division'           => 'required|string',
                'designation'        => 'nullable|string|max:255',
                'acl' => 'required|array',
                'acl.*' => 'exists:roles,id', 
                'status'             => 'required|in:1,0',
                'vehicle_assigned'   => 'nullable|string|max:255',
                'technician_level'   => 'nullable|string|max:255',
                'standard_charge'    => 'nullable|numeric|min:0',
                'additional_charge'  => 'nullable|numeric|min:0',
            ]);
      

        $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('employees', 'public');
            }

        // Insert into users table and get user_id
        $userId = DB::table('users')->insertGetId([
            'name'       => $validated['full_name'],
            'email'      => $validated['email'],
            'password'   => Hash::make($validated['password']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // dd( $userId);
        // Insert into employees table
        DB::table('employees')->insert([
            'user_id'    => $userId,
            'emp_num'    => $validated['employee_id'] ?? 0, // make sure employee_id is in the form
            'phone'      => $validated['phone'],
            'designation'=> $validated['designation'],
            'division'   => $validated['division'],
            'image_url'  => $imagePath,
            'status'     => $validated['status'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert into technicians table using Eloquent
      $technician =   Technician::create([
            'user_id'           => $userId,
            'vehicle_assigned'  => $validated['vehicle_assigned'],
            'technician_level'  => $validated['technician_level'],
            'standard_charge'   => $validated['standard_charge'],
            'additional_charge' => $validated['additional_charge'],
        ]);

         $user = User::find($userId);

       
         $roleIds = Role::whereIn('id', $validated['acl'])->pluck('id')->toArray();

         $user->roles()->sync($roleIds); 

    
        return redirect()->route('technicians.index')->with('success', 'Technician created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $roles = Role::whereIn('name', ['servicemanager', 'servicecoordinator', 'servicetechnician'])->get();

        $technician = Technician::with(['user.roles', 'user.employee'])->find($id);
        if (!$technician || !$technician->user) {
             return redirect()->route('technicians.index')->with('error', 'Technician not found.');
            // abort(404, 'Technician or user not found');
        }
//    dd($technician);

        $assignedRoles = $technician->user->roles->pluck('name')->toArray();

        $users = User::all();
        $vehicles = Vehicle::all();
      

        return view('auth.technicians.edit', compact('technician', 'users', 'vehicles','assignedRoles','roles'));
    }


    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Technician $technician)
    {
     
             $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $technician->user_id,
             'employee_id' => 'required|string|max:50|unique:employees,emp_num,'.$technician->user->employee->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'division' => 'required|string|max:50',
            'designation' => 'required|string|max:100',
            'acl' => 'nullable|array',
            'status' => 'required|boolean',
            'vehicle_assigned' => 'nullable|exists:vehicles,id',
            'technician_level' => 'nullable|string|max:50',
            'standard_charge' => 'nullable|numeric|min:0',
            'additional_charge' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
      
// dd($request->all());
        // Find the technician
        // $technician = Technician::with('user')->findOrFail($id);
        $user = $technician->user;

        // Update user information
        $user->name = $request->input('full_name');
        $user->email = $request->input('email');

        // If password is provided, hash it and update
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
// dd($request->input('status'));
        $user->employee->phone = $request->input('phone');
        $user->employee->division = $request->input('division');
        $user->employee->designation = $request->input('designation');
        $user->employee->status = $request->input('status');
        $user->employee->emp_num = $request->input('employee_id');
        $user->employee->division = $request->input('division');


        // Handle image upload if exists
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($technician->image_url && Storage::exists('public/' . $technician->image_url)) {
                Storage::delete('public/' . $technician->image_url);
            }

            // Upload the new image
            $imagePath = $request->file('image')->store('employees', 'public');
             $user->employee->image_url = $imagePath;
        }

        // Update technician-level, charge details, and vehicle assigned
        $technician->technician_level = $request->input('technician_level');
        $technician->standard_charge = $request->input('standard_charge');
        $technician->additional_charge = $request->input('additional_charge');
        $technician->vehicle_assigned = $request->input('vehicle_assigned');
        
        // Update ACL roles (this assumes you are using Laravel's built-in permissions system, like Spatie)
        $technician->user->syncRoles($request->input('acl'));

        // Save the changes
        $technician->push();
        $user->push(); // Save user and employee information

    //     return redirect()->route('technicians.index')->with('success', 'Technician updated successfully');
    // }

        return redirect()->route('technicians.index')->with('success', 'Technician updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Technician $technician)
    {
        $technician->delete();
        return response()->json(['status' => true, 'message' => 'Technician deleted successfully.']);
    }
}


// <?php

// namespace App\Http\Controllers;

// use App\Models\Technician;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Storage;

// class TechniciansController extends Controller
// {
//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//             'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
//             'full_name'          => 'required|string|max:255',
//             'employee_id'        => 'required|string|max:50|unique:technicians,employee_id',
//             'email'              => 'required|email|unique:technicians,email',
//             'password'           => 'required|string|min:6|confirmed',
//             'phone'              => 'nullable|string|max:20',
//             'division'           => 'required|string',
//             'designation'        => 'nullable|string|max:255',
//             'acl'                => 'nullable|string|max:255',
//             'status'             => 'required|in:1,0',
//             'vehicle_assigned'   => 'nullable|string|max:255',
//             'technician_level'   => 'nullable|string|max:255',
//             'standard_charge'    => 'nullable|numeric|min:0',
//             'additional_charge'  => 'nullable|numeric|min:0',
//         ]);

//         // Handle image upload if provided
//         $imagePath = null;
//         if ($request->hasFile('image')) {
//             $imagePath = $request->file('image')->store('technicians', 'public');
//         }

//         // Create the technician
//         Technician::create([
//             'image'             => $imagePath,
//             'full_name'         => $validated['full_name'],
//             'employee_id'       => $validated['employee_id'],
//             'email'             => $validated['email'],
//             'password'          => Hash::make($validated['password']),
//             'phone'             => $validated['phone'],
//             'division'          => $validated['division'],
//             'designation'       => $validated['designation'],
//             'acl'               => $validated['acl'],
//             'status'            => $validated['status'],
//             'vehicle_assigned'  => $validated['vehicle_assigned'],
//             'technician_level'  => $validated['technician_level'],
//             'standard_charge'   => $validated['standard_charge'],
//             'additional_charge' => $validated['additional_charge'],
//         ]);

//         return redirect()->route('technicians.index')->with('success', 'Technician created successfully.');
//     }
// }

