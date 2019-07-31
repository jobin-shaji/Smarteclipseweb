

$(document).ready(function () { 
     var url = 'driver-score';
     var data = {
   
     };
      backgroundPostData(url,data,'driverScore',{alert:false});
});

function driverScore(res){
var ctx = document.getElementById("myChart").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: res.drive_data,
      datasets: [{
        label: '# Score',
        data: res.drive_score,
        backgroundColor:'rgba(255, 99, 132, 0.2)',
        borderColor:'rgba(255,99,132,1)',
        borderWidth: 1
      }]
    },
    options: {
    title: {
      display: true,
      text: 'Driver Score'
    },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    }
  });
}





var latMap=20.593683;
var lngMap=78.962883;
var haightAshbury = {lat: latMap, lng: lngMap};
var markers = [];
var map;
var map_flag;
var track_flag=0;
var map_popup=0;

function initMap(){
map = new google.maps.Map(document.getElementById('map'), {
zoom: 10,
center: haightAshbury,
  mapTypeId: google.maps.MapTypeId.ROADMAP
});
var input1 = document.getElementById('search_place');
    autocomplete1 = new google.maps.places.Autocomplete(input1);
var searchBox1 = new google.maps.places.SearchBox(autocomplete1);
   map_flag=0;
   getVehicleSequence(); 
  // 'key' => env('APP_KEY'),
 
}
// check each 10 sec

    window.setInterval(function(){
     if(track_flag==0){
     getVehicleSequence();
}
       }, 100000);
// check each 10 sec

function getVehicleSequence(){

var url = 'dash-vehicle-track';
     var data = {};  
    backgroundPostData(url,data,'vehicleTrack',{alert:false});
    deleteMarkers();
   
}

function vehicleTrack(res){

             var JSONObject = res.user_data;

             var marker, i;


              for (i=0;i<JSONObject.length;i++){
             var lat=JSONObject[i].lat;
             var lng=JSONObject[i].lon;
             if(map_flag==0){
             map.panTo(new google.maps.LatLng(lat,lng));
             map.setZoom(13);
             map.setOptions({ minZoom:5, maxZoom: 17 });
             // map_flag=1;
              }
             var gpsID=JSONObject[i].id;
         var reg=JSONObject[i].register_number;
         var vehicle_id=JSONObject[i].vehicle_id;
         var vehicle_name=JSONObject[i].vehicle_name;
             var loc=new google.maps.LatLng(lat,lng);
             var mode=JSONObject[i].mode;
             var color="";
             var vehicle_status="";
            if(mode=='M'){car_color="#2DB05D";vehicle_status="Online";}
    else if(mode=='H'){car_color="#5474F5";vehicle_status="Idle"}
    else if(mode=='S'){car_color="#A1A3AB";vehicle_status="Stop"}
    else{car_color="#DB2133";vehicle_status="Offline"}

             var title ='<div id="content" style="width:150px;">' +
             '<span style="margin-right:5px;"><i class="fa fa-circle" style="color:'+car_color+';" aria-hidden="true"></i></span>'+vehicle_status+
    '<div style="color:#000;font-weight:600;margin-top:5px;" ><span style="padding:20px;"><i>'+vehicle_name+'</i></span></div>'+ 
    '<div style="padding-top:5px; padding-left:16px;"><i class="fa fa-car"></i><span style="margin-right:5px;">:</span>'+reg+' </div>'+
    // '<div style="padding-top:5px;"><i class="fa fa-bell-o"></i> ,</div>'+
    // '<div style="padding-top:5px;"><i class="fa fa-map-marker"></i> </div>'+
    '<div style="padding-top:5px;"><a href=/vehicles/'+vehicle_id+'/playback class="btn btn-xs btn btn-warning" title="Playback" style="background-color:#fff;"><i class="fa fa-car" style="color:#000;font-size: 18px;"></i></a><a href=/vehicles/'+vehicle_id+'/location class="btn btn-xs btn btn-warning" title="Location" style="background-color:#fff;"><i class="fa fa-map-marker" style="color:#000;font-size: 18px;"></i></a>  <a href="/alert" class="btn btn-xs btn btn-warning" title="Alerts" style="background-color:#fff;"><i class="fa fa-warning" style="color:#000;font-size: 18px;"></i></a>  </div>'+
    '</div>';
   
   
    var path=JSONObject[i].vehicle_svg;   
         var scale=JSONObject[i].vehicle_scale;
         var fillOpacity=JSONObject[i].opacity;
         var strokeWeight=JSONObject[i].strokeWeight;
             addMarker(loc,title,car_color,path,scale,fillOpacity,strokeWeight,gpsID);
             if(track_flag!=0){
               addVehicleToVehicleList(vehicle_name,reg,gpsID);
         }
           }
            setMapOnAll(map);

     }
