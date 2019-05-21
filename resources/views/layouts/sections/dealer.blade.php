
<li class="treeview">
    <a href="#">
      <i class="fa fa-user-plus"></i>
      <span>Sub Dealer</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu" style="display: none;">
      <li><a href="{{url('/sub-dealer/create')}}"><i class="fa fa-plus"></i>Add Sub Dealer</a></li>
      <li><a href="{{url('/subdealers')}}"><i class="fa fa-list"></i> List Sub Dealers</a></li>
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
      <li><a href="{{url('/gps-dealer')}}"><i class="fa fa-list"></i> List GPS</a></li>
      <li><a href="{{url('/gps-transfer/create')}}"><i class="fa fa-list"></i> GPS Transfer</a></li>
      <li><a href="{{url('/gps-transfers')}}"><i class="fa fa-list"></i> GPS Transfer List</a></li>
  </ul>
</li>

<li class="treeview">
    <a href="#">
      <i class="fa fa-user-plus"></i>
      <span>End User</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu" style="display: none;">
     <li><a href="{{url('/dealer-client')}}"><i class="fa fa-list"></i> List Client</a></li>

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
      <li><a href="{{url('/vehicle-dealer')}}"><i class="fa fa-list"></i> List Vehicles</a></li>
  </ul>
</li>



