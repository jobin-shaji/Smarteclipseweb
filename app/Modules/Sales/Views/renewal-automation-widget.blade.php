<div class="renewal-automation-widget card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-robot mr-2"></i>
            GPS Renewal Automation
        </h5>
        <span class="badge badge-light" id="renewal-test-mode-badge" style="display: none;">TEST MODE</span>
    </div>
    
    <div class="card-body">
        <!-- Statistics Row -->
        <div class="row mb-3">
            <div class="col-md-3 col-sm-6 mb-2">
                <div class="stat-card stat-card-clickable" id="active-stat-card" role="button" title="Click to view active assignments">
                    <div class="stat-icon bg-primary">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value" id="stat-total-assigned">0</div>
                        <div class="stat-label">Active Assignments</div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 mb-2">
                <div class="stat-card stat-card-clickable" id="urgent-stat-card" role="button" title="Click to view urgent list">
                    <div class="stat-icon bg-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value" id="stat-urgent-count">0</div>
                        <div class="stat-label">Urgent (Escalated)</div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 mb-2">
                <div class="stat-card stat-card-clickable" id="pending-stat-card" role="button" title="Click to view pending follow-ups">
                    <div class="stat-icon bg-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value" id="stat-pending-followup">0</div>
                        <div class="stat-label">Pending Follow-up</div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 mb-2">
                <div class="stat-card stat-card-clickable" id="completed-stat-card" role="button" title="Click to view completed assignments">
                    <div class="stat-icon bg-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value" id="stat-completed-today">0</div>
                        <div class="stat-label">Completed Today</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Action Buttons Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="button-group">
                    <button class="btn btn-primary btn-action" id="btn-run-assignment">
                        <i class="fas fa-play-circle"></i>
                        Run Auto-Assignment
                    </button>
                    
                    <button class="btn btn-warning btn-action" id="btn-check-followups">
                        <i class="fas fa-sync-alt"></i>
                        Check Follow-ups
                    </button>
                    
                    <button class="btn btn-info btn-action" id="btn-view-all">
                        <i class="fas fa-list"></i>
                        View All Assignments
                    </button>
                    
                    <button class="btn btn-secondary btn-action" id="btn-refresh-stats">
                        <i class="fas fa-redo"></i>
                        Refresh Stats
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Last Updated Info -->
        <div class="row mt-3">
            <div class="col-md-12">
                <small class="text-muted">
                    <i class="fas fa-info-circle"></i>
                    Last updated: <span id="last-updated-time">Never</span>
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Urgent List Modal -->
<div class="modal fade" id="urgentListModal" tabindex="-1" role="dialog" aria-labelledby="urgentListModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="urgentListModalLabel">
                    <i class="fas fa-exclamation-triangle"></i>
                    Urgent GPS Devices (Escalated)
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="urgent-list-container">
                    <div class="text-center py-4">
                        <i class="fas fa-spinner fa-spin fa-3x text-muted"></i>
                        <p class="mt-2">Loading...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Load CSS and JS -->
<link rel="stylesheet" href="{{ asset('css/renewal-automation.css') }}">
<script src="{{ asset('js/renewal-automation.js') }}"></script>
