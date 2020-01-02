@extends('layouts.eclipse')
@section('title')
  All Vehicle
@endsection
@section('content')

<?php
    $perPage    = 10;
    $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;       
?>
<div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Vehicle List</li>
            <b>Vehicle List</b>
        </ol>
        @if(Session::has('message'))
        <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
            </div>
        </div>
        @endif 
    </nav>
    <!-- Vehicles detail wrapper -->  
    <div class="vehicle_details_wrapper">           
      <table id="vehicle_details_table" class="table table-bordered" style="text-align: center;">
        <thead>
          <tr>
            <th>SL.No</th>
            <th>Vehicle Name</th>
            <th>IMEI</th>
            <th>Service engineer</th>
             <th>Installation Date</th>
          </tr>
        </thead>
        <tbody>
        @if($vehicles->count() == 0)
        <tr>
            <td></td>
          <td><b style="float: right;margin-right: -13px">No data</b></td>
          <td><b style="float: left;margin-left: -15px">Available</b></td>
        </tr>
        @endif

        @foreach($vehicles as $key => $each_vehicle)                  
        <tr id="vehicle_details_table_row_<?php echo $key; ?>" class="vehicle_details_table_row" onclick="single_vehicle_details('{{$each_vehicle->id}}', <?php echo $key; ?>)">
          <td>{{ (($perPage * ($page - 1)) + $loop->iteration) }}</td>
          <td>{{ $each_vehicle->name}}</td>
          <td>{{ $each_vehicle->gps->imei}}</td>
          <td>{{$each_vehicle->servicerjob->servicer->name}}</td>
          <td>{{$each_vehicle->servicerjob->job_complete_date}}</td>
        </tr>
        @endforeach
      </tbody>
      </table>
      {{ $vehicles->appends(['sort' => 'votes'])->links() }}
    </div>
    <!-- /Vehicle details wrapper -->
    <!-- Monitoring details -->
    <div class="monitoring_details_wrapper">
      <!-- Tabs -->
      <ul id="monitoring_details_tabs" class="nav nav-tabs">
        <li class="monitoring_subtab"><a data-toggle="tab" href="#tab_content_vehicle">Vehicle</a></li>
        <li class="monitoring_subtab"><a data-toggle="tab" href="#device">Device</a></li>
        <li class="monitoring_subtab"><a data-toggle="tab" href="#installation">Installation</a></li>
        <li class="monitoring_subtab"><a data-toggle="tab" href="#service">Service</a></li>
        <li class="monitoring_subtab"><a data-toggle="tab" href="#alerts">Alerts</a></li>
        <li class="monitoring_subtab"><a data-toggle="tab" href="#subscription">Subscription</a></li>
      </ul>
      <!-- Tab details -->
      <div id="monitoring_details_tab_contents" class="tab-content">
        <!-- Vehicle -->
        <div id="tab_content_vehicle" class="tab-pane fade in active">
          <!-- Vehicle details -->
          <span>
            <h3>Vehicle Details</h3>
            <div>Vehicle Name :-
              <span id="tvc_vehicle_name"> </span>
            </div>
            <div>Registration Number :-
              <span id="tvc_vehicle_registration_number"></span>
            </div>
            <div>Vehicle Type :-
              <span id="tvc_vehicle_type"> </span>
            </div>
            <div>Vehicle Model :-
              <span id="tvc_vehicle_model"> </span>
            </div>
            <div>Vehicle Make :-
              <span id="tvc_vehicle_make"> </span>
            </div>
            <div>Vehicle Min Fuel :-
              <span id="tvc_vehicle_min_fuel"> </span>
            </div>
            <div>Vehicle Max Fuel :-
              <span id="tvc_vehicle_max_fuel"> </span>
            </div>
            <div>Vehicle Status :-
              <span id="tvc_vehicle_status"> </span>
            </div>
            <div>Engine Number :-
              <span id="tvc_vehicle_engine_number"> </span>
            </div>
            <div>Chassis Number :-
              <span id="tvc_vehicle_chassis_number"> </span>
            </div>
            <div>Theft Mode :-
              <span id="tvc_vehicle_theftmode"> </span>
            </div>
            <div>Towing :-
              <span id="tvc_vehicle_towing"> </span>
            </div>
            <div>Emergency Status :-
              <span id="tvc_vehicle_emergency_status"> </span>
            </div>
            <div>Created Date :-
              <span id="tvc_vehicle_created_date"> </span>
            </div>
            <!-- /Vehicle details -->

            <!-- Owner details -->
            <h3>Owner Details</h3>
            <div>Owner Name :-
              <span id="tvc_client_name"> </span>
            </div>
            <div>Owner Address :-
              <span id="tvc_client_address"> </span>
            </div>
            <div>Owner Latitude :-
              <span id="tvc_client_lat"> </span>
            </div>
            <div>Owner Longitude :-
              <span id="tvc_client_lng"> </span>
            </div>
            <div>Owner Logo :-
              <span id="tvc_client_logo"></span>
            </div>
            <div>Owner Country :-
              <span id="tvc_client_country"> </span>
            </div>
            <div>Owner State :-
              <span id="tvc_client_state"> </span>
            </div>
            <div>Owner City :-
              <span id="tvc_client_city"> </span>
            </div>
            <div>Sub Dealer :-
              <span id="tvc_client_sub_dealer"> </span>
            </div>
          </span>
          <!-- /Owner details -->

          <!-- Driver details -->
          <span>
            <h3>Driver Details</h3>
            <div>Driver Name :-
              <span id="tvc_driver_name"> </span>
            </div>
            <div>Driver Address :-
              <span id="tvc_driver_address"> </span>
            </div>
            <div>Driver Mobile :-
              <span id="tvc_driver_mobile"> </span>
            </div>
            <div>Driver Points :-
              <span id="tvc_driver_points"> </span>
            </div>
          </span>
          <!-- /Driver details -->
        </div>
        <!-- /Vehicle -->
        <!-- Device -->
        <div id="device" class="tab-pane fade in active">
          <!-- Device details-->
          <h3>Device Details</h3>
          <div>IMEI :-
            <span id="tvc_device_imei"> </span>
          </div> 
          <div>Serial Number :-
            <span id="tvc_device_serial_no"> </span>
          </div>
          <div>Manufacturing date :-
            <span id="tvc_device_manufacturing_date"> </span>
          </div>
          <div>ICC Id :-
            <span id="tvc_device_icc_id"> </span>
          </div>
          <div>IMSI :-
            <span id="tvc_device_imsi"> </span>
          </div>
          <div>E Sim Number :-
            <span id="tvc_device_e_sim_number"> </span>
          </div>
          <div>Batch Number :-
            <span id="tvc_device_batch_number"> </span>
          </div>
          <div>Model Name :-
            <span id="tvc_device_model_name"> </span>
          </div>
          <div>Version :-
            <span id="tvc_device_version"> </span>
          </div>
          <div>Employee Code :-
            <span id="tvc_device_employee_code"> </span>
          </div>
          <div>Number of satellites :-
            <span id="tvc_device_satellites"> </span>
          </div>
          <div>Emergency Status :-
            <span id="tvc_device_emergency_status"> </span>
          </div>
          <div>GPS Fix :-
            <span id="tvc_device_gps_fix"> </span>
          </div>
          <div>Calibrated on :-
            <span id="tvc_device_calibrated_on"> </span>
          </div>
          <div>Login on :-
            <span id="tvc_device_login_on"> </span>
          </div>
          <div>Created At :-
            <span id="tvc_device_created_on"> </span>
          </div>
          <!-- /Device details-->

          <!-- Device Current status-->
          <h3>Device Current Status</h3>
           <div>Mode:-
            <span id="tvc_device_mode"> </span>
          </div>
          <div>Latitude:-
            <span id="tvc_device_lat"> </span>
          </div>
          <div>Longitude:-
            <span id="tvc_device_lon"> </span>
          </div>
          <div>Network Status:-
            <span id="tvc_device_network_status"> </span>
          </div>
          <div>Fuel Status:-
            <span id="tvc_device_fuel_status"> </span>
          </div>
          <div>Speed:-
            <span id="tvc_device_speed"> </span>
          </div>
          <div>Odometer:-
            <span id="tvc_device_odometer"> </span>
          </div>
          <div>Battery Status:-
            <span id="tvc_device_battery_status"> </span>
          </div>
          <div>Main Power Status:-
            <span id="tvc_device_main_power_status"> </span>
          </div>
          <div>Device Time:-
            <span id="tvc_device_device_time"> </span>
          </div>
          <div>Ignition:-
            <span id="tvc_device_ignition"> </span>
          </div>
          <div>GSM Signal Strength:-
            <span id="tvc_device_gsm_signal_strength"> </span>
          </div><div>AC Status:-
            <span id="tvc_device_ac_status"> </span>
          </div><div>Kilometer:-
            <span id="tvc_device_kilometer"> </span>
          </div>
         <!-- /Device Current status-->
        </div>
        <!-- /Device -->
        <div id="installation" class="tab-pane fade">
          <h3>Installation</h3>
          <div id="installation_table_wrapper"></div>
         
        </div>
        <div id="service" class="tab-pane fade">
          <h3>Service</h3>
            <div id="service_table_wrapper"></div>
        </div>
        <div id="alerts" class="tab-pane fade">
          <h3>Alerts</h3>
            <div id="alert_table_wrapper"></div>
        </div>
        <div id="subscription" class="tab-pane fade">
          <h3>Subscription</h3>
          <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
        </div>
      </div>
      <!-- /Tab details -->
    </div>
    <!-- /Monitoring details --> 
</div>
@endsection
<link rel="stylesheet" type="text/css" href="{{asset('css/monitor.css')}}">
<style type="text/css" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"></style>
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js">      </script>
   <script type="text/javascript" src="{{asset('js/gps/monitor-list.js')}}"></script>
@endsection

<style>

</style>