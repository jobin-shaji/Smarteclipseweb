@extends('layouts.gps')

@section('content')

<section class="content-header">
    <h1>
        Live Track
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Live Track</li>
    </ol>
</section>
<input type="hidden" name="vid" id="vehicle_id" value="{{$Vehicle_id}}">
<section class="content box">
  <div class="row">
    <div class="col-lg-12 col-sm-12">
        
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h2 class="card-title" id="user"></h2>

                <p>
                    <b>
                    </b></p>
                     <div class="cover_ofline"><b>
                      <div class="cover_status"> 
                        <span id="online" style="display: none;">
                            <i class="fa fa-circle" style="color:green;" aria-hidden="true"></i> Online
                        </span>
                        <span id="halt" style="display: none;">
                            <i class="fa fa-circle" style="color:yellow;" aria-hidden="true"></i> Halt
                        </span>
                        <span id="sleep" style="display: none;">
                            <i class="fa fa-circle" style="color:orange;" aria-hidden="true"></i> Sleep
                        </span>
                        <span id="ofline" style="display: none;">
                            <i class="fa fa-circle" style="color:red;" aria-hidden="true"></i> Offline
                        </span>
                      </div>


                        <div class="col-sm-12 social-buttons">
                            <a class="btn btn-block btn-social btn-bitbucket">
                                <i class="fa fa-car"></i><label id="vehicle_name"></label></a>

                            <a class="btn btn-block btn-social btn-bitbucket">
                                <i class="fa fa-key"></i> <b><label id="ignition"></label></b>
                            </a>
                            <a class="btn btn-block btn-social btn-bitbucket">
                                <i class="fa fa-tachometer"></i> <b><label id="car_speed"></label></b> K.M/H
                            </a>
                            <a class="btn btn-block btn-social btn-bitbucket">
                                <i class="fa fa-battery-full"></i><b><label id="car_bettary"></label></b>%
                            </a>
                            <a class="btn btn-block btn-social btn-bitbucket">
                                <i class="fa fa-plug"></i>
                                <span id="car_charging">
                                    <?php 
                                      $plug_Status=1; 
                                      if($plug_Status==1){ ?>
                                    <i class="fa fa-check"></i>
                                    <?php }else{ ?>
                                    <i class="fa fa-times"></i>
                                    <?php } ?>
                                </span>
                            </a>

                            <div class="viewmore_location">
                                <i class="fa fa-map-marker"></i>-<b><span id="car_location"></span></b>
                            </div>

                            <hr>
                        </div>
                  </div>
              </div>
          </div>

        <div id="map" style="width:100%;height:500px;"></div>
    </div>
    </div>
</section>

@section('script')

<script src="{{asset('js/gps/location-track.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap" async defer></script>
@endsection

@endsection