
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
              <h3 id="gps"><div class="loader"></div></h3>
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
               <h3 id="dealer"><div class="loader"></div></h3>
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
              <h3 id="sub_dealer"><div class="loader"></div></h3>
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
              <h3 id="client"><div class="loader"></div></h3>
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
                  <h3 id="vehicle"><div class="loader"></div></h3>
                </span>
              </div>
            </div>
            <!-- /.info-box -->
          </div>
        </a>
        <!-- ./col -->
  @endrole

   @role('dealer')
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner">              
              <h3 id="gps_dealer"><div class="loader"></div></h3>
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
               <h3 id="dealer_subdealer"><div class="loader"></div></h3>              
              <p>Sub Dealers</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="/subdealers" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->       
  @endrole
   @role('sub_dealer')

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="subdealer_gps"><div class="loader"></div></h3>              
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
              <h3 id="subdealer_client"><div class="loader"></div></h3>  
              <p>Client</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="/clients" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
   @endrole
   @role('client')
  <div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
      <!-- ============================================================== -->
      <!-- Sales Cards  -->
      <!-- ============================================================== -->
      <div class="row">
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d15714.260711999257!2d76.35214005!3d10.05269365!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1560837024158!5m2!1sen!2sin" width="100%" height="1200" frameborder="0" style="border:0" allowfullscreen></iframe>
          <div class="dashboard-main">
            <div class="iconsbg">          
              <div class="col-md-6 col-lg-4 col-xlg-3">
                <div class="card card-hover">
                  <div class="box bg-success text-center">
                    <h1 class="font-light text-white"></h1>
                    <h2 class="text-white">Summary</h2>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-2 col-xlg-3">
                <div class="card card-hover">
                  <div class="box bg-cyan text-center">
                    <h1 class="font-light text-white"></h1>
                    <h3 id="vehicle_motion">0<div class="loader"></div></h3>
                    <h4 class="text-white">Moving</h4>
                  </div>
                </div>
              </div>

 <div class="col-md-6 col-lg-2 col-xlg-3">
                        <div class="card card-hover">
                            <div class="box bg-cyan text-center">
                                <h1 class="font-light text-white"></h1>
                                <h3 id="idle">0<div class="loader"></div></h3>
                                <h4 class="text-white">Idling</h4>
                            </div>
                        </div>
                    </div>

 <div class="col-md-6 col-lg-2 col-xlg-3">
                        <div class="card card-hover">
                            <div class="box bg-cyan text-center">
                                <h1 class="font-light text-white"></h1>
                                 <h3 >0<div class="loader"></div></h3>
                                <h4 class="text-white">Delayed</h4>
                            </div>
                        </div>
                    </div>

 <div class="col-md-6 col-lg-2 col-xlg-3">
                        <div class="card card-hover">
                            <div class="box bg-cyan text-center">
                                <h1 class="font-light text-white"></h1>
                               <h3 id="stop">0<div class="loader"></div></h3>
                                <h4 class="text-white">Stopped</h4>
                            </div>
                        </div>
                    </div>
