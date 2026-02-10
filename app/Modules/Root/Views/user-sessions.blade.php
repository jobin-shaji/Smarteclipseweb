@extends('layouts.eclipse')

@section('title')
User Sessions Audit
@endsection

@section('content')
<style>
    .page-wrapper_new { background-color: #f8f9fa; min-height: 100vh; padding-top: 20px; }
    .card { border: none; border-radius: 10px; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); margin-bottom: 2rem; }
    .card-header { background-color: #fff; border-bottom: 1px solid #edf2f9; padding: 1.25rem; }
    .table thead th { background-color: #f8f9fa; text-transform: uppercase; font-size: 0.75rem; color: #64748b; }
    .badge-soft-info { background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
</style>

<div class="page-wrapper page-wrapper-root page-wrapper_new">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center audit-header mb-3">
            <div>
                <h2 class="h4 font-weight-bold text-dark mb-1">User Sessions Audit</h2>
                <p class="text-muted small mb-0">Summary from abc_user_sessions table.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Sessions</h4>
                        <div class="card-tools">
                             <span class="text-muted small">Total Users: <strong>{{ count($sessions) }}</strong></span>
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
                                        <th>First Login (Today)</th>
                                        <th>Last Logout (Today)</th>
                                        <th class="text-center pr-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($sessions as $index => $s)
                                        <tr>
                                            <td class="pl-4 text-muted">{{ $index + 1 }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm mr-3 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                        <i class="fa fa-user text-secondary"></i>
                                                    </div>
                                                    <span class="font-weight-bold text-dark">{{ $s->username }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-soft-info px-3 py-2">
                                                    {{ strtoupper($s->role) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($s->first_login_today)
                                                    <div>
                                                        <div>{{ \Carbon\Carbon::parse($s->first_login_today)->format('h:i A') }}</div>
                                                        <div>{{ $s->first_login_office ?? '�' }}</div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">no login yet</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($s->last_logout_today))
                                                    <div>
                                                        <div>{{ \Carbon\Carbon::parse($s->last_logout_today)->format('h:i A') }}</div>
                                                        <div>{{ \Carbon\Carbon::parse($s->last_logout_today)->format('d-m-Y') }}</div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">no logout today</span>
                                                @endif
                                            </td>
                                            <td class="text-center pr-4">
                                                    <a href="{{ route('root.usersessions.history', encrypt($s->user_id)) }}" 
                                                   class="btn btn-sm btn-white bg-white border shadow-sm text-dark font-weight-bold">
                                                    <i class="fa fa-history mr-1"></i> History
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="py-5 text-center text-muted">
                                                <i class="fa fa-user-slash fa-2x mb-3 opacity-25"></i>
                                                <p>No session records found.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if(count($sessions) > 0)
                    <div class="card-footer bg-white border-top-0 py-3">
                        <p class="small text-muted mb-0">Displaying activity from abc_user_sessions.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
