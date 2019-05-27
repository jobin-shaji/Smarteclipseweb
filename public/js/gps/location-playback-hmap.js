function getUrl() {
    return $('meta[name = "domain"]').attr('content');
}



var image ='http://grse.vehiclest.com/img/marker.png';
var start ='http://grse.vehiclest.com/img/start_marker.png';
var stop ='http://grse.vehiclest.com/img/stop_marker.png';
var user ='http://grse.vehiclest.com/img/map_users.png';
var route,
    routeShape,
    linestring;
 


// var numDeltas = 100;
// var delay = 10; //milliseconds
// var i = 0;
// var posLat = 10.107570;
// var posLng = 76.345665;

//  var markericon;
// var deltaLat, deltaLng;
// var marker;
// var map;
// var vehiclePath = "M29.395,0H17.636c-3.117,0-5.643,3.467-5.643,6.584v34.804c0,3.116,2.526,5.644,5.643,5.644h11.759   c3.116,0,5.644-2.527,5.644-5.644V6.584C35.037,3.467,32.511,0,29.395,0z M34.05,14.188v11.665l-2.729,0.351v-4.806L34.05,14.188z    M32.618,10.773c-1.016,3.9-2.219,8.51-2.219,8.51H16.631l-2.222-8.51C14.41,10.773,23.293,7.755,32.618,10.773z M15.741,21.713   v4.492l-2.73-0.349V14.502L15.741,21.713z M13.011,37.938V27.579l2.73,0.343v8.196L13.011,37.938z M14.568,40.882l2.218-3.336   h13.771l2.219,3.336H14.568z M31.321,35.805v-7.872l2.729-0.355v10.048L31.321,35.805";
// var vehicleColor = "#0C2161";
// var vehicleScale = "0.5";


//  function initMap() {
//    map = new google.maps.Map(document.getElementById('map'), {
//         center: {
//             lat: 10.056075,
//             lng: 76.354691
//         },
//         zoom: 10,
//         mapTypeId: 'roadmap'

//     }); 
// }

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
                createPolyline(res.polyline); 
                createPlayback(res.firstpoint,res.polyline,res.polyline.length);
                   // console.log(res.polyline[0]);   
            },
            error: function(err) {
                var message = (err.responseJSON) ? err.responseJSON.message : err.responseText;
                toastr.error(message, 'Error');
            }
        });       
    }); 
}


function createPolyline(locationData) { 
  $(function(){ 
    var routingParameters={};
    var playbackData={};
    var pointname;
    // console.log(locationData);
    // // var length=locationData.length;
    // // var count= length/150;
    // // var round_length=Math.round(count);
    // // for(var i=1;i<round_length;i++)
    // // {
    // //      playbackData=locationData[i];
    // // }
    //  // console.log(playbackData);
    //      // var data=[{"lat":22.548545935598,"lng":88.280163708638},{"lat":22.5464236,"lng":88.2853837},{"lat":22.5428214,"lng":88.286547},{"lat":22.5410671,"lng":88.2887521},{"lat":22.539522,"lng":88.2903415},{"lat":22.51498,"lng":88.3104746},{"lat":22.5116714,"lng":88.3257219},{"lat":22.5035291,"lng":88.3407005},{"lat":22.5013464,"lng":88.346573},{"lat":22.5010609,"lng":88.3687496},{"lat":22.549975499646,"lng":88.278846582115},{"lat":22.5512341,"lng":88.2790673}];
    //       // console.log(data);
           var data=locationData;
            // console.log(data);
            $.each(data, function(i, item) {
                pointname='waypoint'+i;
                routingParameters[pointname]=''+item.lat+','+item.lng+'';
                  var stopImg = new H.map.Icon(stop);
                var endMarker = new H.map.Marker({lat: item.lat,lng:item.lng},{ icon: stopImg });
                map.addObjects([endMarker]);
              });
               routingParameters = routingParameters;
               routingParameters.mode='fastest;car';
               routingParameters.representation= 'display';

              routeDraw(routingParameters);            
      }); 
      }// end of doc ready
  var platform = new H.service.Platform({
    'app_id': 'QViYMVb62ejfVgcqHW2l',
    'app_code':'m2ekKlXM2Mt38Cz9VCLUHA'
  });


  var maptypes = platform.createDefaultLayers();
  var map = new H.Map(
  document.getElementById('mapContainer'),
  maptypes.normal.map,
  {
    zoom: 19,
    center: { lng:73.815842 , lat:  18.524092 }
  });
  var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));
  var ui = H.ui.UI.createDefault(map, maptypes);


