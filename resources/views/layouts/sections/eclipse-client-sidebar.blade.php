<li class="sidebar-item"> 
  <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/home')}}" aria-expanded="false">
    <i class="mdi mdi-view-dashboard"></i>
    <span class="hide-menu">Dashboard</span>
  </a>
</li>
<li class="sidebar-item">
  <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
    <i class="mdi mdi-car"></i>
    <span class="hide-menu">Vehicle</span>
  </a>
  <ul aria-expanded="false" class="collapse  first-level">
    <li class="sidebar-item">
      <a href="{{route('vehicles.create')}}" class="sidebar-link">
        <i class="mdi mdi-note-plus"></i>
        <span class="hide-menu">Add Vehicle</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a href="{{url('/vehicle')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">List Vehicle</span>
      </a>
    </li>
   </ul>
</li>
<li class="sidebar-item">
  <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-tablet-ipad"></i>
    <span class="hide-menu">Device</span>
  </a>
  <ul aria-expanded="false" class="collapse  first-level">
    <li class="sidebar-item">
      <a href="{{url('/gps-new')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">New Arrivals</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a href="{{url('/gps-client')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">List Device</span>
      </a>
    </li>
  </ul>
</li>
<li class="sidebar-item">
  <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/alert')}}" aria-expanded="false">
    <i class="mdi mdi-bell-ring"></i>
    <span class="hide-menu">Alerts</span>
  </a>
</li>
  
<li class="sidebar-item"> 
  <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/alert-manager')}}" aria-expanded="false">
    <i class="mdi mdi-clipboard-alert"></i>
    <span class="hide-menu">Alert Manager</span>
  </a>
</li>
<li class="sidebar-item"> 
  <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
    <i class="mdi mdi-routes"></i>
    <span class="hide-menu">Routes</span>
  </a>
  <ul aria-expanded="false" class="collapse  first-level">
    <li class="sidebar-item">
      <a href="{{url('/route/create')}}" class="sidebar-link">
        <i class="mdi mdi-note-plus"></i>
        <span class="hide-menu">Add Route</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a href="{{url('/route')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">List Vehicle</span>
      </a>
    </li>
  </ul>
</li>
<li class="sidebar-item">
  <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
    <i class="mdi mdi-settings"></i>
    <span class="hide-menu">Settings</span>
  </a>
  <ul aria-expanded="false" class="collapse  first-level">
    <li class="sidebar-item">
      <a href="{{url('/fence')}}" class="sidebar-link">
        <i class="mdi mdi-note-plus"></i>
        <span class="hide-menu">Geofence Creation</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a href="{{url('/geofence')}}" class="sidebar-link">
        <i class="mdi mdi-map-marker-circle"></i>
        <span class="hide-menu">List Geofence</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a href="{{url('/driver/create')}}" class="sidebar-link">
        <i class="mdi mdi-note-plus"></i>
        <span class="hide-menu">Driver Creation</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a href="{{url('/drivers')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">List Drivers</span>
      </a>
    </li>
  </ul>
</li>
<li class="sidebar-item">
  <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
    <i class="mdi mdi-file-document"></i>
    <span class="hide-menu">Reports</span>
  </a>
  <ul aria-expanded="false" class="collapse  first-level">
    <li class="sidebar-item"><a href="{{url('/geofence-report')}}" class="sidebar-link"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Geofence Report</span></a></li>
    <li class="sidebar-item">
      <a href="{{url('/alert-report')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">Alert Report</span>
    </a></li>
    <li class="sidebar-item">
      <a href="{{url('/tracking-report')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">Tracking Report</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a href="{{url('/route-deviation-report')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">Route Deviation Report</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a href="{{url('/harsh-braking-report')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">Harsh Braking Report</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a href="{{url('/sudden-acceleration-report')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">Sudden Acceleration Report</span>
      </a>
    </li>
     <li class="sidebar-item">
      <a href="{{url('/total-km-report')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">Total KM  Report</span>
      </a>
    </li>
     <li class="sidebar-item">
      <a href="{{url('/daily-km-report')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">Daily KM  Report</span>
      </a>
    </li>
     <li class="sidebar-item">
      <a href="{{url('/over-speed-report')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">Over Speed Report</span>
      </a>
    </li>
     <li class="sidebar-item">
      <a href="{{url('/zigzag-driving-report')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">Zig-Zag Driving Report</span>
      </a>
    </li>

    <li class="sidebar-item">
      <a href="{{url('/accident-imapct-alert-report')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">Accident Impact Alert Report</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a href="{{url('/idle-report')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">Idle Report</span>
      </a>
    </li>
     <li class="sidebar-item">
      <a href="{{url('/parking-report')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">Parking Report</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a href="{{url('/mainbattery-disconnect-report')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">Main Battery Disconnect Report</span>
      </a>
    </li>
  </ul>
</li>
                        
<li class="sidebar-item">
  <a class="sidebar-link waves-effect waves-dark sidebar-link" href="javascript:void(0)" aria-expanded="false">
    <i class="mdi mdi-comment-multiple-outline"></i>
    <span class="hide-menu">Help & Support</span>
  </a>
</li>