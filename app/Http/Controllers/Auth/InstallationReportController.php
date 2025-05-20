<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\InstallationReport;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;



class InstallationReportController extends Controller
{
    public function index(Request $request)
    {
        return view('auth.installation_reports.index');
    }

    public function getData(Request $request)
    {
        try {
            \Log::info('InstallationReportController@getData called');

            $reports = InstallationReport::with(['task.jobSchedule', 'technician.user', 'concludedBy'])->latest()->get();

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
                    return view('auth.installation_reports.actions', ['report' => $row])->render();
                })
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
