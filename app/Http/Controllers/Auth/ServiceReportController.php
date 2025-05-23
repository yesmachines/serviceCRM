<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\JobSchedule;
use App\Models\ServiceReport;
use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ServiceReportController extends Controller
{
   public function index(Request $request){

        $jobSchedules = JobSchedule::orderBy('job_no')->get();
        $taskStatus = TaskStatus::get();
        $companies = Company::get();
    return view('auth.service_reports.index',compact('jobSchedules','taskStatus','companies'));
   }
   
   
 

   public function getData(Request $request)
   {
       try {
           \Log::info('getData called');
   
           $query = ServiceReport::with(['task.jobSchedule.jobstatus', 'technician.user', 'concludedBy','clientFeedbacks']);
   
           // Apply filters
           if ($request->filled('job_id')) {
               $query->whereHas('task.jobSchedule', function ($q) use ($request) {
                   $q->where('id', $request->job_id);
               });
           }
   
           if ($request->filled('task_status')) {
               $query->whereHas('task.taskStatus', function ($q) use ($request) {
                   $q->where('id', $request->task_status);
               });
           }
   
           if ($request->filled('company_id')) {
               $query->whereHas('task.jobSchedule.company', function ($q) use ($request) {
                   $q->where('id', $request->company_id);
               });
           }
   
           $reports = $query->latest()->get();
   
           return DataTables::of($reports)
               ->addIndexColumn()
               ->addColumn('job_id', fn($row) => optional($row->task->jobSchedule)->job_no ?? '-')
               ->addColumn('company', fn($row) => optional($row->task->jobSchedule->company)->company ?? '-')
               ->addColumn('task_status', fn($row) => optional($row->task->taskStatus)->status ?? '-')
               ->addColumn('task_details', fn($row) => optional($row->task)->task_details ?? '-')
               ->addColumn('technician_name', fn($row) => optional($row->technician->user)->name ?? '-')
               ->addColumn('client_remark', fn($row) => $row->client_remark ?? '-')
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