function addMarker(location,title,car_color,path,scale,fillOpacity,strokeWeight,gpsID) {
       var icon = { // car icon
                   path: path,
                   scale:scale,
                   fillColor: car_color, //<-- Car Color, you can change it
                   fillOpacity: fillOpacity,
                   strokeWeight: strokeWeight,
                   anchor: new google.maps.Point(0, 5),
                   rotation: 180 //<-- Car angle
               };
  
       var marker = new google.maps.Marker({
           position: location,
           title:"",
           icon:icon
       });
       var infowindow = new google.maps.InfoWindow();
       google.maps.event.addListener(marker, 'mouseover', function() {
       // alert(vehicle_id);
       getVehicle(gpsID);
           infowindow.setContent(title);
           infowindow.open(map, this);
           map_popup=0;
        });

       google.maps.event.addListener(marker, 'click', function() {
       // alert(vehicle_id);
       getVehicle(gpsID);
           infowindow.setContent(title);
           infowindow.open(map, this);
           if(map_popup==1){map_popup=0;}else{ map_popup=1;}

        });

        google.maps.event.addListener(marker, 'mouseout', function() {
         if(map_popup==0){
           infowindow.close(map, this);
          }
        });



        markers.push(marker);

       }

      






     function setMapOnAll(map) {
    
     for (var i = 0; i < markers.length; i++) {
         markers[i].setMap(map);
     }

}




function selectVehicleTrack(res){
map.panTo(new google.maps.LatLng(res.lat,res.lon));
map.setZoom(15);
nearestPointsOnMap(res.lat,res.lon);
}

$( ".vehicle_gps_id" ).click(function() {
var url = '/dashboard-track';
var gps_id=this.value;
var data = {
      gps_id : gps_id
    };

    backgroundPostData(url,data,'selectVehicleTrack',{alert:false});

});

function locationSearch(){
var place_name=$('#search_place').val();
var radius=$('#search_radius').val();
   var geocoder =  new google.maps.Geocoder();
      geocoder.geocode( { 'address':place_name}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
          var lat=results[0].geometry.location.lat();
          var lng=results[0].geometry.location.lng();
          map.panTo(new google.maps.LatLng(lat,lng));
          map.setZoom(12);
          var url = '/location-search';

  var data = {
      lat : lat,
      lng:lng,
      radius:radius
      };

    backgroundPostData(url,data,'searchLocation',{alert:false});
    setMapZoom(radius);
    redarLocation(lat,lng,radius);

          } else {
            alert("Please enter a valid location");
          }
        });
    return false;
}


$(document).ready(function () {
  
var modal = document.getElementById('myModal');
var btn = document.getElementById("diver_behavior");
var span = document.getElementsByClassName("close")[0];
btn.onclick = function() {
  modal.style.display = "block";
}
span.onclick = function() {
  modal.style.display = "none";
}
window.onclick = function(event) {

  if (event.target == modal) {
    modal.style.display = "none";
  }
}
});

function moving(vehicle_mode)
{
track_flag=1;
$('#vehicle_card_cover').empty();
var url = '/dashboard-track-vehicle-mode';
var data = {
      vehicle_mode : vehicle_mode
    };
    backgroundPostData(url,data,'selectVehicleModeTrack',{alert:false});
   
}

function selectVehicleModeTrack(res){
  // console.log(res);
  deleteMarkers();
  flag=0;
  vehicleTrack(res);

}

