
 

   function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 10.107570, lng: 76.345665},
          zoom: 12
        });
        getMarkers();
      }

  function getMarkers() {
   
        var id="<?php echo $encryptedShowID; ?>";
        var JsonObject={id:id};
        var old_lat=0;
        var old_lan=0;
          $.ajax({
            url     :"<?php echo base_url(); ?>api/WebData/getCurrentLocationRefresh",
            method  :"POST",
            contentType: 'application/json',
            context :this,
            data    :JSON.stringify(JsonObject),
            success : function (Result) {
              if(Result.status=="success")
              {
                var vehicleData=Result.vehicleData;
                var lat=vehicleData.latitude;
                var lng=vehicleData.longitude;
                var angle=vehicleData.angle;
                var numberAngle=parseFloat(angle);
                var ignition=vehicleData.ignition;
                var speed=vehicleData.speed;
                var Battery_percentage=vehicleData.Battery_percentage;
                var mainpowerstatus=vehicleData.mainpowerstatus;
                var location=vehicleData.location;
                var status=vehicleData.status;
                var colorStatus=vehicleData.colorStatus;
                var newLatLang = new google.maps.LatLng(lat,lng);
              
              // marker.setPosition(newLatLang);
                // for smooth move
                   i = 0; 
                   deltaLat = (lat - posLat)/numDeltas;
                   deltaLng = (lng - posLng)/numDeltas;
                   moveMarker();
                 // for smooth move

               map.panTo(newLatLang);

               var icon = { // car icon
                    path:vehiclePath,
                    scale: parseFloat(vehicleScale),
                    fillColor: colorStatus, //<-- Car Color, you can change it 
                    fillOpacity: 1,
                    strokeWeight: 1,
                    anchor: new google.maps.Point(0, 5),
                    rotation:numberAngle  //<-- Car angle
                };
                 

              marker.setIcon(icon);

              $("#car_speed").html(speed);
              $("#car_bettary").html(Battery_percentage);
              $("#car_location").html(location);

              if(ignition==1){
                $("#ignition").html('Ignition On');
              }else{
                $("#ignition").html('Ignition Off');
              }

              if(mainpowerstatus==1){
                $("#car_charging").html('<i class="fa fa-check"></i>');
              }else{
                $("#car_charging").html('<i class="fa fa-times"></i>');
              }

              if(status=="M"){
                $("#online_status").html('<i class="fa fa-circle" style="color:green;" aria-hidden="true"></i> Online');
              }else if(status=="H"){
                $("#online_status").html('<i class="fa fa-circle" style="color:yellow;" aria-hidden="true"></i> Halt');
              }else if(status=="S"){
                $("#online_status").html('<i class="fa fa-circle" style="color:orange;" aria-hidden="true"></i> Sleep');
              }else {
                $("#online_status").html('<i class="fa fa-circle" style="color:red;" aria-hidden="true"></i> Offline');
              }
              setTimeout(locate, 5000);
            }

          }
          });
        }


 


     
