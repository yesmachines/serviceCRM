<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#full-width-modal">
    View
</button>

<div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="fullWidthModalLabel">Demo Client Feedback Report</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <h5 class="mb-3">Demo Client Feedback Report Details</h5>
                    @php
                        use Carbon\Carbon;
                        $start = $report->job_start_datetime ? Carbon::parse($report->job_start_datetime)->format('d M Y h:i A') : null;
                        $end = $report->job_end_datetime ? Carbon::parse($report->job_end_datetime)->format('d M Y h:i A') : null;
                    @endphp

                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Drf Reference No</th>
                                <td>{{ $report->jobSchedule->demoRequest->reference_no ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Demo Date</th>
                                <td>
                                {{ $report->jobSchedule->demoRequest && $report->jobSchedule->demoRequest->demo_date 
                                    ? \Carbon\Carbon::parse($report->jobSchedule->demoRequest->demo_date)->format('d M Y') 
                                    : '-' 
                                }}
                            </td>
                            </tr>
                            <tr>
                                <th>Submitted Offer</th>
                                <td>{{ $report->jobSchedule->demoRequest->offer_submitted ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Job Schedule No</th>
                                <td>{{ $report->jobSchedule->job_no ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Job Location</th>
                                <td>{{ $report->jobSchedule->location ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Job Contact No</th>
                                <td>{{ $report->jobSchedule->contact_no ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Job Start Time and Date</th>
                                <td>{{ $start ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Job End Time and Date</th>
                                <td>{{ $end ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Demo Objective</th>
                                <td>{{ $report->demo_objective ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Job Status</th>
                                <td>{{ $report->jobSchedule->jobStatus->status ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Result</th>
                                <td>{{ $report->result ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Client Representative</th>
                                <td>{{ $report->client_representative ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Designation</th>
                                <td>{{ $report->designation ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Rating</th>
                                <td>{{ $report->rating ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Comment</th>
                                <td>{{ $report->comment ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Client Signature</th>
                                <td>
                                    @if($report->client_signature && Storage::disk('public')->exists($report->client_signature))
                                        <img src="{{ asset('storage/' . $report->client_signature) }}" alt="Client Signature" class="img-fluid" style="max-height: 200px;">
                                    @else
                                        <em>No signature available</em>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>

                   

                    @if(optional($report->jobSchedule->demoRequest)->details && count($report->jobSchedule->demoRequest->details))
                        <h6 class="mt-4">DRF ITEMS</h6>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Description</th>
                                    <th>Qty</th>
                                    <th>Remarks</th>
                                    <th>Product Type</th>
                                    <th>Machine Out</th>
                                    <th>Machine In</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($report->jobSchedule->demoRequest->details as $index => $detail)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $detail['description'] ?? '-' }}</td>
                                        <td>{{ $detail['qty'] ?? '-' }}</td>
                                        <td>{{ $detail['remarks'] ?? '-' }}</td>
                                        <td>{{ $detail['product_type'] ?? '-' }}</td>
                                        <td>{{ !empty($detail['machine_out']) ? \Carbon\Carbon::parse($detail['machine_out'])->format('d-m-Y H:i') : '-' }}</td>
                                        <td>{{ !empty($detail['machine_in']) ? \Carbon\Carbon::parse($detail['machine_in'])->format('d-m-Y H:i') : '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p><em>No DRF Details available.</em></p>
                    @endif



                </div>
            </div>
        </div>
    </div>
</div>
