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
      <table class="table table-bordered" style="text-align: center;">
        <thead>
          <tr>
            <th>SL.No</th>
            <th>Vehicle Name</th>
            <th>IMEI</th>
            <th>Installation Date</th>
            <th>Service engineer</th>
            <!-- <th>Alert</th>
            <th>Reservice</th>
            <th>Data</th>
            <th>SMS</th> -->
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

        @foreach($vehicles as $each_vehicle)                  
        <tr>
          <td>{{ (($perPage * ($page - 1)) + $loop->iteration) }}</td>
          <td><a href="#vehicle" id="vehicle_id" onClick="single_vehicle_details('{{$each_vehicle->id}}')">{{ $each_vehicle->name}}</a></td>
          <td><a href="#device">{{ $each_vehicle->gps->imei}}</a></td>
         <td><a href="#installation">{{$each_vehicle->servicerjob->job_complete_date}}</a></td>
         <td><a href="#service">{{$each_vehicle->servicerjob->servicer->name}}</a></td>
         <!-- <td></td>
         <td></td>
         <td></td>
         <td></td> -->
     
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
        <li><a data-toggle="tab" href="#tab_content_vehicle">Vehicle</a></li>
        <li><a data-toggle="tab" href="#device">Device</a></li>
        <li><a data-toggle="tab" href="#installation">Installation</a></li>
        <li><a data-toggle="tab" href="#service">Service</a></li>
        <li><a data-toggle="tab" href="#subscription">Subscription</a></li>
      </ul>
      <!-- Tab details -->
      <div id="monitoring_details_tab_contents" class="tab-content">
        <!-- Vehicle -->
        <div id="tab_content_vehicle" class="tab-pane fade in active">
          <h3>Vehicle</h3>
          <p>
          <div>Vehicle Name <span id="tvc_vehicle_name"> </span></div>
          <div>Registration Number <span id="tvc_vehicle_registration_number"></span></div>
         </p>
          
        </div>
        <!-- /Vehicle -->
        <!-- Device -->
        <div id="device" class="tab-pane fade">
          <h3>Device</h3>
          <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>
        <!-- /Device -->
        <div id="installation" class="tab-pane fade">
          <h3>Installation</h3>
          <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
        </div>
        <div id="service" class="tab-pane fade">
          <h3>Service</h3>
          <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
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
<style type="text/css" src="{{asset('css/monitor.css')}}"></style>
<style type="text/css" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"></style>
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js">      </script>
   <script type="text/javascript" src="{{asset('js/gps/monitor-list.js')}}"></script>
@endsection