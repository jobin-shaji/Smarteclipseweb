
function getUrl(){
  return $('meta[name = "domain"]').attr('content');
}
 var latMap=25.3548;
 var lngMap=51.1839;
 var map;

function initMap(res) {   
          map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center:{lat: latMap, lng: lngMap},
          mapTypeId: 'terrain'
        });
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
                    strokeColor: '#5D5D5D',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    center: res.cordinates[0],
                    fillColor: '#5D5D5D',
                    fillOpacity: 0.35
                  });
                  bermudaTriangle.setMap(map);
            },
            error: function (err) {
                var message = (err.responseJSON)?err.responseJSON.message:err.responseText;
                toastr.error(message, 'Error');
            }
        });


   
    // Define the LatLng coordinates for the polygon's path.
    

        // var triangleCoords = 

        // Construct the polygon.
      
      }
   