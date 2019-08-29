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
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> STUDENT
        </a>
        <ul class="dropdown-menu multi-level">
            <li class="dropdown-submenu">
                <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >STUDENT</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{url('/student/create')}}">ADD STUDENT</a></li>
                <li><a class="dropdown-item" href="{{url('/student')}}">LIST STUDENTS</a></li>
                </ul>
            </li>
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
    
</ul>