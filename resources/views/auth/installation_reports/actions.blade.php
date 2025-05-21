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
                    <h5 class="mb-3">Installation Report Details</h5>
                    <table class="table table-bordered">
                        <tbody>

                        @php
                        use Carbon\Carbon;

                        $start = $report->job_start_datetime ? Carbon::parse($report->job_start_datetime)->format('d M Y h:i A') : null;
                        $end = $report->job_end_datetime ? Carbon::parse($report->job_end_datetime)->format('d M Y h:i A') : null;
                        @endphp
                           
                            <tr><th>Job Schedule No</th><td>{{$report->jobSchedule->job_no ?? '-'}}</td></tr>
                            <tr><th>Job Location</th><td>{{$report->jobSchedule->location ?? '-'}}</td></tr>
                            <tr><th>Job Contact No</th><td>{{$report->jobSchedule->contact_no ?? '-'}}</td></tr>

                            <tr><th>Job Status</th><td>{{$report->jobSchedule->jobStatus->status ?? '-'}}</td></tr>
                            <tr><th>Job Strat Time and Date</th><td>{{ $start ?? '-'}}</td></tr>
                            <tr><th>Job End Time and Date</th><td>{{ $end ?? '-'}}</td></tr>
                           
                           
                            <tr>
                            <th>Client Feedback</th>
                            <td>
                                @if($report->clientFeedbacks->count())
                                    @foreach($report->clientFeedbacks as $feedback)
                                        <div>{{ $feedback->feedback }}</div>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                            </tr>
                            <tr>
                            <th>Technician Feedback</th>
                            <td>
                                @if($report->technicianFeedbacks->count())
                                    @foreach($report->technicianFeedbacks as $feedback)
                                        <div>{{ $feedback->feedback }}</div>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                            </tr>
                            
                            <tr>
                            <th>Company</th>
                            <td>{{ $report->company->company ?? '-' }}</td>
                            </tr>

                            <tr>
                            <th>Order No</th>
                            <td>{{ $report->order->os_number ?? '-' }}</td>
                            </tr>

                            <tr>
                                <th>Product</th>
                                <td>{{ $report->product->title ?? '-' }}</td>
                            </tr>

                            <tr>
                                <th>Brand</th>
                                <td>{{ $report->brand->brand ?? '-' }}</td>
                            </tr>

                         
                            <tr>
                            <th>Attendees</th>
                            <td>
                                @if($report->attendees->count())
                                    <ul class="mb-0">
                                        @foreach($report->attendees as $attendee)
                                        <div> {{ $attendee->user->name ?? 'N/A' }} </div>
                                        <!-- <div> {{ $attendee->user->email ?? 'N/A' }}</div> --> 
                                        @endforeach
                                    </ul>
                                @else
                                    -
                                @endif
                                 </td>
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


                           </tr>
                    
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