function deleteMarkers() {
        clearMarkers();
        markers = [];
      }
    function clearMarkers() {
          setMapOnAll(null);
        }

        function addVehicleToVehicleList(vehicle_name,reg,gpsID){

    
             var vehicleData='<div class="border-card">'+
                 '<div class="card-type-icon with-border">'+
                 '<input type="radio" id="radio" id="gpsid" class="vehicle_gps_id" name="radio" onclick="getVehicle('+gpsID+')" value="'+gpsID+'">'+
                  '</div>'+
                  '<div class="content-wrapper">'+
                      '<div class="label-group fixed">'+
                      '<p class="title">'+
                        '<span><i class="fa fa-car"></i></span>'+
                      '</p>'+
                      '<p class="caption" id="vehicle_name">'+vehicle_name+'</p>'+
                      '</div>'+
                      '<div class="min-gap"></div>'+
                  '<div class="label-group">'+
                      '<p class="title">'+
                        '<span><i class="fas fa-arrow-alt-circle-left"></i></span>'+
                      '</p>'+

                      '<p class="caption" id="register_number">'+reg+'</p>'+
                  '</div>'+
                  '<div class="min-gap"></div>'+
                  '<div class="label-group">'+
                       '<p class="title">'+
                        '<span><i class="fas fa-tachometer-alt"></i></span>'+
                       '</p>'+
                      '<p class="caption">80</p>'+
                  '</div>'+

                  '</div>'+               
                  '</div>';
        
         $("#vehicle_card_cover").append(vehicleData);
       
       
        }


function searchLocation(res){

 
  if(res.status=="success"){
  deleteMarkers();
flag=0;
vehicleTrack(res);
}else{
alert('No vehicle found in this location');
}

}


function redarLocation(lat,lng,radius){
   var radius_in_meter=radius*1000;
   var latlng = new google.maps.LatLng(lat,lng);
   var sunCircle = {
        strokeColor: "#b84930",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#b84930",
        fillOpacity: 0.35,
        map: map,
        center: latlng,
        radius:radius_in_meter // in meters
    };
  cityCircle = new google.maps.Circle(sunCircle)
  var opts = {
   lat : lat,
   lng : lng
  };
  myGoogleRadar = new GoogleRadar(map, opts);

  // init a RadarPolygon
 opts = {
   angle : 10,
   time : 60,
   radius:radius
};
  myGoogleRadar.addRadarPolygon(opts);
}

function setMapZoom(radius){
  var zoom_size=10;
  if(radius==10){
    zoom_size=14;
  }else if(radius==30){
    zoom_size=12;
  }else if(radius==50){
    zoom_size=10;
  }else if(radius==75){
    zoom_size=10;
  }else if(radius==100){
    zoom_size=8;
  }
  map.setZoom(zoom_size);
}
// ---------------find nearest map points-----------------
var POI_markers = [];
function nearestPointsOnMap(lat,lng){
        deleteMarkersPOI();
        var pyrmont = {lat: parseFloat(lat), lng: parseFloat(lng)};
        var service = new google.maps.places.PlacesService(map);
     
        // Perform a nearby search.
       
         service.nearbySearch(
          {location: pyrmont, radius: 5000, type:['atm']},
           function(results, status, pagination) {
           if (status !== 'OK') return;
              createMarkers(results);
            });
         service.nearbySearch(
          {location: pyrmont, radius: 5000, type:['hospital']},
           function(results, status, pagination) {
           if (status !== 'OK') return;
              createMarkers(results);
            });

          service.nearbySearch(
          {location: pyrmont, radius: 500, type:['gas_station']},
           function(results, status, pagination) {
           if (status !== 'OK') return;
              createMarkers(results);
            });
          setMapOnAllPOI();

}
 function createMarkers(places) {
       
        var bounds = new google.maps.LatLngBounds();
        for (var i = 0, place; place = places[i]; i++) {
          var image = {
            url: place.icon,
            size: new google.maps.Size(60, 60),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(10, 20),
            scaledSize: new google.maps.Size(15, 15)
          };
          var marker = new google.maps.Marker({
            icon: image,
            title: place.name,
            position: place.geometry.location
          });


          POI_markers.push(marker);
          bounds.extend(place.geometry.location);
        }
        map.fitBounds(bounds);
        
      }
      function setMapOnAllPOI() {
        for (var i = 0; i < POI_markers.length; i++) {
          POI_markers[i].setMap(map);
        }
      }
      function clearMarkersPOI() {
        POI_markers.();
      }
      function deleteMarkersPOI() {

        clearMarkersPOI();
         POI_markers = [];
        
      }
     
// ---------------find nearest map points-----------------

$(document).ready(function(){
   $('st-actionContainer').launchBtn( { openDuration: 500, closeDuration: 300 } );
  });


