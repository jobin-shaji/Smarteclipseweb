@extends('layouts.eclipse')
@section('title')
    Detailed View Of GPS
@endsection
@section('content')    
<section class="hilite-content">
    <div class="page-wrapper_new">
        <!-- breadcrumbs -->
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Detailed View Of GPS</li>
        </ol>
        </nav> <br>
        <!-- /breadcrumbs -->

        <div class="container-fluid">
            <!-- section 1 -->
            <div class="box-part text-center section_1">
                <!-- IMEI and serial number -->
                <div class="title">
                    <h4 class = 'imei_serial_no_main_section'>
                        <!-- status icon -->
                        <span style="color:{{$gps_details->device_status}}">
                            <i class="fa fa-circle" aria-hidden="true"></i>
                        </span>
                        <!-- /status icon -->
                        IMEI : <?php ( isset($gps_details->imei) ) ? $imei = $gps_details->imei : $imei='-NA-' ?>{{$imei}} ( Serial No: <?php ( isset($gps_details->serial_no) ) ? $serial_no = $gps_details->serial_no : $serial_no='-NA-' ?>{{$serial_no}})
                    </h4>
                </div>
                <!-- /IMEI and serial number -->
                <!-- location and last updated -->
                <div class="row">
                    <!-- location -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 location_and_last_updated_section">
                        <span><b>Location :</b><?php ( isset($last_location) ) ? $last_location = $last_location : $last_location='-NA-' ?> {{$last_location}}</span>
                    </div>
                    <!-- /location -->
                    <!-- last updated -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <span><b>Last Packet Received On :</b> <?php ( isset($gps_details->device_time) ) ? $device_time = date('d/m/Y h:i:s A', strtotime($gps_details->device_time)): $device_time='-Not Yet Activated-' ?> {{$device_time}}<span>
                    </div>
                    <!-- /last updated -->
                </div> 
                <!-- /location and last updated -->
                <!-- basic device details -->
                <table class="table table-borderless basic_device_details" >
                    <thead>
                        <tr>
                            <td><b>Mode</b></td>
                            <td><b>Network Status</b></td>               
                            <td><b>Fuel Status</b></td>
                            <td><b>Speed</b></td>             
                            <td><b>Main Power Status</b></td>
                            <td><b>Ignition ON/OFF</b></td>               
                            <td><b>Gsm Signal Strength </b></td>
                            <td><b>GPS FIX</b></td>
                            <td><b>A/C Status</b></td>               
                        </tr>   
                        <tr>
                            <td><?php ( isset($gps_details->mode) ) ? $mode = $gps_details->mode : $mode='-NA-' ?>{{$mode}}</td>
                            <td><?php ( isset($gps_details->network_status) ) ? $network_status = $gps_details->network_status : $network_status='-NA-' ?>{{$network_status}}</td>               
                            <td><?php ( isset($gps_details->fuel_status) ) ? $fuel_status = $gps_details->fuel_status : $fuel_status='-NA-' ?>{{$fuel_status}}</td>
                            <td><?php ( isset($gps_details->speed) ) ? $speed = $gps_details->speed.' km/h' : $speed='-NA-' ?>{{$speed}}</td>             
                            <td><?php ( isset($gps_details->main_power_status) ) ? $main_power_status = $gps_details->main_power_status : $main_power_status='-NA-' ?>{{$main_power_status}}</td>
                            <td><?php ( isset($gps_details->ignition) ) ? $ignition = $gps_details->ignition : $ignition='-NA-' ?>{{$ignition}}</td>               
                            <td><?php ( isset($gps_details->gsm_signal_strength) ) ? $gsm_signal_strength = $gps_details->gsm_signal_strength : $gsm_signal_strength='-NA-' ?>{{$gsm_signal_strength}}</td>
                            <td><?php ( isset($gps_details->gps_fix_on) ) ? $gps_fix_on = $gps_details->gps_fix_on : $gps_fix_on='-NA-' ?>{{$gps_fix_on}}</td>           
                            <td><?php ( isset($gps_details->ac_status) ) ? $ac_status = $gps_details->ac_status : $ac_status='-NA-' ?>{{$ac_status}}</td>               
                        </tr>                
                    </thead>
                </table>
                <!-- /basic device details -->
                <!-- basic device details - alert based -->
                <table class="table table-borderless basic_alert_details" >
                    <thead>
                        <tr>
                            <td><b>Tilt State</b></td>
                            <td><b>OverSpeed State</b></td>               
                            <td><b>Emergency State</b></td>           
                        </tr> 
                        <tr>
                            <td><?php ( isset($gps_details->tilt_status) ) ? $tilt_status = $gps_details->tilt_status : $tilt_status='-NA-' ?>{{$tilt_status}}</td>
                            <td><?php ( isset($gps_details->overspeed_status) ) ? $overspeed_status = $gps_details->overspeed_status : $overspeed_status='-NA-' ?>{{$overspeed_status}}</td>               
                            <td><?php ( isset($gps_details->emergency_status) ) ? $emergency_status = $gps_details->emergency_status : $emergency_status='-NA-' ?>{{$emergency_status}}</td>           
                        </tr>                
                    </thead>
                </table>
                <!-- /basic device details - alert based -->               
            </div>
            <!-- /section 1 -->
            <!-- section 2 -->
            <div class="container">
                <!-- tabs -->
                <ul class="nav nav-pills" id="buttons">
                    <li class="active"><a data-toggle="pill" href="#device_details_section">Device Details</a></li>
                    <input type = 'hidden' name = 'gps_id' id = 'gps_id' value = "{{$gps_details->id}}" >
                    <li><a data-toggle="pill" href="#vehicle_details_section" onclick="getVehicleDetailsBasedOnGps()">Vehicle Details</a></li>
                    <li><a data-toggle="pill" href="#end_user_details_section" onclick="getOwnerDetailsBasedOnGps()">End User Details</a></li>
                    <li><a data-toggle="pill" href="#transfer_details_section" onclick="getTransferDetailsBasedOnGps()">Transfer Details</a></li>
                    <li><a data-toggle="pill" href="#installation_details_section" onclick="getInstallationDetailsBasedOnGps()">Installation Details</a></li>
                    <li><a data-toggle="pill" href="#service_details_section" onclick="getServiceDetailsBasedOnGps()">Service Details</a></li>
                    <li><a data-toggle="pill" href="#alert_details_section" onclick="getAlertDetailsBasedOnGps()"> Alerts</a></li>
                </ul>
                <!-- /tabs --> 
                <!-- tab contents -->
                <div class="tab-content">
                    <!-- device details -->
                    <div id="device_details_section" class="tab-pane fade in active">
                        <table class="table table-borderless tables_in_tab_section">
                            <thead>
                                <tr class="success" >
                                    <td><b>IMEI</b></td>
                                    <td><?php ( isset($gps_details->imei) ) ? $imei = $gps_details->imei : $imei='-NA-' ?>{{$imei}}</td>
                                </tr>                
                                <tr>
                                    <td><b>Serial Number</b></td>
                                    <td><?php ( isset($gps_details->serial_no) ) ? $serial_no = $gps_details->serial_no : $serial_no='-NA-' ?>{{$serial_no}}</td>
                                </tr>                
                                <tr class="success" >
                                    <td><b>Manufactured On</b></td>
                                    <td><?php ( isset($gps_details->manufacturing_date) ) ? $manufacturing_date = $gps_details->manufacturing_date : $manufacturing_date='-NA-' ?>{{$manufacturing_date}}</td>
                                </tr>                
                                <tr>
                                    <td><b>ICC ID</b></td>
                                    <td><?php ( isset($gps_details->icc_id) ) ? $icc_id = $gps_details->icc_id : $icc_id='-NA-' ?>{{$icc_id}}</td>
                                </tr>      
                                <tr class="success" >
                                    <td><b>IMSI</b></td>
                                    <td><?php ( isset($gps_details->imsi) ) ? $imsi = $gps_details->imsi : $imsi='-NA-' ?>{{$imsi}}</td>
                                </tr>     
                                <tr>
                                    <td><b>E-Sim Number</b></td>
                                    <td><?php ( isset($gps_details->e_sim_number) ) ? $e_sim_number = $gps_details->e_sim_number : $e_sim_number='-NA-' ?>{{$e_sim_number}}</td>
                                </tr>                
                                <tr class="success" >
                                    <td><b> Batch Number</b></td>
                                    <td><?php ( isset($gps_details->batch_number) ) ? $batch_number = $gps_details->batch_number : $batch_number='-NA-' ?>{{$batch_number}}</td>
                                </tr>                
                                <tr>
                                    <td><b>Model Name</b></td>
                                    <td><?php ( isset($gps_details->model_name) ) ? $model_name = $gps_details->model_name : $model_name='-NA-' ?>{{$model_name}}</td>
                                </tr>      
                                <tr class="success" >
                                    <td><b>Version</b></td>
                                    <td><?php ( isset($gps_details->version) ) ? $version = $gps_details->version : $version='-NA-' ?>{{$version}}</td>
                                </tr> 
                                <tr>
                                    <td><b>Employee Code</b></td>
                                    <td><?php ( isset($gps_details->employee_code) ) ? $employee_code = $gps_details->employee_code : $employee_code='-NA-' ?>{{$employee_code}}</td>
                                </tr> 
                                <tr class="success" >
                                    <td><b>Is Returned</b></td>
                                    <td><?php ( isset($gps_details->is_returned) ) ? $is_returned = $gps_details->is_returned : $is_returned='-NA-' ?>{{$is_returned}}</td>
                                </tr>  
                                <tr>
                                    <td><b>Refurbished Device</b></td>
                                    <td><?php ( isset($gps_details->refurbished_status) ) ? $refurbished_status = $gps_details->refurbished_status : $refurbished_status='-NA-' ?>{{$refurbished_status}}</td>
                                </tr>                       
                            </thead>
                        </table>   
                    </div>
                    <!-- /device details -->

                    <!-- vehicle details -->
                    <div id="vehicle_details_section" class="tab-pane fade">
                        <table class="table table-borderless tables_in_tab_section">
                            <thead>
                                <tr class="success" >
                                    <td><b>Vehicle Name</b></td>
                                    <td id = 'vehicle_name'></td>
                                </tr>                
                                <tr>
                                    <td><b>Vehicle Registration Number</b></td>
                                    <td id = 'vehicle_registration_number'></td>
                                </tr>                
                                <tr class="success" >
                                    <td><b>Vehicle Category</b></td>
                                    <td id = 'vehicle_category'></td>
                                </tr>                
                                <tr>
                                    <td><b>Engine Number</b></td>
                                    <td id = 'engine_number'></td>
                                </tr>      
                                <tr class="success" >
                                    <td><b>Chassis Number</b></td>
                                    <td id = 'chassis_number'></td>
                                </tr>     
                                <tr>
                                    <td><b>Driver Name</b></td>
                                    <td id = 'driver_name'></td>
                                </tr> 
                                <tr class="success" >
                                    <td><b>Address</b></td>
                                    <td id = 'driver_address'></td>
                                </tr>                
                                <tr>
                                    <td><b>Mobile Number</b></td>
                                    <td id = 'driver_mobile'></td>
                                </tr>                                
                            </thead>
                        </table>                
                    </div>
                    <!-- /vehicle details -->

                    <!-- end user details -->
                    <div id="end_user_details_section" class="tab-pane fade">
                        <table class="table table-borderless tables_in_tab_section">
                            <thead>
                                <tr class="success" >
                                    <td><b>End User Name</b></td>
                                    <td id = 'owner_name'></td>
                                </tr>                
                                <tr>
                                    <td><b>Address</b></td>
                                    <td id = 'owner_address'></td>
                                </tr>                
                                <tr class="success" >
                                    <td><b>Mobile Number</b></td>
                                    <td id = 'owner_mobile'></td>
                                </tr>                
                                <tr>
                                    <td><b>Email</b></td>
                                    <td id = 'owner_email'></td>
                                </tr>      
                                <tr class="success" >
                                    <td><b>Country</b></td>
                                    <td id = 'owner_country'></td>
                                </tr>     
                                <tr>
                                    <td><b>State</b></td>
                                    <td id = 'owner_state'></td>
                                </tr> 
                                <tr class="success" >
                                    <td><b>City</b></td>
                                    <td id = 'owner_city'></td>
                                </tr>                
                                <tr>
                                    <td><b>Package</b></td>
                                    <td id = 'owner_package'></td>
                                </tr>                                
                            </thead>
                        </table>                
                    </div>
                    <!-- /end user details -->

                    <!-- installation details -->
                    <div id="installation_details_section" class="tab-pane fade">
                        <table class="table table-borderless tables_in_tab_section">
                            <thead>
                                <tr class="success" >
                                    <td><b>Service Engineer Name</b></td>
                                    <td id = 'servicer_name'></td>
                                </tr>                
                                <tr>
                                    <td><b>Address</b></td>
                                    <td id = 'servicer_address'></td>
                                </tr>                
                                <tr class="success" >
                                    <td><b>Mobile Number</b></td>
                                    <td id = 'servicer_mobile'></td>
                                </tr>                
                                <tr>
                                    <td><b>Email</b></td>
                                    <td id = 'servicer_email'></td>
                                </tr>      
                                <tr class="success" >
                                    <td><b>Job Date</b></td>
                                    <td id = 'job_date'></td>
                                </tr>   
                                <tr >
                                    <td><b>Job Status</b></td>
                                    <td id = 'job_status'></td>
                                </tr>     
                                <tr class="success">
                                    <td><b>Job Completion Date</b></td>
                                    <td id = 'job_complete_date'></td>
                                </tr> 
                                <tr>
                                    <td><b>Location</b></td>
                                    <td id = 'location'></td>
                                </tr>                
                                <tr class="success">
                                    <td><b>Description</b></td>
                                    <td id = 'description'></td>
                                </tr>   
                                <tr>
                                    <td><b>Comments</b></td>
                                    <td id = 'comments'></td>
                                </tr>                              
                            </thead>
                        </table>                
                    </div>
                    <!-- /installation details -->

                    <!-- service details -->
                    <div id="service_details_section" class="tab-pane fade">
                        <table class="table table-borderless tables_in_tab_section" id = 'service_details'>
                            <thead>
                                <tr class="success" >
                                    <td><b>Service Engineer Name</b></td>
                                    <td><b>Address</b></td>
                                    <td><b>MObile Number</b></td>
                                    <td><b>Email</b></td>
                                    <td><b>Job Date</b></td>
                                    <td><b>Job Status</b></td>
                                    <td><b>JOb Completion Date</b></td>
                                    <td><b>Location</b></td>
                                    <td><b>Description</b></td>
                                    <td><b>Comments</b></td>
                                </tr>                                          
                            </thead>
                            <tbody> 
                                                                                             
                            </tbody>
                        </table>                
                    </div>
                    <!-- /service details -->

                    <!-- /transfer details -->
                    <div id="transfer_details_section" class="tab-pane fade">
                        <div class="row">
                            <!-- location -->
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 location_and_last_updated_section">          
                                </br>
                                <label>Transfer Details</label>
                                </br>
                                <table class="table table-borderless tables_in_tab_section" >
                                    <thead>
                                        <tr class="success" >
                                            <td><b>Manufacturer</b></td>
                                            <td id = 'manufacturer'></td>
                                        </tr>                
                                        <tr>
                                            <td><b>Distributor</b></td>
                                            <td id = 'dealer'></td>
                                        </tr>                
                                        <tr class="success" >
                                            <td><b>Dealer</b></td>
                                            <td id = 'subdealer'></td>
                                        </tr>                
                                        <tr>
                                            <td><b>Sub Dealer</b></td>
                                            <td id = 'trader'></td>
                                        </tr>  
                                        <tr class="success" >
                                            <td><b>End User</b></td>
                                            <td id = 'client'></td>
                                        </tr>                    
                                    </thead>
                                </table>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 location_and_last_updated_section">                       
                                </br>
                                <label>Transfer History</label>
                                </br>
                                <table  id ="transfer_history" class="table table-borderless tables_in_tab_section" >
                                    <thead>
                                        <tr class="success" >                                    
                                            <td>From User</td>
                                            <td>To User</td>                                        
                                            <td>Dispatched On</td>
                                            <td>Accepted On</td>                                                                                                                               
                                        </tr>                    
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>              
                    </div>
                    <!-- /transfer details -->

                    <!-- alert details -->
                    <div id="alert_details_section" class="tab-pane fade">
                        <table class="table table-borderless tables_in_tab_section" >
                            <thead>
                                <tr class="success" >
                                    <td><b>Vehicle Name</b></td>
                                    <td></td>
                                </tr>                               
                            </thead>
                        </table>                
                    </div>
                    <!-- /alert details -->
                </div>
                <!-- /tab contents -->
            </div>    
            <!-- /section 2 -->  
        </div>
    </div>
</section>


<style>
    .section_1
    {
        padding: 35px;
    } 
    .imei_serial_no_main_section
    {
        font-size: 17px;
    }
    .location_and_last_updated_section
    {
        word-break: break-all;
    }
    .basic_device_details
    {
        border: 50px solid transparent;
    } 
    .basic_alert_details
    {
        width: 365px; 
        border: 0px solid transparent;
    }  
    .tables_in_tab_section
    {
        border: 0px solid transparent; 
    }

   /* #buttons li {
    float: left;
    list-style: none;
    text-align: center;
    background-color: #65A6D8;
    margin-right: 30px;
    width: 150px;
    line-height: 60px;
    }
    #buttons li a {
    text-decoration: none;
    color: #FFFFFF;
    display: block;
    }

    #buttons li a:hover {
    text-decoration: none;
    color: #000000;
    background-color: #33B5E5;
    }  */
</style>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
  <link rel="stylesheet" href="{{asset('dist/css/device-status.css')}}">
    
@section('script')
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="{{asset('js/gps/device-detailed-view-in-report.js')}}"></script>
@endsection

@endsection