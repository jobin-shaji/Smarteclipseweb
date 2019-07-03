    <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                
                <div class="navbar-header" data-logobg="skin5">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand">
                        <!-- Logo icon -->
                                               <!--End Logo icon -->
                         <!-- Logo text -->
                   <span class="logo-text">
                        @role('client')
                            @if(\Auth::user()->client->logo)
                              <img class="light-logo"  src="{{ url('/') }}/logo/{{ \Auth::user()->client->logo }}" />
                            @else
                                <p>No Logo Found</p>
                            @endif
                        @endrole
                        @role('root|dealer|sub_dealer')
                            <img src="{{ url('/') }}/assets/images/logo-s.png" alt="homepage" class="light-logo" />    
                        @endrole                      
                        </span>
                        <!-- Logo icon -->
                        <!-- <b class="logo-icon"> -->
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <!-- <img src="assets/images/logo-text.png" alt="homepage" class="light-logo" /> -->
                            
                        <!-- </b> -->
                        <!--End Logo icon -->
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="False" aria-label="Toggle navigation"><i class="ti-more"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                  
                    @role('root|dealer|sub_dealer')
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light menu_click" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                        <!-- ============================================================== -->
                        <!-- create new -->
                        <!-- ============================================================== -->
                       
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <li class="nav-item search-box"> <a class="nav-link waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                            <form class="app-search position-absolute">
                                <input type="text" class="form-control" placeholder="Search &amp; enter"> <a class="srh-btn"><i class="ti-close"></i></a>
                            </form>
                        </li>
                    </ul>
                   @endrole

                   @role('client')
                   <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block">
                       </li>                       
                        <li class="nav-item search-box"> 
                        </li>
                         <li class="nav-item"> 
                             <a class="nav-link waves-effect waves-dark" href="{{url('/home')}}">
                                <i class="fa fa-home" aria-hidden="true"></i>
                            </a>
                        </li>
                          <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Device
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{url('/gps-new')}}"> New Arrivals <span></span></a>
                                <a class="dropdown-item" href="{{url('/gps-client')}}"> List Device<span></span></a>                               
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Vehicle
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/vehicles/create"> Add Vehicle <span></span></a>
                                <a class="dropdown-item" href="{{url('/vehicle')}}"> List Vehicles<span></span></a>  
                                <a class="dropdown-item" href="{{url('/vehicle-driver-log')}}">Driver's History<span></span></a>                             
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Driver
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/driver/create"> Add Driver <span></span></a>
                                <a class="dropdown-item" href="{{url('/drivers')}}"> List Driver<span></span></a>  
                                <a class="dropdown-item" href="{{url('/performance-score')}}"> Performance Score<span></span></a>                              
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Alerts
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                               
                                <a class="dropdown-item" href="{{url('/alert')}}"> List Alerts<span></span></a>                               
                            </div>
                        </li>
                          <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Alert Manager
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>                               
                                <a class="dropdown-item" href="{{url('/alert-manager')}}"> Alert Notification Manager<span></span></a>                               
                            </div>
                        </li>
                         <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Geofence 
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{url('/fence')}}"> Add Geofence <span></span></a>                               
                                <a class="dropdown-item" href="{{url('/geofence')}}"> List Geofence<span></span></a>                               
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Routes 
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{url('/route/create')}}"> Add Route <span></span></a>                               
                                <a class="dropdown-item" href="{{url('/route')}}"> List Route<span></span></a>                               
                            </div>
                        </li>
