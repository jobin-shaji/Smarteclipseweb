    <ul class="navbar-nav float-left mr-auto">
        <li class="nav-item d-none d-md-block">
        </li>                       
        
        <li class="nav-item"> 
            <a class="nav-link waves-effect waves-dark" href="{{url('/home')}}">
            <i class="fa fa-home" aria-hidden="true"></i>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" href="{{url('/gps-data')}}">All GPS </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" href="{{url('/all-gps-data')}}">CONSOLE</a>
        </li>      
        <li class="nav-item dropdown">
            <a class="nav-link" href="{{url('/gps-map')}}">GPS FIX AND NON FIX</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" href="{{url('/gps-config')}}">GPS CONFIGURATION</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" href="{{url('/gps-km-map')}}">GPS KM</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" href="{{url('/all-gps-config')}}">SINGLE GPS CONFIGURATION</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" href="{{url('/ota-response')}}">OTA RESPONSE</a>
        </li>
    </ul>