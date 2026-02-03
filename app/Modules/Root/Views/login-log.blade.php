@extends('layouts.eclipse')

@section('title')
User Login Audit
@endsection

@section('content')
<style>
    /* Professional UI Enhancements */
    .page-wrapper_new { background-color: #f8f9fa; min-height: 100vh; padding-top: 20px; }
    .card { border: none; border-radius: 10px; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); margin-bottom: 2rem; }
    .card-header { background-color: #fff; border-bottom: 1px solid #edf2f9; padding: 1.25rem; border-top-left-radius: 10px !important; border-top-right-radius: 10px !important; }
    .card-header h4 { margin-bottom: 0; font-weight: 700; color: #334155; font-size: 1.1rem; text-transform: uppercase; letter-spacing: 0.025em; }
    
    /* Table Styling */
    .table thead th { background-color: #f8f9fa; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; color: #64748b; border-top: none; }
    .table-hover tbody tr:hover { background-color: #f1f5f9; transition: background-color 0.2s ease; }
    
    /* Status Badges */
    .badge-soft-info { background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
    .login-time { font-family: 'Inter', sans-serif; font-weight: 500; color: #1e293b; }
    
    /* Header Styles */
    .audit-header { margin-bottom: 1.5rem; }

    /* Custom Text Formatting */
    .audit-text-main { color: #000000; font-size: 0.9rem; font-weight: 500; }
</style>

<div class="page-wrapper page-wrapper-root page-wrapper_new">
    <div class="container-fluid">

        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center audit-header">
            <div>
                <h2 class="h4 font-weight-bold text-dark mb-1">User Login Audit</h2>
                <p class="text-muted small mb-0">Track and monitor user access activity across the system.</p>
            </div>
            <div class="text-right">
                <span class="badge badge-light p-2 shadow-sm border">
                    <i class="far fa-clock mr-1 text-primary"></i> Last Updated: {{ date('h:i A') }}
                </span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Access Logs</h4>
                        <div class="card-tools">
                             <span class="text-muted small">Total Users Logged: <strong>{{ count($logs) }}</strong></span>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="pl-4" style="width: 50px;">#</th>
                                        <th>User Information</th>
                                        <th>Access Role</th>
                                        <th>First Access (Today)</th>
                                        <th>Last Logout (Today)</th>
                                        <th class="text-center pr-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($logs as $index => $log)
                                        <tr>
                                            <td class="pl-4 text-muted">{{ $index + 1 }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm mr-3 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                        <i class="fa fa-user text-secondary"></i>
                                                    </div>
                                                    <span class="font-weight-bold text-dark">{{ $log->username }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-soft-info px-3 py-2">
                                                    {{ strtoupper($log->role) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($log->first_login_today)
                                                    <div class="audit-text-main">
                                                        <div>{{ \Carbon\Carbon::parse($log->first_login_today)->format('h:i A') }}</div>
                                                        <div>{{ $log->first_login_office ?? '�' }}</div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">no login yet</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($log->last_logout_today))
                                                    <div class="audit-text-main">
                                                        <div>{{ \Carbon\Carbon::parse($log->last_logout_today)->format('h:i A') }}</div>
                                                        <div>{{ \Carbon\Carbon::parse($log->last_logout_today)->format('d-m-Y') }}</div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">no logout today</span>
                                                @endif
                                            </td>
                                            <td class="text-center pr-4">
                                                <a href="{{ route('root.loginlogshistory.show', $log->user_id) }}" 
                                                   class="btn btn-sm btn-white bg-white border shadow-sm text-dark font-weight-bold">
                                                    <i class="fa fa-history mr-1"></i> History
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="py-5 text-center text-muted">
                                                <i class="fa fa-user-slash fa-2x mb-3 opacity-25"></i>
                                                <p>No login records found in the database.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if(count($logs) > 0)
                    <div class="card-footer bg-white border-top-0 py-3">
                        <p class="small text-muted mb-0">Displaying activity for all active system users.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection