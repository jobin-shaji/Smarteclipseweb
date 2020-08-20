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
            <!-- SECTION 1 -->
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="row">
                        <!-- DEVICE STATUS SECTION -->
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 content-section">
                            <i class="fa fa-tablet device-icon" aria-hidden="true"></i>
                        </div>
                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12 content-section">
                            <?php ( isset($gps_details->imei) ) ? $imei = $gps_details->imei : $imei='-NA-' ?>{{$imei}} ( Serial No: <?php ( isset($gps_details->serial_no) ) ? $serial_no = $gps_details->serial_no : $serial_no='-NA-' ?>{{$serial_no}})
                        </div>
                        <!-- /DEVICE STATUS SECTION -->

                        <!-- LOCATION SECTION -->
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 content-section">
                            <i class="fa fa-map-marker device-icon" aria-hidden="true"></i>
                        </div>
                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12 content-section">
                            <?php ( isset($last_location) ) ? $last_location = $last_location : $last_location='-NA-' ?> {{$last_location}}
                        </div>
                        <!-- /LOCATION SECTION -->

                        <!-- DATETIME SECTION -->
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 content-section">
                            <i class="fa fa-clock-o device-icon" aria-hidden="true"></i>
                        </div>
                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12 content-section">
                            <?php ( isset($gps_details->device_time) ) ? $device_time = date('d/m/Y h:i:s A', strtotime($gps_details->device_time)): $device_time='-Not Yet Activated-' ?> {{$device_time}}
                        </div>
                        <!-- /DATETIME SECTION -->
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <!-- basic device details - alert based -->
                    <table class="table table-bordered basic_alert_details basiclaart-width" >
                        <thead>
                            <tr>
                                <!-- status icon -->
                                <td>
                                    <span style="color:{{$gps_details->device_status}}">
                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                    </span>
                                </td>
                                <!-- /status icon -->
                                <td><b>Mode</b></td>
                                <td><b><?php ( isset($gps_details->mode) ) ? $mode = $gps_details->mode : $mode='-NA-' ?>{{$mode}}</b></td>                         
                            </tr>  
                            <tr>
                                <!-- status icon -->
                                <td>
                                    <span style="color:{{$gps_details->signal_status}}">
                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                    </span>
                                </td>
                                <!-- /status icon -->
                                <td><b>GSM Signal Strength</b></td>
                                <td><b><?php ( isset($gps_details->gsm_signal_strength) ) ? $gsm_signal_strength = $gps_details->gsm_signal_strength : $gsm_signal_strength='-NA-' ?>{{$gsm_signal_strength}}</b></td>                          
                            </tr>   
                            <tr>
                                <!-- status icon -->
                                <td>
                                    <span style="color:{{$gps_details->fuel_level_status}}">
                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                    </span>
                                </td>
                                <!-- /status icon -->
                                <td><b>Fuel Status</b></td>
                                <td><b><?php ( isset($gps_details->fuel_status) ) ? $fuel_status = $gps_details->fuel_status : $fuel_status='-NA-' ?>{{$fuel_status}}</b></td>                          
                            </tr>  
                            <tr>
                                <!-- status icon -->
                                <td>
                                    <span style="color:{{$gps_details->speed_level_status}}">
                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                    </span>
                                </td>
                                <!-- /status icon -->
                                <td><b>Speed</b></td>
                                <td><b><?php ( isset($gps_details->speed) ) ? $speed = $gps_details->speed.' km/h' : $speed='-NA-' ?>{{$speed}}</b></td>                          
                            </tr> 
                            <tr>
                                <!-- status icon -->
                                <td>
                                    <span style="color:{{$gps_details->power_status}}">
                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                    </span>
                                </td>
                                <!-- /status icon -->
                                <td><b>Main Power Status</b></td>
                                <td><b><?php ( isset($gps_details->main_power_status) ) ? $main_power_status = $gps_details->main_power_status : $main_power_status='-NA-' ?>{{$main_power_status}}</b></td>                          
                            </tr>   
                            <tr>
                                <!-- status icon -->
                                <td>
                                    <span style="color:{{$gps_details->ignition_status}}">
                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                    </span>
                                </td>
                                <!-- /status icon -->
                                <td><b>Ignition ON/OFF</b></td>
                                <td><b><?php ( isset($gps_details->ignition) ) ? $ignition = $gps_details->ignition : $ignition='-NA-' ?>{{$ignition}}</b></td>                          
                            </tr> 
                            <tr>
                                <!-- status icon -->
                                <td>
                                    <span style="color:{{$gps_details->gps_fix_status}}">
                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                    </span>
                                </td>
                                <!-- /status icon -->
                                <td><b>GPS FIX</b></td>
                                <td><b><?php ( isset($gps_details->gps_fix_on) ) ? $gps_fix_on = $gps_details->gps_fix_on : $gps_fix_on='-NA-' ?>{{$gps_fix_on}}</b></td>                          
                            </tr>  
                            <tr>
                                <!-- status icon -->
                                <td>
                                    <span style="color:{{$gps_details->ac_level_status}}">
                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                    </span>
                                </td>
                                <!-- /status icon -->
                                <td><b>A/C Status</b></td>
                                <td><b><?php ( isset($gps_details->ac_status) ) ? $ac_status = $gps_details->ac_status : $ac_status='-NA-' ?>{{$ac_status}}</b></td>                          
                            </tr>  
                            <tr>
                                <!-- status icon -->
                                <td>
                                    <span style="color:{{$gps_details->tilt_level_status}}">
                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                    </span>
                                </td>
                                <!-- /status icon -->
                                <td><b>Tilt State</b></td>
                                <td><b><?php ( isset($gps_details->tilt_status) ) ? $tilt_status = $gps_details->tilt_status : $tilt_status='-NA-' ?>{{$tilt_status}}</b></td>                          
                            </tr> 
                            <tr>
                                <!-- status icon -->
                                <td>
                                    <span style="color:{{$gps_details->overspeed_level_status}}">
                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                    </span>
                                </td>
                                <!-- /status icon -->
                                <td><b>Overspeed State</b></td>
                                <td><b><?php ( isset($gps_details->overspeed_status) ) ? $overspeed_status = $gps_details->overspeed_status : $overspeed_status='-NA-' ?>{{$overspeed_status}}</b></td>                          
                            </tr> 
                            <tr>
                                <!-- status icon -->
                                <td>
                                    <span style="color:{{$gps_details->emergency_level_status}}">
                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                    </span>
                                </td>
                                <!-- /status icon -->
                                <td><b>Emergency State</b></td>
                                <td><b><?php ( isset($gps_details->emergency_status) ) ? $emergency_status = $gps_details->emergency_status : $emergency_status='-NA-' ?>{{$emergency_status}}</b></td>                          
                            </tr>             
                        </thead>
                    </table>
                    <!-- /basic device details - alert based -->   
                </div>
            </div>
            <!-- /SECTION 1 -->

            <!-- SECTION 2 -->
            <div class="tabbed Panels tab-section">  <!-- begins the tabbed panels / wrapper-->                
                <ul class="tabs">
                    <li><a href="#device_details_section">Device Details</a></li>
                    <input type = 'hidden' name = 'gps_id' id = 'gps_id' value = "{{$gps_details->id}}" >
                    <li><a href="#vehicle_details_section" onclick="getVehicleDetailsBasedOnGps()">Vehicle Details</a></li>
                    <li><a href="#end_user_details_section" onclick="getOwnerDetailsBasedOnGps()">End User Details</a></li>                    
                    <li><a href="#transfer_details_section" onclick="getTransferDetailsBasedOnGps()">Transfer Details</a></li>
                    <li><a href="#installation_details_section" onclick="getInstallationDetailsBasedOnGps()">Installation Details</a></li>
                    <li><a href="#service_details_section" onclick="getServiceDetailsBasedOnGps()">Service Details</a></li>
                    <li><a href="#alert_details_section" onclick="getAlertDetailsBasedOnGps()"> Alerts</a></li>                
                    <li><a href="#set_ota_section" onclick="setOtaInGps()"> Set OTA</a></li>
                </ul>
                <div class="panelContainer">
                    <div id="device_details_section" class="panel">
                        <table class="table table-borderless tables_in_tab_section">
                            <tbody>
                                <tr class="success" >
                                    <td class="label-style"><b>IMEI</b></td>
                                    <td><?php ( isset($gps_details->imei) ) ? $imei = $gps_details->imei : $imei='-NA-' ?>{{$imei}}</td>
                                </tr>                
                                <tr>
                                    <td class="label-style"><b>Serial Number</b></td>
                                    <td><?php ( isset($gps_details->serial_no) ) ? $serial_no = $gps_details->serial_no : $serial_no='-NA-' ?>{{$serial_no}}</td>
                                </tr>                
                                <tr class="success" >
                                    <td class="label-style"><b>Manufactured On</b></td>
                                    <td><?php ( isset($gps_details->manufacturing_date) ) ? $manufacturing_date = $gps_details->manufacturing_date : $manufacturing_date='-NA-' ?>{{$manufacturing_date}}</td>
                                </tr>                
                                <tr>
                                    <td class="label-style"><b>ICC ID</b></td>
                                    <td><?php ( isset($gps_details->icc_id) ) ? $icc_id = $gps_details->icc_id : $icc_id='-NA-' ?>{{$icc_id}}</td>
                                </tr>      
                                <tr class="success" >
                                    <td class="label-style"><b>IMSI</b></td>
                                    <td><?php ( isset($gps_details->imsi) ) ? $imsi = $gps_details->imsi : $imsi='-NA-' ?>{{$imsi}}</td>
                                </tr>     
                                <tr>
                                    <td class="label-style"><b>E-Sim Number</b></td>
                                    <td><?php ( isset($gps_details->e_sim_number) ) ? $e_sim_number = $gps_details->e_sim_number : $e_sim_number='-NA-' ?>{{$e_sim_number}}</td>
                                </tr>                
                                <tr class="success" >
                                    <td class="label-style"><b> Batch Number</b></td>
                                    <td><?php ( isset($gps_details->batch_number) ) ? $batch_number = $gps_details->batch_number : $batch_number='-NA-' ?>{{$batch_number}}</td>
                                </tr>                
                                <tr>
                                    <td class="label-style"><b>Model Name</b></td>
                                    <td><?php ( isset($gps_details->model_name) ) ? $model_name = $gps_details->model_name : $model_name='-NA-' ?>{{$model_name}}</td>
                                </tr>      
                                <tr class="success" >
                                    <td class="label-style"><b>Version</b></td>
                                    <td><?php ( isset($gps_details->version) ) ? $version = $gps_details->version : $version='-NA-' ?>{{$version}}</td>
                                </tr> 
                                <tr>
                                    <td class="label-style"><b>Calibrated On</b></td>
                                    <td><?php ( isset($gps_details->calibrated_on) ) ? $calibrated_on = $gps_details->calibrated_on : $calibrated_on='-NA-' ?>{{$calibrated_on}}</td>
                                </tr>      
                                <tr class="success" >
                                    <td class="label-style"><b>Login On</b></td>
                                    <td><?php ( isset($gps_details->login_on) ) ? $login_on = $gps_details->login_on : $login_on='-NA-' ?>{{$login_on}}</td>
                                </tr> 
                                <tr>
                                    <td class="label-style"><b>Employee Code</b></td>
                                    <td><?php ( isset($gps_details->employee_code) ) ? $employee_code = $gps_details->employee_code : $employee_code='-NA-' ?>{{$employee_code}}</td>
                                </tr> 
                                <tr class="success" >
                                    <td class="label-style"><b>Is Returned</b></td>
                                    <td><?php ( isset($gps_details->is_returned) ) ? $is_returned = $gps_details->is_returned : $is_returned='-NA-' ?>{{$is_returned}}</td>
                                </tr>  
                                <tr>
                                    <td class="label-style"><b>Refurbished Device</b></td>
                                    <td><?php ( isset($gps_details->refurbished_status) ) ? $refurbished_status = $gps_details->refurbished_status : $refurbished_status='-NA-' ?>{{$refurbished_status}}</td>
                                </tr>    
                                <tr class="success" >
                                    <td class="label-style"><b>GPS Created On</b></td>
                                    <td><?php ( isset($gps_details->created_at) ) ? $created_at = $gps_details->created_at : $created_at='-NA-' ?>{{$created_at}}</td>         
                                </tr>                     
                            </tbody>
                        </table>                           
                    </div>             
                    <!-- </div>   -->  
                     <!-- vehicle details -->                                          
                    <div id="vehicle_details_section" class="panel">
                        <table class="table table-borderless tables_in_tab_section">
                            <tbody>
                                <tr class="success" >
                                    <td class="label-style"><b>Vehicle Name</b></td>
                                    <td id = 'vehicle_name'></td>
                                </tr>                
                                <tr>
                                    <td class="label-style"><b>Vehicle Registration Number</b></td>
                                    <td id = 'vehicle_registration_number'></td>
                                </tr>                
                                <tr class="success" >
                                    <td class="label-style"><b>Vehicle Category</b></td>
                                    <td id = 'vehicle_category'></td>
                                </tr>                
                                <tr>
                                    <td class="label-style"><b>Engine Number</b></td>
                                    <td id = 'engine_number'></td>
                                </tr>      
                                <tr class="success" >
                                    <td class="label-style"><b>Chassis Number</b></td>
                                    <td id = 'chassis_number'></td>
                                </tr>     
                                <tr>
                                    <td class="label-style"><b>Vehicle Model</b></td>
                                    <td id = 'vehicle_model'></td>
                                </tr>                
                                <tr class="success" >
                                    <td class="label-style"><b>Vehicle Manufacturers</b></td>
                                    <td id = 'vehicle_make'></td>
                                </tr>                
                                <tr>
                                    <td class="label-style"><b>Anti Theft Mode</b></td>
                                    <td id = 'vehicle_theft_mode'></td>
                                </tr>      
                                <tr class="success" >
                                    <td class="label-style"><b>Towing Mode</b></td>
                                    <td id = 'vehicle_towing_mode'></td>
                                </tr>  
                                <tr>
                                    <td class="label-style"><b>Created On</b></td>
                                    <td id = 'vehicle_created_on'></td>
                                </tr>  
                                <tr class="success">
                                    <td class="label-style"><b>Driver Name</b></td>
                                    <td id = 'driver_name'></td>
                                </tr> 
                                <tr>
                                    <td class="label-style"><b>Address</b></td>
                                    <td id = 'driver_address'></td>
                                </tr>                
                                <tr class="success" >
                                    <td class="label-style"><b>Mobile Number</b></td>
                                    <td id = 'driver_mobile'></td>
                                </tr>    
                                <tr>
                                    <td class="label-style"><b>Driver Score</b></td>
                                    <td id = 'driver_score'></td>
                                </tr>                               
                            </tbody>
                        </table>                                  
                    </div> 
                    <!-- vehicle details -->
                       <!-- end user details -->
                    <div id="end_user_details_section" class="panel">
                        <table class="table table-borderless tables_in_tab_section">
                            <tbody>
                                <tr class="success" >
                                    <td class="label-style"><b>End User Name</b></td>
                                    <td id = 'owner_name'></td>
                                </tr>                
                                <tr>
                                    <td class="label-style"><b>Address</b></td>
                                    <td id = 'owner_address'></td>
                                </tr>                
                                <tr class="success" >
                                    <td class="label-style"><b>Mobile Number</b></td>
                                    <td id = 'owner_mobile'></td>
                                </tr>                
                                <tr>
                                    <td class="label-style"><b>Email</b></td>
                                    <td id = 'owner_email'></td>
                                </tr>      
                                <tr class="success" >
                                    <td class="label-style"><b>Country</b></td>
                                    <td id = 'owner_country'></td>
                                </tr>     
                                <tr>
                                    <td class="label-style"><b>State</b></td>
                                    <td id = 'owner_state'></td>
                                </tr> 
                                <tr class="success" >
                                    <td class="label-style"><b>City</b></td>
                                    <td id = 'owner_city'></td>
                                </tr>                
                                <tr>
                                    <td class="label-style"><b>Package</b></td>
                                    <td id = 'owner_package'></td>
                                </tr>                                
                            </tbody>
                        </table>                 
                    </div>
                    <!-- /end user details -->
                   <!-- /transfer details -->
                    <div id="transfer_details_section" class="panel">
                        <div class="row">
                            <!-- location -->
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 location_and_last_updated_section">          
                                </br>
                                <label>Transfer Overview</label>
                                </br>
                                <table class="table table-borderless tables_in_tab_section" >
                                    <tbody>
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
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 location_and_last_updated_section">                       
                                </br>
                                <label>Transfer History</label>
                                </br>
                                <table id ="transfer_history" class="table table-borderless tables_in_tab_section word_break" >
                                    <thead>
                                        <tr class="success" >                                    
                                            <th><b>From User</b></th>
                                            <th><b>To User</b></th>                                        
                                            <th><b>Dispatched On</b></th>
                                            <th><b>Accepted On</b></th>                                                                                                                               
                                        </tr>                    
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>              
                    </div>
                    <!-- /transfer details -->
                     <!-- installation details -->
                     <div id="installation_details_section" class="panel">
                        <table class="table table-borderless tables_in_tab_section">
                            <tbody>
                                <tr class="success" >
                                    <td class="label-style"><b>Service Engineer Name</b></td>
                                    <td id = 'servicer_name'></td>
                                </tr>                
                                <tr>
                                    <td class="label-style"><b>Address</b></td>
                                    <td id = 'servicer_address'></td>
                                </tr>                
                                <tr class="success" >
                                    <td class="label-style"><b>Mobile Number</b></td>
                                    <td id = 'servicer_mobile'></td>
                                </tr>                
                                <tr>
                                    <td class="label-style"><b>Email</b></td>
                                    <td id = 'servicer_email'></td>
                                </tr>      
                                <tr class="success" >
                                    <td class="label-style"><b>Job Date</b></td>
                                    <td id = 'job_date'></td>
                                </tr>   
                                <tr >
                                    <td class="label-style"><b>Job Status</b></td>
                                    <td id = 'job_status'></td>
                                </tr>     
                                <tr class="success">
                                    <td class="label-style"><b>Job Completion Date</b></td>
                                    <td id = 'job_complete_date'></td>
                                </tr> 
                                <tr>
                                    <td class="label-style"><b>Location</b></td>
                                    <td id = 'location'></td>
                                </tr>                
                                <tr class="success">
                                    <td class="label-style"><b>Description</b></td>
                                    <td id = 'description'></td>
                                </tr>   
                                <tr>
                                    <td class="label-style"><b>Comments</b></td>
                                    <td id = 'comments'></td>
                                </tr>                              
                            </tbody>
                        </table>              
                    </div>
                    <!-- /installation details -->
                    <!-- service details -->
                    <div id="service_details_section" class="panel">
                    <table class="table table-borderless tables_in_tab_section word_break" id = 'service_details'>
                            <thead>
                                <tr class="success" >
                                    <th><b>Service Engineer Name</b></th>
                                    <th><b>Address</b></th>
                                    <th><b>Mobile Number</b></th>
                                    <th><b>Email</b></th>
                                    <th><b>Job Date</b></th>
                                    <th><b>Job Status</b></th>
                                    <th><b>Job Completion Date</b></th>
                                    <th><b>Location</b></th>
                                    <th><b>Description</b></th>
                                    <th><b>Comments</b></th>
                                </tr>                                          
                            </thead>
                            <tbody> 
                                                                                             
                            </tbody>
                        </table>                 
                    </div>
                    <!-- /service details -->
                    <!-- alert details -->
                    <div id="alert_details_section" class="panel">
                        <table class="table table-borderless tables_in_tab_section" id = 'alert_details'>
                            <thead>
                                <tr class="success" >
                                    <th><b>SL.No</b></th>
                                    <th><b>Alert Type</b></th>                             
                                    <th><b>Date & Time</b></th>  
                                    <th><b>Location</b></th>        
                                </tr>                                          
                            </thead>
                            <tbody> 
                                                                                      
                            </tbody>
                        </table>  
                        <!-- loader -->
                        <div class="loader-wrapper loader-1"  style="display:none">
                          <div id="loader"></div>
                        </div> 
                        <!-- /loader -->

                        <!-- pagination -->
                        <div class="row float-right">
                          <div class="col-md-12 " id="alert-list-pagination">
                          </div>
                        </div>  
                        <!-- /pagination -->                
                    </div>
                    <!-- /alert details -->
                    <!-- Set OTA section -->
                    <div id="set_ota_section" class="panel">
                        <form method="POST" id="form1" action="{{route('device-detailed-report-view-set-ota')}}">
                        {{csrf_field()}}
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" name="gps_id" id="gps_id" value="{{$gps_details->id}}">
                                        <input type="hidden" name="imei" id="imei" value="{{$gps_details->imei}}">
                                        <div class="form-group row" style="float:none!important">
                                            <label class="col-sm-3 text-right control-label col-form-label">Command:</label>
                                            <div class="form-group has-feedback">
                                                <textarea class="form-control" name="command" id="command" rows=5 required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">POST</button>
                        </form>              
                    </div>
                    <!-- /Set OTA section -->
                    <!-- console modal button-->
                    <button class="btn-sm console_view pull-right" onclick="return openConsole({{$gps_details->imei}})" data-toggle="modal" data-target="#consoleModal">CONSOLE <i class='fa fa-arrow-up'></i></button>
                    <!-- /console modal button-->      
                </div>               
            </div> <!-- ends the tabbed panels / wrapper-->                        
        </div>
    </div>
