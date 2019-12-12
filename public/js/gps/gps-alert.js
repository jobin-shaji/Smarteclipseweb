

$(document).ready(function () { 
     $("#loader-1").show();
});


var locationNameData;
var locationName="";
var latitude= parseFloat(document.getElementById('lat').value);
var longitude= parseFloat(document.getElementById('lng').value); 
function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 17,
    center: {lat: latitude, lng: longitude},
    mapTypeId: 'terrain'
  });
}
var j=0;
var limit=10;
var offset=1;
$(document).ready(function () {
  var url = 'gps-alert-list';
  var data={
    offset:offset,
    limit:limit
  }
  backgroundPostData(url,data,'gpsAlert',{alert:true});
});
function  gpsAlert(res) 
{
  responseList(res);
}
$('#alert').scroll(function() {
  if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
    limit=limit;
    offset=offset+limit;
    limitFunction(limit,offset);  
  }
});
function responseList(res){
  for(var i=0,n=Math.min(res.alerts.length); i<n;i++){
    $('.inner').append('<div class="messages alert_color_'+res.alerts[i].id+'" onclick="gpsAlertCount('+res.alerts[i].id+')">'+res.alerts[i].alert_type.description+'</br><span class="date">'+res.alerts[i].device_time+'</span></div>');
  }
}
function limitFunction(limit,offset)
{
  var url = 'gps-alert-list';
  var data={
    limit:limit,
    offset:offset
  }
  backgroundPostData(url,data,'gpsAlert',{alert:true});
}
function gpsAlertCount(value){
  var url = 'gps-alert-tracker';
  var data={
    id:value
  }
  backgroundPostData(url,data,'gpsAlertTracker',{alert:true});
  $('.messages').removeClass('allert');
  changeAtiveColor(value);
}
function changeAtiveColor(value){
  $('.alert_color_'+value).addClass('allert');
}
function gpsAlertTracker(res)
{
  console.log(res);
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
      center: alertMap[alert].center,
      // radius: Math.sqrt(citymap[city].population) * 100
      radius: 100
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
    var infowindow = new google.maps.InfoWindow();
    google.maps.event.addListener(marker, 'mouseover', function() {
    infowindow.setContent(title);
    infowindow.open(map, this);
    });
    var title ='<div id="content" style="width:150px;">' +
    '<div style="background-color:#FF8C00; color:#fff;font-weight:600"><spna style="padding:30px ;">Alert Map</span></div>'+  
    '<div style="padding-top:5px;"><i class="fa fa-car"></i> '+res.get_vehicle.register_number+'</div>'+ 
    '<div style="padding-top:5px;"><i class="fa fa-bell-o"></i> '+res.alert_icon.description+'</div>'+ 
     '<div style="padding-top:5px;"><i class="fa fa-calendar"></i> '+res.alertmap.device_time+'</div>'+ 
    '</div>'; 
  }
}