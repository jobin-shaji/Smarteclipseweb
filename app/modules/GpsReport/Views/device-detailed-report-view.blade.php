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
                <tr class="success" >
                    <td><b>Mode</b></td>
                    <td><b>Network Status</b></td>               
                    <td><b>Fuel Status</b></td>
                    <td><b>Speed</b></td>             
                    <td><b>Main Power</b></td>
                    <td><b>Ignition ON/OFF</b></td>               
                    <td><b>Gsm </b></td>
                    <td><b>GPS FIX</b></td>
                    <td><b>A/C Status</b></td>               
                </tr>                
                </thead>
            </table> 
            <table class="table table-borderless"  style='width: 365px; margin-left: 515px;border: 0px solid transparent' >
                <thead>
                <tr class="success" >
                    <td ><b>Tilt</b></td>
                    <td><b>OverSpeed</b></td>               
                    <td><b>Emergency</b></td>           
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
                            <td>Tilt</td>
                            <td>OverSpeed</td>
                        </tr>               
                            <td>Emergency</td> 
                            <td >Tilt</td>          
                        </tr>   
                        <tr class="success" >
                            <td >Tilt</td>
                            <td>OverSpeed</td>
                        </tr>               
                            <td>Emergency</td> 
                            <td >Tilt</td>          
                        </tr>   
                        <tr class="success" >
                            <td >Tilt</td>
                            <td>OverSpeed</td>
                        </tr>               
                            <td>Emergency</td> 
                            <td >Tilt</td>          
                        </tr>                
                        </thead>
                    </table>   
                </div>
                <div id="menu1" class="tab-pane fade">
                    <table class="table table-borderless"  style='border: 0px solid transparent' >
                        <thead>
                        <tr class="success" >
                            <td >Tilt</td>
                            <td>OverSpeed</td>
                        </tr>               
                            <td>Emergency</td> 
                            <td >Tilt</td>          
                        </tr>   
                        <tr class="success" >
                            <td >Tilt</td>
                            <td>OverSpeed</td>
                        </tr>               
                            <td>Emergency</td> 
                            <td >Tilt</td>          
                        </tr>   
                        <tr class="success" >
                            <td >Tilt</td>
                            <td>OverSpeed</td>
                        </tr>               
                            <td>Emergency</td> 
                            <td >Tilt</td>          
                        </tr>                
                        </thead>
                    </table>                
                </div>
                <div id="menu2" class="tab-pane fade">
                    <table class="table table-borderless"  style='border: 0px solid transparent' >
                        <thead>
                        <tr class="success" >
                            <td >Tilt</td>
                            <td>OverSpeed</td>
                        </tr>               
                            <td>Emergency</td> 
                            <td >Tilt</td>          
                        </tr>   
                        <tr class="success" >
                            <td >Tilt</td>
                            <td>OverSpeed</td>
                        </tr>               
                            <td>Emergency</td> 
                            <td >Tilt</td>          
                        </tr>   
                        <tr class="success" >
                            <td >Tilt</td>
                            <td>OverSpeed</td>
                        </tr>               
                            <td>Emergency</td> 
                            <td >Tilt</td>          
                        </tr>                
                        </thead>
                    </table>                
                </div>
                
            </div>
        </div>
        <!-- table section -->           
        </div>
    </div>
</section>


<style>
table, th, td {
  border: 1px solid black;
}
tr:hover {background-color: #D5D4D5;}

</style>
@section('script')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
 
    <script src="{{asset('js/gps/device-detailed-view.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@endsection

@endsection