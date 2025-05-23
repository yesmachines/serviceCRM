<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceType extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'parent_id',
        'slug',
        'daily_report',
    ];

    /**
     * Parent service type (self-relation)
     */
    public function parent()
    {
        return $this->belongsTo(ServiceType::class, 'parent_id');
    }

    /**
     * Child service types (self-relation)
     */
    public function children()
    {
        return $this->hasMany(ServiceType::class, 'parent_id');
    }

    public function jobSchedules()
    {
        return $this->hasMany(JobSchedule::class, 'job_type');
    }
}
