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

  <section class="content">
    <div class="col-lg-12 col-sm-12">
                      
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                              <h2 class="card-title">1</h2>
                                
                                <p>
                                <b>  
                                  </b></p><div class="cover_ofline"><b>
                                  <span id="online_status">
                                    <?php $online_status="M";
                                      if($online_status=="M"){ ?>
                                        <i class="fa fa-circle" style="color:green;" aria-hidden="true"></i> Online
                                      <?php } elseif($online_status=="H") { ?>
                                        <i class="fa fa-circle" style="color:yellow;" aria-hidden="true"></i> Halt
                                      <?php } elseif($online_status=="S"){ ?>
                                        <i class="fa fa-circle" style="color:orange;" aria-hidden="true"></i> Sleep
                                      <?php } else{ ?>
                                        <i class="fa fa-circle" style="color:red;" aria-hidden="true"></i> Offline
                                      <?php } ?>
                                  </span>
                           
                                 <div class="col-sm-12 social-buttons">
                                   <a class="btn btn-block btn-social btn-bitbucket">
                                      <i class="fa fa-car"></i><?php echo "245"; ?></a>
                                    <a class="btn btn-block btn-social btn-bitbucket">
                                      <i class="fa fa-key"></i> <b>
                                        <span id="ignition">
                                          <?php $ignition_status=1;
                                          if($ignition_status==1){ ?>Ignition On
                                          <?php } else{ ?> Ignition Off
                                          <?php } ?>
                                        </span></b>
                                    </a>
                                    
                                    <a class="btn btn-block btn-social btn-bitbucket">
                                      <i class="fa fa-tachometer"></i> <b><span id="car_speed"><?php echo 10; ?></span></b> K.M/H
                                    </a>
                                    <a class="btn btn-block btn-social btn-bitbucket">
                                      <i class="fa fa-battery-full"></i><b><span id="car_bettary"><?php echo 10; ?></span></b>%
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
                                      <i class="fa fa-map-marker"></i>-<b><span id="car_location"><?php echo "////"; ?></span></b>
                                   </div>

                                    <hr>

                                    
                                  </div>
                                  </div>

                            </div>
                            </div> 

                        <div id="map" style="width:100%;height:500px;"></div>

                        </div>
  </section>

    @section('script')
      
  
   <script src="{{asset('js/gps/location-track.js')}}"></script>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap"
         async defer></script>
    @endsection

@endsection