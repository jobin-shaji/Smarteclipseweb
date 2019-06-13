<li class="treeview">
  <a href="#">
      <i class="fa fa-mobile fa-lg"></i>
      <span>Device</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu" style="display: none;">
      <li><a href="{{url('/gps-client')}}"><i class="fa fa-list"></i> List Device</a></li>
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
      <i class="fa fa-bus"></i>
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


