
function getUrl(){
  return $('meta[name = "domain"]').attr('content');
}        
function initMap(res) {   
    var latitude= parseFloat(document.getElementById('lat').value);
    var longitude= parseFloat(document.getElementById('lng').value); 
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 17,
      center: {lat: latitude, lng: longitude},
      mapTypeId: 'terrain'
    });
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
}
   