<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DemoRequest extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'company_id',
        'customer_id',
        'brand_id',
        'demo_request_by',
        'created_by',
        'service_expert_id',
        'offer_submitted',
        'date_of_submission_of_offer',
        'demo_date',
        'demo_time',
        'location',
        'how_soon_client_needs_machine',
        'demo_objective',
        'created_date',
        'status',
    ];

    // Relationships

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function brand()
    {
        return $this->belongsTo(Supplier::class, 'brand_id');
    }

    public function demoRequestBy()
    {
        return $this->belongsTo(User::class, 'demo_request_by');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function serviceExpert()
    {
        return $this->belongsTo(User::class, 'service_expert_id');
    }

    public function jobSchedules()
    {
        return $this->hasMany(JobSchedule::class,'demo_request_id');
    }

    public function details()
    {
        return $this->hasMany(DemoRequestDetail::class, 'demo_request_id');
    }
}
