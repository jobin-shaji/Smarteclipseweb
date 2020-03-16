var i               = 0;
var posLat          = '';
var posLng          = '';
var vehicle_data    = {
                      latitude  : '',
                      longitude :''
                    };
 var vehicle_lat,vehicle_lng;

$('document').ready(function(){
  getFirebaseData();
  $('#fuel_100, #fuel_75, #fuel_50, #fuel_25, #fuel_0, #upgrade').hide();

});

function getFirebaseData()
{
  var vehicle_id = $("#vehicle_id").val();
  firebase.database().ref(notify.user_id+'/livetrack/'+vehicle_id)
  .on('value', function(liveTrack) {
    var live_data_for_tracking  = liveTrack.val();
    if(live_data_for_tracking == null)
    {
      alert('No Data Received From GPS!!!!!');
      window.location = window.location.origin+'/vehicle';
    }
    else
    {
      var ac                            = '';
      var fuel                          = '';
      var battery_status                = '';
      var device_time                   = '';
      var signalStrength                = '';
      var angle                         = '';
      var power                         = '';
      var ign                           = '';
      var odometer                      = '';
      var vehicleStatus                 = '';
      var speed                         = '';
      var vehicle_name                  = '';
      var vehicle_reg                   = '';
      var last_seen                     = '';
      var connection_lost_time_minutes  = '';
      var last_update_time              =  live_data_for_tracking.config_offline_time;
      var connection_lost_time_motion   =  live_data_for_tracking.config_connection_lost_time_motion;
      var connection_lost_time_halt     =  live_data_for_tracking.config_connection_lost_time_halt;
      var connection_lost_time_sleep    =  live_data_for_tracking.config_connection_lost_time_sleep;

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
        vehicle_lat = live_data_for_tracking.lat;

        vehicle_data.latitude = parseFloat(live_data_for_tracking.lat);
        if(posLat == '')
        {
          posLat = parseFloat(live_data_for_tracking.lat);
        }
      }
      if(live_data_for_tracking.lon != undefined)
      {
        vehicle_lng = live_data_for_tracking.lon;

        vehicle_data.longitude = parseFloat(live_data_for_tracking.lon);
        // console.log(" longitude"+live_data_for_tracking.lat);
        if(posLng == '')
        {
          posLng = parseFloat(live_data_for_tracking.lon);
        }
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
      document.getElementById("user").innerHTML         = vehicle_name;
      document.getElementById("vehicle_name").innerHTML = vehicle_reg;
      document.getElementById("car_battery").innerHTML  = battery_status;
      document.getElementById("ac").innerHTML           = ac;
      $('#fuel_100, #fuel_75, #fuel_50, #fuel_25, #fuel_0, #upgrade').hide();
      if(fuel < 1)
      {
        $('#fuel_0').show();
      }
      else if((fuel > 0) && (fuel <= 25))
      {
        $('#fuel_25').show();
      }
      else if((fuel > 25) && (fuel <= 50))
      {
        $('#fuel_50').show();
      }
      else if((fuel > 50) && (fuel <= 75))
      {
        $('#fuel_75').show();
      }
      else if(fuel > 75)
      {
        $('#fuel_100').show();
      }
      else
      {
        $('#upgrade').show();
        document.getElementById("upgradefuel").innerHTML = "Upgrade Version";
      }
      document.getElementById("odometer").innerHTML     = odometer;
      getPlace(vehicle_data.latitude,vehicle_data.longitude);

       async function getPlace(lat,lng){
        var location_name = await getPlaceName(lat,lng).then(function(data){
          var location_data = JSON.stringify(data.Response.View);
          document.getElementById("car_location").innerHTML = location_name_list=JSON.parse(location_data)[0].Result[0].Location.Address.Label;
          return "";
        });
      }

      function getPlaceName(lat,lng){
        var location_name = "";
        return $.ajax({
          url: 'https://reverse.geocoder.api.here.com/6.2/reversegeocode.json',
          type: 'GET',
          dataType: 'jsonp',
          jsonp: 'jsoncallback',
          data: {
            prox: lat+','+lng,
            mode: 'retrieveAddresses',
            maxresults: '1',
            gen: '9',
            app_id: "RN9UIyGura2lyToc9aPg",
            app_code: "4YMdYfSTVVe1MOD_bDp_ZA"
          }
        });
        }

      if (vehicleStatus == 'M' && Math.floor(speed) != 0 && device_time >= connection_lost_time_motion)
      {
        $("#online").show();
        $("#zero_speed_online").hide();
        $("#halt").hide();
        $("#offline").hide();
        $("#sleep").hide();
        $("#connection_lost").hide();
      }
      else if (vehicleStatus == 'M' && Math.floor(speed) != 0 && device_time <= connection_lost_time_motion)
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
      }
      else if (vehicleStatus == 'M' && Math.floor(speed) == 0 && device_time >= connection_lost_time_motion)
      {
        $("#zero_speed_online").show();
        $("#halt").hide();
        $("#online").hide();
        $("#offline").hide();
        $("#sleep").hide();
        $("#connection_lost").hide();

      }
      else if (vehicleStatus == 'M' && Math.floor(speed) == 0 && device_time <= connection_lost_time_motion)
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
      }
      else if (vehicleStatus == 'H' && device_time >= connection_lost_time_halt)
      {
        $("#halt").show();
        $("#zero_speed_online").hide();
        $("#online").hide();
        $("#offline").hide();
        $("#sleep").hide();
        $("#connection_lost").hide();
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
      }
      else if (vehicleStatus == 'S' && device_time >= connection_lost_time_sleep)
      {
        $("#sleep").show();
        $("#zero_speed_online").hide();
        $("#halt").hide();
        $("#online").hide();
        $("#offline").hide();
        $("#connection_lost").hide();
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
      if(vehicleStatus == 'M' && Math.floor(speed) == 0)
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
          $('#network_status').removeClass('lost1');
        }
        else if (signalStrength < 19 && signalStrength >= 13 && device_time >= connection_lost_time_motion) {
          document.getElementById("network_status").innerHTML = "AVERAGE";
          $('#network_status').removeClass('lost1');
        }
        else if (signalStrength <= 12 && device_time >= connection_lost_time_motion) {
          document.getElementById("network_status").innerHTML = "POOR";
          $('#lost_blink_id1').removeClass('lost1');
        }
        else{
          document.getElementById("network_status").innerHTML = "LOST";
          $('#network_status').addClass('lost1');
        }
      }
      else if(vehicleStatus == 'H')
      {
        if (signalStrength >= 19 && device_time >= connection_lost_time_halt) {
          document.getElementById("network_status").innerHTML = "GOOD";
          $('#network_status').removeClass('lost1');
        }
        else if (signalStrength < 19 && signalStrength >= 13 && device_time >= connection_lost_time_halt) {
          document.getElementById("network_status").innerHTML = "AVERAGE";
          $('#network_status').removeClass('lost1');
        }
        else if (signalStrength <= 12 && device_time >= connection_lost_time_halt) {
          document.getElementById("network_status").innerHTML = "POOR";
          $('#lost_blink_id1').removeClass('lost1');
        }
        else{
          document.getElementById("network_status").innerHTML = "LOST";
          $('#network_status').addClass('lost1');
        }
      }
      else if(vehicleStatus == 'S')
      {
        if (signalStrength >= 19 && device_time >= connection_lost_time_sleep) {
          document.getElementById("network_status").innerHTML = "GOOD";
          $('#network_status').removeClass('lost1');
        }
        else if (signalStrength < 19 && signalStrength >= 13 && device_time >= connection_lost_time_sleep) {
          document.getElementById("network_status").innerHTML = "AVERAGE";
          $('#network_status').removeClass('lost1');
        }
        else if (signalStrength <= 12 && device_time >= connection_lost_time_sleep) {
          document.getElementById("network_status").innerHTML = "POOR";
          $('#lost_blink_id1').removeClass('lost1');
        }
        else{
          document.getElementById("network_status").innerHTML = "LOST";
          $('#network_status').addClass('lost1');
        }
      }
      else
      {
        document.getElementById("network_status").innerHTML = "LOST";
        $('#network_status').addClass('lost1');
      }
      vehicleMoving(angle,vehicle_lat,vehicle_lng,speed,vehicleStatus);
    }
  });
}
var bearsMarkeronStartPoint;
var bearsMarker;
var startPointLatitude        = null;
var startPointLongitude       = null;
var endPointLatitude          = null;
var endPointLongitude         = null;
var blPlaceCaronMap           = false;
var first_point               = true;
var vehicle_halt,vehicle_sleep,vehicle_offline,vehicle_online;
    vehicle_halt                  =   '/documents/'+$('#ideal_icon').val();
    vehicle_sleep                 =   '/documents/'+$('#sleep_icon').val();
    vehicle_offline               =   '/documents/'+$('#offline_icon').val();
    vehicle_online                =   '/documents/'+$('#online_icon').val();
