@extends('layouts.eclipse')
@section('title')
  All Vehicle
@endsection
@section('content')

<?php
    $perPage    = 10;
    $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;       
?>
<div class="page-wrapper_new page-wrapper-1">
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
    <div class="vehicle_details_wrapper vehicle-container">           
      <table id="vehicle_details_table" class="table table-bordered" style="text-align: center;">
        <thead>
          <tr class="vechile-list-top">
            <th>SL.No</th>
            <th>Vehicle Name</th>
            <th>IMEI</th>
            <th>Service engineer</th>
             <th>Installation Date</th>
          </tr>
        </thead>
       
        <tbody style="max-height:200px; overflow-y: scroll;" >
  
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
    <div class="monitoring_details_wrapper moni-detail-container">
      <!-- Tabs -->
      <ul id="monitoring_details_tabs" class="nav nav-tabs">
        <li class="monitoring_subtab "><a data-toggle="tab" href="#tab_content_vehicle"class="active">Vehicle</a></li>
        <li class="monitoring_subtab"><a data-toggle="tab" href="#device">Device</a></li>
        <li class="monitoring_subtab"><a data-toggle="tab" href="#installation">Installation</a></li>
        <li class="monitoring_subtab"><a data-toggle="tab" href="#service">Service</a></li>
        <li class="monitoring_subtab"><a data-toggle="tab" href="#alerts">Alerts</a></li>
        <li class="monitoring_subtab"><a data-toggle="tab" href="#subscription">Subscription</a></li>
      </ul>
         <div id="monitoring_details_tab_contents_loading" style="display: none;">
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
      
    <div class="list-display"><p>Vehicle Name :-</p>
              <span id="tvc_vehicle_name"> </span>

            </div>
               <div class="list-display"><p>Registration Number :-</p>
              <span id="tvc_vehicle_registration_number"></span>
            </div>
            <div class="list-display"><p>Vehicle Type :-</p>
              <span id="tvc_vehicle_type"> </span>
            </div>
             <div class="list-display"><p>Vehicle Model :-</p>
              <span id="tvc_vehicle_model"> </span>
            </div>
            <div class="list-display"><p>Vehicle Make :-</p>
              <span id="tvc_vehicle_make"> </span>
            </div>
             <div class="list-display"><p>Vehicle Min Fuel :-</p>
              <span id="tvc_vehicle_min_fuel"> </span>
            </div>
            <div class="list-display"><p>Vehicle Max Fuel :-</p>
              <span id="tvc_vehicle_max_fuel"> </span>
            </div>
            <div class="list-display"><p>Vehicle Status :-</p>
              <span id="tvc_vehicle_status"> </span>
            </div>
             <div class="list-display"><p>Engine Number :-</p>
              <span id="tvc_vehicle_engine_number"> </span>
            </div>
             <div class="list-display"><p>Chassis Number :-</p>
              <span id="tvc_vehicle_chassis_number"> </span>
            </div>
           <div class="list-display"><p>Theft Mode :-</p>
              <span id="tvc_vehicle_theftmode"> </span>
            </div>
            <div class="list-display"><p>Towing :-</p>
              <span id="tvc_vehicle_towing"> </span>
            </div>
             <div class="list-display"><p>Emergency Status :-</p>
              <span id="tvc_vehicle_emergency_status"> </span>
            </div>
            <div class="list-display"><p>Created Date :-</p>
              <span id="tvc_vehicle_created_date"> </span>
            </div>

    </div>
  </div>
  <div class="button" role="button">
   Owner Details
  </div>

  <div class="slide">
      <div class="list-outer-bg">
       <div class="list-display"><p>Owner Name :-</p>
              <span id="tvc_client_name"> </span>
            </div>
              <div class="list-display"><p>Owner Address :-</p>
              <span id="tvc_client_address"> </span>
            </div>
            <div class="list-display"><p>Owner Latitude :-</p>
              <span id="tvc_client_lat"> </span>
            </div>
            <div class="list-display"><p>Owner Longitude :-</p>
              <span id="tvc_client_lng"> </span>
            </div>
             <div class="list-display"><p>Owner Logo :-</p>
              <span id="tvc_client_logo"></span>
            </div>
              <div class="list-display"><p>Owner Country :-</p>
              <span id="tvc_client_country"> </span>
            </div>
              <div class="list-display"><p>Owner State :-</p>
              <span id="tvc_client_state"> </span>
            </div>
              <div class="list-display"><p>Owner City :-</p>
              <span id="tvc_client_city"> </span>
            </div>
              <div class="list-display"><p>Sub Dealer :-</p>
              <span id="tvc_client_sub_dealer"> </span>
            </div>
  </div>
    </div>
  <div class="button" role="button">
 Driver Details
  </div>
  <div class="slide">
         <div class="list-outer-bg">
    <div class="list-display"><p>Driver Name :-</p>
              <span id="tvc_driver_name"> </span>
            </div>
            <div class="list-display"><p>Driver Address :-</p>
              <span id="tvc_driver_address"> </span>
            </div>
            <div class="list-display"><p>Driver Mobile :-</p>
              <span id="tvc_driver_mobile"> </span>
            </div>
            <div class="list-display"><p>Driver Points :-</p>
              <span id="tvc_driver_points"> </span>
            </div>
  </div></div>
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
    <div class="list-display"><p>IMEI :-</p>
            <span id="tvc_device_imei"> </span>
          </div>
          <div class="list-display"><p>Serial Number :-</p>
            <span id="tvc_device_serial_no"> </span>
          </div>
          <div class="list-display"><p>Manufacturing date :-</p>
            <span id="tvc_device_manufacturing_date"> </span>
          </div>
          <div class="list-display"><p>ICC Id :-</p>
            <span id="tvc_device_icc_id"> </span>
          </div>
           <div class="list-display"><p>IMSI :-</p>
            <span id="tvc_device_imsi"> </span>
          </div>
            <div class="list-display"><p>E Sim Number :-</p>
            <span id="tvc_device_e_sim_number"> </span>
          </div>
            <div class="list-display"><p>Batch Number :-</p>
            <span id="tvc_device_batch_number"> </span>
          </div>
            <div class="list-display"><p>Model Name :-</p>
            <span id="tvc_device_model_name"> </span>
          </div>
            <div class="list-display"><p>Version :-</p>
            <span id="tvc_device_version"> </span>
          </div>
            <div class="list-display"><p>Employee Code :-</p>
            <span id="tvc_device_employee_code"> </span>
          </div>
           <div class="list-display"><p>Number of satellites :-</p>
            <span id="tvc_device_satellites"> </span>
          </div>
            <div class="list-display"><p>Emergency Status :-</p>
            <span id="tvc_device_emergency_status"> </span>
          </div>
            <div class="list-display"><p>GPS Fix :-</p>
            <span id="tvc_device_gps_fix"> </span>
          </div>
            <div class="list-display"><p>Calibrated on :-</p>
            <span id="tvc_device_calibrated_on"> </span>
          </div>
            <div class="list-display"><p>Login on :-</p>
            <span id="tvc_device_login_on"> </span>
          </div>
            <div class="list-display"><p>Created At :-</p>
            <span id="tvc_device_created_on"> </span>
          </div>
  </div>
    </div>
  <div class="button" role="button">
    Device Current Status
  </div>
  <div class="slide">
      <div class="list-outer-bg">
   <div class="list-display"><p>Mode:-</p>
            <span id="tvc_device_mode"> </span>
          </div>
          <div class="list-display"><p>Latitude:-</p>
            <span id="tvc_device_lat"> </span>
          </div>
          <div class="list-display"><p>Longitude:-</p>
            <span id="tvc_device_lon"> </span>
          </div>
          <div class="list-display"><p>Network Status:-</p>
            <span id="tvc_device_network_status"> </span>
          </div>
          <div class="list-display"><p>Fuel Status:-</p>
            <span id="tvc_device_fuel_status"> </span>
          </div>
          <div class="list-display"><p>Speed:-</p>
            <span id="tvc_device_speed"> </span>
          </div>
          <div class="list-display"><p>Odometer:-</p>
            <span id="tvc_device_odometer"> </span>
          </div>
          <div class="list-display"><p>Battery Status:-</p>
            <span id="tvc_device_battery_status"> </span>
          </div>
          <div class="list-display"><p>Main Power Status:-</p>
            <span id="tvc_device_main_power_status"> </span>
          </div>
          <div class="list-display"><p>Device Time:-</p>
            <span id="tvc_device_device_time"> </span>
          </div>
          <div class="list-display"><p>Ignition:-</p>
            <span id="tvc_device_ignition"> </span>
          </div>
          <div class="list-display"><p>GSM Signal Strength:-</p>
            <span id="tvc_device_gsm_signal_strength"> </span>
          </div><div class="list-display"><p>AC Status:-</p>
            <span id="tvc_device_ac_status"> </span>
          </div><div class="list-display"><p>Kilometer:-</p>
            <span id="tvc_device_kilometer"> </span>
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
<div class="acc-btn"><h1 class="selected">Installation</h1></div>
<div class="acc-content open">
  <div class="acc-content-inner">
    <div class="table-outer">
     <div id="installation_table_wrapper"></div>
   </div>
  </div>
</div>


</div></div>



  
        <div id="service" class="tab-pane fade">

<div class="acc-container">
<div class="acc-btn"><h1 class="selected">Service</h1></div>
<div class="acc-content">
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
<div class="acc-btn"><h1 class="selected">Alerts</h1></div>
<div class="acc-content ">
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
<div class="acc-btn"><h1 class="selected">Subscription</h1></div>
<div class="acc-content ">
  <div class="acc-content-inner">
     <div class="sub-div">
     <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
   </div>
  </div>
</div>


</div>

         
        
        </div>
      </div>
      <!-- /Tab details -->
    </div></div>
    <!-- /Monitoring details --> 
</div>
@endsection
<link rel="stylesheet" type="text/css" href="{{asset('css/monitor.css')}}">
<style type="text/css" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"></style>
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js">      </script>
   <script type="text/javascript" src="{{asset('js/gps/monitor-list.js')}}"></script>


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
</script>

<script type="text/javascript">
  
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
</script>


@endsection

