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
                            <ul class="dropdown-menu multi-level">
                                <a class="dropdown-item" href="{{url('/gps-subdealer-new')}}">NEW ARRIVALS<span></span></a>
                                <a class="dropdown-item" href="{{url('/gps-sub-dealer')}}">ALL DEVICES<span></span></a>
                                <li class="dropdown-submenu">
                                    <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >TRADERS</a>
                                    <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{url('/gps-transfer-sub-dealer-trader/create')}}">TRANSFER DEVICE</a></li>
                                    <li><a class="dropdown-item" href="{{url('/gps-transfers-subdealer-to-trader')}}">DEVICE TRANSFER LIST</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >END USER</a>
                                    <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{url('/gps-transfer-sub-dealer/create')}}">TRANSFER DEVICE</a></li>
                                    <li><a class="dropdown-item" href="{{url('/gps-transfers-subdealer')}}">DEVICE TRANSFER LIST</a></li>
                                    </ul>
                                </li>
                                <a class="dropdown-item" href="{{url('/detailed-device-report')}}">DETAILED DEVICE REPORT  <span class="badge">New</span></a>
                                <a class="dropdown-item" href="{{url('/temporary-certificate-sub-dealer')}}">TEMPORARY INSTALLATION CERTIFICATE<span class="badge">New</span></a>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> SOS
                            </a>
                            <ul class="dropdown-menu multi-level">
                                <a class="dropdown-item" href="{{url('/sos-new')}}">NEW ARRIVALS<span></span></a>
                                <a class="dropdown-item" href="{{url('/sos-sub-dealer')}}">IN STOCK<span></span></a>
                                <li class="dropdown-submenu">
                                    <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >SUB DEALER</a>
                                    <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{url('sos-transfer-sub-dealer-to-trader/create')}}">TRANSFER SOS</a></li>
                                    <li><a class="dropdown-item" href="{{url('/sos-transferred-from-sub-dealer-to-trader')}}">SOS TRANSFER LIST</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >END USER</a>
                                    <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{url('/sos-transfer-sub-dealer/create')}}">TRANSFER SOS</a></li>
                                    <li><a class="dropdown-item" href="{{url('/sos-transferred-from-sub-dealer-to-client')}}">SOS TRANSFER LIST</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> USER
                            </a>
                            <ul class="dropdown-menu multi-level">
                                <!-- sub dealer option in header,created by 10-1-2020 by christeena-start  -->
                                <li class="dropdown-submenu">
                                    <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >TRADERS</a>
                                    <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{url('/trader/create')}}">ADD TRADERS</a></li>
                                    <li><a class="dropdown-item" href="{{url('/trader')}}">LIST TRADERS</a></li>
                                    </ul>
                                </li>
                                <!-- sub dealer option in header,created by 10-1-2020 by christeena-end  -->
                                <li class="dropdown-submenu">
                                    <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >END USER</a>
                                    <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{url('/client/create')}}">ADD END USER</a></li>
                                    <li><a class="dropdown-item" href="{{url('/clients')}}">LIST END USERS</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a href="#" class="dropdown-item dropdown-toggle" data-toggle="dropdown">SERVICE ENGINEERS</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{url('create-servicer')}}">ADD SERVICE ENGINEER</a></li>
                                        <li><a class="dropdown-item" href="{{url('/servicers')}}">LIST SERVICE ENGINEERS</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> JOB
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{url('/sub-dealer-assign-servicer')}}">CREATE JOB</a>
                                <a class="dropdown-item" href="{{url('/sub-dealer-assign-servicer-list')}}">LIST JOBS</a>  
                                <a class="dropdown-item" href="{{url('/servicer-job-history-list')}}">JOBS HISTORY</a>                         
                            </div>
                        </li>
                        <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> SCHOOL 
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{url('/school/create')}}"> ADD SCHOOL <span></span></a>                               
                                <a class="dropdown-item" href="{{url('/school')}}"> LIST SCHOOLS<span></span></a>                                 
                            </div>
                        </li> -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> REPORTS
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                             <a class="dropdown-item" href="{{url('/log-report')}}">DEVICE ACTIVATION REPORT<span></span></a>
                             <a class="dropdown-item" href="{{url('/device-installation-report')}}">DEVICE INSTALLATION REPORT<span></span></a>
                            </div>
                        </li>
                       <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> COMPLAINTS 
                        </a>
                       <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <div class="dropdown-divider"></div>                       
                            <a class="dropdown-item" href="{{url('/complaint')}}"> LIST COMPLAINTS<span></span></a> 
                            <a class="dropdown-item" href="{{url('/complaint-history-list')}}">COMPLAINT HISTORY </a>                               
                        </div>
                        </li>
                    </ul>