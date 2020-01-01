function initMap() {
  var geocoder = new google.maps.Geocoder();
  var map, infoWindow;
  var latMap = parseFloat(document.getElementById('latitude').value);
  var lngMap = parseFloat(document.getElementById('longitude').value);
  var myLatlng = new google.maps.LatLng(latMap,lngMap);
  var map = new google.maps.Map(document.getElementById('map'), {
    center: myLatlng,
    zoom: 14,
    mapTypeId: 'roadmap'
  });
  var marker = new google.maps.Marker({
    position: myLatlng,
    map: map,
    draggable:false
  });
}


