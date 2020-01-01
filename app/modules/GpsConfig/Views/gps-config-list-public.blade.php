@extends('layouts.api-app')
@section('content')
<h3 style="margin-left: 5%"><b>GPS Configuration</b></h3>
<section class="hilite-content">
  <form  method="POST" action="#">
  {{csrf_field()}}
    <div class="row">
      <div class="col-md-4">
        <div  style ="margin-left: 77px"class="form-group has-feedback">
          <label class="srequired">GPS</label>
          <select class="form-control select2" id="gps_id" name="gps_id"  data-live-search="true" title="Select GPS" required onchange='getData(this.value)'>
          <option value="">Select GPS</option>
          @foreach($gps as $gps)
          <option value="{{$gps->id}}">{{$gps->imei}} || {{$gps->serial_no}}</option>
          @endforeach
          </select>  
        </div> 
      </div>
    </div>
  </form>

  <section class="content" >
    <div class="row">
      <div class="col-md-6">
        <table class="table table-hover table-bordered  table-striped">
          <thead>
            <tr>
              <th><b>IMEI</b></th>
              <th id="imei"></th>
            </tr>
            <tr>
              <th><b>Serial No</b></th>
              <th id="serial_no"></th>
            </tr>
            <tr>
              <th><b>Manufacturing Date</b></th>
              <th id="manufacturing_date"></th>
            </tr>
            <tr>
              <th><b>ICC ID</b></th>
              <th id="icc_id"></th>
            </tr>
            <tr>
              <th><b>IMSI</b></th>
              <th id="imsi"></th>
            </tr>
            <tr>
              <th><b>E-Sim No</b></th>
              <th id="e_sim_number"></th>
            </tr>
            <tr>
              <th><b>Batch No</b></th>
              <th id="batch_number"></th>
            </tr>
            <tr>
              <th><b>Model Name</b></th>
              <th id="model_name"></th>
            </tr>
            <tr>
              <th><b>Version</b></th>
              <th id="version"></th>
            </tr>
            <tr>
              <th><b>Mode</b></th>
              <th id="mode"></th>
            </tr>
            <tr>
              <th><b>Latitude</b></th>
              <th id="lat"></th>
            </tr>
            <tr>
              <th><b>Latitude Dir</b></th>
              <th id="lat_dir"></th>
            </tr>
            <tr>
              <th><b>Longitude</b></th>
              <th id="lon"></th>
            </tr>
            <tr>
              <th><b>Longitude Dir</b></th>
              <th id="lon_dir"></th>
            </tr>
            <tr>
              <th><b>Fuel Status</b></th>
              <th id="fuel_status"></th>
            </tr>
            <tr>
              <th><b>Speed</b></th>
              <th id="speed"></th>
            </tr>
            <tr>
              <th><b>Odometer</b></th>
              <th id="odometer"></th>
            </tr>
            <tr>
              <th><b>Satllite</b></th>
              <th id="satllite"></th>
            </tr>
            <tr>
              <th><b>Battery Percentage</b></th>
              <th id="battery_status"></th>
            </tr>
            <tr>
              <th><b>Heading</b></th>
              <th id="heading"></th>
            </tr>
            <tr>
              <th><b>Main power Status</b></th>
              <th id="main_power_status"></th>
            </tr>
            <tr>
              <th><b>Ignition</b></th>
              <th id="ignition"></th>
            </tr>
            <tr>
              <th><b>GSM Signal strength</b></th>
              <th id="gsm_signal_strength"></th>
            </tr>
            <tr>
              <th><b>Emergency Status</b></th>
              <th id="emergency_status"></th>
            </tr>
            <tr>
              <th><b>Ac Status</b></th>
              <th id="ac_status"></th>
            </tr>
            <tr>
              <th><b>KM</b></th>
              <th id="km"></th>
            </tr>
            <tr>
              <th><b>Device Time</b></th>
              <th id="device_time"></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </section>
</section>


@section('script')
    <script src="{{asset('js/gps/gps-config-list-public.js')}}"></script>
@endsection
@endsection