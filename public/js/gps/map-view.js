$(document).ready(function () {   
  var url = 'root-vehicle-mode-count';
  var data = {      
  };
  // window.setInterval(function(){
  backgroundPostData(url,data,'vehicleModeCount',{alert:true});
  // }, 5000);   
});
function vehicleModeCount(res){
  $('#moving').text(res.moving);
  $('#idle').text(res.idle);
  $('#stop').text(res.stop);
  $('#offline').text(res.offline);      
}
var latMap = 20.593683;
var lngMap = 78.962883;
var haightAshbury = {
 lat: latMap,
 lng: lngMap
};
var markers = [];
var map;
var map_flag;
var track_flag = 0;
var map_popup = 0;
var radius;
var cityCircle;
var circleStatus=0;
var myGoogleRadar;
var radarStatus=0;

function initMap() {
 map = new google.maps.Map(document.getElementById('map'), {
  zoom: 10,
  center: haightAshbury,
  mapTypeId: google.maps.MapTypeId.ROADMAP
 });
 var input1 = document.getElementById('search_place');
 autocomplete1 = new google.maps.places.Autocomplete(input1);
 var searchBox1 = new google.maps.places.SearchBox(autocomplete1);
 map_flag = 0;
 getVehicleSequence();
 // 'key' => env('APP_KEY'),
}
// check each 10 sec

window.setInterval(function() {
 if (track_flag == 0) {
  getVehicleSequence();
 }
}, 100000);
// check each 10 sec
function getVehicleSequence() {
 var url = 'dash-vehicle-track';
 var data = {};
 backgroundPostData(url, data, 'vehicleTrack', {
  alert: false
 });
 deleteMarkers();

}

function vehicleTrack(res) {
  //console.log(res);
  if(res.status!="failed"){
    var JSONObject = res.user_data;
    var marker, i;
    for (i = 0; i < JSONObject.length; i++) {
      var lat = JSONObject[i].lat;
      var lng = JSONObject[i].lon;
      if (map_flag == 0) {
        map.panTo(new google.maps.LatLng(lat, lng));
        map.setZoom(13);
        map.setOptions({
        minZoom: 5,
        maxZoom: 17
        });
        // map_flag=1;
      }
      var gpsID = JSONObject[i].id;
      var imei = JSONObject[i].imei;
      var reg = JSONObject[i].register_number;
      var gps_encrypt_id = JSONObject[i].gps_encrypt_id;
      var vehicle_name = JSONObject[i].vehicle_name;
      var loc = new google.maps.LatLng(lat, lng);
      var mode = JSONObject[i].mode;
      var color = "";
      var vehicle_status = "";
      if (mode == 'M') {
        car_color = "#84b752";
        vehicle_status = "Moving";
      } else if (mode == 'H') {
        car_color = "#69b4b9";
        vehicle_status = "Halt"
      } else if (mode == 'S') {
        car_color = "#858585";
        vehicle_status = "Sleep"
      } else {
        car_color = "#c41900";
        vehicle_status = "Offline"
      }

      var title = '<div id="content" style="width:150px;">' +
      '<span style="margin-right:5px;"><i class="fa fa-circle" style="color:' + car_color + ';" aria-hidden="true"></i></span>' + vehicle_status +
      '<div style="color:#000;font-weight:600;margin-top:5px;" ></div>' +
      '<div style="padding-top:5px; padding-left:16px;"><span style="margin-right:5px;">IMEI:</span>' + imei + ' </div>' +
      // '<div style="padding-top:5px;"><i class="fa fa-bell-o"></i> ,</div>'+
      // '<div style="padding-top:5px;"><i class="fa fa-map-marker"></i> </div>'+
      '<div style="padding-top:5px;"><a href=/gps/' + gps_encrypt_id + '/location/root class="btn btn-xs btn btn-warning" title="Location" style="background-color:#fff;"><i class="fa fa-map-marker" style="color:#000;font-size: 18px;"></i></a>   </div>' +
      '</div>';


      var path = JSONObject[i].vehicle_svg;
      var scale = JSONObject[i].vehicle_scale;
      var fillOpacity = JSONObject[i].opacity;
      var strokeWeight = JSONObject[i].strokeWeight;
      addMarker(loc, title, car_color, path, scale, fillOpacity, strokeWeight, gpsID);
      // console.log(imei);
      if (track_flag != 0) {
        addGpsToGpsList(gpsID,imei);
      }
    }
    setMapOnAll(map);
  }
}

