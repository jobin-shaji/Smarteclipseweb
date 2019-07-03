@extends('layouts.eclipse')
@section('content')
@role('root')
<section class="content-header">
   <h1>
      Dashboard
      <small>Control panel</small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
   </ol>
</section>
<section class="content">
   <div class="row">
      <div class="col-lg-3 col-xs-6">
         <!-- small box -->
         <div class="small-box bg-green bxs">
            <div class="inner">
               <h3 id="gps">
                  <div class="loader"></div>
               </h3>
               <p>GPS</p>
            </div>
            <div class="icon">
               <i class="fa fa-tablet"></i>
            </div>
            <a href="/gps" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
         </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
         <!-- small box -->
         <div class="small-box bg-yellow bxs">
            <div class="inner">
               <h3 id="dealer">
                  <div class="loader"></div>
               </h3>
               <p>Dealers</p>
            </div>
            <div class="icon">
               <i class="ion ion-person-add"></i>
            </div>
            <a href="/dealers" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
         </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
         <!-- small box -->
         <div class="small-box bg-blue bxs">
            <div class="inner">
               <h3 id="sub_dealer">
                  <div class="loader"></div>
               </h3>
               <p>Sub Dealers</p>
            </div>
            <div class="icon">
               <i class="ion ion-person-add"></i>
            </div>
            <a href="/sub-dealers" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
         </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
         <!-- small box -->
         <div class="small-box bg-green bxs">
            <div class="inner">
               <h3 id="client">
                  <div class="loader"></div>
               </h3>
               <p>Clients</p>
            </div>
            <div class="icon">
               <i class="ion ion-person-add"></i>
            </div>
            <a href="/client" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
         </div>
      </div>
      <!-- ./col -->
      <a href="">
         <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
               <span class="info-box-icon bg-blue"><i class="ion ion-ios-gear-outline"></i></span>
               <div class="info-box-content">
                  <span class="info-box-text">Vehicle</span>
                  <span class="info-box-number" id="stages">
                     <h3 id="vehicle">
                        <div class="loader"></div>
                     </h3>
                  </span>
               </div>
            </div>
            <!-- /.info-box -->
         </div>
      </a>
   </div>
</section>
<!-- ./col -->
@endrole
@role('dealer')
<div class="page-wrapper">
<div class="page-breadcrumb">
   <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
         <h4 class="page-title">Dashboard</h4>
         @if(Session::has('message'))
         <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
               {{ Session::get('message') }}  
            </div>
         </div>
         @endif
      </div>
   </div>
</div>
<div class="container-fluid">
   <div class="card-body">
      <div class="table-responsive">
         <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
            <div class="row">
               <div class="col-sm-12">
                  <div class="row">
                     <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green bxs">
                           <div class="inner">
                              <h3 id="gps_dealer">
                                 <div class="loader"></div>
                              </h3>
                              <p>GPS</p>
                           </div>
                           <div class="icon">
                              <i class="fa fa-tablet"></i>
                           </div>
                           <a href="/gps-dealer" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                     </div>
                     <!-- ./col -->
                     <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-yellow bxs">
                           <div class="inner">
                              <h3 id="dealer_subdealer">
                                 <div class="loader"></div>
                              </h3>
                              <p>Sub Dealers</p>
                           </div>
                           <div class="icon">
                              <i class="ion ion-person-add"></i>
                           </div>
                           <a href="/subdealers" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
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
@role('sub_dealer')
<div class="col-lg-3 col-xs-6">
   <!-- small box -->
   <div class="small-box bg-green bxs">
      <div class="inner">
         <h3 id="subdealer_gps">
            <div class="loader"></div>
         </h3>
         <p>GPS</p>
      </div>
      <div class="icon">
         <i class="fa fa-tablet"></i>
      </div>
      <a href="/gps-transfers" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
   </div>
</div>
<!-- ./col -->
<div class="col-lg-3 col-xs-6">
   <!-- small box -->
   <div class="small-box bg-blue bxs">
      <div class="inner">
         <h3 id="subdealer_client">
            <div class="loader"></div>
         </h3>
         <p>Client</p>
      </div>
      <div class="icon">
         <i class="ion ion-person-add"></i>
      </div>
      <a href="/clients" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
   </div>
