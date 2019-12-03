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
// var posLat = 10.107570;
// var posLng = 76.345665;
var posLat = parseFloat(start_lat);
var posLng = parseFloat(start_lng);
// alert(posLat);
 var markericon;
var deltaLat, deltaLng;
var marker;
var map;
// var vehiclePath = "M29.395,0H17.636c-3.117,0-5.643,3.467-5.643,6.584v34.804c0,3.116,2.526,5.644,5.643,5.644h11.759   c3.116,0,5.644-2.527,5.644-5.644V6.584C35.037,3.467,32.511,0,29.395,0z M34.05,14.188v11.665l-2.729,0.351v-4.806L34.05,14.188z    M32.618,10.773c-1.016,3.9-2.219,8.51-2.219,8.51H16.631l-2.222-8.51C14.41,10.773,23.293,7.755,32.618,10.773z M15.741,21.713   v4.492l-2.73-0.349V14.502L15.741,21.713z M13.011,37.938V27.579l2.73,0.343v8.196L13.011,37.938z M14.568,40.882l2.218-3.336   h13.771l2.219,3.336H14.568z M31.321,35.805v-7.872l2.729-0.355v10.048L31.321,35.805";
var vehicleColor = "#0C2161";
// var vehicleScale = "0.5";
var vehicleScale = vehicle_scale;

function initMap(){
  map = new google.maps.Map(document.getElementById('map'), {
        center: {
            lat: parseFloat(start_lat),
            lng: parseFloat(start_lng)
        },
        zoom: 18,
        mapTypeId: 'roadmap'

    });  
     var icon = { // car icon
        path: vehiclePath,
        scale: parseFloat(vehicleScale),
        fillColor: vehicleColor, //<-- Car Color, you can change it 
        // fillOpacity: 1,
        // strokeWeight: 1,
        fillOpacity: parseFloat(opacity),
        strokeWeight: parseFloat(strokeWeight),
        anchor: new google.maps.Point(0, 5)
        // rotation: 0 //<-- Car angle
    };
    marker = new google.maps.Marker({
        map: map,
        icon: icon
    });
    map.setOptions({maxZoom:18,minZoom:9});
    getMarkers(map);
}



