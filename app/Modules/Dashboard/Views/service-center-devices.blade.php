@extends('layouts.eclipse')

@section('content')
<style>
    .sc-page {
        background: #f4f7fb;
        min-height: 100vh;
        padding: 30px 0;
    }
    .sc-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        overflow: hidden;
        background: #ffffff;
    }
    .sc-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 100%);
        padding: 22px 28px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;
    }
    .sc-title {
        margin: 0;
        font-size: 1.35rem;
        font-weight: 700;
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .sc-title i {
        background: rgba(255, 255, 255, 0.2);
        padding: 10px;
        border-radius: 10px;
        font-size: 1.1rem;
    }
    .sc-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #e6fffb;
        font-weight: 600;
        font-size: 0.9rem;
    }
    .sc-pill {
        background: rgba(255, 255, 255, 0.2);
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 0.8rem;
        letter-spacing: 0.3px;
        text-transform: uppercase;
    }
    .sc-body {
        padding: 26px;
        background: #f8fafc;
    }
    .sc-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }
    .sc-back-btn {
        padding: 10px 16px;
        border-radius: 8px;
        font-weight: 600;
        background: #0f172a;
        color: #ffffff;
        border: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .sc-back-btn:hover {
        background: #111827;
        transform: translateY(-1px);
        color: #ffffff;
    }
    .sc-table-wrap {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }
    .sc-table {
        margin: 0;
    }
    .sc-table thead {
        background: #1e3a8a;
    }
    .sc-table thead th {
        color: #ffffff;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.6px;
        padding: 16px 14px;
        border: none;
    }
    .sc-table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #f1f5f9;
    }
    .sc-table tbody tr:hover {
        background: #f8fafc;
        box-shadow: inset 0 0 0 999px rgba(15, 23, 42, 0.03);
    }
    .sc-table tbody td {
        padding: 16px 14px;
        vertical-align: middle;
        color: #1f2937;
        font-size: 0.9rem;
    }
    .sc-badge {
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        display: inline-block;
    }
    .sc-badge-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff;
    }
    .sc-badge-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #ffffff;
    }
    .sc-empty {
        background: #ffffff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.06);
        color: #475569;
        font-weight: 600;
    }
    .sc-pagination {
        margin-top: 18px;
    }
</style>

<div class="container-fluid sc-page">
    <div class="row">
        <div class="col-lg-12">
            <div class="sc-card">
                <div class="sc-header">
                    <h4 class="sc-title">
                        <i class="fa fa-cogs"></i>
                        {{ $serviceCenterName }}
                    </h4>
                    <div class="sc-meta">
                        <span class="sc-pill">{{ $typeTitle }}</span>
                        <span>{{ $devices->total() }} Devices</span>
                    </div>
                </div>
                <div class="sc-body">
                    <div class="sc-toolbar">
                        <div style="font-weight:700; color:#0f172a;">
                            Service Center Device List
                        </div>
                        <a href="{{ route('dashboard') }}" class="sc-back-btn">
                            <i class="fa fa-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>

                    @if($devices->count() > 0)
                        <div class="table-responsive sc-table-wrap">
                            <table class="table sc-table">
                                <thead>
                                    <tr>
                                        <th>IMEI</th>
                                        <th>Vehicle No</th>
                                        <th>Customer Name</th>
                                        <th>{{ $type == 'device_out' ? 'Delivery Address' : 'Address' }}</th>
                                        @if($type == 'device_out')
                                            <th>Delivery Service</th>
                                            <th>Delivery Details</th>
                                        @endif
                                        <th>Service In Date</th>
                                        <th>{{ $type == 'device_out' ? 'Delivery Date' : 'Status / Delivery Date' }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($devices as $device)
                                        <tr>
                                            <td>{{ $device->imei }}</td>
                                            <td>{{ $device->vehicle_no }}</td>
                                            <td>{{ $device->customer_name }}</td>
                                            <td>{{ $type == 'device_out' ? ($device->deliveryadddress ?: '-') : ($device->address ?: '-') }}</td>
                                            @if($type == 'device_out')
                                                <td>{{ $device->deliveryservice ?: '-' }}</td>
                                                <td>{{ $device->deliverydetails ?: '-' }}</td>
                                            @endif
                                            <td>{{ $device->date ? \Carbon\Carbon::parse($device->date)->format('d-m-Y') : '-' }}</td>
                                            <td>
                                                @if($type == 'device_out')
                                                    {{ $device->delivery_date ? \Carbon\Carbon::parse($device->delivery_date)->format('d-m-Y') : '-' }}
                                                @else
                                                    @if($device->status == 'delivered' && $device->delivery_date)
                                                        <span class="sc-badge sc-badge-success">Delivered: {{ \Carbon\Carbon::parse($device->delivery_date)->format('d-m-Y') }}</span>
                                                    @else
                                                        <span class="sc-badge sc-badge-warning">{{ ucfirst($device->status) }}</span>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center sc-pagination">
                            {{ $devices->appends(['service_center_id' => $serviceCenterId, 'type' => $type])->links() }}
                        </div>
                    @else
                        <div class="sc-empty">
                            <i class="fa fa-info-circle"></i> No devices found for this filter.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