var objImg                    = document.createElement('img');
var outerElement              = document.createElement('div')
var domIcon                   = new H.map.DomIcon(outerElement);
var hidpi                     = ('devicePixelRatio' in window && devicePixelRatio > 1);
var secure                    = (location.protocol === 'https:') ? true : false; // check if the site was loaded via secure connection
var app_id                    = "RN9UIyGura2lyToc9aPg",
    app_code                      = "4YMdYfSTVVe1MOD_bDp_ZA";
var mapContainer              = document.getElementById('markers');
var platform                  = new H.service.Platform({ app_code: app_code, app_id: app_id, useHTTPS: secure });
var maptypes                  = platform.createDefaultLayers(hidpi ? 512 : 256, hidpi ? 320 : null);
var map                       = new H.Map(mapContainer, maptypes.normal.map);
    map.setCenter({ lat: 10.192656, lng: 76.386666 });
    map.setZoom(12);
var mapTileService              = platform.getMapTileService({
    type: 'base'
});
new H.mapevents.Behavior(new H.mapevents.MapEvents(map)); // add behavior control
var ui = H.ui.UI.createDefault(map, maptypes); // add UI
var vehicle_mode;
var previous_data       = [];
var first_set_data      = true;
var gis = {
  calculateDistance: function (start, end) {
    var lat1 = parseFloat(start[1]),
      lon1 = parseFloat(start[0]),
      lat2 = parseFloat(end[1]),
      lon2 = parseFloat(end[0]);
    return gis.sphericalCosinus(lat1, lon1, lat2, lon2);
  },
  sphericalCosinus: function (lat1, lon1, lat2, lon2) {
    var radius = 6371e3; // meters
    var dLon = gis.toRad(lon2 - lon1),
      lat1 = gis.toRad(lat1),
      lat2 = gis.toRad(lat2),
      distance = Math.acos(Math.sin(lat1) * Math.sin(lat2) +
        Math.cos(lat1) * Math.cos(lat2) * Math.cos(dLon)) * radius;
    return distance;
  },
  createCoord: function (coord, bearing, distance) {
    var
      radius = 6371e3, // meters
      δ = Number(distance) / radius, // angular distance in radians
      θ = gis.toRad(Number(bearing));
      φ1 = gis.toRad(coord[1]),
      λ1 = gis.toRad(coord[0]);
    var φ2 = Math.asin(Math.sin(φ1) * Math.cos(δ) +
      Math.cos(φ1) * Math.sin(δ) * Math.cos(θ));
    var λ2 = λ1 + Math.atan2(Math.sin(θ) * Math.sin(δ) * Math.cos(φ1),
      Math.cos(δ) - Math.sin(φ1) * Math.sin(φ2));
    λ2 = (λ2 + 3 * Math.PI) % (2 * Math.PI) - Math.PI;
    return [gis.toDeg(λ2), gis.toDeg(φ2)];
  },
  getBearing: function (start, end) {
    var
      startLat = gis.toRad(start[1]),
      startLong = gis.toRad(start[0]),
      endLat = gis.toRad(end[1]),
      endLong = gis.toRad(end[0]),
      dLong = endLong - startLong;
    var dPhi = Math.log(Math.tan(endLat / 2.0 + Math.PI / 4.0) /
      Math.tan(startLat / 2.0 + Math.PI / 4.0));
    if (Math.abs(dLong) > Math.PI) {
        dLong = (dLong > 0.0) ? -(2.0 * Math.PI - dLong) : (2.0 * Math.PI + dLong);
    }
    return (gis.toDeg(Math.atan2(dLong, dPhi)) + 360.0) % 360.0;
  },
  toDeg: function (n) { return n * 180 / Math.PI; },
  toRad: function (n) { return n * Math.PI / 180; }
};

