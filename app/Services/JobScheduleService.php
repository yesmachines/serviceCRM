<?php
namespace App\Services;

use App\Enums\MachineType;
use App\Enums\WarrantyStatus;
use App\Models\JobSchedule;
use App\Models\ServiceJob;
use App\Models\ServiceType;
use App\Services\Interfaces\JobScheduleServiceInterface;
use App\Http\Requests\Auth\StoreJobScheduleRequest;
use App\Models\Company;
use App\Models\Customer;
use App\Models\DemoRequest;
use App\Models\JobStatus;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Technician;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Yajra\DataTables\Facades\DataTables;




class JobScheduleService implements JobScheduleServiceInterface
{


  public function getJobSchedulesForDataTable(Request $request)
  {
   
    $query = JobSchedule::with(['customer', 'company', 'product', 'servicetype', 'jobstatus']);

    if (Request::input('company_id')) {
        $query->where('company_id', Request::input('company_id'));
    }
    
    if (Request::input('job_id')) {
        $query->where('id', Request::input('job_id'));
    }
    
    if (Request::input('type_id')) {
        $query->where('job_type', Request::input('type_id'));
    }
    
    if (Request::input('status_id')) {
        $query->where('job_status_id', Request::input('status_id'));
    }
    

    return DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('job_no', fn($row) => $row->job_no ?? '-')
        ->addColumn('job_type', fn($row) => $row->servicetype->title ?? '-')
        ->addColumn('customer', fn($row) => $row->customer->fullname ?? '-')
        ->addColumn('company', fn($row) => $row->company->company ?? '-')
        ->addColumn('product', fn($row) => $row->product->title ?? '-')
        ->addColumn('jobstatus', fn($row) => $row->jobstatus->status ?? '-')
        ->addColumn('actions', function ($row) {
            try {
                return view('auth.job_schedules.actions', ['job' => $row])->render();
            } catch (\Throwable $e) {
                \Log::error('Job Schedule Actions View Error', [
                    'job_id' => $row->id ?? null,
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return 'Error rendering actions';
            }
        })
        ->rawColumns(['actions'])
        ->make(true);
   
  }

    public function createJobSchedule(StoreJobScheduleRequest $request)
    {

        $companyCode = 'YES'; // Or from related company model

        // Derive jobTypeCode from ServiceType title
        $jobTypeTitle = strtolower(optional(ServiceType::find($request->job_type_id))->title);
        $jobTypeCode = strtoupper(substr(strtolower($jobTypeTitle), 0, 2)); // e.g., "Demo" → "DE"
        // Get current year (last two digits)
        $year = now()->format('y');
        // Count existing jobs with same pattern in this year
        $count = JobSchedule::where('job_no', 'like', "$companyCode/$jobTypeCode/$year/%")->count();
        // Sequence number for this pattern
        $sequence = $count + 1;
    
        // Final Job ID
        $jobId = "{$companyCode}/{$jobTypeCode}/{$year}/{$sequence}";

        $jobSchedule = new JobSchedule();
        $jobSchedule->job_no = $jobId;
        $jobSchedule->company_id = $request->company_id;
        $jobSchedule->customer_id = $request->customer_id;
        $jobSchedule->brand_id = $request->supplier_id;
        $jobSchedule->job_owner_id = $request->technician_id;
        $jobSchedule->job_type = $request->job_type_id;
        $jobSchedule->job_status_id = $request->job_status_id;
        $jobSchedule->product_id = $request->product_id;
        $jobSchedule->contact_no = $request->contact_no;
        $jobSchedule->location = $request->location;

        $jobSchedule->start_datetime = parseDateTimeOrNull($request->start_date, $request->start_time);
        $jobSchedule->end_datetime = parseDateTimeOrNull($request->start_date, $request->end_time);
        $jobSchedule->closing_date = parseDateTimeOrNull($request->close_date, $request->close_time);

        $jobSchedule->order_id = $request->order_id ?? null;
        $jobSchedule->job_details = $request->job_details;
        $jobSchedule->remarks = $request->remarks;
        $jobSchedule->demo_request_id = $request->demo_request_id ?? null;
        $jobSchedule->save();

        // $jobType = strtolower(optional(ServiceType::find($request->job_type_id))->title);
        // $jobTypeCode = strtoupper(substr($jobType, 0, 2));

       

        if (in_array($jobTypeTitle, ['amc', 'inside', 'outside'])) {
            ServiceJob::create([
                'job_schedule_id' => $jobSchedule->id,
                'machine_type' => $request->machine_type,
                'is_warranty' => $request->is_warranty,
                'service_type_id' => $request->job_type_id
            ]);
        }
        

        return $jobSchedule;
    }

    public function getCreateData(Request $request): array
    {
        return [
            'companies'         => Company::pluck('company', 'id')->prepend('Select Company', ''),
            'serviceTypesGrouped' => ServiceType::all()->groupBy('parent_id'),
            'suppliers'         => Supplier::pluck('brand', 'id')->prepend('Select Brand', ''),
            'technicians'       => Technician::with('user')->get()->pluck('user.name', 'id')->prepend('Select Technician', ''),
            'jobStatuses' => JobStatus::orderBy('priority')
                ->pluck('status', 'id')
                ->prepend('Select job Status', ''),
            'machineTypes'      => MachineType::options(),
            'warrantyStatuses'  => WarrantyStatus::options(),
            'orders'            => Order::pluck('os_number', 'id')->prepend('Search Os Number', ''),
            'drfRefferences'    => DemoRequest::pluck('reference_no', 'id')->prepend('Search Drf Reference', ''),
        ];
    }

    public function getEditData(int $id): array
    {
        $data = JobSchedule::findOrFail($id);

        $data->start_date = $data->start_datetime ? Carbon::parse($data->start_datetime)->format('d/m/Y') : null;
        $data->start_time = $data->start_datetime ? Carbon::parse($data->start_datetime)->format('H:i') : null;

        $data->end_date = $data->end_datetime ? Carbon::parse($data->end_datetime)->format('d/m/Y') : null;
        $data->end_time = $data->end_datetime ? Carbon::parse($data->end_datetime)->format('H:i') : null;

        // $data->close_date = $data->closing_date ? Carbon::parse($data->closing_date)->format('d/m/Y') : null;
        // $data->close_time = $data->closing_date ? Carbon::parse($data->closing_date)->format('H:i') : null;

        return [
            'data'              => $data,
            'companies'         => Company::pluck('company', 'id'),
            'suppliers'         => Supplier::pluck('brand', 'id'),
            'technicians'       => Technician::with('user')->get()->pluck('user.name', 'id'),
            'jobStatuses' => JobStatus::orderBy('priority')
            ->pluck('status', 'id')
            ->prepend('Select job Status', ''),
            'products'          => Product::limit(50)->pluck('title', 'id'),
            'customers'         => Customer::pluck('fullname', 'id'),
            'orders'            => Order::pluck('os_number', 'id'),
            'serviceTypesGrouped' => ServiceType::all()->groupBy('parent_id'),
            'machineTypes'      => MachineType::options(),
            'warrantyStatuses'  => WarrantyStatus::options(),
            'drfRefferences'    => DemoRequest::pluck('reference_no', 'id')->prepend('Search Drf Reference', ''),
        ];
    }

    public function updateJobSchedule(array $data, int $id): void
    {
        $jobSchedule = JobSchedule::findOrFail($id);

        $jobTypeChanged = $jobSchedule->job_no != $data['job_type_id'];
        // Update job_type_id
        $jobSchedule->job_no = $data['job_type_id'];
    
        if ($jobTypeChanged) {
            // Regenerate job_id
            $companyCode = 'YES'; // Replace with actual company code logic
    
            // Derive new job type code
            $jobTypeTitle = optional(ServiceType::find($data['job_type_id']))->title;
            $jobTypeCode = strtoupper(substr(strtolower($jobTypeTitle), 0, 2));
    
            $year = now()->format('y');
    
            // Count how many jobs exist for this new combination
            $count = JobSchedule::where('job_no', 'like', "$companyCode/$jobTypeCode/$year/%")->count();
            $sequence = $count + 1;
    
            // Generate new job_id
            $jobSchedule->job_no = "{$companyCode}/{$jobTypeCode}/{$year}/{$sequence}";
        }
 
        $jobSchedule->company_id     = $data['company_id'];
        $jobSchedule->customer_id    = $data['customer_id'];
        $jobSchedule->brand_id       = $data['supplier_id'];
        $jobSchedule->job_owner_id   = $data['technician_id'];
        $jobSchedule->job_status_id  = $data['job_status_id'];
        $jobSchedule->product_id     = $data['product_id'];
        $jobSchedule->contact_no     = $data['contact_no'];
        $jobSchedule->location       = $data['location'];
        $jobSchedule->job_type       = $data['job_type_id'];

        $jobSchedule->start_datetime = parseDateTimeOrNull($data['start_date'], $data['start_time']);
        $jobSchedule->end_datetime   = parseDateTimeOrNull($data['start_date'], $data['end_time']);
       

        // $jobSchedule->closing_date   = parseDateTimeOrNull($data['close_date'], $data['close_time']);

        $jobSchedule->order_id       = $data['order_id'] ?? null;
        $jobSchedule->job_details    = $data['job_details'];
        $jobSchedule->remarks        = $data['remarks'];
        $jobSchedule->demo_request_id = $data['demo_request_id'] ?? null;

        $jobSchedule->save();

        $jobTypeTitle = optional(ServiceType::find($data['job_type_id']))->title;
        $jobType = strtolower($jobTypeTitle);

        if (in_array($jobType, ['inside', 'outside', 'amc'])) {
            $serviceJob = ServiceJob::where('job_schedule_id', $jobSchedule->id)->first();

            if ($serviceJob) {
                $serviceJob->machine_type    = $data['machine_type'];
                $serviceJob->is_warranty     = $data['is_warranty'];
                $serviceJob->service_type_id = $data['job_type_id'];
                $serviceJob->save();
            } else {
                ServiceJob::create([
                    'job_schedule_id' => $jobSchedule->id,
                    'machine_type'    => $data['machine_type'],
                    'is_warranty'     => $data['is_warranty'],
                    'service_type_id' => $data['job_type_id'],
                ]);
            }
        } else {
            ServiceJob::where('job_schedule_id', $jobSchedule->id)->delete();
        }
    }

 public function findOrder(Request $request): array
    {
        $search = Request::input('q');
        return Order::query()
            ->where('os_number', 'like', '%' . $search . '%')
            ->limit(20)
            ->get(['id', 'os_number'])
            ->toArray();
    }

    public function findDemo(Request $request): array
    {
        $search = Request::input('q');
    
        return DemoRequest::query()
            ->where('reference_no', 'like', '%' . $search . '%')
            ->limit(20)
            ->get(['id', 'reference_no'])
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'reference_no' => $item->reference_no
                ];
            })
            ->toArray();
    }

    

    private function generateUniqueJobNo()
    {
        return 'JOB-' . strtoupper(uniqid());
    }
}