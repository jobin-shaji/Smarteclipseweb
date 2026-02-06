@extends('layouts.eclipse')

@section('content')
<div style="padding:20px; max-width:1400px; margin:0 auto;">

    <div style="margin-bottom:20px;">
        <a href="{{ route('client.renewal.report2') }}" style="color:#007bff; text-decoration:none; font-size:14px;">
            ← Back to Report
        </a>
    </div>

    <h3 style="margin-bottom:25px; color:#333;">Period Details: {{ $title }}</h3>

    {{-- Summary Box --}}
    <div style="padding:25px; border:1px solid #ddd; border-radius:12px; background:#f8f9fa; margin-bottom:30px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <div style="display:flex; gap:30px; flex-wrap:wrap; justify-content:space-around;">
            <div style="text-align:center; min-width:150px;">
                <div style="font-size:12px; color:#777; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">CMC Charge</div>
                <div style="font-size:28px; font-weight:700; color:#111;">₹{{ number_format($cmcCharge) }}</div>
            </div>
            <div style="text-align:center; min-width:150px;">
                <div style="font-size:12px; color:#777; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">Renewal Needed</div>
                <div style="font-size:28px; font-weight:700; color:#007bff;">{{ number_format($eligibleCount) }}</div>
            </div>
            <div style="text-align:center; min-width:150px;">
                <div style="font-size:12px; color:#777; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">Certificate Attached</div>
                <div style="font-size:28px; font-weight:700; color:#009688;">{{ number_format($certificateCount) }}</div>
            </div>
            <div style="text-align:center; min-width:150px;">
                <div style="font-size:12px; color:#777; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">Serviced</div>
                <div style="font-size:28px; font-weight:700; color:#28a745;">{{ number_format($servicedCount) }}</div>
            </div>
        </div>
    </div>

    {{-- Devices Needing Renewal Table --}}
    <div style="margin-bottom:40px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
            <h4 style="margin:0; color:#333; font-size:18px; font-weight:600;">Devices Needing Renewal ({{ number_format($renewalVehicles->count()) }})</h4>
            <div>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('client.renewal.report2.period.export_renewal', ['year' => $year ?? date('Y'), 'month' => $month ?? date('n')]) }}">Export Renewal CSV</a>
            </div>
        </div>
        <div style="border:1px solid #ddd; border-radius:8px; overflow:hidden; background:#fff;">
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f8f9fa; border-bottom:2px solid #dee2e6;">
                            <th style="padding:12px 15px; text-align:left; font-size:13px; font-weight:600; color:#495057;">SL No</th>
                            <th style="padding:12px 15px; text-align:left; font-size:13px; font-weight:600; color:#495057;">Vehicle No</th>
                            <th style="padding:12px 15px; text-align:left; font-size:13px; font-weight:600; color:#495057;">IMEI</th>
                            <th style="padding:12px 15px; text-align:left; font-size:13px; font-weight:600; color:#495057;">Installed At</th>
                            <th style="padding:12px 15px; text-align:center; font-size:13px; font-weight:600; color:#495057;">Certificate Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($renewalVehicles as $index => $vehicle)
                        <tr style="border-bottom:1px solid #e9ecef;">
                            <td style="padding:12px 15px; font-size:14px; color:#212529;">{{ $index + 1 }}</td>
                            <td style="padding:12px 15px; font-size:14px; color:#212529; font-weight:500;">{{ $vehicle->vehicle_no }}</td>
                            <td style="padding:12px 15px; font-size:14px; color:#495057;">{{ $vehicle->imei }}</td>
                            <td style="padding:12px 15px; font-size:14px; color:#495057;">{{ \Carbon\Carbon::parse($vehicle->installation_date)->format('Y-m-d') }}</td>
                            <td style="padding:12px 15px; text-align:center;">
                                @if($vehicle->certificate_status === 'Yes')
                                    <span style="display:inline-block; padding:4px 12px; background:#d4edda; color:#155724; border-radius:4px; font-size:12px; font-weight:600;">Yes</span>
                                @else
                                    <span style="display:inline-block; padding:4px 12px; background:#f8d7da; color:#721c24; border-radius:4px; font-size:12px; font-weight:600;">No</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="padding:30px; text-align:center; color:#6c757d; font-size:14px;">
                                No devices found for renewal in this period.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Service Records Table --}}
    <div style="margin-bottom:40px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
            <h4 style="margin:0; color:#333; font-size:18px; font-weight:600;">Service Records ({{ number_format($serviceRecords->count()) }})</h4>
            <div>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('client.renewal.report2.period.export_service', ['year' => $year ?? date('Y'), 'month' => $month ?? date('n')]) }}">Export Service CSV</a>
            </div>
        </div>
        <div style="border:1px solid #ddd; border-radius:8px; overflow:hidden; background:#fff;">
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f8f9fa; border-bottom:2px solid #dee2e6;">
                            <th style="padding:12px 15px; text-align:left; font-size:13px; font-weight:600; color:#495057;">SL No</th>
                            <th style="padding:12px 15px; text-align:left; font-size:13px; font-weight:600; color:#495057;">Vehicle No</th>
                            <th style="padding:12px 15px; text-align:left; font-size:13px; font-weight:600; color:#495057;">IMEI</th>
                            <th style="padding:12px 15px; text-align:left; font-size:13px; font-weight:600; color:#495057;">Service Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($serviceRecords as $index => $record)
                        <tr style="border-bottom:1px solid #e9ecef;">
                            <td style="padding:12px 15px; font-size:14px; color:#212529;">{{ $index + 1 }}</td>
                            <td style="padding:12px 15px; font-size:14px; color:#212529; font-weight:500;">{{ $record->vehicle_no }}</td>
                            <td style="padding:12px 15px; font-size:14px; color:#495057;">{{ $record->imei }}</td>
                            <td style="padding:12px 15px; font-size:14px; color:#495057;">{{ \Carbon\Carbon::parse($record->service_date)->format('Y-m-d') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="padding:30px; text-align:center; color:#6c757d; font-size:14px;">
                                No service records found for this period.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
