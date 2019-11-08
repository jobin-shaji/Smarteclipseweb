lat=10.014550;
lng=76.293159;
function initMap() { 
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 15,
    center: {lat: lat, lng: lng},
    mapTypeId: 'terrain'
  });
}

function mapCheck() {
    if(document.getElementById('from_date').value == ''){
          alert('please enter from date');
      }else if(document.getElementById('to_date').value == ''){
          alert('please enter to date');
      }
      else{
          var client=$('meta[name = "client"]').attr('content');
          var from_date = document.getElementById('from_date').value;
          var to_date = document.getElementById('to_date').value;
          var gps_id = document.getElementById('gps_id').value;
          var data = {'client':client,'gps_id':gps_id, 'from_date':from_date , 'to_date':to_date};
      }
    var url = 'vehicle-map/location-track';
    var purl = getUrl() + '/' + url;
    var triangleCoords = [];
    $.ajax({
        type: 'POST',
        url: purl,
        data: data,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
          if(res){
            polyline(res);
          }
        }
    });

}
function polyline(location){
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 14,
    center: {lat: 10.069564, lng: 76.301823},
    mapTypeId: 'terrain'
  });
  var flightPlanCoordinates =location;
  // var flightPlanCoordinates = [
  //   {lat: 10.014550, lng: 76.293159},
  //   {lat: 10.004344, lng: 76.295175},
  //   {lat: 9.999061, lng: 76.296634},
  //   {lat: 9.995173, lng: 76.292130}
  // ];
  if(flightPlanCoordinates){
    var flightPath = new google.maps.Polyline({
        path: flightPlanCoordinates,
        geodesic: true,
        strokeColor: '#FF0000',
        strokeOpacity: 0.5,
        strokeWeight: 7
    });
    flightPath.setMap(map);
    var marker;
    flightPlanCoordinates.forEach(function(element,i) {
      console.log(i);
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(element.lat, element.lng),
        map: map
      });
      var infowindow = new google.maps.InfoWindow({
          content: i.toString(),
      });
      infowindow.open(map, marker);
      // google.maps.event.addListener(marker, 'click', (function(marker) {
      //   return function() {
      //     infowindow.open(map, marker);
      //   }
      // })(marker));
    });



  }
}
