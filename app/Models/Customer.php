<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $fillable = ['fullname'];
   
    public function jobSchedules()
    {
        return $this->hasMany(JobSchedule::class,'customer_id');
    }
}
