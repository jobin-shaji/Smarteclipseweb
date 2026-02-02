@extends('layouts.eclipse')

@section('title')
User Login History
@endsection

@section('content')
<div class="page-wrapper page-wrapper-root">
    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="h5 font-weight-bold text-dark mb-0">
                User Login History
            </h3>

            <a href="{{ route('root.loginlog') }}"
               class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-arrow-left mr-1"></i> Back to Summary
            </a>
        </div>

        {{-- History Table --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h4 class="mb-0">Login Records</h4>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-hover mb-0">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Date & Time</th>
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
                {{ \Carbon\Carbon::parse($log->created_at)->format('d M Y, h:i A') }}
            </td>

            <td>
                <span style="font-size: 15px; font-weight: 600;">
                    {{ $log->ip_address }}
                </span>
            </td>

            <td>
                <span class="badge badge-info" style="font-size: 14px;">
                    {{ $log->platform ?? 'Unknown' }}
                </span>
            </td>

            <td>
                <span class="badge badge-secondary" style="font-size: 13px;">
                    {{ $log->office ?? '—' }}
                </span>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center text-muted py-4">
                No login history found for this user.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

                </div>
            </div>

            {{-- Pagination --}}
            @if ($history->hasPages())
            <div class="card-footer bg-white">
                {{ $history->links() }}
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
