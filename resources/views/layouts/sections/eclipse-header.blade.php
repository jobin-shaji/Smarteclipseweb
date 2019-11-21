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
                        @role('client|school')
                            @if(\Auth::user()->client->logo)
                              <img class="light-logo"  src="{{ url('/') }}/logo/{{ \Auth::user()->client->logo }}" />
                            @else
                                <?php
                                $url=url()->current();
                                $rayfleet_key="rayfleet";
                                $eclipse_key="eclipse";
                                if (strpos($url, $rayfleet_key) == true) {  ?>
                                    <img src="{{ url('/') }}/assets/images/logo-s.jpg" alt="homepage" class="light-logo" /> 
                                <?php } 
                                else if (strpos($url, $eclipse_key) == true) { ?>
                                    <img src="{{ url('/') }}/assets/images/logo-s.png" alt="homepage" class="light-logo" /> 
                                <?php }
                                else { ?>
                                    <img src="{{ url('/') }}/assets/images/logo-s.png" alt="homepage" class="light-logo" />  
                                <?php } ?>  
                            @endif
                        @endrole

                        @role('root|dealer|sub_dealer|servicer')
                            <?php
                            $url=url()->current();
                            $rayfleet_key="rayfleet";
                            $eclipse_key="eclipse";
                            if (strpos($url, $rayfleet_key) == true) {  ?>
                                <img src="{{ url('/') }}/assets/images/logo-s.jpg" alt="homepage" class="light-logo" /> 
                            <?php } 
                            else if (strpos($url, $eclipse_key) == true) { ?>
                                <img src="{{ url('/') }}/assets/images/logo-s.png" alt="homepage" class="light-logo" /> 
                            <?php }
                            else { ?>
                                <img src="{{ url('/') }}/assets/images/logo-s.png" alt="homepage" class="light-logo" />  
                            <?php } ?>  
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
                  
                    @role('root|dealer|sub_dealer|servicer|school|operations')

                    @role('root')
                        @include('layouts.sections.root-header')
                    @endrole 
                     @role('dealer')
                        @include('layouts.sections.dealer-header')
                    @endrole 
                     @role('sub_dealer')
                        @include('layouts.sections.sub_dealer-header')
                    @endrole 
                    @role('servicer')
                        @include('layouts.sections.servicer-header')
                    @endrole 
                    @role('school')
                        @include('layouts.sections.school-header')
                    @endrole
                      @role('operations')
                        @include('layouts.sections.operation-header')
                    @endrole

                   @endrole

                   @role('client')
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
                        <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> GPS
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{url('/gps-client')}}"> LIST GPS<span></span></a>                               
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> SOS
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{url('/sos-client')}}"> LIST SOS<span></span></a>                               
                            </div>
                        </li> -->

                        <li class="nav-item dropdown-submenu">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> VEHICLE
                            </a>
                            <ul class="dropdown-menu multi-level">
                                <li class="dropdown-submenu">
                                    <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >VEHICLE</a>
                                    <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{url('/vehicle')}}">LIST VEHICLES</a></li>
                                    <li><a class="dropdown-item" href="{{url('/all-vehicle-docs')}}">VEHICLE DOCUMENTS</a></li>
                                    <li><a class="dropdown-item" href="{{url('/vehicle-driver-log')}}">DRIVER UPDATE LOG</a></li>
                                     @role('fundamental|superior|pro')
                                    <!-- <li><a class="dropdown-item" href="{{url('/invoice')}}">INVOICE</a></li> -->
                                     @endrole
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a href="#" class="dropdown-item dropdown-toggle" data-toggle="dropdown">DRIVER</a>
                                    <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/driver/create">ADD DRIVER</a></li>
                                    <li><a class="dropdown-item" href="{{url('/drivers')}}">LIST DRIVERS</a></li>
                                    @role('fundamental|superior|pro')
                                    <li><a class="dropdown-item" href="{{url('/drivers-score-page')}}">DRIVER SCORE</a></li>
                                    @endrole
                                    <li><a class="dropdown-item" href="{{url('/performance-score-history')}}">PERFORMANCE SCORE HISTORY</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown-submenu">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> GEOFENCE
                            </a>
                            <ul class="dropdown-menu multi-level">
                                <li class="dropdown-submenu">
                                    <a href="#" class="dropdown-item dropdown-toggle"data-toggle="dropdown" >GEOFENCE</a>
                                    <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{url('/fence')}}">ADD GEOFENCE</a></li>
                                    <li><a class="dropdown-item" href="{{url('/geofence')}}">LIST GEOFENCES</a></li>
                                    <li><a class="dropdown-item" href="{{url('/assign/geofence-vehicle')}}">ASSIGN GEOFENCE</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a href="#" class="dropdown-item dropdown-toggle" data-toggle="dropdown">ROUTE</a>
                                    <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{url('/route/create')}}">ADD ROUTE</a></li>
                                    <li><a class="dropdown-item" href="{{url('/route')}}">LIST ROUTES</a></li>
                                    <li><a class="dropdown-item" href="{{url('/assign/route-vehicle')}}">ASSIGN ROUTE</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        

                        <li class="nav-item dropdown-submenu">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> COMPLAINTS 
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{url('/complaint/create')}}"> ADD COMPLAINT <span></span></a>                               
                                <a class="dropdown-item" href="{{url('/complaint')}}"> LIST COMPLAINTS<span></span></a>                               
                            </div>
                        </li>
                        <li class="nav-item dropdown-submenu">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> REPORTS 
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                                    <ul class="ecosystem">
                                    <li class="sys_vapor cover_total_km">
                                        <a href="{{url('/total-km-report')}}">
                                            <div class="system_icon">
                                               <img src="{{ url('/') }}/Report-icons/Total-KM-report.png"  />
                                           <span class="system_info" >Total KM  Report</span>
                                           </div>
                                            
                                        </a>
                                    </li>
                                     <li class="sys_vapor cover_total_km">
                                        <a href="{{url('/km-report')}}">
                                            <div class="system_icon">
                                               <img src="{{ url('/') }}/Report-icons/Total-KM-report.png"  />
                                           <span class="system_info" >Vehicle  Report</span>
                                           </div>
                                            
                                        </a>
                                    </li>


                                    <li class="sys_vapor cover_geofence">
                                        <a href="{{url('/geofence-report')}}">
                                            <div class="system_icon">
                                               <img src="{{ url('/') }}/Report-icons/geofence-report.png"  />
                                               <span class="system_info"> Geofence Report</span>
                                           </div>
                                          
                                        </a>
                                    </li>

                                    <li class="sys_vapor cover_over_speed">
                                        <a href="{{url('/over-speed-report')}}">
                                            <div class="system_icon">
                                               <img src="{{ url('/') }}/Report-icons/overspeed-report.png"  />
                                           <span class="system_info" >Over Speed  Report</span>
                                           </div>
                                            
                                        </a>
                                    </li>

                                    <li class="sys_vapor cover_tracking_report">
                                        <a href="{{url('/tracking-report')}}">
                                            <div class="system_icon">
                                               <img src="{{ url('/') }}/Report-icons/tracking-report.png"  />
                                          <span class="system_info" >Tracking Report </span>
                                           </div>
                                          
                                        </a>
                                    </li>


                                    <li class="sys_vapor cover_deviation_report">
                                        <a href="{{url('/route-deviation-report')}}">
                                            <div class="system_icon">
                                               <img src="{{ url('/') }}/Report-icons/route-deviation-report.png"  />
                                              <span class="system_info" >Route Deviation Report</span>  
                                           </div>
                                            
                                        </a>
                                    </li>

                                    <li class="sys_vapor cover_harsh_bracking">
                                        <a href="{{url('/harsh-braking-report')}}">
                                            <div class="system_icon">
                                               <img src="{{ url('/') }}/Report-icons/braking-report.png"  />

                                           <span class="system_info" >Harsh Braking Report</span>
                                           </div>
                                            
                                        </a>
                                    </li>

                                     <li class="sys_vapor sudden_acceleration">
                                        <a href="{{url('/sudden-acceleration-report')}}">
                                            <div class="system_icon">
                                               <img src="{{ url('/') }}/Report-icons/accelaration-report.png"  />
                                            <span class="system_info" >Sudden Acceleration</span>
                                           </div>
                                            
                                        </a>
                                    </li>

                                    <li class="sys_vapor cover_dailyreport">
                                        <a href="{{url('/daily-km-report')}}">
                                            <div class="system_icon">
                                               <img src="{{ url('/') }}/Report-icons/Total-KM-report.png"  />
                                               <span class="system_info">Daily Report </span></div>
                                           
                                        </a>
                                    </li>

                                    <li class="sys_vapor cover_alertreport">
                                        <a href="{{url('/alert-report')}}">
                                            <div class="system_icon">
                                               <img src="{{ url('/') }}/Report-icons/alert-report.png"  />
                                           <span class="system_info" >Alert Report </span>
                                           </div>
                                          
                                        </a>
                                    </li>

                                      <li class="sys_vapor cover_zig_zag">
                                        <a href="{{url('/zigzag-driving-report')}}">
                                            <div class="system_icon">
                                               <img src="{{ url('/') }}/Report-icons/zigzag-report.png"  />
                                           <span class="system_info" >Zig-Zag Driving Report</span>
                                           </div>
                                        
                                        </a>
                                    </li>

                                       <li class="sys_vapor cover_accident">
                                        <a href="{{url('/accident-imapct-alert-report')}}">
                                            <div class="system_icon">
                                               <img src="{{ url('/') }}/Report-icons/accident-impact-report.png"  />
                                             <span class="system_info" >Accident Impact Alert</span>
                                           </div>
                                            
                                        </a>
                                    </li>
                                    <li class="sys_vapor cover_idle_report">
                                        <a href="{{url('/idle-report')}}">
                                            <div class="system_icon">
                                               <img src="{{ url('/') }}/Report-icons/idle-report.png"  />
                                            <span class="system_info" >Halt Report</span>
                                           </div>
                                           
                                        </a>
                                    </li>

                                     <li class="sys_vapor cover_parking_report">
                                        <a href="{{url('/parking-report')}}">
                                            <div class="system_icon">
                                               <img src="{{ url('/') }}/Report-icons/parking-report.png"  />
                                             <span class="system_info" >Parking Report</span>   
                                           </div>
                                           
                                        </a>
                                    </li>
                                    <li class="sys_vapor cover_main_battery">
                                        <a href="{{url('/mainbattery-disconnect-report')}}">
                                            <div class="system_icon">
                                               <img src="{{ url('/') }}/Report-icons/main-battery-disconnect-report.png"  />
                                             <span class="system_info" >Main Battery Disconnect</span>  
                                           </div>
                                            
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown-submenu">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> SETTINGS
                            </a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                             
                                <a class="dropdown-item" href="{{url('/performance-score')}}">ALERT POINTS <span></span></a>   
                                  
                                <a class="dropdown-item" href="{{url('/alert-manager')}}"> ALERT NOTIFICATION MANAGER <span></span></a>                         
                            </div>
                        </li>
                        
                        @if(!\Auth::user()->hasRole(['pro']))
                        <li class="nav-item dropdown" >
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" aria-haspopup="true" aria-expanded="false" style="color: green !important" href="{{url('go-premium')}}"> UPGRADE    
                            </a>
                        </li>
                        @endif


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
                        <li class="nav-item dropdown">
                           <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="header-emergency" style="display: none;"><img src="{{ url('/') }}/assets/images/emergency.gif" alt="user" width="50"></a>
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="color: #FF0000">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item">Driver : <h4 id="header_emergency_vehicle_driver"></h4></a>
                                <a class="dropdown-item">Vehicle Number : <h4 id="header_emergency_vehicle_number"></h4></a>
                                <a class="dropdown-item">Location : <h4 id="header_emergency_vehicle_location"></h4></a>
                                <a class="dropdown-item">Time : <h4 id="header_emergency_vehicle_time"></h4></a>
                                <input type="hidden" id="header_em_id">
                                <input type="hidden" id="header_alert_vehicle_id">
                                <input type="hidden" id="header_decrypt_vehicle_id">
                                <a class="dropdown-item"><button onclick="verifyHeaderEmergency()">Verify</button></a>
                            </div>
                        </li>
                        @role('client')
                        <li class="nav-item dropdown">
                            <a onclick="clientAlerts()" class="nav-link dropdown-toggle waves-effect waves-dark" title="Alerts" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
                            <span class="notification-box">
                                <span class="notification-count">0</span>
                                <div>
                                    <i class="mdi mdi-bell font-24" ></i>
                                </div>
                            </span>


<!-- style="padding: 18% 0 0 56%" -->
                            <!-- <span class="cover_bell">
                                <span class="bell_value" id="bell_notification_count">0</span>
                            </span><i class="mdi mdi-bell font-24" style="padding: 18% 0 0 56%"></i> -->
                            </a>
                            <!-- <span class="notification-box">
                                <span class="notification-count">
                                   <a class="dropdown-item" href="{{url('/alert')}}" id="bell_notification_count" title="Alerts">1000</a>
                                </span>
                                <div class="notification-bell">
                                  <span class="bell-top"></span>
                                  <span class="bell-middle"></span>
                                  <span class="bell-bottom"></span>
                                  <span class="bell-rad"></span>
                                  <i class='fas fa-car'></i>
                                  <img src="../../assets/images/arc.png" width="50" height="20">
                                </div>
                                
                            </span> -->
                           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                                <div id="alert_notification">
                            </div>
                                <a class="dropdown-item" href="{{url('/alert')}}">VIEW ALL ALERTS</a>
                            </div>
                        </li>                      
                        <li class="nav-item dropdown">
                            <a href="#" onclick="documents()" class="nav-link dropdown-toggle waves-effect waves-dark" title="Documents" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="font-24 mdi mdi-file-document-box" ></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown" aria-labelledby="2">
                                <ul class="list-style-none">

                                    <li>
                                        <div class="" >       
                                            <h5 class="m-b-0" style="margin-top:10px;margin-left: 5px;">  Documents
                                            </h5>
                                      <div id="notification">
                                            </div>
                                            
                                            <div id="expire_notification" style="background-color: 'red'">
                                            </div>
                                            <div >
                                                 <div class="d-flex no-block align-items-center p-10"  >
                                                <span class="btn btn-success btn-circle"><i class="mdi mdi-file"></i></span>
                                                <div class="m-l-10" >
                                                <a href="{{url('/all-vehicle-docs')}}"><small class="font-light">VIEW ALL DOCUMENTS</small></a><br>                                        
                                                                               
                                                </div>
                                            </div>  

                                            </div>
                                             
                                         </div>
                                    </li>
                                </ul>
                            </div>
                        </li> 
                       <!--  <label>View Documents</label> -->
                        @endrole
                        <li class="nav-item dropdown">
                            @role('client')
                              @include('layouts.sections.eclipse-alert-popup')
                            @endrole
                        </li>
                       
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           @role('client')      
                               <img src="{{ url('/') }}/images/{{ \Auth::user()->roles->last()->path }}" alt="user" title="{{\Auth::user()->username}}" class="rounded-circle" width="70" height="60"></a>
                             @endrole
                             @role('root|dealer|sub_dealer|servicer|school|operations')
                                <img src="{{ url('/') }}/assets/images/2.png" alt="user" title="{{\Auth::user()->username}}" class="rounded-circle" width="31"></a>
                                @endrole
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                <div class="dropdown-divider">
                                </div>
                                @role('client')
                                    <a class="dropdown-item" href="{{url('/client/profile')}}">
                                        <i class="ti-user m-r-5 m-l-5"></i>{{\Auth::user()->username}}</a>

                                    <a class="dropdown-item" href="{{url('/client/'.Crypt::encrypt(\Auth::user()->id).'/change-password')}}">
                                        <i class="fa fa-cog m-r-5 m-l-5"></i>CHANGE PASSWORD</a>
                                @endrole
                                @role('school')
                                    <a class="dropdown-item" href="{{url('/client/profile')}}">
                                        <i class="ti-user m-r-5 m-l-5"></i>{{\Auth::user()->username}}</a>
                                    @if(empty(\Auth::user()->geofence))  
                                    <a class="dropdown-item" href="{{url('/school/'.Crypt::encrypt(\Auth::user()->id).'/fence')}}">
                                        <i class="fa fa-cog m-r-5 m-l-5"></i> GEOFENCE</a>
                                    @endif                                        
                                      
                                    <a class="dropdown-item" href="{{url('/client/'.Crypt::encrypt(\Auth::user()->id).'/change-password')}}">
                                        <i class="fa fa-cog m-r-5 m-l-5"></i>CHANGE PASSWORD</a>
                                @endrole
                                @role('root')
                                    <a style="margin-left: 15px;">
                                        <i class="ti-user m-r-5 m-l-5"></i>{{\Auth::user()->username}}</a>
                                    <a class="dropdown-item" href="{{url('/root/'.Crypt::encrypt(\Auth::user()->id).'/change-password')}}">
                                        <i class="fa fa-cog m-r-5 m-l-5"></i>CHANGE PASSWORD</a>
                                @endrole
                                @role('dealer')
                                    <a class="dropdown-item" href="{{url('/dealer/profile')}}">
                                        <i class="ti-user m-r-5 m-l-5"></i>{{\Auth::user()->username}}</a>
                                    <a class="dropdown-item" href="{{url('/dealers/'.Crypt::encrypt(\Auth::user()->id).'/change-password')}}">
                                        <i class="fa fa-cog m-r-5 m-l-5"></i>CHANGE PASSWORD</a>
                                @endrole
                                @role('sub_dealer')
                                    <a class="dropdown-item" href="{{url('/sub-dealer/profile')}}">
                                        <i class="ti-user m-r-5 m-l-5"></i>{{\Auth::user()->username}}</a>
                                    <a class="dropdown-item" href="{{url('/sub-dealers/'.Crypt::encrypt(\Auth::user()->id).'/change-password')}}">
                                        <i class="fa fa-cog m-r-5 m-l-5"></i>CHANGE PASSWORD</a>
                                @endrole
                                @role('servicer')
                                    <a class="dropdown-item" href="{{url('/servicer/profile')}}">
                                        <i class="ti-user m-r-5 m-l-5"></i>{{\Auth::user()->username}}
                                    </a>
                                    <a class="dropdown-item" href="{{url('/servicer/'.Crypt::encrypt(\Auth::user()->id).'/change-password')}}">
                                        <i class="fa fa-cog m-r-5 m-l-5"></i>CHANGE PASSWORD</a>
                                @endrole
                                  @role('operations')
                                    <a class="dropdown-item" href="{{url('/operations/profile')}}">
                                        <i class="ti-user m-r-5 m-l-5"></i>{{\Auth::user()->username}}
                                    </a>
                                    <a class="dropdown-item" href="{{url('/operations/'.Crypt::encrypt(\Auth::user()->id).'/change-password')}}">
                                        <i class="fa fa-cog m-r-5 m-l-5"></i>CHANGE PASSWORD</a>
                                @endrole
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="clearLocalStorage();event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-power-off m-r-5 m-l-5"></i>LOGOUT</a>
                                
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

    <div id="headerModal" class="modal_for_dash">
          
<div class="modal-content" style="max-width:28%;z-index:9999!important">
<div class="modal-header" onclick="closePremium()">
<span style="font-weight:600;padding:0 3%;color:#fb9a18;width:80%;font-size:18px">Go Premium Now</span> <span class="close">×</span>
</div>
                            <ul style="margin-left:-3%!important;font-weight: 600;font-size:.9em;line-height: 22px;">
                                <span style="margin:3% 0 1% 0;float:left;width:100%;">
                                <li style="list-style: none!important"><img src="{{url('assets/images/fuel-pop.png')}}" width="22" height="22">
                                &nbsp;FUEL STATUS ON WEB/MOBILE APPS 
                                </li>
                            </span>
                                
                              <span style="margin:1% 0;float:left;width:100%;">
                                <li style="list-style: none!important;width:100%;"><img src="{{url('assets/images/immobilizer-pop.png')}}" width="22" height="22">
                                &nbsp;IMMOBILIZER
                                </li></span>
                               <span style="margin:1% 0;float:left;width:100%;">
                                <li style="list-style: none!important"><img src="{{url('assets/images/driver-score-pop.png')}}" width="22" height="22">
                                &nbsp;DRIVER SCORE
                                </li></span>
                                <span style="margin:1% 0;float:left;width:100%;">
                                <li style="list-style: none!important"><img src="{{url('assets/images/ubi-pop.png')}}" width="22" height="22">
                                &nbsp;UBI
                                </li></span>
                                <span style="margin:1% 0;float:left;width:100%;">
                                <li style="list-style: none!important"><img src="{{url('assets/images/route-playback-pop.png')}}" width="22" height="22">
                                &nbsp;HISTORY(ROUTE PLAYBACK,ALERTS)  UPTO 6 MONTHS
                                </li></span>
                                <span style="margin:1% 0;float:left;width:100%;">
                                <li style="list-style: none!important"><img src="{{url('assets/images/e-tolling-pop.png')}}" width="22" height="22">
                                &nbsp;E TOLLING
                                </li></span>
                                <span style="margin:1% 0;float:left;width:100%;">
                                <li style="list-style: none!important"><img src="{{url('assets/images/traffic-offence-alert-pop.png')}}" width="22" height="22">
                                &nbsp;TRAFFIC OFFENCE ALERTS
                                </li></span>
                                <span style="margin:1% 0;float:left;width:100%;">
                                <li style="list-style: none!important"><img src="{{url('assets/images/route-deviation-aler-pop.png')}}" width="22" height="22">
                                &nbsp;ROUTE DEVIATION ALERTS
                                </li></span>
                                <span style="margin:1% 0;float:left;width:100%;">
                                <li style="list-style: none!important"><img src="{{url('assets/images/radar-pop.png')}}" width="22" height="22">
                                &nbsp;RADAR
                                </li></span>
                                <span style="margin:1% 0;float:left;width:100%;">
                                <li style="list-style: none!important"><img src="{{url('assets/images/geofence-pop.png')}}" width="22" height="22">
                                &nbsp;GEOFENCE    UPTO 5
                                </li></span>
                                <span style="margin:1% 0;float:left;width:100%;">
                                <li style="list-style: none!important"><img src="{{url('assets/images/aggregation-pop.png')}}" width="22" height="22">
                                &nbsp;AGGREGATION PLATFORM
                                </li></span>
                                <span style="margin:1% 0;float:left;width:100%;">
                                <li style="list-style: none!important;width:100%;"><img src="{{url('assets/images/share-location.png')}}" width="22" height="22">
                                &nbsp;SHARE LOCATION TO OTHER APPLICATIONS
                                </li></span>
                                <span style="margin:1% 0;float:left;width:100%;">
                                <li style="list-style: none!important"><img src="{{url('assets/images/daily-report-pop.png')}}" width="22" height="22">
                                &nbsp;DAILY REPORT SUMMARY TO REGISTERED EMAIL
                                </li></span>
                                <span style="margin:1% 0;float:left;width:100%;">
                                <li style="list-style: none!important"><img src="{{url('assets/images/sms-alert-pop.png')}}" width="22" height="22">
                                &nbsp;EMERGENCY ALERTS AS SMS/EMAIL/PUSH NOTIFICATIONS</li></span>
                                <span style="margin:1% 0;float:left;width:100%;">
                                <li style="list-style: none!important"><img src="{{url('assets/images/theft-mode-pop.png')}}" width="22" height="22">
                                &nbsp;THEFT MODE
                                </li></span>
                            </ul>
