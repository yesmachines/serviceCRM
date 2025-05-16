<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ServiceReport;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ServiceReportController extends Controller
{
   public function index(Request $request){
    return view('auth.service_reports.index');
   }

   public function getData(Request $request)
{
    try {
        \Log::info('getData called');

        $reports = ServiceReport::with(['task.jobSchedule', 'technician', 'concludedBy'])->latest()->get();

        return DataTables::of($reports)
            ->addIndexColumn()
            ->addColumn('job_id', function ($row) {
                return optional($row->task->jobSchedule)->job_no ?? '-';
            })
            ->addColumn('task_details', function ($row) {
                return optional($row->task)->task_details ?? '-';
            })
            ->addColumn('technician_name', function ($row) {
                return optional($row->technician)->name ?? '-';
            })
            ->addColumn('client_remark', function ($row) {
                return $row->client_remark ?? '-';
            })

            ->addColumn('actions', function ($row) {
                return view('auth.service_reports.actions', ['report' => $row])->render();
            })
         
            ->rawColumns(['actions']) 
            ->make(true);

    } catch (\Exception $e) {
        \Log::error('getData() error: ' . $e->getMessage());
        return response()->json([
            'error' => true,
            'message' => 'Internal Server Error',
            'details' => $e->getMessage()
        ], 500);
    }
}


public function show($id)
{
    $report = ServiceReport::with(['task.jobSchedule', 'technician', 'concludedBy'])->findOrFail($id);

 
    // If it's an AJAX request, return only partial view
    if (request()->ajax()) {
        return view('auth.service_reports.actions', compact('report'))->render();
    }
    // Otherwise fallback
    abort(404);
}

}


