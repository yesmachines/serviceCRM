<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstallationReportResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                      => $this->id,
           'job_schedule'   => $this->whenLoaded('jobSchedule', function () {
                return [
                    'id'    => $this->jobSchedule->id,
                    'job_no' => $this->jobSchedule->job_no,
                ];
            }),
            'order'   => $this->whenLoaded('order', function () {
                return [
                    'id'    => $this->order->id,
                    'os_number' => $this->order->os_number,
                ];
            }),
            'company'   => $this->whenLoaded('company', function () {
                return [
                    'id'    => $this->company->id,
                    'os_number' => $this->company->company,
                ];
            }),
            'brand'   => $this->whenLoaded('brand', function () {
                return [
                    'id'    => $this->brand->id,
                    'brand' => $this->brand->brand,
                ];
            }),
            'product'   => $this->whenLoaded('product', function () {
                return [
                    'id'    => $this->product->id,
                    'title' => $this->product->title,
                ];
            }),
            'created_date'           => $this->created_date,
            'job_start_datetime'     => $this->job_start_datetime,
            'job_end_datetime'       => $this->job_end_datetime,
            'serial_no'              => $this->serial_no,
            'names_of_participants'  => $this->names_of_participants,
            'client_representative'  => $this->client_representative,
            'designation'            => $this->designation,
            'contact_number'         => $this->contact_number,
            'client_signature'       => $this->client_signature,
        ];
    }
}
