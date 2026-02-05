@extends('layouts.eclipse')

@section('content')
<div style="padding:20px; max-width:100%; width:100%;">

    <h3 style="margin-bottom:15px">KSRTC Renewal Report V2 (Testing New Logic)</h3>

    @php
        // chart config
        $size = 750;    // Adjusted canvas size for better layout
        $outerR = 300;  // Adjusted outer radius
        $innerR = 80;   // Adjusted inner radius

        $cx = $size / 2;
        $cy = $size / 2;
        $sliceCount = 12;
        $sliceAngle = 360 / $sliceCount;

        // Use new data structure
        $totalInstalls = collect($installMonths)->sum('installed_count');
        $totalAmount = collect($billingPeriods)->sum('amount');
        $totalRenewalNeeded = collect($billingPeriods)->sum('renewal_needed');

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
                    Period: <span id="mb_month" style="color:#007bff;">{{ $billingPeriods[0]['title'] }}</span>
                </div>

                <div style="display:flex; gap:15px; flex-wrap:wrap;">
                    <div class="stat-card">
                        <div style="font-size:12px; color:#777;">INSTALLED</div>
                        <div id="mb_installed" style="font-size:22px; font-weight:700;">{{ $billingPeriods[0]['installed_count'] }}</div>
                    </div>
                    <div class="stat-card">
                        <div style="font-size:12px; color:#777;">CMC CHARGE APPLICABLE</div>
                        <div id="mb_needed" style="font-size:22px; font-weight:700;">{{ $billingPeriods[0]['renewal_needed'] }}</div>
                    </div>
                    <div class="stat-card">
                        <div style="font-size:12px; color:#777;">RENEWED</div>
                        <div id="mb_renewed" style="font-size:22px; font-weight:700; color:#28a745;">{{ $billingPeriods[0]['renewed'] }}</div>
                    </div>
                    <div class="stat-card">
                        <div style="font-size:12px; color:#777;">NOT RENEWED</div>
                        <div id="mb_not_renamed" style="font-size:22px; font-weight:700; color:#dc3545;">{{ $billingPeriods[0]['not_renewed'] }}</div>
                    </div>
                    <div class="stat-card">
                        <div style="font-size:12px; color:#777;">SERVICE VISITS</div>
                        <div id="mb_service" style="font-size:22px; font-weight:700;">{{ $billingPeriods[0]['service_visits'] }}</div>
                    </div>
                    <div class="stat-card">
                        <div style="font-size:12px; color:#777;">AMOUNT (Rs.)</div>
                        <div id="mb_amount" style="font-size:22px; font-weight:700;">{{ $inrFormat($billingPeriods[0]['amount'] ?? 0) }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. CHART AND STATS SIDE BY SIDE --}}
        <div class="rr-content">
            
            {{-- DONUT CHART (LEFT) --}}
            <div class="rr-chart">
                <svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 {{ $size }} {{ $size }}" style="display:block;">
                    @foreach($billingPeriods as $i => $period)
                        @php
                            // Determine if this slice corresponds to the current calendar month
                            $abbr = substr($period['title'], 0, 3); // e.g. 'Feb'
                            $nowAbbr = \Carbon\Carbon::now()->format('M');
                            $isCurrentSlice = ($abbr === $nowAbbr);
                            $sliceFill = $isCurrentSlice ? '#e6fff2' : '#ffffff';
                            $sliceHover = $isCurrentSlice ? '#ccffd8' : '#f0f7ff';
                        @endphp
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

                            // Label positioning
                            $mid = deg2rad($start + ($sliceAngle/2));

                            // Period title closer to center
                            $monthR = $innerR + 30;
                            $mx = $cx + $monthR * cos($mid);
                            $my = $cy + $monthR * sin($mid);

                            // Details - moved more towards center
                            $detailsR = $outerR - 65;
                            $dx = $cx + $detailsR * cos($mid);
                            $dy = $cy + $detailsR * sin($mid);

                        @endphp

                        <path d="{{ $path }}"
                            fill="{{ $sliceFill }}"
                            stroke="#222"
                            stroke-width="1"
                            style="cursor:pointer"
                            onmouseenter="this.setAttribute('fill', '{{ $sliceHover }}'); setPeriodData('{{ $period['title'] }}', {{ $period['installed_count'] }}, {{ $period['renewal_needed'] }}, {{ $period['renewed'] }}, {{ $period['not_renewed'] }}, {{ $period['service_visits'] }}, {{ $period['amount'] ?? 0 }})"
                            onmouseleave="this.setAttribute('fill', '{{ $sliceFill }}')"
                        ></path>

                        {{-- Period title (inner side) --}}
                        <text x="{{ $mx }}" y="{{ $my }}" text-anchor="middle" font-size="11" font-weight="800" fill="#000">
                            {{ $period['title'] }}
                        </text>

                        {{-- Details (outer side) --}}
                        <text x="{{ $dx }}" y="{{ $dy - 26 }}" text-anchor="middle" font-size="9" font-weight="700" fill="#111">
                            CMC Charge: {{ $inrFormat($period['amount'] ?? 0) }}
                        </text>

                        <text x="{{ $dx }}" y="{{ $dy - 14 }}" text-anchor="middle" font-size="9" font-weight="700" fill="#007bff">
                            Renewal Needed: {{ $period['renewal_needed'] }}
                        </text>

                        <text x="{{ $dx }}" y="{{ $dy - 2 }}" text-anchor="middle" font-size="9" font-weight="700" fill="#333">
                            Installed: {{ $period['installed_count'] }}
                        </text>

                        <text x="{{ $dx }}" y="{{ $dy + 10 }}" text-anchor="middle" font-size="9" font-weight="700" fill="#666">
                            Service Visits: {{ $period['service_visits'] }}
                        </text>

                        <text x="{{ $dx }}" y="{{ $dy + 22 }}" text-anchor="middle" font-size="9" font-weight="700" fill="#28a745">
                            Renewed: {{ $period['renewed'] }}
                        </text>

                        <text x="{{ $dx }}" y="{{ $dy + 34 }}" text-anchor="middle" font-size="9" font-weight="700" fill="#dc3545">
                            Not Renewed: {{ $period['not_renewed'] }}
                        </text>

                    @endforeach

                    {{-- Center --}}
                    <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $innerR - 5 }}" fill="#fff" stroke="#eee" stroke-width="1"></circle>

                    <text x="{{ $cx }}" y="{{ $cy - 35 }}" text-anchor="middle" font-size="12" fill="#666">Total Installs</text>
                    <text x="{{ $cx }}" y="{{ $cy - 12 }}" text-anchor="middle" font-size="22" font-weight="700" fill="#111">{{ $totalInstalls }}</text>

                    <text x="{{ $cx }}" y="{{ $cy + 10 }}" text-anchor="middle" font-size="12" fill="#666">Total Service Visits</text>
                    <text x="{{ $cx }}" y="{{ $cy + 28 }}" text-anchor="middle" font-size="16" font-weight="700" fill="#111">{{ $totalservicevisits }}</text>

                    <text x="{{ $cx }}" y="{{ $cy + 48 }}" text-anchor="middle" font-size="12" fill="#666">CMC Charge</text>
                    <text x="{{ $cx }}" y="{{ $cy + 66 }}" text-anchor="middle" font-size="16" font-weight="700" fill="#111">{{ $inrFormat($totalAmount) }}</text>

                </svg>
            </div>

            {{-- NEW STATS BOX (RIGHT) - Additional Statistics (copied from main report) --}}
            <div class="rr-stats-box">
                <div style="font-weight:700; font-size:18px; margin-bottom:20px; color:#333; text-align:center; padding-bottom:15px; border-bottom: 2px solid #e0e0e0;">
                    Additional Statistics
                </div>

                <div class="stats-card-vertical">
                    <div class="label">Data Recharged</div>
                    <div class="value" style="color:#007bff;">{{ number_format($additionalStats['data_recharged'] ?? 0) }}</div>
                </div>

                <div class="stats-card-vertical">
                    <div class="label">Not Renewed</div>
                    <div class="value" style="color:#dc3545;">{{ number_format($additionalStats['not_renewed'] ?? 0) }}</div>
                </div>

                <div class="stats-card-vertical">
                    <div class="label">Data Certificate Attached</div>
                    <div class="value" style="color:#009688;">{{ number_format($additionalStats['data_certificate_attached'] ?? 0) }}</div>
                </div>

                <div class="stats-card-vertical">
                    <div class="label">IMEI Untagged</div>
                    <div class="value" style="color:#ff9800;">{{ number_format($additionalStats['imei_untagged'] ?? 0) }}</div>
                </div>

                <div class="stats-card-vertical">
                    <div class="label">Replaced by uni140</div>
                    <div class="value" style="color:#6f42c1;">{{ number_format($additionalStats['replaced_by_uni140'] ?? 0) }}</div>
                </div>

                <div class="stats-card-vertical">
                    <div class="label">Serviced</div>
                    <div class="value" style="color:#28a745;">{{ number_format($totalservicevisits ?? 0) }}</div>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
    function setPeriodData(periodTitle, installedCount, renewalNeeded, renewed, notRenewed, serviceVisits, amount) {
        document.getElementById('mb_month').innerText = periodTitle;
        document.getElementById('mb_installed').innerText = installedCount;
        document.getElementById('mb_needed').innerText = renewalNeeded;
        document.getElementById('mb_renewed').innerText = renewed;
        document.getElementById('mb_not_renamed').innerText = notRenewed;
        document.getElementById('mb_service').innerText = serviceVisits;
        document.getElementById('mb_amount').innerText = Number(amount).toLocaleString('en-IN');
    }
</script>

@endsection