function getMarkers() {

    var url = 'gps/location-track/root';
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
              var device_time=res.liveData.dateTime;
              if (res.liveData.vehicleStatus == 'M' && res.liveData.speed != '0' && device_time >= res.liveData.connection_lost_time_motion)
              {
                $("#online").show();
                $("#zero_speed_online").hide();
                $("#halt").hide();
                $("#offline").hide();
                $("#sleep").hide();
                $("#connection_lost").hide();
                vehicleColor="#84b752";
              }
              else if (res.liveData.vehicleStatus == 'M' && res.liveData.speed != '0' && device_time <= res.liveData.connection_lost_time_motion)
              {
                if(res.liveData.connection_lost_time_minutes){
                  $('#connection_lost_last_seen').text(res.liveData.connection_lost_time_minutes);
                }
                $("#online").hide();
                $("#zero_speed_online").hide();
                $("#halt").hide();
                $("#offline").hide();
                $("#sleep").hide();
                $("#connection_lost").show();
                vehicleColor="#84b752";
              } 
              else if (res.liveData.vehicleStatus == 'M' && res.liveData.speed == '0' && device_time >= res.liveData.connection_lost_time_motion)
              {
                $("#zero_speed_online").show();
                $("#halt").hide();
                $("#online").hide();
                $("#offline").hide();
                $("#sleep").hide();
                $("#connection_lost").hide();
                vehicleColor="#84b752";

              }
              else if (res.liveData.vehicleStatus == 'M' && res.liveData.speed == '0' && device_time <= res.liveData.connection_lost_time_motion)
              {
                if(res.liveData.connection_lost_time_minutes){
                  $('#connection_lost_last_seen').text(res.liveData.connection_lost_time_minutes);
                }
                $("#online").hide();
                $("#zero_speed_online").hide();
                $("#halt").hide();
                $("#offline").hide();
                $("#sleep").hide();
                $("#connection_lost").show();
                vehicleColor="#84b752";
              } 
              else if (res.liveData.vehicleStatus == 'H' && device_time >= res.liveData.connection_lost_time_halt)
              {
                $("#halt").show();
                $("#zero_speed_online").hide();
                $("#online").hide();
                $("#offline").hide();
                $("#sleep").hide();
                $("#connection_lost").hide();
                vehicleColor="#69b4b9";

              }
              else if (res.liveData.vehicleStatus == 'H' && device_time <= res.liveData.connection_lost_time_halt)
              {
                if(res.liveData.connection_lost_time_minutes){
                  $('#connection_lost_last_seen').text(res.liveData.connection_lost_time_minutes);
                }
                $("#online").hide();
                $("#zero_speed_online").hide();
                $("#halt").hide();
                $("#offline").hide();
                $("#sleep").hide();
                $("#connection_lost").show();
                vehicleColor="#69b4b9";
              }
              else if (res.liveData.vehicleStatus == 'S' && device_time >= res.liveData.connection_lost_time_sleep)
              {
                $("#sleep").show();
                $("#zero_speed_online").hide();
                $("#halt").hide();
                $("#online").hide();
                $("#offline").hide();
                $("#connection_lost").hide();
                vehicleColor=" #858585";
              }
              else if (res.liveData.vehicleStatus == 'S' && device_time <= res.liveData.connection_lost_time_sleep)
              {
                if(res.liveData.connection_lost_time_minutes){
                  $('#connection_lost_last_seen').text(res.liveData.connection_lost_time_minutes);
                }
                $("#online").hide();
                $("#zero_speed_online").hide();
                $("#halt").hide();
                $("#offline").hide();
                $("#sleep").hide();
                $("#connection_lost").show();
                vehicleColor="#858585";
              }
              else 
              {
                if(res.liveData.last_seen){
                 $('#last_seen').text(res.liveData.last_seen);
                }
                $("#offline").show();
                $("#sleep").hide();
                $("#halt").hide();
                $("#online").hide();
                $("#zero_speed_online").hide();
                $("#connection_lost").hide();
                vehicleColor="#c41900";
              }
              if(res.liveData.ign == 1) {
                document.getElementById("ignition").innerHTML = "ON";
              }else
              {
                document.getElementById("ignition").innerHTML = "OFF";
              }

              if(res.liveData.power == 1) {
                document.getElementById("car_power").innerHTML = "Connected";
              }else
              {
                document.getElementById("car_power").innerHTML = "Disconnected";
              }

              if(res.liveData.vehicleStatus == 'M' && res.liveData.speed == '0') {
                document.getElementById("car_speed").innerHTML = "VEHICLE STOPPED";
                $('#valid_speed').css('display','none');
              }else
              {
                document.getElementById("car_speed").innerHTML = res.liveData.speed;
                $('#valid_speed').css('display','inline-block');
              }
              
              if(res.liveData.vehicleStatus == 'M')
              {
                if (res.liveData.signalStrength >= 19 && device_time >= res.liveData.connection_lost_time_motion) {
                  document.getElementById("network_status").innerHTML = "GOOD";
                  var element = document.getElementById("lost_blink_id");
                  element.classList.remove("lost_blink");
                   $('#network_status').removeClass('lost1');
                }
                else if (res.liveData.signalStrength < 19 && res.liveData.signalStrength >= 13 && device_time >= res.liveData.connection_lost_time_motion) {
                  document.getElementById("network_status").innerHTML = "AVERAGE";
                  var element = document.getElementById("lost_blink_id");
                  element.classList.remove("lost_blink");
                   $('#network_status').removeClass('lost1');
                }
                else if (res.liveData.signalStrength <= 12 && device_time >= res.liveData.connection_lost_time_motion) {
                  document.getElementById("network_status").innerHTML = "POOR";
                  var element = document.getElementById("lost_blink_id");
                  element.classList.remove("lost_blink");
                   $('#lost_blink_id1').removeClass('lost1');
                }
                else{
                  document.getElementById("network_status").innerHTML = "LOST";
                  var element = document.getElementById("lost_blink_id");
                  element.classList.add("lost_blink");
                   $('#network_status').addClass('lost1');
                }
              }
              else if(res.liveData.vehicleStatus == 'H')
              {
                if (res.liveData.signalStrength >= 19 && device_time >= res.liveData.connection_lost_time_halt) {
                  document.getElementById("network_status").innerHTML = "GOOD";
                  var element = document.getElementById("lost_blink_id");
                  element.classList.remove("lost_blink");
                   $('#network_status').removeClass('lost1');
                }
                else if (res.liveData.signalStrength < 19 && res.liveData.signalStrength >= 13 && device_time >= res.liveData.connection_lost_time_halt) {
                  document.getElementById("network_status").innerHTML = "AVERAGE";
                  var element = document.getElementById("lost_blink_id");
                  element.classList.remove("lost_blink");
                   $('#network_status').removeClass('lost1');
                }
                else if (res.liveData.signalStrength <= 12 && device_time >= res.liveData.connection_lost_time_halt) {
                  document.getElementById("network_status").innerHTML = "POOR";
                  var element = document.getElementById("lost_blink_id");
                  element.classList.remove("lost_blink");
                   $('#lost_blink_id1').removeClass('lost1');
                }
                else{
                  document.getElementById("network_status").innerHTML = "LOST";
                  var element = document.getElementById("lost_blink_id");
                  element.classList.add("lost_blink");
                   $('#network_status').addClass('lost1');
                }
              }
              else if(res.liveData.vehicleStatus == 'S')
              {
                if (res.liveData.signalStrength >= 19 && device_time >= res.liveData.connection_lost_time_sleep) {
                  document.getElementById("network_status").innerHTML = "GOOD";
                  var element = document.getElementById("lost_blink_id");
                  element.classList.remove("lost_blink");
                   $('#network_status').removeClass('lost1');
                }
                else if (res.liveData.signalStrength < 19 && res.liveData.signalStrength >= 13 && device_time >= res.liveData.connection_lost_time_sleep) {
                  document.getElementById("network_status").innerHTML = "AVERAGE";
                  var element = document.getElementById("lost_blink_id");
                  element.classList.remove("lost_blink");
                   $('#network_status').removeClass('lost1');
                }
                else if (res.liveData.signalStrength <= 12 && device_time >= res.liveData.connection_lost_time_sleep) {
                  document.getElementById("network_status").innerHTML = "POOR";
                  var element = document.getElementById("lost_blink_id");
                  element.classList.remove("lost_blink");
                   $('#lost_blink_id1').removeClass('lost1');
                }
                else{
                  document.getElementById("network_status").innerHTML = "LOST";
                  var element = document.getElementById("lost_blink_id");
                  element.classList.add("lost_blink");
                   $('#network_status').addClass('lost1');
                }
              }
              else
              {
                document.getElementById("network_status").innerHTML = "LOST";
                var element = document.getElementById("lost_blink_id");
                element.classList.add("lost_blink");
                $('#network_status').addClass('lost1');
              }
              
              document.getElementById("gps_imei").innerHTML = res.liveData.imei;
              document.getElementById("car_bettary").innerHTML = res.liveData.battery_status;
              document.getElementById("ac").innerHTML = res.liveData.ac;
              document.getElementById("fuel").innerHTML = res.liveData.fuel;
              document.getElementById("car_location").innerHTML = res.liveData.place;

              track(map, res);
              setTimeout(locate, 5000);
          }

        },
        error: function(err) {
            var message = (err.responseJSON) ? err.responseJSON.message : err.responseText;
            console.log(message, 'Error');
        }
    });


    function track(map, res) {

        var lat = parseFloat(res.liveData.latitude);
        var lng = parseFloat(res.liveData.longitude);
        var angle=parseFloat(res.liveData.angle);
        var markerLatLng = new google.maps.LatLng(res.liveData.latitude, res.liveData.longitude);
        i = 0;
        deltaLat = (lat - posLat) / numDeltas;
        deltaLng = (lng - posLng) / numDeltas;
       
        map.panTo(markerLatLng);
        moveMarker();
        var icon = { // car icon
                    path:vehiclePath,
                    scale:vehicle_scale,
                    fillColor: vehicleColor, //<-- Car Color, you can change it 
                    // fillOpacity: 1,
                    // strokeWeight: 1,
                    fillOpacity: parseFloat(opacity),
                    strokeWeight: parseFloat(strokeWeight),
                    anchor: new google.maps.Point(0, 5)
                    // rotation:angle  //<-- Car angle
                };
              marker.setIcon(icon);



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

    function locate() {
        getMarkers();
    }
// -------------------------------------------------------------


var POI_markers = [];
var lat=posLat;
var lng=posLng;
var service = new google.maps.places.PlacesService(map);
$('#poi_atm').click(function(){
        var pyrmont = {lat: parseFloat(lat), lng: parseFloat(lng)};
        service.nearbySearch(
          {location: pyrmont, radius: 5000, type:['atm']},
           function(results, status, pagination) {
           if (status !== 'OK') return;
              createMarkers(results);
            });
 

 });
$('#poi_petrol').click(function(){

        var pyrmont = {lat: parseFloat(lat), lng: parseFloat(lng)};
        service.nearbySearch(
          {location: pyrmont, radius: 5000, type:['gas_station']},
           function(results, status, pagination) {
           if (status !== 'OK') return;
              createMarkers(results);
            });
  
    });
 $('#poi_hopital').click(function(){
   
        var pyrmont = {lat: parseFloat(lat), lng: parseFloat(lng)};
        service.nearbySearch(
          {location: pyrmont, radius: 5000, type:['hospital']},
           function(results, status, pagination) {
           if (status !== 'OK') return;
              createMarkers(results);
            });
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
  var gps_id=$('#vehicle_id_data').val();
  var from_date=$('#fromDate').val();
  var to_date=$('#toDate').val();
  var url_data=encodeURI('from_date='+from_date+"&to_date="+to_date+"&gps_id="+gps_id);
  window.open("/gps_playback?"+url_data, "GPS Tracker", "width=700,height=500");
  event.preventDefault();
});

// -------------------playback---------------------------





}