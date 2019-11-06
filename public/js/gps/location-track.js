function getUrl() {
    return $('meta[name = "domain"]').attr('content');
}
capitalize = function(str1){
  return str1.charAt(0).toUpperCase() + str1.slice(1);
}
var vehiclePath = document.getElementById('svg_con').value;
var start_lat = document.getElementById('lat').value;
var start_lng = document.getElementById('lng').value;
var vehicle_scale = document.getElementById('vehicle_scale').value;
var opacity = document.getElementById('opacity').value;
var strokeWeight = document.getElementById('strokeWeight').value;
var marker, map,locationData,markerData,markerPointData,vehicleDetails,icon;
var numDeltas = 300;
var delay = 5; //milliseconds
var i = 0;

var posLat = parseFloat(start_lat);
var posLng = parseFloat(start_lng);

var markericon;
var deltaLat, deltaLng;
var marker;
var map;
var vehicleColor = "#0C2161";
var vehicleScale = vehicle_scale;
var angle=0;
function initMap(){
  map = new google.maps.Map(document.getElementById('map'), {
        center: {
            lat: parseFloat(start_lat),
            lng: parseFloat(start_lng)
        },
        zoom: 21,
        mapTypeId: 'roadmap'

    });  
     var icon = { // car icon
        path: vehiclePath,
        scale: parseFloat(vehicleScale),
        fillColor: vehicleColor, //<-- Car Color, you can change it 
        // fillOpacity: 1,
        // strokeWeight: 1,
        fillOpacity: parseFloat(opacity),
        strokeWeight: parseFloat(strokeWeight),
        anchor: new google.maps.Point(0, 5),
        rotation: 0 //<-- Car angle
    };
    marker = new google.maps.Marker({
        map: map,
        icon: icon
    });
    getMarkers(map);
}


 setTimeout(getMarkers, 5000);



function getMarkers() {

    var url = 'vehicles/location-track';
    var id = $("#vehicle_id_data").val();
    // var id=1;
    data = {
        id:id
    };
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

            if(res.hasOwnProperty('liveData')){
            // console.log(res.liveData.ign);
                    if (res.liveData.vehicleStatus == 'M') {
                        $("#online").show();
                        $("#halt").hide();
                        $("#offline").hide();
                        $("#sleep").hide();
                        vehicleColor="#84b752";
                    } else if (res.liveData.vehicleStatus == 'H') {
                        $("#halt").show();
                        $("#online").hide();
                        $("#offline").hide();
                        $("#sleep").hide();
                        vehicleColor="#69b4b9";

                    } else if (res.liveData.vehicleStatus == 'S') {
                        $("#sleep").show();
                        $("#halt").hide();
                        $("#online").hide();
                        $("#offline").hide();
                        vehicleColor=" #858585";
                    } else {
                      // if(res.liveData.last_seen >'1 hour ago'){
                        
                      // }
                        if(res.liveData.last_seen){
                            $('#last_seen').text(res.liveData.last_seen);
                        }
                        $("#offline").show();
                        $("#sleep").hide();
                        $("#halt").hide();
                        $("#online").hide();
                        vehicleColor="#c41900";

                    }
                    if (res.liveData.ign == 1) {
                        document.getElementById("ignition").innerHTML = "Ignition ON";
                     }else
                      {
                         document.getElementById("ignition").innerHTML = "Ignition OFF";
                      }
                      
                    // document.getElementById("user").innerHTML = res.client_name;
                    document.getElementById("vehicle_name").innerHTML = res.vehicle_reg;
                    document.getElementById("car_speed").innerHTML = res.liveData.speed;
                    document.getElementById("car_bettary").innerHTML = res.liveData.battery_status;
                    document.getElementById("car_location").innerHTML = res.liveData.place;
                    document.getElementById("user").innerHTML = res.vehicle_name.toUpperCase();

                    
                    transition(res)
                    setTimeout(getMarkers, 5000);
                
            }

        },
        error: function(err) {
            var message = (err.responseJSON) ? err.responseJSON.message : err.responseText;
            toastr.error(message, 'Error');
        }
    });

// --------------------------------------------------------------------


var snapped_points=[];
var queueTimer=null;
var angle=100;

function drawLine(loc1,loc2)
  {
   var x = new google.maps.Polyline({
    path: [loc1,loc2],
    strokeColor: vehicleColor,
    strokeOpacity: 0.4,
    strokeWeight: 10
    });
    x.setMap(map);
   }

