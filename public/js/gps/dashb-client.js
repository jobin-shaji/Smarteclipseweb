

 var latMap=20.593683;
 var lngMap=78.962883;
 var haightAshbury = {lat: latMap, lng: lngMap};
 var markers = [];
 var map;

  // 'key' => env('APP_KEY'),
  
 
		$(document).ready(function () {

			  map = new google.maps.Map(document.getElementById('map'), {
				 zoom: 5,
				 center: haightAshbury,
				  mapTypeId: google.maps.MapTypeId.ROADMAP
				});
		     var url = 'dash-vehicle-track';
		     var data = {};   

		   	 window.setInterval(function(){
		   	     setMapOnAll(map);
		    	 backgroundPostData(url,data,'vehicleTrack',{alert:false}); 

		    	 markers = [];
		    	 
			}, 6000);

        	 var input1 = document.getElementById('search_place'); 
         	 autocomplete1 = new google.maps.places.Autocomplete(input1);
        	 var searchBox1 = new google.maps.places.SearchBox(autocomplete1);
       

	 	});

	function vehicleTrack(res){
		


	          var icon = { // car icon
               path: 'M29.395,0H17.636c-3.117,0-5.643,3.467-5.643,6.584v34.804c0,3.116,2.526,5.644,5.643,5.644h11.759   c3.116,0,5.644-2.527,5.644-5.644V6.584C35.037,3.467,32.511,0,29.395,0z M34.05,14.188v11.665l-2.729,0.351v-4.806L34.05,14.188z    M32.618,10.773c-1.016,3.9-2.219,8.51-2.219,8.51H16.631l-2.222-8.51C14.41,10.773,23.293,7.755,32.618,10.773z M15.741,21.713   v4.492l-2.73-0.349V14.502L15.741,21.713z M13.011,37.938V27.579l2.73,0.343v8.196L13.011,37.938z M14.568,40.882l2.218-3.336   h13.771l2.219,3.336H14.568z M31.321,35.805v-7.872l2.729-0.355v10.048L31.321,35.805',
               scale: 0.4,
               fillColor: "#0C2161", //<-- Car Color, you can change it 
               fillOpacity: 1,
               strokeWeight: 1,
               anchor: new google.maps.Point(0, 5),
               rotation: 180 //<-- Car angle
          		};

             var JSONObject = res.user_data;

             var vehicle = res.vehicle;
             var marker, i;
             for (i=0;i<JSONObject.length;i++){
             var lat=JSONObject[i].lat;
             var lng=JSONObject[i].lon;
	         var reg=JSONObject[i].vehicle.register_number;
	         var vehicle_id=vehicle[i];
	         console.log(vehicle_id);
	         var vehicle_name=JSONObject[i].vehicle.name;
             var loc=new google.maps.LatLng(lat,lng);
             var title ='<div id="content" style="width:150px;">' +
    '<div style="background-color:#FF8C00; color:#fff;font-weight:600"><spna style="padding:30px ;">'+vehicle_name+'</span></div>'+  
    '<div style="padding-top:5px;"><i class="fa fa-car"></i>'+reg+' </div>'+ 
    // '<div style="padding-top:5px;"><i class="fa fa-bell-o"></i> ,</div>'+ 
    // '<div style="padding-top:5px;"><i class="fa fa-map-marker"></i> </div>'+ 
    '<div style="padding-top:5px;"><a href=/vehicles/'+vehicle_id+'/location class="btn btn-xs btn btn-warning"><i class="glyphicon glyphicon-map-marker"></i>Track</a> <a href=/vehicles/'+vehicle_id+'/playback class="btn btn-xs btn btn-warning"><i class="glyphicon glyphicon-map-marker"></i>Playback</a></div>'+ 
    '</div>'; 

             car_color="#0C2161";
             addMarker(loc,title,car_color);
             
           }
        
	     }
	 	 function addMarker(location,title,car_color) {

       		var icon = { // car icon
                   path: 'M29.395,0H17.636c-3.117,0-5.643,3.467-5.643,6.584v34.804c0,3.116,2.526,5.644,5.643,5.644h11.759   c3.116,0,5.644-2.527,5.644-5.644V6.584C35.037,3.467,32.511,0,29.395,0z M34.05,14.188v11.665l-2.729,0.351v-4.806L34.05,14.188z    M32.618,10.773c-1.016,3.9-2.219,8.51-2.219,8.51H16.631l-2.222-8.51C14.41,10.773,23.293,7.755,32.618,10.773z M15.741,21.713   v4.492l-2.73-0.349V14.502L15.741,21.713z M13.011,37.938V27.579l2.73,0.343v8.196L13.011,37.938z M14.568,40.882l2.218-3.336   h13.771l2.219,3.336H14.568z M31.321,35.805v-7.872l2.729-0.355v10.048L31.321,35.805',
                   scale: 0.4,
                   fillColor: car_color, //<-- Car Color, you can change it 
                   fillOpacity: 1,
                   strokeWeight: 1,
                   anchor: new google.maps.Point(0, 5),
                   rotation: 180 //<-- Car angle
               };
   
		       var marker = new google.maps.Marker({
		           position: location,
		           title:"Eclips",
		           icon:icon
		       });
		       var infowindow = new google.maps.InfoWindow();
		       google.maps.event.addListener(marker, 'click', function() {
		       		getVehicle(2);
		           infowindow.setContent(title);
		           infowindow.open(map, this);
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
	 		var radius=$('#search_place').val();
	 		   var geocoder =  new google.maps.Geocoder();
   			   geocoder.geocode( { 'address':place_name}, function(results, status) {
	          if (status == google.maps.GeocoderStatus.OK) {
	          	var lat=results[0].geometry.location.lat();
	          	var lng=results[0].geometry.location.lng();
	          	map.panTo(new google.maps.LatLng(lat,lng));
	          	map.setZoom(16);
	          } else {
	            alert("Something got wrong " + status);
	          }
        	});
	 	    return false;
	 	}

	 	

   


	 	