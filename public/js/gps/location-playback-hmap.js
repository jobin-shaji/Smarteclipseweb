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
   var currentRouteStrip = new H.geo.Strip();
  var marker;
  var bSimulationRunning = false;

  var svgMarkup = '<svg width="24" height="24" ' + 
  'xmlns="http://www.w3.org/2000/svg">' +
  '<rect stroke="white" fill="#1b468d" x="1" y="1" width="22" ' +
  'height="22" /><text x="12" y="18" font-size="12pt" ' +
  'font-family="Arial" font-weight="bold" text-anchor="middle" ' +
  'fill="white">H</text></svg>';



// Create an icon, an object holding the latitude and longitude, and a marker:
  var icon = new H.map.Icon(svgMarkup),
  coords = {lat: 51.5141, lng: -0.0999},
  marker = new H.map.Marker(coords, {icon: icon});
  marker.$id = "truckMarker";
  var iSimulationIsAtPosition = 0;
  var simulationWalker = null;
  var simulationGroup = new H.map.Group();
  var routeGroup = new H.map.Group();
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
              if(res.polyline=='empty')
              {
                alert("No data available");
              }
              else
              {
                // console.log(res);
                playBack(res);
                playbackChart(res);
              }
               
            },
            error: function(err) {
                var message = (err.responseJSON) ? err.responseJSON.message : err.responseText;
                toastr.error(message, 'Error');
            }
        });       
    }); 
}
// M29.395,0H17.636c-3.117,0-5.643,3.467-5.643,6.584v34.804c0,3.116,2.526,5.644,5.643,5.644h11.759   c3.116,0,5.644-2.527,5.644-5.644V6.584C35.037,3.467,32.511,0,29.395,0z M34.05,14.188v11.665l-2.729,0.351v-4.806L34.05,14.188z    M32.618,10.773c-1.016,3.9-2.219,8.51-2.219,8.51H16.631l-2.222-8.51C14.41,10.773,23.293,7.755,32.618,10.773z M15.741,21.713   v4.492l-2.73-0.349V14.502L15.741,21.713z M13.011,37.938V27.579l2.73,0.343v8.196L13.011,37.938z M14.568,40.882l2.218-3.336   h13.771l2.219,3.336H14.568z M31.321,35.805v-7.872l2.729-0.355v10.048L31.321,35.805
// ------------------fetch data from date time----------

function playBack(res){

  var locationData=res.polyline; 
  // truck icon
  var iSimulationIsAtPosition = 0;
  // simulation walker
  var simulationWalker = null;
  var simulationGroup = new H.map.Group();
  var routeGroup = new H.map.Group();
  $(function(){ 
      var routingParameters={};
      var pointname;

         // var data=[{"lat":22.548545935598,"lng":88.280163708638},{"lat":22.5464236,"lng":88.2853837},{"lat":22.5428214,"lng":88.286547},{"lat":22.5410671,"lng":88.2887521},{"lat":22.539522,"lng":88.2903415},{"lat":22.51498,"lng":88.3104746},{"lat":22.5116714,"lng":88.3257219},{"lat":22.5035291,"lng":88.3407005},{"lat":22.5013464,"lng":88.346573},{"lat":22.5010609,"lng":88.3687496},{"lat":22.549975499646,"lng":88.278846582115},{"lat":22.5512341,"lng":88.2790673}];
         var data=locationData;
        
            $.each(data, function(i, item) {
                pointname='waypoint'+i;
                routingParameters[pointname]=''+item.lat+','+item.lng+'';
              });

               routingParameters = routingParameters;
               routingParameters.mode='fastest;car';
               routingParameters.representation= 'display';
                   routeDraw(routingParameters);

      }); // end of doc ready
}
// -------------------------------------------------------


function routeDraw(routingParameters){


// Define a callback function to process the routing response:
var onResult = function(result) { 
  console.log(result)

  if(result.hasOwnProperty('response')){

  result.response.route;
  // console.log(result);
 var route,
    routeShape,
    startPoint,
    endPoint,
    linestring;
    // console.log(result.response.route);
  if(result.response.route) {
  // Pick the first route from the response:
  route = result.response.route[0];
  // Pick the route's shape:
  routeShape = route.shape;

  // Create a linestring to use as a point source for the route line
  linestring = new H.geo.LineString();


  // Push all the points in the shape into the linestring:s

  routeShape.forEach(function(point) {
    var parts = point.split(',');
    linestring.pushLatLngAlt(parts[0], parts[1]);
    currentRouteStrip.pushLatLngAlt.apply(currentRouteStrip, point.split(',').map(function(item) { return parseFloat(item); }));

  });

  // Retrieve the mapped positions of the requested waypoints:
  startPoint = route.waypoint[0].mappedPosition;
  endPoint = route.waypoint[1].mappedPosition;

  // Create a polyline to display the route:
  var routeLine = new H.map.Polyline(linestring, {
    style: { strokeColor: 'blue', lineWidth: 10 },
    arrows: { fillColor: 'white', frequency: 2, width: 0.8, length: 0.7 }

  });

  // Create a marker for the start point:
  var startMarker = new H.map.Marker({
    lat: startPoint.latitude,
    lng: startPoint.longitude
  });

  // Create a marker for the end point:
  var endMarker = new H.map.Marker({
    lat: endPoint.latitude,
    lng: endPoint.longitude
  });

  // Add the route polyline and the two markers to the map:
  map.addObjects([routeLine, startMarker, endMarker]);

  // Set the map's viewport to make the whole route visible:
  map.setViewBounds(routeLine.getBounds());
    simulationWalker = new Walker(marker, currentRouteStrip);
    simulationWalker.walk();
  }

}else{
  alert("Something went wrong");
}

};





var router = platform.getRoutingService();
router.calculateRoute(routingParameters, onResult,
  function(error) {
    alert(error.message);
  });

 
}

