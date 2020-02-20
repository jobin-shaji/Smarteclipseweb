function getUrl() {
    return $('meta[name = "domain"]').attr('content');
}
 var vehiclePath = document.getElementById('svg_con').value;
 var start_lat = document.getElementById('lat').value;
 var start_lng = document.getElementById('lng').value;
 var vehicle_scale = document.getElementById('vehicle_scale').value;
 var opacity = document.getElementById('opacity').value;
 var strokeWeight = document.getElementById('strokeWeight').value;
 var track_vehicle_id = document.getElementById('vehicle_id_data').value;

var marker, map,locationData,markerData,markerPointData,vehicleDetails,icon;
var numDeltas = 100;
var delay = 5; //milliseconds
var i = 0;
var posLat = parseFloat(start_lat);
var posLng = parseFloat(start_lng);
var markericon;
var deltaLat, deltaLng;
var marker;
var map;
var vehicleColor = "#0C2161";
var vehicleScale = vehicle_scale;
var service;


$('document').ready(function(){
  initMap();
  setInterval(function() {
        var url = 'continuous-alert';
        var data = { 
          vehicle_id:track_vehicle_id
        };
        backgroundPostData(url,data,'continuousAlert',{alert:false});
  }, 8000);

}); 

function continuousAlert(res){
    if(res.status == 'success'){
        var latitude=res.alerts[0].latitude;
        var longitude=res.alerts[0].longitude;
        getPlaceNameFromLatLng(latitude,longitude);
        
        var modal = document.getElementById('track_alert');
        modal.style.display = "block";
        document.getElementById("alert_id").value = res.alerts[0].alert_type_id;
        document.getElementById("alert_vehicle_id").value = res.vehicle;
        document.getElementById("decrypt_vehicle_id").value = res.alerts[0].gps.vehicle.id;
        $('#critical_alert_name').text(res.alerts[0].alert_type.description);
        $('#critical_alert_time').text(res.alerts[0].device_time); 
    }
}

function verifyCriticalAlert(){
    var alert_id = document.getElementById("alert_id").value;
    var vehicle_id = document.getElementById("alert_vehicle_id").value;
    var decrypt_id = document.getElementById("decrypt_vehicle_id").value;
    var url = 'continuous-alert/verify';
    var data = {
    id : vehicle_id,
    alert_id : alert_id
    };
    backgroundPostData(url,data,'verifyCriticalAlertResponse',{alert:false}); 
}

function verifyCriticalAlertResponse(res){
    if(res){
        var modal = document.getElementById('track_alert');
        modal.style.display = "none";
    }
}

function initMap(){
  map = new google.maps.Map(document.getElementById('map'), {
      center: {
          lat: parseFloat(start_lat),
          lng: parseFloat(start_lng)
      },
      zoom: 17,
      fullscreenControl: false,
      mapTypeId: 'roadmap'
  });  
  // marker = new google.maps.Marker({});
  marker = new SlidingMarker({});
  // marker = new google.maps.Marker({});
  map.setOptions({maxZoom:19,minZoom:9});
  getMarkers();
  service = new google.maps.places.PlacesService(map);
}