</section>
<!-- console modal -->
<div class="modal bottom fade" id="consoleModal" >
    <div class="modal-dialog modal-1-test" >
        <div class="modal-content">
            <!-- console model header -->
            <div class="modal-header">
                <button type="button" class="close" onclick="closeConsole()" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <!-- /console model header -->

            <!-- console model body -->
            <div class="modal-body">
                <div id="loading-indicator" class="hide-loading-indicator">Loading latest records...</div>
                <div class="each_packets"></div>
            </div>
            <!-- /console model body -->
        </div>
    </div>
</div>
<!-- /console modal -->
<style>
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
        font-size: 14px;
    }
    .tabbedPanels {
        width: 100%; 
        margin-top: 25px;
        float:left;
    }

    .word_break tr td
    {
        word-break: break-all;
    }

    .console_view {
        background-color: #0b0a0a;
        color: #fdfcfc;
        padding: 7px;
        position: fixed;
        bottom: 29px;
        right: 50px;
    }

    .operation-header
    {
        margin-left: -114px !important;
    }

    .panelContainer {
        clear: left;
        margin-bottom: 25px;
        border: 0px solid green;
        background-color: #f3f3f3;
        padding: 13px;
        /* add height if you want equal panels */
    }

    /* reset ul defaults  */
    .tabs {
        margin: 0;
        padding: 0;	
        list-style: none;	
    }

    /* set li properties  */
    .tabs li {
        float: left;
    /* width: 150px; */
        padding: 0;
        margin: 0;
        text-align: center;
    }

    /* all formatting goes inside 'a' */
    .tabs a {
        display: block;
        text-decoration: none;
        color: #fff;
        font-weight:normal;
        padding:  8px;
        margin-right: 4px; /*// spaces out the tabs  */
        border-top-right-radius: 5px;
        border-top-left-radius: 5px;
        color:#337ab7;
        margin-bottom: -2px;  /* negative margin will move it down
                                to blend in with outer border  */
    }

    .tabs a.active {
        color: #fff;
        background-color: #337ab7;
        border-radius: 4px;
        font-weight: bold;
    }
            
    .panel img {
                
            margin-top: 10px;
    }

    .panel p  {
                
            margin-bottom: 0px;
    }
    .border-bottom-w{
        border-bottom: 1px solid #dedcdc;
    }
    .basiclaart-width{
        margin:0px auto;
        width: 500px;
    }
   /*******************************
    * MODAL AS BOTTOM SIDEBAR
    *******************************/
	.modal.bottom .modal-dialog {
		position: fixed;
		margin: auto;
	}
	.modal.bottom .modal-content {
        /* background-color: #040404;
        color: #fffbfb; */
        border-radius: 0px;
        width:100% !important;
        max-width:100% !important;
        height:250px !important;
        overflow-x: hidden;
        overflow-y: scroll;
    }
    .modal.bottom .modal-content #loading-indicator{
        text-align: center;
        font-size: 10px;
    }
    .show-loading-indicator{
        visibility:visible;
    }
    .hide-loading-indicator{
        visibility: hidden;
    }
    .modal.bottom .modal-content .row{
        border-bottom:1px solid #f5f5f5;
        padding-top:5px;
        padding-bottom:5px;
        line-height:25px;
    }
    .modal.bottom .modal-content .time{
        padding-left:15px;
    }

    .modal-header
    {
        background-color: #fffbfb;
        padding:6px !important;
    }
    .modal-1-test
    {
        width: 100% !important;
        float: left;
        max-width: 100% !important;
        max-height: 250px !important;
    }
    /*Bottom*/
	.modal.bottom.fade .modal-dialog {
		bottom: -320px;
		-webkit-transition: opacity 0.3s linear, bottom 0.3s ease-out;
		   -moz-transition: opacity 0.3s linear, bottom 0.3s ease-out;
		     -o-transition: opacity 0.3s linear, bottom 0.3s ease-out;
		        transition: opacity 0.3s linear, bottom 0.3s ease-out;
	}
	
	.modal.bottom.fade.in .modal-dialog {
		bottom: 0;
	}
    .body-padding-0 {
        padding-right: 0px !important;
    }
    /* modal section ends here */
    tbody tr:nth-child(odd)
    {
        background: #E4E9EA;
    }
    .success{
        background: #C7CBCC;
    }

    .container-fluid
    {
        margin-left: 3% !important;
        width: 95% !important;
    }
    .content-section
    {
        margin-top: 15px;
        font-weight: bold;
    }
    .device-icon
    {
        color: #f5b130;
        font-size: 25px;
    }
    .tab-section
    {
        margin-top:40px;
    }
    .label-style
    {
        width:20%;
    }
</style>   
@section('script')
<script>
$(document).ready(function() {    
    //alert('here');	
  $('.tabs a').click(function(){ 
     $('.panel').hide();
     $('.tabs a.active').removeClass('active');
     $(this).addClass('active');     
     var panel = $(this).attr('href');
     $(panel).fadeIn(1000);     
     return false;  // prevents link action    
  });  // end click 
     $('.tabs li:first a').click();     
}); // end ready
</script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="{{asset('js/gps/device-detailed-view-in-report.js')}}"></script>
@endsection

@endsection