function addMarker(location, title, car_color, path, scale, fillOpacity, strokeWeight, gpsID) {
  var icon = { // car icon
    path: path,
    scale: scale,
    fillColor: car_color, //<-- Car Color, you can change it
    fillOpacity: fillOpacity,
    strokeWeight: strokeWeight,
    anchor: new google.maps.Point(0, 5),
    rotation: 180 //<-- Car angle
  };

  var marker = new google.maps.Marker({
    position: location,
    title: "",
    icon: icon,
    gpsid:gpsID
  });
  var infowindow = new google.maps.InfoWindow();
  google.maps.event.addListener(marker, 'mouseover', function() {
    // alert(vehicle_id);
    getVehicle(gpsID);
    infowindow.setContent(title);
    infowindow.open(map, this);
    map_popup = 0;
  });

  google.maps.event.addListener(marker, 'click', function() {
    // alert(vehicle_id);
    getVehicle(gpsID);
    infowindow.setContent(title);
    infowindow.open(map, this);
    if (map_popup == 1) {
    map_popup = 0;
    } else {
    map_popup = 1;
    }
  });

  google.maps.event.addListener(marker, 'mouseout', function() {
    if (map_popup == 0) {
    infowindow.close(map, this);
    }
  });
  markers.push(marker);
}

function setMapOnAll(map) {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}

function selectVehicleTrack(res) {
  map.panTo(new google.maps.LatLng(res.lat, res.lon));
  map.setZoom(18);
  if(circleStatus==1){
    cityCircle.setMap(null);
  }
  redarLocationSelectVehicle(res.lat,res.lon,0.1);
}

$(".vehicle_gps_id").change(function() {
  var url = '/dashboard-track';
  var gps_id = this.value;
  var data = {
    gps_id: gps_id
  };
  backgroundPostData(url, data, 'selectVehicleTrack', {
    alert: false
  });
});


function getVehicleTrack(gps_id){
 var url = '/dashboard-track';
 var data = {
  gps_id: gps_id
 };

 backgroundPostData(url, data, 'selectVehicleTrack', {
  alert: false
 });
}

function locationSearch() {
  var place_name = $('#search_place').val();
  radius = $('#search_radius').val();
  if(radius!="KM"){
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({
      'address': place_name
    }, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      removeCircleFromMap();
      track_flag = 1;
      $('#gps_id').empty();
      var vehicleData ='<option value=""disabled selected>select</option>';
      $("#gps_id").append(vehicleData);

      var lat = results[0].geometry.location.lat();
      var lng = results[0].geometry.location.lng();
      map.panTo(new google.maps.LatLng(lat, lng));
      // map.setZoom(12);
      var url = '/location-search';

      var data = {
        lat: lat,
        lng: lng,
        radius: radius
      };

      backgroundPostData(url, data, 'searchLocation', {
      alert: false
      });

      redarLocation(lat, lng, radius);

      }else {
        alert("Please enter a valid location");
      }
    });
  }else{
    alert("Please select radius");
  }
    return false;
}

function mode(vehicle_mode) {
  track_flag = 1;
  $('#gps_id').empty();
  var vehicleData ='<option value=""disabled selected>select</option>';
  $("#gps_id").append(vehicleData);
  var url = '/dashboard-track-vehicle-mode';
  var data = {
    vehicle_mode: vehicle_mode
  };
  backgroundPostData(url, data, 'selectVehicleModeTrack', {
    alert: false
  });
}

function selectVehicleModeTrack(res) {
 // console.log(res);
 deleteMarkers();
 flag = 0;
 vehicleTrack(res);

}

function deleteMarkers() {
 clearMarkers();
 markers = [];
}

function clearMarkers() {
 setMapOnAll(null);
}

function addGpsToGpsList(gpsID,imei) {
  var vehicleData ='<option value="'+gpsID+'">'+imei+'</option>';
  $("#gps_id").append(vehicleData);
}


function searchLocation(res) {

 if (res.status == "success") {
  deleteMarkers();
  flag = 0;
  vehicleTrack(res);
  setMapZoom(radius);
 } else {
  setMapZoom(radius);
  alert('No vehicle found in this location');
 }

}

function redarLocation(lat, lng, radius) {
 if(circleStatus==1){
   cityCircle.setMap(null);
    if(radarStatus==1){
     myGoogleRadar.hidePolygon();
   }
 }
 var radius_in_meter = radius * 1000;
 var latlng = new google.maps.LatLng(lat, lng);
 var sunCircle = {
  strokeColor: "#b84930",
  strokeOpacity: 0.8,
  strokeWeight: 2,
  fillColor: "#b84930",
  fillOpacity: 0.35,
  map: map,
  center: latlng,
  radius: radius_in_meter // in meters
 };
 cityCircle = new google.maps.Circle(sunCircle);
 var opts = {
  lat: lat,
  lng: lng
 };
 myGoogleRadar = new GoogleRadar(map, opts);

 // init a RadarPolygon
 opts = {
  angle: 10,
  time: 60,
  radius: radius
 };
 myGoogleRadar.addRadarPolygon(opts);
 circleStatus=1;
 radarStatus=1;
}


