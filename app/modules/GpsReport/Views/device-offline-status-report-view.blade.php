@extends('layouts.eclipse')
@section('title')
    GPS Details
@endsection
@section('content')    
<section class="hilite-content">
    <div class="page-wrapper_new">
        <!-- breadcrumbs -->
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/GPS Details</li>
            <b> GPS Details</b>
        </ol>
        @if(Session::has('message'))
            <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                    {{ Session::get('message') }}  
            </div>
            </div>
        @endif  
        </nav> <br>
        <!-- /breadcrumbs -->

        <div class="container-fluid">
            <!-- table section -->
            <table class="table" style='width:700px;'>
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
            </table>
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