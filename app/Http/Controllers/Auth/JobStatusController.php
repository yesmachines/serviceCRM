<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\JobStatus;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JobStatusController extends Controller
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


     return view('auth.job_statuses.index');
   }

  public function getData(Request $request)
    {
        $query = JobStatus::select('id', 'status', 'priority', 'active');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('priority', function ($row) {
                return $row->priority ?: '-';
            })
            ->editColumn('active', function ($row) {
                return $row->active ? 'Yes' : 'No';
            })
            ->addColumn('actions', function ($row) {
                return view('auth.job_statuses.actions', ['status' => $row])->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }


    public function create(){

        return view('auth.job_statuses.create');
    }

       public function store(Request $request)
        {
            $request->validate([
                'status' => 'required|string|max:255',
                'priority' => 'required|string|max:255',
                'active' => 'nullable|boolean',
            ]);

            JobStatus::create([
                'status' => $request->input('status'),
                'priority' => $request->input('priority'),
                'active' => $request->has('active'),
            ]);

            alert()->success('success', 'Job status created successfully.');
            return redirect()->route('job-statuses.index');

         
    }

    public function edit(JobStatus $jobStatus)
    {
       
        return view('auth.job_statuses.edit', compact('jobStatus'));
    }

     public function update(Request $request, JobStatus $jobStatus)
    {
        $request->validate([
            'status' => 'required|string|max:255',
            'priority' => 'required|string|max:255',
            'active' => 'nullable|boolean',
        ]);

        $jobStatus->update([
            'status' => $request->input('status'),
            'priority' => $request->input('priority'),
            'active' => $request->has('active'),
        ]);
        
        alert()->success('success', 'Job status updated successfully.');
        return redirect()->route('job-statuses.index');
    }

    /**
     * Remove the specified job status from storage.
     */
    public function destroy(JobStatus $jobStatus)
    {
        $jobStatus->delete();

        return response()->json(['status' => true, 'message' => 'Job status deleted successfully.']);
    }


}
