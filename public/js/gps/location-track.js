
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
         var id=1;
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
              console.log(res);  
            },
            error: function (err) {
                var message = (err.responseJSON)?err.responseJSON.message:err.responseText;
                toastr.error(message, 'Error');
            }
        });


 

}

     
