<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\JobSchedule;
use App\Models\ServiceReport;
use App\Models\Task;
use App\Models\TaskStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ServiceReportController extends Controller
{
   public function index(Request $request){

    $jobSchedules = JobSchedule::orderBy('job_no')->pluck('job_no', 'id');
    $companies = Company::pluck('company', 'id');
    return view('auth.service_reports.index',compact('jobSchedules','companies'));
   }
   
   
 

   public function getData(Request $request)
   {
       try {
           \Log::info('getData called');
   
           $query = ServiceReport::with([
            'task.jobSchedule.jobstatus',
            'task.jobSchedule.company',
            'technician.user',
            'concludedBy',
            'clientFeedbacks'
        ])->latest();
        
        // Apply filters
        
        if ($request->filled('job_id')) {
            $query->whereHas('task.jobSchedule', function ($q) use ($request) {
                $q->where('id', $request->job_id); // Filtering by job schedule ID
            });
        }
        
        if ($request->filled('company_id')) {
            $query->whereHas('task.jobSchedule.company', function ($q) use ($request) {
                $q->where('id', $request->company_id);
            });
        }
        
        if ($request->filled('start_date')) {
            $query->whereHas('task.jobSchedule', function ($q) use ($request) {
                $q->whereDate('start_datetime', '>=', $request->start_date);
            });
        }
        
        if ($request->filled('end_date')) {
            $query->whereHas('task.jobSchedule', function ($q) use ($request) {
                $q->whereDate('end_datetime', '<=', $request->end_date);
            });
        }
        
        if ($request->filled('job_no')) {
            $query->whereHas('task.jobSchedule', function ($q) use ($request) {
                $q->where('job_no', 'like', '%' . $request->job_no . '%');
            });
        }
   
           $reports = $query->latest()->get();
   
           return DataTables::of($reports)
               ->addIndexColumn()
               ->addColumn('job_id', fn($row) => optional($row->task->jobSchedule)->job_no ?? '-')
               ->addColumn('company', fn($row) => optional($row->task->jobSchedule->company)->company ?? '-')
               ->addColumn('task_status', fn($row) => optional($row->task->taskStatus)->status ?? '-')
           
                ->addColumn('job_start_time', function ($row) {
                    $start = optional(optional($row->task)->jobSchedule)->start_datetime;
                    return $start ? \Carbon\Carbon::parse($start)->format('d M Y h:i A') : '-';
                })
                ->addColumn('job_end_time', function ($row) {
                    $end = optional(optional($row->task)->jobSchedule)->end_datetime;
                    return $end ? \Carbon\Carbon::parse($end)->format('d M Y h:i A') : '-';
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
   



}


