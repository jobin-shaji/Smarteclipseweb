

function getUrl() {
    return $('meta[name = "domain"]').attr('content');
}

var hidpi               = ('devicePixelRatio' in window && devicePixelRatio > 1);
var secure              = (location.protocol === 'https:') ? true : false; // check if the site was loaded via secure connection
var app_id              = "vvfyuslVdzP04AK3BlBq",
    app_code            = "f63d__fBLLCuREIGNr6BjQ";
var mapContainer        = document.getElementById('markers');
var platform            = new H.service.Platform({ app_code: app_code, app_id: app_id, useHTTPS: secure });
var maptypes            = platform.createDefaultLayers(hidpi ? 512 : 256, hidpi ? 320 : null);
var map                 = new H.Map(mapContainer, maptypes.normal.map);
map.setCenter({ lat: 10.192656, lng: 76.386666 });
map.setZoom(14);
var zoomToResult = true;
var mapTileService = platform.getMapTileService({
    type: 'base'
});
var parameters = {};
var uTurn = false;
new H.mapevents.Behavior(new H.mapevents.MapEvents(map));
var angle;
var clickedPointRecent
var clickedPointCurrent;
var clickedPointCurrentlatlng;
var locationQueue=[];
var recentPoppedLocation;
var recent_angle_latlng=null;
var current_angle_latlng;
var service,ac,battery_status,connection_lost_time_motion,dateTime,fuel,fuelquantity,ign,last_seen,signalStrength,speed;
var vehicleStatus,connection_lost_time_halt,connection_lost_time_sleep,connection_lost_time_minutes,latitude,longitude,place,power;


 var data_fetch_from_server   = window.setInterval(function(){
      getMarkers();
      console.log('fetch data from server');
     }, 500);
  var data_fetch_from_server   = window.setInterval(function(){
      doWork();
     }, 1000);


function getMarkers() {
  var url            =   'vehicles/location-track';
  var id             =   $("#vehicle_id_data").val();
  data               = {
                        id:id
                      };
  var purl           = getUrl() + '/' + url;
  var triangleCoords = [];
  $.ajax({
     type  :   'POST',
      url  :    purl,
      data :    data,
    async  :    true,
    headers: {
      'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(res) {
      if(res.hasOwnProperty('liveData')){
        document.getElementById("user").innerHTML          = res.vehicle_name;
        document.getElementById("vehicle_name").innerHTML  = res.vehicle_reg;
        transition(res);
        setTimeout(getMarkers, 5000);
      }
    },
    error: function(err) {
      var message = (err.responseJSON) ? err.responseJSON.message : err.responseText;
    }
  });
}

// ---------------------que list--------------------------
function transition(result)
{
  angle                        = result.liveData.angle;
  ac                           = result.liveData.ac;
  battery_status               = result.liveData.battery_status;
  connection_lost_time_motion  = result.liveData.connection_lost_time_motion;
  dateTime                     = result.liveData.dateTime;
  fuel                         = result.liveData.fuel;
  fuelquantity                 = result.liveData.fuelquantity;
  ign                          = result.liveData.ign;
  last_seen                    = result.liveData.last_seen;
  latitude                     = result.liveData.latitude;
  longitude                    = result.liveData.longitude;
  place                        = result.liveData.place;
  power                        = result.liveData.power;
  signalStrength               = result.liveData.signalStrength;
  speed                        = result.liveData.speed;
  vehicleStatus                = result.liveData.vehicleStatus;
  connection_lost_time_halt    = result.liveData.connection_lost_time_halt;
  connection_lost_time_sleep   = result.liveData.connection_lost_time_sleep;
  connection_lost_time_minutes = result.liveData.connection_lost_time_minutes;

  clickedPointCurrent          = result.liveData.latitude + ',' + result.liveData.longitude;   

  if(clickedPointRecent  ==  undefined || clickedPointRecent  ==  null)
   {
    getSnappedPoint([clickedPointCurrent],angle,ac,battery_status,connection_lost_time_motion,dateTime,fuel,fuelquantity,ign,last_seen,latitude,longitude,place,power,signalStrength,speed,vehicleStatus,connection_lost_time_halt,connection_lost_time_sleep,connection_lost_time_minutes)
   }
  else
   { 
    getSnappedPoint([clickedPointRecent,clickedPointCurrent],angle,ac,battery_status,connection_lost_time_motion,dateTime,fuel,fuelquantity,ign,last_seen,latitude,longitude,place,power,signalStrength,speed,vehicleStatus,connection_lost_time_halt,connection_lost_time_sleep,connection_lost_time_minutes);       
   }
  clickedPointRecent = clickedPointCurrent;
}

