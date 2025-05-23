<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DemoRequestDetail extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'demo_request_id',
        'product_id',
        'description',
        'qty',
        'remarks',
        'machine_out',
        'machine_in',
        'product_type',
        'is_out_from_stock',
    ];

    // Relationships

    public function demoRequest()
    {
        return $this->belongsTo(DemoRequest::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
