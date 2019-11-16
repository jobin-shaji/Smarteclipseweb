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
var delay = 10; //milliseconds
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
var ac;
var battery_status;
var connection_lost_time;
var dateTime;
var fuel;
var fuelquantity;
var ign;
var last_seen;
var latitude;
var longitude;
var place;
var power;
var signalStrength;
var speed;
var vehicleStatus;


$('document').ready(function(){setTimeout(getMarkers,5000);}); 

$('document').ready(function(){
  initMap();
  setTimeout(getMarkers,5000);

}); 
$('document').ready(function(){setTimeout(doWork,1000);});  



// ---------------------que list--------------------------
 function addToLocationQueue(loc,angle,ac,battery_status,connection_lost_time,dateTime,fuel,fuelquantity,ign,last_seen,latitude,longitude,place,power,signalStrength,speed,vehicleStatus)
  {


   var location_angle=[loc,angle,ac,battery_status,connection_lost_time,dateTime,fuel,fuelquantity,ign,last_seen,latitude,longitude,place,power,signalStrength,speed,vehicleStatus];
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

  function getSnappedPoint(unsnappedWaypoints,angle,ac,battery_status,connection_lost_time,dateTime,fuel,fuelquantity,ign,last_seen,latitude,longitude,place,power,signalStrength,speed,vehicleStatus)
   {
      $.ajax({
       url: 'https://roads.googleapis.com/v1/snapToRoads?path=' + unsnappedWaypoints.join('|') + '&key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&interpolate=true', //true', 
      crossDomain: true,
      dataType: 'jsonp'
       }).done(function(response) {
      if (response.error) {
        // alert("error" + response.error.message);
        return;
      }
      $.each(response.snappedPoints, function (i, snap_data) {
      var loc=snap_data.location;
      var latlng = new google.maps.LatLng(loc.latitude, loc.longitude);
      addToLocationQueue(latlng,angle,ac,battery_status,connection_lost_time,dateTime,fuel,fuelquantity,ign,last_seen,latitude,longitude,place,power,signalStrength,speed,vehicleStatus);
      });
     });
   }
// ---------------------que list--------------------------
function transition(result)
    {
     angle=result.liveData.angle;
     ac=result.liveData.ac;
     battery_status=result.liveData.battery_status;
     connection_lost_time=result.liveData.connection_lost_time;
     dateTime=result.liveData.dateTime;
     fuel=result.liveData.fuel;
     fuelquantity=result.liveData.fuelquantity;
     ign=result.liveData.ign;
     last_seen=result.liveData.last_seen;
     latitude=result.liveData.latitude;
     longitude=result.liveData.longitude;
     place=result.liveData.place;
     power=result.liveData.power;
     signalStrength=result.liveData.signalStrength;
     speed=result.liveData.speed;
     vehicleStatus=result.liveData.vehicleStatus;


     clickedPointCurrent = result.liveData.latitude + ',' + result.liveData.longitude;
     clickedPointCurrentlatlng=new google.maps.LatLng(result.liveData.latitude, result.liveData.longitude);
      

     if(clickedPointRecent==undefined || clickedPointRecent==null)
     {
        getSnappedPoint([clickedPointCurrent],angle,ac,battery_status,connection_lost_time,dateTime,fuel,fuelquantity,ign,last_seen,latitude,longitude,place,power,signalStrength,speed,vehicleStatus)
     }
     else
     { 
      // var distance=checkDistanceBetweenTwoPoints(clickedPointRecentlatlng,clickedPointCurrentlatlng);
      getSnappedPoint([clickedPointRecent,clickedPointCurrent],angle,ac,battery_status,connection_lost_time,dateTime,fuel,fuelquantity,ign,last_seen,latitude,longitude,place,power,signalStrength,speed,vehicleStatus);       
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
                 
             updateStatusData(current);
             track(current[0],current[1]);
            // setMarketLocation(current[0],current[1]);
            // drawLine(current[0],current[0]); 
            // track()           
        }
        else{   

            updateStatusData(current);
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



function updateStatusData(current)
{

  var latlng=current[0];
  var angle=current[1];
  var ac=current[2];
  var battery_status=current[3];
  var connection_lost_time=current[4];
  var dateTime=current[5];
  var fuel=current[6];
  var fuelquantity=current[7];
  var ign=current[8];
  var last_seen=current[9];
  var latitude=current[10];
  var longitude=current[11];
  var place=current[12];
  var power=current[13];
  var signalStrength=current[14];
  var speed=current[15];
  var vehicleStatus=current[16];




   if (vehicleStatus == 'M' && speed != '0') {
          $("#online").show();
          $("#zero_speed_online").hide();
          $("#halt").hide();
          $("#offline").hide();
          $("#sleep").hide();
          vehicleColor="#84b752";
      } else if (vehicleStatus == 'M' && speed == '0') {
          $("#zero_speed_online").show();
          $("#halt").hide();
          $("#online").hide();
          $("#offline").hide();
          $("#sleep").hide();
          vehicleColor="#84b752";

      }else if (vehicleStatus == 'H') {
          $("#halt").show();
          $("#zero_speed_online").hide();
          $("#online").hide();
          $("#offline").hide();
          $("#sleep").hide();
          vehicleColor="#69b4b9";

      } else if (vehicleStatus == 'S') {
          $("#sleep").show();
          $("#zero_speed_online").hide();
          $("#halt").hide();
          $("#online").hide();
          $("#offline").hide();
          vehicleColor=" #858585";
      } else {
        // if(res.liveData.last_seen >'1 hour ago'){
          
        // }
          if(last_seen){
           $('#last_seen').text(last_seen);
          }
          $("#offline").show();
          $("#sleep").hide();
          $("#halt").hide();
          $("#online").hide();
          $("#zero_speed_online").hide();
          vehicleColor="#c41900";

      }
      if(ign == 1) {
        document.getElementById("ignition").innerHTML = "ON";
      }else
      {
        document.getElementById("ignition").innerHTML = "OFF";
      }
      if(power == 1) {
        document.getElementById("car_power").innerHTML = "CONNECTED";
      }else
      {
        document.getElementById("car_power").innerHTML = "DISCONNECTED";
      }
      if(vehicleStatus == 'M' && speed == '0') {
        document.getElementById("car_speed").innerHTML = "VEHICLE STOPPED";
        $('#valid_speed').css('display','none');
      }else
      {
        document.getElementById("car_speed").innerHTML = speed;
        $('#valid_speed').css('display','inline-block');
      }
      $device_time=dateTime;
      $connection_lost_time=connection_lost_time;
      if (signalStrength >= 19 && $device_time >= $connection_lost_time) {
        document.getElementById("network_status").innerHTML = "GOOD";
      }else if (signalStrength < 19 && signalStrength >= 13 && $device_time >= $connection_lost_time) {
        document.getElementById("network_status").innerHTML = "AVERAGE";
      }else if (signalStrength <= 12 && $device_time >= $connection_lost_time) {
        document.getElementById("network_status").innerHTML = "POOR";
      }else{
        document.getElementById("network_status").innerHTML = "LOST";
      }
      if(ign == 1) {
        document.getElementById("ac").innerHTML = "ON";
      }else
      {
        document.getElementById("ac").innerHTML = "OFF";
      }
      // document.getElementById("vehicle_name").innerHTML = res.vehicle_reg;
     

      document.getElementById("car_bettary").innerHTML = battery_status;
       document.getElementById("fuel").innerHTML = battery_status;
      document.getElementById("car_location").innerHTML = place;
      // document.getElementById("user").innerHTML = res.vehicle_name;
     

      $("#km_live_track").html('');
      $("#km_live_track").append(speed);


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


    
    map.setOptions({maxZoom:15,minZoom:9});
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

                    document.getElementById("user").innerHTML = res.vehicle_name;
                    document.getElementById("vehicle_name").innerHTML = res.vehicle_reg;

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
           var image="/images/ATM.svg";
              createMarkers(results,image);
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
             var image="/images/petrol-pump.svg";
              createMarkers(results,image);
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
             var image="/images/hospital.svg";
                createMarkers(results,image);
              });
          hospital_flag=1;
         }else{
           deleteMarkersPOI();
           hospital_flag=0;
        }
    });
// ---------------find nearest map points-----------------
 var infowindow = new google.maps.InfoWindow();
 function createMarkers(places,image_icon) {
        deleteMarkersPOI();
        var bounds = new google.maps.LatLngBounds();
        for (var i = 0, place; place = places[i]; i++) {
           var image = {
            url: image_icon,
            size: new google.maps.Size(50, 50),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(10, 20),
            scaledSize: new google.maps.Size(50, 50)
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
 '<i class="fa fa-tachometer"></i> <b><label id="km_live_track">-</label> km/h</b></a>'+
 '</div>';

var infowindow = new google.maps.InfoWindow({
    content: contentString
});







