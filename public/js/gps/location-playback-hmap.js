function getUrl() {
    return $('meta[name = "domain"]').attr('content');
}

// -----Draw a map-----------------------------

  var platform = new H.service.Platform({
    'app_id': 'QViYMVb62ejfVgcqHW2l',
    'app_code':'m2ekKlXM2Mt38Cz9VCLUHA'
  });


  var maptypes = platform.createDefaultLayers();
  var map = new H.Map(
  document.getElementById('mapContainer'),
  maptypes.normal.map,
  {
    zoom: 10,
    center: { lng:88.296539 , lat: 22.538009 }
  });
  var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));
  var ui = H.ui.UI.createDefault(map, maptypes);

// -----Draw a map-----------------------------

// ------------------featch data from date time----------

    function playback() {
    $(function() {
        // var baseurl = '/vehicles/location-playback';
        var url = '/vehicles/location-playback';
        var id = document.getElementById('vehicle_id').value;
        var from_time = document.getElementById('fromDate').value;
        var to_time = document.getElementById('toDate').value;
        var data = {
            id: id,
            from_time: from_time,
            to_time: to_time
        };
        // console.log(to_time);
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
               console.log(res.polyline);
            },
            error: function(err) {
                var message = (err.responseJSON) ? err.responseJSON.message : err.responseText;
                toastr.error(message, 'Error');
            }
        });       
    }); 
}


// ------------------featch data from date time----------