<!--                           <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Complaints 
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{url('/complaint/create')}}"> Add Complaint <span></span></a>                               
                                <a class="dropdown-item" href="{{url('/complaint')}}"> List Complaints<span></span></a>                               
                            </div>
                        </li> -->


                    </ul>
                   @endrole
                    <!-- <ul class="needhelp">Need help?   18005322007 (toll free)</ul> -->
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->
                      <!--   <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell font-24"></i>
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="alert_list.html">Ignition - <span>10</span></a>
                                <a class="dropdown-item" href="alert_list.html">Speed - <span>3</span></a>
                                <a class="dropdown-item" href="alert_list.html">Geofence - <span>10</span></a>
                                <a class="dropdown-item" href="alert_list.html">Towing <span>2</span></a>
                                <a class="dropdown-item" href="alert_list.html">View All</a>
                                                            </div>
                        </li> -->
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->
                        <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="font-24 mdi mdi-file-document-box"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown" aria-labelledby="2">
                                <ul class="list-style-none">
                                    <li>
                                        <div class=""> -->
                                             <!-- Message -->
                                            <!-- <a href="javascript:void(0)" class="link border-top">
                                                <div class="d-flex no-block align-items-center p-10">
                                                    <span class="btn btn-success btn-circle"><i class="mdi mdi-file"></i></span>
                                                    <a href="list_vehicle.html"><div class="m-l-10">
                                                        <h5 class="m-b-0"> Expired Documents</h5> 
                                                         <small class="font-light">KL-07-CK 5002 Expiring within 30 Days</small><br>
                                                        <small class="font-light">KL-06-CK 812 Expiring within 26 Days</small><br>
                                                        <small class="font-light">KL-07-CK 1302 Expiring within 9 Days</small> 
                                                    </div></a>
                                                </div>
                                            </a> -->
                                            <!-- Message -->
                                           <!--  <a href="javascript:void(0)" class="link border-top">
                                                <div class="d-flex no-block align-items-center p-10">
                                                    <span class="btn btn-info btn-circle"><i class="mdi mdi-plus-circle"></i></span>
                                                    <a href="list_vehicle.html"><div class="m-l-10">
                                                        <h5 class="m-b-0">Insurance</h5> 
                                                        <small class="font-light">KL-07-CK 5002 Expiring within 30 Days</small><br>
                                                        <small class="font-light">KL-06-CK 812 Expiring within 26 Days</small><br>
                                                        <small class="font-light">KL-07-CK 1302 Expiring within 9 Days</small>
                                                    </div></a>
                                                </div>
                                            </a> -->
                                            <!-- Message -->
                                            <!-- <a href="javascript:void(0)" class="link border-top">
                                                <div class="d-flex no-block align-items-center p-10">
                                                    <span class="btn btn-primary btn-circle"><i class="ti-user"></i></span>
                                                 <a href="list_vehicle.html">   <div class="m-l-10">
                                                        <h5 class="m-b-0">Pollution Certificate</h5> 
                                                         <small class="font-light">KL-07-AK 602 Expiring within 20 Days</small><br>
                                                        <small class="font-light">KL-06-BK 9012 Expiring within 16 Days</small><br>
                                                        <small class="font-light">KL-07-CB 1202 Expiring within 9 Days</small>
                                                    </div></a>
                                                </div>
                                            </a> -->
                                            <!-- Message -->
                                            <!-- <a href="javascript:void(0)" class="link border-top">
                                                <div class="d-flex no-block align-items-center p-10">
                                                    <span class="btn btn-danger btn-circle"><i class="fa fa-link"></i></span>
                                                   <a href="list_vehicle.html"> <div class="m-l-10">
                                                        <h5 class="m-b-0">Fitness</h5> 
                                                        <small class="font-light">KL-08-AP 602 Expiring within 20 Days</small><br>
                                                        <small class="font-light">KL-07-BD 3012 Expiring within 16 Days</small><br>
                                                        <small class="font-light">KL-07-CA 7202 Expiring within 9 Days</small>
                                                    </div></a>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li> -->
                        <li class="nav-item dropdown">
                            @role('client')
                              @include('layouts.sections.eclipse-alert-popup')
                            @endrole
                        </li>
                       
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ url('/') }}/assets/images/2.png" alt="user" class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                <div class="dropdown-divider">
                                </div>
                                @role('client')
                                    <a class="dropdown-item" href="{{url('/client/profile')}}">
                                        <i class="ti-user m-r-5 m-l-5"></i>My Profile</a>

                                    <a class="dropdown-item" href="{{url('/client/'.Crypt::encrypt(\Auth::user()->id).'/change-password')}}">
                                        <i class="fa fa-cog m-r-5 m-l-5"></i>Change Password</a>
                                @endrole
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-power-off m-r-5 m-l-5"></i>Logout</a>
                                
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
    </form>
