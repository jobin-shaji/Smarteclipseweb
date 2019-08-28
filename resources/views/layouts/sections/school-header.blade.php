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
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> SCHOOL 
        </a>
       <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{url('/school/create')}}"> ADD SCHOOL <span></span></a>                               
            <a class="dropdown-item" href="{{url('/school')}}"> LIST SCHOOL<span></span></a>                                 
        </div>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> STUDENT 
        </a>
       <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{url('/student/create')}}"> ADD STUDENT <span></span></a>                               
            <a class="dropdown-item" href="{{url('/student')}}"> LIST STUDENT<span></span></a>                                 
        </div>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> HELPER 
        </a>
       <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{url('/helper/create')}}"> ADD HELPER <span></span></a>                               
            <a class="dropdown-item" href="{{url('/helper')}}"> LIST HELPER<span></span></a>                                 
        </div>
    </li>
    
</ul>