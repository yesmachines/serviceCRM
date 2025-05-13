<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
   public function jobSchedules()
    {
        return $this->hasMany(JobSchedule::class, 'brand_id');
    }

}
