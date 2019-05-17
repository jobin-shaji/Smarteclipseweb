<li class="treeview">
    <a href="#">
      <i class="fa fa-user-plus"></i>
      <span>Client</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu" style="display: none;">
      <li><a href="{{url('/client/create')}}"><i class="fa fa-plus"></i>Add Client</a></li>
      <li><a href="{{url('/clients')}}"><i class="fa fa-list"></i> List Client</a></li>
  </ul>
</li>


<li class="treeview">
  <a href="#">
      <i class="fa fa-mobile fa-lg"></i>
      <span>GPS</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu" style="display: none;">
      <li><a href="{{url('/gps-new')}}"><i class="fa fa-list"></i> New Arrivals</a></li>
      <li><a href="{{url('/gps-sub-dealer')}}"><i class="fa fa-list"></i> List GPS</a></li>
      <li><a href="{{url('/gps-transfer/create')}}"><i class="fa fa-list"></i> GPS Transfer</a></li>
      <li><a href="{{url('/gps-transfers')}}"><i class="fa fa-list"></i> GPS Transfer List</a></li>
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
      <li><a href="{{url('/vehicle-sub-dealer')}}"><i class="fa fa-list"></i> List Vehicles</a></li>
  </ul>
</li>



