@extends('layouts.eclipse')

@section('title', 'Service Records')

@section('content')
<style>
.table-responsive table {
    white-space: nowrap;
}

/* Make table more compact */
.table td, .table th {
    padding: 0.45rem;
    font-size: 0.85rem;
}

/* Reduce customer column width */
.customer-col {
    max-width: 140px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>

<div class="container-fluid">

    <h4 class="mb-3">Service Records</h4>

    {{-- Filter Section --}}
    <div class="row mb-3">
        <div class="col-md-3">
            <label>Status</label>
            <select id="statusFilter" class="form-control">
                <option value="">All Status</option>

                @foreach($statuses as $status)
                    <option value="{{ $status }}">
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Table Section --}}
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 table-bordered" id="serviceTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Entry No</th>
                    <th>IMEI</th>
                    <th>Vehicle No</th>
                    <th class="customer-col">Customer</th>
                    <th>Customer Mobile</th>
                    <th class="status-col">Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="8" class="text-center text-muted">
                        Loading...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script>
$(document).ready(function () {

    // Initial load
    loadServiceRecords();

    // Reload on status change
    $('#statusFilter').on('change', function () {
        loadServiceRecords($(this).val());
    });

});

function loadServiceRecords(status = '') {
    if (status === '') {
        $('.status-col').show();
    }else
    {
        $('.status-col').hide();
    }
        $('#serviceTable tbody').html(
        '<tr><td colspan="10" class="text-center">Loading...</td></tr>'
    );
    $.ajax({
        url: "{{ url('/service-device-status-report') }}",
        type: "GET",
        data: {
            status: status
        },
        success: function (data) {

            let rows = '';

            if (data.length === 0) {
                rows = `
                    <tr>
                        <td colspan="9" class="text-center text-muted">
                            No records found
                        </td>
                    </tr>
                `;
            } else {
            if (status === '') {
                $.each(data, function (index, item) {
                    rows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.entry_no ?? '-'}</td>
                            <td>${item.imei ?? '-'}</td>
                            <td>${item.vehicle_no ?? '-'}</td>
                            <td class="customer-col" title="${item.customer_name ?? '-'}">
                                ${item.customer_name ?? '-'}
                            </td>
                            <td>${item.customermobile ?? '-'}</td>
                            <td class="status-col">
                              <span class="badge badge-info">
                                ${item.status}
                              </span>
                            </td>
                            <td>${item.created_at}</td>
                        </tr>
                    `;
                });
            }else
            {
                $.each(data, function (index, item) {
                    rows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.entry_no ?? '-'}</td>
                            <td>${item.imei ?? '-'}</td>
                            <td>${item.vehicle_no ?? '-'}</td>
                            <td class="customer-col" title="${item.customer_name ?? '-'}">
                                ${item.customer_name ?? '-'}
                            </td>
                            <td>${item.customermobile ?? '-'}</td>
                            <td>${item.created_at}</td>
                        </tr>
                    `;
                });
            }
                
            }

            $('#serviceTable tbody').html(rows);
        },
        error: function () {
            $('#serviceTable tbody').html(
                '<tr><td colspan="8" class="text-center text-danger">Error loading data</td></tr>'
            );
        }
    });
}
</script>
@endsection
