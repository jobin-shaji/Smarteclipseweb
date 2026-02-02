
<?php
use Illuminate\Support\Facades\Log;
    header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0');
?>

<header class="topbar" data-navbarbg="skin5">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
               
        <div class="navbar-header" data-logobg="skin5">
            <a class="navbar-brand" href="#">
              <img src="https://smarteclipse.com/assets/images/logo-v.png" alt="Logo" class="logo" style="width: 80%;margin-left:1em;display:none;"/>
            </a>
        
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
                        @if(\Auth::user()->hasRole(['pro|superior']))
                            <?php if (\Auth::user()->client->logo) { ?>
                            <img class="light-logo"  src="{{ url('/') }}/logo/{{ \Auth::user()->client->logo }}" />
                            <?php } else {?>
                                <img src="{{ url('/') }}/assets/images/logo-s.png" alt="homepage" class="light-logo" /> 
                            <?php } ?>
                        @else
                            <?php
                            $url=url()->current();
                            $rayfleet_key="rayfleet";
                            $eclipse_key="eclipse";
                            if (strpos($url, $rayfleet_key) == true) {  ?>
                                <img src="{{ url('/') }}/assets/images/logo-s.jpg" alt="homepage" class="light-logo" />
                            <?php } elseif (strpos($url, $eclipse_key) == true) { ?>
                                <img src="{{ url('/') }}/assets/images/logo-s.png" alt="homepage" class="light-logo" />
                            <?php } else { ?>
                                <img src="{{ url('/') }}/assets/images/logo-s.png" alt="homepage" class="light-logo" /> 
                            <?php } ?> 
                        @endif
                    @endrole

                    @role('root|dealer|sub_dealer|servicer|trader|sales|finance')
                        <?php
                        $url=url()->current();
                        $rayfleet_key="rayfleet";
                        $eclipse_key="eclipse";
                        if (strpos($url, $rayfleet_key) == true) {  ?>
                            <img src="{{ url('/') }}/assets/images/logo-s.jpg" alt="homepage" class="light-logo" />
                        <?php } elseif (strpos($url, $eclipse_key) == true) { ?>
                            <img src="{{ url('/') }}/assets/images/logo-s.png" alt="homepage" class="light-logo" />
                        <?php } else { ?>
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
        <div class="navbar-collapse collapse operation-header" id="navbarSupportedContent" data-navbarbg="skin5">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->

            @role('root|dealer|sub_dealer|servicer|school|operations|trader|sales|user|Finance|StoreKeeper|Production')

                @role('root')
                    @include('layouts.sections.root-header')
                @endrole
                

                @role('user')
                    @include('layouts.sections.user-header')
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
                @role('trader')
                    @include('layouts.sections.trader-header')
                @endrole
                @role('sales')
                    @include('layouts.sections.sales-header')
                @endrole
                @role('Finance')
                    @include('layouts.sections.finance-header')
                @endrole
               @role('StoreKeeper')
                    @include('layouts.sections.storekeeper-header')
                @endrole
            @endrole
            @role('Driver')
                @include('layouts.sections.driver-header')
            @endrole    
            @role('Call_Center')
                @include('layouts.sections.callcenter-header')
            @endrole

            @role('Production')
                @include('layouts.sections.production-header')
            @endrole
            @role('client')
                @include('layouts.sections.client-header')
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
                        <a class="dropdown-item">Vehicle Number : <h4 id="header_emergency_vehicle_number"></h4></a>
                        <a class="dropdown-item">Location : <h4 id="header_emergency_vehicle_location"></h4></a>
                        <a class="dropdown-item">Time : <h4 id="header_emergency_vehicle_time"></h4></a>
                        <input type="hidden" id="header_emergency_alert_id">
                        <input type="hidden" id="header_alert_vehicle_id">
                        <input type="hidden" id="header_decrypt_vehicle_id">
                        <input type="hidden" id="firebase_key">
                        <a class="dropdown-item"><button onclick="verifyHeaderEmergency()">Verify</button></a>
                    </div>
                </li>
                @role('root|operations|client')
                    <script> 
                        var url_ms_alerts       = '{{ Config::get("eclipse.urls.ms_alerts") }}';
                        var url_ms_trips        = '{{ Config::get("eclipse.urls.ms_trips") }}';
                        var url_ms_live_track   = '{{ Config::get("eclipse.urls.ms_live_track") }}';

                        
                    </script>
                @endrole
                @role('servicer')
                    <script> 
                        var url_ms_vehicle      = '{{ Config::get("eclipse.urls.ms_vehicle")}}';
                    </script>
                @endrole
                @role('client')

                <input type="hidden" id="user_id" value="{{\Auth::user()->id}}">
                <li class="nav-item dropdown">
                    <!-- by christeena<a onclick="clientAlerts()" class="nav-link dropdown-toggle waves-effect waves-dark" title="Alerts" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> -->
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" title="Alerts" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="notification-box">
                        <span class="notification-count" id="bell_notification_count">0</span>
                        <div>
                            <i class="mdi mdi-bell font-24" ></i>
                        </div>
                    </span>
                </a>
                

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <div class="dropdown-divider"></div>
                        <div id="alert_notification">
                        </div>
                        <a class="dropdown-item" href="{{url('/all-alerts')}}">VIEW ALL ALERTS</a>
                    </div>
                    
                    <script> 
                        var firebaseConfig = {
                            apiKey:  '{{Config::get("firebase.apiKey")}}',
                            authDomain: '{{Config::get("firebase.authDomain")}}',
                            databaseURL: '{{Config::get("firebase.databaseURL")}}',
                            projectId: '{{Config::get("firebase.projectId")}}',
                            storageBucket: '{{Config::get("firebase.storageBucket")}}',
                            messagingSenderId: '{{Config::get("firebase.messagingSenderId")}}',
                            appId: '{{Config::get("firebase.appId")}}',
                            measurementId: '{{Config::get("firebase.measurementId")}}'
                        }; 
                    </script>
                    <!-- <script src="https://www.gstatic.com/firebasejs/live/3.0/firebase.js"></script> -->
                    <!-- <script src="{{asset('js/gps/firebase_notifications.js')}}"></script> -->
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
                    <?php
                        echo \Auth::user()->username
                    ?>
                   
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                
                    @role('client')     
                        <img src="{{ url('/') }}/images/{{ \Auth::user()->roles->last()->path }}" alt="user" title="{{\Auth::user()->username}}" class="rounded-circle" width="70" height="60"/>
                        @endrole
                   
                        @role('root|dealer|sub_dealer|servicer|school|operations|trader|sales|user|Call_Center')
                        <img src="{{ url('/') }}/assets/images/2.png" alt="user" title="{{\Auth::user()->username}}" class="rounded-circle" width="31">
                        @endrole
                    </a>
                    
                    <div class="dropdown-menu dropdown-menu-right user-dd animated">
                        <div class="dropdown-divider">
                        </div>
                        @role('client')
                            <a class="dropdown-item" href="{{url('/client/profile')}}">
                                <i class="ti-user m-r-5 m-l-5"></i>{{\Auth::user()->client->name}}</a>

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
                        @role('user')
                            <a style="margin-left: 15px;">
                                <i class="ti-user m-r-5 m-l-5"></i>{{\Auth::user()->username}}</a>
                            <a class="dropdown-item" href="{{url('/root/'.Crypt::encrypt(\Auth::user()->id).'/change-password')}}">
                                <i class="fa fa-cog m-r-5 m-l-5"></i>CHANGE PASSWORD</a>
                        @endrole
                        @role('dealer')
                            <a class="dropdown-item" href="{{url('/dealer/profile')}}">
                                <i class="ti-user m-r-5 m-l-5"></i>{{\Auth::user()->dealer->name}}</a>
                            <a class="dropdown-item" href="{{url('/dealers/'.Crypt::encrypt(\Auth::user()->id).'/change-password')}}">
                                <i class="fa fa-cog m-r-5 m-l-5"></i>CHANGE PASSWORD</a>
                        @endrole
                        @role('sub_dealer')
                            <a class="dropdown-item" href="{{url('/sub-dealer/profile')}}">
                                <i class="ti-user m-r-5 m-l-5"></i>{{\Auth::user()->subDealer->name}}</a>
                            <a class="dropdown-item" href="{{url('/sub-dealers/'.Crypt::encrypt(\Auth::user()->id).'/change-password')}}">
                                <i class="fa fa-cog m-r-5 m-l-5"></i>CHANGE PASSWORD</a>
                        @endrole
                        @role('servicer')
                            <a class="dropdown-item" href="{{url('/servicer/profile')}}">
                                <i class="ti-user m-r-5 m-l-5"></i>{{\Auth::user()->servicer->name}}
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

                        @role('trader')
                            <a class="dropdown-item" href="{{url('/trader/profile')}}">
                                <i class="ti-user m-r-5 m-l-5"></i>{{\Auth::user()->username}}
                            </a>
                            <a class="dropdown-item" href="{{url('/trader_profile_change_password/'.Crypt::encrypt(\Auth::user()->id).'/change-password')}}">
                                <i class="fa fa-cog m-r-5 m-l-5"></i>CHANGE PASSWORD</a>
                        @endrole
                        @role('sales')
                            <a class="dropdown-item" href="{{url('/salesman/profile')}}">
                                <i class="ti-user m-r-5 m-l-5"></i>{{\Auth::user()->username}}
                            </a>
                            <a class="dropdown-item" href="{{url('/salesman/'.Crypt::encrypt(\Auth::user()->id).'/change-password')}}">
                                <i class="fa fa-cog m-r-5 m-l-5"></i>CHANGE PASSWORD</a>
                        @endrole
                        @role('Driver')
                        <a style="margin-left: 15px;">
                                <i class="ti-user m-r-5 m-l-5"></i>{{\Auth::user()->username}}</a>
                            <a class="dropdown-item" href="{{url('/root/'.Crypt::encrypt(\Auth::user()->id).'/change-password')}}">
                                <i class="fa fa-cog m-r-5 m-l-5"></i>CHANGE PASSWORD</a>
                         @endrole
                         @role('Finance')
                        <a style="margin-left: 15px;">
                                <i class="ti-user m-r-5 m-l-5"></i>{{\Auth::user()->username}}</a>
                            <a class="dropdown-item" href="{{url('/root/'.Crypt::encrypt(\Auth::user()->id).'/change-password')}}">
                                <i class="fa fa-cog m-r-5 m-l-5"></i>CHANGE PASSWORD</a>
                         @endrole

                         @role('Call_Center')
                        <a style="margin-left: 15px;">
                                <i class="ti-user m-r-5 m-l-5"></i>{{\Auth::user()->username}}</a>
                            <a class="dropdown-item" href="{{url('/root/'.Crypt::encrypt(\Auth::user()->id).'/change-password')}}">
                                <i class="fa fa-cog m-r-5 m-l-5"></i>CHANGE PASSWORD</a>
                         @endrole
                   <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="clearLocalStorage();event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-power-off m-r-5 m-l-5"></i>LOGOUT
                    </a>
                            
                    </div>
                </li>
            </ul>
        </div>
        <?php
            $test=-1;
            if(\Auth::user()->hasRole('root'))
            {
                $role=md5('root');
                $test=1;
            }
            else if(\Auth::user()->hasRole('user'))
            {
                $role=md5('user');
                $test=11;

            }
            else if(\Auth::user()->hasRole('dealer'))
            {
                $role=md5('dealer');
                $test=2;
            }
            else if(\Auth::user()->hasRole('sub_dealer'))
            {
                $role=md5('sub_dealer');
                $test=3;
            }
            else if(\Auth::user()->hasRole('trader'))
            {
                $role=md5('trader');
                $test=4;
            }
            else if(\Auth::user()->hasRole('client'))
            {
                $role=md5('client');
                $test=5;
            }     
            else if(\Auth::user()->hasRole('operations'))
            {
                $role=md5('operations');
                $test=6;
            }  
            else if(\Auth::user()->hasRole('sales'))
            {
                $role=md5('sales');
                $test=7;
            }
            else if(\Auth::user()->hasRole('servicer'))
            {
                $role=md5('servicer');
                $test=8;
            }
            else if(\Auth::user()->hasRole('Call_Center'))
            {
                $role=md5('Call_Center');
                $test=9;
            }
            else{
                $role=md5('root');//eugene
                $test=0;
            }
            //______________________________________________________________________________________
            /*
            $user_role=\Auth::user()->roles->first()==null?"":\Auth::user()->roles->first()->name;
            echo \Auth::user()->username . " (".$test.") [".$user_role."] ";
            
            $roles = \Auth::user()->getRoleNames(); // Get all roles
            echo "*".strlen($roles)."*";// implode(', ', $roles->toArray());
            //echo "*". $roles->toArray().length . "*";// implode(', ', $roles->toArray());

            Log::info('User roles: ' . implode(', ', $roles->toArray()));
            
            //$test = \Auth::user()->first()->name ?? null;
            //error_log("XXX" . $test, 3, base_path('temp/logfile.log'));
            */
            //________________________________________________________________________________
    ?>
    @role('client')
    <input type="hidden" id="user_id" name="user_id" value="{{\Auth::user()->id}}">
    @endrole
    <input type="hidden" id="header_role" name="header_role" value="{{$role}}">
    </nav>
</header>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
</form>

<div class="modal right fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog model-class" role="document">
        <div class="modal-content modal-content">
            <div class="modal-header modal-header modal-head-bg">
                <h4 class="modal-title" id="myModalLabel2">Alert Details</h4>
                <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>                
            </div>                    
            <div class="modal-body moadl-span-outer">
                 <div class="loader-wrapper" id="load-2">
                 <div id="load2" class="load-modal-img" ></div>
                </div>
                    <span id="alert_content">
                        
                    </span>
                    <div class="alert_address">
                        <h4 class="modai-h4-inner">Address</h4>
                        <span id="alert_address"></span>
                    </div>
                </div>
                <p></p>
            </div>
        </div>
    </div>
</div>

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
@role('operations')
<style>
    .operation-header
    {
        width: 100%;
        padding: 0px 5px 0px 0 !important;
        margin-left: -50px;
    }

</style>
@endrole

<style>
    .load-modal-img{
        width: 35px !important;
        height: 35px !important;
        float: left;
        margin-top: 40px !important;
        margin-left: -32px !important;
    }

</style>
<link rel="stylesheet" href="{{asset('css/loader-2.css')}}">
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



.notification-count {
  position: absolute;
  text-align: center;
  z-index: 1;
  right: 3px;
  width: 40px;
  line-height: 20px;
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

/*@keyframes zoom {
  0% { opacity: 0; transform: scale(0); }
  10% { opacity: 1; transform: scale(1); }
  50% { opacity: 1; }
  51% { opacity: 0; }
  100% { opacity: 0; }
}*/
#2:hover{
    background-color: red!important
}
.psudo-link{
    cursor:pointer;
}
.alert_content{
    line-height:30px;
}
.alert_address{
    margin-top: 12px;
}

.modal-head-bg{
    background: #ffb848;
    color: #fff;
    float: left;
    font-size: 18px;
    padding: 8px 13px;
}
.modal-head-bg h4{
    font-size: 1em;
}
.modai-h4-inner{
    color: #3e5569;
    font-size: 1em;
    float: left;
    padding-bottom: 3px;
    font-weight: 600;
    padding-top: 10px;
}
.moadl-span-outer span{ 
    font-size: 0.9em;
    float: left;
    width: 100%;

}

</style>


 
