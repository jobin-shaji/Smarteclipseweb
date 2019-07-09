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
 var map;
 var place_name="";

   function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 25.3548, lng: 51.1839},
          zoom: 12
        });

           var input1 = document.getElementById('search_place'); 
           autocomplete1 = new google.maps.places.Autocomplete(input1);
           var searchBox1 = new google.maps.places.SearchBox(autocomplete1);


        var drawingManager = new google.maps.drawing.DrawingManager({
          drawingMode: google.maps.drawing.OverlayType.POLYGON,
          // drawingMode: google.maps.drawing.OverlayType,

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

        google.maps.event.addDomListener(drawingManager, 'polygoncomplete', function(polygon) {
          addArrays(polygon);
          drawingManager.setDrawingMode(null);
          drawingManager.setOptions({
            drawingControl: false
          });
        });

        google.maps.event.addDomListener(savebutton, 'click', function() {
          var name= document.getElementById('name').value;
          if(name !== "")
          {
            var url = 'save/fence';
            var data = {
             polygons : allPolly,
             name : name
            };
            backgroundPostData(url,data,'none',{alert:true});  

            // console.log(allPolly);
          }
          else
          {
            alert("Plese Enter Name");
          }
        
           
         
         
        });
   
    }









function addArrays(polygon) {
  var vertices = polygon.getPath();
  var contentString = "";
  poly = [];
  for (var i =0; i < vertices.getLength(); i++) {
    var xy = vertices.getAt(i);
    // contentString += '<br>' + 'Coordinate ' + i + ':<br>' + xy.lat() + ',' +
        // xy.lng();
    cord = [ xy.lat(),xy.lng()];
    poly.push(cord);
  }
  allPolly.push(poly);
}


function locationSearch(){

       place_name=$('#search_place').val();
       var geocoder =  new google.maps.Geocoder();
           geocoder.geocode( { 'address':place_name}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              var lat=results[0].geometry.location.lat();
              var lng=results[0].geometry.location.lng();
              map.panTo(new google.maps.LatLng(lat,lng));
             
            } else {
              alert("Something got wrong " + status);
            }
          });
        return false;
    }





     
