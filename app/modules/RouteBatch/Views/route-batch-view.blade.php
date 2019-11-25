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
     </ol>
    </nav>
    <div class="row">
      <div class="col-lg-5 col-md-5">
        <table class="table table-bordered  table-striped " style="width:100%">
          <thead>
            <tr>
              <th>Sl.No</th>
              <th>Student ID</th>
              <th>Name</th>
              <th>Parent Name</th>
              <th>Contact No.</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($students as $student)
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>{{$student->code}}</td>
              <td>{{$student->name}}</td>
              <td>{{$student->parent_name}}</td>
              <td>{{$student->mobile}}</td>
              <?php $latitude=$student->latitude; $longitude=$student->longitude; ?>
              <td><button onclick="panToMap({{$student->id}})" class='btn btn-xs btn-success'>Location</button></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div> 
      <div class="col-lg-1 col-md-1">
      </div> 
      <div class="col-lg-6 col-md-6">
        <div id="map" style=" width:100%;height:520px; margin-top:10px;"></div> 
      </div>  
    </div>    
</div>

@endsection

  @section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&libraries=drawing&callback=initMap" async defer></script>
    <script>        
    
      var lat;
      var lng;
      var map;            
      <?php if($route_batch){ ?> 
        lat= <?php echo $route_area[0]['latitude']; ?>;
        lng=<?php echo $route_area[0]['longitude']; ?>;
      <?php }else{ ?>
        lat=10.014550;
        lng=76.293159;
      <?php } ?>
      var marker;
      var i;
      var start ='';
      var stop ='';
      var LastLatLng;
      var markers = [];

      function initMap() { 
        map = new google.maps.Map(document.getElementById('map'), {
         zoom: 13,
        center: {lat: lat, lng: lng}
        });
        map.setOptions({ minZoom:5, maxZoom: 17 });
        LoadMap();
      }

      function LoadMap() { 
        <?php 
          $dataPacket=[];
          $dataPacketStudent=[];
          foreach ($route_area as $locData) {
            $intLat=floatval($locData['latitude']);
            $intLng=floatval($locData['longitude']);
            $dataPacket[]=array("lat"=>$intLat,"lng"=>$intLng);
          }
          $jsondata=json_encode($dataPacket);
          foreach ($students as $student_data) {
            $intLatStudent=floatval($student_data['latitude']);
            $intLngStudent=floatval($student_data['longitude']);
            $studentCode=$student_data['code'];
            $studentName=$student_data['name'];
            $dataPacketStudent[]=array("lat"=>$intLatStudent,"lng"=>$intLngStudent,"code" =>$studentCode,"name" =>$studentName);
          }
          $studentjsondata=json_encode($dataPacketStudent);
        ?>

        var flightPlanCoordinates =<?php echo $jsondata;?>;
        var StudentPlaceCoordinates =<?php echo $studentjsondata;?>;
        var flightPath = new google.maps.Polyline({
          path: flightPlanCoordinates,
          geodesic: true,
          strokeColor: '#1F618D',
          strokeOpacity: 0.5,
          strokeWeight: 7
        });

        flightPath.setMap(map);

        for (var i = 0, length = StudentPlaceCoordinates.length; i < length; i++) {
          var data = StudentPlaceCoordinates[i],
          latLng = new google.maps.LatLng(data.lat, data.lng); 
          // Creating a marker and putting it on the map
          var marker = new google.maps.Marker({
            position: latLng,
            map: map,
            title:data.name
          }); 
        }  
            
      }
      $(function(){
        initMap();
      });

      function panToMap(student_id){
        var url = 'route-batch/pan-to-map';
        var data = {
            id : student_id
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true});  
      }
    </script>
  @endsection