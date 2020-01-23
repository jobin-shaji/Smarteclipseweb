@extends('layouts.eclipse')
@section('title')
  All Vehicle
@endsection
@section('content')
<?php
    $perPage    = 10;
    $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $key        = ( isset($_GET['monitoring_module_search_key']) ) ? $_GET['monitoring_module_search_key'] : '';  
?>

<div class="modal fade show in" id="emergeny_alert_modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header"  style="margin-bottom: 5px;">
        <h5 class="modal-title">Alert</h5>
        <button type="button" class="close" onclick="closeModal()" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- /Header -->
      <!-- Body -->
      <div class="modal-body" id="eam_body">
      </div>
    </div>
  </div>
</div>
<div class="page-wrapper_new page-wrapper-1">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <b>Monitoring</b>
    </ol>
    @if(Session::has('message'))
      <div class="pad margin no-print">
        <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
        </div>
      </div>
    @endif 
  </nav>
  
  <ul class="monitor_tab_for_map">
    <li class="mlt vst-theme-color" value="list" id="mlt_list"><a href="#">Monitoring</a></li>
    <a target="_blank" href="{{url('/monitor-map')}}"><li class="mlt ">Map</li></a>
    <li class="mlt" value="alert" id="mlt_alert"><a href="#">Alert</a></li>


  </ul>
  
  <div class="mlt-list">

    <!-- Search and filters -->
  <div align="right" class="search-1">
    <form  method="GET" action="{{route('monitor_vehicle')}}" class="search-top">
       {{csrf_field()}}
      <input type="text" placeholder=" Search for Vehicle" name="monitoring_module_search_key" id="monitoring_module_search_key" value="{{ $key }}">
      <button type="submit" title="Enter IMEI,Owner,Vehicle,Distributor,Dealer,Service Engineer name">Search</button>
      <button class=".search-1 clear-bt-new" onclick="clearSearch()">Clear</button>
    </form>
  </div>
  <!-- /Search and filters -->

  <!-- Vehicles detail wrapper --> 
        <div class="vehicle_details_wrapper vehicle-container">  
        <!-- <div class="loader"></div>          -->
          <table id="vehicle_details_table" class="table table-bordered">
            <thead>
              <tr class="vechile-list-top">
                <th style="width:4%;">SL.No</th>
                <th style="width:17%;">Owner Name</th>
                <th style="width:8%;">Owner Mobile</th>
                <th style="width:15%;">Vehicle Name</th>
                <th style="width:8%;">IMEI</th>
                <th style="width:11%;">Distributor</th>
                <th style="width:11%;">Dealer</th>
                <th style="width:11%;">Sub-Dealer</th>
                <th style="width:11%;">Service Engineer</th>
                <th style="width:4%;">Installation Date</th>
              </tr>
            </thead>
            <tbody style="max-height:200px; overflow-y: scroll;" >
              @if($vehicles->count() == 0)
                <tr>
                  <td style="width:4%;"></td>
                  <td style="width:17%;"></td>
                  <td style="width:8%;"></td>
                  <td style="width:15%;"><b style="float: right;margin-right: -13px">No data</b></td>
                  <td style="width:8%;"><b style="float: left;margin-left: -15px">Available</b></td>
                  <td style="width:11%;"></td>
                  <td style="width:11%;"></td>
                  <td style="width:11%;"></td>
                  <td style="width:11%;"></td>
                  <td style="width:4%;"></td>
                </tr>
              @endif
              <?php
              
              ?>
              @foreach($vehicles as $key => $each_vehicle) 
                <?php $date = explode(' ', $each_vehicle->job_complete_date); ?>
                <tr id="vehicle_details_table_row_<?php echo $key; ?>" class="vehicle_details_table_row" onclick="clicked_vehicle_details('{{$each_vehicle->id}}', <?php echo $key; ?>)" data-target="#sidebar-right" data-toggle="modal">
                  <td style="width:4%;">{{ (($perPage * ($page - 1)) + $loop->iteration) }}</td>
                  <td style="width:17%;">{{ $each_vehicle->client_name }}</td>
                  <td style="width:8%;">{{ $each_vehicle->mobile_number}}</td>
                  <td style="width:15%;">{{ $each_vehicle->vehicle_name }}</td>
                  <td style="width:8%;">{{ $each_vehicle->imei }}</td>
                  <td style="width:11%;">{{ $each_vehicle->distributor_name }} ({{ $each_vehicle->distributor_mobile }})</td>
                  <td style="width:11%;"><?php if( isset($each_vehicle->sub_dealer_name) ){ echo '--'; } else { echo $each_vehicle->dealer_name.'('.$each_vehicle->dealer_mobile.')'; } ?></td>
                  <td style="width:11%;"><?php echo (isset($each_vehicle->sub_dealer_name)) ? $each_vehicle->sub_dealer_name.'('.$each_vehicle->sub_dealer_mobile.')' : '--'; ?></td>
                  <td style="width:11%;">{{$each_vehicle->servicer_name }} ({{ $each_vehicle->servicer_mobile }})</td>
                  <td style="width:4%;">{{ $date[0] }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
          {{ $vehicles->appends(Request::all())->links() }}
        </div>

        <!-- /Vehicle details wrapper -->
          <!-- Monitoring details -->
        <div class="monitoring_details_wrapper moni-detail-container">
          <div class="modal fade right" id="sidebar-right" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
              <div class="modal-content">
                <div class="close-bt">
                  <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="right-sider-inner">
                  <!-- Monitoring details -->
                    <!-- Tabs -->
                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Download</button>
                 

                    <ul id="monitoring_details_tabs" class="nav nav-tabs">
                      <li class="monitoring_subtab ">
                        <a data-toggle="tab" href="#tab_content_vehicle" class="active">Vehicle</a>
                      </li>
                      <li class="monitoring_subtab">
                        <a data-toggle="tab" href="#device">Device</a>
                      </li>
                      <li class="monitoring_subtab">
                        <a data-toggle="tab" href="#installation">Installation</a>
                      </li>
                      <li class="monitoring_subtab">
                        <a data-toggle="tab" href="#service">Service</a>
                      </li>
                      <li class="monitoring_subtab">
                        <a data-toggle="tab" href="#alerts">Alerts</a>
                      </li>
                      <li class="monitoring_subtab">
                        <a data-toggle="tab" href="#subscription">Data & SMS</a>
                      </li>
                    </ul>
                    <div id="monitoring_details_tab_contents_loading" class="please-w8" style="display: none;">
                      Please wait...
                    </div>
                    <!-- Tab details -->
                    <div class="vechile-container">
                      <div id="monitoring_details_tab_contents" class="tab-content monitoring_details">
                        <!-- Vehicle -->
                        <div id="tab_content_vehicle" class="tab-pane fade in active">
                          <!-- Vehicle details -->
                         

                          <div class="detail-list-outer">
                            <div id="accordion">
                              <div class="button" role="button">
                                Vehicle Details
                              </div>
                              <div class="slide">
                                <div class="list-outer-bg">
                                  <div class="list-display">
                                    <p>Vehicle Name <span>:-</span></p>
                                    <span class="vehicle-details-value" id="tvc_vehicle_name"></span>
                                  </div>
                                  <div class="list-display">
                                    <p>Registration Number <span>:-</span></p>
                                    <span class="vehicle-details-value" id="tvc_vehicle_registration_number"></span>
                                  </div>    
                                  <div class="list-display">
                                    <p>Vehicle Type <span>:-</span></p>
                                    <span class="vehicle-details-value" id="tvc_vehicle_type"> </span>
                                  </div>
                                  <div class="list-display">
                                    <p>Vehicle Model <span>:-</span></p>
                                    <span class="vehicle-details-value" id="tvc_vehicle_model"> </span>
                                  </div>
                                  <div class="list-display">
                                    <p>Vehicle Make <span>:-</span></p>
                                    <span class="vehicle-details-value" id="tvc_vehicle_make"> </span>
                                  </div>
                                  <div class="list-display">
                                    <p>Engine Number <span>:-</span></p>
                                    <span class="vehicle-details-value" id="tvc_vehicle_engine_number"> </span>
                                  </div>
                                   <div class="list-display">
                                    <p>Chassis Number <span>:-</span></p>
                                    <span class="vehicle-details-value" id="tvc_vehicle_chassis_number"> </span>
                                  </div>
                                  <div class="list-display">
                                    <p>Theft Mode <span>:-</span></p>
                                    <span class="vehicle-details-value" id="tvc_vehicle_theftmode"> </span>
                                  </div>
                                  <div class="list-display">
                                    <p>Towing <span>:-</span></p>
                                    <span class="vehicle-details-value" id="tvc_vehicle_towing"> </span>
                                  </div>
                                  <div class="list-display">
                                    <p>Emergency Status <span>:-</span></p>
                                    <span class="vehicle-details-value" id="tvc_vehicle_emergency_status"> </span>
                                  </div>
                                  <div class="list-display">
                                    <p>Created At <span>:-</span></p>
                                    <span class="vehicle-details-value" id="tvc_vehicle_created_date"> </span>
                                  </div>
                                </div>
                              </div>
                              <div class="button" role="button">
                               Owner Details
                              </div>
                              <div class="slide">
                                <div class="list-outer-bg">
                                  <div class="list-display">
                                    <p>Owner Name <span>:-</span></p>
                                    <span class="vehicle-details-value" id="tvc_client_name"> </span>
                                  </div>
                                  <div class="list-display">
                                    <p>Owner Address <span>:-</span></p>
                                    <span class="vehicle-details-value" id="tvc_client_address"> </span>
                                  </div>
                                  <div class="list-display">
                                    <p>Owner Mobile <span>:-</span></p>
                                    <span class="vehicle-details-value" id="tvc_client_mobile"> </span>
                                  </div>
                                  <div class="list-display">
                                    <p>Owner Email <span>:-</span></p>
                                    <span  class="vehicle-details-value" id="tvc_client_email"> </span>
                                  </div>
                                  <div class="list-display">
                                    <p>Owner Latitude <span>:-</span></p>
                                    <span  class="vehicle-details-value" id="tvc_client_lat"> </span>
                                  </div>
                                  <div class="list-display">
                                    <p>Owner Longitude <span>:-</span></p>
                                    <span class="vehicle-details-value" id="tvc_client_lng"> </span>
                                  </div>
                                  <div class="list-display">
                                    <p>Owner Country <span>:-</span></p>
                                    <span  class="vehicle-details-value" id="tvc_client_country"> </span>
                                  </div>
                                  <div class="list-display">
                                    <p>Owner State <span>:-</span></p>
                                    <span class="vehicle-details-value" id="tvc_client_state"> </span>
                                  </div>
                                  <div class="list-display">
                                    <p>Owner City <span>:-</span></p>
                                    <span class="vehicle-details-value" id="tvc_client_city"> </span>
                                  </div>
                                  <div class="list-display">
                                    <p>Dealer <span>:-</span></p>
                                    <span class="vehicle-details-value" id="tvc_client_sub_dealer"> </span>
                                  </div>
                                  <div class="list-display">
                                    <p>Owner Package <span>:-</span></p>
                                    <span class="vehicle-details-value" id="tvc_client_package"> </span>
                                  </div>
                                </div>
                              </div>
                              <div class="button" role="button">
                                Driver Details
                              </div>
                              <div class="slide">
                                <div class="list-outer-bg">
                                  <div class="list-display">
                                    <p>Driver Name <span>:-</span></p>
                                    <span  class="vehicle-details-value" id="tvc_driver_name"> </span>
                                  </div>
                                  <div class="list-display">
                                    <p>Driver Address <span>:-</span></p>
                                    <span  class="vehicle-details-value" id="tvc_driver_address"> </span>
                                  </div>
                                  <div class="list-display">
                                    <p>Driver Mobile <span>:-</span></p>
                                    <span  class="vehicle-details-value" id="tvc_driver_mobile"> </span>
                                  </div>
                                  <div class="list-display">
                                    <p>Driver Points <span>:-</span></p>
                                    <span  class="vehicle-details-value" id="tvc_driver_points"> </span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- /Driver details -->
                          </div>
                        </div>
                        <!-- /Vehicle -->
                        <!-- Device -->
                        <div id="device" class="tab-pane fade in active">
                          <div id="accordion1">
                            <div class="button" role="button">
                              Device Details
                            </div>
                            <div class="slide">
                              <div class="list-outer-bg">
                                <div class="list-display">
                                  <p>IMEI <span>:-</span></p>
                                  <span  class="vehicle-details-value" id="tvc_device_imei"> </span>
                                </div>
                                <div class="list-display">
                                  <p>Serial Number <span>:-</span></p>
                                  <span  class="vehicle-details-value" id="tvc_device_serial_no"> </span>
                                </div>
                                <div class="list-display">
                                  <p>Manufacturing date <span>:-</span></p>
                                  <span  class="vehicle-details-value" id="tvc_device_manufacturing_date"> </span>
                                </div>
                                <div class="list-display">
                                  <p>ICC Id <span>:-</span></p>
                                  <span class="vehicle-details-value" id="tvc_device_icc_id"> </span>
                                </div>
                                <div class="list-display">
                                  <p>IMSI <span>:-</span></p>
                                  <span class="vehicle-details-value"  id="tvc_device_imsi"> </span>
                                </div>
                                <div class="list-display">
                                  <p>E Sim Number <span>:-</span></p>
                                  <span class="vehicle-details-value" id="tvc_device_e_sim_number"> </span>
                                </div>
                                <div class="list-display">
                                  <p>Batch Number <span>:-</span></p>
                                  <span class="vehicle-details-value" id="tvc_device_batch_number"> </span>
                                </div>
                                <div class="list-display">
                                  <p>Model Name <span>:-</span></p>
                                  <span class="vehicle-details-value" id="tvc_device_model_name"> </span>
                                </div>
                                <div class="list-display">
                                  <p>Version <span>:-</span></p>
                                  <span class="vehicle-details-value" id="tvc_device_version"> </span>
                                </div>
                                <div class="list-display">
                                  <p>Employee Code <span>:-</span></p>
                                  <span class="vehicle-details-value"  id="tvc_device_employee_code"> </span>
                                </div>
                                <div class="list-display">
                                  <p>Number of satellites <span>:-</span></p>
                                  <span  class="vehicle-details-value" id="tvc_device_satellites"> </span>
                                </div>
                                <div class="list-display">
                                  <p>Emergency Status <span>:-</span></p>
                                  <span class="vehicle-details-value" id="tvc_device_emergency_status"> </span>
                                </div>
                                <div class="list-display">
                                  <p>GPS Fix <span>:-</span></p>
                                  <span class="vehicle-details-value"  id="tvc_device_gps_fix"> </span>
                                </div>
                                <div class="list-display">
                                  <p>Calibrated on <span>:-</span></p>
                                  <span  class="vehicle-details-value" id="tvc_device_calibrated_on"> </span>
                                </div>
                                <div class="list-display">
                                  <p>Login on <span>:-</span></p>
                                  <span class="vehicle-details-value" id="tvc_device_login_on"> </span>
                                </div>
                                <div class="list-display">
                                  <p>Created At <span>:-</span></p>
                                  <span class="vehicle-details-value" id="tvc_device_created_on"> </span>
                                </div>
                              </div>
                            </div>
                            <div class="button" role="button">
                              Device Current Status
                            </div>
                            <div class="slide">
                              <div class="list-outer-bg">
                                <div class="list-display">
                                  <p>Mode<span>:-</span></p>
                                  <span  class="vehicle-details-value" id="tvc_device_mode"> </span>
                                </div>
                                <div class="list-display">
                                  <p>Latitude<span>:-</span></p>
                                  <span class="vehicle-details-value"  id="tvc_device_lat"> </span>
                                </div>
                                <div class="list-display">
                                  <p>Longitude<span>:-</span></p>
                                  <span  class="vehicle-details-value" id="tvc_device_lon"> </span>
                                </div>
                                
                                <div class="list-display">
                                  <p>Fuel Status<span>:-</span></p>
                                  <span class="vehicle-details-value" id="tvc_device_fuel_status"> </span>
                                </div>
                                <div class="list-display">
                                  <p>Speed<span>:-</span></p>
                                  <span  class="vehicle-details-value" id="tvc_device_speed"> </span>
                                </div>
                                <div class="list-display">
                                  <p>Odometer<span>:-</span></p>
                                  <span class="vehicle-details-value" id="tvc_device_odometer"> </span>
                                </div>
                                <div class="list-display">
                                  <p>Battery Status<span>:-</span></p>
                                  <span  class="vehicle-details-value" id="tvc_device_battery_status"> </span>
                                </div>
                                <div class="list-display">
                                  <p>Main Power Status<span>:-</span></p>
                                  <span class="vehicle-details-value" id="tvc_device_main_power_status"> </span>
                                </div>
                                <div class="list-display">
                                  <p>Device Date & Time<span>:-</span></p>
                                  <span  class="vehicle-details-value" id="tvc_device_device_time"> </span>
                                </div>
                                <div class="list-display">
                                  <p>Ignition<span>:-</span></p>
                                  <span  class="vehicle-details-value" id="tvc_device_ignition"> </span>
                                </div>
                                <div class="list-display">
                                  <p>GSM Signal Strength<span>:-</span></p>
                                  <span  class="vehicle-details-value" id="tvc_device_gsm_signal_strength"> </span>
                                </div>
                                <div class="list-display">
                                  <p>AC Status<span>:-</span></p>
                                  <span  class="vehicle-details-value" id="tvc_device_ac_status"> </span>
                                </div>
                              </div>
                            </div>
                            <div class="button" role="button">
                              Device Configuration
                            </div>
                            <div class="slide">
                              <div class="list-outer-bg">
                                <div class="list-display" id="ota">
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- /Device details-->
                          <!-- Device Current status-->
                         <!-- /Device Current status-->
                        </div>
                        <!-- /Device -->
                        <div id="installation" class="tab-pane fade">
                          <div class="acc-container">
                            <div class="acc-content open">
                              <div class="acc-content-inner">
                                <div class="table-outer">
                                  <div id="installation_table_wrapper"></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div id="service" class="tab-pane fade">
                          <div class="acc-container">
                            <div class="acc-content open">
                              <div class="acc-content-inner">
                                <div class="table-outer">
                                  <div id="service_table_wrapper"></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div id="alerts" class="tab-pane fade">
                          <div class="acc-container">
                            <div class="acc-content open">
                              <div class="acc-content-inner">
                                <div class="table-outer">
                                  <div id="alert_table_wrapper"></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div id="subscription" class="tab-pane fade">
                          <div class="acc-container">
                            <div class="acc-content open">
                              <div class="acc-content-inner">
                                <div class="">
                                  Please refer <a href="https://portal.tatacommunications.com/" target="_blank">
                                  https://portal.tatacommunications.com/</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- /Tab details -->
                    </div>
                  </div>
                  <!-- /Monitoring details --> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <div id="critical_alerts_table" class="mlt-alert">
     <!--  <p>Please wait...</p> -->
    </div> 


  </div>

<audio id="myAudio">
  <source src="../assets/sounds/alerts.mp3" type="audio/ogg">
  <source src="../assets/sounds/alerts.mp3" type="audio/mpeg">
</audio>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
         <form  method="POST" action="{{route('monitoring.report.pdf.downloads')}}">
            {{csrf_field()}}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Report Type</h4>
        </div>
         <input type="hidden" name="vehicle_id" id="vehicle_id" value="">
        <div class="modal-body">
           <div id="report_type">
            <input type="checkbox" id="report_type1" name="report[]" value="1">Vehicle Details</br>
            <input type="checkbox" id="report_type2"  name="report[]" value="2">Owner Details</br>
            <input type="checkbox" id="report_type3" name="report[]" value="3">Driver Details</br>
            <input type="checkbox" id="report_type4" name="report[]" value="4">Device Details</br>
            <input type="checkbox" id="report_type5" name="report[]" value="5">Device Current Status</br>
            <input type="checkbox" id="report_type6" name="report[]" value="6">Device Configuration</br>
            <input type="checkbox" id="report_type7" name="report[]" value="7">Installation</br>
            <input type="checkbox" id="report_type8" name="report[]" value="8">Service</br>
            <input type="checkbox" id="report_type9" name="report[]" value="9">Alerts</br>         
        </div>         
        </div>     
        <div class="modal-footer">
          <button type="submit" class="btn btn-default"><i class='fa fa-download'></i>Download Certificate</button>
          <button type="button" class="btn btn-default" data-dismiss="modal" onclick="downloadMonitoringReport()" >Download Excel</button>        
        </div>
         </form>
      </div>
      
    </div>
  </div>

@endsection
<link rel="stylesheet" type="text/css" href="{{asset('css/monitor.css')}}">
<style type="text/css" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"></style>


 

@section('script')


<script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-core.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-service.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-ui.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-mapevents.js"></script>
<script type="text/javascript" src="{{asset('js/gps/monitor-list.js')}}"></script>

<script type="text/javascript">


  // alerts on map
    var parisMarker = new H.map.Marker({ lat: 10.192656, lng: 76.386666 });
    var objImg = document.createElement('img');
    objImg.src = '';
    var outerElement = document.createElement('div')
    var domIcon = new H.map.DomIcon(outerElement);
    var bearsMarker = new H.map.DomMarker({ lat: 10.192656, lng: 76.386666 }, {
        icon: domIcon
    });

    var hidpi = ('devicePixelRatio' in window && devicePixelRatio > 1);
    var secure = (location.protocol === 'https:') ? true : false; // check if the site was loaded via secure connection
    var app_id = "vvfyuslVdzP04AK3BlBq",
        app_code = "f63d__fBLLCuREIGNr6BjQ";

    var mapContainer = document.getElementById('markers');
    var platform = new H.service.Platform({ app_code: app_code, app_id: app_id, useHTTPS: secure });
    var maptypes = platform.createDefaultLayers(hidpi ? 512 : 256, hidpi ? 320 : null);

    var map = new H.Map(mapContainer, maptypes.normal.map);
    map.setCenter({ lat: 10.192656, lng: 76.386666 });
    map.setZoom(14);
    var zoomToResult = true;
    var mapTileService = platform.getMapTileService({
        type: 'base'
    });
    var parameters = {};
    var uTurn = false;

    new H.mapevents.Behavior(new H.mapevents.MapEvents(map)); // add behavior control
    var ui = H.ui.UI.createDefault(map, maptypes); // add UI
    



    var locationQueue=[];


    window.setInterval(function(){
        addToLocationQueue();
    }, 2000);


    function addToLocationQueue()
     {
       
        console.log(location_data[1]);
        var marker_location = new H.map.Marker({lat:location_data[1].latitude, lng:location_data[1].longitude});
        map.addObject(marker_location);

        popFromLocationQueue();
     }

    function popFromLocationQueue(){
     if(location_data.length>0)
     {
          return location_data.splice(0,1)[0];    
     }
      else
      return null;
    }
    function addMarkersToMap(){
    }

</script>

  



   
<!-- accordian -->
<script type="text/javascript">


  
  $(document).ready(function() {
  
  $('.slide').hide()
 
  $("#accordion").find("div[role|='button']").click(function() {
    $("#accordion").find("div[role|='button']").removeClass('active');
    $('.slide').slideUp('fast');
    var selected = $(this).next('.slide');
    if (selected.is(":hidden")) {
      $(this).next('.slide').slideDown('fast');
      $(this).toggleClass('active');
    }
  });
});
  
  $(document).ready(function() {
  
  $('.slide').hide()
 
  $("#accordion1").find("div[role|='button']").click(function() {
    $("#accordion1").find("div[role|='button']").removeClass('active');
    $('.slide').slideUp('fast');
    var selected = $(this).next('.slide');
    if (selected.is(":hidden")) {
      $(this).next('.slide').slideDown('fast');
      $(this).toggleClass('active');
    }
  });
});

function closeModal()
{
  $('#emergeny_alert_modal').hide();
  audio.pause();
}
</script>

<!-- /accordian -->
@endsection

