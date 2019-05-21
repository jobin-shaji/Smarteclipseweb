function getUrl() {
    return $('meta[name = "domain"]').attr('content');
}
var numDeltas = 100;
var delay = 10; //milliseconds
var i = 0;
var posLat = 10.107570;
var posLng = 76.345665;
var deltaLat, deltaLng;
var marker;
var marker, map,locationData,markerData,markerPointData,vehicleDetails,icon;
    lat=floatval(DEFAULT_LAT);
    lng=floatval(DEFAULT_LNG);
var myLatlng = new google.maps.LatLng(lat,lng);
var map;
var vehiclePath = "M29.395,0H17.636c-3.117,0-5.643,3.467-5.643,6.584v34.804c0,3.116,2.526,5.644,5.643,5.644h11.759   c3.116,0,5.644-2.527,5.644-5.644V6.584C35.037,3.467,32.511,0,29.395,0z M34.05,14.188v11.665l-2.729,0.351v-4.806L34.05,14.188z    M32.618,10.773c-1.016,3.9-2.219,8.51-2.219,8.51H16.631l-2.222-8.51C14.41,10.773,23.293,7.755,32.618,10.773z M15.741,21.713   v4.492l-2.73-0.349V14.502L15.741,21.713z M13.011,37.938V27.579l2.73,0.343v8.196L13.011,37.938z M14.568,40.882l2.218-3.336   h13.771l2.219,3.336H14.568z M31.321,35.805v-7.872l2.729-0.355v10.048L31.321,35.805";
var vehicleColor = "#0C2161";
var vehicleScale = "0.5";

function initMap() {


    map = new google.maps.Map(document.getElementById('map'), {
        center: {
            lat: 10.107570,
            lng: 76.345665
        },
        zoom: 19,
        mapTypeId: 'roadmap'

    });

    var icon = { // car icon
        path: vehiclePath,
        scale: parseFloat(vehicleScale),
        fillColor: vehicleColor, //<-- Car Color, you can change it 
        fillOpacity: 1,
        strokeWeight: 1,
        anchor: new google.maps.Point(0, 5),
        rotation: 0 //<-- Car angle
    };
    marker = new google.maps.Marker({
        map: map,
        icon: icon
    });
    getMarkers(map);
}

function getMarkers() {

    var url = '/vehicles/location-track';
    var id = document.getElementById('vehicle_id').value;
    // var id=1;
    var data = {
        id: id
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
            // console.log(res.liveData.ign);
            if (res.liveData.vehicleStatus == 'M') {
                $("#online").show();
                $("#halt").hide();
                $("#ofline").hide();
                $("#sleep").hide();



                vehicleColor="#203a17";
            } else if (res.liveData.vehicleStatus == 'H') {
                $("#halt").show();
                $("#online").hide();
                $("#ofline").hide();
                $("#sleep").hide();

                vehicleColor="#c1c431";

            } else if (res.liveData.vehicleStatus == 'S') {
                $("#sleep").show();
                $("#halt").hide();
                $("#online").hide();
                $("#ofline").hide();
                vehicleColor="#ffa500";
            } else {
                $("#ofline").show();
                $("#sleep").hide();
                $("#halt").hide();
                $("#online").hide();
                vehicleColor="#711307";

            }
            if (res.liveData.ign == 1) {
                document.getElementById("ignition").innerHTML = "Ignitio ON";
             }else
              {
                 document.getElementById("ignition").innerHTML = "Ignitio OFF";
              }
            // document.getElementById("user").innerHTML = res.client_name;
            document.getElementById("vehicle_name").innerHTML = res.vehicle_reg;
            document.getElementById("car_speed").innerHTML = res.liveData.speed;
            document.getElementById("car_bettary").innerHTML = res.liveData.power;
            document.getElementById("car_location").innerHTML = res.liveData.place;
            document.getElementById("user").innerHTML = res.vehicle_name;

            

            track(map, res);
            setTimeout(locate, 5000);


        },
        error: function(err) {
            var message = (err.responseJSON) ? err.responseJSON.message : err.responseText;
            toastr.error(message, 'Error');
        }
    });


    function track(map, res) {

        var lat = parseFloat(res.liveData.latitude);
        var lng = parseFloat(res.liveData.longitude);
        var angle=parseFloat(res.liveData.angle);
        var markerLatLng = new google.maps.LatLng(res.liveData.latitude, res.liveData.longitude);
        i = 0;
        deltaLat = (lat - posLat) / numDeltas;
        deltaLng = (lng - posLng) / numDeltas;
       
        map.panTo(markerLatLng);
        moveMarker();
        var icon = { // car icon
                    path:vehiclePath,
                    scale: parseFloat(vehicleScale),
                    fillColor: vehicleColor, //<-- Car Color, you can change it 
                    fillOpacity: 1,
                    strokeWeight: 1,
                    anchor: new google.maps.Point(0, 5),
                    rotation:angle  //<-- Car angle
                };
              marker.setIcon(icon);



    }

    function moveMarker() {

        posLat += deltaLat;
        posLng += deltaLng;
        var latlng = new google.maps.LatLng(posLat, posLng);
        marker.setPosition(latlng);
        if (i != numDeltas) {
            i++;
            setTimeout(moveMarker, delay);
        }
    }

    function locate() {
        getMarkers();
    }

}