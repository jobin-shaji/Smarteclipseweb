@extends('layouts.eclipse')
@section('content')

<!--  -->
<!-- ROOT ROLE-START -->
@role('root')
 <style>
    .btn-pop {
    display: inline-block;
    font-weight: 400;
    color: #212529;
    text-align: center;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;  
    background-color:#ccc;
    border: 1px solid transparent;
    padding: 0 .21rem;
     line-height: 2;
     font-size:.75rem!important;
    border-radius: .25rem;
    margin:0 .1rem .5rem .1rem;
    color:#000;
  }
  .btn-pop:hover {background:#f7b018;}
  </style>
<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <section class="content">
      <div class="row">
        <div class="col-lg-3 col-xs-6 gps_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="gps">
                <div class="loader"></div>
              </h3>
              <p>GPS In Stock</p>
            </div>
            <div class="icon">
              <i class="fa fa-tablet"></i>
            </div>
            <a href="/gps" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6 dealer_dashboard_grid dash_grid" >
          <!-- small box -->
          <div class="small-box bg-yellow bxs">
            <div class="inner">
              <h3 id="dealer">
                <div class="loader"></div>
              </h3>
              <p>Active Dealers</p>
            </div>
            <div class="icon">
              <i class="fa fa-tablet"></i>
            </div>
              <a href="/dealers" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6 sub_dealer_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-blue bxs">
            <div class="inner">
              <h3 id="sub_dealer">
                <div class="loader"></div>
              </h3>
              <p>Active Subdealers</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="/sub-dealers" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6 client_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="client">
                <div class="loader"></div>
              </h3>
              <p>Active Clients</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="/client" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 col-xs-6">
          <canvas id="rootChart" style="max-width: 100%; height: 200px;" ></canvas>  
        </div>
        <div class="col-lg-6 col-xs-6">
          <canvas id="rootChartUser" style="max-width: 100%; height: 200px;" ></canvas>  
        </div>
      </div>
    </section>
  </div>
</div>
@endrole
<!-- ROOT ROLE-END -->

<!-- DEALER ROLE-START -->
@role('dealer')
<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <div class="container-fluid">
      <div class="card-body">
        <div class="table-responsive">
          <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
            <div class="row">
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-lg-2 col-xs-6 new_arrival_dashboard_grid dash_grid">
                    <div class="small-box bg-green bxs">
                      <div class="inner">
                        <h3 id="gps_new_arrival_dealer">
                          <div class="loader"></div>
                        </h3>
                        <p>GPS New Arrivals</p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-tablet"></i>
                      </div>
                      <a href="/gps-dealer-new" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <div class="col-lg-2 col-xs-6 gps_dashboard_grid dash_grid">
                    <div class="small-box bg-green bxs">
                      <div class="inner">
                        <h3 id="total_gps_dealer">
                          <div class="loader"></div>
                        </h3>
                        <p>GPS In Stock</p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-tablet"></i>
                      </div>
                      <a href="/gps-dealer" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <div class="col-lg-2 col-xs-6 transferred_gps_dashboard_grid dash_grid">
                    <!-- small box -->
                    <div class="small-box bg-green bxs">
                      <div class="inner">
                        <h3 id="transferred_gps_dealer">
                          <div class="loader"></div>
                        </h3>
                        <p>Transferred GPS</p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-tablet"></i>
                      </div>
                      <a href="/gps-transfers-dealer" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-2 col-xs-6 sub_dealer_dashboard_grid dash_grid">
                    <!-- small box -->
                    <div class="small-box bg-yellow bxs">
                      <div class="inner">
                        <h3 id="dealer_subdealer">
                          <div class="loader"></div>
                        </h3>
                        <p>Active Subdealers</p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-user"></i>
                      </div>
                      <a href="/subdealers" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <div class="col-lg-2 col-xs-6 client_dashboard_grid dash_grid">
                    <!-- small box -->
                    <div class="small-box bg-green bxs">
                      <div class="inner">
                        <h3 id="dealer_client">
                          <div class="loader"></div>
                        </h3>
                        <p>Active Clients</p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-user"></i>
                      </div>
                      <a href="/dealer-client" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6 col-xs-6">
                <canvas id="rootChart" style="max-width: 100%;" ></canvas>  
              </div>
              <div class="col-lg-6 col-xs-6">
                <canvas id="rootChartUser" style="max-width: 100%;" ></canvas>  
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- ./col -->       
@endrole
<!-- DEALER ROLE-END -->
<!-- DEALER ROLE-START -->
@role('operations')
<div class="page-wrapper page-wrapper-root page-wrapper_new" style="min-height: 634px!important">
  <div class="page-wrapper-root1">
    <div class="container-fluid">
      <div class="card-body">
        <div class="table-responsive">
          <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
            <div class="row">
              <div class="col-sm-12">
                <div class="row">
                  <!-- ./col -->
                  <div class="col-lg-3 col-xs-8 sub_dealer_dashboard_grid dash_grid">
                    <!-- small box -->
                    <div class="small-box bg-yellow bxs">
                      <div class="inner">
                        <h3 id="gps">
                          <div class="loader"></div>
                        </h3>
                        <p>Instock Gps </p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-user"></i>
                      </div>
                     <!--  <a href="" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a> -->
                    </div>
                  </div>
                   <div class="col-lg-3 col-xs-8 client_dashboard_grid dash_grid">
                    <!-- small box -->
                    <div class="small-box bg-green bxs">
                      <div class="inner">
                        <h3 id="gps_today">
                          <div class="loader"></div>
                        </h3>
                        <p>Today Manufactured</p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-user"></i>
                      </div>
                     <!--  <a href="" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a> -->
                    </div>
                  </div>
                 
                
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- ./col -->       
@endrole
<!-- SUB DEALER ROLE-START -->
@role('sub_dealer')
<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <div class="row">
      <div class="col-lg-3 col-xs-6 new_arrival_dashboard_grid dash_grid">
        <div class="small-box bg-green bxs">
          <div class="inner">
            <h3 id="gps_new_arrival_subdealer">
              <div class="loader"></div>
            </h3>
            <p>GPS New Arrivals</p>
          </div>
          <div class="icon">
            <i class="fa fa-tablet"></i>
          </div>
          <a href="/gps-subdealer-new" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6 gps_dashboard_grid dash_grid">
      <!-- small box -->
        <div class="small-box bg-green bxs">
          <div class="inner">
            <h3 id="total_gps_subdealer">
              <div class="loader"></div>
            </h3>
            <p>Total GPS </p>
          </div>
          <div class="icon">
            <i class="fa fa-tablet"></i>
          </div>
          <a href="/gps-sub-dealer" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6 transferred_gps_dashboard_grid dash_grid">
        <!-- small box -->
        <div class="small-box bg-green bxs">
          <div class="inner">
            <h3 id="transferred_gps_subdealer">
              <div class="loader"></div>
            </h3>
            <p>Transferred GPS</p>
          </div>
          <div class="icon">
            <i class="fa fa-tablet"></i>
          </div>
          <a href="/gps-transfers-subdealer" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6 client_dashboard_grid dash_grid">
        <!-- small box -->
        <div class="small-box bg-blue bxs">
          <div class="inner">
            <h3 id="subdealer_client">
              <div class="loader"></div>
            </h3>
            <p>Active Clients</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="/clients" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 col-xs-6">
        <canvas id="rootChart" style="max-width: 100%;" ></canvas>  
      </div>
      <div class="col-lg-6 col-xs-6">
        <canvas id="rootChartUser" style="max-width: 100%;" ></canvas>  
      </div>
    </div>
  </div>
</div>
@endrole
<!-- SUB DEALER ROLE-END -->

<!-- SERVICER ROLE-START -->
@role('servicer')
<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <section class="content">
      <div class="row">
        <div class="col-lg-3 col-xs-6 gps_dashboard_grid dash_grid">
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="pending_jobs">
                <div class="loader"></div>
              </h3>
              <p>NEW JOBS</p>
            </div>
            <div class="icon">
              <i class="fa fa-tablet"></i>
            </div>
            <a href="/job-list" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6 dealer_dashboard_grid dash_grid" >
          <div class="small-box bg-yellow bxs">
            <div class="inner">
              <h3 id="completed_jobs">
                <div class="loader"></div>
              </h3>
              <p>COMPLETED JOBS</p>
            </div>
            <div class="icon">
              <i class="fa fa-tablet"></i>  
            </div>
              <a href="/job-history-list" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
@endrole
<!-- SERVICER ROLE-END -->


<!-- SCHOOL ROLE-START -->
@role('school')


<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 full-height">
      <div id="map" style="width:100%; height:100%;"></div>
    </div>
    <!-- <div class="left-bottom-car-details"><img class="left-bottom-car-details-img" src="assets/images/main-car.png"></div> -->
    <div class="pageContainer" style="overflow: scroll">
      <div class="col-lg-12">
        <div class="st-actionContainer right-bottom" >
          <div class="st-panel">
            <!-- <div class="st-panel-header"><i class="fa fa-bars" aria-hidden="true"></i> 
              <img src="assets/images/logo1.png" style="width:50px;height:20px;"/>
            </div> -->
            <div class="st-panel-contents" id="vehicle_card_cover" style="overflow:auto;">
              @foreach ($vehicles as $vehicle) 

                <div class="border-card">
                  <div class="card-type-icon with-border">
                  <input type="radio" id="radio" id="gpsid{{ $loop->iteration }}" class="vehicle_gps_id" name="radio" onclick="getVehicle({{$vehicle->gps_id}})" value="{{$vehicle->gps_id}}">
                  </div>
                  <div class="content-wrapper">
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
          <div class="right-bottom">
            <div class="st-button-main">
              <img class="left-bottom-car-details-img" src="assets/images/stearing.png" width="66px">
            </div>
          </div>

          @role('fundamental|superior|pro|school')
          <div class="right-bottom2">
            <form  onsubmit="return locationSearch();" >
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
          </div>

          <div id="myModal" class="modal_for_dash">
            <!-- Modal content -->
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
    </div>
    <div class="dashboard-main-Right cover_vehicle_track_list">
      <div class="iconsbg1234">
        <div class="col-md-6 col-lg-2 col-xlg-3 cover_track_data" onclick="moving('M')">
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
        <div class="col-md-6 col-lg-2 col-xlg-3 cover_track_data" onclick="moving('H')">
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
                <!-- <h5 class="text-white">Halt</h5> -->
              </span>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-2 col-xlg-3 cover_track_data" onclick="moving('S')">
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
        <div class="col-md-6 col-lg-2 col-xlg-3 cover_track_data" onclick="moving('O')">
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
                <img src="assets/images/network-status.png" id="network_online">
                <img src="assets/images/no-network.png" id="network_offline" style="display: none;">
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


@endrole
<!-- SCHOOL ROLE-END -->





<!-- CLIENT ROLE-START -->
@role('client')
<input type="hidden" id="lat" name="lat" value="{{$client->latitude}}">
<input type="hidden" id="lng" name="lng" value="{{$client->longitude}}">
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 full-height">
      <div id="map" style="width:100%; height:100%;"></div>
    </div>
    <!-- <div class="left-bottom-car-details"><img class="left-bottom-car-details-img" src="assets/images/main-car.png"></div> -->
    <div class="pageContainer">
      <div class="col-lg-12">
        <div class="st-actionContainer right-bottom" >
          <div class="st-panel">
            <!-- <div class="st-panel-header"><i class="fa fa-bars" aria-hidden="true"></i> 
              <img src="assets/images/logo1.png" style="width:50px;height:20px;"/>
            </div> -->
            <div class="st-panel-contents" id="vehicle_card_cover">
              @foreach ($vehicles as $vehicle)       
                <div class="border-card">
                  <div class="card-type-icon with-border">
                  <input type="radio" id="radio" id="gpsid{{ $loop->iteration }}" class="vehicle_gps_id" name="radio" onclick="getVehicle({{$vehicle->gps_id}})" value="{{$vehicle->gps_id}}">
                  </div>
                  <div class="content-wrapper">
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
          <div class="right-bottom">
            <div class="st-button-main">
              <img class="left-bottom-car-details-img" src="assets/images/stearing.png" width="66px">
            </div>
          </div>

          @role('fundamental|superior|pro|school')
          <div class="right-bottom2">
            <form  onsubmit="return locationSearch();" >
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
          </div>

          <div id="myModal" class="modal_for_dash">
            <!-- Modal content -->
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
    </div>
    <div class="dashboard-main-Right cover_vehicle_track_list">
      <div class="iconsbg1234">
        <div class="col-md-6 col-lg-2 col-xlg-3 cover_track_data" onclick="moving('M')">
          <!-- <div class="card card-hover"> -->
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
        <div class="col-md-6 col-lg-2 col-xlg-3 cover_track_data" onclick="moving('H')">
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
                <!-- <h5 class="text-white">Halt</h5> -->
              </span>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-2 col-xlg-3 cover_track_data" onclick="moving('S')">
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
        <div class="col-md-6 col-lg-2 col-xlg-3 cover_track_data" onclick="moving('O')">
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
                <img src="assets/images/network-status.png" id="network_online">
                <img src="assets/images/no-network.png" id="network_offline" style="display: none;">
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
  @endrole
  <!-- CLIENT ROLE-END -->
</div>
</section>
@section('script')

<script src="{{asset('js/gps/mdb.js')}}"></script>
<script src="{{asset('js/gps/dashb.js')}}"></script>
@role('client')
<script src="{{asset('js/gps/dashb-client.js')}}"></script>
<script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&libraries=places&callback=initMap"></script>
<script type="text/javascript">

</script>
<script src="{{asset('js/gps/GoogleRadar.js')}}"></script>

<script src="{{asset('dist/js/st.action-panel.js')}}"></script>
<style type="text/css">
  .container-fluid {padding-left: 0px !important}
</style>
@endrole

@role('school')
<script src="{{asset('js/gps/dashb-client.js')}}"></script>
<script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&libraries=places&callback=initMap"></script>
<script type="text/javascript">

</script>
<script src="{{asset('js/gps/GoogleRadar.js')}}"></script>

<script src="{{asset('dist/js/st.action-panel.js')}}"></script>
<style type="text/css">
  .container-fluid {padding-left: 0px !important}
</style>
@endrole




@role('root')
<script src="{{asset('js/gps/dash-root.js')}}"></script>
@endrole

@role('dealer')
<script src="{{asset('js/gps/dash-dealer.js')}}"></script>
@endrole

@role('sub_dealer')
<script src="{{asset('js/gps/dash-sub-dealer.js')}}"></script>
@endrole

@endsection
@endsection