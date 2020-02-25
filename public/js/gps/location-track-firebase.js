var svg_icon        =   $("#svg_icon").val();
var vehicle_scale   =   $("#vehicle_scale").val();
var stroke_weight   =   $("#stroke_weight").val();
var opacity         =   $("#opacity").val();
var marker, map, icon;
var numDeltas       = 100;
var delay           = 5; //milliseconds
var i               = 0;
var posLat          = '';
var posLng          = '';
var deltaLat, deltaLng;
var vehicleColor    = "#0C2161";
var vehicle_data    = {
                      latitude  : '',
                      longitude :''
                    };


$('document').ready(function(){
  getFirebaseData();
  initMap();
}); 

function initMap(){
  map = new google.maps.Map(document.getElementById('map'), {
      center: {
          lat: vehicle_data.latitude,
          lng: vehicle_data.longitude
      },
      zoom: 17,
      fullscreenControl: false,
      mapTypeId: 'roadmap'
  }); 
  marker = new SlidingMarker({});
  map.setOptions({maxZoom:19,minZoom:9});
}
/**
 * 
 * 
 * 
 */
function getFirebaseData()
{
  var vehicle_id = $("#vehicle_id").val();
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
      vehicle_data.latitude = parseFloat(live_data_for_tracking.lat);
    }
    if(live_data_for_tracking.lon != undefined)
    {
      vehicle_data.longitude = parseFloat(live_data_for_tracking.lon);
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
  
    document.getElementById("car_battery").innerHTML = battery_status;
    document.getElementById("car_location").innerHTML = place;
    document.getElementById("ac").innerHTML = ac;
    document.getElementById("fuel").innerHTML = fuel;
    document.getElementById("odometer").innerHTML = odometer;

    track(vehicle_data.latitude,vehicle_data.longitude,angle);
  });
}

function track(latitude,longitude,angle) 
{

  var lat = latitude;
  var lng = longitude;
  posLat  = latitude;
  posLng  = longitude;
  angle   = parseInt(angle);
  var markerLatLng = new google.maps.LatLng(lat,lng);
  i = 0;
  deltaLat = (lat - posLat) / numDeltas;
  deltaLng = (lng - posLng) / numDeltas;
  moveMarker();
  var icon = { 
              path        : svg_icon,// car icon
              scale       : parseFloat(vehicle_scale),
              fillColor   : vehicleColor, //<-- Car Color, you can change it 
              fillOpacity : parseFloat(opacity),
              strokeWeight: parseFloat(stroke_weight),
              anchor      : new google.maps.Point(0, 5),
              rotation    :angle  //<-- Car angle
  };
  marker.setIcon(icon);
  marker.setMap(map);
  
}

function moveMarker() 
{
  posLat += deltaLat;
  posLng += deltaLng;
  var latlng = new google.maps.LatLng(posLat, posLng);
  marker.setPosition(offsetCenter(latlng));
  marker.setDuration(10);
  map.panTo(latlng);

  if (i != numDeltas) 
  {
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





