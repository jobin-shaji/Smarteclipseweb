@extends('layouts.gps')

@section('content')
<section class="content-header">
      <h1>
        GPS
        <small>Control panel</small>
      </h1>
      <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/GPS Data</li>
        <b>Gps Data</b>
      </ol>
    </nav>
     
</section>
<section class="content">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">Gps Data List                     
        </div>
        <div class="table-responsive">
          <div class="panel-body">
             <input type="hidden" id="gps_count" >
            <input type="hidden" id="hd_gps" value="{{$gps->id}}">
            <table class="table table-hover table-bordered  table-striped datatable" style="width:100%;text-align: center;" id="dataTable">
              <thead>
                <tr>
                  <th>SL.No</th>
                  <!-- <th>Client</th> -->
                  <th>Gps</th>
                  <!-- <th>Vehicle</th> -->
                  <th>Header</th>
                  <th>Firmware</th>
                  <th>IMEI</th>
                  <th>Ignitio ON</th>
                  <th>Ignitio OFF</th>
                  <th>Battery Percentage</th>
                  <th>Low Battery Percentage</th>
                  <th>Memory Percentage</th>
                  <th>Digital IO Status </th>
                  <th>Analog Status</th>
                  <th>Activation Key</th>
                  <th>Lattitude</th>
                  <th>Lat Dir</th>
                  <th>Longitude</th>
                  <th>Long Dir</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Speed</th>
                  <th>Alert</th>
                  <th>Packet Status</th>
                  <th>GPS Fix</th>
                  <th>MCC</th>
                  <th>MNC</th>
                  <th>LAC</th>
                  <th>Cell</th>
                  <th>Heading</th>
                  <th>No Of Satelite</th>
                  <th>Hdop</th>
                  <th>Gsm signal Strength</th>
                  <th>Ignition</th>
                  <th>Main Power</th>
                  <th>Vehicle Mode</th>
                  <th>Alititude</th>
                  <th>Pdop</th>
                  <th>New OP Name</th>
                  <th>NMR</th>
                  <th>Main Input Voltage</th>
                  <th>Internal Battery Voltage</th>
                  <th>Tamper Alert</th>
                  <th>Digital Input Status</th>
                  <th>Digital Output Status</th>
                  <th>Frame Number</th>
                  <th>Check Sum</th>
                  <th>Key1</th>
                  <th>Value 1</th>
                  <th>Key 2</th>
                  <th>Value 2</th>
                  <th>Key 3</th>
                  <th>Value 3</th>
                  <th>GF ID</th>
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
  <script src="{{asset('js/gps/gps-data-list.js')}}"></script>
@endsection
@endsection