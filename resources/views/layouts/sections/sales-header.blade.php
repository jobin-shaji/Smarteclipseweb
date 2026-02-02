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
           <a class="dropdown-item" href="{{url('/gps-all')}}">ALL DEVICE  </a>  
           <a class="dropdown-item" href="{{url('/gps-stock-report')}}">STOCK REPORT  </a>    
           <a class="dropdown-item" href="{{url('/gps-transfer-report')}}">TRANSFER REPORT  <span class="badge">New</span></a>                  
           <a class="dropdown-item" href="{{url('/esim-renewal')}}">ESIM RENEWAL </a>
           <a class="dropdown-item" href="{{url('/esim-renewal-pending')}}">ESIM RENEWAL PENDING <span class="badge">New</span></a> 
           <a class="dropdown-item" href="{{url('/esim-bulk-assign')}}">ESIM ASSIGN TO EXECUTIVES <span class="badge">New</span></a> 
          
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
            CALL CENTER EXECUTIVES
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">  
           <a class="dropdown-item" href="{{url('/callcenter/create')}}">ADD CALL CENTER EXECUTIVES  </a>    
           <a class="dropdown-item" href="{{url('/callcenter')}}">LIST CALL CENTER EXECUTIVES</a>                  
          
        </div>
    </li>
 </ul>
