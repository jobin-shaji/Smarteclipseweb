@extends('layouts.eclipse')
@section('title')
  View Route
@endsection
@section('content')

<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper_new_map">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Route View</li>
        <b>Route View</b>
     </ol>
    </nav>
    <div class="row">
      <div class="col-md-4">
        <label>Route Name : {{$route->name}}</label>
      </div>
      <div class="col-md-4">
        <label>Created By : {{$route->client->name}}</label>
      </div>
      <div class="col-md-4">
        <label>Created On : {{$route->created_at}}</label>
      </div>
    </div>

    <div id="map" style=" width:100%;height:520px; margin-top:10px;"></div>       

  </div>


@endsection

  @section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&libraries=drawing&callback=initMap" async defer></script>
    <script>        
    
    var lat;
    var lng;
    var map;
                  
       <?php if($route){ ?> 
          lat= <?php echo $route_area[0]['latitude']; ?>;
          lng=<?php echo $route_area[0]['longitude']; ?>;
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
        map.setOptions({ minZoom:5, maxZoom: 17 });


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
            foreach ($route_area as $locData) {
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