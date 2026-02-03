<style>
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
</style>

<title></title>
<meta name="viewport" content="initial-scale=1.0">
<meta charset="utf-8">

<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    
    <section class="content">
      <!-- Existing Dashboard Boxes -->
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-12  new_arrival_dashboard_grid dash_grid">
          <div class="small-box bg-yellow bxs">
            <div class="inner">
              <h3>
                <div class="loader"></div>
              </h3>
              <p> DEVICE STOCK REPORT</p>
            </div>
            <a href="/gps-stock-report" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12  transferred_gps_dashboard_grid dash_grid">
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3>
                <div class="loader"></div>
              </h3>
              <p> DEVICE TRANSFER REPORT</p>
            </div>
            <a href="/gps-transfer-report" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>    
        
        

        <div class="col-lg-3 col-md-6 col-sm-12  new_arrival_dashboard_grid dash_grid">
          <div class="small-box bg-yellow bxs">
            <div class="inner">
              <h3>
                <div class="loader"></div>
              </h3>
              <p> CUSTOMER ASSIGNED</p>

              <div class="dash-boad1-rt-move-no">{{$assigned}}</div>
            </div>
             <a href="/assigned-gps" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
        
            </div>
        </div>
       
        <div class="col-lg-3 col-md-6 col-sm-12  transferred_gps_dashboard_grid dash_grid">
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3>
                <div class="loader"></div>
              </h3>
              <p> CUSTOMER ASSIGNED TODAY</p>
              <div class="dash-boad1-rt-move-no">{{$gpstdy}}</div>
            </div>
               <a href="/assigned-gps" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
        
            </div>
        </div>  
        <div class="col-lg-3 col-md-6 col-sm-12  new_arrival_dashboard_grid dash_grid">
          <div class="small-box bg-yellow bxs">
            <div class="inner">
              <h3>
                <div class="loader"></div>
              </h3>
              <p> DEVICE PENDING ASSIGN</p>
              <div class="dash-boad1-rt-move-no">{{$gps}}</div>
            </div>
            <a href="/esim-renewal-pending" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>    

        <div class="col-lg-3 col-md-6 col-sm-12  gps_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-blue bxs">
            <div class="inner">
              <h3 id="todays_renewal">
                {{$todays_renewal}}
                <div class="loader"></div>
              </h3>
              <p>Today's Renewal</p>
            </div>
          
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="/gps-all" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      
      <!-- GPS Renewal Automation Widgets -->
      @if(config('renewal_automation.dashboard_widget.enabled', true))
      <div class="row mt-4">
        <div class="col-md-12 mb-3">
          <!-- Renewal Report Widget -->
          <div class="card shadow-sm" style="border-radius: 10px; overflow: hidden;">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
              <h5 class="mb-0">
                <i class="fas fa-chart-line mr-2"></i>
                Renewal Report
              </h5>
              <span class="badge badge-light" id="renewal-test-mode-badge" style="display: none;">TEST MODE</span>
            </div>
            
            <div class="card-body">
              <!-- Statistics Row -->
              <div class="row mb-3">
                <div class="col-md-2dot4 col-sm-6 mb-2">
                  <div class="stat-card stat-card-clickable" id="pending-assignments-stat-card" role="button" title="Click to view pending assignments">
                    <div class="stat-icon bg-info">
                      <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div class="stat-content">
                      <div class="stat-value" id="stat-pending-assignments">0</div>
                      <div class="stat-label">Pending Assignments</div>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-2dot4 col-sm-6 mb-2">
                  <div class="stat-card stat-card-clickable" id="active-stat-card" role="button" title="Click to view assigned GPS">
                    <div class="stat-icon bg-primary">
                      <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="stat-content">
                      <div class="stat-value" id="stat-total-assigned">0</div>
                      <div class="stat-label">Assigned GPS</div>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-2dot4 col-sm-6 mb-2">
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
                
                <div class="col-md-2dot4 col-sm-6 mb-2">
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
                
                <div class="col-md-2dot4 col-sm-6 mb-2">
                  <div class="stat-card stat-card-clickable" id="completed-today-stat-card" role="button" title="Click to view completed assignments">
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
              
              <!-- Refresh Stats Button -->
              <div class="row mb-3">
                <div class="col-md-12 text-center">
                  <button class="btn btn-secondary btn-sm" id="btn-refresh-stats">
                    <i class="fas fa-redo"></i>
                    Refresh Stats
                  </button>
                </div>
              </div>

              <!-- Call Center Performance Boxes -->
              <div class="row">
                <div class="col-md-12">
                  <h6 class="mb-3"><i class="fas fa-users"></i> Call Center Performance</h6>
                  <div id="callcenter-stats-container">
                    <div class="text-center text-muted py-3">
                      <i class="fas fa-spinner fa-spin"></i> Loading...
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Last Updated Info -->
              <div class="row mt-2">
                <div class="col-md-12">
                  <small class="text-muted">
                    <i class="fas fa-info-circle"></i>
                    Last updated: <span id="last-updated-time">Never</span>
                  </small>
                </div>
              </div>
            </div>
          </div>
          <!-- End Renewal Report Widget -->
        </div>
      </div>
      
      <!-- Automation Actions Widget removed for Sales users -->
      @endif
      <!-- End GPS Renewal Automation Widgets -->
      
    </section>
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

<style>
/* Call Center Performance Box Styles */
.col-md-2dot4 {
  flex: 0 0 20%;
  max-width: 20%;
}

@media (max-width: 768px) {
  .col-md-2dot4 {
    flex: 0 0 50%;
    max-width: 50%;
  }
}

.callcenter-performance-box {
  display: flex;
  align-items: stretch;
  margin-bottom: 10px;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.callcenter-name-box {
  background-color: #f5f5f5;
  padding: 15px 20px;
  min-width: 200px;
  display: flex;
  align-items: center;
  font-weight: 600;
  font-size: 16px;
  border-right: 2px solid #e0e0e0;
}

.callcenter-stats-boxes {
  display: flex;
  flex: 1;
  background-color: #ffffff;
}

.callcenter-stat-item {
  flex: 1;
  padding: 15px;
  text-align: center;
  border-right: 1px solid #f0f0f0;
  cursor: pointer;
  transition: all 0.3s ease;
}

.callcenter-stat-item:hover {
  background-color: #f8f9fa;
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.callcenter-stat-item:last-child {
  border-right: none;
}

.callcenter-stat-value {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 5px;
}

.callcenter-stat-value.active {
  color: #007bff;
}

.callcenter-stat-value.pending {
  color: #ffc107;
}

.callcenter-stat-value.completed {
  color: #28a745;
}

.callcenter-stat-label {
  font-size: 12px;
  color: #6c757d;
  text-transform: uppercase;
}
</style>
