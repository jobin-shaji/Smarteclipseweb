function getUrl() {
    return $('meta[name = "domain"]').attr('content');
}
 var vehiclePath = document.getElementById('svg_con').value;
 var start_lat = document.getElementById('lat').value;
 var start_lng = document.getElementById('lng').value;
 var vehicle_scale = document.getElementById('vehicle_scale').value;
 var opacity = document.getElementById('opacity').value;
 var strokeWeight = document.getElementById('strokeWeight').value;

var marker, map,locationData,markerData,markerPointData,vehicleDetails,icon;
var numDeltas = 100;
var delay = 3; //milliseconds
var i = 0;
var posLat = parseFloat(start_lat);
var posLng = parseFloat(start_lng);
var markericon;
var deltaLat, deltaLng;
var marker;
var map;
var vehicleColor = "#0C2161";
var vehicleScale = vehicle_scale;

var angle;
var clickedPointRecent
var clickedPointCurrent;
var clickedPointCurrentlatlng;
var locationQueue=[];
var recentPoppedLocation;

var recent_angle_latlng=null;
var current_angle_latlng;
var service;

$('document').ready(function(){setTimeout(getMarkers,5000);}); 

$('document').ready(function(){
  initMap();
  setTimeout(getMarkers,5000);

}); 
$('document').ready(function(){setTimeout(doWork,1000);});  



// ---------------------que list--------------------------
 function addToLocationQueue(loc,angle)
  {


   var location_angle=[loc,angle];
   locationQueue.push(location_angle);
  }
 function popFromLocationQueue()
  {
   if(locationQueue.length>0)
    {
          return locationQueue.splice(0,1)[0];    
    }
      else
      return null;
  }

  function getSnappedPoint(unsnappedWaypoints,angle)
   {
      $.ajax({
       url: 'https://roads.googleapis.com/v1/snapToRoads?path=' + unsnappedWaypoints.join('|') + '&key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&interpolate=true', //true', 
      crossDomain: true,
      dataType: 'jsonp'
       }).done(function(response) {
      if (response.error) {
        alert("error" + response.error.message);
        return;
      }
      $.each(response.snappedPoints, function (i, snap_data) {
      var loc=snap_data.location;
      var latlng = new google.maps.LatLng(loc.latitude, loc.longitude);
      addToLocationQueue(latlng,angle);
      });
     });
   }
// ---------------------que list--------------------------
function transition(result)
    {
     angle=result.liveData.angle;
     clickedPointCurrent = result.liveData.latitude + ',' + result.liveData.longitude;
     clickedPointCurrentlatlng=new google.maps.LatLng(result.liveData.latitude, result.liveData.longitude);
      

     if(clickedPointRecent==undefined || clickedPointRecent==null)
     {
        getSnappedPoint([clickedPointCurrent],angle)
     }
     else
     { 
      // var distance=checkDistanceBetweenTwoPoints(clickedPointRecentlatlng,clickedPointCurrentlatlng);
      getSnappedPoint([clickedPointRecent,clickedPointCurrent],angle);       
     }
     clickedPointRecent = clickedPointCurrent;
     clickedPointRecentlatlng=clickedPointCurrentlatlng;
    }

  // --------------------------------------------------------
function doWork()
    {
      var current=popFromLocationQueue();

      if(current!=null)
       {
        if(recentPoppedLocation==null)
        {  
                 

             track(current[0],current[1]);
            // setMarketLocation(current[0],current[1]);
            // drawLine(current[0],current[0]); 
            // track()           
        }
        else{   

            track(current[0],current[1]);
            
            // drawLine(recentPoppedLocation[0],current[0]);
            // setMarketLocation(current[0],current[1]);
         }
        
        recentPoppedLocation = current[0];
        
     }
     else{
     
     }

    setTimeout(doWork,1000);
    }