<div style="padding:3% 6%;;font-weight:600;font-size:20px;color:#fb9a18;border-top: 1px solid #e9ecef">
Contact for Assistance +91 9544313131</div>
</div>   
    </div>
<style type="text/css">
  .notification-box {
  /*position: relative;*/
  z-index: 99;
  top: 29px;
  right: 133px;
  width: 100px;
  height: 50px;
}
.notification-bell {
  /*animation: bell 1s 1s both infinite;*/
}
/*.notification-bell * {
  display: block;
  margin: 0 auto;
  box-shadow: 0px 0px 15px #fff;
}*/
/*.bell-top {
  width: 4px;
  height: 6px;
  border-radius: 3px 3px 0 0;
}
.bell-middle {
  width: 19px;
  height: 18px;
  border-radius: 12.5px 12.5px 0 0;
}
.bell-bottom {
  position: relative;
  z-index: 0;
  width: 32px;
  height: 2px;
}
.bell-bottom::before,
.bell-bottom::after {
  content: '';
  position: absolute;
  top: -4px;
}
.bell-bottom::before {
  left: 1px;
  border-bottom: 4px solid #fff;
  border-right: 0 solid transparent;
  border-left: 4px solid transparent;
}
.bell-bottom::after {
  right: 1px;
  border-bottom: 4px solid #fff;
  border-right: 4px solid transparent;
  border-left: 0 solid transparent;
}
.bell-rad {
  width: 8px;
  height: 4px;
  margin-top: 2px;
  border-radius: 0 0 4px 4px;
  animation: rad 1s 2s both infinite;
}*/
.notification-count {
  position: absolute;
  text-align: center;
  z-index: 1;
  right: 3px;
  width: 37px;
  line-height: 29px;
  font-size: 15px;
  border-radius: 50%;
  background-color: #ff4927;
/*  color: white;
*/  animation: zoom 2s 2s both infinite;
}
@keyframes bell {
  0% { transform: rotate(0); }
  10% { transform: rotate(30deg); }
  20% { transform: rotate(0); }
  80% { transform: rotate(0); }
  90% { transform: rotate(-30deg); }
  100% { transform: rotate(0); }
}
/*@keyframes rad {
  0% { transform: translateX(0); }
  10% { transform: translateX(6px); }
  20% { transform: translateX(0); }
  80% { transform: translateX(0); }
  90% { transform: translateX(-6px); }
  100% { transform: translateX(0); }
}*/
@keyframes zoom {
  0% { opacity: 0; transform: scale(0); }
  10% { opacity: 1; transform: scale(1); }
  50% { opacity: 1; }
  51% { opacity: 0; }
  100% { opacity: 0; }
}
#2:hover{
    background-color: red!important
}
</style>