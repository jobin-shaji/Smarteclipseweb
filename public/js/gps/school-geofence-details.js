
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
          zoom: 13,
          center:{lat: latMap, lng: lngMap},
          mapTypeId: 'terrain',

        });

          

        map.setOptions({ minZoom:5, maxZoom: 17 });
        var url = 'school-geofence/show';
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
                  
                   document.getElementById("geofence_name").innerHTML = res.geofence.name;
                   document.getElementById("user").innerHTML = res.geofence.user.username;
                  document.getElementById("created_date").innerHTML = res.geofence.date;
                   // locs(res.geofence);
            },
            error: function (err) {
                var message = (err.responseJSON)?err.responseJSON.message:err.responseText;
                toastr.error(message, 'Error');
            }
        });

      }
   