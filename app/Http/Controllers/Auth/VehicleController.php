<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VehicleController extends Controller
{
   public function index(Request $request){


     return view('auth.vehicles.index');
   }

   public function getData(Request $request)
    {
       
        $query = Vehicle::select('id', 'name', 'type','vehicle_number')->get();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return view('auth.vehicles.actions', ['vehicle' => $row])->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function create(Request $request){

      return view('auth.vehicles.create');
    }

   public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'vehicle_number' => 'nullable|string|max:255',
        ]);

        Vehicle::create($validated);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle added successfully.');
    }

     public function edit(Vehicle $vehicle)
    {

        return view('auth.vehicles.edit', compact('vehicle'));
    }

    

            public function update(Request $request, Vehicle $vehicle)
            {
                $validated = $request->validate([
                    'name' => 'required|string|max:255',
                    'type' => 'nullable|string|max:255',
                    'vehicle_number' => 'nullable|string|max:255',
                ]);

                $vehicle->update($validated);

                return redirect()->route('vehicles.index')->with('success', 'Vehicle updated successfully.');
            }

            // public function destroy(Vehicle $vehicle)
            // {
            //     $vehicle->delete();

            //     return redirect()->route('vehicles.index')->with('success', 'Vehicle deleted successfully.');
            // }

            public function destroy(Vehicle $vehicle)
            {
                $vehicle->delete();

                if (request()->ajax()) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Vehicle deleted successfully!',
                    ]);
                }

                return redirect()->route('vehicles.index')->with('success', 'Vehicle deleted successfully!');
            }

}

  