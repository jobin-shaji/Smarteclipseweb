@extends('layouts.eclipse')

@section('title')
User Session History
@endsection

@section('content')
<div class="page-wrapper page-wrapper-root">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="h5 font-weight-bold text-dark mb-0">User Session History</h3>

            <a href="{{ route('root.usersessions') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-arrow-left mr-1"></i> Back to Summary
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h4 class="mb-0">Session Records</h4>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-hover mb-0">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Login</th>
            <th>Logout</th>
            <th>IP Address</th>
            <th>Platform</th>
            <th>Office</th>
        </tr>
    </thead>

    <tbody>
    @forelse ($history as $index => $log)
        <tr>
            <td>{{ $history->firstItem() + $index }}</td>

            <td>
                {{ \Carbon\Carbon::parse($log->logged_in_at ?? $log->created_at)->format('d M Y, h:i A') }}
            </td>

            <td>
                @if(!empty($log->logged_out_at))
                    {{ \Carbon\Carbon::parse($log->logged_out_at)->format('d M Y, h:i A') }}
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>

            <td>
                <span style="font-size: 15px; font-weight: 600;">{{ $log->login_ip ?? 'N/A' }}</span>
            </td>

            <td>
                <span class="badge badge-info" style="font-size: 14px;">{{ $log->login_platform ?? 'Unknown' }}</span>
            </td>

            <td>
                <span class="badge badge-secondary" style="font-size: 13px;">{{ $log->login_office ?? '�' }}</span>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center text-muted py-4">No session history found for this user.</td>
        </tr>
    @endforelse
    </tbody>
</table>

                </div>
            </div>

            @if ($history->hasPages())
            <div class="card-footer bg-white">
                {{ $history->links() }}
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