function setMarketLocation(loc,angle)
  {

    var angle=parseFloat(angle);
    var icon = { // car icon       
        path:"M29.395,0H17.636c-3.117,0-5.643,3.467-5.643,6.584v34.804c0,3.116,2.526,5.644,5.643,5.644h11.759   c3.116,0,5.644-2.527,5.644-5.644V6.584C35.037,3.467,32.511,0,29.395,0z M34.05,14.188v11.665l-2.729,0.351v-4.806L34.05,14.188z    M32.618,10.773c-1.016,3.9-2.219,8.51-2.219,8.51H16.631l-2.222-8.51C14.41,10.773,23.293,7.755,32.618,10.773z M15.741,21.713   v4.492l-2.73-0.349V14.502L15.741,21.713z M13.011,37.938V27.579l2.73,0.343v8.196L13.011,37.938z M14.568,40.882l2.218-3.336   h13.771l2.219,3.336H14.568z M31.321,35.805v-7.872l2.729-0.355v10.048L31.321,35.805",
        rotation:angle,
        fillOpacity: 1.2,
        scale: 0.9,
        strokeColor: vehicleColor,
        strokeWeight: 1
        };
        var icon;
        marker.setIcon(icon);
        var arranged_location=offsetCenter(loc)
        marker.setPosition(arranged_location); 
        map.setZoom(19);
        map.panTo(arranged_location);      
    }

    function doWork()
    {
      var current=popFromLocationQueue();
 
      if(current!=null)
       {


        if(recentPoppedLocation==null)
        {  
            setMarketLocation(current[0],current[1]);
            drawLine(current[0],current[0]);            
        }
        else{   
            drawLine(recentPoppedLocation[0],current[0]);
            setMarketLocation(current[0],current[1]);
         }
        recentPoppedLocation = current[0];
     }
    else{
     
     }
    setTimeout(doWork,98);
    }
 var timerEvent=null;
 var clickedPointCurrent;
 var clickedPointRecent=null;
 var clickedPointCurrentlatlng;
 var clickedPointRecentlatlng;
//Load google map
  function transition(result)
    {
     angle=result.liveData.angle;
     clickedPointCurrent = result.liveData.latitude + ',' + result.liveData.longitude;
     clickedPointCurrentlatlng=new google.maps.LatLng(result.liveData.latitude, result.liveData.longitude);
    

     if(clickedPointRecent==undefined || clickedPointRecent==null)
     {
        getSnappedPoint([clickedPointCurrent],angle)
     }
     else
     { 
      var distance=checkDistanceBetweenTwoPoints(clickedPointRecentlatlng,clickedPointCurrentlatlng);
      getSnappedPoint([clickedPointRecent,clickedPointCurrent],angle);       
     }
     clickedPointRecent = clickedPointCurrent;
     clickedPointRecentlatlng=clickedPointCurrentlatlng;
    }
// -------------------it will return snappede point between two points------------------
  function getSnappedPoint(unsnappedWaypoints,angle)
   {
      $.ajax({
       url: 'https://roads.googleapis.com/v1/snapToRoads?path=' + unsnappedWaypoints.join('|') + '&key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&interpolate=true', //true', 
      crossDomain: true,
      dataType: 'jsonp'
       }).done(function(response) {
      if (response.error) {
        alert("error" + response.error.message);
        return;
      }
      $.each(response.snappedPoints, function (i, snap_data) {
      var loc=snap_data.location;
      var latlng = new google.maps.LatLng(loc.latitude, loc.longitude);
      addToLocationQueue(latlng,angle);
      });
     });
   }
