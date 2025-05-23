<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceJob extends Model
{
    use HasFactory,SoftDeletes;
  
    protected $fillable = [
        'job_schedule_id',
        'machine_type',
        'is_warranty',
        'service_type_id'
    ];
}