async function createNewCoods(lat,lng,angle,mode,distance,previous_data){
  var bearing   = angle;
  var start       = [previous_data['lat'],previous_data['lng']];
  var end       = [lat, lng];
  var new_coord = gis.createCoord(start, angle, distance);
  var pCoordinates;
  for (var i = 0; i < distance; i++) {
    bearing = gis.getBearing(start, end);
    new_coord = gis.createCoord(start, bearing, i);
    if (i > 0) {
      if (pCoordinates != new_coord[0]) {
        await sleep(1);
        plotLocationOnMap(new_coord[0],new_coord[1],angle,mode)
      }
    }
    pCoordinates = new_coord;
  }
}

function moveMarker(RotateDegree,lat,lng,vehicle_mode){

  if ((bearsMarkeronStartPoint != null) && (blPlaceCaronMap == true)) {
    map.removeObject(bearsMarkeronStartPoint);
    blPlaceCaronMap = false;
  }

  if(vehicle_mode=="M")
  {
    objImg.src = vehicle_online;
  }else if(vehicle_mode=="H")
  {
    objImg.src = vehicle_halt;
  }else if(vehicle_mode=="S")
  {
    objImg.src = vehicle_sleep;
  }else{
    objImg.src = vehicle_offline;
  }
  el = objImg;
  var carDirection = RotateDegree;
  if (el.style.transform.includes("rotate")) {
    el.style.transform = el.style.transform.replace(/rotate(.*)/, "rotate(" + carDirection + "deg)");
  } else {
    el.style.transform = el.style.transform + "rotate(" + carDirection + "deg)";
  }

  outerElement.appendChild(el);
  outerElement.style.top = "0px";
  outerElement.style.width = "0px";
  var domIcon = new H.map.DomIcon(outerElement);
  bearsMarkeronStartPoint = new H.map.DomMarker({ lat:lat, lng:lng }, {
      icon: domIcon
  });
  map.addObject(bearsMarkeronStartPoint);
  blPlaceCaronMap = true;
}

