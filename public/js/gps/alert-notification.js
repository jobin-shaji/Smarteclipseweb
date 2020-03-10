var latitude= parseFloat(document.getElementById('lat').value);
var longitude= parseFloat(document.getElementById('lng').value); 
function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 17,
    fullscreenControl: false,
    center: {lat: latitude, lng: longitude},
    mapTypeId: 'terrain'
  });
}
$(document).ready(function () {
 
  var data={ client_id:  alert_client_id}; 
  $(".loader-1").show();
    $.ajax({
            type:'post',
            data:data,
            url: url_ms_alerts+"/last-seven-days-alerts",
            dataType: "json",
            success: function (res) 
            {            
              notificationAlertsList(res.data) 
            }
          });
});
function notificationAlertsList(res)
{
    $(".loader-1").hide();
    for (var i = 0; i < res.length; i++)
    {
      register_number = res[i].gps.connected_vehicle_registration_number;
      vehicle_name    = res[i].gps.connected_vehicle_name;
      alert           = res[i].alert_type.description;
      device_time     = res[i].device_time;
      id              = res[i]._id;
      // read alerts
      if(res[i].is_read == 1)
      {
        var notification=' <div class="item active-read psudo-link" id="alert" data-toggle="modal" onclick="gpsAlertCount(\''+id+'\')" data-target="#clickedModelInDetailPage">'+  
        '<div class="not-icon-bg">'+
        '<img src="images/bell.svg"/>'+
        '</div>'+
        '<div class="deatils-bx-rt">'+
        '<div class="vech-no-out">'+
        '<div class="vech-no">'+
        vehicle_name+'<span>('+register_number+')</span>'+
        '</div>'+
        '<div class="ash-time">'+alert+'</div>'+
        '</div>'+
        '<div class="run-date">'+device_time+'</div>'+
        '</div>'+
        '</div>  ';    
      }
      // unread alerts
      if(res[i].is_read == 0)
      {
        var notification=' <div class="item active-read alert psudo-link alert_color_'+id+'" id="alert_'+id+'" data-toggle="modal" onclick="gpsAlertCount(\''+id+'\')" data-target="#clickedModelInDetailPage"  >'+  
        '<div class="not-icon-bg" >'+
        '<img src="/images/bell.svg"/>'+
        '</div>'+
        '<div class="deatils-bx-rt">'+
        '<div class="vech-no">'+
        '<div class="vech">'+
        vehicle_name+'<span>('+register_number+')</span>'+
        '</div>'+
        '<div class="ash-time">'+alert+'</div>'+
        '</div>'+
        '<div class="run-date">'+device_time+'</div>'+
        '</div>'+
        '</div>';    
      }   
      $("#notification").append(notification);       
    }
    // empty alerts message
    if(res.length == 0)
    {
      var notification = ' <div class="item active-read psudo-link"  data-toggle="modal">No alerts found'+
      '</div>';
      $("#notification").append(notification); 
    }
    $("#loader-1").hide();
    $(".loader-1").hide();
}
function gpsAlertCount(value){
  var data={ id:  value};   
  $.ajax({
    type:'POST',
    data:data, 
    url: url_ms_alerts+'/alert-mark-as-read',
    dataType: "json",
    success: function (res) 
    {  
      gpsAlertTracker(res.data.alert) 
    }
  });
}
function gpsAlertTracker(res)
{  
  $('#alert_'+res._id).removeClass('alert');
  var latitude=parseFloat(res.latitude);
  var longitude=parseFloat(res.longitude);
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 17,
      center: {lat: latitude, lng: longitude},
      mapTypeId: 'terrain'
    });
  $.ajax({
    url     :'https://maps.googleapis.com/maps/api/geocode/json?latlng='+latitude+','+longitude+'&sensor=false&key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap',
    method  :"get",
    async   :true,
    context :this,
    success : function (Result) {
      locs();
    }
  });     
  var alertMap = {
    alerttype: {
      center: {lat: latitude, lng: longitude},               
    }
  };
  for (var alert in alertMap) {
    var cityCircle = new google.maps.Circle({
      strokeColor: '#FF0000',
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: '#FF0000',
      fillOpacity: 0.35,
      map: map,
      center: alertMap[alert].center
      });
  }
  var marker = new google.maps.Marker({
    position:  alertMap[alert].center,
    map: map
  });
  function locs()
  {
    getAddress(res.latitude,res.longitude);
    $('#vehicle_name').text(res.gps.connected_vehicle_name);
    $('#register_number').text(res.gps.connected_vehicle_registration_number);
    $('#description').text(res.alert_type.description);
    $('#device_time').text(res.device_time);
  }
}
function getAddress(lat, lng) {
  var address=""
  var latlng = new google.maps.LatLng(lat, lng);
  var geocoder = geocoder = new google.maps.Geocoder();
  geocoder.geocode({ 'latLng': latlng }, function (results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
          if (results[1]) {
            address= results[0].formatted_address;    
            $('#address').text(address);         
          }        
      }    
  }); 
}