var Walker = function (marker, path)
  {
    this.path = path;
    this.marker = marker;
    this.dir = -1;
    this.isWalking = false;
    this.options = {
      search_radius: 1,
      keyattribute: 'ID'
    };
    var that = this;
    this.walk = function ()
    {
      // Get the next coordinate from the route and set the marker to this coordinate
      var coord = path.extractPoint(iSimulationIsAtPosition);
      map.addObject(marker);
      marker.setPosition(coord);

      // If we get to the end of the route reverse direction
      if (!iSimulationIsAtPosition || iSimulationIsAtPosition === path.getPointCount() - 1) {
        iSimulationIsAtPosition = 0;
      }

      iSimulationIsAtPosition += 1;

      /* Recursively call this function with time that depends on the distance to the next point
      * which makes the marker move in similar random fashion
      */
      that.timeout = setTimeout(that.walk, 300);
      that.isWalking = true;

      //gfe.checkProximity(document.getElementById('layerId').value, coord, that.options, onSimulationActivePositionChanged);

    };

    this.stop = function ()
    {
      clearTimeout(that.timeout);
      this.isWalking = false;
    };
  };


  // Helper for route simulation stop
  function stopRouteSimulation()
  {
    // stop simulation
    bSimulationRunning = false;
   // document.getElementById("simulateRouteButton").value = "Simulate Asset";
    if(simulationWalker)
    {
      simulationWalker.stop();
    }
  }

// for listner
    var group = new H.map.Group();
    map.addObject(group);
    group.addEventListener('tap', function (evt) {
    var bubble =  new H.ui.InfoBubble(evt.target.getPosition(), { 
      content: evt.target.getData()
    });
     ui.addBubble(bubble);
    }, false);
// for listner

  

function addMarkerToGroup(group, coordinate, html) {
  var userImg = new H.map.Icon('helo.png');
  // console.log(userImg);
  var marker = new H.map.Marker(coordinate,{icon:userImg});
  marker.setData(html);
  group.addObject(marker);
}
// ------------------------------------------------------------------


  function playbackChart(res){
  //    var charts=res.polyline;
  //    console.log(charts);
  //    var chart_length= charts.length;
  //    // console.log(charts[0].speed);
  //    var dps = []; 
  //    var chart = new CanvasJS.Chart("chartContainer", {
  //         title :{
  //           text: ""
  //         },
  //         axisY: {
  //          title: "speed",
  //           includeZero: false
  //         }, 

  //         axisX:{
  //           title: "timeline",
  //           // gridThickness: 2,
  //            valueFormatString: "YY:MM:DD H:i:s"
  //         },     
  //         data: [{
  //           type: "line",
  //         dataPoints: dps
  //         }]
  //       });

  //      // number of dataPoints visible at any point
  //       var xVal = 0;
  //       var yVal = 100; 
  //       var updateInterval = 1000;
  //       var dataLength = 20;
  // var updateChart = function (count) {
  
  //   var i=1;
  //   $.each(charts, function(key,value) {
  //      yVal = yVal +  Math.round(5 + Math.random() *(-5-5));
  //       speed=value.speed;
  //       datetime=value.datetime;
  //       dps.push({
  //       x: new Date(datetime),
  //       y: speed
  //      // x: xVal ,
  //      // y: yVal
  //     });
  //      xVal++;
      
  //    });
  //   // count = count || 1;
  //   // for (var j = 0; j < count; j++) {  
  //   //  // var yVal= charts[j].datetime
  //   //   yVal = yVal +  Math.round(5 + Math.random() *(-5-5));
  //   // // datetime=charts[j].datetime;
  //   // // speed=charts[j].speed;
  //   //   dps.push({
  //   //     x: xVal ,
  //   //     y: yVal
  //   //   });
  //   //    xVal++;
  //   // }
  //   if (dps.length > dataLength) {
  //     dps.shift();
  //   }
  // chart.render();
  // };
  // updateChart(dataLength);
  // setInterval(function(){updateChart()}, updateInterval);

  //   $(".playback_chart").show(100).animate("slow");
  //   // chartpolyline(chart);
  }









