<li class="sidebar-item"> 
  <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/home')}}" aria-expanded="false">
    <i class="mdi mdi-view-dashboard"></i>
    <span class="hide-menu">Dashboard</span>
  </a>
</li>
<li class="sidebar-item">
  <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
    <i class="mdi mdi-tablet-ipad"></i>
    <span class="hide-menu">Device</span>
  </a>
  <ul aria-expanded="false" class="collapse  first-level">
    <li class="sidebar-item">
      <a href="{{url('/gps/create')}}" class="sidebar-link">
        <i class="mdi mdi-note-plus"></i>
        <span class="hide-menu">Add Device</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a href="{{url('/gps-transferred')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu"> List Device</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a href="{{url('/gps-transferred')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">Transferred Device List</span>
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
  <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-user"></i>
    <span class="hide-menu">Dealer</span>
  </a>
  <ul aria-expanded="false" class="collapse  first-level">
    <li class="sidebar-item">
      <a href="{{url('/dealer/create')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">Add Dealer</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a href="{{url('/dealers')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">List Dealer</span>
      </a>
    </li>
  </ul>
</li>
<li class="sidebar-item">
  <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-user"></i>
    <span class="hide-menu">Sub Dealer</span>
  </a>
  <ul aria-expanded="false" class="collapse  first-level">  
    <li class="sidebar-item">
      <a href="{{url('/sub-dealers')}}" class="sidebar-link">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">List Sub Dealer</span>
      </a>
    </li>
  </ul>
</li>