function getMarkers()  //from firebase
{
  var vehicle_id = $("#vehicle_id_data").val();
  firebase.database().ref(notify.user_id+'/livetrack/'+vehicle_id)
  .on('value', function(liveTrack) {
    var live_data_for_tracking  = liveTrack.val();
    
    var ac                            = '';
    var fuel                          = '';
    var battery_status                = '';
    var device_time                   = '';
    var signalStrength                = '';
    var angle                         = '';
    var power                         = '';
    var ign                           = '';
    var odometer                      = '';
    var latitude                      = '';
    var longitude                     = '';
    var vehicleStatus                 = '';
    var speed                         = '';
    var vehicle_name                  = '';
    var vehicle_reg                   = '';
    var place                         = '';
    var last_seen                     = '';
    var connection_lost_time_minutes  = '';
    var last_update_time              =  live_data_for_tracking.config_offline_time;
    var connection_lost_time_motion   =  live_data_for_tracking.config_connection_lost_time_motion;
    var connection_lost_time_halt     =  live_data_for_tracking.config_connection_lost_time_halt;
    var connection_lost_time_sleep    =  live_data_for_tracking.config_connection_lost_time_sleep;
    var today                         =   new Date();
    var date                          =   today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    var time                          =   today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    var currentDateTime               =   date+' '+time;

    if(live_data_for_tracking.ac_status != undefined)
    {
      ac    =   live_data_for_tracking.ac_status;
      if(ac == 1)
      {
          ac     =   "ON";
      }else if(ac ==  0)
      {
          ac     =   "OFF";
      }
    }
    if(live_data_for_tracking.fuel_status != undefined)
    {
      fuel = live_data_for_tracking.fuel_status;
    }
    if(live_data_for_tracking.battery_status != undefined)
    {
      battery_status = Math.ceil(live_data_for_tracking.battery_status);
    }
    if(live_data_for_tracking.device_time != undefined)
    {
      device_time                          =   live_data_for_tracking.device_time;
      connection_lost_time_minutes         =   device_time;
      last_seen                            =   device_time;
    }
    if(live_data_for_tracking.gsm_signal_strength != undefined)
    {
      signalStrength = live_data_for_tracking.gsm_signal_strength;
    }
    if(live_data_for_tracking.heading != undefined)
    {
      angle = live_data_for_tracking.heading;
    }
    if(live_data_for_tracking.ignition != undefined)
    {
      ign = live_data_for_tracking.ignition;
    }
    if(live_data_for_tracking.km != undefined)
    {
      var odometer_in_meter   =   live_data_for_tracking.km;
      var gps_km              =   odometer_in_meter/1000;
      odometer                =   Math.ceil(gps_km);
    }
    if(live_data_for_tracking.lat != undefined)
    {
      latitude = live_data_for_tracking.lat;
    }
    if(live_data_for_tracking.lon != undefined)
    {
      longitude = live_data_for_tracking.lon;
    }
    if(live_data_for_tracking.main_power_status != undefined)
    {
      power = live_data_for_tracking.main_power_status;
    }
    if(live_data_for_tracking.mode != undefined)
    {
      vehicleStatus = live_data_for_tracking.mode;
    }
    if(live_data_for_tracking.speed != undefined)
    {
      speed = live_data_for_tracking.speed;
    }
    if(live_data_for_tracking.vehicle_name != undefined)
    {
      vehicle_name = live_data_for_tracking.vehicle_name;
    }
    if(live_data_for_tracking.vehicle_register_number != undefined)
    {
      vehicle_reg = live_data_for_tracking.vehicle_register_number;
    }

    if( device_time <  last_update_time )
    {
      vehicleStatus           =   "Offline";
      signalStrength          =   "Connection Lost";
    }

    //var snap_route            =   liveSnapRoot(latitude,longitude);

    document.getElementById("user").innerHTML         = vehicle_name;
    document.getElementById("vehicle_name").innerHTML = vehicle_reg;

    if (vehicleStatus == 'M' && speed != '0' && device_time >= connection_lost_time_motion)
    {
      $("#online").show();
      $("#zero_speed_online").hide();
      $("#halt").hide();
      $("#offline").hide();
      $("#sleep").hide();
      $("#connection_lost").hide();
      vehicleColor="#84b752";
    }
    else if (vehicleStatus == 'M' && speed != '0' && device_time <= connection_lost_time_motion)
    {
      if(connection_lost_time_minutes){
        $('#connection_lost_last_seen').text(connection_lost_time_minutes);
      }
      $("#online").hide();
      $("#zero_speed_online").hide();
      $("#halt").hide();
      $("#offline").hide();
      $("#sleep").hide();
      $("#connection_lost").show();
      vehicleColor="#84b752";
    } 
    else if (vehicleStatus == 'M' && speed == '0' && device_time >= connection_lost_time_motion)
    {
      $("#zero_speed_online").show();
      $("#halt").hide();
      $("#online").hide();
      $("#offline").hide();
      $("#sleep").hide();
      $("#connection_lost").hide();
      vehicleColor="#84b752";

    }
    else if (vehicleStatus == 'M' && speed == '0' && device_time <= connection_lost_time_motion)
    {
      if(connection_lost_time_minutes){
        $('#connection_lost_last_seen').text(connection_lost_time_minutes);
      }
      $("#online").hide();
      $("#zero_speed_online").hide();
      $("#halt").hide();
      $("#offline").hide();
      $("#sleep").hide();
      $("#connection_lost").show();
      vehicleColor="#84b752";
    } 
    else if (vehicleStatus == 'H' && device_time >= connection_lost_time_halt)
    {
      $("#halt").show();
      $("#zero_speed_online").hide();
      $("#online").hide();
      $("#offline").hide();
      $("#sleep").hide();
      $("#connection_lost").hide();
      vehicleColor="#69b4b9";

    }
    else if (vehicleStatus == 'H' && device_time <= connection_lost_time_halt)
    {
      if(connection_lost_time_minutes){
        $('#connection_lost_last_seen').text(connection_lost_time_minutes);
      }
      $("#online").hide();
      $("#zero_speed_online").hide();
      $("#halt").hide();
      $("#offline").hide();
      $("#sleep").hide();
      $("#connection_lost").show();
      vehicleColor="#69b4b9";
    }
    else if (vehicleStatus == 'S' && device_time >= connection_lost_time_sleep)
    {
      $("#sleep").show();
      $("#zero_speed_online").hide();
      $("#halt").hide();
      $("#online").hide();
      $("#offline").hide();
      $("#connection_lost").hide();
      vehicleColor=" #858585";
    }
    else if (vehicleStatus == 'S' && device_time <= connection_lost_time_sleep)
    {
      if(connection_lost_time_minutes){
        $('#connection_lost_last_seen').text(connection_lost_time_minutes);
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
      if(last_seen){
       $('#last_seen').text(last_seen);
      }
      $("#offline").show();
      $("#sleep").hide();
      $("#halt").hide();
      $("#online").hide();
      $("#zero_speed_online").hide();
      $("#connection_lost").hide();
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
    if(vehicleStatus == 'M' && speed == '0') 
    {
      document.getElementById("car_speed").innerHTML = "VEHICLE STOPPED";
      $('#valid_speed').css('display','none');
    }
    else
    {
      document.getElementById("car_speed").innerHTML = speed;
      $('#valid_speed').css('display','inline-block');
    }

    if(vehicleStatus == 'M')
    {
      if (signalStrength >= 19 && device_time >= connection_lost_time_motion) {
        document.getElementById("network_status").innerHTML = "GOOD";
        var element = document.getElementById("lost_blink_id");
        element.classList.remove("lost_blink");
        $('#network_status').removeClass('lost1');
      }
      else if (signalStrength < 19 && signalStrength >= 13 && device_time >= connection_lost_time_motion) {
        document.getElementById("network_status").innerHTML = "AVERAGE";
        var element = document.getElementById("lost_blink_id");
        element.classList.remove("lost_blink");
        $('#network_status').removeClass('lost1');
      }
      else if (signalStrength <= 12 && device_time >= connection_lost_time_motion) {
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
    else if(vehicleStatus == 'H')
    {
      if (signalStrength >= 19 && device_time >= connection_lost_time_halt) {
        document.getElementById("network_status").innerHTML = "GOOD";
        var element = document.getElementById("lost_blink_id");
        element.classList.remove("lost_blink");
        $('#network_status').removeClass('lost1');
      }
      else if (signalStrength < 19 && signalStrength >= 13 && device_time >= connection_lost_time_halt) {
        document.getElementById("network_status").innerHTML = "AVERAGE";
        var element = document.getElementById("lost_blink_id");
        element.classList.remove("lost_blink");
        $('#network_status').removeClass('lost1');
      }
      else if (signalStrength <= 12 && device_time >= connection_lost_time_halt) {
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
    else if(vehicleStatus == 'S')
    {
      if (signalStrength >= 19 && device_time >= connection_lost_time_sleep) {
        document.getElementById("network_status").innerHTML = "GOOD";
        var element = document.getElementById("lost_blink_id");
        element.classList.remove("lost_blink");
        $('#network_status').removeClass('lost1');
      }
      else if (signalStrength < 19 && signalStrength >= 13 && device_time >= connection_lost_time_sleep) {
        document.getElementById("network_status").innerHTML = "AVERAGE";
        var element = document.getElementById("lost_blink_id");
        element.classList.remove("lost_blink");
        $('#network_status').removeClass('lost1');
      }
      else if (signalStrength <= 12 && device_time >= connection_lost_time_sleep) {
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
  
    document.getElementById("car_bettary").innerHTML = battery_status;
    document.getElementById("car_location").innerHTML = place;
    document.getElementById("ac").innerHTML = ac;
    document.getElementById("fuel").innerHTML = fuel;
    document.getElementById("odometer").innerHTML = odometer;

    track(latitude,longitude,angle);
  });
   
}

// function getSnappedPoint(unsnappedWaypoints,angle,ac,battery_status,connection_lost_time_motion,dateTime,fuel,fuelquantity,ign,last_seen,latitude,longitude,place,power,signalStrength,speed,vehicleStatus,connection_lost_time_halt,connection_lost_time_sleep,connection_lost_time_minutes,odometer)
// {
//   $.ajax({
//     url: 'https://roads.googleapis.com/v1/snapToRoads?path=' + unsnappedWaypoints.join('|') + '&key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&interpolate=true', //true', 
//     crossDomain: true,
//     dataType: 'jsonp'
//   }).done(function(response) {
//     if (response.error) {
//       // alert("error" + response.error.message);
//       return;
//     }
//     if(response.snappedPoints == undefined){
//       var latlng = new google.maps.LatLng(latitude,longitude);
//       addToLocationQueue(latlng,angle,ac,battery_status,connection_lost_time_motion,dateTime,fuel,fuelquantity,ign,last_seen,latitude,longitude,place,power,signalStrength,speed,vehicleStatus,connection_lost_time_halt,connection_lost_time_sleep,connection_lost_time_minutes,odometer);
//     }else{
//       $.each(response.snappedPoints, function (i, snap_data) {
//         var loc=snap_data.location;
//         var latlng = new google.maps.LatLng(loc.latitude, loc.longitude);
//         addToLocationQueue(latlng,angle,ac,battery_status,connection_lost_time_motion,dateTime,fuel,fuelquantity,ign,last_seen,latitude,longitude,place,power,signalStrength,speed,vehicleStatus,connection_lost_time_halt,connection_lost_time_sleep,connection_lost_time_minutes,odometer);
//       });
//     }
//   });
// }


// function liveSnapRoot(latitude,longitude)
// {
//   var route = [latitude,longitude].join(',');
//   var url   = "https://roads.googleapis.com/v1/snapToRoads?path="+route+"&interpolate=true&key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo";
//   console.log(url.snappedPoints());
// }

  var SameThreshold = 0.1;
  var increment_angle=5.0;
  var stop_angle;
  var recent_angle_increment_value;
  function track(latitude,longitude,angle) 
  {
    var lat = latitude;
    var lng = longitude;
    angle   = parseInt(angle);
    
    var markerLatLng = new google.maps.LatLng(lat,lng);
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

  function moveMarker() 
  {
    // infowindow.open(map, marker);
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
    var offsetx=0;
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


  var POI_markers = [];
  var lat=posLat;
  var lng=posLng;

  var poi_atm_clicked = false;
  var clicked_poi_item = '';
  var petrol_flag=0;
  var hospital_flag=0;

  $('.poi_item').click(function(){
    var marker_images             = {
      atm:{
        'icon': '/images/ATM.svg',
        'label': 'ATM'
      },
      gas_station:{
        'icon': '/images/petrol-pump.svg',
        'label': 'Petrol Pump'
      },
      hospital:{
        'icon': '/images/hospital.svg',
        'label': 'Hospital'
      }
    };
    // map filter
    var filter = $(this).attr('filter');
    if(filter == 'undefined')
    {
      return true;
    }
    // clear existing markers
    deleteMarkersPOI();
    $('.poi_item').removeClass('poi_item_active');

    if( clicked_poi_item != filter)
    {
      // set active class
      $(this).addClass('poi_item_active');
      // filter map contents
      var latlng_location = {lat: parseFloat(lat), lng: parseFloat(lng)};
      service.nearbySearch({
        location: latlng_location, radius: 1000, type:[filter]
      },
      function(results, status) 
      {
        if (status !== 'OK') 
        {
          alert(' No '+marker_images[filter]['label']+' found within 1 KM');
          return;
        }
        createMarkers(results, marker_images[filter]['icon']);
        map.setZoom(15);
      });
      // set selected item
      clicked_poi_item = filter;
    }
    else
    {
      clicked_poi_item = '';
      map.setZoom(17);
    }
  });

// ---------------find nearest map points-----------------
  var infowindow = new google.maps.InfoWindow();
  function createMarkers(places,image_icon) {
    deleteMarkersPOI();
    var bounds = new google.maps.LatLngBounds();
    for (var i = 0, place; place = places[i]; i++) 
    {
      var image = {
        url: image_icon,
        size: new google.maps.Size(50, 50),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(10, 20),
        scaledSize: new google.maps.Size(30, 30)
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







