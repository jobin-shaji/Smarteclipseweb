
     var url = '/client-location';
     var data = { 
      
     };
     backgroundPostData(url,data,'loadMap',{alert:false});

      var latMap=25.402282;
      var lngMap=51.189165;
      var map;
      var image ='';
      var path=[];
      var marker=[];
      var markersList=[];
      var lat;
      var lng;
      var place_name="";


      function loadMap(res) {
        latMap = res.latitude;
        lngMap = res.longitude
        var heightAshbury = {lat:latMap, lng:lngMap};
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 16,
          center: heightAshbury,
          mapTypeId: 'roadmap'
        });
        map.setOptions({ minZoom:5, maxZoom: 17 });
        
         var input1 = document.getElementById('search_place'); 
         autocomplete1 = new google.maps.places.Autocomplete(input1);
         var searchBox1 = new google.maps.places.SearchBox(autocomplete1);

        poly = new google.maps.Polyline({
            strokeColor: '#000000',
            strokeOpacity: 1.0,
            strokeWeight: 3
        });
        poly.setMap(map);

        // Add a listener for the click event
        map.addListener('click', addLatLng);

       
       }
       // Handles click events on a map, and adds a new point to the Polyline.
        function addLatLng(event) {

            path = poly.getPath();
            var validate=validatateKM(event.latLng,path);
            if(validate==true){
            path.push(event.latLng);
            
            var latlng=event.latLng;
            // Add a new marker at the new plotted point on the polyline.
            marker = new google.maps.Marker({
                position: event.latLng,
                title: '#' + path.getLength(),
                icon:image,
                map: map
            });
            markersList.push(marker);
            document.getElementById('locationLatLng').value += "" + latlng + ";";
            }

        }


        function checkRouteValue(){
          var markers=$('#locationLatLng').val();
          if(markers==""){
            alert("please Draw your route");
            return false; 
          }else{
            return true; 
          }

        }

        function clearlastdraw(){
          path.pop();
          markersList.pop(markersList[markersList.length -1].setMap(null));
          new_path();
        }

       
        function new_path(){
          document.getElementById('locationLatLng').value="";
          if(path!=null && path!=undefined)
          {
            var pathArray=path.getArray();
            if(pathArray)
            {
              if(path.getLength() > 0){
                for(var i=0; i < path.getLength(); i++){
                    var pathpoints=path.getAt(i);
                    var poinLat=pathpoints.lat();
                    var poinLng=pathpoints.lng();
                   document.getElementById('locationLatLng').value += "(" + poinLat + "," + poinLng + ");";
                }
              }
            }
          }
        }
        function validatateKM(latlng,path){
          if(path!=null && path!=undefined)
          {
            var last=path.getAt(path.getLength()-1);
               if(last!=undefined){
                   var lastLat=last.lat();
                   var lastLng=last.lng();
                   var currentLat=latlng.lat();
                   var currentLng=latlng.lng();
                   var ds=distance(lastLat,lastLng,currentLat,currentLng);
                   if(ds>1){
                    alert("Please select a point within 1 KM");
                    return false
                   }else{
                     return true;
                   }
                }else{
                  return true;
                }
            }else{
              return true;
            }
        }
        function distance(lat1, lon1, lat2, lon2, unit) {
            var radlat1 = Math.PI * lat1/180
            var radlat2 = Math.PI * lat2/180
            var theta = lon1-lon2
            var radtheta = Math.PI * theta/180
            var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
            if (dist > 1) {
              dist = 1;
            }
            dist = Math.acos(dist)
            dist = dist * 180/Math.PI
            dist = dist * 60 * 1.1515
            if (unit=="K") { dist = dist * 1.609344 }
            if (unit=="N") { dist = dist * 0.8684 }
            return dist
        }


        // $(function() {
        //   initMap();
        // });

    // ------------------------------------------

    function locationSearch(){
       place_name=$('#search_place').val();
       var geocoder =  new google.maps.Geocoder();
           geocoder.geocode( { 'address':place_name}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              var lat=results[0].geometry.location.lat();
              var lng=results[0].geometry.location.lng();
              map.panTo(new google.maps.LatLng(lat,lng));
             
            } else {
              alert("Something got wrong " + status);
            }
          });
        return false;
    }
  // ------------------------------------------------------