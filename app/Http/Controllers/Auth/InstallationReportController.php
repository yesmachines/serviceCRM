<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\InstallationReport;
use App\Models\JobSchedule;
use App\Models\JobStatus;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;



class InstallationReportController extends Controller
{
    public function index(Request $request)
    {
        $jobSchedules = JobSchedule::orderBy('job_no')->get();
        $jobStatus = JobStatus::get();
        $serialNos = InstallationReport::whereNotNull('serial_no')
        ->orderBy('serial_no')
        ->get();
       
        return view('auth.installation_reports.index',compact('jobSchedules','jobStatus','serialNos'));
       
    }

    public function getData(Request $request)
    {
        try {
            \Log::info('InstallationReportController@getData called');
    
            $query = InstallationReport::with([
                'jobSchedule.jobStatus',
                'clientFeedbacks',
                'technicianFeedbacks',
                'order',
                'brand',
                'product',
                'attendees.user',
                'company'
            ])->latest();

         
            if ($request->filled('job_id')) {
                $query->where('job_schedule_id', $request->job_id);
            }

            if ($request->filled('serial_id')) {
                $query->where('serial_no', $request->serial_id);
            }
    
            if ($request->filled('job_status')) {
                $query->whereHas('jobSchedule.jobStatus', function ($q) use ($request) {
                    $q->where('id', $request->job_status);
                });
            }
    
            $reports = $query->get()->unique('id')->values();
    
            return DataTables::of($reports)
            ->addIndexColumn()
            ->addColumn('job_id', fn($row) => optional($row->jobSchedule)->job_no ?? '-')
            ->addColumn('job_status', fn($row) => optional(optional($row->jobSchedule)->jobStatus)->status ?? '-')
            ->addColumn('company', fn($row) => optional($row->company)->company ?? '-')
            ->addColumn('serial_no', fn($row) => $row->serial_no ?? '-') 
            ->addColumn('order_no', fn($row) => optional($row->order)->os_number ?? '-')
            // ->addColumn('client_feedback', fn($row) => $row->clientFeedbacks->pluck('feedback')->implode('<br>') ?: '-')
            // ->addColumn('technician_feedback', fn($row) => $row->technicianFeedbacks->pluck('feedback')->implode('<br>') ?: '-')
            ->addColumn('actions', fn($row) => view('auth.installation_reports.actions', ['report' => $row])->render())
            ->rawColumns(['actions'])
            ->make(true);
        
        } catch (\Exception $e) {
            \Log::error('InstallationReportController@getData error: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => 'Internal Server Error',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    
    
}
