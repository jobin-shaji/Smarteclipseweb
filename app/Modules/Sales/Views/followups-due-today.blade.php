@extends('layouts.eclipse')
@section('title')
FOLLOW-UPS DUE TODAY
@endsection

@section('content')
<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
   <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a> / FOLLOW-UPS DUE TODAY</li>
      <b>FOLLOW-UPS DUE TODAY</b>
    </ol>
  </nav>
  
  <div class="card">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">
        <i class="fas fa-bell"></i> GPS Devices Requiring Follow-up (Due & Overdue)
      </h4>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered datatable" id="followupsTable">
          <thead class="bg-primary text-white">
            <tr>
              <th>SL No.</th>
              <th>GPS ID</th>
              <th>IMEI</th>
              <th>Vehicle No</th>
              <th>Last Follow-up</th>
              <th>Next Follow-up Date</th>
              <th>Days to Expiry</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($followups as $index => $followup)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td><strong>{{ $followup->gps_id }}</strong></td>
              <td>{{ $followup->gps->imei ?? 'N/A' }}</td>
              <td>{{ $followup->gps->vehicle_no ?? '-' }}</td>
              <td>
                <small>{{ $followup->description ?? 'No comments' }}</small><br>
                <em class="text-muted">{{ $followup->created_at->diffForHumans() }}</em>
              </td>
              <td>
                <span class="badge badge-warning">
                  <i class="fas fa-calendar"></i> {{ $followup->next_follow_date }}
                </span>
              </td>
              <td>
                @php
                  $daysToExpiry = null;
                  if ($followup->gps && $followup->gps->validity_date) {
                    $daysToExpiry = \Carbon\Carbon::now()->diffInDays($followup->gps->validity_date, false);
                  }
                @endphp
                @if($daysToExpiry !== null)
                  <span class="badge {{ $daysToExpiry <= 7 ? 'badge-danger' : ($daysToExpiry <= 15 ? 'badge-warning' : 'badge-success') }}">
                    {{ $daysToExpiry }} days
                  </span>
                @else
                  <span class="badge badge-secondary">N/A</span>
                @endif
              </td>
              <td>
                @if($followup->gps && $followup->gps->pay_status == 1)
                  <span class="badge badge-success"><i class="fas fa-check"></i> Renewed</span>
                @else
                  <span class="badge badge-warning"><i class="fas fa-clock"></i> Pending</span>
                @endif
              </td>
              <td>
                <a href="{{ route('follow-gps', ['id' => $followup->gps_id]) }}" 
                   class="btn btn-sm btn-primary" 
                   title="Add Follow-up">
                  <i class="fas fa-phone"></i> Contact
                </a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center text-muted">
                <i class="fas fa-check-circle fa-3x mb-2"></i>
                <p>No follow-ups due today! Great job!</p>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>

<style>
.card {
  border: none;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.badge {
  padding: 6px 10px;
  font-size: 12px;
}

.table thead th {
  font-weight: 600;
  border-bottom: 2px solid #dee2e6;
}

.table tbody tr:hover {
  background-color: #f8f9fa;
}

small {
  font-size: 11px;
}
</style>

<script>
$(document).ready(function() {
    $('#followupsTable').DataTable({
        "order": [[5, "asc"]], // Sort by days to expiry
        "pageLength": 25,
        "language": {
            "emptyTable": "No follow-ups due today"
        }
    });
});
</script>

@endsection