function vehicleMoving(angle,lat,lng,speed,mode)
{
  if(first_set_data == true)
  {
    moveMarker(angle,lat,lng,mode);
    moveMap(lat,lng);
    previous_data={
      "lat"   : lat,
      "lng"   : lng,
      "angle" : angle,
      "mode"  : mode
    };
    first_set_data = false;
  }else
  {
    var start   = [previous_data['lat'], previous_data['lng']];
    var end     = [lat,lng];
    var total_distance = gis.calculateDistance(start, end);
    createNewCoods(lat,lng,angle,mode,total_distance,previous_data);
    previous_data = {
      "lat"   : lat,
      "lng"   : lng,
      "angle" : angle,
      "mode"  : mode
    };
    previous_vehicle_mode = null;
  }
}

function plotLocationOnMap(lat,lng,angle,mode)
{
  moveMap(lat,lng);
  first_point=false;
  if( (startPointLatitude != null) && (startPointLongitude!=null) )
  {
    endPointLatitude    = lat;
    endPointLongitude   = lng;
    vehicle_mode        = mode;
    var direction       =  angle;
    moveMarker(direction,endPointLatitude,endPointLongitude,vehicle_mode);
  }
  startPointLatitude  = lat;
  startPointLongitude = lng;
}

function moveMap(lat,lng)
{
  map.setCenter({lat:lat, lng:lng});
}

function sleep(ms)
{
  return new Promise(resolve => setTimeout(resolve, ms));
}