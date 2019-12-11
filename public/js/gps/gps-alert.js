
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
  limit+=limit+3;
  offset+=offset+1;
      // alert(offset);
  if($('#alert').height()+$('#alert').scrollTop() >= 360){
      
      limitFunction(limit,offset);
  }
});

function responseList(res){
  console.log(res.alerts.length);
  for(var i=0,n=Math.min(res.alerts.length); i<n;i++){
    $('.inner').append('<div class="messages alert_color_'+res.alerts[i].id+'" onclick="gpsAlertCount('+res.alerts[i].id+')">'+i+res.alerts[i].alert_type.description+'</br><span class="date">'+res.alerts[i].device_time+'</span></div>');
  }res
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


// if($('#alert').scrollTop() <= 20) 
//   {
    
//    alert(1);

//   }
  
