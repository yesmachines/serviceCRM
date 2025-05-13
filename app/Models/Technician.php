<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Technician extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vehicle_assigned',
        'technician_level',
        'standard_charge',
        'additional_charge',
    ];

    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_assigned');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'user_id', 'role_id');
    }

    public function jobSchedules()
    {
        return $this->hasMany(JobSchedule::class, 'job_owner_id');
    }





       
}
