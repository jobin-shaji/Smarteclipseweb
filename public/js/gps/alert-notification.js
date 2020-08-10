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
var page=1;
$(document).ready(function () {
  
  var data={ user_id:  alert_user_id,page:page}; 
  lastSevendaysAlert(data);
});

function viewMoreAlerts(total_page){
  if(total_page>page)
  {
    page=page+1;
    var data={ user_id:  alert_user_id,page:page}; 
    lastSevendaysAlert(data);
  }
}
function lastSevendaysAlert(data)
{
  $(".loader-1").show();
    $.ajax({
            type:'post',
            data:data,
            url: url_ms_alerts+"/last-seven-days-alerts",
            dataType: "json",
            success: function (res) 
            {  
              // console.log(page);          
              notificationAlertsList(res.data) 
            }
          });
        }
  
function notificationAlertsList(res)
{
    $(".loader-1").hide();
    for (var i = 0; i < res.alerts.length; i++)
    {
      register_number = res.alerts[i].gps.connected_vehicle_registration_number;
      vehicle_name    = res.alerts[i].gps.connected_vehicle_name;
      alert           = res.alerts[i].alert_type.description;
      device_time     = res.alerts[i].device_time;
      id              = res.alerts[i]._id;
      // read alerts
      if(res.alerts[i].is_read == 1)
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
      if(res.alerts[i].is_read == 0)
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
    if(res.alerts.length != 0)
    {
      // console.log(res.alerts.length);
      var show_more = ' <div class=" " id="page_count"  >' + 
      '<div class="deatils-bx-rt">'+    
      '<div class="run-date" ><button onclick="viewMoreAlerts('+res.total_pages+')">SHOW MORE</button></div>'+
      '</div>'+
      '</div>';
      $("#show_more").html(show_more); 
    }
    // empty alerts message
    else if(res.alerts.length == 0)
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
  console.log(res);
  $('#alert_'+res._id).removeClass('alert');
  var latitude=parseFloat(res.latitude);
  var longitude=parseFloat(res.longitude);
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 17,
      center: {lat: latitude, lng: longitude},
      mapTypeId: 'terrain'
    });
  // $.ajax({
  //   url     :'https://maps.googleapis.com/maps/api/geocode/json?latlng='+latitude+','+longitude+'&sensor=false&key='.config('eclipse.keys.googleMap'),
  //   method  :"get",
  //   async   :true,
  //   context :this,
    // success : function (Result) {
      locs();
  //   }
  // });     
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
    $('#vehicle_name').text(res.gps.connected_vehicle_name);
    $('#register_number').text(res.gps.connected_vehicle_registration_number);
    $('#description').text(res.alert_type.description);
    $('#device_time').text(res.device_time);
    $('#address').text(res.address); 
  }
}


