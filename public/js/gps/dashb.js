$(document).ready(function () {
     var url = 'dash-count';
     var data = { 
     
     };

    window.setInterval(function(){
    	 backgroundPostData(url,data,'dbcount',{alert:false});  
	}, 5000);
});

function dbcount(res){
	    $('#gps').text(res.gps);
      $('#dealer').text(res.dealers);
      $('#sub_dealer').text(res.subdealers);
      $('#client').text(res.clients);
      $('#vehicle').text(res.vehicles);
      $('#dealer_subdealer').text(res.subdealers);
      $('#gps_dealer').text(res.gps);
      $('#subdealer_gps').text(res.gps);
      $('#subdealer_client').text(res.clients);
      $('#client_gps').text(res.gps);
      $('#client_vehicle').text(res.vehicles);
       $('#geofence').text(res.geofence);
       $('#vehicle_motion').text(res.moving);
      
}