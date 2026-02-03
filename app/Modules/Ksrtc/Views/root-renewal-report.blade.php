@extends('layouts.eclipse')

@section('content')
<div class="container" style="padding:20px">

    <h3 style="margin-bottom:15px">Total Renewal Report</h3>

    @php
        // chart config
        $size = 900;    // Increased canvas size to fit larger labels
        $outerR = 350;  // Increased outer radius (larger circle)
        $innerR = 90;   // Decreased inner radius (smaller hole)

        $cx = $size / 2;
        $cy = $size / 2;
        $sliceCount = 12;
        $sliceAngle = 360 / $sliceCount;

        $totalAll = collect($months)->sum('total_installed');
    @endphp

    <style>
        .rr-wrap {
            display: flex;
            flex-direction: column; /* Puts box on top, chart below */
            gap: 0px;
            align-items: center;
        }
        .rr-box {
            width: 100%;
            max-width: 1100px;
        }
        .rr-chart {
            width: 100%;
            max-width: 750px;
            display: flex;
            justify-content: center;
        }
        .rr-chart svg {
            width: 100%;
            height: auto;
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
                        <div style="font-size:12px; color:#777;">SERVICE </div>
                        <div id="mb_service" style="font-size:22px; font-weight:700;">{{ $months[0]['service_visits'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. LARGE DONUT CHART (BOTTOM) --}}
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

                        $mid = deg2rad($start + ($sliceAngle/2));

                        // Month name closer to center
                        $monthR = $innerR + 35;
                        $mx = $cx + $monthR * cos($mid);
                        $my = $cy + $monthR * sin($mid);

                        // Details closer to outer edge
                        $detailsR = $outerR - 80;
                        $dx = $cx + $detailsR * cos($mid);
                        $dy = $cy + $detailsR * sin($mid);
                    @endphp

                    <path d="{{ $path }}"
                          fill="#ffffff"
                          stroke="#222"
                          stroke-width="1"
                          style="cursor:pointer"
                          onmouseenter="this.setAttribute('fill', '#f0f7ff'); setMonthData('{{ $m['month_name'] }}', {{ $m['total_installed'] }}, {{ $m['renewal_needed'] }}, {{ $m['renewed'] }}, {{ $m['not_renewed'] }}, {{ $m['service_visits'] }})"
                          onmouseleave="this.setAttribute('fill', '#ffffff')"
                    ></path>

                    {{-- Month name (inner side) --}}
                    <text x="{{ $mx }}" y="{{ $my }}" text-anchor="middle" font-size="14" font-weight="800" fill="#000">
                        {{ $m['month_name'] }}
                    </text>

                    {{-- Details (outer side) --}}
                    <text x="{{ $dx }}" y="{{ $dy - 30 }}" text-anchor="middle" font-size="10" font-weight="800" fill="#111">
                        Renewal Needed: {{ $m['renewal_needed'] }}
                    </text>

                    <text x="{{ $dx }}" y="{{ $dy - 14 }}" text-anchor="middle" font-size="10" font-weight="800" fill="#111">
                        Installed: {{ $m['total_installed'] }}
                    </text>

                    <text x="{{ $dx }}" y="{{ $dy + 0 }}" text-anchor="middle" font-size="10" font-weight="800" fill="#111">
                        Service : {{ $m['service_visits'] }}
                    </text>

                    <text x="{{ $dx }}" y="{{ $dy + 14 }}" text-anchor="middle" font-size="10" font-weight="800" fill="#28a745">
                        Renewed: {{ $m['renewed'] }}
                    </text>

                    <text x="{{ $dx }}" y="{{ $dy + 28 }}" text-anchor="middle" font-size="10" font-weight="800" fill="#dc3545">
                        Not Renewed: {{ $m['not_renewed'] }}
                    </text>
                @endforeach

                {{-- Center --}}
                <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $innerR - 5 }}" fill="#fff" stroke="#eee" stroke-width="1"></circle>

                <text x="{{ $cx }}" y="{{ $cy - 35 }}" text-anchor="middle" font-size="12" fill="#666">Total Installed</text>
                <text x="{{ $cx }}" y="{{ $cy - 12 }}" text-anchor="middle" font-size="22" font-weight="700" fill="#111">{{ $totalAll }}</text>

                <text x="{{ $cx }}" y="{{ $cy + 10 }}" text-anchor="middle" font-size="12" fill="#666">Total Service </text>
                <text x="{{ $cx }}" y="{{ $cy + 28 }}" text-anchor="middle" font-size="16" font-weight="700" fill="#111">{{ $totalservicevisits }}</text>
            </svg>
        </div>

    </div>
</div>

<script>
    function setMonthData(monthName, installed, renewalNeeded, renewed, notRenewed, serviceVisits) {
        document.getElementById('mb_month').innerText = monthName;
        document.getElementById('mb_installed').innerText = installed;
        document.getElementById('mb_needed').innerText = renewalNeeded;
        document.getElementById('mb_renewed').innerText = renewed;
        document.getElementById('mb_not').innerText = notRenewed;
        document.getElementById('mb_service').innerText = serviceVisits;
    }
</script>
@endsection
