  
<nav class="navbar navbar-expand-lg navbar-light bg-light">
 <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="{{url('/gps-data')}}">All GPS </a>
      </li>
      <li class="nav-item dropdown">
            <a class="nav-link" href="{{url('/all-gps-data-public')}}">CONSOLE</a>
        </li> 
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> GPS CONFIGURATION
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <div class="dropdown-divider"></div>            
            <a class="dropdown-item"href="{{url('/gps-config-public')}}">GPS CONFIGURATION</a>
        </div>
    </li>     
        <li class="nav-item dropdown">
            <a class="nav-link" href="{{url('/gps-map-public')}}">GPS FIX AND NON FIX</a>
        </li>        
       
      
    </ul>
    
  </div>
</nav>

     
   