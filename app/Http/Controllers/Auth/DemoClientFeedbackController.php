<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\DemoClientFeedback;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DemoClientFeedbackController extends Controller
{
    public function index(Request $request){

        return view('auth.demo_client_feedback.index');
    }


    public function getData(Request $request)
    {
        try {
            \Log::info('DemoClientReportController@getData called');
    
            $reports = DemoClientFeedback::with('jobSchedule')
            ->latest()
            ->get()
            ->unique('id')
            ->values();
        
        return DataTables::of($reports)
            ->addIndexColumn()
            ->addColumn('job_id', function ($row) {
                return optional($row->jobSchedule)->job_no ?? '-';
            })
            ->addColumn('demo_objective', function ($row) {
                return $row->demo_objective ?? '-';
            })
            ->addColumn('designation', function ($row) {
                return $row->designation ?? '-';
            })
            ->addColumn('rating', function ($row) {
                return $row->rating ?? '-';
            })
            ->addColumn('actions', function ($row) {
                return view('auth.demo_client_feedback.actions', ['report' => $row])->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    
        } catch (\Exception $e) {
            \Log::error('ClientFeedbackController@getData error: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => 'Internal Server Error',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
