function getUrl() {
    return $('meta[name = "domain"]').attr('content');
}
var numDeltas = 100;
var delay = 10; //milliseconds
var i = 0;
var posLat = 10.107570;
var posLng = 76.345665;

 var markericon;
var deltaLat, deltaLng;
var marker;
var map;
var vehiclePath = "M29.395,0H17.636c-3.117,0-5.643,3.467-5.643,6.584v34.804c0,3.116,2.526,5.644,5.643,5.644h11.759   c3.116,0,5.644-2.527,5.644-5.644V6.584C35.037,3.467,32.511,0,29.395,0z M34.05,14.188v11.665l-2.729,0.351v-4.806L34.05,14.188z    M32.618,10.773c-1.016,3.9-2.219,8.51-2.219,8.51H16.631l-2.222-8.51C14.41,10.773,23.293,7.755,32.618,10.773z M15.741,21.713   v4.492l-2.73-0.349V14.502L15.741,21.713z M13.011,37.938V27.579l2.73,0.343v8.196L13.011,37.938z M14.568,40.882l2.218-3.336   h13.771l2.219,3.336H14.568z M31.321,35.805v-7.872l2.729-0.355v10.048L31.321,35.805";
var vehicleColor = "#0C2161";
var vehicleScale = "0.5";


 function initMap() {
   map = new google.maps.Map(document.getElementById('map'), {
        center: {
            lat: 10.056075,
            lng: 76.354691
        },
        zoom: 10,
        mapTypeId: 'roadmap'

    }); 
}

// function playback() {
//     var url = '/vehicles/location-playback';
//     var id = document.getElementById('vehicle_id').value;
//     var from_time = document.getElementById('fromDate').value;
//     var to_time = document.getElementById('toDate').value;
//     var data = {
//         id: id,
//         from_time: from_time,
//         to_time: to_time
//     };
//     var purl = getUrl() + '/' + url;
//     var triangleCoords = [];
//     $.ajax({
//         type: 'POST',
//         url: purl,
//         data: data,
//         async: true,
//         headers: {
//         'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
//         },
//         success: function(res) {
           
//             createPolyline(res.polyline); 
//               markerAddInmap(res.marker,res);           
//         },
//         error: function(err) {
//             var message = (err.responseJSON) ? err.responseJSON.message : err.responseText;
//             toastr.error(message, 'Error');
//         }
//     });
// }
// function createPolyline(locationData) { 
//     var lineData =locationData;
//     var linePath = new google.maps.Polyline({
//         path: lineData,
//         geodesic: true,
//         strokeColor: '#0C2161',
//         strokeOpacity: 0.5,
//         strokeWeight: 7
//     });
//     linePath.setMap(map);          
// }


//  function markerAddInmap(markerPointData,locationData){
//       console.log(locationData.polyline[0]);
// //   //     var lineData =locationData;
// //   //   // alert(markerPointData);
// //   if(markerPointData.length>0){
// //    icon = { 
// //      // path:vehicleDetails.SvgICon,
// //     path: locationData,
// //     scale: 0.4,
// //     fillColor: "#ff0023", //<-- Car Color, you can change it 
// //     fillOpacity: 1,
// //     rotation:150.0  //<-- Car angle
// //     }; 
// //      // var markerLatlng = new google.maps.LatLng(parseFloat(locationData.polyline[0]);


        
// //   var locationsMarkerdata=locationData;
 
// //   var latlng = new google.maps.LatLng(parseFloat(locationData.polyline[0]);
// //       car = new google.maps.Marker({
// //         position: latlng,
// //         map: map,
// //         icon:icon
// //      });
// // // {lat: 10.056075, lng: 76.354691}
// // // 1: {lat: 10.055787, lng: 76.354712}
// //   if(locationsMarkerdata){
// //     var infowindow = new google.maps.InfoWindow();
// //     // for (i = 0; i < locationsMarkerdata.length; i++) {  
// //        marker = new google.maps.Marker({
// //       position: new google.maps.LatLng(parseFloat(locationData.polyline[i]),
// //       icon:markericon,
// //       map: map
// //       });

// //        // google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
// //        //  return function() {
// //        //    infowindow.setContent('<div id="content" style="width:150px;">' +
// //        //        'div style="padding-top:5px;"><i class="fa fa-tachometer"></i> '+markerPointData[i].Speed+' KM/H </div>'+ 
// //        //        '</div>');
// //        //    infowindow.open(map, marker);
// //        //  }
// //        // })(marker, i));


// //      // }
// //    }

// //   }
//   }
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
                      
            },
            error: function(err) {
                var message = (err.responseJSON) ? err.responseJSON.message : err.responseText;
                toastr.error(message, 'Error');
            }
        });       
    }); 
}
