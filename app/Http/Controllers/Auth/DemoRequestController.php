<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Customer;
use App\Models\DemoRequest;
use App\Models\JobSchedule;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class DemoRequestController extends Controller
{
   public function index(Request $request){

    $jobSchedules = JobSchedule::orderBy('job_no')->pluck('job_no', 'id');
    $companies = Company::pluck('company', 'id');
    $brands = Supplier::pluck('brand', 'id');
    $customers = Customer::pluck('fullname', 'id');
    return view('auth.drf_requests.index',compact('jobSchedules','companies','brands','customers'));
    
   }
   public function getData(Request $request)
   {
       try {
           \Log::info('DemoRequestController@getData called');
   
           $query = DemoRequest::with(['brand', 'company', 'customer'])->latest();
   
 
           if ($request->filled('company_id')) {
               $query->where('company_id', $request->company_id);
           }

            if ($request->filled('company_id')) {
                $query->where('company_id', $request->company_id);
            }

            if ($request->filled('brand')) {
                $query->where('brand_id', $request->brand);
            }

            if ($request->filled('customer')) {
                $query->where('customer_id', $request->customer);
            }

            if ($request->filled('demo_date')) {
                $query->whereDate('demo_date', $request->demo_date);
            }
   
           $reports = $query->get();
   
           return DataTables::of($reports)
               ->addIndexColumn()
               ->addColumn('brand', fn($row) => optional($row->brand)->brand ?? '-')
               ->addColumn('company', fn($row) => optional($row->company)->company ?? '-')
               ->addColumn('customer', fn($row) => optional($row->customer)->fullname ?? '-')
               ->addColumn('demo_date', fn($row) => $row->demo_date ? \Carbon\Carbon::parse($row->demo_date)->format('d M Y') : '-')
               ->addColumn('status', fn($row) => ucfirst($row->status ?? '-'))
               ->addColumn('actions', fn($row) => view('auth.drf_requests.actions', ['report' => $row])->render())
               ->rawColumns(['actions'])
               ->make(true);
   
       } catch (\Exception $e) {
           \Log::error('DemoRequestController@getData error: ' . $e->getMessage());
           return response()->json([
               'error' => true,
               'message' => 'Internal Server Error',
               'details' => $e->getMessage()
           ], 500);
       }
   }


   public function view($id){

    $validator = Validator::make(['id' => $id], [
        'id' => 'required|integer|exists:demo_requests,id',
    ]);

    if ($validator->fails()) {
        Alert::error('Invalid Request', 'The provided DRF ID is invalid or not found.');
        return redirect()->route('drf-requests.index')->withErrors($validator);
    }

    $drfDatas = DemoRequest::with(['details','brand', 'company', 'customer'])->findOrFail($id);

    // dd($drfDatas );

    return view('auth.drf_requests.view',compact('drfDatas'));

   }
   
}
