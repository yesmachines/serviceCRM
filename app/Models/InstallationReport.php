<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstallationReport extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'job_schedule_id',
        'order_id',
        'company_id',
        'created_date',
        'job_start_datetime',
        'job_end_datetime',
        'brand_id',
        'product_id',
        'serial_no',
        'names_of_participants',
        'client_representative',
        'designation',
        'contact_number',
        'client_signature',
    ];

    public function jobSchedule()
    {
        return $this->belongsTo(JobSchedule::class);
    }


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function brand()
    {
        return $this->belongsTo(Supplier::class, 'brand_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attendees()
    {
        return $this->hasMany(InstallationAttendee::class);
    }
    public function clientFeedbacks()
    {
        return $this->hasMany(InstallationReportClientFeedback::class);
    }

    public function technicianFeedbacks()
    {
        return $this->hasMany(InstallationTechnicianFeedback::class);
    }
}
