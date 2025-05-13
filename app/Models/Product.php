<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

     protected $fillable = ['title']; 
    public function jobSchedules()
    {
        return $this->hasMany(JobSchedule::class);
    }

}
