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
                    IMEI : <?php ( isset($gps_details->imei) ) ? $imei = $gps_details->imei : $imei='-NA-' ?>{{$imei}} ( Serial No: <?php ( isset($gps_details->serial_no) ) ? $serial_no = $gps_details->serial_no : $serial_no='-NA-' ?>{{$serial_no}})</h4>
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
                    <td>IMEI</td>
                    <td>Network Status</td>               
                    <td>Fuel Status</td>
                    <td>Speed</td>             
                    <td>Main Power</td>
                    <td>Ingnition ON/OFF</td>               
                    <td>Gsm </td>
                    <td>GPS FIX</td>
                    <td>A/C Status</td>               
                </tr>                
                </thead>
            </table> 
            <table class="table table-borderless"  style='width: 365px; margin-left: 515px;border: 0px solid transparent' >
                <thead>
                <tr class="success" >
                    <td >Tilt</td>
                    <td>OverSpeed</td>               
                    <td>Emergency</td>           
                </tr>                
                </thead>
            </table>   
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
@endsection