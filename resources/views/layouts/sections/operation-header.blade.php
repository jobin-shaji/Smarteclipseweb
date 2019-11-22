    <ul class="navbar-nav float-left mr-auto">
        <li class="nav-item d-none d-md-block">
        </li>                       
        
        <li class="nav-item"> 
            <a class="nav-link waves-effect waves-dark" href="{{url('/home')}}">
            <i class="fa fa-home" aria-hidden="true"></i>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" href="{{url('/operation-gps-data')}}">All GPS </a>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">  CONFIGURATION
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{url('/all-gps-config')}}">SINGLE GPS CONFIGURATION</a>
                <a class="dropdown-item"href="{{url('/gps-config')}}">GPS CONFIGURATION</a>
                <a class="dropdown-item" href="{{url('/gps-map')}}">GPS FIX AND NON FIX</a>
                <a class="dropdown-item" href="{{url('/gps-map')}}">GPS FIX AND NON FIX</a>
                <a class="dropdown-item" href="{{url('/gps-km-map')}}">GPS KM</a>
                <a class="dropdown-item" href="{{url('/all-gps-data')}}">CONSOLE</a>
            </div>
        </li>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> DEVICE
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <div class="dropdown-divider"></div>
         
            <a class="dropdown-item" href="{{url('/gps/stock')}}">ADD STOCK</a>
            
        </div>
    </li>
   

       
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> OTA
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <div class="dropdown-divider"></div>
                 <a class="dropdown-item" href="{{url('/set-ota-operations')}}">SET SOTA </a>
                <a class="dropdown-item" href="{{url('/ota-response')}}">OTA RESPONSE</a>
                <a class="dropdown-item"href="{{url('/ota-update')}}">OTA UPDATES</a>
                
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> GPS STOCK REPORT
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{url('/stock-report')}}">STOCK REPORT</a>
                <a class="dropdown-item"href="{{url('/combined-stock-report')}}">COMBINED STOCK REPORT</a>
                
            </div>
        </li> 





        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> TESTED REPORT
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{url('/gps-report')}}">GPS TESTED REPORT</a>
                <a class="dropdown-item"href="{{url('/combined-gps-report')}}">COMBINED GPS TESTED REPORT</a>
                
            </div>
        </li>


      <!--   <li class="nav-item dropdown">
            <a class="nav-link" href="{{url('/gps-report')}}">GPS REPORT</a>
        </li> -->
    </ul>