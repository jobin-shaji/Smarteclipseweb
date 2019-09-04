<ul class="navbar-nav float-left mr-auto">
    <li class="nav-item d-none d-md-block">
    </li>                       
  
     <li class="nav-item"> 
         <a class="nav-link waves-effect waves-dark" href="{{url('/home')}}">
            <i class="fa fa-home" aria-hidden="true"></i>
        </a>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> VEHICLE
        </a>
        <ul class="dropdown-menu multi-level">
            <li class="dropdown-submenu">
                <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >HELPER</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{url('/helper/create')}}">ADD HELPER</a></li>
                <li><a class="dropdown-item" href="{{url('/helper')}}">LIST HELPERS</a></li>
                </ul>
            </li>
            <li class="dropdown-submenu">
                <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >VEHICLE</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{url('/vehicle')}}">LIST VEHICLES</a></li>
                <li><a class="dropdown-item" href="{{url('/all-vehicle-docs')}}">VEHICLE DOCUMENTS</a></li>
                <li><a class="dropdown-item" href="{{url('/vehicle-driver-log')}}">DRIVER UPDATE LOG</a></li>
                 @role('fundamental|superior|pro')
                <li><a class="dropdown-item" href="{{url('/invoice')}}">INVOICE</a></li>
                 @endrole
                </ul>
            </li>
            <li class="dropdown-submenu">
                <a href="#" class="dropdown-item dropdown-toggle" data-toggle="dropdown">DRIVER</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/driver/create">ADD DRIVER</a></li>
                <li><a class="dropdown-item" href="{{url('/drivers')}}">LIST DRIVERS</a></li>
                @role('fundamental|superior|pro')
                <li><a class="dropdown-item" href="{{url('/drivers-score-page')}}">DRIVER SCORE</a></li>
                @endrole
                <li><a class="dropdown-item" href="{{url('/performance-score-history')}}">PERFORMANCE SCORE HISTORY</a></li>
                </ul>
            </li>
        </ul>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> ROUTE
        </a>
        <ul class="dropdown-menu multi-level">
            <li class="dropdown-submenu">
                <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >ROUTE</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{url('/route/create')}}">ADD ROUTE</a></li>
                <li><a class="dropdown-item" href="{{url('/route')}}">LIST ROUTES</a></li>
                </ul>
            </li>

            <li class="dropdown-submenu">
                <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >ROUTE BATCH</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{url('/route-batch/create')}}">ADD ROUTE BATCH</a></li>
                <li><a class="dropdown-item" href="{{url('/route-batch')}}">LIST ROUTE BATCH</a></li>
                </ul>
            </li>
            <li class="dropdown-submenu">
                <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >SCHEDULE ROUTE</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{url('/route/schedule')}}">SCHEDULE ROUTE</a></li>
                <li><a class="dropdown-item" href="{{url('/route-schedule')}}">LIST SCHEDULED ROUTES</a></li>
                </ul>
            </li>
            
        </ul>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> STUDENT
        </a>
        <ul class="dropdown-menu multi-level">
            <li class="dropdown-submenu">
                <a href="#" class="dropdown-item dropdown-toggle" data-toggle="dropdown">CLASS</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{url('/class/create')}}">ADD CLASS</a></li>
                <li><a class="dropdown-item" href="{{url('/class')}}">LIST CLASSS</a></li>
                </ul>
            </li>

            <li class="dropdown-submenu">
                <a href="#" class="dropdown-item dropdown-toggle" data-toggle="dropdown">DIVISION</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{url('/division/create')}}">ADD DIVISION</a></li>
                <li><a class="dropdown-item" href="{{url('/division')}}">LIST DIVISIONS</a></li>
                </ul>
            </li>

            <li class="dropdown-submenu">
                <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >STUDENT</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{url('/student/create')}}">ADD STUDENT</a></li>
                <li><a class="dropdown-item" href="{{url('/student')}}">LIST STUDENTS</a></li>
                </ul>
            </li>

            <li class="dropdown-submenu">
                <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >NOTIFICATION</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{url('/student-notification/create')}}">ADD NOTIFICATION</a></li>
                <li><a class="dropdown-item" href="{{url('/student-notification')}}">LIST NOTIFICATION</a></li>
                </ul>
            </li>

        </ul>
    </li>


    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> HELPER 
        </a>
       <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{url('/helper/create')}}"> ADD HELPER <span></span></a>                               
            <a class="dropdown-item" href="{{url('/helper')}}"> LIST HELPERS<span></span></a>                                 
        </div>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> VEHICLE
        </a>
        <ul class="dropdown-menu multi-level">
            <li class="dropdown-submenu">
                <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >VEHICLE</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{url('/vehicle')}}">LIST VEHICLES</a></li>
                <li><a class="dropdown-item" href="{{url('/all-vehicle-docs')}}">VEHICLE DOCUMENTS</a></li>
                <li><a class="dropdown-item" href="{{url('/vehicle-driver-log')}}">DRIVER UPDATE LOG</a></li>
                 @role('fundamental|superior|pro')
                <li><a class="dropdown-item" href="{{url('/invoice')}}">INVOICE</a></li>
                 @endrole
                </ul>
            </li>
            <li class="dropdown-submenu">
                <a href="#" class="dropdown-item dropdown-toggle" data-toggle="dropdown">DRIVER</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/driver/create">ADD DRIVER</a></li>
                <li><a class="dropdown-item" href="{{url('/drivers')}}">LIST DRIVERS</a></li>
                @role('fundamental|superior|pro')
                <li><a class="dropdown-item" href="{{url('/drivers-score-page')}}">DRIVER SCORE</a></li>
                @endrole
                <li><a class="dropdown-item" href="{{url('/performance-score-history')}}">PERFORMANCE SCORE HISTORY</a></li>
                </ul>
            </li>
        </ul>
    </li> 

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> REPORTS 
        </a>
       <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{url('/pickup-dropoff-report-based-on-student')}}"> PICKUP /DROP OFF REPORT  BASED ON STUDENT <span></span></a>
            <a class="dropdown-item" href="{{url('/pickup-dropoff-report-based-on-bus')}}"> PICKUP /DROP OFF REPORT  BASED ON BUS<span></span></a>
            <a class="dropdown-item" href="{{url('/total-km-report')}}"> TOTAL KM REPORT<span></span></a> <a class="dropdown-item" href="{{url('/daily-km-report')}}"> DAILY REPORT<span></span></a> 
            <a class="dropdown-item" href="{{url('/alert-report')}}"> ALERT REPORT<span></span></a> 
            <a class="dropdown-item" href="{{url('/geofence-report')}}">GEOFENCE REPORT<span></span></a>
            <a class="dropdown-item" href="{{url('/over-speed-report')}}"> OVERSPEED REPORT<span></span></a>
            <a class="dropdown-item" href="{{url('/zigzag-driving-report')}}"> ZIG-ZAG REPORT<span></span></a>
            <a class="dropdown-item" href="{{url('/accident-imapct-alert-report')}}">ACCIDENT IMPACT REPORT<span></span></a> 
            <a class="dropdown-item" href="{{url('/missed-student-report')}}"> MISSED STUDENTS REPORT<span></span></a>  
            <a class="dropdown-item" href="{{url('/idle-report')}}"> NO OF IDLE DAYS REPORT<span></span></a>   
            <a class="dropdown-item" href="{{url('/special-class-bus-schedule-report')}}"> SPECIAL CLASS BUS SCHEDULE REPORT<span></span></a> 
            <a class="dropdown-item" href="{{url('/parent-information-report')}}"> PARENT INFORMATION REPORT<span></span></a> 
            <a class="dropdown-item" href="{{url('/student-wise-usage-report')}}"> STUDENT WISE USAGE REPORT<span></span></a> 
            <a class="dropdown-item" href="{{url('/nfc-card-report')}}"> NFC CARD REPORT<span></span></a>                     
        </div>
    </li>

    
</ul>