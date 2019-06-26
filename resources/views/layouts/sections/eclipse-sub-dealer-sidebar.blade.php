<li class="sidebar-item"> 
  <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/home')}}" aria-expanded="false">
    <i class="mdi mdi-view-dashboard"></i>
    <span class="hide-menu">Dashboard</span>
  </a>
</li>
<li class="sidebar-item">
  <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-tablet-ipad"></i>
    <span class="hide-menu">End User</span>
  </a>
  <ul aria-expanded="false" class="collapse  first-level">
    <li class="sidebar-item">
      <a href="{{url('/client/create')}}" class="sidebar-link">
        <i class="mdi mdi-note-plus"></i>
        <span class="hide-menu">Add End User</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a href="{{url('/clients')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">List End User</span>
      </a>
    </li>
  </ul>
</li>
<li class="sidebar-item">
  <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
    <i class="mdi mdi-tablet-ipad"></i>
    <span class="hide-menu">Device</span>
  </a>
  <ul aria-expanded="false" class="collapse  first-level">
    <li class="sidebar-item">
      <a href="{{url('/gps-new')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu"> New Arrivals</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a href="{{url('/gps-sub-dealer')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">List Device</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a href="{{url('/gps-transfer/create')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">Device Transfer</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a href="{{url('/gps-transfers')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">Device Transfer List</span>
      </a>
    </li>
   </ul>
</li>

<li class="sidebar-item">
  <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-car"></i>
    <span class="hide-menu">Vehicle</span>
  </a>
  <ul aria-expanded="false" class="collapse  first-level">  
    <li class="sidebar-item">
      <a href="{{url('/vehicle-sub-dealer')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">List Vehicles</span>
      </a>
    </li>
  </ul>
</li>
