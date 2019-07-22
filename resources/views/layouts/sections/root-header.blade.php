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
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> DEVICE
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{url('/gps/create')}}">Add Device</a>
                                <a class="dropdown-item" href="{{url('/gps')}}"> List Device</a>  
                                 
                                 <a class="dropdown-item" href="{{url('/gps-transfer/create')}}">Device Transfer</a> 
                                 <a class="dropdown-item" href="{{url('/gps-transfers')}}"> Transfer List</a> 
                                 <a class="dropdown-item" href="{{url('/gps-transferred')}}"> Transferred Device List</a>                           
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> EMPLOYEES
                            </a>
                           
                    <ul class="dropdown-menu multi-level">
                        <li class="dropdown-submenu">
                            <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >DEALERS</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{url('/dealer/create')}}">ADD DEALER</a></li>
                                <li><a class="dropdown-item" href="{{url('/dealers')}}">LIST DEALERS</a></li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                            <a href="#" class="dropdown-item dropdown-toggle" data-toggle="dropdown">SUB DEALERS</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{url('/sub-dealers')}}">LIST SUB DEALERS</a></li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                            <a href="#" class="dropdown-item dropdown-toggle" data-toggle="dropdown">SERVICE ENGINEERS</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">ADD SERVICE ENGINEER</a></li>
                                <li><a class="dropdown-item" href="#">LIST SERVICE ENGINEERS</a></li>
                            </ul>
                        </li>
                    </ul>
                        </li>


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> VEHICLE CATEGORY 
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{url('/vehicle-type/create')}}">Add Vehicle Category<span></span></a>                               
                                <a class="dropdown-item" href="{{url('/vehicle-types')}}">List Vehicle Categories<span></span></a>                     
                            </div>
                        </li>



                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> VEHICLE
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                             
                                <a class="dropdown-item" href="{{url('/vehicle-root')}}">List Vehicles<span></span></a>   
                                                          
                            </div>
                        </li>

                         <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> ALERT TYPE
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                             
                                <a class="dropdown-item" href="{{url('/alert-type/create')}}">Add Alert Type<span></span></a>   
                                <a class="dropdown-item" href="{{url('/alert-types')}}">List Alert Type<span></span></a>   
                                                          
                            </div>
                        </li>

                         <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">OTA TYPES
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                             
                                <a class="dropdown-item" href="{{url('/ota-type/create')}}">Add Ota Type<span></span></a>   
                                <a class="dropdown-item" href="{{url('/ota-type')}}">List Ota Type<span></span></a>   
                                                          
                            </div>
                        </li>


                        
                      

                    </ul>