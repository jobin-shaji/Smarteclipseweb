<ul class="navbar-nav float-left mr-auto">
  <li class="nav-item d-none d-md-block">
  </li>                      
         <!--  <li class="nav-item search-box">
          </li> -->
  <li class="nav-item">
      <a class="nav-link waves-effect waves-dark" href="{{url('/home')}}">
          <i class="fa fa-home i.fa.fa-home" aria-hidden="true" style="font-size: 2em!important;padding: 35% 0 0 0;margin-top: 2px"></i>
      </a>
  </li>

  <li class="nav-item dropdown-submenu">
      <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">VEHICLE
      </a>
      <ul class="dropdown-menu multi-level">
          <li class="dropdown-submenu">
              <!-- <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >VEHICLE</a>
              <ul class="dropdown-menu"> -->

  <li><a class="dropdown-item" href="/vehicles/create">Add VEHICLES</a></li>
                                     
              <li><a class="dropdown-item" href="{{url('/vehicle')}}">LIST VEHICLES</a></li>
              <li><a class="dropdown-item" href="{{url('/all-vehicle-docs')}}">VEHICLE DOCUMENTS</a></li>
              <li><a class="dropdown-item" href="{{url('/vehicle-driver-log')}}">DRIVER UPDATE LOG</a></li>
              <li><a class="dropdown-item" href="/on-demand-report">GENERAL TRIP REPORT LIST</a></li>
              <li><a class="dropdown-item" href="{{url('/trip-report-client')}}">TRIP REPORTS</a></li>
              <li><a class="dropdown-item" href="{{url('/bulk-sms')}}">SEND BULK SMS</a></li>
              @role('fundamental|superior|pro')
              <!-- <li><a class="dropdown-item" href="{{url('/invoice')}}">INVOICE</a></li> -->
                  @endrole
              <!-- </ul> -->
          </li>
      </ul>
  </li>

  <li class="nav-item dropdown-submenu">
      <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> DRIVER
      </a>
      <ul class="dropdown-menu multi-level">
          <li class="dropdown-submenu">
              <!-- <a href="#" class="dropdown-item dropdown-toggle" data-toggle="dropdown">DRIVER</a>
              <ul class="dropdown-menu"> -->
             
              <li><a class="dropdown-item" href="/driver/create">ADD DRIVER</a></li>
              <li><a class="dropdown-item" href="{{url('/drivers')}}">DRIVER LIST</a></li>
              @role('fundamental|superior|pro')
              <li><a class="dropdown-item" href="{{url('/drivers-score-page')}}">DRIVER SCORE</a></li>
              <li><a class="dropdown-item" href="{{url('/performance-score-history')}}">PERFORMANCE SCORE HISTORY</a></li>
              @endrole
              <!-- </ul> -->
          </li>
      </ul>
  </li>

  <li class="nav-item dropdown-submenu">
      <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> GEOFENCE
      </a>
      <ul class="dropdown-menu multi-level">
          <li class="dropdown-submenu">
              <li><a class="dropdown-item" href="{{url('/fence')}}">ADD GEOFENCE</a></li>
              <li><a class="dropdown-item" href="{{url('/geofence')}}">LIST GEOFENCES</a></li>
              <li><a class="dropdown-item" href="{{url('/assign/geofence-vehicle')}}">ASSIGN GEOFENCE</a></li>
          </li>
      </ul>
  </li>
  @role('fundamental|superior|pro')
  <li class="nav-item dropdown-submenu">
      <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> ROUTE
      </a>
      <ul class="dropdown-menu multi-level">
          <li class="dropdown-submenu">
              <li><a class="dropdown-item" href="{{url('/route/create')}}">ADD ROUTE</a></li>
              <li><a class="dropdown-item" href="{{url('/route')}}">LIST ROUTES</a></li>
              <li><a class="dropdown-item" href="{{url('/assign/route-vehicle')}}">ASSIGN ROUTE</a></li>
          </li>
      </ul>
  </li>
  @endrole          

  <li class="nav-item dropdown-submenu">
      <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> COMPLAINTS
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{url('/complaint/create')}}"> ADD COMPLAINT <span></span></a>                              
          <a class="dropdown-item" href="{{url('/complaint')}}"> LIST COMPLAINTS<span></span></a>
          <a class="dropdown-item" href="{{url('/returned-gps')}}"> LIST RETURNED DEVICES<span></span></a>                              
      </div>
     
  </li>

  <li class="nav-item dropdown-submenu">
      <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> JOBS
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{url('/client-job-list')}}"> JOB LIST<span></span></a>                              
                                        
      </div>
     
  </li>
  <li class="nav-item dropdown-submenu">
      <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> REPORTS
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <div class="dropdown-divider"></div>
          <ul class="ecosystem">
              
              <li class="sys_vapor cover_total_km">
                  <a href="{{url('/client-renewal-report')}}">
                      <div class="system_icon">
                          <img src="{{ url('/') }}/Report-icons/report-2.png"  />
                      <span class="system_info" >Renewal Report</span>
                      </div>
                  </a>
              </li>
              <li class="sys_vapor cover_total_km">
                  <a href="{{url('/total-km-report')}}">
                      <div class="system_icon">
                          <img src="{{ url('/') }}/Report-icons/report-2.png"  />
                      <span class="system_info" >Total KM Report</span>
                      </div>
                  </a>
              </li>
              <li class="sys_vapor cover_vehicle_report">
                  <a href="{{url('/vehicle-report')}}">
                      <div class="system_icon">
                          <img src="{{ url('/') }}/Report-icons/vehicle-report.png"  />
                      <span class="system_info" >Vehicle Report</span>
                      </div>  
                  </a>
              </li>

              <li class="sys_vapor cover_geofence">
                  <a href="{{url('/geofence-report')}}">
                      <div class="system_icon">
                          <img src="{{ url('/') }}/Report-icons/geofence-report.png"  />
                          <span class="system_info"> Geofence Report</span>
                      </div>
                      
                  </a>
              </li>

              <li class="sys_vapor cover_over_speed">
                  <a href="{{url('/over-speed-report')}}">
                      <div class="system_icon">
                          <img src="{{ url('/') }}/Report-icons/overspeed-report.png"  />
                      <span class="system_info" >Over Speed Report</span>
                      </div>
                      
                  </a>
              </li>

              <li class="sys_vapor cover_tracking_report">
                  <a href="{{url('/tracking-report')}}">
                      <div class="system_icon">
                          <img src="{{ url('/') }}/Report-icons/tracking-report.png"  />
                      <span class="system_info" >Tracking Report </span>
                      </div>
                      
                  </a>
              </li>

              @role('fundamental|superior|pro')
              <li class="sys_vapor cover_deviation_report">
                  <a href="{{url('/route-deviation-report')}}">
                      <div class="system_icon">
                          <img src="{{ url('/') }}/Report-icons/route-deviation-report.png"  />
                          <span class="system_info" >Route Deviation Report</span> 
                      </div>
                  </a>
              </li>
              @endrole

              <li class="sys_vapor cover_harsh_bracking">
                  <a href="{{url('/harsh-braking-report')}}">
                      <div class="system_icon">
                          <img src="{{ url('/') }}/Report-icons/braking-report.png"  />

                      <span class="system_info" >Harsh Braking Report</span>
                      </div>
                      
                  </a>
              </li>
              <li class="sys_vapor cover_dailyreport">
                  <a href="{{url('/daily-km-report')}}">
                      <div class="system_icon">
                          <img src="{{ url('/') }}/Report-icons/report-1.png"  />
                          <span class="system_info">Daily KM Report </span></div>
                      
                  </a>
              </li>

              <li class="sys_vapor sudden_acceleration">
                  <a href="{{url('/sudden-acceleration-report')}}">
                      <div class="system_icon">
                          <img src="{{ url('/') }}/Report-icons/accelaration-report.png"  />
                      <span class="system_info" >Sudden Acceleration</span>
                      </div>
                      
                  </a>
              </li>

              <li class="sys_vapor cover_alertreport">
                  <a href="{{url('/alert-report')}}">
                      <div class="system_icon">
                          <img src="{{ url('/') }}/Report-icons/alert-report.png"  />
                      <span class="system_info" >Alert Report </span>
                      </div>
                      
                  </a>
              </li>

              <li class="sys_vapor cover_zig_zag">
                  <a href="{{url('/zigzag-driving-report')}}">
                      <div class="system_icon">
                          <img src="{{ url('/') }}/Report-icons/zigzag-report.png"  />
                      <span class="system_info" >Zig-Zag Driving Report</span>
                      </div>
                  
                  </a>
              </li>

              <li class="sys_vapor cover_accident">
                  <a href="{{url('/accident-imapct-alert-report')}}">
                      <div class="system_icon">
                          <img src="{{ url('/') }}/Report-icons/accident-impact-report.png"  />
                          <span class="system_info" >Accident Impact Alert</span>
                      </div>
                      
                  </a>
              </li>
              <li class="sys_vapor cover_idle_report">
                  <a href="{{url('/idle-report')}}">
                      <div class="system_icon">
                          <img src="{{ url('/') }}/Report-icons/idle-report.png"  />
                      <span class="system_info" >Halt Report</span>
                      </div>
                      
                  </a>
              </li>

              <li class="sys_vapor cover_parking_report">
                  <a href="{{url('/parking-report')}}">
                      <div class="system_icon">
                          <img src="{{ url('/') }}/Report-icons/parking-report.png"  />
                          <span class="system_info" >Parking Report</span>  
                      </div>
                      
                  </a>
              </li>
              <li class="sys_vapor cover_main_battery">
                  <a href="{{url('/mainbattery-disconnect-report')}}">
                      <div class="system_icon">
                          <img src="{{ url('/') }}/Report-icons/main-battery-disconnect-report.png"  />
                          <span class="system_info" >Main Battery Disconnect</span> 
                      </div>
                      
                  </a>
              </li>

              @role('superior|pro')
              <li class="sys_vapor cover_accident">
                  <a href="{{url('/fuel-reports')}}">
                      <div class="system_icon">
                          <img src="{{ url('/') }}/Report-icons/report-1.png"  />
                          <span class="system_info" >Fuel Report</span> 
                      </div>
                      
                  </a>
              </li>
              @endrole
                  
          </ul>
      </div>
  </li>
  <li class="nav-item dropdown-submenu">
      <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> SETTINGS
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <div class="dropdown-divider"></div>
      @role('fundamental|superior|pro')
          <a class="dropdown-item" href="{{url('/performance-score')}}">ALERT POINTS <span></span></a>  
      @endrole
          <a class="dropdown-item" href="{{url('/alert-manager')}}"> ALERT NOTIFICATION MANAGER <span></span></a>
      </div>
  </li>
         
  @if(!\Auth::user()->hasRole(['pro']))
  <li class="nav-item dropdown" >
      <a class="nav-link dropdown-toggle waves-effect waves-dark" aria-haspopup="true" aria-expanded="false" style="color: green !important" href="{{url('go-premium')}}"> UPGRADE   
      </a>
  </li>
  @endif


</ul>