function redarLocationSelectVehicle(lat, lng, radius) {
 if(circleStatus==1){
   cityCircle.setMap(null);
   if(radarStatus==1){
     myGoogleRadar.hidePolygon();
   }
 }
 var radius_in_meter = radius * 1000;
 var latlng = new google.maps.LatLng(lat, lng);
 var sunCircle = {
  strokeColor: "#408753",
  strokeOpacity: 0.8,
  strokeWeight: 2,
  fillColor: "#408753",
  fillOpacity: 0.35,
  map: map,
  center: latlng,
  radius: radius_in_meter // in meters
 };
 cityCircle = new google.maps.Circle(sunCircle);

 
 circleStatus=1;
}

function setMapZoom(radius) {
 if (radius == 10) {
  zoom_size = 11;
 } else if (radius == 30) {
  zoom_size = 10;
 } else if (radius == 50) {
  zoom_size = 9;
 } else if (radius == 75) {
  zoom_size = 8;
 } else if (radius == 100) {
  zoom_size = 8;
 } else {
  var zoom_size = 8;
 }
 map.setZoom(zoom_size);
}

// ------------------------------------------
function removeCircleFromMap(){

}
// -------------------------------------------
$(document).ready(function() {
 $('st-actionContainer').launchBtn({
  openDuration: 500,
  closeDuration: 300
 });
});

$('.cover_track_data').click(function(){
   $('.track_status').css('display','none');
});

$(document).ready(function () {
  var url = 'dash-count';
  var data = { 
     
  };
  backgroundPostData(url,data,'dbcount',{alert:true});
 //    window.setInterval(function(){
 //      backgroundPostData(url,data,'dbcount',{alert:false});  

  // }, 5000);
});
var activeElement;

function dbcount(res){
      $('#gps').text(res.gps);
      $('#dealer').text(res.dealers);
      $('#sub_dealer').text(res.subdealers);
      $('#client').text(res.clients);
      $('#vehicle').text(res.vehicles);
      $('#dealer_subdealer').text(res.subdealers);
      $('#total_gps_dealer').text(res.total_gps);
      $('#transferred_gps_dealer').text(res.transferred_gps);
      $('#total_gps_subdealer').text(res.total_gps);
      $('#transferred_gps_subdealer').text(res.transferred_gps);
      $('#subdealer_client').text(res.clients);
      $('#client_gps').text(res.gps);
      $('#client_vehicle').text(res.vehicles);
      $('#geofence').text(res.geofence);
      $('#moving').text(res.moving);
      $('#idle').text(res.idle);
      $('#stop').text(res.stop);
      $('#offline').text(res.offline);      
}

//updated all aaaaa
function getVehicle(value)
{  
  var url = '/vehicle-detail';
  var data = { 
    gps_id : value
  };
  backgroundPostData(url,data,'vehicle_details',{alert:true});
}
function vehicle_details(res){
  var network_status=res.network_status;
  var vehicle_mode=res.mode;
  if(network_status=="Connection Lost"){
    $("#network_offline").show();
    $("#network_online").hide();
  }else{
    $("#network_online").show();
    $("#network_offline").hide();
  }
  if(vehicle_mode=="Moving"){
    $("#vehicle_moving").show();
    $("#vehicle_status").hide();
    $("#vehicle_halt").hide();
    $("#vehicle_sleep").hide();
    $("#vehicle_stop").hide();
  }else if(vehicle_mode=="Halt"){
    $("#vehicle_moving").hide();
    $("#vehicle_status").hide();
    $("#vehicle_halt").show();
    $("#vehicle_sleep").hide();
    $("#vehicle_stop").hide();
  }else if(vehicle_mode=="Sleep"){
    $("#vehicle_moving").hide();
    $("#vehicle_status").hide();
    $("#vehicle_halt").hide();
    $("#vehicle_sleep").show();
    $("#vehicle_stop").hide();
  }else{
    $("#vehicle_moving").hide();
    $("#vehicle_status").hide();
    $("#vehicle_halt").hide();
    $("#vehicle_sleep").hide();
    $("#vehicle_stop").show();
  }
  $('#network_status').text(network_status);
  $('#fuel_status').text(res.fuel_status);
  $('#speed').text(res.speed);
  $('#odometer').text(res.odometer);
  $('#mode').text(vehicle_mode);
  $('#satelite').text(res.satelite);
  $('#battery_status').text(res.battery_status);
  $('#ignition').text(res.ignition);
  var address=res.address;
  $('#address').text(address);      
}
