var locationNameData;
var locationName="";
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
   $(".loader-1").show();
  var url = 'notification-alerts-list';
  var data={  
  }
  backgroundPostData(url,data,'notificationAlertsList',{alert:true});
});

function notificationAlertsList(res)
{
    $(".loader-1").hide();
    for (var i = 0; i < res.alerts.length; i++)
    {
      register_number = res.alerts[i].gps.vehicle.register_number;
      vehicle_name    = res.alerts[i].gps.vehicle.name;
      alert           = res.alerts[i].alert_type.description;
      device_time     = res.alerts[i].device_time;
      id              = res.alerts[i].id;
      // read alerts
      if(res.alerts[i].status == 1)
      {
        var notification=' <div class="item active-read psudo-link" id="alert" data-toggle="modal" onclick="gpsAlertCount('+id+')" data-target="#myModal2">'+  
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
      if(res.alerts[i].status == 0)
      {
        var notification=' <div class="item active-read alert psudo-link alert_color_'+res.alerts[i].id+'" id="alert_'+res.alerts[i].id+'" data-toggle="modal" onclick="gpsAlertCount('+id+')" data-target="#myModal2"  >'+  
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
    if(res.alerts.length == 0)
    {
      var notification = ' <div class="item active-read psudo-link"  data-toggle="modal">No alerts found'+
      '</div>';
      $("#notification").append(notification); 
    }
   // responseList(res);
    $("#loader-1").hide();
    $(".loader-1").hide();

}

function gpsAlertCount(value){
  // console.log(res);
  var url = 'gps-alert-tracker';
  var data={
    id:value    
  }
  backgroundPostData(url,data,'gpsAlertTracker',{alert:true});
}
function gpsAlertTracker(res)
{  

  $('#alert_'+res.alertmap.id).removeClass('alert');
  var latitude=parseFloat(res.alertmap.latitude);
  var longitude=parseFloat(res.alertmap.longitude);
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
      // radius: Math.sqrt(citymap[city].population) * 100
      // radius: 0
    });
  }
  var marker = new google.maps.Marker({
    position:  alertMap[alert].center,
    // icon: iconBase,
    map: map
  });
  // console.log(res);
  function locs()
  {
    $('#address').text(res.address);
    $('#vehicle_name').text(res.get_vehicle.name);
    $('#register_number').text(res.get_vehicle.register_number);
    $('#description').text(res.alert_icon.description);
    $('#device_time').text(res.alertmap.device_time);

  }
}