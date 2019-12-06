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
            <!-- <a class="dropdown-item" href="{{url('/gps/create')}}">ADD DEVICE</a> -->
            <!-- <a class="dropdown-item" href="{{url('/gps/stock')}}">ADD STOCK</a> -->
            <!-- <a class="dropdown-item" href="{{url('/gps')}}">IN STOCK</a>   -->
            <a class="dropdown-item" href="{{url('/gps-all')}}">ALL DEVICES</a> 
            <a class="dropdown-item" href="{{url('/gps-transfer-root')}}">TRANSFER DEVICES</a> 
            <a class="dropdown-item" href="{{url('/gps-transferred-root')}}">DEVICE TRANSFER LOG</a> 
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> SOS
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{url('/sos/create')}}">ADD SOS</a>
            <a class="dropdown-item" href="{{url('/sos')}}">IN STOCK</a>  
            <a class="dropdown-item" href="{{url('/sos-transfer-root/create')}}">TRANSFER SOS</a> 
            <a class="dropdown-item" href="{{url('/sos-transfers')}}">SOS TRANSFER LOG</a> 
            <a class="dropdown-item" href="{{url('/sos-transferred')}}">TRANSFERRED SOS</a>
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> USER
        </a>
        <ul class="dropdown-menu multi-level">
            <li class="dropdown-submenu">
                <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >DISTRIBUTORS</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{url('/dealer/create')}}">ADD DISTRIBUTOR</a></li>
                <li><a class="dropdown-item" href="{{url('/dealers')}}">LIST DISTRIBUTORS</a></li>
                </ul>
            </li>

            <li class="dropdown-submenu">
                <a href="#" class="dropdown-item dropdown-toggle" data-toggle="dropdown">DEALERS</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{url('/sub-dealers')}}">LIST DEALERS</a></li>
                </ul>
            </li>
            <li class="dropdown-submenu">
                <a href="#" class="dropdown-item dropdown-toggle" data-toggle="dropdown">END USERS</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{url('/root/client/create')}}">ADD END USER</a></li>
                <li><a class="dropdown-item" href="{{url('/client')}}">LIST END USERS</a></li>
                </ul>
            </li>
            <li class="dropdown-submenu">
                <a href="#" class="dropdown-item dropdown-toggle" data-toggle="dropdown">SERVICE ENGINEERS</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{url('create-servicer')}}">ADD SERVICE ENGINEER</a></li>
                <li><a class="dropdown-item" href="{{url('/servicers')}}">LIST SERVICE ENGINEERS</a></li>
                <li><a class="dropdown-item" href="{{url('/assign-servicer')}}">CREATE JOB</a></li>
                <li><a class="dropdown-item" href="{{url('/assign-servicer-list')}}">LIST JOBS</a></li>
                <li><a class="dropdown-item" href="{{url('/servicer-job-history-list')}}">JOBS HISTORY</a></li>
                </ul>
            </li>
            <li class="dropdown-submenu">
                <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >OPERATIONS</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{url('/operations/create')}}">ADD USER (OPERATION)</a></li>
                <li><a class="dropdown-item" href="{{url('/operations')}}">LIST USER (OPERATION)</a></li>
                </ul>
            </li>
        </ul>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> VEHICLE
        </a>
        <ul class="dropdown-menu multi-level">
            <a class="dropdown-item" href="{{url('/vehicle-root')}}">LIST VEHICLES<span></span></a>
            <li class="dropdown-submenu">
                <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >VEHICLE CATEGORY</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{url('/vehicle-type/create')}}">ADD VEHICLE CATEGORY</a></li>
                <li><a class="dropdown-item" href="{{url('/vehicle-types')}}">VEHICLE CATEGORIES</a></li>
                </ul>
            </li>
            <!-- <li class="dropdown-submenu">
                <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >SUBSCRIPTION</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{url('/subscription/create')}}">ADD SUBSCRIPTION</a></li>
                <li><a class="dropdown-item" href="{{url('/subscription')}}">LIST SUBSCRIPTION</a></li>
                </ul>
            </li> -->
            <li class="dropdown-submenu">
                <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >TRAFFIC RULES</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{url('/traffic-rule/create')}}">ADD TRAFFIC RULE</a></li>
                <li><a class="dropdown-item" href="{{url('/traffic-rule')}}">LIST TRAFFIC RULES</a></li>
                </ul>
            </li>
        </ul>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> ALERT
        </a>
        <ul class="dropdown-menu multi-level">
            <li class="dropdown-submenu">
                <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >ALERT</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{url('/alert-type/create')}}">ADD ALERT TYPE</a></li>
                <li><a class="dropdown-item" href="{{url('/alert-types')}}">LIST ALERT TYPES</a></li>
                </ul>
            </li>
            <li class="dropdown-submenu">
                <a href="#" class="dropdown-item dropdown-toggle" data-toggle="dropdown">OTA</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{url('/ota-type/create')}}">ADD OTA</a></li>
                <li><a class="dropdown-item" href="{{url('/ota-type')}}">OTA LIST</a></li>
                </ul>
            </li>
        </ul>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> EMPLOYEES
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{url('/employee/create')}}">ADD EMPLOYEE<span></span></a> 
            <a class="dropdown-item" href="{{url('/employee')}}">LIST EMPLOYEES<span></span></a> 
        </div>
    </li>  
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> COMPLAINTS
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{url('/complaint-type/create')}}">ADD COMPLAINT TYPE<span></span></a> 
            <a class="dropdown-item" href="{{url('/complaint-type')}}">LIST COMPLAINT TYPES<span></span></a> 
            <a class="dropdown-item" href="{{url('/complaint')}}">LIST COMPLAINTS<span></span></a>
            <a class="dropdown-item" href="{{url('/complaint-history-list')}}">COMPLAINT HISTORY </a>  
        </div>
    </li>  
      <li class="nav-item dropdown">
        <a class="nav-link waves-effect waves-dark" href="{{url('/map-view')}}"  aria-haspopup="true" > MAP VIEW
        </a>
        <!-- <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{url('/complaint-type/create')}}">ADD COMPLAINT TYPE<span></span></a> 
            <a class="dropdown-item" href="{{url('/complaint-type')}}">LIST COMPLAINT TYPES<span></span></a> 
            <a class="dropdown-item" href="{{url('/complaint')}}">LIST COMPLAINTS<span></span></a>
            <a class="dropdown-item" href="{{url('/complaint-history-list')}}">COMPLAINT HISTORY </a>  
        </div> -->
    </li> 
    </li>
    <!--   <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> CONFIGURATION
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{url('/configuration-create')}}">ADD CONFIGURATION </a>          
        </div>
    </li>  -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> SETTINGS
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{url('/subscription/create')}}">ADD WARRANTY AND PLANS </a>
            <a class="dropdown-item" href="{{url('/subscription')}}">LIST WARRANTY AND PLANS </a>
          
        </div>
    </li> 
  
</ul>
