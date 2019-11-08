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
var numDeltas = 300;
var delay = 20; //milliseconds
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


$('document').ready(function(){setTimeout(getMarkers,5000);}); 
$('document').ready(function(){setTimeout(doWork,500);});  


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
            
            // drawLine(recentPoppedLocation[0],current[0]);
            // setMarketLocation(current[0],current[1]);
         }
        
        recentPoppedLocation = current[0];
        
     }
     else{
     
     }
    setTimeout(doWork,140);
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


    marker = new google.maps.Marker({});
    
    map.setOptions({maxZoom:18,minZoom:9});
     getMarkers(map);
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
            // console.log(res.liveData.ign);
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


   function track(latlng,angle) {

        var lat = parseFloat(latlng.lat());
        var lng = parseFloat(latlng.lng());
        var angle=parseFloat(angle);
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



    }

    function moveMarker() {

        posLat += deltaLat;
        posLng += deltaLng;
        var latlng = new google.maps.LatLng(posLat, posLng);
        marker.setPosition(latlng);
        if (i != numDeltas) {
            i++;
            setTimeout(moveMarker, delay);
        }


    }









