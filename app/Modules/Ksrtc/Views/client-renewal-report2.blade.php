@extends('layouts.eclipse')

@section('content')
<div style="padding:20px; max-width:100%; width:100%;">

    <h3 style="margin-bottom:15px">KSRTC Renewal Report</h3>

    <style>
        .rr-wrap {
            display: flex;
            flex-direction: column;
            gap: 20px;
            align-items: center;
            width: 100%;
        }
        .rr-content {
            display: flex;
            gap: 30px;
            align-items: flex-start;
            justify-content: center;
            width: 100%;
            max-width: 1500px;
        }
        .rr-chart {
            flex: 0 0 850px;
            width: 850px;
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
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .stats-card-vertical:last-child {
            margin-bottom: 0;
        }
        .stats-card-vertical:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border-color: #007bff;
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
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            font-size: 24px;
            font-weight: 700;
            color: #007bff;
        }
        .loading-overlay.hidden {
            display: none;
        }
        .chart-header {
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 10px;
            color: #333;
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0e0e0;
        }
        .chart-header label {
            font-size: 16px;
            font-weight: 600;
            margin-right: 10px;
        }
        .chart-header select {
            padding: 8px 15px;
            font-size: 16px;
            border: 2px solid #007bff;
            border-radius: 8px;
            background: white;
            cursor: pointer;
            outline: none;
        }
        .chart-header select:focus {
            border-color: #0056b3;
            box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
        }
    </style>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="loading-overlay">
        <div>
            <div style="margin-bottom:10px">Loading...</div>
            <div style="font-size:14px; color:#666">Please wait while we fetch the data</div>
        </div>
    </div>

    <div class="rr-wrap" id="reportContent" style="display:none;">

        {{-- CHART AND STATS SIDE BY SIDE --}}
        <div class="rr-content">
            
            {{-- DONUT CHART (LEFT) --}}
            <div class="rr-chart">
                <div class="chart-header">
                    <label for="yearSelect">Select Year:</label>
                    <select id="yearSelect">
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026" selected>2026</option>
                    </select>
                </div>
                <svg id="chartSvg" width="850" height="850" viewBox="0 0 850 850" style="display:block;">
                    <!-- Chart will be rendered here by JavaScript -->
                </svg>
            </div>

            {{-- STATS BOX (RIGHT) --}}
            <div class="rr-stats-box">
                <div style="font-weight:700; font-size:18px; margin-bottom:20px; color:#333; text-align:center; padding-bottom:15px; border-bottom: 2px solid #e0e0e0;">
                    Total Statistics
                </div>

                <div class="stats-card-vertical" onclick="window.location.href='{{ route('client.renewal.report2.all-vehicles') }}'">
                    <div class="label">Total Data Recharged</div>
                    <div id="stat_recharged" class="value" style="color:#007bff;">0</div>
                </div>

                <div class="stats-card-vertical" onclick="window.location.href='{{ route('client.renewal.report2.vehicles-with-certificate') }}'">
                    <div class="label">Total Certificate Attached</div>
                    <div id="stat_certificate" class="value" style="color:#009688;">0</div>
                </div>

                <div class="stats-card-vertical" onclick="window.location.href='{{ route('client.renewal.report2.replaced-by-uni140') }}'">
                    <div class="label">Replaced by uni140</div>
                    <div id="stat_replaced" class="value" style="color:#6f42c1;">0</div>
                </div>

                <div class="stats-card-vertical" onclick="window.location.href='{{ route('client.renewal.report2.service-report') }}'">
                    <div class="label">Serviced</div>
                    <div id="stat_serviced" class="value" style="color:#28a745;">0</div>
                </div>

                <div class="stats-card-vertical" onclick="window.location.href='{{ route('client.renewal.report2.not-paid') }}'">
                    <div class="label">Not Paid</div>
                    <div id="stat_not_paid" class="value" style="color:#dc3545;">0</div>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
    // Global data storage
    let reportData = null;

    // Indian number format
    function formatINR(num) {
        num = String(parseInt(num || 0));
        return num.replace(/(\d+?)(?=(\d\d)+(\d)(?!\d))/g, "$1,");
    }

    // Number format with commas
    function formatNumber(num) {
        return parseInt(num || 0).toLocaleString('en-IN');
    }

    // Function to render the donut chart
    function renderChart(data) {
        const size = 850;
        const outerR = 350;
        const innerR = 90;
        const cx = size / 2;
        const cy = size / 2;
        const sliceCount = 12;
        const sliceAngle = 360 / sliceCount;

        const billingPeriods = data.billingPeriods;
        const installMonths = data.installMonths;
        const totalservicevisits = data.totalservicevisits;

        // Calculate totals
        const totalInstalls = installMonths.reduce((sum, m) => sum + m.installed_count, 0);
        const totalAmount = billingPeriods.reduce((sum, p) => sum + (p.amount || 0), 0);
        const totalRenewalNeeded = billingPeriods.reduce((sum, p) => sum + p.renewal_needed, 0);

        let svg = '';

        // Render slices
        billingPeriods.forEach((period, i) => {
            const start = -90 + (i * sliceAngle);
            const end = start + sliceAngle;

            const startRad = start * Math.PI / 180;
            const endRad = end * Math.PI / 180;

            const x1 = cx + outerR * Math.cos(startRad);
            const y1 = cy + outerR * Math.sin(startRad);
            const x2 = cx + outerR * Math.cos(endRad);
            const y2 = cy + outerR * Math.sin(endRad);

            const x3 = cx + innerR * Math.cos(endRad);
            const y3 = cy + innerR * Math.sin(endRad);
            const x4 = cx + innerR * Math.cos(startRad);
            const y4 = cy + innerR * Math.sin(startRad);

            const path = `M ${x1} ${y1} A ${outerR} ${outerR} 0 0 1 ${x2} ${y2} L ${x3} ${y3} A ${innerR} ${innerR} 0 0 0 ${x4} ${y4} Z`;

            // Check if current month AND current year
            const abbr = period.title.substring(0, 3);
            const yearInTitle = period.title.substring(4, 6); // Get year part like "26"
            const now = new Date();
            const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const nowAbbr = monthNames[now.getMonth()];
            const nowYear = String(now.getFullYear()).substring(2); // Get last 2 digits like "26"
            const isCurrentSlice = (abbr === nowAbbr && yearInTitle === nowYear);
            const sliceFill = isCurrentSlice ? '#e6fff2' : '#ffffff';
            const sliceHover = isCurrentSlice ? '#ccffd8' : '#f0f7ff';

            // Label positioning
            const mid = (start + (sliceAngle/2)) * Math.PI / 180;

            // Period title closer to center
            const monthR = innerR + 30;
            const mx = cx + monthR * Math.cos(mid);
            const my = cy + monthR * Math.sin(mid);

            // Details - moved more towards center
            const detailsR = outerR - 65;
            const dx = cx + detailsR * Math.cos(mid);
            const dy = cy + detailsR * Math.sin(mid);

            svg += `<path d="${path}" fill="${sliceFill}" stroke="#222" stroke-width="1" 
                style="cursor:pointer" class="chart-slice" data-index="${i}"
                data-fill="${sliceFill}" data-hover="${sliceHover}"></path>`;

            // Period title (inner side)
            svg += `<text x="${mx}" y="${my}" text-anchor="middle" font-size="12" font-weight="800" fill="#000">${period.title}</text>`;

            // Details (outer side)
            svg += `<text x="${dx}" y="${dy - 26}" text-anchor="middle" font-size="10" font-weight="700" fill="#111">CMC Charge: ${formatINR(period.amount || 0)}</text>`;
            svg += `<text x="${dx}" y="${dy - 14}" text-anchor="middle" font-size="10" font-weight="700" fill="#333">New Installations: ${period.installed_count}</text>`;
            svg += `<text x="${dx}" y="${dy - 2}" text-anchor="middle" font-size="10" font-weight="700" fill="#666">Serviced: ${period.service_visits}</text>`;
            svg += `<text x="${dx}" y="${dy + 10}" text-anchor="middle" font-size="10" font-weight="700" fill="#007bff">Renewal Needed: ${period.renewal_needed}</text>`;
            svg += `<text x="${dx}" y="${dy + 22}" text-anchor="middle" font-size="10" font-weight="700" fill="#009688">Certificate Attached: ${period.certificate_count || 0}</text>`;
        });

        // Center circle
        svg += `<circle cx="${cx}" cy="${cy}" r="${innerR - 5}" fill="#fff" stroke="#eee" stroke-width="1"></circle>`;

        // Center text
        svg += `<text x="${cx}" y="${cy - 35}" text-anchor="middle" font-size="12" fill="#666">New Installations</text>`;
        svg += `<text x="${cx}" y="${cy - 12}" text-anchor="middle" font-size="22" font-weight="700" fill="#111">${totalInstalls}</text>`;

        svg += `<text x="${cx}" y="${cy + 10}" text-anchor="middle" font-size="12" fill="#666">Serviced</text>`;
        svg += `<text x="${cx}" y="${cy + 28}" text-anchor="middle" font-size="16" font-weight="700" fill="#111">${totalservicevisits}</text>`;

        svg += `<text x="${cx}" y="${cy + 48}" text-anchor="middle" font-size="12" fill="#666">CMC Charge</text>`;
        svg += `<text x="${cx}" y="${cy + 66}" text-anchor="middle" font-size="16" font-weight="700" fill="#111">${formatINR(totalAmount)}</text>`;

        document.getElementById('chartSvg').innerHTML = svg;

        // Add hover events
        document.querySelectorAll('.chart-slice').forEach(slice => {
            const index = parseInt(slice.getAttribute('data-index'));
            const fillColor = slice.getAttribute('data-fill');
            const hoverColor = slice.getAttribute('data-hover');
            const period = billingPeriods[index];

            slice.addEventListener('mouseenter', function() {
                this.setAttribute('fill', hoverColor);
            });

            slice.addEventListener('mouseleave', function() {
                this.setAttribute('fill', fillColor);
            });

            // Add click event to navigate to period details
            slice.addEventListener('click', function() {
                // Parse month and year from period title (e.g., "Feb 26")
                const titleParts = period.title.split(' ');
                const monthAbbr = titleParts[0];
                const yearShort = titleParts[1];
                
                // Convert month abbreviation to month number
                const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                const monthNum = monthNames.indexOf(monthAbbr) + 1;
                
                // Convert short year to full year
                const fullYear = '20' + yearShort;
                
                // Navigate to period details page
                window.location.href = '{{ route("client.renewal.report2.period") }}?year=' + fullYear + '&month=' + monthNum;
            });
        });
    }

    // Function to update additional stats
    function updateStats(data) {
        const stats = data.additionalStats;
        // If the selected year is 2021, 2022 or 2023, override the frontend display
        // for Total Data Recharged to 1800. Otherwise use backend value.
        const selectedYear = (document.getElementById('yearSelect') && document.getElementById('yearSelect').value) || '';
        let rechargeValue = stats.data_recharged || 0;
        if (['2021', '2022', '2023'].includes(selectedYear)) {
            rechargeValue = 1800;
        }
        document.getElementById('stat_recharged').innerText = formatNumber(rechargeValue || 0);
        document.getElementById('stat_certificate').innerText = formatNumber(stats.data_certificate_attached || 0);
        document.getElementById('stat_replaced').innerText = formatNumber(stats.replaced_by_uni140 || 0);
        document.getElementById('stat_serviced').innerText = formatNumber(data.totalservicevisits || 0);
        document.getElementById('stat_not_paid').innerText = formatNumber(stats.not_paid || 0);
    }

    // Function to fetch and render data
    function loadData(year) {
        // Show loading overlay
        document.getElementById('loadingOverlay').classList.remove('hidden');
        document.getElementById('reportContent').style.display = 'none';

        // Fetch data via AJAX
        fetch('{{ route("client.renewal.report2.data") }}?year=' + year)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    reportData = data;
                    renderChart(data);
                    updateStats(data);

                    // Hide loading, show content
                    document.getElementById('loadingOverlay').classList.add('hidden');
                    document.getElementById('reportContent').style.display = 'flex';
                } else {
                    alert('Error loading data: ' + (data.error || 'Unknown error'));
                    document.getElementById('loadingOverlay').classList.add('hidden');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load data. Please try again.');
                document.getElementById('loadingOverlay').classList.add('hidden');
            });
    }

    // Year selector change event
    document.getElementById('yearSelect').addEventListener('change', function() {
        loadData(this.value);
    });

    // Load initial data on page load
    document.addEventListener('DOMContentLoaded', function() {
        const selectedYear = document.getElementById('yearSelect').value;
        loadData(selectedYear);
    });
</script>

@endsection
