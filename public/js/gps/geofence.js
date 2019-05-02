 // // Initialize the platform object:
 //    var platform = new H.service.Platform({
 //    'app_id': '{QViYMVb62ejfVgcqHW2l}',
 //    'app_code': '{Em2ekKlXM2Mt38Cz9VCLUHA}'
 //    });

 //    // Obtain the default map types from the platform object
 //    var maptypes = platform.createDefaultLayers();

 //    // Instantiate (and display) a map object:
 //    var map = new H.Map(
 //    document.getElementById('mapContainer'),
 //    maptypes.normal.map,
 //    {
 //      zoom: 10,
 //      center: { lng: 13.4, lat: 52.51 }
 //    });

 var allPolly = [];

   function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 8
        });

        var drawingManager = new google.maps.drawing.DrawingManager({
          drawingMode: google.maps.drawing.OverlayType.MARKER,
          drawingControl: true,
          drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: [ 'polygon']
          },
          markerOptions: {icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'},
          circleOptions: {
            fillColor: '#ffff00',
            fillOpacity: 1,
            strokeWeight: 5,
            clickable: false,
            editable: true,
            zIndex: 1
          }
        });
        drawingManager.setMap(map);

      var polygons = [];

      google.maps.event.addDomListener(drawingManager, 'polygoncomplete', function(polygon) {
       // polygon.addListener('click', showArrays);
       showArrays(polygon);
        polygons.push(polygon);
      });

        google.maps.event.addDomListener(savebutton, 'click', function() {
            for (var i = 0; i < polygons.length; i++) {
            console.log(polygons[i]);                            
         }
       });
   
    }


function showArrays(polygon) {

  var vertices = polygon.getPath();
  var contentString = "";
  poly = [];

  for (var i =0; i < vertices.getLength(); i++) {
    var xy = vertices.getAt(i);
    contentString += '<br>' + 'Coordinate ' + i + ':<br>' + xy.lat() + ',' +
        xy.lng();
    cord = JSON.stringify({lat : xy.lat(),lng : xy.lng()});
    poly.push(cord);
  }

  allPolly.push(poly);

  alert(allPolly);
}

     
