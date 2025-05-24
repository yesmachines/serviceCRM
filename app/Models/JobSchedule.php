<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobSchedule extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'job_no',
        'job_type',
        'company_id',
        'customer_id',
        'brand_id',
        'product_id',
        'job_owner_id',
        'job_status_id',
        'contact_no',
        'location',
        'start_datetime',
        'end_datetime',
        'job_details',
        'chargeable',
        'closing_date',
        'remarks',
    ];
    protected $dates = ['start_datetime', 'end_datetime', 'closing_date'];

    // Relations
    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class, 'job_type');
    }

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function brand()
    {
        return $this->belongsTo(Supplier::class, 'brand_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function jobOwner()
    {
        return $this->belongsTo(Technician::class, 'job_owner_id');
    }

    public function jobStatus()
    {
        return $this->belongsTo(JobStatus::class, 'job_status_id');
    }

    public function demoRequest()
    {
        return $this->belongsTo(DemoRequest::class, 'demo_request_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
