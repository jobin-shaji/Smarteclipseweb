@extends('layouts.eclipse')
@section('content')

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 full-height">
      <div id="map" style="width:100%; height:100%;"></div>
    </div>
    <!-- <div class="left-bottom-car-details"><img class="left-bottom-car-details-img" src="assets/images/main-car.png"></div> -->
    <div class="pageContainer" style="overflow: scroll">
      <div class="col-lg-12">
        <div class="st-actionContainer right-bottom" >         
          <div class="right-bottom">                        
          </div>         
          <div class="right-bottom2 all_user_gps_data">    
                 
            <select id="gps_id" name=""  class="form-control vehicle_gps_id select2"  onchange="getVehicle(this.value)">
              <option value="" disabled selected>Select</option>
             @foreach ($gpss as $gps)
                <option  value="{{$gps->id}}">{{$gps->imei}}</option>
              @endforeach  
            </select> 
                              
          </div>
        </div>
      </div>
    </div>
    <div class="dashboard-main-Right cover_vehicle_track_list">
      <div class="iconsbg1234">
        <div class="col-md-6 col-lg-2 col-xlg-3 cover_track_data" onclick="mode('M')">
          <div class="card card-hover">
            <div class="box bg-cyan1234 text-center">
              <h1 class="font-light text-white"></h1>
              <h1 class="text-white" style="color:#84b752!important">
              <!-- <img src="assets/images/moving.png" style="width:100%"> -->
                <i class="fa fa-map-marker" aria-hidden="true"></i>
              </h1>
              <span class="track_status">Moving</span>
              <span style="float:left;width:100%"  >
                <h1 id="moving"  class="text-white"  style="font-size:19px;color:#fab03a!important">0</h1>
                <!--  <h5 class="text-white">MOVING</h5> -->
              </span>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-2 col-xlg-3 cover_track_data" onclick="mode('H')">
          <div class="card card-hover">
            <div class="box bg-cyan1234 text-center">
              <h1 class="font-light text-white"></h1>
              <h1 class="text-white" style="color: #69b4b9!important">
               <!--  <img src="assets/images/idling.png" style="width:100%"> -->
                <i class="fa fa-map-marker" aria-hidden="true"></i>
              </h1>
              <span class="track_status">Halt</span>
              <span style="float:left;width:100%">
                <h1  id="idle" class="text-white" style="font-size:19px;color:#fab03a!important">0</h1>
                <!-- <h5 class="text-white">IDLE</h5> -->
              </span>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-2 col-xlg-3 cover_track_data" onclick="mode('S')">
          <div class="card card-hover">
            <div class="box bg-cyan1234 text-center">
              <h1 class="font-light text-white"></h1>
              <h1 class="text-white" style="color: #858585!important">
                <!-- <img src="assets/images/delayed.png" style="width:100%"> -->
                <i class="fa fa-map-marker" aria-hidden="true"></i>
              </h1>
              <span class="track_status">Sleep</span>
              <span style="float:left;width:100%">
                <h1 id="stop"  class="text-white"  style="font-size:19px;color:#fab03a!important">0</h1>
                <!-- <h5 class="text-white">DELAY</h5> -->
              </span>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-2 col-xlg-3 cover_track_data" onclick="mode('O')">
          <div class="card card-hover">
            <div class="box bg-cyan1234 text-center">
              <h1 class="font-light text-white"></h1>
              <h1 class="text-white" style="color:#c41900!important">
                <!-- <img src="assets/images/stopped.png" style="width:100%"> -->
                <i class="fa fa-map-marker" aria-hidden="true"></i>
              </h1>
              <span class="track_status">Offline</span>
              <span style="float:left;width:100%">
                <h1 id="offline" class="text-white" style="font-size:19px;color:#fab03a!important">0</h1>
                <!--  <h5 class="text-white">STOPPED</h5> -->
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="iconsbg12345">
        <div class="row">
          <div class="card card-hover" style="width:100%;-webkit-box-shadow: 1px 1px 2px 3px #ccc;
               -moz-box-shadow: 1px 1px 2px 3px #ccc;
               box-shadow: 1px 1px 21px 1px #ccc">
            <div class="col-6 m-t-15">
              <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%;border-radius: 20px 0 0 0;" >
                <img src="assets/images/network-status.png">
                <h4 class="m-b-0 m-t-5 score_data_text">Network Status</h4>
                <medium id="network_status" class="font-light">
                <i class="fa fa-spinner" aria-hidden="true"></i>
              </div>

              <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%;border-radius: 0 20px 0 0;" >
                <img src="assets/images/fuel-status.png">
                <h4 class="m-b-0 m-t-5 score_data_text">Fuel Status</h4>
                <medium id="fuel_status" class="font-light">
                <i class="fa fa-spinner" aria-hidden="true"></i>
              </div>

              <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%">
                <img src="assets/images/speed.png">
                <h4 class="m-b-0 m-t-5 score_data_text">Speed</h4>
                <medium id="speed" class="font-light">
                <i class="fa fa-spinner" aria-hidden="true"></i>
              </div>

              <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%">
                <img src="assets/images/odometer.png">
                <h4 class="m-b-0 m-t-5 score_data_text">Odometer</h4>
                <medium id="odometer" class="font-light">
                <i class="fa fa-spinner" aria-hidden="true"></i>
              </div>

              <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%">
                <img src="assets/images/vehicle-status.png">
                <h4 class="m-b-0 m-t-5 score_data_text">Vehicle Status</h4>
                <medium id="mode" class="font-light">
                <i class="fa fa-spinner" aria-hidden="true"></i>
              </div>

              <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%">
                <img src="assets/images/sattelite.png">
                <h4 class="m-b-0 m-t-5 score_data_text">Satellite</h4>
                <medium id="satelite" class="font-light">
                <i class="fa fa-spinner" aria-hidden="true"></i>
              </div>

              <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%">
                <img src="assets/images/battery-status.png">
                <h4 class="m-b-0 m-t-5 score_data_text">Battery Status</h4>
                <medium id="battery_status" class="font-light">
                  <i class="fa fa-spinner" aria-hidden="true"></i>
              </div>

              <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%">
                <img src="assets/images/towing-dash.png">
                <h4 class="m-b-0 m-t-5 score_data_text">Towing</h4>
                <medium class="font-light">
                <i class="fa fa-spinner" aria-hidden="true"></i>
              </div>
                 
              <div class="bg-dark p-10 text-white text-center location_details" style="float: left;width:100%;border-radius: 0px 0px 8px 10px;">
                <h4 class="m-b-0 m-t-5 score_data_text">
                  <img src="assets/images/location.png">
                    Location
                </h4>
                <medium id="address" class="font-light">
                <i class="fa fa-spinner" aria-hidden="true"></i>   
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- CLIENT ROLE-END -->
</div>
</section>
@section('script')

<script src="{{asset('js/gps/m_dashb.js')}}"></script>
<script src="{{asset('js/gps/map-view.js')}}"></script>
<script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&libraries=places&callback=initMap"></script>
<script type="text/javascript">
</script>
<script src="{{asset('js/gps/GoogleRadar.js')}}"></script>
<script src="{{asset('dist/js/st.action-panel.js')}}"></script>
<style type="text/css">
  .container-fluid {padding-left: 0px !important}
</style>


@endsection
@endsection