
function getUrl(){
  return $('meta[name = "domain"]').attr('content');
}


function initMap(res) {   
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          center: {lat: 10.125145227224547, lng: 76.30721285156255},
          mapTypeId: 'terrain'
        });
        var url = 'geofence/show';
        var geo_id= document.getElementById('hd_id').value;
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
                triangleCoords = res.cordinates;

                  var bermudaTriangle = new google.maps.Polygon({
                    paths: triangleCoords,
                    strokeColor: '#FF0000',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#FF0000',
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
   