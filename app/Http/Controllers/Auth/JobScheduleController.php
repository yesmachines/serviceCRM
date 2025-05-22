<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreJobScheduleRequest;
use App\Http\Requests\Auth\UpdateJobScheduleRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Services\Interfaces\JobScheduleServiceInterface;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;



class JobScheduleController extends Controller 
{

    protected $jobScheduleService;


    public function __construct(JobScheduleServiceInterface $jobScheduleService)
    {
        $this->jobScheduleService = $jobScheduleService;
    }

    public function index(Request $request){

        return view('auth.job_schedules.index');
    }


   public function getData(Request $request)
    {  
        return $this->jobScheduleService->getJobSchedulesForDataTable($request);     
    }

    

    public function store(StoreJobScheduleRequest $request)
    {
        $this->jobScheduleService->createJobSchedule($request);
        alert()->success('success', 'Job schedule created successfully.');
        return redirect()->route('job-schedules.index');
    }



    public function create(Request $request)
    {
        $data = $this->jobScheduleService->getCreateData($request);
        return view('auth.job_schedules.create', $data);
    }



    public function edit($id)
    {
        $data = $this->jobScheduleService->getEditData($id);
        return view('auth.job_schedules.edit', $data);
    }

    public function update(UpdateJobScheduleRequest $request, $id)
    {
        $this->jobScheduleService->updateJobSchedule($request->validated(), $id);

        alert()->success('success', 'Job schedule updated successfully.');
        return redirect()->route('job-schedules.index');
    }

    public function findOrder(Request $request)
    {
        $orders = $this->jobScheduleService->findOrder($request);
        return response()->json($orders);
    }

    public function findDemo (Request $request){

        $demos = $this->jobScheduleService->findDemo($request);
        return response()->json($demos);

    }

    public function getSuppliersByProduct($supplierId)
    {
        $products = Product::where('brand_id', $supplierId)
            // ->where('product_category', 'products')
            ->limit(30)
            ->pluck('title', 'id'); 
        return response()->json($products);
    }


    public function getCustomersByCompany($companyId)
    {
        $customers = Customer::where('company_id', $companyId)
            ->pluck('fullname', 'id');

        return response()->json($customers);
    }


// private function generateUniqueJobNo()
// {
//     do {
//         $slug = 'job-' . Str::lower(Str::random(8));
//     } while (JobSchedule::where('job_no', $slug)->exists());

//     return $slug;
// }

}
