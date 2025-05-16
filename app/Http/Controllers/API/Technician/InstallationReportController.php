<?php

namespace App\Http\Controllers\API\Technician;

use App\Http\Controllers\Controller;
use App\Http\Resources\InstallationReportResource;
use App\Models\InstallationReport;
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
            'created_date'          => 'nullable|date',
            'job_start_datetime'    => 'nullable|date',
            'job_end_datetime'      => 'nullable|date|after_or_equal:job_start_datetime',
            'brand_id'              => 'nullable|exists:suppliers,id',
            'product_id'            => 'nullable|exists:products,id',
            'serial_no'             => 'nullable|string|max:255',
            'names_of_participants' => 'nullable|string',
            'client_representative' => 'nullable|string|max:255',
            'designation'           => 'nullable|string|max:255',
            'client_signature'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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

        $report = InstallationReport::create($data);
        $report->load(['jobSchedule', 'order', 'company', 'brand', 'product']);

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
            'created_date'          => 'nullable|date',
            'job_start_datetime'    => 'nullable|date',
            'job_end_datetime'      => 'nullable|date|after_or_equal:job_start_datetime',
            'brand_id'              => 'nullable|exists:suppliers,id',
            'product_id'            => 'nullable|exists:products,id',
            'serial_no'             => 'nullable|string|max:255',
            'names_of_participants' => 'nullable|string',
            'client_representative' => 'nullable|string|max:255',
            'designation'           => 'nullable|string|max:255',
            'client_signature'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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

        $report->update($data);
        $report->load(['jobSchedule', 'order', 'company', 'brand', 'product']);

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
