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
  var url = 'notification-alerts-list';
  var data={  
  }
  backgroundPostData(url,data,'notificationAlertsList',{alert:true});
});
function notificationAlertsList(res){
  var length=res.alerts.length;
     for (var i = 0; i < length; i++) {
     register_number=res.alerts[i].gps.vehicle.register_number;
      vehicle_name=res.alerts[i].gps.vehicle.name;
     alert=res.alerts[i].alert_type.description;
      device_time=res.alerts[i].device_time;
      if(res.alerts[i].status==1){
        var notification=' <div class="item active-read" data-toggle="modal" data-target="#myModal2" onclick="gpsAlertCount('+res.alerts[i].id+')">'+  
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
      if(res.alerts[i].status==0){
        var notification=' <div class="item active-read" data-toggle="modal" data-target="#myModal2" style="background-color:#30c2bb" onclick="gpsAlertCount('+res.alerts[i].id+')">'+  
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
   // responseList(res);
}
function gpsAlertCount(value){
  console.log(value);
  // var url = 'gps-alert-tracker';
  // var data={
  //   id:value
  // }
  // backgroundPostData(url,data,'gpsAlertTracker',{alert:true});
  // $('.messages').removeClass('allert');
  // changeAtiveColor(value);
}