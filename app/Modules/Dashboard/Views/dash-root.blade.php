<!-- Root dashboard block extracted from dashboard.blade.php -->
<style>
  /* Fix canvas overflow on mobile */
  canvas {
    max-width: 100% !important;
    height: auto !important;
  }
  .btn-pop {
    display: inline-block;
    font-weight: 400;
    color: #212529;
    text-align: center;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-color: #ccc;
    border: 1px solid transparent;
    padding: 0 .21rem;
    line-height: 2;
    font-size: .75rem !important;
    border-radius: .25rem;
    margin: 0 .1rem .5rem .1rem;
    color: #000;
  }

  .btn-pop:hover {
    background: #f7b018;
  }

  .rr-wrap {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    gap: 10px;
    align-items: center;
    justify-content: center;
  }

  .rr-box {
    flex: 0 0 360px;
    max-width: 420px;
    width: 100%;
  }

  .rr-chart {
    flex: 1 1 640px;
    width: 100%;
    max-width: 1000px;
    display: flex;
    justify-content: center;
  }

  .rr-chart svg {
    width: 100%;
    height: auto;
  }

  .rr-stat-card {
    flex: 1;
    min-width: 160px;
    padding: 15px;

    border: 1px solid #000000;
    border-radius: 12px;
    background: #fff;
    text-align: center;
  }

</style>
<title></title>
<meta name="viewport" content="initial-scale=1.0">
<meta charset="utf-8">
<link href='https://fonts.googleapis.com/css?family=Raleway:300,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="style.css" type="text/css" media="all">
<script src="modernizr.js"></script>
@php
  $rootRenewalMonths = $rootRenewalMonths ?? [];
  $rootTotalServiceVisits = $rootTotalServiceVisits ?? 0;
