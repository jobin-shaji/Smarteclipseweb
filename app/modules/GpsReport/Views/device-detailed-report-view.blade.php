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
                
            </div>


            <!-- table section -->
            <!-- <table class="table" style='width:700px;'>
                <tbody>
                <tr class="success">
                    <td><b>IMEI </b></td>
                    <td><?php ( isset($gps_details->imei) ) ? $imei = $gps_details->imei : $imei='-NA-' ?>{{$imei}}</td>
                </tr>
                <tr class="success">
                    <td><b>Serial Number</b></td>
                    <td><?php ( isset($gps_details->serial_no) ) ? $serial_no = $gps_details->serial_no : $serial_no='-NA-' ?>{{$serial_no}}</td>
                </tr>
                <tr class="success">
                    <td><b>Distributor </b></td>
                    <td><?php ( isset($gps_details->gpsStock->dealer->name) ) ? $dealer = $gps_details->gpsStock->dealer->name : $dealer='-NA-' ?>{{$dealer}}</td>
                </tr>
                <tr class="success">
                    <td><b>Dealer </td>
                    <td><?php ( isset($gps_details->gpsStock->subdealer->name) ) ? $subdealer = $gps_details->gpsStock->subdealer->name : $subdealer='-NA-' ?>{{$subdealer}}</td>
                </tr>
                <tr class="success">
                    <td><b>Sub Dealer</b></td>
                    <td><?php ( isset($gps_details->vehicleGps->vehicle->client->trader->name) ) ? $trader = $gps_details->vehicleGps->vehicle->client->trader->name : $trader='-NA-' ?>{{$trader}}</td>
                </tr>
                <tr class="success">
                    <td><b>End User </b></td>
                    <td><?php ( isset($gps_details->vehicleGps->vehicle->client->name) ) ? $client = $gps_details->vehicleGps->vehicle->client->name : $client='-NA-' ?>{{$client}}</td>
                </tr>
                <tr class="success">
                    <td><b>Vehicle Name </b></td>
                    <td><?php ( isset($gps_details->vehicleGps->vehicle->name) ) ? $vehicle_name = $gps_details->vehicleGps->vehicle->name : $vehicle_name='-NA-' ?>{{$vehicle_name}}</td>
                </tr>
                <tr class="success">
                    <td><b>Vehicle Registration Number </b></td>
                    <td><?php ( isset($gps_details->vehicleGps->vehicle->register_number) ) ? $register_no = $gps_details->vehicleGps->vehicle->register_number : $register_no='-NA-' ?>{{$register_no}}</td>
                </tr>
                <tr class="success">
                    <td><b>Last Packet Received On </b></td>
                    <td><?php ( isset($gps_details->device_time) ) ? $device_time = $gps_details->device_time : $device_time='-Not Yet Activated-' ?>{{$device_time}}</td>
                    
                </tr>
                
                </tbody>
            </table> -->
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
    <script src="{{asset('js/gps/device-detailed-view.js')}}"></script>
@endsection

@endsection