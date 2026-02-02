@extends('layouts.eclipse')

@section('title')
GPS Renewal Daily Report
@endsection

@section('content')
<style>
    /* Professional UI Enhancements */
    .page-wrapper_new { background-color: #f8f9fa; min-height: 100vh; padding-top: 20px; }
    .card { border: none; border-radius: 10px; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); margin-bottom: 2rem; }
    .card-header { background-color: #fff; border-bottom: 1px solid #edf2f9; padding: 1.25rem; border-top-left-radius: 10px !important; border-top-right-radius: 10px !important; }
    .card-header h4 { margin-bottom: 0; font-weight: 700; color: #334155; font-size: 1.1rem; text-transform: uppercase; letter-spacing: 0.025em; }
    
    /* Box Spacing and Uniformity */
    .small-box { border-radius: 10px; overflow: hidden; transition: transform 0.2s; border: none; margin-bottom: 20px; height: 180px;} /* Fixed height for same size */
    .small-box:hover { transform: translateY(-3px); }
    .small-box .inner { padding: 1.5rem !important; }
    
    /* Typography hierarchy */
    .stat-heading { font-size: 0.9rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.85; margin-bottom: 10px; display: block; }
    .stat-subtext { font-size: 1.1rem; font-weight: 500; display: block; margin-bottom: 5px; }
    .stat-value { font-size: 1.8rem; font-weight: 800; }

    /* Specific font size increase for 3rd box data */
    .large-stat-data { font-size: 1.6rem !important; font-weight: 800; }

    .table thead th { background-color: #f8f9fa; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; color: #64748b; border-top: none; }
</style>

<div class="page-wrapper page-wrapper-root page-wrapper_new">
    <div class="container-fluid">

        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 font-weight-bold text-dark mb-0">Daily Performance Overview</h2>
            <div class="text-right">
                <form method="GET" action="{{ route('gps-renewal-daily-report') }}" class="form-inline justify-content-end">
            
                    <input type="date"
                           id="filter-date"
                           name="date"
                           class="form-control form-control-sm mr-2"
                           value="{{ request('date') }}">
                    
                    <input type="month"
                           id="filter-month"
                           name="month"
                           class="form-control form-control-sm mr-2"
                           value="{{ request('month') }}">
            
                    <button class="btn btn-sm btn-outline-secondary mr-2">
                        <i class="fa fa-search"></i>
                    </button>
            
                    <span class="badge badge-light p-2 shadow-sm">
                        <i class="far fa-calendar-alt mr-1"></i>
                        {{ $labelDate ?? date('d M Y') }}
                    </span>
            
                </form>
            </div>
        </div>

        <div class="row">
            {{-- Box 1: Highest Performer by Amount --}}
            <div class="col-lg-4 col-md-4 col-sm-4 px-3">
                <div class="small-box bg-success shadow-sm">
                    <div class="inner text-white">
                        <span class="stat-heading text-dark">Highest Performer by (Amount)</span>
                        <span class="stat-subtext">
                            <i class="fa fa-user-circle mr-1"></i> {{ $topByAmount->username ?? 'N/A' }}
                        </span>
                        <div class="stat-value">
                             <i class="fa fa-rupee-sign mr-1"></i>{{ number_format($topByAmount->total_sales ?? 0) }}
                        </div>
                    </div>
                    <div class="icon text-white-50">
                        <i class="fa fa-award"></i>
                    </div>
                </div>
            </div>

            {{-- Box 2: Highest Performer by Count --}}
            <div class="col-lg-4 col-md-4 col-sm-4 px-3">
                <div class="small-box bg-success shadow-sm">
                    <div class="inner text-white">
                        <span class="stat-heading text-dark">Highest Performer by (Count)</span>
                        <span class="stat-subtext">
                             <i class="fa fa-user-circle mr-1"></i> {{ $topByCount->username ?? ($topByCount->username ?? 'N/A') }}
                        </span>
                        <div class="stat-value">{{ $topByCount->renewal_count ?? 0 }}</div>
                    </div>
                    <div class="icon text-white-50">
                        <i class="fa fa-medal"></i>
                    </div>
                </div>
            </div>

            {{-- Box 3: Total Renewals --}}
            <div class="col-lg-4 col-md-4 col-sm-4 px-3">
                <div class="small-box bg-success shadow-sm">
                    <div class="inner text-white">
                        <span class="stat-heading text-dark">Total Renewals</span>
                        <div class="row mt-2">
                            <div class="col-6 border-right">
                                <span class="small opacity-75 d-block">Total Amount</span>
                                <div class="large-stat-data mb-0">
                                    <i class="fa fa-rupee-sign mr-1"></i>{{ number_format($todaySales->total_amount ?? 0) }}
                                </div>
                            </div>
                            <div class="col-6">
                                <span class="small opacity-75 d-block">Count</span>
                                <div class="large-stat-data mb-0">{{ $todaySales->total_renewals ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="icon text-white-50">
                        <i class="fa fa-sync-alt"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Detailed Renewal Log</h4>
                <div>
                    <button class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                        <i class="fa fa-print mr-1"></i> Print
                    </button>
                    <a href="{{ route('gps-renewal-daily-report.export', request()->query()) }}"
                       class="btn btn-sm btn-outline-success ml-2">
                        <i class="fa fa-file-excel mr-1"></i> Excel This page
                    </a>
                    <a href="{{ route('gps-renewal-daily-report.export') }}"
                       class="btn btn-sm btn-outline-success ml-2">
                        <i class="fa fa-file-excel mr-1"></i> Excel All
                    </a>
                </div>

            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="pl-4">#</th>
                                <th>Employee Details</th>
                                <th>Device Info</th>
                                <th>Vehicle No</th>
                                <th>Amount</th>
                                <th>Processed By</th>
                                <th>Pay Date</th>
                                <th class="pr-4">Validity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($renewals as $index => $row)
                                <tr>
                                    <td class="pl-4 text-muted">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="font-weight-bold text-dark">{{ $row->username ?? 'N/A' }}</div>
                                        <small class="text-muted">{{ $row->username }}</small>
                                    </td>
                                    <td>
                                        <small class="d-block text-uppercase font-weight-bold text-muted" style="font-size: 0.65rem;">IMEI</small>
                                        <span class="text-secondary">{{ $row->imei }}</span>
                                    </td>
                                    <td><span class="text-dark">{{ $row->vehicle_no }}</span></td>
                                    <td class="font-weight-bold text-dark">
                                        <i class="fa fa-rupee-sign small mr-1 text-muted"></i>{{ number_format($row->amount, 2) }}
                                    </td>
                                    <td><span class="text-muted small">{{ $row->renewed_by }}</span></td>
                                    <td>{{ \Carbon\Carbon::parse($row->pay_date)->format('d M, Y') }}</td>
                                    <td class="pr-4">
                                        <span class="text-success font-weight-bold">
                                            {{ \Carbon\Carbon::parse($row->validity_date)->format('d M, Y') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-5 text-center text-muted">
                                        No records found for the selected date.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if(count($renewals) > 0)
            <div class="card-footer bg-white border-top-0 py-3">
                <p class="small text-muted mb-0">Summary: <strong>{{ count($renewals) }}</strong> transactions processed.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
<script>
document.addEventListener('DOMContentLoaded', function () {
    const dateInput  = document.getElementById('filter-date');
    const monthInput = document.getElementById('filter-month');

    dateInput.addEventListener('change', function () {
        if (this.value) {
            monthInput.value = '';
        }
    });

    monthInput.addEventListener('change', function () {
        if (this.value) {
            dateInput.value = '';
        }
    });
});
</script>