</div>
<div class="card" style="float:left;width:50%!important">

                            <table class="table" style="border:none!important;">
                                  <thead>
                                    <tr>
                                       <th scope="col"></th>
                                      
                                      <th scope="col">Vehicle Name</th>
                                      <th scope="col">Vehicle Number</th>
                                      <th scope="col">Dist. Covered</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                   <body>
                                   @foreach ($vehicles as $vehicle)
                                    <tr>
                                      <td><input type="radio" id="radio" name="radio" onclick="getVehicle({{$vehicle->gps_id}})" value="{{$vehicle->gps_id}}"></td>
                                      
                                       <td>{{$vehicle->register_number}}</td>
                                       <td>{{$vehicle->name}}</td>
                                        <td>80 </td>
                                    </tr>
                                      
                                      @endforeach  

                                  </tbody>
                            </table>
                        </div>
    <div class="iconsbg1"> 
      <div class="row">
        <div class="card card-hover" style="width:100%">
          <div class="box bg-success text-center">
            <h3 class="text-white" style="padding:3% 0 0!important;line-height:1">LIVE TRACK</h3>
          </div>
        </div>
        <div class="col-6 m-t-15" style="width:50%;float:left">
          <div class="bg-dark p-10 text-white text-center">
            <img src="assets/images/network-status.png">
              <h4 class="m-b-0 m-t-5">Network Status</h4>
            <medium id="network_status" class="font-light">
              <i class="fa fa-spinner" aria-hidden="true"></i>
            </medium>
          </div>
        </div>
        <div class="col-6 m-t-15"  style="width:50%;float:left">
          <div class="bg-dark p-10 text-white text-center">
            <img src="assets/images/fuel-status.png">
              <h4 class="m-b-0 m-t-5">Fuel Status</h4>
            <medium id="fuel_status" class="font-light">
              <i class="fa fa-spinner" aria-hidden="true"></i>
            </medium>
          </div>
        </div>
        <div class="col-6 m-t-15" style="width:50%;float:left">
          <div class="bg-dark p-10 text-white text-center">
            <img src="assets/images/speed.png">
              <h4 class="m-b-0 m-t-5">Speed</h4>
            <medium id="speed" class="font-light">
              <i class="fa fa-spinner" aria-hidden="true"></i>
            </medium>
          </div>
        </div>
        <div class="col-6 m-t-15" style="width:50%;float:left">
          <div class="bg-dark p-10 text-white text-center">
            <img src="assets/images/odometer.png">
              <h4 class="m-b-0 m-t-5">Odometer</h4>
            <medium id="odometer" class="font-light">
              <i class="fa fa-spinner" aria-hidden="true"></i>
            </medium>
          </div>
        </div>
        <div class="col-6 m-t-15" style="width:50%;float:left">
          <div class="bg-dark p-10 text-white text-center">
            <img src="assets/images/vehicle-status.png">
              <h4 class="m-b-0 m-t-5">Vehicle Status</h4>
            <medium id="mode" class="font-light">
              <i class="fa fa-spinner" aria-hidden="true"></i>
            </medium>
          </div>
        </div>
        <div class="col-6 m-t-15" style="width:50%;float:left">
          <div class="bg-dark p-10 text-white text-center">
            <img src="assets/images/sattelite.png">
              <h4 class="m-b-0 m-t-5">Satellite</h4>
            <medium id="satelite" class="font-light">
              <i class="fa fa-spinner" aria-hidden="true"></i>
            </medium>
          </div>
        </div>
        <div class="col-6 m-t-15" style="width:50%;float:left">
          <div class="bg-dark p-10 text-white text-center">
            <img src="assets/images/battery-status.png">
              <h4 class="m-b-0 m-t-5">Battery Status</h4>
            <medium id="battery_status" class="font-light">
              <i class="fa fa-spinner" aria-hidden="true"></i>
            </medium>
          </div>
        </div>
        <div class="col-6 m-t-15" style="width:50%;float:left">
          <div class="bg-dark p-10 text-white text-center">
            <img src="assets/images/towing-dash.png">
              <h4 class="m-b-0 m-t-5">Towing</h4>
            <medium class="font-light">
              <i class="fa fa-spinner" aria-hidden="true"></i>
            </medium>
          </div>
        </div>
        <div class="col-6 m-t-15" style="width:50%;float:left">
          <div class="bg-dark p-10 text-white text-center">
            <img src="assets/images/immobilizer.png">
              <h4 class="m-b-0 m-t-5">Immobilizer</h4>
            <medium class="font-light">
              <i class="fa fa-spinner" aria-hidden="true"></i>
            </medium>
          </div>
        </div>
        <div class="col-6 m-t-15" style="width:50%;float:left">
          <div class="bg-dark p-10 text-white text-center">
          <img src="assets/images/location.png">
          <h4 class="m-b-0 m-t-5">Location</h4>
          <medium id="address" class="font-light">
            <i class="fa fa-spinner" aria-hidden="true"></i>
          </medium>
          </div>
        </div>
      </div>     
    </div>

                </div>
                  <!-- Column -->
                </div>
                <!-- ============================================================== -->
                <!-- Sales chart -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-md-12">
                      
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Sales chart -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Recent comment and chats -->
                <!-- ============================================================== -->
                               <!-- ============================================================== -->
                <!-- Recent comment and chats -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
          
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
  @endrole

</div>
      
</section>
  @section('script')
      <script src="{{asset('js/gps/dashb.js')}}"></script>
  @endsection

@endsection