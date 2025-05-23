<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    
    
    public function jobSchedules()
    {
        return $this->hasMany(JobSchedule::class);
    }
}
