

 var allPolly = [];
   function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 10.107570, lng: 76.345665},
          zoom: 12
        });

 var flightPlanCoordinates = [
          {lat: 10.146437001122608, lng: 76.30206301025396},
          {lat: 10.153533944581872, lng: 76.37896730712896},
          {lat: 10.115005790442368, lng: 76.38205721191412},
          {lat: 10.106556015244578, lng: 76.30274965576177}
        ];    
          var flightPath = new google.maps.Polyline({
          path: flightPlanCoordinates,
          geodesic: true,         
          strokeOpacity: 1.0,
          strokeWeight: 2,
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
        flightPath.setMap(map);
    }

