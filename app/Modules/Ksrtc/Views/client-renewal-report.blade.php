@extends('layouts.eclipse')

@section('content')
<div style="padding:20px; max-width:100%; width:100%;">

    <h3 style="margin-bottom:15px">KSRTC Renewal Report</h3>

    @php
        // chart config
        $size = 750;    // Adjusted canvas size for better layout
        $outerR = 300;  // Adjusted outer radius
        $innerR = 80;   // Adjusted inner radius

        $cx = $size / 2;
        $cy = $size / 2;
        $sliceCount = 12;
        $sliceAngle = 360 / $sliceCount;

        $totalAll = collect($months)->sum('total_installed');
        $totalAmount = collect($months)->sum('amount');

        // Indian number format helper
        $inrFormat = function ($num) {
            $num = (string) ((int) ($num ?? 0));
            return preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))/", "$1,", $num);
        };
    @endphp

    <style>
        .rr-wrap {
            display: flex;
            flex-direction: column;
            gap: 20px;
            align-items: center;
            width: 100%;
        }
        .rr-box {
            width: 100%;
            max-width: 1400px;
        }
        .rr-content {
            display: flex;
            gap: 30px;
            align-items: flex-start;
            justify-content: center;
            width: 100%;
            max-width: 1400px;
        }
        .rr-chart {
            flex: 0 0 750px;
            width: 750px;
        }
        .rr-chart svg {
            width: 100%;
            height: auto;
        }
        .rr-stats-box {
            flex: 0 0 300px;
            width: 300px;
        }
        .stat-card {
            flex: 1;
            min-width: 160px;
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            background: #fff;
            text-align: center;
        }
        .stats-card-vertical {
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            background: #fff;
            margin-bottom: 15px;
            text-align: center;
        }
        .stats-card-vertical:last-child {
            margin-bottom: 0;
        }
        .stats-card-vertical .label {
            font-size: 12px;
            color: #777;
            margin-bottom: 8px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .stats-card-vertical .value {
            font-size: 32px;
            font-weight: 700;
        }
    </style>

    <div class="rr-wrap">

        {{-- 1. DATA BOX (TOP) --}}
        <div class="rr-box">
            <div id="monthBox" style="padding:20px; border:1px solid #ddd; border-radius:15px; background:#fcfcfc; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                <div style="font-weight:700; font-size:18px; margin-bottom:15px;">
                    Month: <span id="mb_month" style="color:#007bff;">{{ $months[0]['month_name'] }}</span>
                </div>

                <div style="display:flex; gap:15px; flex-wrap:wrap;">
                    <div class="stat-card">
                        <div style="font-size:12px; color:#777;">INSTALLED</div>
                        <div id="mb_installed" style="font-size:22px; font-weight:700;">{{ $months[0]['total_installed'] }}</div>
                    </div>
                    <div class="stat-card">
                        <div style="font-size:12px; color:#777;">RENEWAL NEEDED</div>
                        <div id="mb_needed" style="font-size:22px; font-weight:700;">{{ $months[0]['renewal_needed'] }}</div>
                    </div>
                    <div class="stat-card">
                        <div style="font-size:12px; color:#777;">RENEWED</div>
                        <div id="mb_renewed" style="font-size:22px; font-weight:700; color:#28a745;">{{ $months[0]['renewed'] }}</div>
                    </div>
                    <div class="stat-card">
                        <div style="font-size:12px; color:#777;">NOT RENEWED</div>
                        <div id="mb_not" style="font-size:22px; font-weight:700; color:#dc3545;">{{ $months[0]['not_renewed'] }}</div>
                    </div>
                    <div class="stat-card">
                        <div style="font-size:12px; color:#777;">SERVICE VISITS</div>
                        <div id="mb_service" style="font-size:22px; font-weight:700;">{{ $months[0]['service_visits'] }}</div>
                    </div>
                    <div class="stat-card">
                        <div style="font-size:12px; color:#777;">AMOUNT</div>
                        <div id="mb_amount" style="font-size:22px; font-weight:700;">{{ $inrFormat($months[0]['amount'] ?? 0) }}</div>
                    </div>

                </div>
            </div>
        </div>

        {{-- 2. CHART AND STATS SIDE BY SIDE --}}
        <div class="rr-content">
            
            {{-- DONUT CHART (LEFT) --}}
            <div class="rr-chart">
                <svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 {{ $size }} {{ $size }}" style="display:block;">
                    @foreach($months as $i => $m)
                        @php
                            $start = -90 + ($i * $sliceAngle);
                            $end   = $start + $sliceAngle;

                            $startRad = deg2rad($start);
                            $endRad   = deg2rad($end);

                            $x1 = $cx + $outerR * cos($startRad);
                            $y1 = $cy + $outerR * sin($startRad);
                            $x2 = $cx + $outerR * cos($endRad);
                            $y2 = $cy + $outerR * sin($endRad);

                            $x3 = $cx + $innerR * cos($endRad);
                            $y3 = $cy + $innerR * sin($endRad);
                            $x4 = $cx + $innerR * cos($startRad);
                            $y4 = $cy + $innerR * sin($startRad);

                            $path = "M $x1 $y1 A $outerR $outerR 0 0 1 $x2 $y2 L $x3 $y3 A $innerR $innerR 0 0 0 $x4 $y4 Z";

                            // Label positioning - adjusted for smaller circle
                            $mid = deg2rad($start + ($sliceAngle/2));

                            // Month name closer to center
                            $monthR = $innerR + 30;
                            $mx = $cx + $monthR * cos($mid);
                            $my = $cy + $monthR * sin($mid);

                            // Details closer to outer edge
                            $detailsR = $outerR - 65;
                            $dx = $cx + $detailsR * cos($mid);
                            $dy = $cy + $detailsR * sin($mid);

                        @endphp

                        <path d="{{ $path }}"
                              fill="#ffffff"
                              stroke="#222"
                              stroke-width="1"
                              style="cursor:pointer"
                              onmouseenter="this.setAttribute('fill', '#f0f7ff'); setMonthData('{{ $m['month_name'] }}', {{ $m['total_installed'] }}, {{ $m['renewal_needed'] }}, {{ $m['renewed'] }}, {{ $m['not_renewed'] }}, {{ $m['service_visits'] }}, {{ $m['amount'] ?? 0 }})"
                              onmouseleave="this.setAttribute('fill', '#ffffff')"
                        ></path>

                        {{-- Month name (inner side) --}}
                        <text x="{{ $mx }}" y="{{ $my }}" text-anchor="middle" font-size="13" font-weight="800" fill="#000">
                            {{ $m['month_name'] }}
                        </text>

                        {{-- Details (outer side) --}}
                        <text x="{{ $dx }}" y="{{ $dy - 30 }}" text-anchor="middle" font-size="9" font-weight="700" fill="#111">
                            CMC Charge: {{ $inrFormat($m['amount'] ?? 0) }}
                        </text>

                        <text x="{{ $dx }}" y="{{ $dy - 14 }}" text-anchor="middle" font-size="9" font-weight="700" fill="#111">
                            Renewal Needed: {{ $m['renewal_needed'] }}
                        </text>

                        <text x="{{ $dx }}" y="{{ $dy + 0 }}" text-anchor="middle" font-size="9" font-weight="700" fill="#111">
                            Installed: {{ $m['total_installed'] }}
                        </text>

                        <text x="{{ $dx }}" y="{{ $dy + 14 }}" text-anchor="middle" font-size="9" font-weight="700" fill="#111">
                            Service Visits: {{ $m['service_visits'] }}
                        </text>

                        <text x="{{ $dx }}" y="{{ $dy + 28 }}" text-anchor="middle" font-size="9" font-weight="700" fill="#28a745">
                            Renewed: {{ $m['renewed'] }}
                        </text>

                        <text x="{{ $dx }}" y="{{ $dy + 42 }}" text-anchor="middle" font-size="9" font-weight="700" fill="#dc3545">
                            Not Renewed: {{ $m['not_renewed'] }}
                        </text>

                    @endforeach

                    {{-- Center --}}
                    <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $innerR - 5 }}" fill="#fff" stroke="#eee" stroke-width="1"></circle>

                    <text x="{{ $cx }}" y="{{ $cy - 35 }}" text-anchor="middle" font-size="12" fill="#666">Total Installed</text>
                    <text x="{{ $cx }}" y="{{ $cy - 12 }}" text-anchor="middle" font-size="22" font-weight="700" fill="#111">{{ $totalAll }}</text>

                    <text x="{{ $cx }}" y="{{ $cy + 10 }}" text-anchor="middle" font-size="12" fill="#666">Total Service Visits</text>
                    <text x="{{ $cx }}" y="{{ $cy + 28 }}" text-anchor="middle" font-size="16" font-weight="700" fill="#111">{{ $totalservicevisits }}</text>

                    <text x="{{ $cx }}" y="{{ $cy + 48 }}" text-anchor="middle" font-size="12" fill="#666">CMC Charge</text>
                    <text x="{{ $cx }}" y="{{ $cy + 66 }}" text-anchor="middle" font-size="16" font-weight="700" fill="#111">{{ $inrFormat($totalAmount) }}</text>

                </svg>
            </div>

            {{-- NEW STATS BOX (RIGHT) --}}
            <div class="rr-stats-box">
                <div style="font-weight:700; font-size:18px; margin-bottom:20px; color:#333; text-align:center; padding-bottom:15px; border-bottom: 2px solid #e0e0e0;">
                    Additional Statistics
                </div>

                <div class="stats-card-vertical">
                    <div class="label">Not Renewed</div>
                    <div class="value" style="color:#dc3545;">245</div>
                </div>

                <div class="stats-card-vertical">
                    <div class="label">Data Recharged</div>
                    <div class="value" style="color:#007bff;">1,823</div>
                </div>

                <div class="stats-card-vertical">
                    <div class="label">IMEI Tagged by Other Party</div>
                    <div class="value" style="color:#ff9800;">67</div>
                </div>

                <div class="stats-card-vertical">
                    <div class="label">Data Certificate Attached</div>
                    <div class="value" style="color:#009688;">312</div>
                </div>

                <div class="stats-card-vertical">
                    <div class="label">Serviced</div>
                    <div class="value" style="color:#28a745;">{{ $totalservicevisits }}</div>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
    function setMonthData(monthName, installed, renewalNeeded, renewed, notRenewed, serviceVisits, amount) {
        document.getElementById('mb_month').innerText = monthName;
        document.getElementById('mb_installed').innerText = installed;
        document.getElementById('mb_needed').innerText = renewalNeeded;
        document.getElementById('mb_renewed').innerText = renewed;
        document.getElementById('mb_not').innerText = notRenewed;
        document.getElementById('mb_service').innerText = serviceVisits;
        document.getElementById('mb_amount').innerText = Number(amount).toLocaleString('en-IN');
    }
</script>

@endsection