@extends('layouts.eclipse')
@section('title')
    Direct Device Return
@endsection
@section('content')
<section class="hilite-content">
    <div class="page-wrapper_new mrg-top-50">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Direct Device Return</li>
                <b>Direct Device Return</b>
            </ol>
            @if(Session::has('message'))
                <div class="pad margin no-print">
                    <div class="callout {{ Session::get('alert-class', 'alert-success') }}" style="margin-bottom: 0!important;">
                        {{ Session::get('message') }}
                    </div>
                </div>
            @endif
        </nav>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">Return Device for Refurbishment</h4>
                        <p class="text-muted">Process device return directly without client assignment or vehicle creation. Device will be marked as returned and ready for refurbishment.</p>

                        <form id="directReturnForm">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="control-label">Device IMEI <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="imei" name="imei" placeholder="Enter device IMEI" required>
                                <small class="form-text text-muted">Enter the IMEI number of the device to return</small>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fa fa-check"></i> Process Device Return
                            </button>
                        </form>
                    </div>

                    <div class="col-md-6">
                        <h4 class="card-title">Processing Information</h4>
                        <div class="alert alert-info" role="alert">
                            <strong>What happens when you process:</strong>
                            <ul style="margin-bottom: 0; margin-top: 10px;">
                                <li>Device marked as returned in inventory</li>
                                <li>Refurbished status set to 1</li>
                                <li>Device IMEI unchanged (no suffix added)</li>
                                <li>If device has associated vehicle, vehicle is also marked as returned</li>
                                <li>GPS tracking updated</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Result Section -->
                <div id="resultSection" style="display: none; margin-top: 30px;">
                    <hr>
                    <h4>Operation Result</h4>
                    <div id="resultMessage"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .mrg-top-50 {
        margin-top: 50px;
    }
    .text-danger {
        color: #dc3545;
    }
    .alert-info {
        background-color: #e7f3ff;
        border-color: #b3d9ff;
        color: #004085;
    }
</style>

@section('script')
<script>
$(document).ready(function() {
    $('#directReturnForm').on('submit', function(e) {
        e.preventDefault();

        const imei = $('#imei').val().trim();

        if (!imei) {
            showError('Please enter device IMEI');
            return;
        }

        // Show loading state
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');

        $.ajax({
            type: 'POST',
            url: '{{ route("direct-device-return.process") }}',
            data: {
                imei: imei,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status === 1) {
                    showSuccess(response.message, response.data);
                    $('#directReturnForm')[0].reset();
                } else {
                    showError(response.message);
                }
            },
            error: function(xhr) {
                let message = 'An error occurred';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                showError(message);
            },
            complete: function() {
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    function showSuccess(message, data) {
        let html = `
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong><i class="fa fa-check-circle"></i> Success!</strong><br>
                ${message}<br><br>
                <strong>Device Details:</strong><br>
                <ul style="margin-bottom: 0; margin-top: 8px;">
                    <li><strong>IMEI:</strong> ${data.imei}</li>
                    <li><strong>Status:</strong> Returned & Ready for Refurbishment</li>
                    <li><strong>Vehicle Updated:</strong> ${data.vehicle_updated ? 'Yes' : 'No (not assigned to vehicle)'}</li>
                    <li><strong>Refurbished Status:</strong> ${data.refurbished_status}</li>
                </ul>
            </div>
        `;
        $('#resultMessage').html(html);
        $('#resultSection').show();
    }

    function showError(message) {
        let html = `
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong><i class="fa fa-times-circle"></i> Error!</strong><br>
                ${message}
            </div>
        `;
        $('#resultMessage').html(html);
        $('#resultSection').show();
    }
});
</script>
@endsection

@endsection
