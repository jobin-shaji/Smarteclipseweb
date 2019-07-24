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
                                <a class="dropdown-item" href="{{url('/gps-new')}}"> New Arrivals</a>
                                <a class="dropdown-item" href="{{url('/gps-dealer')}}"> List Device</a>  
                                <a class="dropdown-item" href="{{url('/gps-transfer-dealer/create')}}"> Device Transfer</a>
                                <a class="dropdown-item" href="{{url('/gps-transfers')}}"> Device Transfer List</a>                           
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> SOS
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{url('/sos-new')}}"> New Arrivals</a>
                                <a class="dropdown-item" href="{{url('/sos-dealer')}}"> List SOS</a>  
                                <a class="dropdown-item" href="{{url('/sos-transfer-dealer/create')}}"> SOS Transfer</a>
                                <a class="dropdown-item" href="{{url('/sos-transfers')}}"> SOS Transfer List</a>                           
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> SUB DEALER
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                              
                                 <a class="dropdown-item" href="{{url('/sub-dealer/create')}}">Add Sub Dealer<span></span></a>
                                   <a class="dropdown-item" href="{{url('/subdealers')}}">List Sub Dealer<span></span></a>
                            </div>
                        </li>
                           <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> END USER
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                              
                               
                                   <a class="dropdown-item" href="{{url('/dealer-client')}}">List End User<span></span></a>
                            </div>
                        </li>
                      



                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> VEHICLE
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                             
                                <a class="dropdown-item" href="{{url('/vehicle-dealer')}}">List Vehicles<span></span></a>   
                                                          
                            </div>
                        </li>
                    </ul>