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
            <th>Alert</th>
            <th>Service engineer</th>
            <th>Reservice</th>
            <th>Data</th>
            <th>SMS</th>
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

        @foreach($vehicles as $detail)                  
        <tr> 
          <td>{{ (($perPage * ($page - 1)) + $loop->iteration) }}</td>
          <td>{{ $detail->name}}</td>
          <td>{{ $detail->gps->imei}}</td>
         <td>{{$detail->servicerjob->job_complete_date}}</td>
         <td></td>
         <td>{{$detail->servicerjob->servicer->name}}</td>
         <td></td>
         <td></td>
         <td></td>
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
        <ul class="nav nav-tabs">
            <li class="active"><a href="#a">Home</a></li>
            <li><a href="#b">Menu 1</a></li>
            <li><a href="#c">Menu 2</a></li>
            <li><a href="#">Menu 3</a></li>
        </ul>
        <!-- /Tabs -->
        <p id="a">a</p>
        <p id="b">b</p>
        <p id="c">c</p>
    </div>
    <!-- /Monitoring details --> 
</div>
@endsection
<!-- @section('script')
    <script src="{{asset('js/gps/monitor-list.js')}}"></script>
@endsection -->