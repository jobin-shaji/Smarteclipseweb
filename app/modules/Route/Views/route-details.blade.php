@extends('layouts.gps') 
@section('title')
   Route View
@endsection
@section('content')
    <section class="content-header">
     <h1>Route View</h1>
    </section>
    @if(Session::has('message'))
    <div class="pad margin no-print">
      <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
      </div>
    </div>
    @endif  
  <section class="content">
    <div class="row">
      <div class="col-lg-12 col-sm-12">  
        <div id="map" style=" width:100%;height:500px;"></div>
      </div>                             
    </div>
  </section>
  @section('script')
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap" async defer></script>
    <script>        
    
    var lat;
    var lng;
    var map;
                  
       <?php if($route){ ?> 
          lat= <?php echo $route->routeArea[0]['latitude']; ?>;
          lng=<?php echo $route->routeArea[0]['longitude']; ?>;
          <?php }else{ ?>
            lat=10.014550;
            lng=76.293159;
          <?php } ?>
 
                  var marker;
                  var start ='';
                  var stop ='';
                  var LastLatLng;
                  var markers = [];

      function initMap() { 
        map = new google.maps.Map(document.getElementById('map'), {
         zoom: 17,
        center: {lat: lat, lng: lng}
        });

        var myLatLng = {lat: lat, lng: lng};
        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          icon: start 
        });

        LoadMap();
      
      }

      function LoadMap() { 
          <?php 
            $dataPacket=[];
            foreach ($route->routeArea as $locData) {
              $intLat=floatval($locData['latitude']);
              $intLng=floatval($locData['longitude']);
              $dataPacket[]=array("lat"=>$intLat,"lng"=>$intLng);

              $lastLat=$locData['latitude'];
              $lastLng=$locData['longitude'];

            }

             $jsondata=json_encode($dataPacket); 


          ?>

          var lastLat=<?php  echo $lastLat;?>;
          var lastLng=<?php  echo $lastLng;?>;
          
         var flightPlanCoordinates =<?php echo $jsondata;?>;

        var flightPath = new google.maps.Polyline({
          path: flightPlanCoordinates,
          geodesic: true,
          strokeColor: '#1F618D',
          strokeOpacity: 0.5,
          strokeWeight: 7
        });

        flightPath.setMap(map);  

           var LastLatLng = {lat: lastLat, lng: lastLng};
           var marker = new google.maps.Marker({
            position: LastLatLng,
            map: map,
            icon:stop
          });     
        }
      $(function(){
        initMap();
      });
    </script>
    @endsection
    @endsection
