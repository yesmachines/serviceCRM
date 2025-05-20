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
    
            $reports = InstallationReport::with(['jobSchedule', 'clientFeedbacks', 'technicianFeedbacks'])
                ->latest()
                ->get()
                ->unique('id')
                ->values();
    
            return DataTables::of($reports)
                ->addIndexColumn()
                ->addColumn('job_id', function ($row) {
                    return optional($row->jobSchedule)->job_no ?? '-';
                })
                ->addColumn('client_feedback', function ($row) {
                    return $row->clientFeedbacks->pluck('feedback')->implode('<br>') ?: '-';
                })
                ->addColumn('technician_feedback', function ($row) {
                    return $row->technicianFeedbacks->pluck('feedback')->implode('<br>') ?: '-';
                })
                ->addColumn('actions', function ($row) {
                    return view('auth.installation_reports.actions', ['report' => $row])->render();
                })

                // ->addColumn('actions', function ($row) {
                //     return view('auth.installation_reports.actions', ['report' => $row])->render();
                // })

                
                ->addColumn('actions', function ($row) {
                    return view('auth.installation_reports.actions', ['report' => $row])->render();
                })
                ->rawColumns(['client_feedback', 'technician_feedback', 'actions'])
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
