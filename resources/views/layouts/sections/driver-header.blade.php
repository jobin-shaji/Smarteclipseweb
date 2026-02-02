<ul class="navbar-nav float-left mr-auto">
    <li class="nav-item d-none d-md-block">
    </li>
    <li class="nav-item">
        <a class="nav-link waves-effect waves-dark" href="{{url('/home')}}">
            <i class="fa fa-home" aria-hidden="true"></i>
        </a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> VEHICLES
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">  
           <a class="dropdown-item" href="{{url('/vehicle')}}">List Vehicles  </a>    
           </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> DEVICE
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">  
           <a class="dropdown-item" href="{{url('/gps-all')}}">MY DEVICE </a>    
          </div>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> REPORTS
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">  
           <a class="dropdown-item" href="{{url('/vehicle-report')}}">Vehicle Reports </a>    
          </div>
    </li>
    
 </ul>
