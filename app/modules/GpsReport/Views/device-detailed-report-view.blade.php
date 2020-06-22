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
            <div class="box-part text-center" style="background-color:#eae9e2;padding: 35px;">
                <div class="title">
                    <h4 style="font-size: 17px;">
                    <span style="color:{{$gps_details->device_status}}">
                        <i class="fa fa-circle" aria-hidden="true"></i>
                    </span>
                    Mode : <?php ( isset($gps_details->imei) ) ? $imei = $gps_details->imei : $imei='-NA-' ?>{{$imei}} ( Serial No: <?php ( isset($gps_details->serial_no) ) ? $serial_no = $gps_details->serial_no : $serial_no='-NA-' ?>{{$serial_no}})</h4>
                </div><br>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="word-break: break-all;">
                        <span><b>Location :</b><?php ( isset($last_location) ) ? $last_location = $last_location : $last_location='-NA-' ?> {{$last_location}}</span>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <span><b>Last Packet Received On :</b> <?php ( isset($gps_details->device_time) ) ? $device_time = date('d/m/Y h:i:s A', strtotime($gps_details->device_time)): $device_time='-Not Yet Activated-' ?> {{$device_time}}<span>
                    </div>
                </div> 
                <table class="table table-borderless" style='border: 50px solid transparent' >
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
            <table class="table table-borderless"  style='width: 365px; margin-left: 400px;border: 0px solid transparent' >
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
        </div>
        <div class="container">
            <ul class="nav nav-pills">
                <li class="active"><a data-toggle="pill" href="#home">Vehicle Details</a></li>
                <li><a data-toggle="pill" href="#menu1">Device Details</a></li>
                <li><a data-toggle="pill" href="#menu2"> Alerts</a></li>
            </ul> 
            <div class="tab-content">
            </br>
                <div id="home" class="tab-pane fade in active">
                    <table class="table table-borderless"  style='border: 0px solid transparent' >
                        <thead>
                            <tr class="success" >
                                <td><b>Vehicle Name</b></td>
                                <td></td>
                            </tr>                
                            <tr>
                                <td>Vehicle Registration Number</td>
                                <td></td>
                            </tr>                
                            <tr class="success" >
                                <td><b>Vehicle Category</b></td>
                                <td></td>
                            </tr>                
                            <tr>
                                <td>Engine Number</td>
                                <td></td>
                            </tr>      
                            <tr class="success" >
                                <td><b>Chassis Number</b></td>
                                <td></td>
                            </tr>                   
                        </thead>
                    </table>   
                </div>
                <div id="menu1" class="tab-pane fade">
                    <table class="table table-borderless"  style='border: 0px solid transparent' >
                    <thead>
                            <tr class="success" >
                                <td><b>IMEI</b></td>
                                <td><?php ( isset($gps_details->tilt_status) ) ? $tilt_status = $gps_details->tilt_status : $tilt_status='-NA-' ?>{{$tilt_status}}</td>
                            </tr>                
                            <tr>
                                <td>Serial Number</td>
                                <td><?php ( isset($gps_details->tilt_status) ) ? $tilt_status = $gps_details->tilt_status : $tilt_status='-NA-' ?>{{$tilt_status}}</td>
                            </tr>                
                            <tr class="success" >
                                <td><b>Manufactured On</b></td>
                                <td><?php ( isset($gps_details->tilt_status) ) ? $tilt_status = $gps_details->tilt_status : $tilt_status='-NA-' ?>{{$tilt_status}}</td>
                            </tr>                
                            <tr>
                                <td>ICC ID</td>
                                <td><?php ( isset($gps_details->tilt_status) ) ? $tilt_status = $gps_details->tilt_status : $tilt_status='-NA-' ?>{{$tilt_status}}</td>
                            </tr>      
                            <tr class="success" >
                                <td><b>IMSI</b></td>
                                <td><?php ( isset($gps_details->tilt_status) ) ? $tilt_status = $gps_details->tilt_status : $tilt_status='-NA-' ?>{{$tilt_status}}</td>
                            </tr>     
                            <tr>
                                <td>E-Sim Number</td>
                                <td><?php ( isset($gps_details->tilt_status) ) ? $tilt_status = $gps_details->tilt_status : $tilt_status='-NA-' ?>{{$tilt_status}}</td>
                            </tr>                
                            <tr class="success" >
                                <td><b> Batch Number</b></td>
                                <td><?php ( isset($gps_details->tilt_status) ) ? $tilt_status = $gps_details->tilt_status : $tilt_status='-NA-' ?>{{$tilt_status}}</td>
                            </tr>                
                            <tr>
                                <td>Model Name</td>
                                <td><?php ( isset($gps_details->tilt_status) ) ? $tilt_status = $gps_details->tilt_status : $tilt_status='-NA-' ?>{{$tilt_status}}</td>
                            </tr>      
                            <tr class="success" >
                                <td><b>Version</b></td>
                                <td><?php ( isset($gps_details->tilt_status) ) ? $tilt_status = $gps_details->tilt_status : $tilt_status='-NA-' ?>{{$tilt_status}}</td>
                            </tr> 
                            <tr>
                                <td>Employee Code</td>
                                <td><?php ( isset($gps_details->tilt_status) ) ? $tilt_status = $gps_details->tilt_status : $tilt_status='-NA-' ?>{{$tilt_status}}</td>
                            </tr> 
                            <tr class="success" >
                                <td><b>Return Status</b></td>
                                <td><?php ( isset($gps_details->tilt_status) ) ? $tilt_status = $gps_details->tilt_status : $tilt_status='-NA-' ?>{{$tilt_status}}</td>
                            </tr>                    
                        </thead>
                    </table>                
                </div>
                <div id="menu2" class="tab-pane fade">
                    <table class="table table-borderless"  style='border: 0px solid transparent' >
                    <thead>
                            <tr class="success" >
                                <td><b>Vehicle Name</b></td>
                                <td></td>
                            </tr>                
                            <tr>
                                <td>Vehicle Registration Number</td>
                                <td></td>
                            </tr>                
                            <tr class="success" >
                                <td><b>Vehicle Category</b></td>
                                <td></td>
                            </tr>                
                            <tr>
                                <td>Engine Number</td>
                                <td></td>
                            </tr>      
                            <tr class="success" >
                                <td><b>Chassis Number</b></td>
                                <td></td>
                            </tr>                   
                        </thead>
                    </table>                
                </div>
                
            </div>
        </div>      
        </div>
    </div>
</section>


@section('script')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@endsection

@endsection