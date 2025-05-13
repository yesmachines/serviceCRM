<?php

namespace App\Http\Controllers\Auth;

use App\Enums\MachineType;
use App\Enums\WarrantyStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobScheduleRequest;
use App\Http\Requests\UpdateJobScheduleRequest;
use App\Models\Company;
use App\Models\Customer;
use App\Models\JobSchedule;
use App\Models\JobStatus;
use App\Models\Order;
use App\Models\Product;
use App\Models\ServiceJob;
use App\Models\ServiceType;
use App\Models\Supplier;
use App\Models\Technician;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class JobScheduleController extends Controller
{
    public function index(Request $request){

        return view('auth.job_schedules.index');
    }

 public function getData(Request $request)
    {
    $query = JobSchedule::with(['customer', 'company', 'product', 'servicetype', 'jobstatus'])->get();

    return DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('job_no', function ($row) {
            return $row->job_no ?? '-';
        })
        ->addColumn('job_type', function ($row) {
            return $row->servicetype->title ?? '-';
        })
      ->addColumn('customer', function ($row) {
            return $row->customer->fullname ?? '-';
        })
        ->addColumn('product', function ($row) {
            return $row->product->title ?? '-';
        })
       ->addColumn('time', function ($row) {
            return ($row->start_datetime instanceof \Carbon\Carbon)
                ? $row->start_datetime->format('Y-m-d H:i')
                : ($row->start_datetime ?? '-');
        })
        ->addColumn('actions', function ($row) {
            return view('auth.job_schedules.actions', ['job' => $row])->render();
        })
        ->rawColumns(['actions'])
        ->make(true);
    }

   public function create(Request $request)
    {   
        return view('auth.job_schedules.create', [
            'companies'     => Company::pluck('company', 'id'),
            'customers'     => Customer::pluck('fullname', 'id'),
            'jobTypes'  => ServiceType::pluck('title', 'id'),
            'suppliers'     => Supplier::pluck('brand', 'id'), // for brand
            'productOptions' => Product::limit(10)->pluck('title', 'id')->toArray(),
            'orders'     => Order::pluck('os_number', 'id'), 
            'technicians' => Technician::with('user')->get()->pluck('user.name', 'id'),
            'jobStatuses'   => JobStatus::pluck('status', 'id'),
            'machineTypes' => MachineType::options(),
            'warrantyStatuses' => WarrantyStatus::options(),
        ]);
}

public function store(StoreJobScheduleRequest $request)
{
    // dd($request->all());
    $jobSchedule = new JobSchedule();
    $jobSchedule->job_no = $this->generateUniqueJobNo();

    $jobSchedule->company_id     = $request->company_id;
    $jobSchedule->customer_id    = $request->customer_id;
    $jobSchedule->brand_id    = $request->supplier_id;
    $jobSchedule->job_owner_id   = $request->technician_id;
    $jobSchedule->job_type  = $request->job_type_id;

    $jobSchedule->job_status_id  = $request->job_status_id;
    $jobSchedule->product_id     = $request->product_id;
    $jobSchedule->contact_no     = $request->contact_no;
    $jobSchedule->location       = $request->location;

    $startDatetime = parseDateTimeOrNull($request->start_date, $request->start_time);
    $endDatetime = parseDateTimeOrNull($request->start_date, $request->end_time); // uses same date as start
    $closeDatetime = parseDateTimeOrNull($request->close_date, $request->close_time);
    $jobSchedule->start_datetime = $startDatetime;
    $jobSchedule->end_datetime = $endDatetime;
    $jobSchedule->closing_date = $closeDatetime;
 

    $jobSchedule->order_id       = $request->order_id;
    $jobSchedule->job_details    = $request->job_details;
    $jobSchedule->remarks        = $request->remarks;

    $jobSchedule->save();

  
    $jobTypeValue = optional(ServiceType::find($request->job_type_id))->title;
    $jobType = strtolower($jobTypeValue);



    if (in_array($jobType, ['amc', 'inside', 'outside'])) {
        ServiceJob::create([
            'job_schedule_id' => $jobSchedule->id,
            'machine_type'    => $request->machine_type,
            'is_warranty'     => $request->is_warranty,
            'service_type_id' => $request->job_type_id
        ]);
    }

    return redirect()->route('job-schedules.index')->with('success', 'Job schedule created successfully.');
}


public function edit($id){

    $data = JobSchedule::findOrFail($id);
    $data->start_date = $data->start_datetime ? Carbon::parse($data->start_datetime)->format('d/m/Y') : null;
    $data->start_time = $data->start_datetime ? Carbon::parse($data->start_datetime)->format('H:i') : null;

    $data->end_date = $data->end_datetime ? Carbon::parse($data->end_datetime)->format('d/m/Y') : null;
    $data->end_time = $data->end_datetime ? Carbon::parse($data->end_datetime)->format('H:i') : null;

    $data->close_date = $data->closing_date ? Carbon::parse($data->closing_date)->format('d/m/Y') : null;
    $data->close_time = $data->closing_date ? Carbon::parse($data->closing_date)->format('H:i') : null;

    $companies = Company::pluck('company', 'id');
    $suppliers =Supplier::pluck('brand', 'id');
    $technicians = Technician::with('user')->get()->pluck('user.name', 'id');
    $jobStatuses = JobStatus::pluck('status', 'id');
    $productOptions = Product::limit(10)->pluck('title', 'id');
    $customers = Customer::pluck('fullname', 'id');
    $orders = Order::pluck('os_number', 'id');
    $jobTypes  = ServiceType::pluck('title', 'id');
    $machineTypes = MachineType::options();
    $warrantyStatuses = WarrantyStatus::options();

     

   return view('auth.job_schedules.edit', compact('data','companies','suppliers','technicians','jobStatuses',
   'productOptions','customers','orders','jobTypes','machineTypes','warrantyStatuses'
));
}

public function update(UpdateJobScheduleRequest $request, $id)
{
    // Find the job schedule by ID
    $jobSchedule = JobSchedule::findOrFail($id);

    // Update the job schedule fields
    $jobSchedule->company_id     = $request->company_id;
    $jobSchedule->customer_id    = $request->customer_id;
    $jobSchedule->brand_id       = $request->supplier_id;
    $jobSchedule->job_owner_id   = $request->technician_id;
    $jobSchedule->job_status_id  = $request->job_status_id;
    $jobSchedule->product_id     = $request->product_id;
    $jobSchedule->contact_no     = $request->contact_no;
    $jobSchedule->location       = $request->location;
    $jobSchedule->job_type       = $request->job_type_id;

    // Parse the date and time fields and convert them into DateTime objects
    $startDatetime = parseDateTimeOrNull($request->start_date, $request->start_time);
    $endDatetime = parseDateTimeOrNull($request->start_date, $request->end_time); // uses same date as start
    $closeDatetime = parseDateTimeOrNull($request->close_date, $request->close_time);

    // Update the fields with the parsed DateTime values
    $jobSchedule->start_datetime = $startDatetime;
    $jobSchedule->end_datetime = $endDatetime;
    $jobSchedule->closing_date = $closeDatetime;

    // Update other fields
    $jobSchedule->order_id       = $request->order_id;
    $jobSchedule->job_details    = $request->job_details;
    $jobSchedule->remarks        = $request->remarks;
    // Save the updated job schedule record
    $jobSchedule->save();


     // 🔍 Get job type value (title)
     $jobTypeTitle = optional(ServiceType::find($request->job_type_id))->title;

    
     $jobTypeValue = strtolower($jobTypeTitle);
 
     // 🎯 Handle ServiceJob logic
     if (in_array($jobTypeValue, ['inside', 'outside', 'amc'])) {
       
         $serviceJob = ServiceJob::where('job_schedule_id', $jobSchedule->id)->first();
        
         if ($serviceJob) {
             // Update existing service job
             $serviceJob->machine_type    = $request->machine_type;
             $serviceJob->is_warranty     = $request->is_warranty;
             $serviceJob->service_type_id = $request->job_type_id;
             $serviceJob->save();
         } else {
      
             // Create new service job
             ServiceJob::create([
                 'job_schedule_id' => $jobSchedule->id,
                 'machine_type'    => $request->machine_type,
                 'is_warranty'     => $request->is_warranty,
                 'service_type_id' => $request->job_type_id,
             ]);
         }
     } else {
       
         // If job type is not valid for service job, delete if exists
         ServiceJob::where('job_schedule_id', $jobSchedule->id)->delete();
     }
    // Redirect back to the index page with a success message
    return redirect()->route('job-schedules.index')->with('success', 'Job schedule updated successfully.');
}





public function ajaxSearch(Request $request)
{

    $search = $request->get('q');

    $products = Product::query()
        ->where('title', 'like', '%' . $search . '%')
        ->limit(20)
        ->get(['id', 'title']);

    return response()->json($products);
}

public function getCustomersByCompany($companyId)
{
    $customers = Customer::where('company_id', $companyId)
        ->pluck('fullname', 'id');

    return response()->json($customers);
}

public function findOrder(Request $request)
{
    $search = $request->get('q');

    $orders = Order::query()
        ->where('os_number', 'like', '%' . $search . '%')
        ->limit(20)
        ->get(['id', 'os_number']);

    return response()->json($orders);
}
private function generateUniqueJobNo()
{
    do {
        $slug = 'job-' . Str::lower(Str::random(8));
    } while (JobSchedule::where('job_no', $slug)->exists());

    return $slug;
}



}
