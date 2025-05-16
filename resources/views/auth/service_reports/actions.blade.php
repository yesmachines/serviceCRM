<!-- View Button -->
<button type="button" class="btn btn-sm btn-primary view-report-btn" data-id="{{ $report->id }}">
    View
</button>

<!-- Include Modal Partial -->
@include('auth.service_reports.modal')

<!-- JS for Modal Behavior -->
<script>
$(document).ready(function() {
    $(document).on('click', '.view-report-btn', function () {
        let reportId = $(this).data('id');

        $('#report-modal-body').html(`
            <div class="text-center">
                <div class="spinner-border text-primary" role="status"></div>
                <p>Loading...</p>
            </div>
        `);

        $('#full-width-modal').modal('show');

        $.ajax({
            url: `/service-reports/${reportId}`,
            method: 'GET',
            success: function (res) {
                $('#report-modal-body').html(res);
            },
            error: function () {
                $('#report-modal-body').html('<p class="text-danger">Failed to load report.</p>');
            }
        });
    });
});
</script>
