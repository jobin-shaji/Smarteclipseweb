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
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-12  new_arrival_dashboard_grid dash_grid">
          <div class="small-box bg-yellow bxs">
            <div class="inner">
              <h3>{{ $followups_due_today ?? 0 }}</h3>
              <p> TODAY'S FOLLOW UP</p>
            </div>
            <a href="/followups-due-today" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12  transferred_gps_dashboard_grid dash_grid">
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3>
                <div class="loader"></div>
              </h3>
              <p> PENDING FOLLOW UP</p>
            </div>
            <a href="/assigned-gps?type=0" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
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
              <a href="/assigned-gps" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
       
            </div>
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
              <a href="/assigned-gps" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
       
            </div>
            </div>
        </div>  
          
        

       

       

  <div class="col-lg-3 col-md-6 col-sm-12  gps_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-blue bxs">
            <div class="inner">
              <h3 id="todays_renewal">
                <div class="loader">{{$assigned}}</div>
              </h3>
              <p>Upcoming Renewals</p>
              <a href="/assigned-gps" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
       
            </div>

                     
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            </div>
        </div>

         <div class="col-lg-3 col-md-6 col-sm-12  gps_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-blue bxs">
            <div class="inner">
              <h3 id="todays_collection">
                <div class="loader">{{$todays_collection}}</div>
              </h3>
              <p>Today's Collection</p>
            </div>
            
            </div>
          </div>
        <div class="col-lg-3 col-md-6 col-sm-12  gps_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-blue bxs">
            <div class="inner">
              <h3 id="todays_renewal">
                <div class="loader">{{$total_renewal}}</div>
              </h3>
              <p>Completed Previous Renewals</p>
              <a href="/renewed-gps" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
       
            </div>

                     
            <div class="icon">
              <i class="fa fa-user"></i>
             
            </div>
            </div>
        </div>

      </div>
    </section>

    <!-- GPS Renewal Automation Premium Widget -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card renewal-automation-widget">
            <div class="card-header">
              <h4 class="mb-0" style="color: white;">
                <i class="fas fa-sync-alt"></i> Renewal
              </h4>
            </div>
            <div class="card-body">
              <div class="row" id="renewal-stats">
                <!-- Assigned to You -->
                <div class="col-lg-3 col-md-6 mb-3">
                  <div class="stat-card stat-card-clickable" id="assigned-stat-card">
                    <div class="stat-icon bg-primary">
                      <i class="fas fa-user-check"></i>
                    </div>
                    <div class="stat-content">
                      <div class="stat-value" id="stat-assigned">
                        <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                      </div>
                      <div class="stat-label">Assigned to You</div>
                    </div>
                  </div>
                </div>

                <!-- Follow-ups Pending -->
                <div class="col-lg-3 col-md-6 mb-3">
                  <div class="stat-card stat-card-clickable" id="followup-stat-card">
                    <div class="stat-icon bg-warning">
                      <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="stat-content">
                      <div class="stat-value" id="stat-followup">
                        <div class="spinner-border spinner-border-sm text-warning" role="status"></div>
                      </div>
                      <div class="stat-label">Follow-ups Pending</div>
                    </div>
                  </div>
                </div>

                <!-- Completed Today -->
                <div class="col-lg-3 col-md-6 mb-3">
                  <div class="stat-card stat-card-clickable" id="completed-today-stat-card-cc">
                    <div class="stat-icon bg-success">
                      <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                      <div class="stat-value" id="stat-completed-today">
                        <div class="spinner-border spinner-border-sm text-success" role="status"></div>
                      </div>
                      <div class="stat-label">Completed Today</div>
                    </div>
                  </div>
                </div>

                <!-- This Month Revenue -->
                <div class="col-lg-3 col-md-6 mb-3">
                  <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                      <i class="fas fa-rupee-sign"></i>
                    </div>
                    <div class="stat-content">
                      <div class="stat-value" id="stat-month-revenue">
                        <div class="spinner-border spinner-border-sm" style="color: #8b5cf6;" role="status"></div>
                      </div>
                      <div class="stat-label">Todays Revenue</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

<link rel="stylesheet" href="{{ asset('css/renewal-automation.css') }}">

<script>
$(document).ready(function() {
    let statsLoading = false; // Prevent concurrent requests
    
    // Load renewal automation statistics for call center
    function loadRenewalStats() {
        if (statsLoading) {
            console.log('Stats request already in progress, skipping...');
            return;
        }
        
        statsLoading = true;
        
        $.ajax({
            url: '{{ route("renewal.stats") }}',
            method: 'GET',
            cache: false,
            data: {
                callcenter_id: '{{ \Auth::user()->callcenter->id ?? "" }}',
                _t: new Date().getTime()
            },
            success: function(response) {
                if (response.success) {
                    const stats = response.stats;
                    
                    // Update stat values with animation
                    $('#stat-assigned').html(stats.assigned);
                    $('#stat-followup').html(stats.pending_followup);
                    $('#stat-completed-today').html(stats.completed_today);
                    $('#stat-month-revenue').html('₹' + formatNumber(stats.month_revenue));
                }
            },
            error: function() {
                $('#stat-assigned').html('--');
                $('#stat-followup').html('--');
                $('#stat-completed-today').html('--');
                $('#stat-month-revenue').html('--');
            },
            complete: function() {
                statsLoading = false;
            }
        });
    }

    // Format number with commas
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // Click handler for Assigned stat card
    $('#assigned-stat-card').on('click', function() {
        window.location.href = '/auto-assigned-renewals?status=assigned&callcenter_id={{ \Auth::user()->callcenter->id ?? "" }}';
    });

    // Click handler for Follow-up stat card
    $('#followup-stat-card').on('click', function() {
        window.location.href = '/auto-assigned-renewals?status=pending&callcenter_id={{ \Auth::user()->callcenter->id ?? "" }}';
    });

    // Click handler for Completed Today stat card
    $('#completed-today-stat-card-cc').on('click', function() {
        window.location.href = '/auto-assigned-renewals?status=completed&callcenter_id={{ \Auth::user()->callcenter->id ?? "" }}';
    });

    // Load stats on page load
    loadRenewalStats();

    // Refresh stats every 60 seconds
    setInterval(loadRenewalStats, 60000);
});
</script>
