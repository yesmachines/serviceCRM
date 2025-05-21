<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\DemoClientFeedback;
use App\Models\JobSchedule;
use App\Models\JobStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DemoClientFeedbackController extends Controller
{
    public function index(Request $request){
        $jobSchedules = JobSchedule::orderBy('job_no')->get();
        $jobStatus = JobStatus::get();
        return view('auth.demo_client_feedback.index',compact('jobSchedules','jobStatus'));
    }

   


    public function getData(Request $request)
    {
        $query = DemoClientFeedback::with('jobSchedule.jobStatus');
    
        if ($request->filled('job_id')) {
            $query->where('job_schedule_id', $request->job_id);
        }
    
        if ($request->filled('job_status')) {
            $query->whereHas('jobSchedule.jobStatus', function ($q) use ($request) {
                $q->where('id', $request->job_status);
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
    
        $reports = $query->latest()->get()->unique('id')->values();
    
        return DataTables::of($reports)
            ->addIndexColumn()
            ->addColumn('job_id', fn($row) => optional($row->jobSchedule)->job_no ?? '-')
            ->addColumn('job_status', fn($row) => optional(optional($row->jobSchedule)->jobStatus)->status ?? '-')
            ->addColumn('job_start_time', function ($row) {
                $start = optional($row->jobSchedule)->start_datetime;
                return $start ? Carbon::parse($start)->format('d M Y h:i A') : '-';
            })
            ->addColumn('job_end_time', function ($row) {
                $end = optional($row->jobSchedule)->end_datetime;
                return $end ? Carbon::parse($end)->format('d M Y h:i A') : '-';
            })
            ->addColumn('designation', fn($row) => $row->result ?? '-')
            ->addColumn('rating', fn($row) => $row->rating ?? '-')
            ->addColumn('actions', function ($row) {
                return view('auth.demo_client_feedback.actions', ['report' => $row])->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
