+<li class="treeview">
  <a href="#">
      <i class="fa fa-mobile fa-lg"></i>
      <span>GPS</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu" style="display: none;">
      <li><a href="{{url('/gps-client')}}"><i class="fa fa-list"></i> List GPS</a></li>
  </ul>
</li>
<li class="treeview">
    <a href="#">
      <i class="fa fa-bus"></i>
      <span>Vehicle</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu" style="display: none;">
      <li><a href="/vehicles/create"><i class="fa fa-plus"></i>Add Vehicle</a></li>
      <li><a href="{{url('/vehicle')}}"><i class="fa fa-list"></i> List Vehicles</a></li>
  </ul>
</li>
<li class="treeview">
    <a href="#">
      <i class="fa fa-user-plus"></i>
      <span>Driver</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu" style="display: none;">
      <li><a href="/driver/create"><i class="fa fa-plus"></i>Add Driver</a></li>
      <li><a href="{{url('/drivers')}}"><i class="fa fa-list"></i> List Driver</a></li>
  </ul>
</li>

<li class="treeview">
    <a href="#">
      <i class="fa fa-bell"></i>
      <span>Alerts</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu" style="display: none;">
      <li><a href="{{url('/alerts')}}"><i class="fa fa-list"></i> List Alerts</a></li>
  </ul>
</li>

<li class="treeview">
    <a href="#">
      <i class="fa fa-bus"></i>
      <span>Geofence</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu" style="display: none;">
      <li><a href="{{url('/fence')}}"><i class="fa fa-plus"></i>Add Geofence</a></li>
      <li><a href="{{url('/geofence')}}"><i class="fa fa-list"></i> List Geofence</a></li>
  </ul>
</li>

<li class="treeview">
    <a href="#">
      <i class="fa fa-files-o"></i>
      <span>Reports</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu" style="display: none;">
      <li><a href="{{url('/geofence-report')}}"><i class="fa fa-list"></i>Geofence Report</a></li>
      <li><a href="{{url('/alert-report')}}"><i class="fa fa-list"></i>Alert Report</a></li>
      <li><a href="{{url('/tracking-report')}}"><i class="fa fa-list"></i>Tracking Report</a></li>
      <li><a href="{{url('/route-deviation-report')}}"><i class="fa fa-list"></i>Route Deviation Report</a></li>
  </ul>
</li>






