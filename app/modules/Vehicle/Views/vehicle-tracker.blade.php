@extends('layouts.eclipse')

@section('content')
<section class="content box">
<div class="page-wrapper_new_map">
  <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Live Track</li>
         </ol>
          @if(Session::has('message'))
            <div class="pad margin no-print">
               <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                  {{ Session::get('message') }}  
               </div>
            </div>
            @endif  
        </nav>

  


  <div class="row">
    <div class="col-lg-12 col-sm-12">
      <input type="hidden" name="vid" id="vehicle_id_data" value="{{$Vehicle_id}}">
       <input type="hidden" name="svg_con" id="svg_con" value="{{$vehicle_type->svg_icon}}">
       <input type="hidden" name="vehicle_scale" id="vehicle_scale" value="{{$vehicle_type->vehicle_scale}}">
        <input type="hidden" name="opacity" id="opacity" value="{{$vehicle_type->opacity}}">
         <input type="hidden" name="strokeWeight" id="strokeWeight" value="{{$vehicle_type->strokeWeight}}">
       <input type="hidden" name="lat" id="lat" value="{{$latitude}}">
       <input type="hidden" name="lng" id="lng" value="{{$longitude}}">
                      
                        <div class="card data_list_cover pull-right" style="width: 16rem;">
                            <div class="card-body data_list_body">
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
                        <span id="offline" style="display: none;font-size: 13px;">
                            <i class="fa fa-circle" style="color:red;" aria-hidden="true"></i> Last seen <span id="last_seen"></span>
                        </span>
                      </div>


                        <div class="col-sm-12 social-buttons">
                            <a class="btn btn-block btn-social btn-bitbucket track_item">
                                <i class="fa fa-car"></i><label id="vehicle_name"></label></a>

                            <a class="btn btn-block btn-social btn-bitbucket track_item">
                                <i class="fa fa-key"></i> <b><label id="ignition"></label></b>
                            </a>
                            <a class="btn btn-block btn-social btn-bitbucket track_item">
                                <i class="fa fa-tachometer"></i> <b><label id="car_speed"></label></b> K.M/H
                            </a>
                            <a class="btn btn-block btn-social btn-bitbucket track_item">
                                <i class="fa fa-battery-full"></i><b><label id="car_bettary"></label></b>%
                            </a>
                            <a class="btn btn-block btn-social btn-bitbucket track_item">
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
                         </b>
                  </div>
                 

              </div>
          </div>

           <div class="share_button">
                     <!--These buttons are created by frinmash.blogspot.com,frinton madtha--> <div id="share-buttons"> <!-- Facebook --> <a href="https://www.facebook.com/sharer.php?u=https://www.google.com/maps/search/?api=1&query=36.26577,-92.54324" target="_blank"><img src="https://4.bp.blogspot.com/-raFYZvIFUV0/UwNI2ek6i3I/AAAAAAAAGSA/zs-kwq0q58E/s1600/facebook.png" alt="Facebook" /></a> <!-- Twitter --> <a href="https://twitter.com/share?url=https://www.google.com/maps/search/?api=1&query=36.26577,-92.54324&text=Simple Share Buttons" target="_blank"><img src="https://4.bp.blogspot.com/--ISQEurz3aE/UwNI4hDaQMI/AAAAAAAAGS4/ZAgmPiM9Xpk/s1600/twitter.png" alt="Twitter" /></a> <!-- Google+ --> <a href="https://plus.google.com/share?url=https://www.google.com/maps/search/?api=1&query=36.26577,-92.54324" target="_blank"><img src="https://2.bp.blogspot.com/-9ijXNtKTaSk/UwNI3ANT4MI/AAAAAAAAGSY/Tu4kE8x9SnI/s1600/google.png" alt="Google" /></a><!-- LinkedIn --> <a href="https://www.linkedin.com/shareArticle?mini=true&url=https://www.google.com/maps/search/?api=1&query=36.26577,-92.54324" target="_blank"><img src="https://2.bp.blogspot.com/-3_cATk7Wlho/UwNI3eoTTLI/AAAAAAAAGSQ/Y8cpq6S-SeQ/s1600/linkedin.png" alt="LinkedIn" /></a> 
                      <a href="mailto:?Subject=FrinMash&Body=I%20saw%20this%20and%20thought%20of%20you!%20 https://www.google.com/maps/search/?api=1&query=36.26577,-92.54324"><img src="https://4.bp.blogspot.com/-njgKtNLrPqI/UwNI2o-9WfI/AAAAAAAAGR4/f8da1gBgyLs/s1600/email.png" alt="Email" /></a>
                      <!-- watsapp -->

                      <a href="https://web.whatsapp.com/send?text=https://www.google.com/maps/search/?api=1&query=36.26577,-92.54324" data-action="share/whatsapp/share"><img src="https://4.bp.blogspot.com/-njgKtNLrPqI/UwNI2o-9WfI/AAAAAAAAGR4/f8da1gBgyLs/s1600/email.png" alt="Email" /></a>

                   
                      </div>
                  </div>

        <div id="map" class="live_track_map" style="width:100%;height:500px;"></div>
    </div>
    </div>

  </div>
</section>

@section('script')

<script src="{{asset('js/gps/location-track.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap" async defer></script>
@endsection

@endsection