</div>
@endrole
<!-- -----------------------------------------------------------------------------   -->
@role('client')

   <div class="container-fluid">
      <div class="row">




         <!-- ============================================================== -->
          

            <div class="col-md-12 full-height">
               <div id="map" style="width:100%; height:100%;"></div>
            </div>

              

            <!-- <div class="left-bottom-car-details"><img class="left-bottom-car-details-img" src="assets/images/main-car.png"></div> -->
            <div class="pageContainer">

              <div class="col-lg-12">
               <div class="st-actionContainer right-bottom">
                  <div class="st-panel">
                     <div class="st-panel-header"><i class="fa fa-bars" aria-hidden="true"></i> 
                        <img src="assets/images/logo1.png" style="width:50px;height:20px;"/>
                     </div>
                     <div class="st-panel-contents" style="overflow:auto;">

                     @foreach ($vehicles as $vehicle)       
                    <div class="border-card">

                   <div class="card-type-icon with-border">
                    <input type="radio" id="radio" class="vehicle_gps_id" name="radio" onclick="getVehicle({{$vehicle->gps_id}})" value="{{$vehicle->gps_id}}">
                   </div>
                  <div class="content-wrapper">
                      <div class="label-group fixed">
                      <p class="title">
                        <span><i class="fa fa-car"></i></span>
                      </p>
                      <p class="caption">{{$vehicle->name}}</p>
                      </div>
                      <div class="min-gap"></div>
                  <div class="label-group">
                      <p class="title">
                        <span><i class="fas fa-arrow-alt-circle-left"></i></span>
                      </p>

                      <p class="caption">{{$vehicle->register_number}}</p>
                  </div>
                  <div class="min-gap"></div>
                  <div class="label-group">
                       <p class="title">
                        <span><i class="fas fa-tachometer-alt"></i></span>
                       </p>
                      <p class="caption">80</p>
                  </div>

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

                    <div class="right-bottom2">
                     
                       <form  onsubmit="return locationSearch();" >
                      <div class="col-lg-12 col-md-12">
                       <div class="container-fluid bg-light map_search">
                       <div class="row align-items-center justify-content-center">
                              <div class="col-lg-4 col-md-4 ">
                                     <div class="form-group">
                                        <input type="text" id="search_place" class="form-control">
                                     </div>
                                  </div>
                                  <div class="col-lg-4 col-md-4 ">
                                      <div class="form-group">
                                        <select id="search_radius" class="form-control">
                                          <option selected>KM</option>
                                          <option>10 KM</option>
                                          <option>30 KM</option>
                                          <option>50 KM</option>
                                          <option>75 KM</option>
                                          <option>100 KM</option>
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
                     <div class="right-bottom3">
                        <div class="driver_image" id="diver_behavior">
                          <img src="assets/images/driver_dash.png">
                        </div>
                     </div>
                     
                      <div id="myModal" class="modal_for_dash">
                       <!-- Modal content -->
                           <div class="modal-content">
                              <div class="modal-header">
                                <span class="close">×</span>
                                
                          <div class="container">  
                            <div class="container">
                              <canvas id="myChart" style="max-width: 500px;"></canvas>
                          </div>
                          </div>
                          </div>
                          </div>
                          
                       <!-- Modal content -->
                        </div>

               </div>
              </div>



            </div>
            <div class="dashboard-main-Right">
               <div class="iconsbg1234">
                  <div class="col-md-6 col-lg-2 col-xlg-3">
                     <div class="card card-hover">
                        <div class="box bg-cyan1234 text-center">
                           <h1 class="font-light text-white"></h1>
                           <h1 class="text-white" style="color:#129a00!important">
                            <!-- <img src="assets/images/moving.png" style="width:100%"> -->
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                            
                           </h1>
                           <span style="float:left;width:100%">
                           <h1 id="moving" class="text-white" style="font-size:26px;color:#fab03a!important">36</h1>
                           <!--  <h5 class="text-white">MOVING</h5></span> -->
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 col-lg-2 col-xlg-3">
                     <div class="card card-hover">
                        <div class="box bg-cyan1234 text-center">
                           <h1 class="font-light text-white"></h1>
                           <h1 class="text-white" style="color: #0077ae!important">
                           <!--  <img src="assets/images/idling.png" style="width:100%"> -->
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                          </h1>
                           <span style="float:left;width:100%">
                           <h1  id="idle" class="text-white" style="font-size:26px;color:#fab03a!important"></h1>
                           <!-- <h5 class="text-white">IDLE</h5></span> -->
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 col-lg-2 col-xlg-3">
                     <div class="card card-hover">
                        <div class="box bg-cyan1234 text-center">
                           <h1 class="font-light text-white"></h1>
                           <h1 class="text-white" style="color: #999!important">
                            <!-- <img src="assets/images/delayed.png" style="width:100%"> -->
                            <i class="fa fa-map-marker" aria-hidden="true"></i>

                           </h1>
                           <span style="float:left;width:100%">
                           <h1 id="stop"  class="text-white" style="font-size:26px;color:#fab03a!important"></h1>
                           <!-- <h5 class="text-white">DELAY</h5></span> -->
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 col-lg-2 col-xlg-3">
                     <div class="card card-hover">
                        <div class="box bg-cyan1234 text-center">
                           <h1 class="font-light text-white"></h1>
                           <h1 class="text-white" style="color:#fc4343!important">
                            <!-- <img src="assets/images/stopped.png" style="width:100%"> -->
                            <i class="fa fa-map-marker" aria-hidden="true"></i>

                           </h1>
                           <span style="float:left;width:100%">
                           <h1  class="text-white" style="font-size:26px;color:#fab03a!important">0</h1>
                           <!--  <h5 class="text-white">STOPPED</h5></span> -->
                        </div>
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
                            <h4 class="m-b-0 m-t-5">Network Status</h4>
                             <medium id="network_status" class="font-light">
                              <i class="fa fa-spinner" aria-hidden="true"></i>

                        </div>
                        <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%;border-radius: 0 20px 0 0;" >
                           <img src="assets/images/fuel-status.png">
                           <h4 class="m-b-0 m-t-5">Fuel Status</h4>
                           <medium id="fuel_status" class="font-light">
                          <i class="fa fa-spinner" aria-hidden="true"></i>
                        </div>
                        <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%">
                           <img src="assets/images/speed.png">
                           <h4 class="m-b-0 m-t-5">Speed</h4>
                            <medium id="speed" class="font-light">
                           <i class="fa fa-spinner" aria-hidden="true"></i>
                        </div>
                        <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%">
                           <img src="assets/images/odometer.png">
                            <h4 class="m-b-0 m-t-5">Odometer</h4>
                             <medium id="odometer" class="font-light">
                             <i class="fa fa-spinner" aria-hidden="true"></i>
                        </div>
                        <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%">
                           <img src="assets/images/vehicle-status.png">
                            <h4 class="m-b-0 m-t-5">Vehicle Status</h4>
                            <medium id="mode" class="font-light">
                            <i class="fa fa-spinner" aria-hidden="true"></i>
                        </div>
                        <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%">
                           <img src="assets/images/sattelite.png">
                            <h4 class="m-b-0 m-t-5">Satellite</h4>
                            <medium id="satelite" class="font-light">
                           <i class="fa fa-spinner" aria-hidden="true"></i>
                        </div>
                        <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%">
                           <img src="assets/images/battery-status.png">
                            <h4 class="m-b-0 m-t-5">Battery Status</h4>
                            <medium id="battery_status" class="font-light">
                              <i class="fa fa-spinner" aria-hidden="true"></i>
                        </div>
                        <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%">
                           <img src="assets/images/towing-dash.png">
                            <h4 class="m-b-0 m-t-5">Towing</h4>
                            <medium class="font-light">
                              <i class="fa fa-spinner" aria-hidden="true"></i>
                        </div>
                       
                        <div class="bg-dark p-10 text-white text-center location_details" style="float: left;width:100%;border-radius: 0px 0px 8px 10px;">
                           <img src="assets/images/immobilizer.png">
                            <h4 class="m-b-0 m-t-5">Location</h4>
                              <medium id="address" class="font-light">
                             <i class="fa fa-spinner" aria-hidden="true"></i>
                        </div>
                    

                     </div>
                  </div>
               </div>
            </div>



         </div>
          <footer class="footer text-center">
    All Rights Reserved by VST Mobility Solutions. Designed and Developed by <a href="http://vstmobility.com">VST</a>.
  </footer>
      </div>
  
   @endrole
   <!-- ----------------------------------------------------------------------------- -->
</div>
</section>
@section('script')
<script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCOae8mIIP0hzHTgFDnnp5mQTw-SkygJbQ&libraries=places"></script>
<script src="{{asset('js/gps/dashb.js')}}"></script>
@role('client')
<script src="{{asset('js/gps/dashb-client.js')}}"></script>
<script src="{{asset('dist/js/st.action-panel.js')}}"></script>
<script src="{{asset('js/gps/mdb.js')}}"></script>
<style type="text/css">
  .container-fluid {padding-left: 0px !important}
</style>
@endrole
@endsection
@endsection