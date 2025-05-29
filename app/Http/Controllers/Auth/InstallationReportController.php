<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\InstallationReport;
use App\Models\JobSchedule;
use App\Models\JobStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;



class InstallationReportController extends Controller
{
    public function index(Request $request)
    {
        $jobSchedules = JobSchedule::orderBy('job_no')->pluck('job_no', 'id');
        $companies = Company::pluck('company', 'id');
       
        return view('auth.installation_reports.index',compact('jobSchedules','companies'));
       
    }

    public function getData(Request $request)
    {
        try {
            \Log::info('InstallationReportController@getData called');
            $query = InstallationReport::with([
                'jobSchedule.jobStatus',
                'jobSchedule.createdBy',
                'jobSchedule.jobOwner',
                'jobSchedule.company',
                'jobSchedule.product',
                'jobSchedule.order',
                'clientFeedbacks',
                'technicianFeedbacks',
                'attendees.user',
                'attendees.technician',
                'company',
                
            ])->latest();

            
            
            if ($request->filled('job_id')) {
                $query->where('job_schedule_id', $request->job_id);
            }
            
            if ($request->filled('company_id')) {
                $query->whereHas('company', function ($q) use ($request) {
                    $q->where('id', $request->company_id);
                });
            }
            
            if ($request->filled('start_date')) {
                $query->whereHas('jobSchedule', function ($q) use ($request) {
                    $q->whereDate('start_datetime', '>=', $request->start_date);
                });
            }
            
            if ($request->filled('end_date')) {
                $query->whereHas('jobSchedule', function ($q) use ($request) {
                    $q->whereDate('end_datetime', '<=', $request->end_date);
                });
            }
            
            $reports = $query->get()->unique('id')->values();
           

            return DataTables::of($reports)
            ->addIndexColumn()
            ->addColumn('job_id', fn($row) => optional($row->jobSchedule)->job_no ?? '-')
            ->addColumn('job_status', fn($row) => optional(optional($row->jobSchedule)->jobStatus)->status ?? '-')
            ->addColumn('company', fn($row) => optional($row->company)->company ?? '-')
            ->addColumn('company', fn($row) => optional(optional($row->jobSchedule)->company)->company ?? '-')
            ->addColumn('job_status', fn($row) => optional(optional($row->jobSchedule)->jobStatus)->status ?? '-')
            ->addColumn('job_start_time', function ($row) {
                $start = optional($row->jobSchedule)->start_datetime;
                return $start ? Carbon::parse($start)->format('d M Y h:i A') : '-';
            })
            ->addColumn('job_end_time', function ($row) {
                $end = optional($row->jobSchedule)->end_datetime;
                return $end ? Carbon::parse($end)->format('d M Y h:i A') : '-';
            })
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