function initMap(){
  map = new google.maps.Map(document.getElementById('map'), {
        center: {
            lat: parseFloat(start_lat),
            lng: parseFloat(start_lng)
        },
        zoom: 18,
        mapTypeId: 'roadmap'

    });  


    // marker = new google.maps.Marker({});
    marker = new SlidingMarker({});

    // marker = new google.maps.Marker({});


    
    map.setOptions({maxZoom:18,minZoom:9});
     getMarkers(map);

  service = new google.maps.places.PlacesService(map);
 }






 function getMarkers() {

    var url = 'vehicles/location-track';
    var id = $("#vehicle_id_data").val();
    // var id=1;
    data = {
        id:id
    };
    var purl = getUrl() + '/' + url;
    var triangleCoords = [];
    $.ajax({
        type: 'POST',
        url: purl,
        data: data,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {

            if(res.hasOwnProperty('liveData')){

                    if (res.liveData.vehicleStatus == 'M') {
                        $("#online").show();
                        $("#halt").hide();
                        $("#offline").hide();
                        $("#sleep").hide();
                        vehicleColor="#84b752";
                    } else if (res.liveData.vehicleStatus == 'H') {
                        $("#halt").show();
                        $("#online").hide();
                        $("#offline").hide();
                        $("#sleep").hide();
                        vehicleColor="#69b4b9";

                    } else if (res.liveData.vehicleStatus == 'S') {
                        $("#sleep").show();
                        $("#halt").hide();
                        $("#online").hide();
                        $("#offline").hide();
                        vehicleColor=" #858585";
                    } else {
                      // if(res.liveData.last_seen >'1 hour ago'){
                        
                      // }
                        if(res.liveData.last_seen){
                            $('#last_seen').text(res.liveData.last_seen);
                        }
                        $("#offline").show();
                        $("#sleep").hide();
                        $("#halt").hide();
                        $("#online").hide();
                        vehicleColor="#c41900";

                    }
                    if(res.liveData.ign == 1) {
                      document.getElementById("ignition").innerHTML = "Ignition ON";
                    }else
                    {
                      document.getElementById("ignition").innerHTML = "Ignition OFF";
                    }
                    if(res.liveData.power == 1) {
                      document.getElementById("car_power").innerHTML = "Connected";
                    }else
                    {
                      document.getElementById("car_power").innerHTML = "Disconnected";
                    }
                    $device_time=res.liveData.dateTime;
                    $connection_lost_time=res.liveData.connection_lost_time;
                    if (res.liveData.signalStrength >= 19 && $device_time >= $connection_lost_time) {
                      document.getElementById("network_status").innerHTML = "Good";
                    }else if (res.liveData.signalStrength < 19 && res.liveData.signalStrength >= 13 && $device_time >= $connection_lost_time) {
                      document.getElementById("network_status").innerHTML = "Average";
                    }else if (res.liveData.signalStrength <= 12 && $device_time >= $connection_lost_time) {
                      document.getElementById("network_status").innerHTML = "Poor";
                    }else{
                      document.getElementById("network_status").innerHTML = "Connection Lost";
                    }
                    
                    document.getElementById("vehicle_name").innerHTML = res.vehicle_reg;
                    document.getElementById("car_speed").innerHTML = res.liveData.speed;
                    document.getElementById("car_bettary").innerHTML = res.liveData.battery_status;
                    document.getElementById("car_location").innerHTML = res.liveData.place;
                    document.getElementById("user").innerHTML = res.vehicle_name;

                    
                    transition(res);
                    // track(map, res);
                    setTimeout(getMarkers, 5000);
            }

        },
        error: function(err) {
            var message = (err.responseJSON) ? err.responseJSON.message : err.responseText;
        }
    });

  }

   var SameThreshold = 0.1;
   var increment_angle=5.0;
   var stop_angle;
   var recent_angle_increment_value;
   function track(latlng,angle) {
        current_angle_latlng=latlng;

        if(recent_angle_latlng== null){
          angle=parseFloat(angle);
        }else{
         
         
        if (google.maps.geometry.spherical.computeDistanceBetween(recent_angle_latlng,current_angle_latlng) < SameThreshold){
           if(recent_angle_increment_value==undefined){
             recent_angle_increment_value=angle;
           }
           // angle=(parseFloat(recent_angle_increment_value) + parseFloat(increment_angle))%360;
           // recent_angle_increment_value=angle;
            angle=parseFloat(angle);

         }else{
          // angle = google.maps.geometry.spherical.computeHeading(current_angle_latlng,recent_angle_latlng);
            angle=parseFloat(angle);
          
         }
         
        }
        var lat = parseFloat(latlng.lat());
        var lng = parseFloat(latlng.lng());
   


        var markerLatLng = new google.maps.LatLng(latlng.lat(),latlng.lng());
        i = 0;
        deltaLat = (lat - posLat) / numDeltas;
        deltaLng = (lng - posLng) / numDeltas;
       
        map.panTo(markerLatLng);
        moveMarker();
        var icon = { // car icon
                    path:vehiclePath,
                    scale: parseFloat(vehicleScale),
                    fillColor: vehicleColor, //<-- Car Color, you can change it 
                    // fillOpacity: 1,
                    // strokeWeight: 1,
                    fillOpacity: parseFloat(opacity),
                    strokeWeight: parseFloat(strokeWeight),
                    anchor: new google.maps.Point(0, 5),
                    rotation:angle  //<-- Car angle
                };
              marker.setIcon(icon);
              marker.setMap(map);
              recent_angle_latlng=current_angle_latlng;

    }

    function moveMarker() {
        infowindow.open(map, marker);
        posLat += deltaLat;
        posLng += deltaLng;
        var latlng = new google.maps.LatLng(posLat, posLng);
        marker.setPosition(offsetCenter(latlng));
        marker.setDuration(10);

        if (i != numDeltas) {
            i++;
            setTimeout(moveMarker, delay);
        }
    }

 // ---------------------center on  a marker--------------------------
