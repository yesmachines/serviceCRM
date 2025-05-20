<?php

namespace App\Http\Controllers\API\Technician;

use App\Http\Controllers\Controller;
use App\Http\Resources\InstallationReportResource;
use App\Models\InstallationReport;
use App\Models\InstallationReportClientFeedback;
use App\Models\InstallationTechnicianFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class InstallationReportController extends Controller
{
    public function index()
    {
        $reports = InstallationReport::with(['jobSchedule', 'order', 'company', 'brand', 'product'])->latest()->paginate(15);
        return successResponse('Success', InstallationReportResource::collection($reports));
    }

    public function store(Request $request)
    {
   
        $validator = Validator::make($request->all(), [
            'job_schedule_id'       => 'required|exists:job_schedules,id',
            'order_id'              => 'nullable|exists:orders,id',
            'company_id'            => 'required|exists:companies,id',
            'start_date'     => 'required|date_format:m/d/Y',
            'start_time'     => 'required|date_format:H:i',
            'end_time'       => 'required|date_format:H:i|after:start_time',
            'close_date'     => 'nullable|date_format:m/d/Y',
            'brand_id'              => 'nullable|exists:suppliers,id',
            'product_id'            => 'nullable|exists:products,id',
            'serial_no'             => 'nullable|string|max:255',
            'names_of_participants' => 'nullable|string',
            'client_representative' => 'nullable|string|max:255',
            'designation'           => 'nullable|string|max:255',
            'client_signature'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'attendees' => 'nullable|array',
            'attendees.*.id' => 'nullable|exists:technicians,id',
            'technician_feedbacks' => 'nullable|array',
            'client_feedbacks' => 'nullable|array',
        ]
        , [
            'attendees.*.id.exists' => 'One or more selected technicians do not exist.',
        ]);
        
        if ($validator->fails()) {
            $errorMessage = $validator->messages();
            return errorResponse(trans('api.required_fields'), $errorMessage);
        }

        $data = $validator->validated();


        if ($request->hasFile('client_signature')) {
            $file = $request->file('client_signature');
            $path = $file->store('client_signatures', 'public');
            $data['client_signature'] = $path;
        }
        $report = new InstallationReport();
        $report->job_schedule_id = $data['job_schedule_id'] ?? null;
        $report->order_id = $data['order_id'] ?? null;
        $report->company_id = $data['company_id'] ?? null;
        $report->brand_id = $data['brand_id'] ?? null;
        $report->product_id = $data['product_id'] ?? null;
        $report->serial_no = $data['serial_no'] ?? null;
        $report->names_of_participants = $data['names_of_participants'] ?? null;
        $report->client_representative = $data['client_representative'] ?? null;
        $report->designation = $data['designation'] ?? null;
        $report->designation = $data['contact_number'] ?? null;
        $report->job_start_datetime = parseDateTimeOrNull($request->start_date, $request->start_time);
        $report->job_end_datetime = parseDateTimeOrNull($request->close_date, $request->end_time);
        // $jobSchedule->created_date = parseDateTimeOrNull($request->close_date, $request->close_time);
        $report->save();
      
        if (!empty($data['technician_feedbacks']) && is_array($data['technician_feedbacks'])) {
                foreach ($data['technician_feedbacks'] as $label => $feedback) {
                    InstallationTechnicianFeedback::create([
                        'installation_report_id' => $report->id,
                        'label' => $label,
                        'feedback' => $feedback,
                        'remarks' => $request->remarks ?? null,
                    ]);
            }
        }

        if (!empty($data['client_feedbacks']) && is_array($data['client_feedbacks'])) {
            foreach ($data['client_feedbacks'] as $label => $feedback) {
                InstallationReportClientFeedback::create([
                    'installation_report_id' => $report->id,
                    'label' => $label,
                    'feedback' => $feedback,
                    'remarks' => $request->remarks ?? null,
                ]);
           }
        }
    


        if ($request->has('attendees') && is_array($request->attendees)) {
            // Clear existing attendees (useful during update)
            $report->attendees()->delete();
        
            $attendeeData = collect($request->attendees)
                ->map(function ($attendee) use ($report) {
                    return [
                        'installation_report_id' => $report->id,
                        'technician_id' => $attendee['id'],
                    ];
                })->toArray();
        
            $report->attendees()->createMany($attendeeData);
        }

        $report->load(['jobSchedule', 'order', 'company', 'brand', 'product','attendees.technician.user.employee','technicianFeedbacks','clientFeedbacks']);

        return response()->json([
            'status' => true,
            'message' => 'Installation report created successfully.',
            'data' => new InstallationReportResource($report)
        ]);
    }

    public function show($id)
    {
        $report = InstallationReport::with(['jobSchedule', 'order', 'company', 'brand', 'product'])->find($id);

        if (!$report) {
            return response()->json(['status' => false, 'message' => 'Installation report not found.'], 404);
        }

        return response()->json([
            'status' => true,
            'data' => new InstallationReportResource($report)
        ]);
    }

    public function update(Request $request, $id)
    {
        $report = InstallationReport::find($id);

        if (!$report) {
            return response()->json(['status' => false, 'message' => 'Installation report not found.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'job_schedule_id'       => 'nullable|exists:job_schedules,id',
            'order_id'              => 'nullable|exists:orders,id',
            'company_id'            => 'nullable|exists:companies,id',
            'start_date'     => 'required|date_format:m/d/Y',
            'start_time'     => 'required|date_format:H:i',
            'end_time'       => 'required|date_format:H:i|after:start_time',
            'close_date'     => 'nullable|date_format:m/d/Y',
            'brand_id'              => 'nullable|exists:suppliers,id',
            'product_id'            => 'nullable|exists:products,id',
            'serial_no'             => 'nullable|string|max:255',
            'names_of_participants' => 'nullable|string',
            'client_representative' => 'nullable|string|max:255',
            'designation'           => 'nullable|string|max:255',
            'client_signature'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'attendees' => 'nullable|array',
            'attendees.*.id' => 'nullable|exists:technicians,id',
            'technician_feedbacks' => 'nullable|array',
            'client_feedbacks' => 'nullable|array',
        ]
        , [
            'attendees.*.id.exists' => 'One or more selected technicians do not exist.',
        ]);
        

        if ($validator->fails()) {
            $errorMessage = $validator->messages();
            return errorResponse(trans('api.required_fields'), $errorMessage);
        }


        $data = $validator->validated();

        if ($request->hasFile('client_signature')) {
            if ($report->client_signature && Storage::disk('public')->exists($report->client_signature)) {
                Storage::disk('public')->delete($report->client_signature);
            }
            $file = $request->file('client_signature');
            $path = $file->store('client_signatures', 'public');
            $data['client_signature'] = $path;
        }

        $report = new InstallationReport();
        $report->job_schedule_id = $data['job_schedule_id'] ?? null;
        $report->order_id = $data['order_id'] ?? null;
        $report->company_id = $data['company_id'] ?? null;
        $report->brand_id = $data['brand_id'] ?? null;
        $report->product_id = $data['product_id'] ?? null;
        $report->serial_no = $data['serial_no'] ?? null;
        $report->names_of_participants = $data['names_of_participants'] ?? null;
        $report->client_representative = $data['client_representative'] ?? null;
        $report->designation = $data['designation'] ?? null;
        $report->designation = $data['contact_number'] ?? null;
        $report->job_start_datetime = parseDateTimeOrNull($request->start_date, $request->start_time);
        $report->job_end_datetime = parseDateTimeOrNull($request->close_date, $request->end_time);

        $report->update($data);

        if ($request->has('attendees') && is_array($request->attendees)) {
            // Clear existing attendees (useful during update)
            $report->attendees()->delete();
        
            $attendeeData = collect($request->attendees)
                ->map(function ($attendee) use ($report) {
                    return [
                        'installation_report_id' => $report->id,
                        'technician_id' => $attendee['id'],
                    ];
                })->toArray();
        
            $report->attendees()->createMany($attendeeData);
        }
        

        if (!empty($data['technician_feedbacks']) && is_array($data['technician_feedbacks'])) {
            // Delete existing technician feedbacks
            $report->technicianFeedbacks()->delete();
        
            // Create new technician feedbacks
            foreach ($data['technician_feedbacks'] as $label => $feedback) {
                $report->technicianFeedbacks()->create([
                    'label' => $label,
                    'feedback' => $feedback,
                    'remarks' => $request->remarks ?? null,
                ]);
            }
        }
        
        // CLIENT FEEDBACKS
        if (!empty($data['client_feedbacks']) && is_array($data['client_feedbacks'])) {
            // Delete existing client feedbacks
            $report->clientFeedbacks()->delete();
        
            // Create new client feedbacks
            foreach ($data['client_feedbacks'] as $label => $feedback) {
                $report->clientFeedbacks()->create([
                    'label' => $label,
                    'feedback' => $feedback,
                    'remarks' => $request->remarks ?? null,
                ]);
            }
        }
    
        $report->load(['jobSchedule', 'order', 'company', 'brand', 'product','attendees.technician.user.employee','technicianFeedbacks','clientFeedbacks']);

        return response()->json([
            'status' => true,
            'message' => 'Installation report updated successfully.',
            'data' => new InstallationReportResource($report)
        ]);
    }

    public function destroy($id)
    {
        $report = InstallationReport::find($id);

        if (!$report) {
            return response()->json(['status' => false, 'message' => 'Installation report not found.'], 404);
        }

        if ($report->client_signature && Storage::disk('public')->exists($report->client_signature)) {
            Storage::disk('public')->delete($report->client_signature);
        }

        $report->delete();

        return response()->json([
            'status' => true,
            'message' => 'Installation report deleted successfully.'
        ]);
    }
}
