<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
     protected $fillable = ['title']; 
    public function jobSchedules()
    {
        return $this->hasMany(JobSchedule::class);
    }

}