function routeDraw(routingParameters){
// Define a callback function to process the routing response:
var onResult = function(result) {

var route,
    routeShape,
    linestring;

  if(result.response.route) {
  // Pick the first route from the response:
  route = result.response.route[0];
  routeShape = route.shape;
  linestring = new H.geo.LineString();
  routeShape.forEach(function(point) {


    var parts = point.split(',');
    linestring.pushLatLngAlt(parts[0], parts[1]);
  });
  var point_length=route.waypoint.length;
  startPoint = route.waypoint[0].mappedPosition;
  endPoint = route.waypoint[point_length-1].mappedPosition;


  var routeLine = new H.map.Polyline(linestring, {
    style: { strokeColor: 'rgba(12, 33,97, 0.6',
            lineWidth: 7
             }
  });
// var start="start";
// var stop="stop";

var startImg = new H.map.Icon(start);

var startMarker = new H.map.Marker({lat: startPoint.latitude,lng: startPoint.longitude },
{ icon: startImg }
);
var stopImg = new H.map.Icon(stop);
var endMarker = new H.map.Marker({lat: endPoint.latitude,lng: endPoint.longitude},{ icon: stopImg });
map.addObjects([routeLine, startMarker, endMarker]);
map.setViewBounds(routeLine.getBounds());
 
  // map.addObjects([routeLine]);
  // map.setViewBounds(routeLine.getBounds());
  }


};

var router = platform.getRoutingService();
router.calculateRoute(routingParameters, onResult,
  function(error) {
    alert(error.message);
  });

 
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
  var userImg = new H.map.Icon(user);
  var marker = new H.map.Marker(coordinate,{icon:userImg});
  marker.setData(html);
  group.addObject(marker);
}

function createPlayback(firstpoint,polyData,length) {
  // console.log(polyData[0]);
  (function () {
'use strict';
   var sample = firstpoint;
    // var sample = [
    //     {"lat":22.548545935598,"lng":88.280163708638},  
    //     {"lat":22.549975499646,"lng":88.278846582115},
    //     {"lat":22.5512341,"lng":88.2790673}
    // ];

let data = [];
    sample.map((item, i) => {
       console.log(item.lat);
        data.push([i, item.lat, item.lng]);
    });
    // create the provider
    let provider = new H.datalens.Provider();
    provider.setData({
        columns: ['id', 'lat', 'lng'],
        rows: data
    });
    // create the layer
    let layer = new H.datalens.ObjectLayer(provider, {
    rowToMapObject: (row) => {   
        return H.datalens.ObjectLayer.createReusableMarker(
            row.id,
            new H.geo.Point(row.lat, row.lng)
        );
    },    
    transitionOptions: (row) => {
        return {
            duration: (Math.floor(Math.random() * 4) + 2) * 900,
            easing: 'ease',
            interp: 'slerp'
        };
    }
});
// console.log(layer);
map.addLayer(layer);
// update marker positions periodically
function updateMarkerPositions() {
    let copy = sample.slice();
    let data = [];
    // console.log(copy);
    shuffle(copy);
    copy.map((item, i) => {
        data.push([i, item.lat, item.lng]);
    });
    provider.setData({
        columns: ['id', 'lat', 'lng'],
        rows: data
    });
}
function shuffle(a) {
    for (let i = a.length; i; i--) {
        let j = Math.floor(Math.random() * i);
       
        [a[i - 1], a[j]] = [a[j], a[i - 1]];
    }
}
setTimeout(updateMarkerPositions, 0);
setInterval(updateMarkerPositions, 700);

}());

  }