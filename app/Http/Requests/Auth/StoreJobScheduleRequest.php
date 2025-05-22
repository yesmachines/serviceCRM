<?php

namespace App\Http\Requests\Auth;

use App\Models\ServiceType;
use Illuminate\Foundation\Http\FormRequest;

class StoreJobScheduleRequest extends FormRequest
{
      /**
     * Determine if the user is authorized to make this request.
     */
 public function authorize(): bool
 {
     return true;
 }

 public function rules(): array
 {
     return [
         'job_type_id' => 'required|exists:service_types,id',
         'company_id'     => 'required|exists:companies,id',
         'customer_id'    => 'required|exists:customers,id',
         'supplier_id'    => 'nullable|exists:suppliers,id',
         'technician_id'  => 'required|exists:technicians,id',
         'job_status_id'  => 'required|exists:job_statuses,id',
         'product_id'     => 'required|exists:products,id',
         'contact_no'     => 'required|string|max:20',
         'location'       => 'required|string|max:255',
         'start_date'     => 'required|date_format:m/d/Y',
         'start_time'     => 'required|date_format:H:i',
         'end_time'       => 'required|date_format:H:i|after:start_time',
         'close_date'     => 'nullable|date_format:m/d/Y',
         'close_time'     => 'nullable|date_format:H:i',
         'order_id'       => 'nullable|exists:orders,id',
         'job_details'    => 'nullable|string',
         'remarks'        => 'nullable|string|max:500',
     ];

     $jobTypeId = $this->input('job_type_id');

    if ($jobTypeId) {
        $jobTypeTitle = \App\Models\ServiceType::where('id', $jobTypeId)->value('title');
        $jobTypeSlug = strtolower($jobTypeTitle);

        if (in_array($jobTypeSlug, ['inside', 'outside', 'amc'])) {
            $rules['machine_type'] = 'required|string';
            $rules['is_warranty'] = 'required|in:yes,no'; // if it's 'yes' or 'no' as string
            $rules['order_id'] = 'required|exists:orders,id';
        }

        if ($jobTypeSlug === 'demo') {
            $rules['demo_request_id'] = 'required|exists:demo_requests,id';
        }
    }

    return $rules;

        // $jobTypeId = $this->input('job_type_id');

        // if ($jobTypeId) {
        //     $jobTypeTitle = \App\Models\ServiceType::where('id', $jobTypeId)->value('title');
        //     $jobTypeSlug = strtolower($jobTypeTitle);
    
        //     if (in_array($jobTypeSlug, ['inside', 'outside', 'amc'])) {
        //         $rules['machine_type'] = 'required|string';
        //         $rules['is_warranty'] = 'required|boolean';
        //     }
        // }
    
        
 }


 
 public function messages(): array
 {
     return [
         'job_type_id.required'     => 'Job type is required.',
         'job_type_id.exists'       => 'Selected Job type does not exist.',
         'company_id.required'     => 'Company is required.',
         'company_id.exists'       => 'Selected company does not exist.',
 
         'customer_id.required'    => 'Customer is required.',
         'customer_id.exists'      => 'Selected customer does not exist.',
 
         'supplier_id.exists'      => 'Selected supplier does not exist.',
 
         'technician_id.required' => 'Technician is required.',
         'technician_id.exists'   => 'Selected technician does not exist.',
 
         'job_status_id.required' => 'Job status is required.',
         'job_status_id.exists'   => 'Selected job status does not exist.',
 
         'product_id.required'    => 'Product is required.',
         'product_id.exists'      => 'Selected product does not exist.',
 
         'contact_no.required'    => 'Contact number is required.',
         'contact_no.string'      => 'Contact number must be a string.',
         'contact_no.max'         => 'Contact number may not be greater than 20 characters.',
 
         'location.required'      => 'Location is required.',
         'location.string'        => 'Location must be a string.',
         'location.max'           => 'Location may not be greater than 255 characters.',
 
         'start_date.required'    => 'Start date is required.',
         'start_date.date_format' => 'Start date must be in the format MM/DD/YYYY.',
 
         'start_time.required'    => 'Start time is required.',
         'start_time.date_format' => 'Start time must be in the format HH:MM.',
 
         'end_time.required'      => 'End time is required.',
         'end_time.date_format'   => 'End time must be in the format HH:MM.',
         'end_time.after'         => 'End time must be after the start time.',
 
         'close_date.date_format' => 'Close date must be in the format MM/DD/YYYY.',
 
         'close_time.date_format' => 'Close time must be in the format HH:MM.',
 
         'order_id.required'      => 'Order is required.',
         'order_id.exists'        => 'Selected order does not exist.',
 
         'job_details.string'     => 'Job details must be a string.',
 
         'remarks.string'         => 'Remarks must be a string.',
         'remarks.max'            => 'Remarks may not be greater than 500 characters.',
     ];
 }
}