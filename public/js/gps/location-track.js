
   function getUrl(){
    return $('meta[name = "domain"]').attr('content');
   }

   function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 10.107570, lng: 76.345665},
          zoom: 12
        });
        getMarkers();
      }

  function getMarkers() {

         var url = '/vehicles/location-track';
          var id= document.getElementById('vehicle_id').value;
         // var id=1;
         var data = {
          id : id
         };
        var purl = getUrl() + '/'+url ;
        var triangleCoords = [];
        $.ajax({
            type:'POST',
            url: purl,
            data: data,
            async: true,
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
               // console.log(res.liveData.ign);
              if(res.liveData.vehicleStatus=='M')
              {
                 $("#online").show();               
              }
              else if(res.liveData.vehicleStatus=='H')
              {
                 $("#halt").show();   
              }
               else if(res.liveData.vehicleStatus=='S')
              {
                 $("#sleep").show();   
              }
               else 
              {
                 $("#ofline").show();   
              }
              if(res.liveData.ign==1)
              {
                document.getElementById("ignition").innerHTML = "Ignitio ON";
              }
              else
              {
                 document.getElementById("ignition").innerHTML = "Ignitio OFF";
              }
                document.getElementById("user").innerHTML = res.client_name;
              document.getElementById("vehicle_name").innerHTML = res.vehicle_name;
              document.getElementById("car_speed").innerHTML = res.liveData.speed;
               document.getElementById("car_bettary").innerHTML = res.liveData.power;
             
              console.log(res);  

            },
            error: function (err) {
                var message = (err.responseJSON)?err.responseJSON.message:err.responseText;
                toastr.error(message, 'Error');
            }
        });


 

}

     
