@extends('layouts.eclipse')

@section('title')
KSRTC Devices by Period
@endsection

@section('content')
<style>
    /* Modern minimalist styling */
    .dashboard-wrapper {
        display: flex;
        min-height: 80vh;
        background: #f8fafc;
        font-family: 'Inter', sans-serif;
    }

    /* Left Sidebar */
    .sidebar {
        width: 260px;
        background: #ffffff;
        border-right: 1px solid #e2e8f0;
        padding: 20px;
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
        /* keep sidebar within viewport so inner list can scroll */
        max-height: calc(100vh - 40px);
    }

    .sidebar h3 {
        font-size: 0.9rem;
        text-transform: uppercase;
        color: #64748b;
        letter-spacing: 0.05em;
        margin-bottom: 20px;
    }

    .period-box {
        padding: 12px 16px;
        margin-bottom: 8px;
        border-radius: 8px;
        border: 1px solid transparent;
        transition: all 0.2s ease;
        font-weight: 500;
        color: #334155;
        background: #f1f5f9;
        cursor: pointer;
    }

    /* Scrollable container for period boxes */
    .period-boxes {
        overflow-y: auto;
        flex: 1 1 auto;
        padding-right: 6px; /* give some room for scrollbar */
    }

    .period-box:hover {
        background: #e2e8f0;
    }

    /* Right Content Area */
    .main-panel {
        flex: 1;
        padding: 30px;
    }

    /* Top Widget */
    .summary-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        display: none; /* Controlled by JS */
        border-left: 4px solid #3b82f6;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-top: 10px;
    }

    .summary-item label {
        display: block;
        font-size: 0.75rem;
        color: #94a3b8;
        text-transform: uppercase;
    }

    .summary-item span {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
    }

    /* Table container styling */
    .table-container {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .dataTables_wrapper .dataTables_length, 
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 15px;
    }

    table.dataTable thead th {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0 !important;
        color: #475569;
        font-weight: 600;
    }
</style>

<div class="dashboard-wrapper">
    <aside class="sidebar">
        <h3>Periods</h3>
        <div class="period-boxes">
            @foreach($periods as $p)
                <div class="period-box" data-id="{{ $p->id }}" data-title="{{ $p->title }}">
                    {{ \Carbon\Carbon::parse($p->period_start)->format('M Y') }} - {{ \Carbon\Carbon::parse($p->period_end)->format('M Y') }}
                </div>
            @endforeach
        </div>
    </aside>

    <main class="main-panel">
        <div id="periodWidget" class="summary-card">
            <h4 id="periodTitle" style="margin:0 0 15px 0; color: #3b82f6;"></h4>
            <div class="summary-grid">
                <div class="summary-item">
                    <label>Total Devices</label>
                    <span id="periodCount">0</span>
                </div>
                <div class="summary-item">
                    <label>Total Amount</label>
                    <span>₹<span id="periodAmount">0</span></span>
                </div>
            </div>
        </div>

        <div class="table-container">
            <div class="table-header" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                <h3 style="margin:0;">All Devices</h3>
                <button id="exportExcelBtn" class="btn btn-sm" style="background:#3b82f5;border-color:#93c5fd;color:#ffffff;font-weight:600;">Excel</button>
            </div>
            <table class="table table-hover" id="devicesTable" style="width:100%;">
                <thead>
                    <tr>
                        <th>SL No</th>
                        <th>Vehicle No</th>
                        <th>IMEI</th>
                        <th>Installed At</th>
                    </tr>
                </thead>
            </table>
        </div>
    </main>
</div>
@endsection

@section('script')
<script>
$(function(){
    var selectedPeriod = null;

    var table = $('#devicesTable').DataTable({
        processing: true,
        serverSide: true,
        deferLoading: 0,
        ajax: {
            url: "{{ route('ksrtc.cmc.devices.list') }}",
            data: function(d){
                if (selectedPeriod) {
                    d.period_id = selectedPeriod;
                }
            }
        },
        columns: [
            { data: 'DT_RowIndex', orderable:false, searchable:false },
            { data: 'vehicle_no' },
            { data: 'imei' },
            { data: 'installation_date' }
        ]
    });

    $('.period-box').on('click', function(){
        // Reset styles for all boxes
        $('.period-box').css({'background':'','color':'','border-color':''});
        
        // Modern "Active" state
        $(this).css({
            'background':'#3b82f6',
            'color':'#ffffff',
            'border-color': '#2563eb'
        });

        selectedPeriod = $(this).data('id');
        var title = $(this).data('title') || '';
        
        $.getJSON("{{ route('ksrtc.cmc.devices.summary') }}", { period_id: selectedPeriod })
            .done(function(res){
                $('#periodTitle').text(res.title || title);
                $('#periodCount').text(res.count);
                // Format amount using Indian numbering (en-IN)
                var amt = Number(res.amount) || 0;
                $('#periodAmount').text(amt.toLocaleString('en-IN'));
                $('#periodWidget').fadeIn(); // Smoother transition
            })
            .fail(function(){
                $('#periodWidget').hide();
            });
        table.ajax.reload();
    });

    $('#exportExcelBtn').on('click', function(){
        if (!selectedPeriod) {
            alert('Please select a period to export');
            return;
        }
        var url = "{{ route('ksrtc.cmc.devices.export') }}" + '?period_id=' + selectedPeriod;
        window.location = url;
    });

    var first = $('.period-box').first();
    if(first.length){
        first.click();
    }
});
</script>
@endsection