/*-----------------------------------------------*/
function getSnappedPoint(unsnappedWaypoints,angle,ac,battery_status,connection_lost_time_motion,dateTime,fuel,fuelquantity,ign,last_seen,latitude,longitude,place,power,signalStrength,speed,vehicleStatus,connection_lost_time_halt,connection_lost_time_sleep,connection_lost_time_minutes)
{
  $.ajax({
    url           : 'https://roads.googleapis.com/v1/snapToRoads?path=' + unsnappedWaypoints.join('|') + '&key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&interpolate=true', //true', 
    crossDomain   : true,
    dataType      : 'jsonp'
  }).done(function(response) {
    if (response.error) {
      return;
    }
    $.each(response.snappedPoints, function (i, snap_data) {
      var loc     = snap_data.location;
      var latlng  = new google.maps.LatLng(loc.latitude, loc.longitude);
      addToLocationQueue(latlng,angle,ac,battery_status,connection_lost_time_motion,dateTime,fuel,fuelquantity,ign,last_seen,latitude,longitude,place,power,signalStrength,speed,vehicleStatus,connection_lost_time_halt,connection_lost_time_sleep,connection_lost_time_minutes);
    });
  });
}


// ---------------------que list--------------------------
function addToLocationQueue(loc,angle,ac,battery_status,connection_lost_time_motion,dateTime,fuel,fuelquantity,ign,last_seen,latitude,longitude,place,power,signalStrength,speed,vehicleStatus,connection_lost_time_halt,connection_lost_time_sleep,connection_lost_time_minutes)
{
  var location_angle=[
  loc,angle,ac,battery_status,connection_lost_time_motion,dateTime,fuel,fuelquantity,ign,last_seen,latitude,longitude,place,power,signalStrength,speed,vehicleStatus,connection_lost_time_halt,connection_lost_time_sleep,connection_lost_time_minutes];
  locationQueue.push(location_angle);
}
function popFromLocationQueue()
{
  if(locationQueue.length>0)
  {
    return locationQueue.splice(0,1)[0];    
  }
  else
  return null;
}
// --------------------------------------------------------
function doWork()
{
  var current=locationQueue[0];
  popFromLocationQueue();
  plotLocationOnMap();
}
function plotLocationOnMap()
{
  console.log(locationQueue[0].lat);
            console.log('Current length '+locationQueue.length);
            if(locationQueue.length >0)
            {
               
                moveMap(locationQueue[0].lat,locationQueue[0].lng);
                // create start marker
                if(first_point==true){
                    
                     var madridMarker = new H.map.Marker({lat:locationQueue[0].lat, lng:locationQueue[0].lng},{ icon: start_icon});
                     map.addObject(madridMarker);
                }
                first_point=false;
                // create start marker



                if( (startPointLatitude != null) && (startPointLongitude!=null) )
                {
                    endPointLatitude    = location_data_que[0].lat;
                    endPointLongitude   = location_data_que[0].lng;
                    vehicle_mode        = location_data_que[0].mode;
                    // calculate the direction of movement   
                    var direction = calculateCarDirection(startPointLatitude,startPointLongitude,endPointLatitude,endPointLongitude);

                    moveMarker(direction,endPointLatitude,endPointLongitude,vehicle_mode);
                    addPolylineToMap(startPointLatitude,startPointLongitude,endPointLatitude,endPointLongitude);
                }
                startPointLatitude  = location_data_que[0].lat;
                startPointLongitude = location_data_que[0].lng;
                // remove the already plotted locations
                popFromLocationQueue();
                // want to load new set of data ?
                if( (location_data_que.length <= 29) && (!isDataLoadInProgress) && (!dataLoadingCompleted) )
                {
                    console.log('Loading fresh set of data');
                    getLocationData();
                }

                // stop point
                if(last_offset==true && location_data_que.length==0){
                     
                     var flag = new H.map.Marker({lat:startPointLatitude, lng:startPointLongitude},{ icon: stop_icon});
                     map.addObject(flag);
                }
                // stop point
                
             }
        }











