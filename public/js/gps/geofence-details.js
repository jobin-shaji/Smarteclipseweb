$(document).ready(function () {
  var allPolly = []; 
  var geo_id= document.getElementById('hd_id').value;
  var url = 'geofence/show';
  var data = {
    id : geo_id
  };
  allPolly=getPolygonData(url,data,'Coordinates',{alert:true});  

});
 
//    function initMap() {
//         var map = new google.maps.Map(document.getElementById('map'), {
//           center: {lat: 10.107570, lng: 76.345665},
//           zoom: 12
//         });

      
// function Coordinates(res){
//   console.log(res.cordinates);
//  var flightPlanCoordinates = res.cordinates;
//           var flightPath = new google.maps.Polyline({
//           path: flightPlanCoordinates,
//           geodesic: true,         
//           strokeOpacity: 1.0,
//           strokeWeight: 2,
//           markerOptions: {icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'},
//           circleOptions: {
//             fillColor: '#ffff00',
//             fillOpacity: 1,
//             strokeWeight: 5,
//             clickable: false,
//             editable: true,
//             zIndex: 1
//           }
//         });
//         flightPath.setMap(map);
//       }
//     }
function Coordinates(res){
function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 5,
          center: {lat: 24.886, lng: -70.268},
          mapTypeId: 'terrain'
        });

    // Define the LatLng coordinates for the polygon's path.
        var triangleCoords = [
          {lat: 25.774, lng: -80.190},
          {lat: 18.466, lng: -66.118},
          {lat: 32.321, lng: -64.757},
          {lat: 25.774, lng: -80.190}
        ];

        // Construct the polygon.
        var bermudaTriangle = new google.maps.Polygon({
          paths: triangleCoords,
          strokeColor: '#FF0000',
          strokeOpacity: 0.8,
          strokeWeight: 2,
          fillColor: '#FF0000',
          fillOpacity: 0.35
        });
        bermudaTriangle.setMap(map);
      }
    }

