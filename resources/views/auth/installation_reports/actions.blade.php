<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#full-width-modal">
    View
</button>


<div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="fullWidthModalLabel">Installation Report</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">

                    {{-- Installation Report Details --}}
                    <h5 class="mb-3">Installation Report Details</h5>
                    <table class="table table-bordered">
                        <tbody>
                            @php
                                use Carbon\Carbon;
                                $start = $report->job_start_datetime ? Carbon::parse($report->job_start_datetime)->format('d M Y h:i A') : null;
                                $end = $report->job_end_datetime ? Carbon::parse($report->job_end_datetime)->format('d M Y h:i A') : null;
                            @endphp

                            <tr><th>Job Schedule No</th><td>{{ $report->jobSchedule->job_no ?? '-' }}</td></tr>


                            <tr><th>Job Created By</th><td>{{ optional($report->jobSchedule->createdBy)->name  ?? '-' }}</td></tr>
                            <tr><th>Job Owner</th><td>{{ optional($report->jobSchedule->jobOwner)->name  ?? '-' }}</td></tr>


                            <tr><th>Job Location</th><td>{{ $report->jobSchedule->location ?? '-' }}</td></tr>
                            <tr><th>Job Contact No</th><td>{{ $report->jobSchedule->contact_no ?? '-' }}</td></tr>
                            <tr><th>Job Status</th><td>{{ $report->jobSchedule->jobStatus->status ?? '-' }}</td></tr>
                            <tr><th>Job Start Time and Date</th><td>{{ $start ?? '-' }}</td></tr>
                            <tr><th>Job End Time and Date</th><td>{{ $end ?? '-' }}</td></tr>
                            <tr><th>Company</th><td>{{ $report->company->company ?? '-' }}</td></tr>
                            <tr><th>Order No</th><td>{{ $report->jobSchedule->order->os_number ?? '-' }}</td></tr>
                            <tr><th>Product</th><td>{{ $report->product->title ?? '-' }}</td></tr>
                            <tr><th>Brand</th><td>{{ $report->brand->brand ?? '-' }}</td></tr>
                            
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

                    {{-- Client Feedback Table --}}
                    <h5 class="mt-5 mb-3">Client Feedback</h5>
                    <table class="table table-bordered text-center align-middle">
                        <thead>
                            <tr>
                                <th></th> <!-- Label column with no heading -->
                                <th>Excellent</th>
                                <th>Good</th>
                                <th>To Improve</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($report->clientFeedbacks as $feedback)
                            <tr>
                                <td class="text-start">{{ $feedback->label_name }}</td>
                                <td>@if(strtolower($feedback->feedback) === 'excellent') ✓ @endif</td>
                                <td>@if(strtolower($feedback->feedback) === 'good') ✓ @endif</td>
                                <td>
                                    @if(in_array(strtolower($feedback->feedback), ['to-improve', 'to improve'])) ✓ @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No client feedbacks available.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>


                    {{-- Technician Feedback Table --}}
                            <h5 class="mt-4 mb-3">Technician Feedback</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Yes / No</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($report->technicianFeedbacks as $feedback)
                                        <tr>
                                             <td>{{ $feedback->label_name }} </td>
                                            <td>{{ $feedback->feedback ?? '-' }}</td>      {{-- Yes / No --}}
                                            <td>{{ $feedback->remarks ?? '-' }}</td>       {{-- Remarks --}}
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">No technician feedbacks available.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{-- Attendees Table --}}
                                <h5 class="mt-4 mb-3">Attendees</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Technician Level</th> {{-- Optional: only if available --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($report->attendees as $attendee)
                                            <tr>
                                                <td>{{ $attendee->user->name ?? '-' }}</td>
                                                <td>{{ $attendee->user->email ?? '-' }}</td>
                                                <td>{{ $attendee->technician->technician_level ?? '-' }}</td> {{-- Add this only if you have it --}}
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">No attendees available.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>


                </div>
            </div>
        </div>
    </div>
</div>