// ---------------------draw polyline--------------------------
// ---------------------que list--------------------------
   var locationQueue=[];
   var recentPoppedLocation=null;
    function addToLocationQueue(loc,angle)
     {
       var location_angle=[loc,angle];
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
// ---------------------que list--------------------------
// ---------------------center on  a marker--------------------------
function offsetCenter(latlng) 
  {
    var offsetx=1;
    var offsety=0;
    // offsetx is the distance you want that point to move to the right, in pixels
    // offsety is the distance you want that point to move upwards, in pixels
    var scale = Math.pow(2, map.getZoom());
    var worldCoordinateCenter = map.getProjection().fromLatLngToPoint(latlng);
    var pixelOffset = new google.maps.Point((offsetx/scale) || 0,(offsety/scale) ||0);
    var worldCoordinateNewCenter = new google.maps.Point(
        worldCoordinateCenter.x - pixelOffset.x,
        worldCoordinateCenter.y + pixelOffset.y
    );
    var newCenter = map.getProjection().fromPointToLatLng(worldCoordinateNewCenter);
    return newCenter;
   }
// ---------------------center on  a marker--------------------------
// ----------------------distance between two points---------------------
function checkDistanceBetweenTwoPoints(first_point,second_pont)
  {
    var lat1=first_point.lat();
    var lon1=first_point.lng();
    var lat2=second_pont.lat();
    var lon2=second_pont.lng();
    var unit="K";

    if ((lat1 == lat2) && (lon1 == lon2)) 
    {
        return 0;
    }
    else {
        var radlat1 = Math.PI * lat1/180;
        var radlat2 = Math.PI * lat2/180;
        var theta = lon1-lon2;
        var radtheta = Math.PI * theta/180;
        var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
        if (dist > 1) {
            dist = 1;
        }
        dist = Math.acos(dist);
        dist = dist * 180/Math.PI;
        dist = dist * 60 * 1.1515;
        dist = dist * 1.609344;
        return dist;
    }
  }
  // ----------------------distance between two points---------------------
  $('document').ready(function(){setTimeout(doWork,98);});




// -------------------------------------------------------------
var POI_markers = [];
var lat=posLat;
var lng=posLng;
var service = new google.maps.places.PlacesService(map);
var atm_flag=0;
var petrol_flag=0;
var hospital_flag=0;


$('#poi_atm').click(function(){
    deleteMarkersPOI();
    if(atm_flag==0){
       $('.poi_atm').css('background', ' #f2b231 '); 
        $('.poi_hopital').css('background', '#FFFFFF'); 
          $('.poi_petrol').css('background', '#FFFFFF'); 
        var pyrmont = {lat: parseFloat(lat), lng: parseFloat(lng)};
        service.nearbySearch(
          {location: pyrmont, radius: 1400, type:['atm']},
           function(results, status, pagination) {
           if (status !== 'OK') return;
              createMarkers(results);
            });

         atm_flag=1;
         }else{
          $('.poi_atm').css('background', '#FFFFFF'); 
           deleteMarkersPOI();
           atm_flag=0;
         }
 

 });


$('#poi_petrol').click(function(){
        deleteMarkersPOI();
        if(petrol_flag==0){
          $('.poi_petrol').css('background', ' #f2b231 '); 
          $('.poi_hopital').css('background', '#FFFFFF'); 
          $('.poi_atm').css('background', '#FFFFFF'); 
          var pyrmont = {lat: parseFloat(lat), lng: parseFloat(lng)};
          service.nearbySearch(
          {location: pyrmont, radius: 3000, type:['gas_station']},
           function(results, status, pagination) {
           if (status !== 'OK') return;
              createMarkers(results);
            });

          petrol_flag=1;
         }else{
           $('.poi_petrol').css('background', '#FFFFFF'); 
           deleteMarkersPOI();
           petrol_flag=0;
         }
  
    });
 $('#poi_hopital').click(function(){
          $('.poi_hopital').css('background', ' #f2b231 '); 
          $('.poi_petrol').css('background', '#FFFFFF'); 
          $('.poi_atm').css('background', '#FFFFFF'); 
        deleteMarkersPOI();
        if(hospital_flag==0){
          var pyrmont = {lat: parseFloat(lat), lng: parseFloat(lng)};
          service.nearbySearch(
            {location: pyrmont, radius: 1000, type:['hospital']},
             function(results, status, pagination) {
             if (status !== 'OK') return;
                createMarkers(results);
              });
          hospital_flag=1;
         }else{
          $('.poi_hopital').css('background', '#FFFFFF'); 
           deleteMarkersPOI();
           hospital_flag=0;
        }
    });

// ---------------find nearest map points-----------------
 var infowindow = new google.maps.InfoWindow();
 function createMarkers(places) {
        deleteMarkersPOI();
        var bounds = new google.maps.LatLngBounds();
        for (var i = 0, place; place = places[i]; i++) {
          var image = {
            url: place.icon,
            size: new google.maps.Size(30, 30),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(10, 20),
            scaledSize: new google.maps.Size(20, 20)
          };
          var marker = new google.maps.Marker({
            icon: image,

            title: place.name,
            position: place.geometry.location,
            data:place.vicinity
          });
          var place_name=place.name;



          POI_markers.push(marker);
          bounds.extend(place.geometry.location);

         
        }
        map.fitBounds(bounds);
        setMapOnAllPOI(map); 
        
      }
      function setMapOnAllPOI(map) {
        for (var i = 0; i < POI_markers.length; i++) {
          POI_markers[i].setMap(map);
           google.maps.event.addListener(POI_markers[i], 'click', (function(marker, i) {
          return function() {
            infowindow.setContent('<i>'+POI_markers[i].title +'</i><br><span style="margin-top: 25px;">'+POI_markers[i].data+'</span>');
            infowindow.setOptions({maxWidth: 200});
            infowindow.open(map, POI_markers[i]);
          }
          }) (marker, i));
        }
      }
      function clearMarkersPOI() {
        setMapOnAllPOI(null);
      }
      function deleteMarkersPOI() {
        clearMarkersPOI();
         POI_markers = [];
        
      }
     
// ---------------find nearest map points-----------------
// -------------------playback---------------------------


$( "#playback_form" ).submit(function( event ) {
  var vehicle_id=$('#vehicle_id').val();
  var from_date=$('#fromDate').val();
  var to_date=$('#toDate').val();
  var url_data=encodeURI('from_date='+from_date+"&to_date="+to_date+"&vehicle_id="+vehicle_id);
  window.open("/vehicle_playback?"+url_data, "myWindow", "width=700,height=500");
  event.preventDefault();
});

// -------------------playback---------------------------





}