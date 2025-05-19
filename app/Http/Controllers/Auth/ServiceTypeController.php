<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


class ServiceTypeController extends Controller
{

    public function __construct() {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->hasRole('superadmin')) {
                alert()->error('No Access!', 'You don\'t have permission to access this page.');
                return redirect()->route('dashboard');
            }

            return $next($request);
        });
    }
    public function index(Request $request){


       return view('auth.service_types.index');
    }

   public function getData(Request $request)
    {
    $query = ServiceType::with('parent');

    return DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('parent_title', function ($row) {
            return $row->parent ? $row->parent->title : '-';
        })
        ->addColumn('daily_report_label', function ($row) {
            return $row->daily_report ? 'Yes' : 'No';
        })
        ->addColumn('actions', function ($row) {
            return view('auth.service_types.actions', ['serviceType' => $row])->render();
        })
        ->rawColumns(['actions'])
        ->make(true);
    }

    public function create(){

    $services = ServiceType::where('parent_id',null)->get();
      
    return view('auth.service_types.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:service_types,id',
            'daily_report' => 'nullable|boolean',
        ]);

        ServiceType::create([
            'title' => $request->input('title'),
            'parent_id' => $request->input('parent_id'),
            'slug' => Str::slug($request->input('title')),
            'daily_report' => $request->has('daily_report'),
        ]);

        alert()->success('success', 'Job type created successfully.');
        return redirect()->route('service-types.index');
    }

    public function edit($id)
    {
            $serviceType = ServiceType::findOrFail($id);
            $services = ServiceType::where('id', '!=', $id)
            ->where('parent_id',null)
            ->get(); 

        return view('auth.service_types.edit', compact('serviceType', 'services'));
    }

    public function update(Request $request, $id)
    {
        $serviceType = ServiceType::findOrFail($id);

        // Validate inputs
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:service_types,id',
            'daily_report' => 'nullable|boolean',
        ]);

        // Update fields
        $serviceType->title = $validated['title'];
        $serviceType->parent_id = $validated['parent_id'] ?? null;
        $serviceType->daily_report = $request->has('daily_report') ? 1 : 0; // checkbox

        // You can also generate slug here if needed
        $serviceType->slug = Str::slug($validated['title']);

        $serviceType->save();

        alert()->success('success', 'Job type updated successfully.');
        return redirect()->route('service-types.index');
    }

    public function destroy($id)
    {
           try {
        $serviceType = ServiceType::findOrFail($id);

        // Check if this service type has any child service types
        $hasChildren = ServiceType::where('parent_id', $serviceType->id)->exists();

    
        if ($hasChildren) {
            return response()->json([
                'status' => false,
                'message' => 'Cannot delete: this service type has child service types assigned..'
            ], 400); // 400 = Bad Request
        }

        // Safe to delete
        $serviceType->delete();

         return response()->json([
            'status' => true,
            'message' => 'Job Type deleted successfully.'
        ]);
    } catch (\Exception $e) {
        // Catch unexpected errors
        return response()->json([
            'status' => false,
            'message' => 'An error occurred: ' . $e->getMessage()
        ], 500); // 500 = Server Error
    }

       
    }




}