function offsetCenter(latlng) 
  {
    var offsetx=9.5;
    var offsety=0;
    // offsetx is the distance you want that point to move to the right, in pixels
    // offsety is the distance you want that point to move upwards, in pixels
    var scale = Math.pow(2, map.getZoom());
    var worldCoordinateCenter = map.getProjection().fromLatLngToPoint(latlng);
    var pixelOffset = new google.maps.Point((offsetx/scale) || 0,(offsety/scale) ||0);
    var worldCoordinateNewCenter = new google.maps.Point(
        worldCoordinateCenter.x - pixelOffset.x,
        worldCoordinateCenter.y + pixelOffset.y
    );
    var newCenter = map.getProjection().fromPointToLatLng(worldCoordinateNewCenter);
    return newCenter;
   }
// ---------------------center on  a marker--------------------------
  // marker.addListener('click', function() {
  //   alert(1);
  //   infowindow.open(map, marker);
  // });

  // var contentString = 'hiiii';

  // var infowindow = new google.maps.InfoWindow({
  //   content: contentString
  // });
// ----------------------------------------------------------------

// -------------------------------------------------------------


var POI_markers = [];
var lat=posLat;
var lng=posLng;

var atm_flag=0;
var petrol_flag=0;
var hospital_flag=0;


$('#poi_atm').click(function(){
    deleteMarkersPOI();
    if(atm_flag==0){
        var pyrmont = {lat: parseFloat(lat), lng: parseFloat(lng)};
        service.nearbySearch(
          {location: pyrmont, radius: 1000, type:['atm']},
           function(results, status, pagination) {
           if (status !== 'OK') return;
              createMarkers(results);
            });

         atm_flag=1;
         }else{
           deleteMarkersPOI();
           atm_flag=0;
         }
 

 });


$('#poi_petrol').click(function(){
        deleteMarkersPOI();
        if(petrol_flag==0){
        var pyrmont = {lat: parseFloat(lat), lng: parseFloat(lng)};
        service.nearbySearch(
          {location: pyrmont, radius: 1000, type:['gas_station']},
           function(results, status, pagination) {
           if (status !== 'OK') return;
              createMarkers(results);
            });

          petrol_flag=1;
         }else{
           deleteMarkersPOI();
           petrol_flag=0;
         }
  
    });
 $('#poi_hopital').click(function(){
        deleteMarkersPOI();
        if(hospital_flag==0){
          var pyrmont = {lat: parseFloat(lat), lng: parseFloat(lng)};
          service.nearbySearch(
            {location: pyrmont, radius: 1000, type:['hospital']},
             function(results, status, pagination) {
             if (status !== 'OK') return;
                createMarkers(results);
              });
          hospital_flag=1;
         }else{
           deleteMarkersPOI();
           hospital_flag=0;
        }
    });

// ---------------find nearest map points-----------------
 var infowindow = new google.maps.InfoWindow();
 function createMarkers(places) {
        deleteMarkersPOI();
        var bounds = new google.maps.LatLngBounds();
        for (var i = 0, place; place = places[i]; i++) {
          var image = {
            url: place.icon,
            size: new google.maps.Size(30, 30),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(10, 20),
            scaledSize: new google.maps.Size(20, 20)
          };
          var marker = new google.maps.Marker({
            icon: image,
            title: place.name,
            position: place.geometry.location,
            data:place.vicinity
          });
          var place_name=place.name;



          POI_markers.push(marker);
          bounds.extend(place.geometry.location);

         
        }
        map.fitBounds(bounds);
        setMapOnAllPOI(map); 
        
      }
      function setMapOnAllPOI(map) {
        for (var i = 0; i < POI_markers.length; i++) {
          POI_markers[i].setMap(map);
           google.maps.event.addListener(POI_markers[i], 'click', (function(marker, i) {
          return function() {
            infowindow.setContent('<i>'+POI_markers[i].title +'</i><br><span style="margin-top: 25px;">'+POI_markers[i].data+'</span>');
            infowindow.setOptions({maxWidth: 200});
            infowindow.open(map, POI_markers[i]);
          }
          }) (marker, i));
        }
      }
      function clearMarkersPOI() {
        setMapOnAllPOI(null);
      }
      function deleteMarkersPOI() {
        clearMarkersPOI();
         POI_markers = [];
        
      }
     
// ---------------find nearest map points-----------------
// -------------------playback---------------------------


$( "#playback_form" ).submit(function( event ) {
  var vehicle_id=$('#vehicle_id').val();
  var from_date=$('#fromDate').val();
  var to_date=$('#toDate').val();
  var url_data=encodeURI('from_date='+from_date+"&to_date="+to_date+"&vehicle_id="+vehicle_id);
  window.open("/vehicle_playback?"+url_data, "myWindow", "width=700,height=500");
  event.preventDefault();
});

// -------------------playback---------------------------
var contentString = 
 '<div style="width:13%;float:left">'+
 '<div class="text-center mb-4" style="margin:0 0 1.5rem .5rem!important">'+


 '<a class="btn btn-block btn-social btn-bitbucket track_item">'+
 '<i class="fa fa-tachometer"></i> <b><label id="car_speed">0</label> km/h</b></a>'+
 '</div>';

var infowindow = new google.maps.InfoWindow({
    content: contentString
});







