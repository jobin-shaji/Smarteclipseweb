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
                                <a class="dropdown-item" href="{{url('/gps-dealer-new')}}"> NEW ARRIVALS</a>
                                <a class="dropdown-item" href="{{url('/gps-dealer')}}"> IN STOCK </a>  
                                <a class="dropdown-item" href="{{url('/gps-transfer-dealer/create')}}">TRANSFER DEVICE</a>
                                <a class="dropdown-item" href="{{url('/gps-transfers-dealer')}}"> DEVICE TRANSFER LIST</a>                           
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> SOS
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{url('/sos-new')}}"> NEW ARRIVALS</a>
                                <a class="dropdown-item" href="{{url('/sos-dealer')}}"> SOS LIST</a>  
                                <a class="dropdown-item" href="{{url('/sos-transfer-dealer/create')}}">TRANSFER SOS</a>
                                <a class="dropdown-item" href="{{url('/sos-transfers')}}"> SOS TRANSFER LIST</a>                           
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">DEALERS
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                              
                                 <a class="dropdown-item" href="{{url('/sub-dealer/create')}}">ADD DEALER<span></span></a>
                                   <a class="dropdown-item" href="{{url('/subdealers')}}">LIST DEALERS<span></span></a>
                            </div>
                        </li>
                           <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> END USER
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                              
                               
                                   <a class="dropdown-item" href="{{url('/dealer-client')}}">LIST END USER<span></span></a>
                            </div>
                        </li>
                    </ul>