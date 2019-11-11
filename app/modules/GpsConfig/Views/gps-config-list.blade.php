@extends('layouts.api-app')
@section('content')
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
              <th>IMEI</th>
              <th id="imei"></th>
            </tr>
            <tr>
              <th>Serial No</th>
              <th id="serial_no"></th>
            </tr>
            <tr>
              <th>Manufacturing Date</th>
              <th id="manufacturing_date"></th>
            </tr>
            <tr>
              <th>ICC ID</th>
              <th id="icc_id"></th>
            </tr>
            <tr>
              <th>IMSI</th>
              <th id="imsi"></th>
            </tr>
            <tr>
              <th>E-Sim No.</th>
              <th id="e_sim_number"></th>
            </tr>
            <tr>
              <th>Batch No.</th>
              <th id="batch_number"></th>
            </tr>
            <tr>
              <th>Model Name</th>
              <th id="model_name"></th>
            </tr>
            <tr>
              <th>Version</th>
              <th id="version"></th>
            </tr>
            <tr>
              <th>Mode</th>
              <th id="mode"></th>
            </tr>
            <tr>
              <th>Latitude</th>
              <th id="lat"></th>
            </tr>
            <tr>
              <th>Latitude Dir</th>
              <th id="lat_dir"></th>
            </tr>
            <tr>
              <th>Longitude</th>
              <th id="lon"></th>
            </tr>
            <tr>
              <th>Longitude Dir</th>
              <th id="lon_dir"></th>
            </tr>
            <tr>
              <th>Fuel Status</th>
              <th id="fuel_status"></th>
            </tr>
            <tr>
              <th>Speed</th>
              <th id="speed"></th>
            </tr>
            <tr>
              <th>Odometer</th>
              <th id="odometer"></th>
            </tr>
            <tr>
              <th>Satllite</th>
              <th id="satllite"></th>
            </tr>
            <tr>
              <th>Battery Percentage</th>
              <th id="battery_status"></th>
            </tr>
            <tr>
              <th>Heading</th>
              <th id="heading"></th>
            </tr>
            <tr>
              <th>Main power Status</th>
              <th id="main_power_status"></th>
            </tr>
            <tr>
              <th>Ignition</th>
              <th id="ignition"></th>
            </tr>
            <tr>
              <th>GSM Signal strength</th>
              <th id="gsm_signal_strength"></th>
            </tr>
            <tr>
              <th>Emergency Status</th>
              <th id="emergency_status"></th>
            </tr>
            <tr>
              <th>Ac Status</th>
              <th id="ac_status"></th>
            </tr>
            <tr>
              <th>KM</th>
              <th id="km"></th>
            </tr>
            <tr>
              <th>Device Time</th>
              <th id="device_time"></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </section>
</section>


@section('script')
    <script src="{{asset('js/gps/gps-config-list.js')}}"></script>
@endsection
@endsection