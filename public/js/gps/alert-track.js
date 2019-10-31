
var locationNameData;
var locationName="";
var latitude= parseFloat(document.getElementById('lat').value);
var longitude= parseFloat(document.getElementById('lng').value); 
var alert_icon= document.getElementById('icon').value; 
var vehicle= document.getElementById('vehicle').value; 
var description= document.getElementById('alert').value; 
function getUrl(){
  return $('meta[name = "domain"]').attr('content');
}        
function initMap(res) {   
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 17,
    center: {lat: latitude, lng: longitude},
    mapTypeId: 'terrain'
  });
  // getLocationFromLatLng(latitude,longitude);

  $.ajax({
    url     :'https://maps.googleapis.com/maps/api/geocode/json?latlng='+latitude+','+longitude+'&sensor=false&key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap',
    method  :"get",
    async   :true,
    context :this,
    success : function (Result) {
      var address = Result.results[0];                    
      locationName=address.formatted_address;
      locs(locationName);
      // alert(locationName);
    }
  });     

// console.log(locationName);
  var url = 'alerts';
  var iconBase = {
    url: '/alerts/'+alert_icon, // url
    scaledSize: new google.maps.Size(50, 50), // scaled size
  }; 
  var alertMap = {
    alerttype: {
        center: {lat: latitude, lng: longitude},               
    }
  };
  for (var alert in alertMap) {
    // Add the circle for this city to the map.
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
    icon: iconBase,
    map: map
  });
 
   function locs(locationName)
   {
    // alert(1);
     var infowindow = new google.maps.InfoWindow();
     // google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(title);
        infowindow.open(map, this);
    // });
  


  







  
    var title ='<div id="content" style="width:150px;">' +
    '<div style="background-color:#FF8C00; color:#fff;font-weight:600"><spna style="padding:30px ;">Alert Map</span></div>'+  
    '<div style="padding-top:5px;"><i class="fa fa-car"></i> '+vehicle+'</div>'+ 
    '<div style="padding-top:5px;"><i class="fa fa-bell-o"></i> '+description+'</div>'+ 
    '<div style="padding-top:5px;"><i class="fa fa-map-marker"></i> '+locationName+'</div>'+ 
    '</div>'; 
  }
  // addMarker(title);
}
