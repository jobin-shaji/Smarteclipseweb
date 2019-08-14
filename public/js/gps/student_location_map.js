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
    draggable:true,
    title:"Drag me!"
  });
  marker.addListener('dragend', function(event)  {
    //alert(event.latLng.lat() + ' ' +  event.latLng.lng());
    geocoder.geocode({
      'latLng': event.latLng
    }, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      if (results[0]) {
        $('#student_location').val(results[0].formatted_address);
        $('#latitude').val(event.latLng.lat());
        $('#longitude').val(event.latLng.lng());
      }
    }
    });
  });

  // Create the search box and link it to the UI element.
  var input = document.getElementById('student_location');
  var searchBox = new google.maps.places.SearchBox(input);


  // Bias the SearchBox results towards current map's viewport.
  map.addListener('bounds_changed', function() {
    searchBox.setBounds(map.getBounds());
  });

  // Listen for the event fired when the user selects a prediction and retrieve
  // more details for that place.
  searchBox.addListener('places_changed', function() {
    var places = searchBox.getPlaces();
    if (places.length == 0) {
      return;
    }
    // For each place, get the icon, name and location.
    var bounds = new google.maps.LatLngBounds();
    places.forEach(function(place) {
      if (!place.geometry) {
        alert("Returned place contains no geometry");
        return;
      }
      var icon = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };

      var marker = new google.maps.Marker({
        position: place.geometry.location,
        map: map,
        draggable:true,
        title:"Drag me!"
      });
      var location = place.geometry.location;
      //alert(location.lat() + ' ' +  location.lng());
      $('#latitude').val(location.lat());
      $('#longitude').val(location.lng());

      marker.addListener('dragend', function(event)  {
        //alert(event.latLng.lat() + ' ' +  event.latLng.lng());
        geocoder.geocode({
          'latLng': event.latLng
        }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (results[0]) {
            $('#student_location').val(results[0].formatted_address);
            $('#latitude').val(event.latLng.lat());
            $('#longitude').val(event.latLng.lng());
          }
        }
        });
      });

      if (place.geometry.viewport) {
        // Only geocodes have viewport.
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
      }
    });
    map.fitBounds(bounds);
  });
}


