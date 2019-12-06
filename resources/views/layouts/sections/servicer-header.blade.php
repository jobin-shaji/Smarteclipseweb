<ul class="navbar-nav float-left mr-auto">
    <li class="nav-item d-none d-md-block">
    </li>                       
   <!--  <li class="nav-item search-box"> 
    </li> -->
     <li class="nav-item"> 
         <a class="nav-link waves-effect waves-dark" href="{{url('/home')}}">
            <i class="fa fa-home" aria-hidden="true"></i>
        </a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> JOBS
        </a>
       <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{url('/job-list')}}"> INSTALLATION JOB LIST </a>
              <a class="dropdown-item" href="{{url('/service-job-list')}}"> SERVICE JOB LIST </a>    
            <a class="dropdown-item" href="{{url('/job-history-list')}}">
             INSTALLATION JOB HISTORY </a>
             <a class="dropdown-item" href="{{url('/servicerjob-history-list')}}">
             SERVICE JOB HISTORY </a>
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> COMPLAINTS
        </a>
       <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{url('/complaint-list')}}">COMPLAINT LIST </a>  
            <a class="dropdown-item" href="{{url('/complaint-history-list')}}">COMPLAINT HISTORY </a>  
                                     
        </div>
    </li>
     <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> VEHICLES
        </a>
       <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{url('/servicer-vehicle')}}">VEHICLES LIST </a>  
        </div>
    </li>


       <!--  <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> USER
            </a>
            <ul class="dropdown-menu multi-level">
                <li class="dropdown-submenu">
                    <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >END USER</a>
                    <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{url('/client/create')}}">ADD END USER</a></li>
                    <li><a class="dropdown-item" href="{{url('/clients')}}">LIST END USERS</a></li>
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
         
            <a class="dropdown-item" href="{{url('/vehicle-sub-dealer')}}">LIST VEHICLES<span></span></a>                                                             
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> REPORTS
        </a>
       <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <div class="dropdown-divider"></div>
         <a class="dropdown-item" href="{{url('/log-report')}}">DEVICE ACTIVATION REPORT<span></span></a>
        </div>
    </li> -->
</ul>