@endphp
<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <section class="content">
      <div class="row root-dashboard-flex">
        <div class="col-lg-3 col-md-6 col-sm-12 new_arrival_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner inner-left">
              <div class="box-2">
                <div style="float:left; width:50%">
                  <h3 id="gps_manufactured"></h3>
                  <p class="mrg-bt-0">GPS Devices Manufactured</p>
                </div>
                <div style="float:left; width:50%">
                  <h3 id="refurbished_devices"></h3>
                  <p class="mrg-bt-0">Refurbished GPS Devices</p>
                </div>
              </div>
            </div>
            <a href="/gps-all" class="small-box-footer view-last">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12  gps_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-green bxs">

            <div class="inner inner-left">
              <div class="box-2">
                <div style="float:left; width:50%">
                  <h3 id="gps"></h3>
                  <p class="mrg-bt-0">GPS Devices In Stock</p>
                </div>
                <div style="float:left; width:50%">
                  <h3 id="refurbished_gps"></h3>
                  <p class="mrg-bt-0">Refurbished GPS Devices In Stock</p>
                </div>
              </div>
            </div>
            <a href="/gps" class="small-box-footer view-last">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 transferred_gps_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="gps_transferred">
                <div class="loader"></div>
              </h3>
              <p>GPS Devices Transferred</p>
            </div>
            <div class="icon">
              <i class="fa fa-tablet"></i>
            </div>
            <a href="/gps-transferred-root" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 gps_non_stock_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="gps_to_be_added_to_stock">
                <div class="loader"></div>
              </h3>
              <p>GPS Devices: To be added to stock</p>
            </div>
            <div class="icon">
              <i class="fa fa-tablet"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="row root-dashboard-flex"> 
        <div class="col-lg-3 col-md-6 col-sm-12 gps_returned_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-green bxs">

            <div class="inner inner-left">
              <div class="box-2">
                <div style="float:left; width:50%">
                  <h3 id="gps_returned"></h3>
                  <p class="mrg-bt-0">GPS Devices: Returned</p>
                </div>
                <div style="float:left; width:50%">
                  <h3 id="gps_returned_request"></h3>
                  <p class="mrg-bt-0">GPS Devices: Return Request</p>
                </div>
              </div>
            </div>
            <a href="/returned-gps" class="small-box-footer" style='float: left;width: 49%;'>View <i class="fa fa-arrow-circle-right"></i></a>
            <a href="/device-return-history-list" class="small-box-footer" style='float: left;width: 51%;'>View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>          
        <!-- ./col -->
        <div class="col-lg-3 col-md-6 col-sm-12 dealer_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-yellow bxs">
            <div class="inner">
              <h3 id="dealer">
                <div class="loader"></div>
              </h3>
              <p>Active Distributors</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="/dealers" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-md-6 col-sm-12 sub_dealer_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-blue bxs">
            <div class="inner">
              <h3 id="sub_dealer">
                <div class="loader"></div>
              </h3>
              <p>Active Dealers</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="/sub-dealers" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
       <div class="col-lg-3 col-xs-6 gps_non_stock_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-blue bxs">
            
            <div class="inner">
              <h3 id="total_renewal">
                <div class="loader"></div>
              </h3>
              <p>Total Renewal</p>
            </div>
            
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="/gps-all" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
    
        <div class="col-lg-3 col-md-6 col-sm-12  transferred_gps_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-blue bxs">
            
            <div class="inner">
              <h3 id="best_performer">
                <div class="loader"></div>
              </h3>
              <p>Highest Best Performer</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="/gps-all" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>



        <!-- ./col -->
        <div class="col-lg-3 col-md-6 col-sm-12  client_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="client">
                <div class="loader"></div>
              </h3>
              <p>Active End Users</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="/client" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


        <div class="col-lg-3 col-md-6 col-sm-12  gps_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-blue bxs">
            <div class="inner">
              <h3 id="todays_renewal">
                <div class="loader"></div>
              </h3>
              <p>Today's Renewal</p>
            </div>

            <div class="inner">
              <h3 id="todays_ksrtc">
                <div class="loader"></div>
              </h3>
              <p>Today's Renewal(KSRTC)</p>
            </div>
            <div class="inner">
              <h3 id="todays_performer">
                <div class="loader"></div>
              </h3>
              <p>Today's Best Performer</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="{{route('gps-renewal-daily-report')}}" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      
       <div class="col-lg-3 col-md-6 col-sm-12  gps_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-blue bxs">
            <div class="inner">
              <h3 id="todays_collection">
                <div class="loader"></div>
              </h3>
              <p>Today's Collection</p>
            </div>

            <div class="inner">
              <h3 id="total_collection">
                <div class="loader"></div>
              </h3>
              <p>Total Collection</p>
            </div>
            
            </div>
          </div>

          <div class="col-lg-3 col-md-6 col-sm-12  dealer_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-blue bxs">
            <div class="inner">
              <h3 id="devices_in">
                <div class="loader"></div>
              </h3>
              <p>Device In</p>
            </div>

            <div class="inner">
              <h3 id="devices_out">
                <div class="loader"></div>
              </h3>
              <p>Device Out</p>
            </div>

            <div class="inner">
              <h3 id="devices_pending">
                <div class="loader"></div>
              </h3>
              <p>Pending</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
              <a href="{{route('service.device.report')}}" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>          
            </div>
          </div>
          
        <div class="col-lg-3 col-md-6 col-sm-12  gps_non_stock_dashboard_grid dash_grid">
        <!-- small box -->
        <div class="small-box bg-blue bxs">
          <div class="inner">
            <h3 id="todaydevices_in">
              <div class="loader"></div>
            </h3>
            <p>Today's Device In</p>
          </div>

          <div class="inner">
            <h3 id="todaydevices_out">
              <div class="loader"></div>
            </h3>
            <p>Today's Device Out</p>
          </div>

          <div class="inner">
            <h3 id="todaydevices_pending">
              <div class="loader"></div>
            </h3>
            <p>Today's Pending</p>
          </div>
          
          </div>
        </div>
          
        <div class="col-lg-3 col-md-6 col-sm-12 gps_non_stock_dashboard_grid dash_grid">
        <!-- small box -->
        <div class="small-box bg-blue bxs">
          <div class="inner">
              <div class="loader"></div>
            </h3>
            <p>Logging Details</p>
          </div>
          <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="{{route('root.loginlog')}}" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>          
          </div>
          
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12  gps_non_stock_dashboard_grid dash_grid">
        <!-- small box -->
        <div class="small-box bg-blue bxs">
          <div class="inner">
            <h3 id="todaydevices_in">
              <div class="loader"></div>
            </h3>
            <p>KSRTC Renewal Report</p>
          </div>
          <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="{{route('client.renewal.report')}}" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>          
          </div>
        </div>
        

      </div>
      
      {{-- Service center device-in table (root only) --}}
      @if(!empty($serviceCenterCounts) && auth()->user()->hasRole('root'))
      <div class="row root-dashboard-flex mrg-top-20">
        <div class="col-lg-12">
          <style>
            .sc-summary-card{background:linear-gradient(180deg,#f8fafc 0%,#ffffff 70%);border:1px solid #e5e7eb;box-shadow:0 10px 24px rgba(15,23,42,0.08);border-radius:12px}
            .sc-summary-title{margin:0 0 10px 0;color:#0f172a;letter-spacing:.2px}
            .sc-summary-table thead th{background:#f1f5f9;border-bottom:1px solid #e2e8f0;color:#1f2937;font-weight:600}
            .sc-summary-table tbody td{background:#ffffff}
            .sc-summary-table tbody tr:hover td{background:#f8fafc}
            .sc-summary-table .pending-over-week{color:#c0392b;font-weight:700}
          </style>
          <div class="card sc-summary-card" style="padding:12px;">
            <h4 class="sc-summary-title">Service Center Device Summary</h4>
            <div class="table-responsive">
              <table class="table table-striped table-bordered sc-summary-table">
                <thead>
                  <tr>
                    <th>Service Center</th>
                    <th class="text-right">Device In</th>
                    <th class="text-right">Device Out</th>
                    <th class="text-right">Pending Less Than 1 Week</th>
                    <th class="text-right">Pending Over 1 Week</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($serviceCenterCounts as $sc)
                    <tr>
                      <td>{{ $sc['name'] }}</td>
                      <td class="text-right">{{ $sc['device_in'] }}</td>
                      <td class="text-right">{{ $sc['device_out'] }}</td>
                      <td class="text-right">{{ $sc['pending_under_week'] }}</td>
                      <td class="text-right pending-over-week">{{ $sc['pending_over_week'] }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      @endif

      {{-- Temporarily hidden root chart trio --}}
      {{--
      <div class="row root-dashboard-flex">
        <div class="col-lg-6 col-xs-6">
          <canvas id="rootChart" style="max-width: 100%; height: 200px;"></canvas>
        </div>
        <div class="col-lg-6 col-xs-6">
          <canvas id="rootChartUser" style="max-width: 100%; height: 200px;"></canvas>
        </div>
        <div class="col-lg-6 col-xs-6">
          <canvas id="rootGpsSaleChart" style="max-width: 100%; height: 200px;"></canvas>
        </div>
      </div>
      --}}

      @if(!empty($rootRenewalMonths))
        @php
          $rrSize = 1000;
          $rrOuterR = 390;
          $rrInnerR = 90;

          $rrCx = $rrSize / 2;
          $rrCy = $rrSize / 2;
          $rrSliceCount = 12;
          $rrSliceAngle = 360 / $rrSliceCount;

          $rrTotalInstalled = collect($rootRenewalMonths)->sum('total_installed');
        @endphp

        <div class="row">
          <div class="col-lg-12">
            <div class="rr-wrap" style="padding:4px 6px 4px 6px;">

              <div class="rr-chart">
                <svg width="{{ $rrSize }}" height="{{ $rrSize }}" viewBox="0 0 {{ $rrSize }} {{ $rrSize }}" style="display:block;">
                  @foreach($rootRenewalMonths as $i => $m)
                    @php
                      $start = -90 + ($i * $rrSliceAngle);
                      $end   = $start + $rrSliceAngle;

                      $startRad = deg2rad($start);
                      $endRad   = deg2rad($end);

                      $x1 = $rrCx + $rrOuterR * cos($startRad);
                      $y1 = $rrCy + $rrOuterR * sin($startRad);
                      $x2 = $rrCx + $rrOuterR * cos($endRad);
                      $y2 = $rrCy + $rrOuterR * sin($endRad);

                      $x3 = $rrCx + $rrInnerR * cos($endRad);
                      $y3 = $rrCy + $rrInnerR * sin($endRad);
                      $x4 = $rrCx + $rrInnerR * cos($startRad);
                      $y4 = $rrCy + $rrInnerR * sin($startRad);

                      $path = "M $x1 $y1 A $rrOuterR $rrOuterR 0 0 1 $x2 $y2 L $x3 $y3 A $rrInnerR $rrInnerR 0 0 0 $x4 $y4 Z";

                      $mid = deg2rad($start + ($rrSliceAngle/2));

                      $monthR = $rrInnerR + 35;
                      $mx = $rrCx + $monthR * cos($mid);
                      $my = $rrCy + $monthR * sin($mid);

                      $detailsR = $rrOuterR - 80;
                      $dx = $rrCx + $detailsR * cos($mid);
                      $dy = $rrCy + $detailsR * sin($mid);
                    @endphp

                    <path d="{{ $path }}"
                          fill="#ffffff"
                          stroke="#222"
                          stroke-width="1"
                          style="cursor:pointer"
                          onmouseenter="this.setAttribute('fill', '#f0f7ff'); setRootRenewalMonthData('{{ $m['month_name'] }}', {{ $m['total_installed'] }}, {{ $m['renewal_needed'] }}, {{ $m['renewed'] }}, {{ $m['not_renewed'] }}, {{ $m['service_visits'] }})"
                          onmouseleave="this.setAttribute('fill', '#ffffff')"
                    ></path>

                    <text x="{{ $mx }}" y="{{ $my }}" text-anchor="middle" font-size="16" font-weight="800" fill="#000">
                      {{ $m['month_name'] }}
                    </text>

                    <text x="{{ $dx }}" y="{{ $dy - 30 }}" text-anchor="middle" font-size="12" font-weight="800" fill="#111">
                      Renewal Needed: {{ $m['renewal_needed'] }}
                    </text>

                    <text x="{{ $dx }}" y="{{ $dy - 14 }}" text-anchor="middle" font-size="12" font-weight="800" fill="#111">
                      Installed: {{ $m['total_installed'] }}
                    </text>

                    <text x="{{ $dx }}" y="{{ $dy + 0 }}" text-anchor="middle" font-size="12" font-weight="800" fill="#111">
                      Service: {{ $m['service_visits'] }}
                    </text>

                    <text x="{{ $dx }}" y="{{ $dy + 14 }}" text-anchor="middle" font-size="12" font-weight="800" fill="#28a745">
                      Renewed: {{ $m['renewed'] }}
                    </text>

                    <text x="{{ $dx }}" y="{{ $dy + 28 }}" text-anchor="middle" font-size="12" font-weight="800" fill="#dc3545">
                      Not Renewed: {{ $m['not_renewed'] }}
                    </text>
                  @endforeach

                  <circle cx="{{ $rrCx }}" cy="{{ $rrCy }}" r="{{ $rrInnerR - 5 }}" fill="#fff" stroke="#eee" stroke-width="1"></circle>

                  <text x="{{ $rrCx }}" y="{{ $rrCy - 35 }}" text-anchor="middle" font-size="12" fill="#666">Total Installed</text>
                  <text x="{{ $rrCx }}" y="{{ $rrCy - 12 }}" text-anchor="middle" font-size="22" font-weight="700" fill="#111">{{ $rrTotalInstalled }}</text>

                  <text x="{{ $rrCx }}" y="{{ $rrCy + 10 }}" text-anchor="middle" font-size="12" fill="#666">Total Service</text>
                  <text x="{{ $rrCx }}" y="{{ $rrCy + 28 }}" text-anchor="middle" font-size="16" font-weight="700" fill="#111">{{ $rootTotalServiceVisits }}</text>
                </svg>
              </div>

              <div class="rr-box" style="margin-top:2px;">
                <div id="rr_monthBox" style="padding:12px; border:1px solid #ddd; border-radius:15px; background:#fcfcfc; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                  <div style="font-weight:700; font-size:18px; margin-bottom:6px;">
                    Month: <span id="rr_mb_month" style="color:#007bff;">{{ $rootRenewalMonths[0]['month_name'] ?? '' }}</span>
                  </div>

                  <div style="display:flex; gap:6px; flex-wrap:wrap;">
                    <div class="rr-stat-card">
                      <div style="font-size:12px; color:#777;">INSTALLED</div>
                      <div id="rr_mb_installed" style="font-size:22px; font-weight:700;">{{ $rootRenewalMonths[0]['total_installed'] ?? 0 }}</div>
                    </div>
                    <div class="rr-stat-card">
                      <div style="font-size:12px; color:#777;">RENEWAL NEEDED</div>
                      <div id="rr_mb_needed" style="font-size:22px; font-weight:700;">{{ $rootRenewalMonths[0]['renewal_needed'] ?? 0 }}</div>
                    </div>
                    <div class="rr-stat-card">
                      <div style="font-size:12px; color:#777;">RENEWED</div>
                      <div id="rr_mb_renewed" style="font-size:22px; font-weight:700; color:#28a745;">{{ $rootRenewalMonths[0]['renewed'] ?? 0 }}</div>
                    </div>
                    <div class="rr-stat-card">
                      <div style="font-size:12px; color:#777;">NOT RENEWED</div>
                      <div id="rr_mb_not" style="font-size:22px; font-weight:700; color:#dc3545;">{{ $rootRenewalMonths[0]['not_renewed'] ?? 0 }}</div>
                    </div>
                    <div class="rr-stat-card">
                      <div style="font-size:12px; color:#777;">SERVICE</div>
                      <div id="rr_mb_service" style="font-size:22px; font-weight:700;">{{ $rootRenewalMonths[0]['service_visits'] ?? 0 }}</div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        <script>
          function setRootRenewalMonthData(monthName, installed, renewalNeeded, renewed, notRenewed, serviceVisits) {
            document.getElementById('rr_mb_month').innerText = monthName;
            document.getElementById('rr_mb_installed').innerText = installed;
            document.getElementById('rr_mb_needed').innerText = renewalNeeded;
            document.getElementById('rr_mb_renewed').innerText = renewed;
            document.getElementById('rr_mb_not').innerText = notRenewed;
            document.getElementById('rr_mb_service').innerText = serviceVisits;
          }
        </script>
      @endif
    </section>
  </div>
</div>
