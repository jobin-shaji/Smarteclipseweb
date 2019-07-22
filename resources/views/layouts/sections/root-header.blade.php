<ul class="navbar-nav float-left mr-auto">
    <li class="nav-item d-none d-md-block">
    </li>                       
    <li class="nav-item"> 
        <a class="nav-link waves-effect waves-dark" href="{{url('/home')}}">
            <i class="fa fa-home" aria-hidden="true"></i>
        </a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> DEVICE
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{url('/gps/create')}}">ADD DEVICE</a>
            <a class="dropdown-item" href="{{url('/gps')}}">LIST DEVICE</a>  
            <a class="dropdown-item" href="{{url('/gps-transfer/create')}}">TRANSFER DEVICES</a> 
            <a class="dropdown-item" href="{{url('/gps-transfers')}}">DEVICE TRANSFER LOG</a> 
            <a class="dropdown-item" href="{{url('/gps-transferred')}}">TRANSFERRED DEVICES</a>
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> USER
        </a>
        <ul class="dropdown-menu multi-level">
            <li class="dropdown-submenu">
                <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >DEALERS</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{url('/dealer/create')}}">ADD DEALER</a></li>
                <li><a class="dropdown-item" href="{{url('/dealers')}}">LIST DEALERS</a></li>
                </ul>
            </li>
            <li class="dropdown-submenu">
                <a href="#" class="dropdown-item dropdown-toggle" data-toggle="dropdown">SUB DEALERS</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{url('/sub-dealers')}}">LIST SUB DEALERS</a></li>
                </ul>
            </li>
            <li class="dropdown-submenu">
                <a href="#" class="dropdown-item dropdown-toggle" data-toggle="dropdown">SERVICE ENGINEERS</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{url('create-servicer')}}">ADD SERVICE ENGINEER</a></li>
                <li><a class="dropdown-item" href="{{url('/servicers')}}">LIST SERVICE ENGINEERS</a></li>
                </ul>
            </li>
        </ul>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> VEHICLE
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{url('/vehicle-root')}}">LIST VEHICLES<span></span></a> 
            <a class="dropdown-item" href="{{url('/vehicle-types')}}">VEHICLE CATAGORIES<span></span></a> 
            <a class="dropdown-item" href="{{url('/vehicle-type/create')}}">ADD VEHICLE CATAGORY<span></span></a>
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> ALERT
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{url('/alert-type/create')}}">ADD ALERT TYPE<span></span></a>   
            <a class="dropdown-item" href="{{url('/alert-types')}}">LIST ALERT TYPES<span></span></a><a class="dropdown-item" href="{{url('/ota-type/create')}}">ADD OTA<span></span></a>   
        </a><a class="dropdown-item" href="{{url('/ota-type')}}">OTA LIST<span></span></a>  
        </div>
    </li>       
</ul>