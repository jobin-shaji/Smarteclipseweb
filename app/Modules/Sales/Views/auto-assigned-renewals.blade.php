@extends('layouts.eclipse')
@section('content')

<style>
    .premium-page-wrapper {
        background: #ffffff;
        min-height: 100vh;
        padding: 30px 0;
    }
    
    .premium-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        background: white;
    }
    
    .premium-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 25px 30px;
        border: none;
    }
    
    .premium-header h4 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
        color: white;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .premium-header h4 i {
        background: rgba(255, 255, 255, 0.2);
        padding: 12px;
        border-radius: 10px;
        font-size: 1.3rem;
    }
    
    .premium-body {
        padding: 30px;
        background: #f8f9fa;
    }
    
    .filter-section {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        margin-bottom: 25px;
    }
    
    .filter-section label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .premium-select {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 8px 15px;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        height: 45px;
        line-height: normal;
    }
    
    .premium-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .premium-btn {
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .premium-btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .premium-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }
    
    .premium-btn-secondary {
        background: #6b7280;
        color: white;
    }
    
    .premium-btn-secondary:hover {
        background: #4b5563;
        transform: translateY(-2px);
    }
    
    .premium-table-wrapper {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    
    .premium-table {
        margin: 0;
    }
    
    .premium-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .premium-table thead th {
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 18px 15px;
        border: none;
    }
    
    .premium-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f3f4f6;
    }
    
    .premium-table tbody tr:hover {
        background: #f9fafb;
        transform: scale(1.01);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    
    .premium-table tbody td {
        padding: 18px 15px;
        vertical-align: middle;
        color: #374151;
        font-size: 0.9rem;
    }
    
    .premium-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .badge-completed {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    
    .badge-pending {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }
    
    .badge-assigned {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }
    
    .badge-escalated {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }
    
    .premium-table tbody td.days-critical {
        color: #dc2626 !important;
        font-weight: 700;
        font-size: 1rem;
    }
    
    .premium-table tbody td.days-warning {
        color: #f59e0b !important;
        font-weight: 600;
        font-size: 1rem;
    }
    
    .premium-table tbody td.days-ok {
        color: #059669 !important;
        font-weight: 500;
        font-size: 1rem;
    }
    
    .premium-table tbody td.days-na {
        color: #000000 !important;
        font-weight: 500;
        font-size: 1rem;
    }
    
    .premium-action-btn {
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin: 2px;
    }
    
    .premium-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .btn-attach {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    
    .btn-download-cert {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }
    
    .btn-download-invoice {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }
    
    .btn-reassign {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 8px 12px;
    }
    
    .premium-pagination {
        margin-top: 25px;
    }
    
    .premium-pagination .pagination {
        gap: 8px;
    }
    
    .premium-pagination .page-item .page-link {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        color: #667eea;
        font-weight: 600;
        padding: 10px 16px;
        transition: all 0.3s ease;
    }
    
    .premium-pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        color: white;
    }
    
    .premium-pagination .page-item .page-link:hover {
        background: #667eea;
        border-color: #667eea;
        color: white;
        transform: translateY(-2px);
    }
    
    .premium-modal .modal-content {
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }
    
    .premium-modal .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 20px 25px;
    }
    
    .premium-modal .modal-title {
        font-weight: 600;
        font-size: 1.3rem;
    }
    
    .premium-modal .modal-body {
        padding: 30px;
    }
    
    .premium-modal .modal-footer {
        border: none;
        padding: 20px 25px;
        background: #f8f9fa;
    }
</style>

<div class="premium-page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card premium-card">
                    <div class="card-header premium-header">
                        <h4>
                            <i class="fas fa-clipboard-list"></i>
                            <span>Auto-Assigned GPS Renewals</span>
                        </h4>
                    </div>
                    <div class="card-body premium-body">
                        <!-- Filters -->
                        <div class="filter-section">
                            <div class="row align-items-end">
                                <div class="{{ isset($isCallCenter) && $isCallCenter ? 'col-md-7' : 'col-md-5' }}">
                                    <label for="filter-status">Filter by Status</label>
                                    <select class="form-control premium-select" id="filter-status">
                                        <option value="">All Statuses</option>
                                        <option value="assigned">Assigned</option>
                                        <option value="pending">Follow-up</option>
                                        @if(!isset($isCallCenter) || !$isCallCenter)
                                        <option value="escalated">Escalated</option>
                                        @endif
                                        <option value="completed">Completed</option>
                                    </select>
                                </div>
                                @if(!isset($isCallCenter) || !$isCallCenter)
                                <div class="col-md-4">
                                    <label for="filter-callcenter">Filter by Call Center</label>
                                    <select class="form-control premium-select" id="filter-callcenter">
                                        <option value="">All Call Centers</option>
                                        @foreach($callcenters as $cc)
                                            <option value="{{ $cc->id }}">{{ $cc->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="col-md-3">
                                    <label for="filter-search">Search</label>
                                    <input type="text" id="filter-search" class="form-control premium-select" placeholder="Search IMEI, Vehicle No, GPS ID, Call Center...">
                                </div>
                                <div class="col-md-2">
                                    <input type="hidden" id="is-call-center" value="{{ isset($isCallCenter) && $isCallCenter ? '1' : '0' }}">
                                    <input type="hidden" id="user-callcenter-id" value="{{ $userCallcenterId ?? '' }}">
                                    <!-- Apply button removed — filters auto-load on change -->
                                    <button class="btn premium-btn premium-btn-secondary" id="btn-reset-filter">
                                        <i class="fas fa-redo"></i> Reset
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="premium-table-wrapper">
                            <div class="table-responsive">
                                <table class="table premium-table" id="auto-assignments-table">
                                <thead class="bg-primary" id="table-header">
                                    <tr>
                                        <th class="text-white font-weight-bold">IMEI</th>
                                        <th class="text-white font-weight-bold">Vehicle No</th>
                                        <th class="text-white font-weight-bold call-center-column">Call Center</th>
                                        <th class="text-white font-weight-bold">Assigned On</th>
                                        <th class="text-white font-weight-bold">Validity Date</th>
                                        <th class="text-white font-weight-bold">Days Left</th>
                                        <th class="text-white font-weight-bold followup-columns">Note</th>
                                        <th class="text-white font-weight-bold followup-columns">Followup By</th>
                                        <th class="text-white font-weight-bold followup-columns">Followup Date</th>
                                        <th class="text-white font-weight-bold">Status</th>
                                        <th class="text-white font-weight-bold reassigns-column">Reassigns</th>
                                        <th class="text-white font-weight-bold">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data loaded via AJAX -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div id="pagination-container" class="premium-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reassign Modal -->
<div class="modal fade premium-modal" id="reassignModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-exchange-alt mr-2"></i>Reassign GPS</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Select Call Center:</label>
                    <select class="form-control premium-select" id="modal-callcenter-select">
                        <option value="">-- Select Call Center --</option>
                        @foreach($callcenters as $cc)
                            <option value="{{ $cc->id }}">{{ $cc->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Reason (optional):</label>
                    <textarea class="form-control premium-select" id="modal-reason" rows="3" placeholder="Enter reason for reassignment..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn premium-btn premium-btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn premium-btn premium-btn-primary" id="modal-confirm-reassign">
                    <i class="fas fa-check"></i> Reassign
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Certificate Upload Modal -->
<div class="modal fade premium-modal" id="certificateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fas fa-certificate mr-2"></i>Upload Certificate</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('update.warranty')}}" enctype="multipart/form-data" id="certificate-form">
                    {{csrf_field()}}
                    <div class="card" style="border: 2px solid #e5e7eb; border-radius: 10px;">
                        <div class="overlay" style="display: none;">
                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="exampleInputFile" style="font-weight: 600; color: #374151;">
                                            <i class="fas fa-upload mr-2"></i>Upload Certificate File
                                        </label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="hidden" name="gps_id" id="modal_gps_id">
                                                <input type="file" name="products_csv" class="form-control premium-select" required>
                                            </div>
                                        </div>
                                        <small class="text-muted">Supported formats: PDF, JPG, PNG</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer" style="background: #f8f9fa; border: none;">
                            <button type="submit" class="btn premium-btn premium-btn-primary">
                                <i class="fas fa-upload"></i> Upload Certificate
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let currentPage = 1;
    let selectedAssignmentId = null;
    let selectedCurrentCc = null;
    
    // Check if user is Call_Center
    const isCallCenter = $('#is-call-center').val() === '1';
    const userCallcenterId = $('#user-callcenter-id').val();
    
    // Hide Call Center column and Reassigns column for Call_Center users
    if (isCallCenter) {
        $('.call-center-column').hide();
        $('.reassigns-column').hide();
    }

    // Get URL parameters and apply filters
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('status')) {
        let status = urlParams.get('status');
        // Map old 'active' to new 'assigned'
        if (status === 'active') {
            status = 'assigned';
        }
        $('#filter-status').val(status);
    }
    // Handle old followup_status parameter
    if (urlParams.has('followup_status')) {
        let followupStatus = urlParams.get('followup_status');
        if (followupStatus === 'pending') {
            $('#filter-status').val('pending');
        }
    }
    if (urlParams.has('callcenter_id')) {
        $('#filter-callcenter').val(urlParams.get('callcenter_id'));
    }

    // Load data on page load
    // If URL contains search param, prefill
    const urlParamsSearch = new URLSearchParams(window.location.search);
    if (urlParamsSearch.has('search')) {
        $('#filter-search').val(urlParamsSearch.get('search'));
    }
    loadAssignments();

    // Reset filter
    $('#btn-reset-filter').on('click', function() {
        $('#filter-status').val('');
        $('#filter-callcenter').val('');
        $('#filter-search').val('');
        currentPage = 1;
        updateTableHeaders();
        loadAssignments();
    });
    // Auto-apply filters when changed
    $('#filter-status, #filter-callcenter').on('change', function() {
        currentPage = 1;
        updateTableHeaders();
        loadAssignments();
    });

    // Debounced search input
    let searchTimer = null;
    $('#filter-search').on('input', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function() {
            currentPage = 1;
            updateTableHeaders();
            loadAssignments();
        }, 400);
    });

    // Keep Enter key behavior for instant search
    $('#filter-search').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            clearTimeout(searchTimer);
            currentPage = 1;
            updateTableHeaders();
            loadAssignments();
        }
    });
    
    // Update table headers based on status filter
    function updateTableHeaders() {
        const status = $('#filter-status').val();
        let headers = '';
        
        if (status === 'completed') {
            // Completed view - show Completed Date and Action columns
            headers = `
                <tr>
                    <th class="text-white font-weight-bold">IMEI</th>
                    <th class="text-white font-weight-bold">Vehicle No</th>
                    ${!isCallCenter ? '<th class="text-white font-weight-bold call-center-column">Call Center</th>' : ''}
                    <th class="text-white font-weight-bold">Assigned On</th>
                    <th class="text-white font-weight-bold">Validity Date</th>
                    <th class="text-white font-weight-bold">Days Left</th>
                    <th class="text-white font-weight-bold followup-columns">Followup Date</th>
                    <th class="text-white font-weight-bold">Status</th>
                    <th class="text-white font-weight-bold">Completed Date</th>
                    <th class="text-white font-weight-bold">Action</th>
                </tr>
            `;
        } else if (status === 'pending') {
            // Pending (Follow-up) view - always include Note column; include Followup By for call center users
            headers = `
                <tr>
                    <th class="text-white font-weight-bold">IMEI</th>
                    <th class="text-white font-weight-bold">Vehicle No</th>
                    ${!isCallCenter ? '<th class="text-white font-weight-bold call-center-column">Call Center</th>' : ''}
                    <th class="text-white font-weight-bold">Assigned On</th>
                    <th class="text-white font-weight-bold">Validity Date</th>
                    <th class="text-white font-weight-bold">Days Left</th>
                    <th class="text-white font-weight-bold followup-columns">Note</th>
                    ${isCallCenter ? '<th class="text-white font-weight-bold followup-columns">Followup By</th>' : ''}
                    <th class="text-white font-weight-bold followup-columns">Followup Date</th>
                    <th class="text-white font-weight-bold">Status</th>
                    ${!isCallCenter ? '<th class="text-white font-weight-bold reassigns-column">Reassigns</th>' : ''}
                    <th class="text-white font-weight-bold">Action</th>
                </tr>
            `;
        } else {
            // Normal view
            headers = `
                <tr>
                    <th class="text-white font-weight-bold">IMEI</th>
                    <th class="text-white font-weight-bold">Vehicle No</th>
                    ${!isCallCenter ? '<th class="text-white font-weight-bold call-center-column">Call Center</th>' : ''}
                    <th class="text-white font-weight-bold">Assigned On</th>
                    <th class="text-white font-weight-bold">Validity Date</th>
                    <th class="text-white font-weight-bold">Days Left</th>
                    <th class="text-white font-weight-bold followup-columns">Followup Date</th>
                    <th class="text-white font-weight-bold">Status</th>
                    ${!isCallCenter ? '<th class="text-white font-weight-bold reassigns-column">Reassigns</th>' : ''}
                    <th class="text-white font-weight-bold">Action</th>
                </tr>
            `;
        }
        
        $('#auto-assignments-table thead').html(headers);
    }
    
    // Initialize table headers
    updateTableHeaders();

    // Load assignments via AJAX
    function loadAssignments(page = 1) {
        // If a search term is present, omit the status filter so search spans all statuses
        const searchVal = $('#filter-search').val().trim();
        const filters = {
            status: searchVal ? '' : $('#filter-status').val(),
            callcenter_id: isCallCenter ? userCallcenterId : $('#filter-callcenter').val(),
            search: searchVal,
            page: page
        };

        $.ajax({
            url: '{{ route("renewal.assignments-list") }}',
            method: 'GET',
            data: filters,
            beforeSend: function() {
                const status = $('#filter-status').val();
                let colspan = 9; // default
                if (status === 'completed') {
                    colspan = isCallCenter ? 9 : 10;
                } else if (status === 'pending') {
                    colspan = isCallCenter ? 10 : 11;
                } else {
                    colspan = isCallCenter ? 8 : 10;
                }
                $('#auto-assignments-table tbody').html(
                    '<tr><td colspan="' + colspan + '" class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</td></tr>'
                );
            },
            success: function(response) {
                console.log('Response:', response);
                if (response.success) {
                    renderTable(response.data);
                    renderPagination(response.pagination);
                } else {
                    const status = $('#filter-status').val();
                    let colspan = 9;
                    if (status === 'completed') {
                        colspan = isCallCenter ? 9 : 10;
                    } else if (status === 'pending') {
                        colspan = isCallCenter ? 10 : 11;
                    } else {
                        colspan = isCallCenter ? 8 : 10;
                    }
                    $('#auto-assignments-table tbody').html(
                        '<tr><td colspan="' + colspan + '" class="text-center text-danger">No data returned</td></tr>'
                    );
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error, xhr.responseText);
                const statusFilter = $('#filter-status').val();
                let colspan = 9;
                if (statusFilter === 'completed') {
                    colspan = isCallCenter ? 9 : 10;
                } else if (statusFilter === 'pending') {
                    colspan = isCallCenter ? 10 : 11;
                } else {
                    colspan = isCallCenter ? 8 : 10;
                }
                $('#auto-assignments-table tbody').html(
                    '<tr><td colspan="' + colspan + '" class="text-center text-danger">Failed to load data: ' + error + '</td></tr>'
                );
            }
        });
    }

    // Render table rows
    function renderTable(data) {
        const tbody = $('#auto-assignments-table tbody');
        const status = $('#filter-status').val();
        const isCompletedFilter = status === 'completed';
        
        if (!data || data.length === 0) {
            let colspan = 9;
            if (isCompletedFilter) {
                colspan = isCallCenter ? 9 : 10;
            } else if (status === 'pending') {
                colspan = isCallCenter ? 10 : 11;
            } else {
                colspan = isCallCenter ? 8 : 10;
            }
            tbody.html('<tr><td colspan="' + colspan + '" class="text-center">No assignments found</td></tr>');
            return;
        }

        let html = '';
        data.forEach(function(item) {
            const daysLeft = item.days_remaining;
            let daysClass, daysDisplay;
            
            if (daysLeft === null || daysLeft === undefined) {
                daysClass = 'days-na';
                daysDisplay = 'N/A';
            } else {
                daysClass = daysLeft < 0 ? 'days-critical' : (daysLeft > 7 ? 'days-ok' : 'days-warning');
                daysDisplay = daysLeft + ' days';
            }
            
            // Check if this specific item is completed (regardless of filter)
            const isItemCompleted = item.followup_status === 'completed';
            
            html += '<tr>';
            html += '<td>' + (item.gps_imei || 'N/A') + '</td>';
            html += '<td>' + (item.vehicle_no || '-') + '</td>';
            if (!isCallCenter) {
                html += '<td>' + item.callcenter_name + '</td>';
            }
            html += '<td>' + formatDateOnly(item.assignment_date) + '</td>';
            html += '<td>' + formatDateOnly(item.validity_date) + '</td>';
            html += '<td class="' + daysClass + '">' + daysDisplay + '</td>';
            
            // Add Note and Followup Date columns when status filter is 'pending' (for both sales and callcenter users)
            if (status === 'pending') {
                html += '<td>' + (item.followup_description || '-') + '</td>';
                // Include Followup By column for call center users
                if (isCallCenter) {
                    html += '<td>' + formatDateOnly(item.next_follow_date) + '</td>';
                }
                // Followup Date (always shown before Status)
                html += '<td>' + formatDateOnly(item.next_follow_date) + '</td>';
            } else {
                // For non-pending rows, always show Followup Date before Status
                html += '<td>' + formatDateOnly(item.next_follow_date) + '</td>';
            }
            
            // Status based on followup_status from controller
            if (item.followup_status === 'completed') {
                html += '<td>Completed</td>';
            } else if (item.followup_status === 'pending') {
                html += '<td><span class="premium-badge badge-pending">Pending</span></td>';
            } else if (item.followup_status === 'assigned') {
                html += '<td><span class="premium-badge badge-assigned">Assigned</span></td>';
            } else if (item.followup_status === 'escalated') {
                html += '<td><span class="premium-badge badge-escalated">Escalated</span></td>';
            } else {
                html += '<td><span class="premium-badge" style="background: #6b7280; color: white;">-</span></td>';
            }
            
            if (isCompletedFilter) {
                // Completed filter view: Show completed date column
                html += '<td>' + formatDateOnly(item.completed_date) + '</td>';
                
                // Action buttons for completed items: Attach Certificate, Download Certificate, Download Invoice
                html += '<td>';
                
                // Attach Certificate button
                html += '<button class="premium-action-btn btn-attach btn-attach-cert" ' +
                        'data-gps-id="' + item.gps_id + '" data-toggle="modal" data-target="#certificateModal">' +
                        '<i class="fas fa-upload"></i> Attach</button> ';
                
                // Download Certificate button (only if certificate exists)
                if (item.warrenty_certificate) {
                    html += '<a href="/uploads/' + item.warrenty_certificate + '" ' +
                            'class="premium-action-btn btn-download-cert" download>' +
                            '<i class="fas fa-file-download"></i> Certificate</a> ';
                }
                
                // Download Invoice button
                html += '<a href="/download-invoice/' + item.gps_id + '" ' +
                        'class="premium-action-btn btn-download-invoice">' +
                        '<i class="fas fa-file-invoice"></i> Invoice</a> ';
                
                // View button
                html += '<a href="/gps-details/' + item.gps_id + '" ' +
                        'class="premium-action-btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">' +
                        '<i class="fas fa-eye"></i> View</a>';
                
                html += '</td>';
            } else {
                // Non-completed filter view (All, Assigned, Pending, Escalated)
                // Show reassigns column for sales users only
                if (!isCallCenter) {
                    html += '<td>' + item.reassignment_count + '/3</td>';
                }
                
                // Action buttons based on item's actual status
                html += '<td>';
                if (isItemCompleted) {
                    // This item is completed - show certificate/invoice buttons
                    html += '<button class="premium-action-btn btn-attach btn-attach-cert" ' +
                            'data-gps-id="' + item.gps_id + '" data-toggle="modal" data-target="#certificateModal">' +
                            '<i class="fas fa-upload"></i> Attach</button> ';
                    
                    if (item.warrenty_certificate) {
                        html += '<a href="/uploads/' + item.warrenty_certificate + '" ' +
                                'class="premium-action-btn btn-download-cert" download>' +
                                '<i class="fas fa-file-download"></i> Certificate</a> ';
                    }
                    
                    html += '<a href="/download-invoice/' + item.gps_id + '" ' +
                            'class="premium-action-btn btn-download-invoice">' +
                            '<i class="fas fa-file-invoice"></i> Invoice</a> ';
                    
                    html += '<a href="/gps-details/' + item.gps_id + '" ' +
                            'class="premium-action-btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">' +
                            '<i class="fas fa-eye"></i> View</a>';
                } else {
                    // This item is not completed - show renew/followup or reassign
                    if (isCallCenter) {
                        // Call Center users: Show Renew, Follow Up
                        html += '<form method="POST" action="/esim-post-renewal" style="display: inline;">' +
                                '{{ csrf_field() }}' +
                                '<input type="hidden" name="id" value="' + item.gps_id + '">' +
                                '<button type="submit" class="premium-action-btn btn-attach">' +
                                '<i class="fas fa-sync"></i> Renew</button>' +
                                '</form> ';
                        html += '<a href="/gps-followup/' + item.gps_id + '" ' +
                                'class="premium-action-btn btn-download-cert">' +
                                '<i class="fas fa-phone"></i> Follow Up</a> ';
                        
                        html += '<a href="/gps-details/' + item.gps_id + '" ' +
                                'class="premium-action-btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">' +
                                '<i class="fas fa-eye"></i> View</a>';
                    } else {
                        // Sales users: Show Reassign button
                        html += '<button class="premium-action-btn btn-reassign btn-reassign-item" ' +
                                'data-id="' + item.id + '" data-gps="' + item.gps_id + '" data-cc="' + item.callcenter_id + '">' +
                                '<i class="fas fa-exchange-alt"></i> Reassign</button> ';
                        
                        html += '<a href="/gps-details/' + item.gps_id + '" ' +
                                'class="premium-action-btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">' +
                                '<i class="fas fa-eye"></i> View</a>';
                    }
                }
                html += '</td>';
            }
            
            html += '</tr>';
        });
        
        tbody.html(html);
        
        // Bind reassign buttons
        $('.btn-reassign-item').on('click', function() {
            selectedAssignmentId = $(this).data('id');
            const gpsId = $(this).data('gps');
            selectedCurrentCc = $(this).data('cc');
            
            // Reset the dropdown - clear value and re-enable all options
            $('#modal-callcenter-select').val('');
            $('#modal-callcenter-select option').prop('disabled', false);
            $('#modal-reason').val('');
            
            // Disable only the current call center option
            $('#modal-callcenter-select option[value="' + selectedCurrentCc + '"]').prop('disabled', true);
            $('.modal-title').text('Reassign GPS ' + gpsId);
            $('#reassignModal').modal('show');
        });
    }

    // Render pagination
    function renderPagination(pagination) {
        if (!pagination || pagination.last_page <= 1) {
            $('#pagination-container').html('');
            return;
        }

        let html = '<ul class="pagination justify-content-center">';
        
        for (let i = 1; i <= pagination.last_page; i++) {
            html += '<li class="page-item ' + (i === pagination.current_page ? 'active' : '') + '">';
            html += '<a class="page-link" href="#" data-page="' + i + '">' + i + '</a>';
            html += '</li>';
        }
        
        html += '</ul>';
        $('#pagination-container').html(html);
        
        // Bind pagination clicks
        $('.page-link').on('click', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            loadAssignments(page);
        });
    }

    // Confirm reassignment
    $('#modal-confirm-reassign').on('click', function() {
        const newCc = $('#modal-callcenter-select').val();
        const reason = $('#modal-reason').val();
        
        if (!newCc) {
            alert('Please select a call center');
            return;
        }
        
        if (newCc == selectedCurrentCc) {
            alert('Please select a different call center');
            return;
        }

        performReassignment(selectedAssignmentId, newCc, reason);
    });

    // Perform reassignment
    function performReassignment(assignmentId, newCc, reason) {
        console.log('=== REASSIGNMENT START ===');
        console.log('Assignment ID:', assignmentId);
        console.log('New Call Center ID:', newCc);
        console.log('Reason:', reason);
        
        const $btn = $('#modal-confirm-reassign');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');

        $.ajax({
            url: '{{ route("renewal.manual-reassign") }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                assignment_id: assignmentId,
                new_callcenter_id: newCc,
                reason: reason
            },
            success: function(response) {
                console.log('=== REASSIGNMENT SUCCESS ===');
                console.log('Response:', response);
                
                $btn.prop('disabled', false).html('Reassign');
                
                if (response.success) {
                    $('#reassignModal').modal('hide');
                    toastr.success(response.message);
                    loadAssignments(currentPage);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                console.error('=== REASSIGNMENT ERROR ===');
                console.error('Status:', xhr.status);
                console.error('Status Text:', xhr.statusText);
                console.error('Response Text:', xhr.responseText);
                console.error('Response JSON:', xhr.responseJSON);
                
                $btn.prop('disabled', false).html('Reassign');
                
                var errorMsg = 'Reassignment failed';
                if(xhr.responseJSON?.message) {
                    errorMsg = xhr.responseJSON.message;
                } else if(xhr.responseJSON?.errors) {
                    errorMsg = Object.values(xhr.responseJSON.errors).join(', ');
                }
                
                console.error('Error message:', errorMsg);
                toastr.error(errorMsg);
            }
        });
    }

    // Format date helper - date only (no time)
    function formatDateOnly(dateStr) {
        if (!dateStr || dateStr === 'N/A' || dateStr === null || dateStr === '0000-00-00') {
            return 'N/A';
        }
        
        try {
            // Parse SQL datetime format: 2026-01-29 14:46:56
            const date = new Date(dateStr);
            
            // Check if date is valid
            if (isNaN(date.getTime())) {
                console.error('Invalid date:', dateStr);
                return 'N/A';
            }
            
            // Format: Jan 29, 2026
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const month = months[date.getMonth()];
            const day = date.getDate();
            const year = date.getFullYear();
            
            return `${month} ${day}, ${year}`;
        } catch (e) {
            console.error('Error formatting date:', dateStr, e);
            return 'Error';
        }
    }
    
    // Handle certificate modal
    $(document).on('click', '.btn-attach-cert', function() {
        var gpsId = $(this).data('gps-id');
        $('#modal_gps_id').val(gpsId);
    });
});
</script>

@endsection
