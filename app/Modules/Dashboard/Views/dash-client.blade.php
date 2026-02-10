  <input type="hidden" id="lat" name="lat" value="{{$client->latitude}}">
  <input type="hidden" id="lng" name="lng" value="{{$client->longitude}}">
  <div id="map_refresh_button" class="refresh_map" onclick="refreshPage()">
    <button id="refresh_button" type="submit" class="btn btn-primary btn-block">
      <i class="fa fa-refresh"></i> Refresh
    </button>
  </div>
  <div class="dashboar-1-map-box">
    <div class="dasb-board-googlemap">
      <div id="map" style="width:100%; height:100%;"></div>
      <div class="st-actionContainer right-bottom">
        <div class="st-panel st-panel-dashboard1" style="width: 50%">
          <div class="st-panel-contents" id="vehicle_card_cover" style="overflow: scroll!important;height: auto;width: 103%;max-height: 164px">
            @foreach ($vehicles as $vehicle)
            <div class="border-card">
              <div class="content-wrapper con-radio">
                <div class="card-type-icon with-border">
                  <input type="radio" id="radio" id="gpsid{{ $loop->iteration }}" class="vehicle_gps_id" name="radio" onclick="getVehicle({{$vehicle->gps_id}},true)" value="{{$vehicle->gps_id}}">
                </div>
                <div class="label-group fixed">
                  <p class="title">
                    <span><i class="fa fa-car"></i></span>
                  </p>
                  <p class="caption" id="vehicle_name{{ $loop->iteration }}">{{$vehicle->name}}</p>
                </div>
                <div class="min-gap"></div>
                <div class="label-group">
                  <p class="title">
                    <span><i class="fas fa-arrow-alt-circle-left"></i></span>
                  </p>
                  <p class="caption" id="register_number{{ $loop->iteration }}">{{$vehicle->register_number}}</p>
                </div>
                <div class="min-gap"></div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
      <div class="dashboard-serch-km-section">
        <div class="dash-bord-bottom">
          <div class="st-button-main str-icon">
            <img class="left-bottom-car-details-img" src="assets/images/stearing.png" width="66px">
          </div>
          @role('fundamental|superior|pro|school')
          <div class="dash-board-bt-inner">
            <div class="right-bottom">
            </div>
            <form onsubmit="return locationSearch();">
              <input type="text" id="search_place" class="form-control" value="">
              <select id="search_radius" name="cars">
                <option selected>KM</option>
                <option value="10">10 KM</option>
                <option value="30">30 KM</option>
                <option value="50">50 KM</option>
                <option value="75">75 KM</option>
                <option value="100">100 KM</option>
              </select>
              <button><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
            @endrole
          </div>
        </div>
      </div>
      <div class="dash-baord-rt-new-box">
        <div class="dash-boad1-rt-box">
          <div class="dash-boad1-rt-box-sm green" onclick="moving('M')">
            <a href="#">
              <i class="fa fa-map-marker green" aria-hidden="true"></i>
              <div class="track_status dash-boad1-rt-move">Moving</div>
              <div id="moving" class="dash-boad1-rt-move-no">0</div>
            </a>
          </div>
          <div class="dash-boad1-rt-box-sm blue" onclick="moving('H')">
            <a href="#">
              <i class="fa fa-map-marker blue" aria-hidden="true"></i>
              <div class="track_status dash-boad1-rt-move">Halt</div>
              <div id="idle" class="dash-boad1-rt-move-no">0</div>
            </a>
          </div>
          <div class="dash-boad1-rt-box-sm gray" onclick="moving('S')">
            <a href="#">
              <i class="fa fa-map-marker gray" aria-hidden="true"></i>
              <div class="track_status dash-boad1-rt-move">Sleep</div>
              <div id="stop" class="dash-boad1-rt-move-no">0</div>
            </a>
          </div>
          <div class="dash-boad1-rt-box-sm red border-0" onclick="moving('O')">
            <a href="#">
              <i class="fa fa-map-marker red" aria-hidden="true"></i>
              <div class="track_status dash-boad1-rt-move">Disconnect</div>
              <div id="offline" class="dash-boad1-rt-move-no">0</div>
            </a>
          </div>
        </div>
        
        <div class="location-sction" id="location-sction">
          <div class="location-sction-icon"><i class="fa fa-location-arrow" aria-hidden="true"></i></div>
          <div class="location-sction-content">
            <medium id="address" class="font-light">
            <div class="loader-wrapper loader-1"  >
                  <div id="loader"></div>
                </div>
          </div>
        </div>
        <div class="dash-vechile-detials-1">
          <div class="dash-vechile-detials-1-inner">
            <div class="dash-vechile-detials-1-inner-lf">
              <div class="dash-vechile-detials-img">
                <img src="assets/images/network-status.png" id="network_online">
                <img src="assets/images/no-network.png" id="network_offline" style="display: none;">
              </div>
              <div class="dash-vechile-detail-text"><p>Network Status</p>
                <medium id="network_status" class="font-light">
                <i class="fa fa-spinner" aria-hidden="true"></i>
              </div>
            </div>
            <div class="dash-vechile-detials-1-inner-lf">
              <div class="dash-vechile-detials-img">
                <img src="assets/images/fuel-status.png">
              </div>
              <div class="dash-vechile-detail-text"><p>Fuel Status</p>
                <div id="fuel_100" class="fuel-outer fuel-out">
                  <ul>
                    <li id="f100"></li>
                    <li id="f100"></li>
                    <li id="f100"></li>
                    <li id="f100"></li>
                  </ul>
                </div>
                <div id="fuel_75" class="fuel-outer fuel-out">
                  <ul>
                    <li id="f75"></li>
                    <li id="f75"></li>
                    <li id="f75"></li>
                    <li id="f0"></li>
                  </ul>
                </div>
                <div id="fuel_50" class="fuel-outer fuel-out">
                  <ul>
                    <li id="f50"></li>
                    <li id="f50"></li>
                    <li id="f0"></li>
                    <li id="f0"></li>
                  </ul>
                </div>
                <div id="fuel_25" class="fuel-outer fuel-out">
                  <ul>
                    <li id="f25"></li>
                    <li id="f0"></li>
                    <li id="f0"></li>
                    <li id="f0"></li>
                  </ul>
                </div>
                <div id="fuel_0" class="fuel-outer fuel-out">
                  <ul>
                    <li id="f0"></li>
                    <li id="f0"></li>
                    <li id="f0"></li>
                    <li id="f0"></li>
                  </ul>
                </div>
                <div id="upgrade" class="fuel-outer fuel-out">
                  <medium id="upgradefuel" class="font-light">
                </div>
                <i class="fa fa-spinner" aria-hidden="true"></i>
              </div>
            </div>
          </div>
          <div class="dash-vechile-detials-1-inner">
            <div class="dash-vechile-detials-1-inner-lf">
              <div class="dash-vechile-detials-img">
                <img src="assets/images/speed.png">
              </div>
              <div class="dash-vechile-detail-text"><p>Speed</p>
                <medium id="speed" class="font-light">
                <i class="fa fa-spinner" aria-hidden="true"></i>
              </div>
            </div>
            <div class="dash-vechile-detials-1-inner-lf">
              <div class="dash-vechile-detials-img">
                <img src="assets/images/odometer.png">
              </div>
              <div class="dash-vechile-detail-text"><p>Odometer</p>
                <medium id="odometer" class="font-light">
                <i class="fa fa-spinner" aria-hidden="true"></i>
              </div>
            </div>
          </div>
          <div class="dash-vechile-detials-1-inner">
            <div class="dash-vechile-detials-1-inner-lf">
              <div class="dash-vechile-detials-img">
                <img src="assets/images/vehicle-status.png" id="vehicle_status">
                <img src="assets/images/moving-dashboard.png" id="vehicle_moving" style="display: none;">
                <img src="assets/images/halt-dashboard.png" id="vehicle_halt" style="display: none;">
                <img src="assets/images/sleep-dashboard.png" id="vehicle_sleep" style="display: none;">
                <img src="assets/images/offline-dashboard.png" id="vehicle_stop" style="display: none;">
              </div>
              <div class="dash-vechile-detail-text"><p>Vehicle Status</p>
                <medium id="mode" class="font-light">
                <i class="fa fa-spinner" aria-hidden="true"></i>
              </div>
            </div>
            <div class="dash-vechile-detials-1-inner-lf">
              <div class="dash-vechile-detials-img">
                <img src="assets/images/sattelite.png">
              </div>
              <div class="dash-vechile-detail-text"><p>Satellite</p>
                <medium id="satelite" class="font-light">
                <i class="fa fa-spinner" aria-hidden="true"></i>
              </div>
            </div>
          </div>
          <div class="dash-vechile-detials-1-inner mrg-bottom-0 border-last-0">
            <div class="dash-vechile-detials-1-inner-lf">
              <div class="dash-vechile-detials-img">
                <img src="assets/images/battery-status.png">
              </div>
              <div class="dash-vechile-detail-text"><p>Internal Battery Status.</p>
                <medium id="battery_status" class="font-light">
                <i class="fa fa-spinner" aria-hidden="true"></i>
              </div>
            </div>
            <div class="dash-vechile-detials-1-inner-lf ">
              <div class="dash-vechile-detials-img">
                <img src="assets/images/ignition-dashboard.png">
              </div>
              <div class="dash-vechile-detail-text"><p>Ignition</p>
                <medium id="ignition" class="font-light">
                <i class="fa fa-spinner" aria-hidden="true"></i>
              </div>
              <div class="location " id="location">
                <!-- <button type="button">View Location</button>          -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>




    <!-- <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 full-height">
          <div id="map_refresh_button" class="refresh_map" onclick="refreshPage()">
            <button id="refresh_button" type="submit" class="btn btn-primary btn-block">
              <i class="fa fa-refresh"></i> Refresh
            </button>
          </div>
        </div>
        <div class="pageContainer">
          <div class="col-lg-12">
            <div class="st-actionContainer right-bottom">
              <div class="st-panel" style="width: 50%">
                <div class="st-panel-contents" id="vehicle_card_cover" style="overflow: scroll!important;height: auto;width: 103%;max-height: 164px"> -->
                  <!-- @foreach ($vehicles as $vehicle)
                  <div class="border-card">
                    <div class="content-wrapper con-radio">
                      <div class="card-type-icon with-border">
                        <input type="radio" id="radio" id="gpsid{{ $loop->iteration }}" class="vehicle_gps_id" name="radio" onclick="getVehicle({{$vehicle->gps_id}},true)" value="{{$vehicle->gps_id}}">
                      </div>
                      <div class="label-group fixed">
                        <p class="title">
                          <span><i class="fa fa-car"></i></span>
                        </p>
                        <p class="caption" id="vehicle_name{{ $loop->iteration }}">{{$vehicle->name}}</p>
                      </div>
                      <div class="min-gap"></div>
                      <div class="label-group">
                        <p class="title">
                          <span><i class="fas fa-arrow-alt-circle-left"></i></span>
                        </p>
                        <p class="caption" id="register_number{{ $loop->iteration }}">{{$vehicle->register_number}}</p>
                      </div>
                      <div class="min-gap"></div>
                    </div>
                  </div>
                  @endforeach
                 </div>
                 <div id="msg"></div>
               </div>
               <div class="right-bottom">
                <div class="st-button-main">
                  <img class="left-bottom-car-details-img" src="assets/images/stearing.png" width="66px">
                </div>
              </div>
              @role('fundamental|superior|pro|school')
              <div class="right-bottom2">
                <form onsubmit="return locationSearch();">
                  <div class="col-lg-12 col-md-12">
                    <div class="container-fluid bg-light map_search">
                      <div class="row align-items-center justify-content-center">
                        <div class="col-lg-4 col-md-4 ">
                          <div class="form-group">
                            <input type="text" id="search_place" class="form-control" value="">
                          </div>
                        </div>
                        <div class="col-lg-4 col-md-4 ">
                          <div class="form-group">
                            <select id="search_radius" class="form-control">
                              <option selected>KM</option>
                              <option value="10">10 KM</option>
                              <option value="30">30 KM</option>
                              <option value="50">50 KM</option>
                              <option value="75">75 KM</option>
                              <option value="100">100 KM</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-2 col-md-2 ">
                          <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-search"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div> -->
              <style type="text/css">
                .pac-container {
                  position: absolute !important;
                  bottom: 105px !important;
                  margin: 0px;
                  top: inherit !important;
                }
                .new-track-stle {
                  right: 4%;
                }
                .content-wrapper.con-radio {
                    height: auto;
                  }
              </style>
              <!-- <div id="myModal" class="modal_for_dash">
                <div class="modal-content">
                  <div class="modal-header">
                    <span class="close"></span>
                    <div class="container">
                      <div class="container">
                        <canvas id="myChart" style="max-width: 500px;"></canvas>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endrole
          </div>
        </div>
      </div>-->

      <!--<div class="dashboard-main-Right cover_vehicle_track_list new-track-stle">
         <div class="iconsbg1234">
          <div class="col-md-6 col-lg-2 col-xlg-3 cover_track_data" onclick="moving('M')" style="max-width: 23%!important">
            <div class="card card-hover" style="cursor: pointer;">
              <div class="box bg-cyan1234 text-center">
                <h1 class="font-light text-white"></h1>
                <h1 class="text-white" style="color:#84b752!important">
                  <i class="fa fa-map-marker" aria-hidden="true"></i>
                </h1>
                <span class="track_status">Moving</span>
                <span style="float:left;width:100%">
                  <h1 id="moving" class="text-white" style="font-size:19px;color:#fab03a!important">0</h1>
                </span>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-2 col-xlg-3 cover_track_data" onclick="moving('H')" style="max-width: 20%!important">
            <div class="card card-hover" style="cursor: pointer;">
              <div class="box bg-cyan1234 text-center">
                <h1 class="font-light text-white"></h1>
                <h1 class="text-white" style="color: #69b4b9!important">
                  <i class="fa fa-map-marker" aria-hidden="true"></i>
                </h1>
                <span class="track_status">Halt</span>
                <span style="float:left;width:100%">
                  <h1 id="idle" class="text-white" style="font-size:19px;color:#fab03a!important">0</h1>
                </span>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-2 col-xlg-3 cover_track_data" onclick="moving('S')" style="max-width: 20%!important">
            <div class="card card-hover" style="cursor: pointer;">
              <div class="box bg-cyan1234 text-center">
                <h1 class="font-light text-white"></h1>
                <h1 class="text-white" style="color: #858585!important">
                  <i class="fa fa-map-marker" aria-hidden="true"></i>
                </h1>
                <span class="track_status">Sleep</span>
                <span style="float:left;width:100%">
                  <h1 id="stop" class="text-white" style="font-size:19px;color:#fab03a!important">0</h1>
                </span>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-2 col-xlg-3 cover_track_data" onclick="moving('O')" style="max-width: 23%!important">
            <div class="card card-hover" style="cursor: pointer;">
              <div class="box bg-cyan1234 text-center">
                <h1 class="font-light text-white"></h1>
                <h1 class="text-white" style="color:#c41900!important">
                  <i class="fa fa-map-marker" aria-hidden="true"></i>
                </h1>
                <span class="track_status">Offline</span>
                <span style="float:left;width:100%">
                  <h1 id="offline" class="text-white" style="font-size:19px;color:#fab03a!important">0</h1>
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="iconsbg12345">
          <div class="row" style="padding: 0 12% 0 0">
            <div class="card card-hover" style="width:100%;-webkit-box-shadow: 1px 1px 2px 3px #ccc;
               -moz-box-shadow: 1px 1px 2px 3px #ccc;
               box-shadow: 1px 1px 21px 1px #ccc">
              <div class="col-6 m-t-15">
                <div style="width: 100%;float: left;">
                  <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%;border-radius: 20px 0 0 0;">
                    <img src="assets/images/network-status.png" id="network_online">
                    <img src="assets/images/no-network.png" id="network_offline" style="display: none;">
                    <h4 class="m-b-0 m-t-5 score_data_text">Network Status</h4>
                    <medium id="network_status" class="font-light">
                      <i class="fa fa-spinner" aria-hidden="true"></i>
                  </div>
                  <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%;border-radius: 0 20px 0 0;">
                    <img src="assets/images/fuel-status.png">
                    <h4 class="m-b-0 m-t-5 score_data_text">Fuel Status</h4>
                    <div id="fuel_100" class="fuel-outer">
                      <ul>
                        <li id="f100"></li>
                        <li id="f100"></li>
                        <li id="f100"></li>
                        <li id="f100"></li>
                      </ul>
                    </div>
                    <div id="fuel_75" class="fuel-outer">
                      <ul>
                        <li id="f75"></li>
                        <li id="f75"></li>
                        <li id="f75"></li>
                        <li id="f0"></li>
                      </ul>
                    </div>
                    <div id="fuel_50" class="fuel-outer">
                      <ul>
                        <li id="f50"></li>
                        <li id="f50"></li>
                        <li id="f0"></li>
                        <li id="f0"></li>
                      </ul>
                    </div>
                    <div id="fuel_25" class="fuel-outer">
                      <ul>
                  <li id="f25"></li>
                        <li id="f0"></li>
                        <li id="f0"></li>
                        <li id="f0"></li>
                      </ul>
                    </div>
                    <div id="fuel_0" class="fuel-outer">
                      <ul>
                        <li id="f0"></li>
                        <li id="f0"></li>
                        <li id="f0"></li>
                        <li id="f0"></li>
                      </ul>
                    </div>
                    <i class="fa fa-spinner" aria-hidden="true"></i>
                  </div>
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
                  <img src="assets/images/vehicle-status.png" id="vehicle_status">
                  <img src="assets/images/moving-dashboard.png" id="vehicle_moving" style="display: none;">
                  <img src="assets/images/halt-dashboard.png" id="vehicle_halt" style="display: none;">
                  <img src="assets/images/sleep-dashboard.png" id="vehicle_sleep" style="display: none;">
                  <img src="assets/images/offline-dashboard.png" id="vehicle_stop" style="display: none;">
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
                  <h4 class="m-b-0 m-t-5 score_data_text">Internal Battery Status</h4>
                  <medium id="battery_status" class="font-light">
                    <i class="fa fa-spinner" aria-hidden="true"></i>
                </div>

                <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%">
                  <img src="assets/images/ignition-dashboard.png">
                  <h4 class="m-b-0 m-t-5 score_data_text">Ignition</h4>
                  <medium id="ignition" class="font-light">
                    <i class="fa fa-spinner" aria-hidden="true"></i>
                </div>

                <div class="bg-dark p-10 text-white text-center location_details" style="width:100%;border-radius: 0px 0px 8px 10px; padding: 10px 0 10px 14px!important;">
                  <h4 class="m-b-0 m-t-5 score_data_text" style="padding: 0 48% 0 0!important">
                    <img src="assets/images/location.png">
                    Location
                  </h4>
                  <medium id="address" class="font-light">
                    <i class="fa fa-spinner" aria-hidden="true"></i>
                </div>
                <div class="clear"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>-->
    