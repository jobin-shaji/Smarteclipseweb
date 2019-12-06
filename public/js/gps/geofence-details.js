
function getUrl(){
  return $('meta[name = "domain"]').attr('content');
}
 var latMap=25.3548;
 var lngMap=51.1839;
 var bangalore = { lat: 12.97, lng: 77.59 };
 var map;
 var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
var labelIndex = 0;

function initMap(res) {   
          map = new google.maps.Map(document.getElementById('map'), {
          zoom: 14,
          center:{lat: latMap, lng: lngMap},
          mapTypeId: 'terrain',

        });

          

        map.setOptions({ minZoom:5, maxZoom: 17 });
        var url = 'geofence/show';
        var geo_id= document.getElementById('g_id').value;
        var data = {
          id : geo_id
        };
        var purl = getUrl() + '/'+url ;
        var triangleCoords = [];
        $.ajax({
            type:'POST',
            url: purl,
            data: data,
            async: true,
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
              
              var panLat=res.cordinates[0].lat;
              var panLng=res.cordinates[0].lng;
              var latLng = new google.maps.LatLng(panLat,panLng);
              map.panTo(latLng); 
            
                triangleCoords = res.cordinates;
// console.log(triangleCoords[0]);
                  var bermudaTriangle = new google.maps.Polygon({
                    paths: triangleCoords,
                    strokeColor: '#CD1C40',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    center: res.cordinates[0],
                    fillColor: '#CD1C40',
                    fillOpacity: 0.35
                  });
                  bermudaTriangle.setMap(map);
                
                   // locs(res.geofence);
            },
            error: function (err) {
                var message = (err.responseJSON)?err.responseJSON.message:err.responseText;
                console.log(message);
            }
        });

//         var infowindow = new google.maps.InfoWindow();
//           google.maps.event.addListener(map, 'click', function(event) {
//              infowindow.setContent(title);
//         infowindow.open(map, this);
//     addMarker(event.latLng, map);

//   });
//           addMarker(bangalore, map);


//          function addMarker(location, map) {
//   // Add the marker at the clicked location, and add the next-available label
//   // from the array of alphabetical characters.
//   var marker = new google.maps.Marker({
//     position: location,
   
//     map: map
//   });
// }
 // var marker = new google.maps.Marker({
 //                    // position:  details.cordinates[0].center,
 //                    position:  [9.97414581591621, 76.3701251647949],
 //                    // icon: icon,
 //                    map: map
 //                  });

  //  function locs(details)
  //  {
   
 
  //    var infowindow = new google.maps.InfoWindow();
  //    google.maps.event.addListener(map, 'click', function() {

  //       infowindow.setContent(title);
  //       infowindow.open(map, this);
  //   });
  
  
  //   var title ='<div id="content" style="width:150px;">' +
  //   '<div style="background-color:#FF8C00; color:#fff;font-weight:600"><spna style="padding:30px ;">Alert Map</span></div>'+  
  //   '<div style="padding-top:5px;"><i class="fa fa-car"></i> 1</div>'+ 
  //   '<div style="padding-top:5px;"><i class="fa fa-bell-o"></i> 1</div>'+ 
  //   '<div style="padding-top:5px;"><i class="fa fa-map-marker"></i> 1</div>'+ 
  //   '</div>'; 
  // }
   
    // Define the LatLng coordinates for the polygon's path.
    

        // var triangleCoords = 

        // Construct the polygon.
      
      }
   