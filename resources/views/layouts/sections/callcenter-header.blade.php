<ul class="navbar-nav float-left mr-auto">
    <li class="nav-item d-none d-md-block">
    </li>
    <li class="nav-item">
        <a class="nav-link waves-effect waves-dark" href="{{url('/home')}}">
            <i class="fa fa-home" aria-hidden="true"></i>
        </a>
    </li>
    <input type="hidden" id="user_id" value="{{\Auth::user()->id}}">
    <!--<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Assigned Task        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">  
           <a class="dropdown-item" href="{{url('/assigned-gps')}}">Assigned  Gps  </a>    
           </div>
    </li>-->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="/assigned-gps"  aria-haspopup="true" aria-expanded="false"> DEVICE
        </a>
        
    </li>




    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> COMPLAINTS
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown"> 
           <a class="dropdown-item" href="{{url('/complaint/create')}}"><i class="fa fa-plus"></i>Add Complaint</a>
       <!--   <a class="dropdown-item" href="{{url('/complaint')}}"><i class="fa fa-list"></i> List Complaints</a>  
--> </div>
    </li>

   
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> REPORTS
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">  
           <a class="dropdown-item" href="{{url('/callcenter-report')}}">Reports</a>    
          </div>
    </li>
    
 </ul>
